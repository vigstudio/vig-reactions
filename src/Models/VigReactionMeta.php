<?php

namespace Botble\VigReactions\Models;

use Botble\Base\Traits\EnumCastable;
use Botble\Revision\RevisionableTrait;
use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class VigReactionMeta extends BaseModel
{
    use EnumCastable;
    use RevisionableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'vig_reaction_meta';

    /**
     * @var array
     */
    protected $fillable = [
        "value",
        "reactable_id",
        "reactable_type",
    ];

    /**
     * @var array
     */
    protected $casts = [
        'value' => 'json',
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
}
