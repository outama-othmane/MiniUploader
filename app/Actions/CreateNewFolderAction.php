<?php

namespace App\Actions;

use App\Models\Team;

class CreateNewFolderAction
{
    public function create(Team $team, array $input)
    {
        $folder = $team->folders()->create([
            'name'  => $input['name'],
        ]);

        $object = $team->objects()->make([
            'parent_id' => $input['parent_id'] ?? null,
        ]);

        $object->objectable()->associate($folder);
        $object->save();
    }
}
