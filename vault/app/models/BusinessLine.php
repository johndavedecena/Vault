<?php

class BusinessLine extends Eloquent{

	protected $table = "tbl_business_lines";
	public $timestamps = false;
	
	public function employees(){
		return $this->hasMany("Employee","business_line_id","id");
	}
	
	public function units(){
		return $this->hasMany("Unit","businessline_id","id");
	}
}