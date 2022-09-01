<?php

namespace App\Listeners;

use App\Events\PostCreatedEvent;
use App\Models\User;
use App\Notifications\PostCreatedNotification; 
use Illuminate\Support\Facades\Notification;

class PostCreatedListener
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
     * @param  \App\Events\PostCreatedEvent  $event
     * @return void
     */
    public function handle(PostCreatedEvent $event)
    {
        if($event->post){
            Notification::send(User::all(),new PostCreatedNotification($event->post));

        }
    }
}
