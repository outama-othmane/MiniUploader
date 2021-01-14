<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use App\Observers\FileObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory,
        HasUuid;

     protected $fillable = [
        'uuid',
        'name',
        'size',
        'path',
    ];

    public static function booted() {
        File::observe(FileObserver::class);
    }

    public function sizeForHumans()
    {
        $bytes = $this->size;

        $units = ['b', 'kb', 'mb', 'gb', 'tb', 'pb'];

        for ($i=0; $bytes > 1024 && $bytes <= 2^((count($units)-1) *10); $i++) { 
            $bytes /= 1024;
        }

        return round($bytes, 2) . $units[$i];
    }
}
