<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\FileRequest;
use App\Http\Controllers\Controller;
use App\Models\File;
use Auth;
use Response;
use Carbon\Carbon;

class FilesController extends Controller
{
    /**
     * A function that is called whenever executing an upload command
     *
     * @param \Illuminate\Http\Request  $request
     * @return Illuminate\Http\Response
     */
    public function download(Request $request){
        $destinationPath = $request->input('destinationPath');
        $fileName = $request->input('fileName');
        $filePath = $destinationPath . '/' . $fileName;

        return Response::download($filePath);
    }

    public function viewDownloadHistory(File $file){

    }
}
