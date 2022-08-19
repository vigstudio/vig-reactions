<?php

namespace Botble\VigReactions\Http\Controllers;

use Botble\VigReactions\Repositories\Interfaces\VigReactionsInterface;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\VigReactions\Http\Requests\VigReactionsRequest;
use Botble\VigReactions\Models\VigReactions;
use Illuminate\Http\Request;
use Exception;
use Eloquent;
use Botble\VigReactions\Traits\Reacts;
use Botble\VigReactions\Http\Resources\ReactionResource;

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

    public function getReaction(VigReactionsRequest $request, BaseHttpResponse $response)
    {
        $data = $request->input('reaction_type')::find($request->input('reaction_id'));

        $react = $data->reactions?->first();
        if (!$react) {
            return $response->setError(true)->setMessage(__('Reaction not found'));
        }
        return $response->setData(new ReactionResource($react))->toApiResponse();
    }

    public function pressReaction(VigReactionsRequest $request, BaseHttpResponse $response)
    {
        $data = $request->input('reaction_type')::find($request->input('reaction_id'));

        $react = $this->reactTo($data, $request->input('type'));

        return $response->setData(new ReactionResource($react))->toApiResponse();
    }

}
