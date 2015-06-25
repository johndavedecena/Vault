<?php

class Manager extends Eloquent{

	protected $table = "tbl_managers";
	public $timestamps = false;
	
	public function employees(){
		return $this->hasMany("Employee","manager_id","id");
	}
	
}