<?php

namespace Botble\VigReactions\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Botble\VigReactions\Http\Listeners\CreateOrUpdateReactionListener;
use Botble\VigReactions\Http\Events\CreateOrUpdateReactionEvent;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        CreateOrUpdateReactionEvent::class => [
            CreateOrUpdateReactionListener::class,
        ],
    ];
}
