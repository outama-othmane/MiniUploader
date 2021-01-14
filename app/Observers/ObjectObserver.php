<?php

namespace App\Observers;

use App\Models\Obj;

class ObjectObserver
{
    /**
     * Handle the Obj "created" event.
     *
     * @param  \App\Models\Obj  $obj
     * @return void
     */
    public function created(Obj $obj)
    {
        //
    }

    /**
     * Handle the Obj "updated" event.
     *
     * @param  \App\Models\Obj  $obj
     * @return void
     */
    public function updated(Obj $obj)
    {
        //
    }

    /**
     * Handle the Obj "deleting" event.
     *
     * @param  \App\Models\Obj  $obj
     * @return void
     */
    public function deleting(Obj $obj)
    {
        optional($obj->objectable)->delete();
        $obj->descendants->each->delete();
        // $obj
    }

    /**
     * Handle the Obj "deleted" event.
     *
     * @param  \App\Models\Obj  $obj
     * @return void
     */
    public function deleted(Obj $obj)
    {
        
    }

    /**
     * Handle the Obj "restored" event.
     *
     * @param  \App\Models\Obj  $obj
     * @return void
     */
    public function restored(Obj $obj)
    {
        //
    }

    /**
     * Handle the Obj "force deleted" event.
     *
     * @param  \App\Models\Obj  $obj
     * @return void
     */
    public function forceDeleted(Obj $obj)
    {
        //
    }
}
