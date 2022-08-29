<?php

namespace Botble\VigReactions\Repositories\Caches;

use Botble\Support\Repositories\Caches\CacheAbstractDecorator;
use Botble\VigReactions\Repositories\Interfaces\VigReactionMetaInterface;

class VigReactionMetaCacheDecorator extends CacheAbstractDecorator implements VigReactionMetaInterface
{
    public function saveMetaReactionData($object, $value)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }

    public function getMetaData($object, array $select = ['value'])
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }

    public function getMeta($object, array $select = ['value'])
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }

}
