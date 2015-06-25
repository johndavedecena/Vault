<?php

class SoftwareLog extends Eloquent{
	
	protected $table = "tbl_software_logs";
	public $timestamps = false;
	
	public function software(){
		return $this->belongsTo("Software","software_id","id"); 
	}
	
	public function user(){
		return $this->belongsTo("User","user_id","id");
	}
}