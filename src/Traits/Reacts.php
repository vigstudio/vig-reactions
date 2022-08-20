<?php

namespace Botble\VigReactions\Traits;

use Botble\Base\Models\BaseModel;
use Botble\VigReactions\Models\VigReactions;

trait Reacts
{
    /**
     * Add Traits to Model Authorizable
     * @param BaseModel $reactable
     * @param string $type
     * @return mixed
     */
    public function reactTo($reactable, $type)
    {
        $reaction = $this->getOldReaction($reactable);

        if (!$reaction) {
            return $this->storeReactions($reactable, $type);
        }

        if ($reaction->type == $type) {
            return $reaction;
        }

        $this->deleteReactions($reaction);

        return $this->storeReactions($reactable, $type);
    }

    /**
     * @param BaseModel $reactable
     * @return mixed
     */
    public function getOldReaction($reactable)
    {
        $user = get_auth_reaction();

        if ($user) {
            return $reactable->reactions()->where([
                'responder_id'   => $user->getKey(),
                'responder_type' => get_class($user),
                'session_id'     => session()->getId(),
            ])->first();
        }

        return $reactable->reactions()->where([
            'session_id' => session()->getId(),
        ])->first();
    }

    /**
     * @param BaseModel $reactable
     * @param string $type
     * @return mixed
     */
    protected function storeReactions($reactable, $type)
    {
        $user = get_auth_reaction();

        if ($user) {
            return $reactable->reactions()->create([
                'responder_id'   => $user->getKey(),
                'responder_type' => get_class($user),
                'session_id'     => session()->getId(),
                'type'           => $type,
            ]);
        }

        return $reactable->reactions()->create([
            'session_id' => session()->getId(),
            'type'       => $type,
        ]);
    }

    /**
     * @param VigReactions $reaction
     * @return bool|null
     */
    protected function deleteReactions(VigReactions $reaction)
    {
        return $reaction->delete();
    }
}
