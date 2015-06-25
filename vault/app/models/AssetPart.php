<?php

class AssetPart extends Eloquent{
	
	protected $table = "tbl_asset_parts";
	public $timestamps = false;
	
	public function remarks(){
		return $this->hasMany("Remark","part_id","id");
	}
	
}