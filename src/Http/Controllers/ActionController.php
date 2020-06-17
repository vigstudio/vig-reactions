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
        $query = VigReactions::where('session_id', $session_id)->get();

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
