<?php

namespace Botble\VigReactions\Providers;

use Botble\Base\Enums\BaseStatusEnum;
use Illuminate\Support\ServiceProvider;
use Botble\VigReactions\Models\VigReactions;
use Theme;

class HookServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (function_exists('shortcode')) {
            add_shortcode('vig-reactions', __('Vig Reactions'), __('Add Vig Reaction'), function ($query) {
                return $this->render($query);
            });
        }
    }

    public function render($query)
    {
        $content = $query->content;
        return view('plugins/vig-reactions::reaction', compact('content'));
    }

}
