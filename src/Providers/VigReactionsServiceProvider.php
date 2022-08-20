<?php

namespace Botble\VigReactions\Providers;

use Botble\Base\Models\BaseModel;
use Botble\VigReactions\Models\VigReactions;
use Illuminate\Support\ServiceProvider;
use Botble\VigReactions\Repositories\Caches\VigReactionsCacheDecorator;
use Botble\VigReactions\Repositories\Eloquent\VigReactionsRepository;
use Botble\VigReactions\Repositories\Interfaces\VigReactionsInterface;
use Botble\Base\Supports\Helper;
use Event;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Illuminate\Routing\Events\RouteMatched;
use MacroableModels;
use Botble\Slug\SlugHelper;

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

        foreach (array_keys($this->app->make(SlugHelper::class)->supportedModels()) as $item) {
            if (!class_exists($item)) {
                continue;
            }
            /**
             * @var BaseModel $item
             */
            $item::resolveRelationUsing('reactions', function ($model) {
                return $model->morphMany(VigReactions::class, 'reactable');
            });

            MacroableModels::addMacro($item, 'reactionSummary', function () {
                return $this->reactions->groupBy('type')->map(function ($val) {
                    return $val->count();
                });
            });

            MacroableModels::addMacro($item, 'reactionTotal', function () {
                return $this->reactions->count();
            });

            MacroableModels::addMacro($item, 'getReactionSummaryAttribute', function () {
                return $this->reactionSummary();
            });
        }


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
