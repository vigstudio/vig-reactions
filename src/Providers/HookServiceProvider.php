<?php

namespace Botble\VigReactions\Providers;

use Assets;
use Botble\Dashboard\Supports\DashboardWidgetInstance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class HookServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (function_exists('shortcode')) {
            add_shortcode('vig-reactions', __('Vig Reactions'), __('Add Vig Reaction'), function ($query) {
                return $this->renderReaction($query);
            });
        }

        add_filter(DASHBOARD_FILTER_ADMIN_LIST, [$this, 'registerDashboardWidgetsRecent'], 51, 2);
        add_filter(DASHBOARD_FILTER_ADMIN_LIST, [$this, 'registerDashboardWidgetsPopular'], 50, 2);

        theme_option()
            ->setSection([
                'title' => 'Vig Reactions',
                'desc' => 'Theme options for Vig Reactions',
                'id' => 'opt-vig-reactions',
                'subsection' => true,
                'icon' => 'fa fa-edit',
                'fields' => [
                    [
                        'id' => 'vig_reactions_style',
                        'type' => 'customSelect',
                        'label' => 'Style',
                        'attributes' => [
                            'name' => 'vig_reactions_style',
                            'list' => [
                                '1' => 'Full Option',
                                '2' => 'Simple More',
                                '3' => 'Simple More Small',
                                '4' => 'Same Github',
                            ],
                            'value' => '',
                            'options' => [
                                'class' => 'form-control',
                            ],
                        ],
                    ],
                ],
            ]);
    }

    /**
     * @param stdClass $shortcode
     * @return array|string
     */
    public function renderReaction($query)
    {
        $content = $query->content;

        $style = theme_option('vig_reactions_style') ?: 1;

        $reactionTypes = ['like', 'love', 'haha', 'wow', 'sad', 'angry'];

        $data = json_decode($content);
        if (! $data) {
            return null;
        }

        return view('plugins/vig-reactions::style-' . $style, compact('content', 'reactionTypes', 'data'));
    }

    /**
     * @param array $widgets
     * @param Collection $widgetSettings
     * @return array
     */
    public function registerDashboardWidgetsRecent($widgets, $widgetSettings)
    {
        if (! Auth::user()->hasPermission('vig-reactions.index')) {
            return $widgets;
        }

        Assets::addScriptsDirectly(['/vendor/core/plugins/vig-reactions/reaction-recent.js']);

        return (new DashboardWidgetInstance())
            ->setPermission('vig-reactions.index')
            ->setKey('widget_reaction_vig_recent')
            ->setTitle('Reactions Recent')
            ->setIcon('fas fa-flushed')
            ->setColor('#f3c200')
            ->setRoute(route('vig-reactions.widget.recent-reactions'))
            ->setBodyClass('scroll-table')
            ->setColumn('col-md-6 col-sm-6')
            ->init($widgets, $widgetSettings);
    }

    /**
     * @param array $widgets
     * @param Collection $widgetSettings
     * @return array
     */
    public function registerDashboardWidgetsPopular($widgets, $widgetSettings)
    {
        if (! Auth::user()->hasPermission('vig-reactions.index')) {
            return $widgets;
        }

        Assets::addScriptsDirectly(['/vendor/core/plugins/vig-reactions/reaction-recent.js']);

        return (new DashboardWidgetInstance())
            ->setPermission('vig-reactions.index')
            ->setKey('widget_reaction_vig_popular')
            ->setTitle('Popularity Reaction')
            ->setIcon('fas fa-flushed')
            ->setColor('#f3c200')
            ->setRoute(route('vig-reactions.widget.popular-reactions'))
            ->setBodyClass('scroll-table')
            ->setColumn('col-md-6 col-sm-6')
            ->init($widgets, $widgetSettings);
    }
}
