<?php

class LogsController extends BaseController{
	
	public function __construct(){
	
		if(Session::has('username')){
			date_default_timezone_set("Asia/Manila");
	
			$user = User::where('username','=',Session::get("username"))->first();
			if(!$user){
				Session::flush();
				return Redirect::to("/");
			}
	
			Session::put('user_id',$user->id);
			Session::put('username',$user->username);
			Session::put('first_name',$user->first_name);
			Session::put('last_name',$user->last_name);
			Session::put('user_type',$user->user_type);
			
		}
	}
	
	public function systemLogs(){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin" || Session::get("user_type")=="User")){

			$view = View::make("Logs.system_logs");
			$view->nav="system";
			$view->tab="system";
			
			if(Session::get("user_type")=="User"){
				$userLogs = UserLog::where("type","=","Employees")->orderBy("datetime","desc")->paginate(25);
				$logsCount = UserLog::where("type","=","Employees")->count();
			}
			
			else{
				$userLogs = UserLog::orderBy("datetime","desc")->paginate(25);
				$logsCount = UserLog::all()->count();
			}
			
			
			$view->userLogs = $userLogs;
			$view->logsCount = $logsCount;
			return $view;
		}
		
		else{
			return Redirect::to("/");
		}
		
	}
	
	public function filterSystemLogs(){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin" || Session::get("user_type")=="User")){
			
			$view = View::make("Logs.system_logs");
			$view->nav="system";
			$view->tab="system";
			
			$input = Input::all();
			
			$username = trim($input["username"]);
			$start_date = trim($input["start_date"]);
			$end_date = trim($input["end_date"]);
			
			$type = isset($input["type"]) ? $input["type"] : null;
			
			$validator = Validator::make(
						
						array(
							"username"=>$username,
							"start date"=>$start_date,
							"end date"=>$end_date
						),
						array(
							"username"=>"exists:tbl_user_accounts,username",
							"start date"=>"date|required_with:end date",
							"end date"=>"date"
						)
							
					);
			
			if($validator->fails()){
				Input::flash();
				return Redirect::to("logs/system")->with('message',$validator->messages()->first());
			}
			
			else if(empty($username) && empty($start_date) && empty($end_date) && empty($type)){
				return Redirect::to("logs/system");
			}
			
			else{
				
				$userLogs = UserLog::where(function($query) use($username){
								if(!empty($username)){  
									$query->whereHas("user", function($q) use($username){
										$q->where("username","=",$username);
									});
								}
							})
							->where(function($query) use($start_date,$end_date){
								
								if(!empty($start_date)){
									if(!empty($end_date)){
										$query->whereBetween("datetime",array($start_date,$end_date." 23:59:59"));
									}
										
									else{
										$query->where("datetime","LIKE","$start_date%");
									}
								}
						
							})
							->where(function($query) use($type){
								if(!empty($type)){
									
									if(Session::get("user_type")=="User"){
										$query->where("type","=","Employees");
									}
									
									else{
										$query->where("type","=",$type);
									}
								}
								
								else{
									if(Session::get("user_type")=="User"){
										$query->where("type","=","Employees");
									}
								}
							})
							
							->orderBy("datetime","desc")
							->paginate(25);
				
				
				$logsCount = UserLog::where(function($query) use($username){
								if(!empty($username)){  
									$query->whereHas("user", function($q) use($username){
										$q->where("username","=",$username);
									});
								}
							})
							->where(function($query) use($start_date,$end_date){
								
								if(!empty($start_date)){
									if(!empty($end_date)){
										$query->whereBetween("datetime",array($start_date,$end_date." 23:59:59"));
									}
										
									else{
										$query->where("datetime","LIKE","$start_date%");
									}
								}
						
							})
							->where(function($query) use($type){
								if(!empty($type)){
									
									if(Session::get("user_type")=="User"){
										$query->where("type","=","Employees");
									}
									
									else{
										$query->where("type","=",$type);
									}
								}
								
								else{
									if(Session::get("user_type")=="User"){
										$query->where("type","=","Employees");
									}
								}
							})
							->count();
				
				$view->userLogs = $userLogs;
				$view->logsCount = $logsCount;
				
				Input::flash();
				return $view;
			}
			
		}
		
		else{
			return Redirect::to("/");
		}
	}
	
	public function assetsLogs(){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin" || Session::get("user_type")=="User")){
			
				$view = View::make("Logs.assets_logs");
				$view->nav="system";
				$view->tab="assets";
				
				$assetsLogs = AssetLog::orderBy("datetime","desc")->paginate(25);
				$logsCount = AssetLog::all()->count();
					
				$view->assetsLogs = $assetsLogs;
				$view->logsCount = $logsCount;
				$view->q = $logsCount;
				return $view;
		}

		else{
			return Redirect::to("/");
		}
	}
	
	public function filterAssetsLogs(){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin" || Session::get("user_type")=="User")){
			
			$view = View::make("Logs.assets_logs");
			$view->nav="system";
			$view->tab="assets";
				
			$input = Input::all();
				
			$username = trim($input["username"]);
			$start_date = trim($input["start_date"]);
			$end_date = trim($input["end_date"]);
			$asset = trim($input["asset"]);
			$validator = Validator::make(
			
					array(
							"username"=>$username,
							"start date"=>$start_date,
							"end date"=>$end_date
					),
					array(
							"username"=>"exists:tbl_user_accounts,username",
							"start date"=>"date|required_with:end date",
							"end date"=>"date"
					)
						
			);
				
			if($validator->fails()){
				Input::flash();
				return Redirect::to("logs/assets")->with('message',$validator->messages()->first());
			}
				
			else if(empty($username) && empty($start_date) && empty($end_date) && empty($asset)){
				return Redirect::to("logs/assets");
			}
				
			else{
				
				if(isset($_GET["export"])){
					
					$assetLogs = AssetLog::where(function($query) use($username){
						if(!empty($username)){
							$query->whereHas("user", function($q) use($username){
								$q->where("username","=",$username);
							});
						}
					})
					->where(function($query) use($start_date,$end_date){
							
						if(!empty($start_date)){
							if(!empty($end_date)){
								$query->whereBetween("datetime",array($start_date,$end_date." 23:59:59"));
							}
					
							else{
								$query->where("datetime","LIKE","$start_date%");
							}
						}
							
					})
					->where(function($query) use($asset){
						if(!empty($asset)){
							$query->whereHas("asset",function($q) use($asset){
								$q->where("classification_id","=",$asset);
							});
						}
					})
					->orderBy("datetime","desc")
					->get();
					
					
					$logsCount = $assetLogs->count();
						
					
					Input::flash();
					
					if($assetLogs->count()>0){
					
						$assetLogsArray = array();
						foreach($assetLogs as $a){
							$assetLogsArray[$a->id] = array(
									"Username"=>$a->user->username,
									"Description"=>strip_tags($a->description),
									"Date/Time"=>DateTime::createFromFormat("Y-m-d H:i:s", $a->datetime)->format("F d, Y g:iA")
							);
						}
							
						Excel::create('asset_logs_export_'.str_random(6), function($excel) use($assetLogsArray) {
					
							// Set the title
							$excel->setTitle('Asset Logs Export');
					
							// Chain the setters
							$excel->setCreator('Vault')
							->setCompany('Vault');
					
							// Call them separately
							$excel->setDescription('Asset Logs Data Export from IT Vault.');
					
							// Our first sheet
							$excel->sheet('Assets Logs', function($sheet) use($assetLogsArray) {
								$sheet->fromArray(
										$assetLogsArray
								);
							});
									
						})->download('xlsx');
					}
						
					else{
						Input::flash();
						return Redirect::to('export/client')->with('info', "No records have been retrieved. Data export cancelled.");
					}
					
				}
				
				else if(isset($_GET["filter"])){
					
					$assetsLogs = AssetLog::where(function($query) use($username){
						if(!empty($username)){
							$query->whereHas("user", function($q) use($username){
								$q->where("username","=",$username);
							});
						}
					})
					->where(function($query) use($start_date,$end_date){
							
						if(!empty($start_date)){
							if(!empty($end_date)){
								$query->whereBetween("datetime",array($start_date,$end_date." 23:59:59"));
							}
								
							else{
								$query->where("datetime","LIKE","$start_date%");
							}
						}
							
					})
					->where(function($query) use($asset){
						if(!empty($asset)){
							$query->whereHas("asset",function($q) use($asset){
								$q->where("classification_id","=",$asset);
							});
						}
					})
					->orderBy("datetime","desc")
					->paginate(25);
						
						
					$logsCount = $assetsLogs->count();
					
					$view->assetsLogs = $assetsLogs;
					$view->logsCount = $logsCount;
					$view->q = $logsCount;
					Input::flash();
					
				}
			
				return $view;
			}
		}
		
		else{
			return Redirect::to("/");
		}
	
	}
	
	public function softwareAssetsLogs(){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin" || Session::get("user_type")=="User")){
		
				$view = View::make("Logs.software_logs");
				$view->nav="system";
				$view->tab="software";
				
				$softwareAssetsLogs = SoftwareLog::orderBy("datetime","desc")->paginate(25);
				$logsCount = SoftwareLog::all()->count();
					
				$view->softwareAssetsLogs = $softwareAssetsLogs;
				$view->logsCount = $logsCount;
				
				return $view;
		}
		
		else{
			return Redirect::to("/");
		}
		
	}
	
	public function filterSoftwareAssetsLogs(){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin" || Session::get("user_type")=="User")){
				
			$view = View::make("Logs.software_logs");
			$view->nav="system";
			$view->tab="software";
		
			$input = Input::all();
		
			$username = trim($input["username"]);
			$start_date = trim($input["start_date"]);
			$end_date = trim($input["end_date"]);
		
			$validator = Validator::make(
						
					array(
							"username"=>$username,
							"start date"=>$start_date,
							"end date"=>$end_date
					),
					array(
							"username"=>"exists:tbl_user_accounts,username",
							"start date"=>"date|required_with:end date",
							"end date"=>"date"
					)
		
			);
		
			if($validator->fails()){
				Input::flash();
				return Redirect::to("logs/softwareassets")->with('message',$validator->messages()->first());
			}
		
			else if(empty($username) && empty($start_date) && empty($end_date) && empty($type)){
				return Redirect::to("logs/softwareassets");
			}
		
			else{
					
				$softwareAssetsLogs = SoftwareLog::where(function($query) use($username){
					if(!empty($username)){
						$query->whereHas("user", function($q) use($username){
							$q->where("username","=",$username);
						});
					}
				})
				->where(function($query) use($start_date,$end_date){
						
					if(!empty($start_date)){
						if(!empty($end_date)){
							$query->whereBetween("datetime",array($start_date,$end_date." 23:59:59"));
						}
							
						else{
							$query->where("datetime","LIKE","$start_date%");
						}
					}
						
				})
				->orderBy("datetime","desc")
				->paginate(25);
					
					
				$logsCount = SoftwareLog::where(function($query) use($username){
					if(!empty($username)){
						$query->whereHas("user", function($q) use($username){
							$q->where("username","=",$username);
						});
					}
				})
				->where(function($query) use($start_date,$end_date){
						
					if(!empty($start_date)){
						if(!empty($end_date)){
							$query->whereBetween("datetime",array($start_date,$end_date." 23:59:59"));
						}
							
						else{
							$query->where("datetime","LIKE","$start_date%");
						}
					}
						
				})
				->count();
					
				$view->softwareAssetsLogs = $softwareAssetsLogs;
				$view->logsCount = $logsCount;
					
				Input::flash();
				return $view;
			}
		}
		
		else{
			return Redirect::to("/");
		}
		
	}
	
	public function IPAssetsLogs(){
	
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin" || Session::get("user_type")=="User")){
	
			$view = View::make("Logs.ip_logs");
			$view->nav="system";
			$view->tab="ip";
	
			$IPAssetsLogs = IPLog::orderBy("datetime","desc")->paginate(25);
			$logsCount = IPLog::all()->count();
				
			$view->IPAssetsLogs = $IPAssetsLogs;
			$view->logsCount = $logsCount;
	
			return $view;
		}
	
		else{
			return Redirect::to("/");
		}
	
	}
	
	public function filterIPAssetsLogs(){
	
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin" || Session::get("user_type")=="User")){
	
			$view = View::make("Logs.ip_logs");
			$view->nav="system";
			$view->tab="ip";
	
			$input = Input::all();
	
			$username = trim($input["username"]);
			$start_date = trim($input["start_date"]);
			$end_date = trim($input["end_date"]);
	
			$validator = Validator::make(
	
					array(
							"username"=>$username,
							"start date"=>$start_date,
							"end date"=>$end_date
					),
					array(
							"username"=>"exists:tbl_user_accounts,username",
							"start date"=>"date|required_with:end date",
							"end date"=>"date"
					)
	
			);
	
			if($validator->fails()){
				Input::flash();
				return Redirect::to("logs/ipassets")->with('message',$validator->messages()->first());
			}
	
			else if(empty($username) && empty($start_date) && empty($end_date) && empty($type)){
				return Redirect::to("logs/ipassets");
			}
	
			else{
					
				$IPAssetsLogs = IPLog::where(function($query) use($username){
					if(!empty($username)){
						$query->whereHas("user", function($q) use($username){
							$q->where("username","=",$username);
						});
					}
				})
				->where(function($query) use($start_date,$end_date){
	
					if(!empty($start_date)){
						if(!empty($end_date)){
							$query->whereBetween("datetime",array($start_date,$end_date." 23:59:59"));
						}
							
						else{
							$query->where("datetime","LIKE","$start_date%");
						}
					}
	
				})
				->orderBy("datetime","desc")
				->paginate(25);
					
					
				$logsCount = IPLog::where(function($query) use($username){
					if(!empty($username)){
						$query->whereHas("user", function($q) use($username){
							$q->where("username","=",$username);
						});
					}
				})
				->where(function($query) use($start_date,$end_date){
	
					if(!empty($start_date)){
						if(!empty($end_date)){
							$query->whereBetween("datetime",array($start_date,$end_date." 23:59:59"));
						}
							
						else{
							$query->where("datetime","LIKE","$start_date%");
						}
					}
	
				})
				->count();
					
				$view->IPAssetsLogs = $IPAssetsLogs;
				$view->logsCount = $logsCount;
					
				Input::flash();
				return $view;
			}
		}
	
		else{
			return Redirect::to("/");
		}
	
	}
}