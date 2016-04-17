<?php

namespace App\Http\Controllers\Subjects;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubjectPostRequest;
use App\Http\Services\FilesService;
use App\Models\Subjects\Subject;
use App\Models\Subjects\SubjectPost;
use App\Models\File;
use Auth;

class SubjectPostsController extends Controller
{
    private $filesService;

    public function __construct(FilesService $filesService){
        $this->filesService = $filesService;
    }

    public function create(Subject $subject){
        return view('subjects.posts.create', compact('subject'));
    }

    public function store(Subject $subject, SubjectPostRequest $request){
        $subjectPost = $subject->subjectPosts()->create($request->all());
        
        $destinationPath = 'documents/' . Auth::user()->username . '/' . $subject->subject_title . '/' . $subjectPost->id;
        $files = $request->file('files');
        $file_ids = $this->uploadFiles($files, $destinationPath);
        $subjectPost->files()->sync($file_ids);
        
        flash()->success('Post has been saved. It will be published at the specified date.');
        return redirect('/subjects/' . $subject->id);
    }

    
    public function edit(Subject $subject, SubjectPost $subjectPost){
        $post = $subjectPost;
        return view('subjects.posts.edit', compact('subject', 'post'));
    }

    public function update(Subject $subject, SubjectPost $subjectPost, SubjectPostRequest $request){
        $files = $request->file('files');
        $destinationPath = 'documents/' . Auth::user()->username . '/' . $subject->subject_title . '/posts/' . $subjectPost->id;
        $new_file_ids = $this->uploadFiles($files, $destinationPath);
        $old_file_ids = ($request->input('old_files') == null ? [] : $request->input('old_files'));
        $file_ids = array_merge($old_file_ids, $new_file_ids);
        
        $subjectPost->update($request->all());
        $subjectPost->files()->sync($file_ids);
        flash()->success('Post successfully updated');
        return redirect('/subjects/' . $subject->id);
    }

    public function showDeleteConfirmation(Subject $subject, SubjectPost $subjectPost){
        $post = $subjectPost;
        return view('subjects.posts.delete', compact('subject', 'post'));
    }

    public function delete(Subject $subject, SubjectPost $subjectPost){
        $subjectPost->delete();
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
