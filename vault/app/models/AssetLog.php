<?php

class AssetLog extends Eloquent{
	
	public $timestamps = false;
	protected $table = "tbl_asset_logs";
	
	public function asset(){
		return $this->belongsTo("Asset","asset_id","id");
	}
	
	public function employee(){
		return $this->belongsTo("Employee","employee_id","id");
	}
	
	public function user(){
		return $this->belongsTo("User","user_id","id");
	}
	
	
}