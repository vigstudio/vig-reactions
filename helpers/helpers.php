<?php
use Botble\VigReactions\Models\VigReactions;

if (!function_exists('get_vig_reaction')) {
    /**
     * @param int $limit
     * @param array $with
     * @return array
     */
    function get_vig_reaction($type, $id)
    {
        return VigReactions::where('reaction_id', $id)->where('reaction_type', $type)->get();
    }
}

if (!function_exists('count_vig_reaction')) {
    /**
     * @param int $limit
     * @param array $with
     * @return array
     */
    function count_vig_reaction($reaction, $type = NULL)
    {
        if(is_null($type)) {
            return $reaction->count();
        }
        return $reaction->where('type', $type)->count();
    }
}
