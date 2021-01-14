<?php

namespace App\Models;

use App\Models\File;
use App\Models\Folder;
use App\Models\Obj;
use App\Observers\TeamObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Jetstream\Events\TeamCreated;
use Laravel\Jetstream\Events\TeamDeleted;
use Laravel\Jetstream\Events\TeamUpdated;
use Laravel\Jetstream\Team as JetstreamTeam;

class Team extends JetstreamTeam
{
    use HasFactory;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'personal_team' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'personal_team',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => TeamCreated::class,
        'updated' => TeamUpdated::class,
        'deleted' => TeamDeleted::class,
    ];

    public static function booted() {
        Team::observe(TeamObserver::class);
        
        /* static::created(function ($team) {
            $obejct = $team->objects()->make([
                'parent_id' => null,
            ]);

            $obejct->objectable()->associate(
                $team->folders()->create([
                    'name'  => $team->name
                ])
            );

            $obejct->save();
        }); */
    }

    public function objects()
    {
        return $this->hasMany(Obj::class);
    }
    
    public function files()
    {
        return $this->hasMany(File::class);
    }
    
    public function folders()
    {
        return $this->hasMany(Folder::class);
    }
}
