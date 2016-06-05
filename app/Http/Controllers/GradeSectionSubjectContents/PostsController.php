<?php

namespace App\Http\Controllers\GradeSectionSubjectContents;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\GradeSectionSubjects\PostRequest;
use App\Http\Services\FilesService;
use App\Models\File;
use App\Models\PostsAndRequirements\Post;
use App\Models\GradeSectionSubjects\GradeSectionSubject;
use App\Models\GradeSectionSubjects\GradeSectionSubjectPost;
use Auth;
use Carbon\Carbon;

class PostsController extends Controller
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
     * Show list of all posts
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $posts = Post::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        return view('grade-section-subjects.posts.index', compact('posts'));
    }

    /**
     * Show the contents of the given post
     *
     * @param Post $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post){
        $is_teacher = true;
        $attachments = GradeSectionSubjectPost::where('post_id', $post->id)->get();
        return view('grade-section-subjects.posts.show', compact('post', 'attachments', 'is_teacher'));
    }

    /**
     * Show the form in creating a subject post
     *
     * @param Subject $subject
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $timeNow = Carbon::parse(Carbon::now())->format('Y-m-d\\TH:i');
        $gradeSectionSubjectsList = Auth::user()->gradeSectionSubjects;
        $gradeSectionSubjects = [];
        $gradeSectionSubjects[0] = "--Disable--";
        foreach ($gradeSectionSubjectsList as $gradeSectionSubject){
            $gradeSectionSubjects[$gradeSectionSubject->id] = $gradeSectionSubject->subject->name . ' (' . $gradeSectionSubject->gradeSection->getName->name . ')';
        }
        return view('grade-section-subjects.posts.create', compact('gradeSectionSubjects', 'timeNow'));
    }

    /**
     * Store the subject post in the database
     *
     * @param Subject $subject
     * @param PostRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request){
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $post = Post::create($data);

        $destinationPath = 'documents/' . Auth::user()->username . '/posts/' . $post->id;
        $files = $request->file('files');
        $file_ids = $this->uploadFiles($files, $destinationPath);
        $post->files()->sync($file_ids);  

        $gradeSectionSubjectIdList = $request->input('grade_section_subject_id');
        $publishOnList = $request->input('publish_on');
        for ($i = 0; $i < count($gradeSectionSubjectIdList); $i++){
            if ($gradeSectionSubjectIdList[$i] != '0'){
                GradeSectionSubjectPost::create([
                    'post_id' => $post->id,
                    'grade_section_subject_id' => $gradeSectionSubjectIdList[$i],
                    'publish_on' => Carbon::parse($publishOnList[$i]),
                ]);
            }
        }
        flash()->success('Post has been created and attached. It will be published on the specified date.');
        return redirect('/posts/' . $post->id);
    }

    /**
     * Show the form in editing a subject post
     *
     * @param Subject $subject
     * @param Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post){
        return view('grade-section-subjects.posts.edit', compact('post'));
    }

    /**
     * Update the subject post in the database
     *
     * @param Subject $subject
     * @param Post $post
     * @param PostRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(Post $post, PostRequest $request){
        $files = $request->file('files');
        $destinationPath = 'documents/' . Auth::user()->username . '/posts/' . $post->id;
        $new_file_ids = $this->uploadFiles($files, $destinationPath);
        $old_file_ids = ($request->input('old_files') == null ? [] : $request->input('old_files'));
        $file_ids = array_merge($old_file_ids, $new_file_ids);
        
        $post->update($request->all());
        $post->files()->sync($file_ids);
        flash()->success('Post successfully updated');
        return redirect('/posts/' . $post->id);
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
