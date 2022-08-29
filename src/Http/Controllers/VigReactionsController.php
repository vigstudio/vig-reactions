<?php

namespace Botble\VigReactions\Http\Controllers;

use Botble\Base\Events\BeforeEditContentEvent;
use Botble\VigReactions\Http\Requests\VigReactionsRequest;
use Botble\VigReactions\Repositories\Interfaces\VigReactionsInterface;
use Botble\VigReactions\Repositories\Interfaces\VigReactionMetaInterface;
use Botble\Base\Http\Controllers\BaseController;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;
use Botble\VigReactions\Tables\VigReactionsTable;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\VigReactions\Forms\VigReactionsForm;
use Botble\Base\Forms\FormBuilder;
use Throwable;
use Botble\Slug\SlugHelper;

class VigReactionsController extends BaseController
{
    /**
     * @var VigReactionsInterface
     */
    protected $vigReactionsRepository;

     /**
     * @var VigReactionMetaInterface
     */
    protected $metaBoxRepository;

    /**
     * @param VigReactionsInterface $vigReactionsRepository
     * MetaBox constructor.
     * @param VigReactionMetaInterface $metaBoxRepository
     */
    public function __construct(VigReactionsInterface $vigReactionsRepository, VigReactionMetaInterface $metaBoxRepository)
    {
        $this->vigReactionsRepository = $vigReactionsRepository;
        $this->metaBoxRepository = $metaBoxRepository;
    }

    /**
     * @param VigReactionsTable $table
     * @return JsonResponse|View
     * @throws Throwable
     */
    public function index(VigReactionsTable $table)
    {
        page_title()->setTitle(trans('plugins/vig-reactions::vig-reactions.name'));

        return $table->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/vig-reactions::vig-reactions.create'));

        return $formBuilder->create(VigReactionsForm::class)->renderForm();
    }

    /**
     * @param VigReactionsRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(VigReactionsRequest $request, BaseHttpResponse $response)
    {
        $vigReactions = $this->vigReactionsRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(VIG_REACTIONS_MODULE_SCREEN_NAME, $request, $vigReactions));

        return $response
            ->setPreviousUrl(route('vig-reactions.index'))
            ->setNextUrl(route('vig-reactions.edit', $vigReactions->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

     /**
     * @param Request $request
     * @param $id
     * @return BaseHttpResponse
     */
    public function copy(Request $request, $id, BaseHttpResponse $response)
    {
        $vigReactions = $this->vigReactionsRepository->findOrFail($id);

        $new = $vigReactions->replicate();
        $new->save();

        event(new CreatedContentEvent(VIG_REACTIONS_MODULE_SCREEN_NAME, $request, $new));

        return $response
            ->setPreviousUrl(route('vig-reactions.index'))
            ->setNextUrl(route('vig-reactions.index'))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    /**
     * @param $id
     * @param Request $request
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function edit($id, FormBuilder $formBuilder, Request $request)
    {
        $vigReactions = $this->vigReactionsRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $vigReactions));

        page_title()->setTitle(trans('plugins/vig-reactions::vig-reactions.edit') . ' "' . $vigReactions->name . '"');

        return $formBuilder->create(VigReactionsForm::class, ['model' => $vigReactions])->renderForm();
    }

    /**
     * @param $id
     * @param VigReactionsRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function update($id, VigReactionsRequest $request, BaseHttpResponse $response)
    {
        $vigReactions = $this->vigReactionsRepository->findOrFail($id);

        $vigReactions->fill($request->input());

        $this->vigReactionsRepository->createOrUpdate($vigReactions);

        event(new UpdatedContentEvent(VIG_REACTIONS_MODULE_SCREEN_NAME, $request, $vigReactions));

        return $response
            ->setPreviousUrl(route('vig-reactions.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    /**
     * @param $id
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function destroy(Request $request, $id, BaseHttpResponse $response)
    {
        try {
            $vigReactions = $this->vigReactionsRepository->findOrFail($id);

            $this->vigReactionsRepository->delete($vigReactions);

            event(new DeletedContentEvent(VIG_REACTIONS_MODULE_SCREEN_NAME, $request, $vigReactions));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws Exception
     */
    public function deletes(Request $request, BaseHttpResponse $response)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return $response
                ->setError()
                ->setMessage(trans('core/base::notices.no_select'));
        }

        foreach ($ids as $id) {
            $vigReactions = $this->vigReactionsRepository->findOrFail($id);
            $this->vigReactionsRepository->delete($vigReactions);
            event(new DeletedContentEvent(VIG_REACTIONS_MODULE_SCREEN_NAME, $request, $vigReactions));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }


     /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws Throwable
     */
    public function getWidgetRecentReactions(Request $request, BaseHttpResponse $response)
    {
        $limit = (int)$request->input('paginate', 10);
        $limit = $limit > 0 ? $limit : 10;

        $reactions = $this->vigReactionsRepository->advancedGetReaction([
            'with'     => ['reactable'],
            'order_by' => ['created_at' => 'desc'],
            'paginate' => [
                'per_page'      => $limit,
                'current_paged' => (int)$request->input('page', 1),
            ],
        ]);

        return $response
            ->setData(view('plugins/vig-reactions::widgets.recent', compact('reactions', 'limit'))->render());
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws Throwable
     */
    public function getWidgetPopularReactions(Request $request, BaseHttpResponse $response)
    {
        $limit = (int)$request->input('paginate', 10);
        $limit = $limit > 0 ? $limit : 10;


         $reactions = $this->metaBoxRepository->advancedGet([
            'with'     => ['reactable'],
            'order_by' => ['value->reactable_total' => 'asc'],
            'paginate' => [
                'per_page'      => $limit,
                'current_paged' => (int)$request->input('page', 1),
            ],
        ]);

        return $response
            ->setData(view('plugins/vig-reactions::widgets.popular', compact('reactions', 'limit'))->render());
    }
}
