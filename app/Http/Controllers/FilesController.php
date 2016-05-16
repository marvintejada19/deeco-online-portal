<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\FileRequest;
use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\FileDownloadHistory;
use Auth;
use Response;
use Carbon\Carbon;

class FilesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('fileOwner', ['only' => ['viewDownloadHistory']]);
        $this->middleware('role:Faculty', ['only' => ['viewDownloadHistory']]);
    }

    /**
     * Request a file download
     *
     * @param \Illuminate\Http\Request  $request
     * @return Illuminate\Http\Response
     */
    public function download(Request $request){
        $fileId = $request->input('fileId');
        $file = File::find($fileId);
        $destinationPath = $file->destination_path;
        $fileName = $file->file_name;
        $filePath = $destinationPath . '/' . $fileName;

        $fileDownloadHistory = new FileDownloadHistory;
        $fileDownloadHistory->user_id = Auth::user()->id;
        $fileDownloadHistory->file_id = $file->id;
        $fileDownloadHistory->downloaded_at = Carbon::now();
        $fileDownloadHistory->save();
        return Response::download($filePath);
    }

    /**
     * Returns the list of students who downloaded the given file
     * 
     * @param File $file
     * @return array $list
     */
    public function viewDownloadHistory($file_id){
        $file = File::find($file_id);
        $list = FileDownloadHistory::where('file_id', $file->id)->orderBy('downloaded_at', 'desc')->get();
        return view('download-history', compact('file', 'list'));
    }
}
