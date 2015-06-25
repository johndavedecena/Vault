<?php

class Asset extends Eloquent{
	
	protected $table = "tbl_assets";
	public $timestamps = false;
	
	public function classification(){
		return $this->belongsTo('AssetClassification',"classification_id","id");
	}
	
	public function employee(){
		return $this->belongsTo("Employee","employee_number","employee_number");
	}
	
	public function model(){
		return $this->belongsTo("Model","model_id","id");
	}
	
	public function assetlogs(){
		return $this->hasMany("AssetLog","asset_id","id");
	}
	
	public function remarks(){
		return $this->hasMany("Remark","asset_id","id");
	}
	
}