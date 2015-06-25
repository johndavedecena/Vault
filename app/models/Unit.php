<?php

class Unit extends Eloquent{

	protected $table = "tbl_units";
	public $timestamps = false;
	
	public function employees(){
		return $this->hasMany("Employee","unit_id","id");
	}
	
	public function businessline(){
		return $this->belongsTo("BusinessLine","businessline_id","id");
	}
	
}