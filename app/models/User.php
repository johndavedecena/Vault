<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {
	
	use UserTrait, RemindableTrait;
	
	protected $table = 'tbl_user_accounts';
	protected $hidden = array('password', 'remember_token');
	public $timestamps = false;

	public function getRememberToken(){
		return $this->remember_token;
	}
	
	public function setRememberToken($value){
		$this->remember_token = $value;
	}
	
	public function getRememberTokenName(){
		return 'remember_token';
	}

	public function userlogs(){
		return $this->hasMany("UserLog","user_id","id");
	}
	
	public function assetlogs(){
		return $this->hasMany("AssetLog","user_id","id");
	}
	
	public function softwareLogs(){
		return $this->hasMany("SoftwareLog","user_id","id");
	}
}
