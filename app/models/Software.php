<?php

class Software extends Eloquent{

	protected $table = "tbl_software_assets";
	public $timestamps = false;

	public function type(){
		return $this->belongsTo("SoftwareType","software_type_id","id");
	}

	public function employee(){
		return $this->belongsTo("Employee","employee_number","employee_number");
	}

	public function logs(){
		return $this->hasMay("SoftwareLog","software_id","id");
	}

}