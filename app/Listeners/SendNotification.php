<?php

namespace App\Listeners;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNotification
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
     * @param  ModelNotFoundException  $event
     * @return void
     */
    public function handle(ModelNotFoundException $event)
    {
        return Response::make('Not found',404);
    }
}
