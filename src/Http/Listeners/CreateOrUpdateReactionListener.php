<?php

namespace Botble\VigReactions\Http\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Botble\VigReactions\Http\Events\CreateOrUpdateReactionEvent;
use Botble\VigReactions\Repositories\Interfaces\VigReactionMetaInterface;
use Botble\VigReactions\Http\Resources\ReactionResource;

class CreateOrUpdateReactionListener
{
    /**
     * @var VigReactionMetaInterface
     */
    protected $metaBoxRepository;

    /**
     * @param VigReactionMetaInterface $metaBoxRepository
     */
    public function __construct(VigReactionMetaInterface $metaBoxRepository)
    {
        $this->metaBoxRepository = $metaBoxRepository;
    }

    /**
     * Handle the event.
     *
     * @param CreateOrUpdateReactionEvent $event
     * @return void
     */
    public function handle(CreateOrUpdateReactionEvent $event)
    {
        $reactionId = $event->reaction->reactable_id;
        $reactionType = $event->reaction->reactable_type;
        $data = $reactionType::findOrFail($reactionId);

        return $this->metaBoxRepository->saveMetaReactionData($data, new ReactionResource($event->reaction));
    }
}
