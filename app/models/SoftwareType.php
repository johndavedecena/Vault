<?php

class SoftwareType extends Eloquent{
	
	protected $table = "tbl_software_types";
	public $timestamps = false;
	
	public function softwareassets(){
		return $this->hasMany("Software","software_type_id","id");
	}
}