<?php

namespace Botble\VigReactions\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'type'              => $this->type,
            'reactable_summary' => $this->reactable->reactionSummary(),
            'reactable_total'   => $this->reactable->reactionTotal(),
        ];
    }
}
