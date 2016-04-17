<?php

namespace App\Http\Controllers\Subjects;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubjectRequirementRequest;
use App\Http\Services\FilesService;
use App\Models\Subjects\Subject;
use App\Models\Subjects\SubjectRequirement;
use App\Models\File;
use Auth;
use Carbon\Carbon;


class SubjectRequirementsController extends Controller
{
    private $filesService;

    public function __construct(FilesService $filesService){
        $this->filesService = $filesService;
    }

    public function create(Subject $subject){
        return view('subjects.requirements.create', compact('subject'));
    }

    public function store(Subject $subject, SubjectRequirementRequest $request){
        $subjectRequirement = $subject->subjectRequirements()->create($request->all());
        
        $destinationPath = 'documents/' . Auth::user()->username . '/' . $subject->subject_title . '/requirements/' . $subjectRequirement->id;
        $files = $request->file('files');
        $file_ids = $this->uploadFiles($files, $destinationPath);
        $subjectRequirement->files()->sync($file_ids);
        
        flash()->success('Requirement has been saved. It will be published at the specified date.');
        return redirect('/subjects/' . $subject->id);
    }

    public function edit(Subject $subject, SubjectRequirement $subjectRequirement){
        $requirement = $subjectRequirement;
        return view('subjects.requirements.edit', compact('subject', 'requirement'));
    }

    public function update(Subject $subject, SubjectRequirement $subjectRequirement, SubjectRequirementRequest $request){
        $files = $request->file('files');
        $destinationPath = 'documents/' . Auth::user()->username . '/' . $subject->subject_title . '/' . $subjectRequirement->id;
        $new_file_ids = $this->uploadFiles($files, $destinationPath);
        $old_file_ids = ($request->input('old_files') == null ? [] : $request->input('old_files'));
        $file_ids = array_merge($old_file_ids, $new_file_ids);

        $subjectRequirement->update($request->all());
        $subjectRequirement->files()->sync($file_ids);
        flash()->success('Requirement successfully updated');
        return redirect('/subjects/' . $subject->id);
    }

    public function showDeleteConfirmation(Subject $subject, SubjectRequirement $subjectRequirement){
        $requirement = $subjectRequirement;
        return view('subjects.requirements.delete', compact('subject', 'requirement'));
    }

    public function delete(Subject $subject, SubjectRequirement $subjectRequirement){
        $subjectRequirement->delete();
        return redirect('/subjects/' . $subject->id);
    }

    private function uploadFiles($files, $destinationPath){
        if($files[0]){
            return $this->filesService->upload($files, $destinationPath);
        } else {
            return [];
        }
    }
}
