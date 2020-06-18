<?php

namespace Botble\VigReactions\Http\Controllers;

use Botble\VigReactions\Repositories\Interfaces\VigReactionsInterface;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\VigReactions\Http\Requests\VigReactionsRequest;
use Botble\VigReactions\Models\VigReactions;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Exception;
use Session;
use Eloquent;

class ActionController extends BaseController
{
    /**
     * @var VigReactionsInterface
     */
    protected $vigReactionsRepository;

    /**
     * @param VigReactionsInterface $vigReactionsRepository
     */
    public function __construct(VigReactionsInterface $vigReactionsRepository, Store $session)
    {
        $this->vigReactionsRepository = $vigReactionsRepository;
        $this->session = $session;
    }

    public function pressReaction(VigReactionsRequest $request)
    {
        $session_id = Session::getId();

        if(is_null($session_id)) {
            return response()->json(['error' => true]);
        }

        $request->merge($this->mergeRequest($session_id));

        $query = $this->vigReactionsRepository->select(['*'], [
            'session_id'    => $session_id,
            'reaction_id'   => $request->input('reaction_id'),
            'reaction_type' => $request->input('reaction_type')
        ]);

        $reaction = $this->createOrUpdate($query, $request);

        return response()->json($reaction);
    }

    public function createOrUpdate($query, $request)
    {
        if($query->count() == 0) {
            $result = $this->vigReactionsRepository->create($request->input());
        } else if($query->first()->type !== $request->input('type')) {
            $old_type = $query->first()->type;
            $query->first()->update($request->input());
            $result = ['old_type' => $old_type, 'action' => 'update', 'type' => $query->first()->type];
        } else {
            $result = ['type' => $query->first()->type, 'action' => 'delete'];
            $query->first()->delete();
        }
        return $result;
    }

    public function mergeRequest($session)
    {
        if(auth()->guard('member')->check()) {
            $user_id = auth()->guard('member')->id();
            $user_type = get_class(auth()->guard('member')->user());
        } else if(auth()->check()) {
            $user_id = auth()->id();
            $user_type = get_class(auth()->user());
        }

        return [
            'session_id'    => $session,
            'user_id'       => $user_id,
            'user_type'     => $user_type
        ];
    }


}
