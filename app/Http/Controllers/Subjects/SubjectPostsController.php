<?php

namespace App\Http\Controllers\Subjects;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\Subjects\SubjectPostRequest;
use App\Http\Services\FilesService;
use App\Models\Subjects\Subject;
use App\Models\Subjects\SubjectPost;
use App\Models\File;
use Auth;

class SubjectPostsController extends Controller
{
    private $filesService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(FilesService $filesService){
        $this->filesService = $filesService;
    }

    /**
     * Show list of all subject posts
     *
     * @param Subject $subject
     * @return \Illuminate\Http\Response
     */
    public function index(Subject $subject){
        return view('subjects.posts.index', compact('subject'));
    }

    /**
     * Show the contents of the given subject post
     *
     * @param Subject $subject
     * @param SubjectPost $post
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject, SubjectPost $post){
        $is_teacher = true;
        return view('subjects.posts.show', compact('subject', 'post', 'is_teacher'));
    }

    /**
     * Show the form in creating a subject post
     *
     * @param Subject $subject
     * @return \Illuminate\Http\Response
     */
    public function create(Subject $subject){
        return view('subjects.posts.create', compact('subject'));
    }

    /**
     * Store the subject post in the database
     *
     * @param Subject $subject
     * @param SubjectPostRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Subject $subject, SubjectPostRequest $request){
        $post = $subject->subjectPosts()->create($request->all());
        $destinationPath = 'documents/' . Auth::user()->username . '/' . $subject->subject_title . '/' . $post->id;
        $files = $request->file('files');
        $file_ids = $this->uploadFiles($files, $destinationPath);
        $post->files()->sync($file_ids);        
        flash()->success('Post has been saved. It will be published at the specified date.');
        return redirect('/subjects/' . $subject->id . '/posts');
    }

    /**
     * Show the form in editing a subject post
     *
     * @param Subject $subject
     * @param SubjectPost $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $subject, SubjectPost $post){
        return view('subjects.posts.edit', compact('subject', 'post'));
    }

    /**
     * Update the subject post in the database
     *
     * @param Subject $subject
     * @param SubjectPost $post
     * @param SubjectPostRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(Subject $subject, SubjectPost $post, SubjectPostRequest $request){
        $files = $request->file('files');
        $destinationPath = 'documents/' . Auth::user()->username . '/' . $subject->subject_title . '/posts/' . $post->id;
        $new_file_ids = $this->uploadFiles($files, $destinationPath);
        $old_file_ids = ($request->input('old_files') == null ? [] : $request->input('old_files'));
        $file_ids = array_merge($old_file_ids, $new_file_ids);
        
        $post->update($request->all());
        $post->files()->sync($file_ids);
        flash()->success('Post successfully updated');
        return redirect('/subjects/' . $subject->id . '/posts');
    }

    /**
     * Show the form in deleting a subject post
     *
     * @param Subject $subject
     * @param SubjectPost $post
     * @return \Illuminate\Http\Response
     */
    public function showDeleteConfirmation(Subject $subject, SubjectPost $post){
        return view('subjects.posts.delete', compact('subject', 'post'));
    }

    /**
     * Delete the subject post in the database
     *
     * @param Subject $subject
     * @param SubjectPost $post
     * @return \Illuminate\Http\Response
     */
    public function delete(Subject $subject, SubjectPost $post){
        $post->delete();
        return redirect('/subjects/' . $subject->id . '/posts');
    }

    /**
     * Store into the database the files uploaded by the faculty 
     *
     * @param array $files
     * @param string $destinationPath
     * @return array
     */
    private function uploadFiles($files, $destinationPath){
        if($files[0]){
            return $this->filesService->upload($files, $destinationPath);
        } else {
            return [];
        }
    }
}
