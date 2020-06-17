<?php

namespace Botble\VigReactions\Tables;

use Auth;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\VigReactions\Repositories\Interfaces\VigReactionsInterface;
use Botble\Table\Abstracts\TableAbstract;
use Illuminate\Contracts\Routing\UrlGenerator;
use Yajra\DataTables\DataTables;
use Botble\VigReactions\Models\VigReactions;
use Html;

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
    public function ajax()
    {
        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('name', function ($item) {
                if (!Auth::user()->hasPermission('vig-reactions.edit')) {
                    return $item->name;
                }
                return Html::link(route('vig-reactions.edit', $item->id), $item->name);
            })
            ->editColumn('checkbox', function ($item) {
                return table_checkbox($item->id);
            })
            ->editColumn('created_at', function ($item) {
                return date_from_database($item->created_at, config('core.base.general.date_format.date'));
            })
            ->editColumn('status', function ($item) {
                return $item->status->toHtml();
            });

        return apply_filters(BASE_FILTER_GET_LIST_DATA, $data, $this->repository->getModel())
            ->addColumn('operations', function ($item) {
                return table_actions('vig-reactions.edit', 'vig-reactions.destroy', $item);
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * {@inheritDoc}
     */
    public function query()
    {
        $model = $this->repository->getModel();
        $query = $model->select([
            'vig_reactions.id',
            'vig_reactions.type',
            'vig_reactions.created_at',
        ]);

        return $this->applyScopes(apply_filters(BASE_FILTER_TABLE_QUERY, $query, $model));
    }

    /**
     * {@inheritDoc}
     */
    public function columns()
    {
        return [
            'id' => [
                'name'  => 'vig_reactions.id',
                'title' => trans('core/base::tables.id'),
                'width' => '20px',
            ],
            'name' => [
                'name'  => 'vig_reactions.name',
                'title' => trans('core/base::tables.type'),
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
        $buttons = $this->addCreateButton(route('vig-reactions.create'), 'vig-reactions.create');

        return apply_filters(BASE_FILTER_TABLE_BUTTONS, $buttons, VigReactions::class);
    }

    /**
     * {@inheritDoc}
     */
    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('vig-reactions.deletes'), 'vig-reactions.destroy', parent::bulkActions());
    }

    /**
     * {@inheritDoc}
     */
    public function getBulkChanges(): array
    {
        return [
            'vig_reactions.type' => [
                'title'    => trans('core/base::tables.type'),
                'type'     => 'text',
                'validate' => 'required|max:120',
            ],
            'vig_reactions.created_at' => [
                'title' => trans('core/base::tables.created_at'),
                'type'  => 'date',
            ],
        ];
    }
}
