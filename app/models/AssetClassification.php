<?php


class AssetClassification extends Eloquent{
	
	protected $table = "tbl_asset_classifications";
	public $timestamps = false;
	
	public function assets(){
		return $this->hasMany('Asset','classification_id','id');
	}
	
	public function models(){
		return $this->hasMany("Model","classification_id","id");
	}
	
}