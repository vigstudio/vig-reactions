<?php

namespace Botble\VigReactions\Traits;

use Botble\VigReactions\Models\VigReactions;

trait Reacts
{
    // Add Traits to Model Authorizable
    public function reactTo($reactable, $type)
    {
        $reaction = $this->getOldReaction($reactable);

        if (! $reaction) {
            return $this->storeReactions($reactable, $type);
        }

        if ($reaction->type == $type) {
            return $reaction;
        }

        $this->deleteReactions($reaction, $reactable);

        return $this->storeReactions($reactable, $type);
    }

    public function getOldReaction($reactable)
    {
        $user = get_auth_reaction();
        if($user) {
            return $reactable->reactions()->where([
                'responder_id'      => $user->getKey(),
                'responder_type'    => get_class($user),
                'session_id'        => session()->getId(),
            ])->first();
        } else {
            return $reactable->reactions()->where([
                'session_id'      => session()->getId(),
            ])->first();
        }

    }

    protected function storeReactions($reactable, $type)
    {
        $user = get_auth_reaction();

        if($user) {
            $reaction = $reactable->reactions()->create([
                'responder_id'      => $user->getKey(),
                'responder_type'    => get_class($user),
                'session_id'      => session()->getId(),
                'type' => $type,
            ]);
        } else {
            $reaction = $reactable->reactions()->create([
                'session_id'      => session()->getId(),
                'type' => $type,
            ]);
        }
        return $reaction;
    }

    protected function deleteReactions(VigReactions $reaction, $reactable)
    {
        $response = $reaction->delete();
        return $response;
    }
}
