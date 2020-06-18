<?php

namespace Botble\VigReactions\Http\Controllers;

use Botble\VigReactions\Repositories\Interfaces\VigReactionsInterface;
use Botble\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Exception;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\VigReactions\Models\VigReactions;
use Illuminate\Session\Store;
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
            return ['status' => 'error'];
        }

        if(auth()->guard('member')->check()) {
            $request->merge([
                'session_id'    => $session_id,
                'user_id'       => auth()->guard('member')->id(),
                'user_type'     => get_class(auth()->guard('member')->user())
            ]);
        }

        if(auth()->check()) {
            $request->merge([
                'session_id'    => $session_id,
                'user_id'       => auth()->id(),
                'user_type'     => get_class(auth()->user())
            ]);
        }

        $query = VigReactions::where('session_id', $session_id)
                                ->where('reaction_id', $request->input('reaction_id'))
                                ->where('reaction_type', $request->input('reaction_type'))
                                ->get();

        if($query->count() == 0) {
            $reaction = $this->vigReactionsRepository->create($request->input());
        } else if($query->first()->type !== $request->input('type')) {
            $old_type = $query->first()->type;
            $query->first()->update($request->input());
            $reaction = ['old_type' => $old_type, 'action' => 'update', 'type' => $query->first()->type];
        } else {
            $reaction = ['type' => $query->first()->type, 'action' => 'delete'];
            $query->first()->delete();
        }
        return response()->json($reaction);
    }


}
