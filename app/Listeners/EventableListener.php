<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Str;

class EventableListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $model = $event->model;

        \App\Models\Event::create([
            'message' => $this->getMessage($model),
            'eventable_type' => $this->getEventableType($model),
            'eventable_id' => $model->getAttribute('id'),
            'user_id' => $model->getAttribute('user_id'),
            'created_at' => $model->getAttribute('created_at'),
            'updated_at' => $model->getAttribute('updated_at'),
        ]);
    }

    /**
     * Determine the eventable type.
     *
     * @param object $model
     * @return string
     */
    private function getEventableType(object $model): string
    {
        return match ($model->getTable()) {
            'subscribers' => 'subscription',
            'followers' => 'follower',
            'donations' => 'donation',
            'merch_sales' => 'sale',
        };
    }

    /**
     * Determine the event message.
     *
     * @param object $model
     * @return string
     */
    private function getMessage(object $model): string
    {
        return match ($model->getTable()) {
            'subscribers' => "{$model->name} ({$model->subscription_tier}) subscribed to you!",
            'followers' => "{$model->name} followed you!",
            'donations' => "{$model->donator->name} donated {$model->amount} {$model->currency} to you!\n“Thank you for being awesome”",
            'merch_sales' => "{$model->buyer->name} bought some {$model->item_name} from you for {$model->amount} {$model->currency}!",
        };
    }
}
