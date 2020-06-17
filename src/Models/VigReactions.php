<?php

namespace Botble\VigReactions\Models;

use Botble\Base\Traits\EnumCastable;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;

class VigReactions extends BaseModel
{
    use EnumCastable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'vig_reactions';

    /**
     * @var array
     */
    protected $fillable = [
        'type',
        'session_id',
        'reaction_id',
        'reaction_type',
        'user_id',
        'user_type'
    ];

}
