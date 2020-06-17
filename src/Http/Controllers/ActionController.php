<?php

namespace Botble\VigReactions\Http\Controllers;

use Botble\VigReactions\Repositories\Interfaces\VigReactionsInterface;
use Botble\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Exception;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Illuminate\Session\Store;
use Session;

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
        $reaction = $this->vigReactionsRepository->create($request->input());
        return response()->json($reaction);

    }

}
