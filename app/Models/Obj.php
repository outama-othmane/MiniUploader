<?php

namespace App\Models;

use App\Models\Obj;
use App\Models\Traits\HasUuid;
use App\Models\Traits\RelatesToTeams;
use App\Observers\ObjectObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class Obj extends Model
{
    use HasFactory,
        HasUuid,
        RelatesToTeams,
        HasRecursiveRelationships,
        Searchable;

    public $asYouType = true;

    public $table = "objects";

    protected $fillable = [
        'parent_id',
        'team_id',
        'uuid',
    ];

    public static function booted() {
        Obj::observe(ObjectObserver::class);
    }

    public function isFile():bool 
    {
        return $this->objectable_type === "file";
    }

    public function isFolder():bool 
    {
        return $this->objectable_type === "folder";
    }

    public function scopeDefault(Builder $query)
    {
        $query->forCurrentTeam()->whereNull('parent_id');
    }

    public function objectable()
    {
        return $this->morphTo();
    }

    public function toSearchableArray()
    {
        return [
             'id'       => $this->id,
             'team_id'  => $this->team_id,
             'name'     => $this->objectable->name,
             'path'     => $this->ancestorsAndSelf->pluck('objectable.name')->reverse()->join('/'),
        ];
    }
}
