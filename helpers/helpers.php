<?php
use Botble\VigReactions\Models\VigReactions;

if (!function_exists('get_vig_reaction')) {
    /**
     * @param int $limit
     * @param array $with
     * @return array
     */
    function get_vig_reaction($slugable)
    {
        $slug = json_decode($slugable);
        if($slug) {
            $id = $slug->reference_id;
            $type = $slug->reference_type;
        } else {
            $id = NULL;
            $type = NULL;
        }
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
