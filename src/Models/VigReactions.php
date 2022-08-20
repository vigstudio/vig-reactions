<?php

namespace Botble\VigReactions\Models;

use Botble\Base\Traits\EnumCastable;
use Botble\Revision\RevisionableTrait;
use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class VigReactions extends BaseModel
{
    use EnumCastable;
    use RevisionableTrait;

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
        'reactable_id',
        'reactable_type',
        'responder_id',
        'responder_type',
    ];

    /**
     * Reactable model relation.
     *
     * @return MorphTo
     */
    public function reactable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the user that reacted on reactable model.
     *
     * @return MorphTo
     */
    public function responder(): MorphTo
    {
        return $this->morphTo();
    }
}
