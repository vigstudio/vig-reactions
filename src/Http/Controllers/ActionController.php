<?php

namespace Botble\VigReactions\Http\Controllers;

use Botble\VigReactions\Repositories\Interfaces\VigReactionsInterface;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\VigReactions\Http\Requests\VigReactionsRequest;
use Botble\VigReactions\Traits\Reacts;
use Botble\VigReactions\Http\Resources\ReactionResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class ActionController extends BaseController
{
    use Reacts;

    /**
     * @var VigReactionsInterface
     */
    protected $vigReactionsRepository;

    /**
     * @param VigReactionsInterface $vigReactionsRepository
     */
    public function __construct(VigReactionsInterface $vigReactionsRepository)
    {
        $this->vigReactionsRepository = $vigReactionsRepository;
    }

    /**
     * @param VigReactionsRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse|JsonResponse|RedirectResponse|JsonResource
     */
    public function getReaction(VigReactionsRequest $request, BaseHttpResponse $response)
    {
        $reactionType = $request->input('reaction_type');

        if (!class_exists($reactionType)) {
            return $response;
        }

        $data = $reactionType::findOrFail($request->input('reaction_id'));

        $react = $data->reactions ? $data->reactions->first() : null;

        if (!$react) {
            return $response->setError()->setMessage(__('Reaction not found'));
        }

        return $response->setData(new ReactionResource($react))->toApiResponse();
    }

    /**
     * @param VigReactionsRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse|JsonResponse|RedirectResponse|JsonResource
     */
    public function pressReaction(VigReactionsRequest $request, BaseHttpResponse $response)
    {
        $reactionType = $request->input('reaction_type');

        if (!class_exists($reactionType)) {
            return $response;
        }

        $data = $reactionType::findOrFail($request->input('reaction_id'));

        $react = $this->reactTo($data, $request->input('type'));

        return $response->setData(new ReactionResource($react))->toApiResponse();
    }
}
