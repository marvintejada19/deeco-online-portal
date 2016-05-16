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
     * Request a file upload and create records in the database
     *
     * @param array $files
     * @param $destinationPath
     * @return array $file_ids;
     */
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
