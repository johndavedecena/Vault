<?php

class IPLog extends Eloquent{
	
	protected $table = "tbl_ip_logs";
	public $timestamps = false;
	
	public function ip(){
		return $this->belongsTo("IP","ip_id","id"); 
	}
	
	public function user(){
		return $this->belongsTo("User","user_id","id");
	}
}