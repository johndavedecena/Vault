<?php

class Remark extends Eloquent{
	
	protected $table = "tbl_asset_remarks";
	public $timestamps = false;
	
	public function asset(){
		return $this->belongsTo("Asset","asset_id","id");
	}
	
	public function part(){
		return $this->belongsTo("AssetPart","part_id","id");
	}
	
}