<?php

namespace Botble\VigReactions\Providers;

use Botble\VigReactions\Models\VigReactions;
use Illuminate\Support\ServiceProvider;
use Botble\VigReactions\Repositories\Caches\VigReactionsCacheDecorator;
use Botble\VigReactions\Repositories\Eloquent\VigReactionsRepository;
use Botble\VigReactions\Repositories\Interfaces\VigReactionsInterface;
use Botble\Base\Supports\Helper;
use Event;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Illuminate\Routing\Events\RouteMatched;

class VigReactionsServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind(VigReactionsInterface::class, function () {
            return new VigReactionsCacheDecorator(new VigReactionsRepository(new VigReactions));
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('plugins/vig-reactions')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadAndPublishViews()
            ->loadMigrations()
            ->loadAndPublishTranslations()
            ->loadRoutes(['web'])
            ->publishAssets();

        $this->app->register(HookServiceProvider::class);

        Event::listen(RouteMatched::class, function () {
            if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
                \Language::registerModule([VigReactions::class]);
            }

            // dashboard_menu()->registerItem([
            //     'id'          => 'cms-plugins-vig-reactions',
            //     'priority'    => 5,
            //     'parent_id'   => null,
            //     'name'        => 'plugins/vig-reactions::vig-reactions.name',
            //     'icon'        => 'fa fa-list',
            //     'url'         => route('vig-reactions.index'),
            //     'permissions' => ['vig-reactions.index'],
            // ]);
        });
    }
}
