<?php

class IP extends Eloquent{
	
	protected $table = "tbl_ip_assets";
	public $timestamps = false;
	
	public function employee(){
		return $this->belongsTo("Employee","requestor","employee_number");
	}
	
	public function unit(){
		return $this->belongsTo("Unit","team","id");
	}
	
	/*public function logs(){
		return $this->hasMay(IPLog","ip_id","ip_id");
	}*/
	
}