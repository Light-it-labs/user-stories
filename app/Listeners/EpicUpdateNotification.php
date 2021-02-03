<?php

namespace App\Listeners;

use App\Events\EpicUpdateEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EpicUpdateNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  EpicUpdateEvent  $event
     * @return void
     */
    public function handle(EpicUpdateEvent $event)
    {
        
    }
}
