<?php

namespace Botble\VigReactions\Repositories\Caches;

use Botble\Support\Repositories\Caches\CacheAbstractDecorator;
use Botble\VigReactions\Repositories\Interfaces\VigReactionsInterface;

class VigReactionsCacheDecorator extends CacheAbstractDecorator implements VigReactionsInterface
{
    public function advancedGetReaction(array $params = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
