<?php

class Model extends Eloquent{
	
	public $timestamps = false;
	protected $table = "tbl_asset_models";
	
	public function assets(){
		return $this->hasMany("Asset","model_id","id");
	}
	
	public function classification(){
		return $this->belongsTo("AssetClassification","classification_id","id");
	}
	
}