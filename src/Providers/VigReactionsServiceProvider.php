<?php

namespace Botble\VigReactions\Providers;

use Botble\Base\Models\BaseModel;
use Botble\VigReactions\Models\VigReactions;
use Botble\VigReactions\Models\VigReactionMeta;
use Illuminate\Support\ServiceProvider;
use Botble\VigReactions\Repositories\Caches\VigReactionsCacheDecorator;
use Botble\VigReactions\Repositories\Eloquent\VigReactionsRepository;
use Botble\VigReactions\Repositories\Interfaces\VigReactionsInterface;
use Botble\VigReactions\Repositories\Caches\VigReactionMetaCacheDecorator;
use Botble\VigReactions\Repositories\Eloquent\VigReactionMetaRepository;
use Botble\VigReactions\Repositories\Interfaces\VigReactionMetaInterface;
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

        $this->app->bind(VigReactionMetaInterface::class, function () {
            return new VigReactionMetaCacheDecorator(new VigReactionMetaRepository(new VigReactionMeta));
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
        $this->app->register(EventServiceProvider::class);

        // config()->set('database.mysql.strict', false);

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

            MacroableModels::addMacro($item, 'getSummaryAttribute', function () {
                return $this->reactionTotal();
            });
        }


        dashboard_menu()->registerItem([
            'id'          => 'cms-plugins-vig-reactions',
            'priority'    => 5,
            'parent_id'   => null,
            'name'        => 'Reaction Manager',
            'icon'        => 'fa fa-list',
            'url'         => route('vig-reactions.index'),
            'permissions' => ['vig-reactions.index'],
        ]);
    }
}
