<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Obj;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function __construct()
    {
        $this->middleware(["auth"]);
    }

    public function index(Request $request)
    {
        //
        $object = Obj::with(['children.objectable', 'ancestorsAndSelf.objectable'])->forCurrentTeam()
            ->where(
                'uuid', $request->get('uuid', Obj::default()->first()->uuid)
            )
            ->firstOrFail();
        
        return view("files", [
            'object'    => $object,
            'ancestors' => $object->ancestorsAndSelf()->breadthFirst()->get(),
        ]);
    }

    public function download(File $file, Request $request)
    {
        $this->authorize('download', $file);

        return Storage::disk('local')->download($file->path, $file->name);
    }
}
