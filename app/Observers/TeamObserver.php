<?php

namespace App\Observers;

use App\Actions\CreateNewFolderAction;
use App\Models\Team;

class TeamObserver
{
    /**
     * Handle the Team "created" event.
     *
     * @param  \App\Models\Team  $team
     * @return void
     */
    public function created(Team $team)
    {
        (new CreateNewFolderAction())->create(
            $team, 
            [
                'name' => $team->name, 
                'parent_id' => null
            ]);
        
        /* $folder = $team->folders()->create([
            'name'  => $team->name
        ]);
        
        $object = $team->objects()->make([
            'parent_id' => null,
        ]);
            
        $object->objectable()->associate($folder);
                
        $object->save(); */
    }

    /**
     * Handle the Team "updated" event.
     *
     * @param  \App\Models\Team  $team
     * @return void
     */
    public function updated(Team $team)
    {
        //
    }

    /**
     * Handle the Team "deleted" event.
     *
     * @param  \App\Models\Team  $team
     * @return void
     */
    public function deleting(Team $team)
    {
        $team->objects()->oldest()->first()->delete();
    }

    /**
     * Handle the Team "deleted" event.
     *
     * @param  \App\Models\Team  $team
     * @return void
     */
    public function deleted(Team $team)
    {
        //
    }

    /**
     * Handle the Team "restored" event.
     *
     * @param  \App\Models\Team  $team
     * @return void
     */
    public function restored(Team $team)
    {
        //
    }

    /**
     * Handle the Team "force deleted" event.
     *
     * @param  \App\Models\Team  $team
     * @return void
     */
    public function forceDeleted(Team $team)
    {
        //
    }
}
