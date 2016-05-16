<?php

namespace App\Http\Controllers\Subjects;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\Subjects\SubjectRequirementRequest;
use App\Http\Services\FilesService;
use App\Models\Subjects\Subject;
use App\Models\Subjects\SubjectRequirement;
use App\Models\Subjects\SubjectRequirementInstance;
use App\Models\File;
use Auth;
use Carbon\Carbon;


class SubjectRequirementsController extends Controller
{
    private $filesService;

    public function __construct(FilesService $filesService){
        $this->filesService = $filesService;
    }

    public function index(Subject $subject){
        return view('subjects.requirements.index', compact('subject'));
    }

    public function show(Subject $subject, SubjectRequirement $requirement){
        $is_teacher = true;
        $submissions = [];
        foreach ($subject->students as $student){
            $submissions[$student->id] = SubjectRequirementInstance::where('user_id', $student->id)->where('subject_requirement_id', $requirement->id)->first();
        }
        return view('subjects.requirements.show', compact('subject', 'requirement', 'is_teacher', 'submissions'));
    }

    public function create(Subject $subject){
        return view('subjects.requirements.create', compact('subject'));
    }

    public function store(Subject $subject, SubjectRequirementRequest $request){
        $requirement = $subject->subjectRequirements()->create($request->all());
        $destinationPath = 'documents/' . Auth::user()->username . '/' . $subject->subject_title . '/requirements/' . $requirement->id;
        $files = $request->file('files');
        $file_ids = $this->uploadFiles($files, $destinationPath);
        $requirement->files()->sync($file_ids);
        flash()->success('Requirement has been saved. It will be published at the specified date.');
        return redirect('/subjects/' . $subject->id . '/requirements');
    }

    public function edit(Subject $subject, SubjectRequirement $requirement){
        return view('subjects.requirements.edit', compact('subject', 'requirement'));
    }

    public function update(Subject $subject, SubjectRequirement $requirement, SubjectRequirementRequest $request){
        $files = $request->file('files');
        $destinationPath = 'documents/' . Auth::user()->username . '/' . $subject->subject_title . '/' . $requirement->id;
        $new_file_ids = $this->uploadFiles($files, $destinationPath);
        $old_file_ids = ($request->input('old_files') == null ? [] : $request->input('old_files'));
        $file_ids = array_merge($old_file_ids, $new_file_ids);

        $requirement->update($request->all());
        $requirement->files()->sync($file_ids);
        flash()->success('Requirement successfully updated');
        return redirect('/subjects/' . $subject->id . '/requirements');
    }

    public function showDeleteConfirmation(Subject $subject, SubjectRequirement $requirement){
        return view('subjects.requirements.delete', compact('subject', 'requirement'));
    }

    public function delete(Subject $subject, SubjectRequirement $requirement){
        $requirement->delete();
        return redirect('/subjects/' . $subject->id . '/requirements');
    }

    private function uploadFiles($files, $destinationPath){
        if($files[0]){
            return $this->filesService->upload($files, $destinationPath);
        } else {
            return [];
        }
    }
}
