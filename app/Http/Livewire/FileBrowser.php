<?php

namespace App\Http\Livewire;
    
use App\Actions\CreateNewFileAction;
use App\Actions\CreateNewFolderAction;
use App\Models\Obj;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class FileBrowser extends Component
{
    use WithFileUploads;

    public $query;
    
    public $upload;

    public $object;

    public $ancestors;

    public $creatingNewFolder = false;

    public $newFolderState = [
        'name' => ''
    ];

    public $renamingObject;

    public $renamingObjectState;

    public $showingFileUploadForm = false;

    public $confirmingObjectDeletion;

    public function getResultsProperty()
    {
        if (strlen($this->query)) {
            return Obj::search($this->query)->where('team_id', $this->currentTeam->id)->get();
        }
        
        return $this->object->children;
    }

    public function deleteObject()
    {
        Obj::forCurrentTeam()->find($this->confirmingObjectDeletion)->delete();
        
        $this->confirmingObjectDeletion = null;

        $this->object = $this->object->fresh();
    }

    public function updatedUpload($upload)
    {
        $path = $upload->storePublicly(
                    'files', [
                        'disk' => 'local',
                    ]
                );

                
        (new CreateNewFileAction())->create($this->currentTeam, [
            'name'  => $upload->getClientOriginalName(),
            'size'  => $upload->getSize(),
            'path'  => $path,
            'parent_id'=> $this->object->id
        ]);

        $this->object = $this->object->fresh();
    }

    public function renameObject()
    {
        $this->validate([
            'renamingObjectState.name'   => 'required|max:255',
        ]);

        $object = Obj::forCurrentTeam()->find($this->renamingObject)->objectable->update($this->renamingObjectState);

        $this->renamingObject = null;
        
        $this->object = $this->object->fresh();
    }

    public function updatingRenamingObject($id)
    {
        if (is_null($id)) {
            $this->renamingObjectState = [
                'name'  => ''
            ];
            return;
        }
        
        if ($object = Obj::forCurrentTeam()->find($id)) {
            $this->renamingObjectState = [
                'name'  => $object->objectable->name
            ];
        }
    }

    public function createFolder(CreateNewFolderAction $createNewFolderAction)
    {
        $this->validate([
            'newFolderState.name'   => 'required|max:255',
        ]);

        $createNewFolderAction->create($this->currentTeam, array_merge([
            'parent_id' => $this->object->id,
        ], $this->newFolderState));

        $this->creatingNewFolder = false;

        $this->newFolderState = [
            'name' => ''
        ];

        $this->object = $this->object->fresh();
    }

    public function updateObject()
    {
        //
    }

    public function getCurrentTeamProperty() {
        return auth()->user()->currentTeam;
    }

    public function render()
    {
        return view('livewire.file-browser');
    }
}
