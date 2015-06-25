<?php

class Employee extends Eloquent{
	
	protected $table = "tbl_employees";
	public $timestamps = false;
	
	public function manager(){
		return $this->belongsTo("Manager","manager_id","id");
	}
	
	public function unit(){
		return $this->belongsTo("Unit","unit_id","id");
	}
	
	public function businessline(){
		return $this->belongsTo("BusinessLine","business_line_id","id");
	}
	
	public function assets(){
		return $this->hasMany("Asset","employee_number","employee_number");
	}
	
	public function assetlogs(){
		return $this->hasMany("AssetLog","asset_id","id");
	}
	
	public function softwareassets(){
		return $this->hasMany("Software","employee_number","employee_number");
	}
	
}