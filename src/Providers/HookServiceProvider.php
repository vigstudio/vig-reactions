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

        theme_option()
            ->setSection([
                'title'      => 'Vig Reactions',
                'desc'       => 'Theme options for Vig Reactions',
                'id'         => 'opt-vig-reactions',
                'subsection' => true,
                'icon'       => 'fa fa-edit',
                'fields'     => [
                    [
                        'id'         => 'vig_reactions_style',
                        'type'       => 'customSelect',
                        'label'      => 'Style',
                        'attributes' => [
                            'name'    => 'vig_reactions_style',
                            'list'    => [
                                '1' => 'Style 1',
                                '2' => 'Style 2',
                                '3' => 'Style 3',
                            ],
                            'value'   => '',
                            'options' => [
                                'class' => 'form-control',
                            ],
                        ],
                    ],
                ],
            ]);
    }

    public function render($query)
    {
        $content = $query->content;
        $style = theme_option('vig_reactions_style') ?? 1;
        return view('plugins/vig-reactions::style-'.$style, compact('content'));
    }

}
