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

    public function pressReaction(Request $request)
    {
        $session_id = Session::getId();
        $request->merge([
            'session_id' => $session_id
        ]);
        $check = VigReactions::where('session_id', $session_id)->where('type', $request->type)->get();
        if($check->count() == 0) {
            $reaction = $this->vigReactionsRepository->create($request->input());
        } else {
            $reaction = ['type' => $check->first()->type, 'error' => true];
            $check->first()->delete();
        }
        return response()->json($reaction);
    }

}
