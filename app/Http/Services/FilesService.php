<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\FileRequest;
use App\Models\File;
use Auth;
use Response;

class FilesService
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

    public function upload(array $files, $destinationPath){
        $file_ids = [];
        foreach($files as $file) {            
            $fileName = $file->getClientOriginalName();
            $file->move($destinationPath, $fileName);
        
            $fileDAO = new File;
            $fileDAO->user_id = Auth::user()->id;
            $fileDAO->destination_path = $destinationPath;
            $fileDAO->file_name = $fileName;
            $fileDAO->save();
        
            $file_ids[] = $fileDAO->id;
        }
        return $file_ids;
    }
}
