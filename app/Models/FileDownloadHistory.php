<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class FileDownloadHistory extends Model
{
    protected $fillable = [
		'user_id',
		'downloaded_at',
	];

	protected $table = 'file_download_history';
	public $timestamps = false;

    public function file(){
		return $this->belongsTo('App\Models\File');
	}

	public function getUser(){
		return DB::table('users')->where('id', $this->user_id)->first();
	}
}
