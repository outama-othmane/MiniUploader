<?php

namespace App\Providers;

use App\Models\File;
use App\Models\Folder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class MorphMapServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            "folder"    => Folder::class,
            "file"      => File::class,
        ]);
    }
}
