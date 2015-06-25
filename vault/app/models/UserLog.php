<?php

class UserLog extends Eloquent{

	protected $table = "tbl_user_logs";
	public $timestamps = false;
	
	public function user(){
		return $this->belongsTo("User","user_id","id");
	}
	
	
}