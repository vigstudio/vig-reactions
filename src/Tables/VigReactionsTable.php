<?php

namespace Botble\VigReactions\Tables;

use Auth;
use BaseHelper;
use Botble\VigReactions\Repositories\Interfaces\VigReactionsInterface;
use Botble\Table\Abstracts\TableAbstract;
use Illuminate\Contracts\Routing\UrlGenerator;
use Yajra\DataTables\DataTables;
use Html;
use Illuminate\Http\JsonResponse;

class VigReactionsTable extends TableAbstract
{

    /**
     * @var bool
     */
    protected $hasActions = true;

    /**
     * @var bool
     */
    protected $hasFilter = true;

    /**
     * VigReactionsTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param VigReactionsInterface $vigReactionsRepository
     */
    public function __construct(DataTables $table, UrlGenerator $urlGenerator, VigReactionsInterface $vigReactionsRepository)
    {
        $this->repository = $vigReactionsRepository;
        $this->setOption('id', 'table-plugins-vig-reactions');
        parent::__construct($table, $urlGenerator);

        if (!Auth::user()->hasAnyPermission(['vig-reactions.edit', 'vig-reactions.destroy'])) {
            $this->hasOperations = false;
            $this->hasActions = false;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function ajax(): JsonResponse
    {
        $data = $this->table
            ->of($this->query())
            ->editColumn('type', function ($item) {
                return $item->type_image;
            })
            ->editColumn('checkbox', function ($item) {
                return $this->getCheckbox($item->id);
            })
            ->editColumn('created_at', function ($item) {
                return BaseHelper::formatDate($item->created_at);
            })
            ->editColumn('reactable_id', function ($item) {
                return Html::link($item->reactable->slugable->key, BaseHelper::clean($item->reactable->name), ['target' => '_blank']);
            })
            ->addColumn('operations', function ($item) {
                return view('plugins/vig-reactions::actions', compact('item'))->render();

            });

        return $this->toJson($data);
    }

    /**
     * {@inheritDoc}
     */
    public function query()
    {
        $model = $this->repository->getModel();
        $query = $model
            ->with(['reactable'])
            ->select([
                'vig_reactions.id',
                'vig_reactions.type',
                'vig_reactions.reactable_id',
                'vig_reactions.reactable_type',
                'vig_reactions.created_at',
            ]);

        return $this->applyScopes($query);
    }

    /**
     * {@inheritDoc}
     */
    public function columns()
    {
        return [
            'id'         => [
                'name'  => 'vig_reactions.id',
                'title' => trans('core/base::tables.id'),
                'width' => '20px',
            ],
            'type'       => [
                'name'  => 'vig_reactions.type',
                'title' => 'Type',
                'class' => 'text-left',
            ],
            'reactable_id'       => [
                'title' => 'name',
                'class' => 'text-left',
            ],
            'created_at' => [
                'name'  => 'vig_reactions.created_at',
                'title' => trans('core/base::tables.created_at'),
                'width' => '100px',
            ],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function buttons()
    {
        // return $this->addCreateButton(route('vig-reactions.create'), 'vig-reactions.create');
    }

    /**
     * {@inheritDoc}
     */
    public function bulkActions(): array
    {
        return $this->addDeleteAction(
            route('vig-reactions.deletes'),
            'vig-reactions.destroy',
            parent::bulkActions()
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getBulkChanges(): array
    {
        return [
            'vig_reactions.type'       => [
                'title'    => 'Type',
                'type'     => 'customSelect',
                'validate' => 'required|max:120',
                'choices'    => [
                    'like'  => ' Like',
                    'love'  =>  'Love',
                    'haha'  =>  'Haha',
                    'wow'   =>  'WoW',
                    'sad'   =>  'Sad',
                    'angry' =>  'Angry',
                ],
            ],
            'vig_reactions.created_at' => [
                'title' => trans('core/base::tables.created_at'),
                'type'  => 'date',
            ],
        ];
    }
}
