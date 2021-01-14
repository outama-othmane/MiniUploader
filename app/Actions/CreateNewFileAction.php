<?php

namespace App\Actions;

use App\Models\Team;

class CreateNewFileAction
{
    public function create(Team $team, array $input)
    {
        $file = $team->files()->create([
            'name'  => $input['name'],
            'size'  => $input['size'],
            'path'  => $input['path'],
        ]);

        $object = $team->objects()->make([
            'parent_id' => $input['parent_id'] ?? null,
        ]);

        $object->objectable()->associate($file);
        $object->save();
    }
}
