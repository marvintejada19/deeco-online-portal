<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class FilesController extends Controller
{
    /**
	 * A function that is called whenever executing a download command
	 *
	 * @param string $file_path
	 * @param string $file_name
	 * @return Illuminate\Http\Response
     */
    public function download($file_path, $file_name){
    	$file_path = public_path('files/'.$file_name);
    	return response()->download($file_path);
    }

    /**
     * A function that is called whenever executing an upload command
     *
     * @param \Illuminate\Http\Request  $request
     * @return Illuminate\Http\Response
     */
    public function upload(Request $request){
        $destinationPath = 'uploads';
        foreach($request->file('files') as $file){
            //$extension = $file->getClientOriginalExtension();
            //$fileName = $request->input('file_name') . '.' . $extension;
            $fileName = $file->getClientOriginalName();
            dd($fileName);
            $file->move($destinationPath, $fileName);
            dd('finished uploading');
        }
        // Session::flash('success', 'Upload successfully'); 
        // return Redirect::to('upload');
    }
}
