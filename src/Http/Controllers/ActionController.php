<?php

namespace Botble\VigReactions\Http\Controllers;

use Botble\VigReactions\Repositories\Interfaces\VigReactionsInterface;
use Botble\VigReactions\Repositories\Interfaces\VigReactionMetaInterface;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\VigReactions\Http\Requests\VigReactionsRequest;
use Botble\VigReactions\Traits\Reacts;
use Botble\VigReactions\Http\Resources\ReactionResource;
use Botble\VigReactions\Http\Resources\ReactionMetaResource;
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
     * @var VigReactionMetaInterface
     */
    protected $metaBoxRepository;

    /**
     * @param VigReactionsInterface $vigReactionsRepository
     */
    public function __construct(VigReactionsInterface $vigReactionsRepository, VigReactionMetaInterface $metaBoxRepository)
    {
        $this->vigReactionsRepository = $vigReactionsRepository;
        $this->metaBoxRepository = $metaBoxRepository;
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

        $meta = $this->metaBoxRepository->getMetadata($data);

        if($meta) {
            return $response->setData($meta)->toApiResponse();
        }

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

        $this->metaBoxRepository->saveMetaReactionData($data, new ReactionResource($react));

        return $response->setData(new ReactionResource($react))->toApiResponse();
    }
}
