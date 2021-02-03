<?php

namespace App\Listeners;

use App\Events\ProjectUpdateEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProjectUpdateNotification
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
     * @param  ProjectUpdateEvent  $event
     * @return void
     */
    public function handle(ProjectUpdateEvent $event)
    {
        //
    }
}
