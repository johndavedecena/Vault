<?php

class ExportController extends BaseController{
	
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
	
	public function exportClient(){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
		
			$view = View::make("Export.export_client");
			$view->nav = "system";
			$view->tab = "client";
			$view->assets = Asset::whereHas("classification",function($query){
						$query->where("type","=","Client");
					})->orderBy("asset_tag")->paginate(25);
			
			$view->results = Asset::whereHas("classification",function($query){
						$query->where("type","=","Client");
					})->count();
		
			$getAssetClassifications = AssetClassification::where("type","=","Client")->get();
			$assetClassifications = array(""=>"All");
				
			foreach($getAssetClassifications as $gac){
				$assetClassifications[$gac->id]=$gac->name;
			}
		
			$view->assetClassifications = $assetClassifications;
		
			$getAssetModels = Model::whereHas('classification', function ($query){
				$query->where("type","=","Client");
			})->orderBy("name","asc")->get();
		
			$assetModels = array(""=>"--Select One--");
				
			foreach($getAssetModels as $gam){
				$assetModels[$gam->id] = $gam->name;
			}
		
			$view->assetModels = $assetModels;
				
			return $view;
		}
			
		else{
			return Redirect::to("/");
		}
		
	}
	
	public function exportClientBegin(){
	
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
	 		
			if(isset($_GET['search'])){
				
				$view = View::make("Export.export_client");
				$view->nav = "system";
				$view->tab = "client";
				
				$input = Input::all();
				 
				$asset_tag = trim($input["asset_tag"])!=null ? str_replace(' ', '%', trim($input["asset_tag"])) : "";
				$serial_number = trim($input["serial_number"])!=null ? str_replace(' ', '%', trim($input["serial_number"])) : "";
				$employee = trim($input["employee"])!=null ? trim($input["employee"]) : "";
				$classification_id = trim($input["classification_id"])!=null ? str_replace(' ', '%', trim($input["classification_id"])) : "";
				$asset_status = !empty($input["asset_status"]) ? $input["asset_status"] : "";
				$model = !empty($input["model"]) ? $input["model"] : "";
				$warranty_start = trim($input["warranty_start"])!=null ? str_replace(' ', '%', trim($input["warranty_start"])) : "";
				$warranty_end = trim($input["warranty_end"])!=null ? str_replace(' ', '%', trim($input["warranty_end"])) : "";
				$employee_status = trim($input["employee_status"])!=null ? str_replace(' ', '%', trim($input["employee_status"])) : "";
				 
				 
				$assets = Asset::where("asset_tag","LIKE","%$asset_tag%")
						->whereHas("classification",function ($query){
							$query->where("type","=","Client");
						})
						->where(function($query) use($serial_number){
							if(!empty($serial_number)){
								$query->where("serial_number","LIKE",$serial_number);
							}
						})
						->where(function($query) use($employee){
								
							$emp = "%".str_replace(' ', '%', $employee)."%";
							$emp = DB::connection()->getPdo()->quote($emp);
								
							if(!empty($employee)){
								$query->where("employee_number","LIKE",$employee)
								->orWhereHas("employee",function($q) use($employee,$emp){
									$q->whereRaw("concat(first_name,' ',last_name) LIKE $emp");
								})
								->orWhereHas("employee",function($q) use($employee,$emp){
									$q->whereRaw("concat(last_name,' ',first_name) LIKE $emp");
								});
							}
						})
						->where(function($query) use($classification_id){
							if(!empty($classification_id)){
								$query->where("classification_id","LIKE","$classification_id");
							}
						})
						->where(function($query) use($asset_status){
							if(!empty($asset_status)){
								$query->where("status","=","$asset_status");
							}
						})
						->where(function($query) use($model){
							if(!empty($model)){
								$query->where("model_id","=",$model);
							}
						})
						->where(function($query) use($warranty_start){
							if(!empty($warranty_start)){
								$query->where("warranty_start","LIKE","$warranty_start%");
							}
						})
						->where(function($query) use($warranty_end){
							if(!empty($warranty_end)){
								$query->where("warranty_end","LIKE","$warranty_end%");
							}
						})
						->where(function($query) use($employee_status){
							if(!empty($employee_status)){
								$query->whereHas("employee",function($q) use($employee_status){
									$q->where("status","LIKE","%$employee_status%");
								});
							}
						})
						->orderBy("asset_tag","asc")
						->paginate(25);
				
				$results = Asset::where("asset_tag","LIKE","%$asset_tag%")
						->whereHas("classification",function ($query){
							$query->where("type","=","Client");
						})
						->where(function($query) use($serial_number){
							if(!empty($serial_number)){
								$query->where("serial_number","LIKE",$serial_number);
							}
						})
						->where(function($query) use($employee){
								
							$emp = "%".str_replace(' ', '%', $employee)."%";
							$emp = DB::connection()->getPdo()->quote($emp);
								
							if(!empty($employee)){
								$query->where("employee_number","LIKE",$employee)
								->orWhereHas("employee",function($q) use($employee,$emp){
									$q->whereRaw("concat(first_name,' ',last_name) LIKE $emp");
								})
								->orWhereHas("employee",function($q) use($employee,$emp){
									$q->whereRaw("concat(last_name,' ',first_name) LIKE $emp");
								});
							}
						})
						->where(function($query) use($classification_id){
							if(!empty($classification_id)){
								$query->where("classification_id","LIKE","$classification_id");
							}
						})
						->where(function($query) use($asset_status){
							if(!empty($asset_status)){
								$query->where("status","=","$asset_status");
							}
						})
						->where(function($query) use($model){
							if(!empty($model)){
								$query->where("model_id","=",$model);
							}
						})
						->where(function($query) use($warranty_start){
							if(!empty($warranty_start)){
								$query->where("warranty_start","LIKE","$warranty_start%");
							}
						})
						->where(function($query) use($warranty_end){
							if(!empty($warranty_end)){
								$query->where("warranty_end","LIKE","$warranty_end%");
							}
						})
						->where(function($query) use($employee_status){
							if(!empty($employee_status)){
								$query->whereHas("employee",function($q) use($employee_status){
									$q->where("status","LIKE","%$employee_status%");
								});
							}
						})
						->count();
				 
				$getAssetClassifications = AssetClassification::where("type","=","Client")->get();
				$assetClassifications = array(""=>"All");
				
				foreach($getAssetClassifications as $gac){
					$assetClassifications[$gac->id]=$gac->name;
				}
				 
				$getAssetModels = Model::whereHas('classification', function ($query){
					$query->where("type","=","Client");
				})->orderBy("name","asc")->get();
				 
				$assetModels = array(""=>"--Select One--");
				
				foreach($getAssetModels as $gam){
					$assetModels[$gam->id] = $gam->name;
				}
				 
				$view->assetModels = $assetModels;
				$view->assets = $assets;
				$view->results = $results;
				$view->assetClassifications = $assetClassifications;
				 
				Input::flash();
				return $view;
			}
			
	 		else if(isset($_GET["export"])){
	 			
	 			
	 			$input = Input::all();
	 				
	 			$asset_tag = trim($input["asset_tag"])!=null ? str_replace(' ', '%', trim($input["asset_tag"])) : "";
	 			$serial_number = trim($input["serial_number"])!=null ? str_replace(' ', '%', trim($input["serial_number"])) : "";
	 			$employee = trim($input["employee"])!=null ? trim($input["employee"]) : "";
	 			$classification_id = trim($input["classification_id"])!=null ? str_replace(' ', '%', trim($input["classification_id"])) : "";
	 			$asset_status = !empty($input["asset_status"]) ? $input["asset_status"] : "";
	 			$model = !empty($input["model"]) ? $input["model"] : "";
	 			$warranty_start = trim($input["warranty_start"])!=null ? str_replace(' ', '%', trim($input["warranty_start"])) : "";
	 			$warranty_end = trim($input["warranty_end"])!=null ? str_replace(' ', '%', trim($input["warranty_end"])) : "";
	 			$employee_status = trim($input["employee_status"])!=null ? str_replace(' ', '%', trim($input["employee_status"])) : "";
	 				
	 				
	 			$assets = Asset::where("asset_tag","LIKE","%$asset_tag%")
			 			->whereHas("classification",function ($query){
			 				$query->where("type","=","Client");
			 			})
			 			->where(function($query) use($serial_number){
			 				if(!empty($serial_number)){
			 					$query->where("serial_number","LIKE",$serial_number);
			 				}
			 			})
			 			->where(function($query) use($employee){
			 			
			 				$emp = "%".str_replace(' ', '%', $employee)."%";
			 				$emp = DB::connection()->getPdo()->quote($emp);
			 			
			 				if(!empty($employee)){
			 					$query->where("employee_number","LIKE",$employee)
			 					->orWhereHas("employee",function($q) use($employee,$emp){
			 						$q->whereRaw("concat(first_name,' ',last_name) LIKE $emp");
			 					})
			 					->orWhereHas("employee",function($q) use($employee,$emp){
			 						$q->whereRaw("concat(last_name,' ',first_name) LIKE $emp");
			 					});
			 				}
			 			})
			 			->where(function($query) use($classification_id){
			 				if(!empty($classification_id)){
			 					$query->where("classification_id","LIKE","$classification_id");
			 				}
			 			})
			 			->where(function($query) use($asset_status){
			 				if(!empty($asset_status)){
			 					$query->where("status","=","$asset_status");
			 				}
			 			})
			 			->where(function($query) use($model){
			 				if(!empty($model)){
			 					$query->where("model_id","=",$model);
			 				}
			 			})
			 			->where(function($query) use($warranty_start){
			 				if(!empty($warranty_start)){
			 					$query->where("warranty_start","LIKE","$warranty_start%");
			 				}
			 			})
			 			->where(function($query) use($warranty_end){
			 				if(!empty($warranty_end)){
			 					$query->where("warranty_end","LIKE","$warranty_end%");
			 				}
			 			})
			 			->where(function($query) use($employee_status){
			 				if(!empty($employee_status)){
			 					$query->whereHas("employee",function($q) use($employee_status){
			 						$q->where("status","LIKE","%$employee_status%");
			 					});
			 				}
			 			})
			 			->orderBy("asset_tag")->get();
	 			
	 			if($assets->count()>0){
	 				
	 				if(isset($_GET["format"])){
	 					$assetsArray = array();
	 					foreach($assets as $a){
	 						$assetsArray[$a->id] = array(
	 								"Asset Tag"=>$a->asset_tag,
	 								"Serial Number"=>$a->serial_number,
	 								"Employee"=>!empty($a->employee->first_name) ? $a->employee->first_name." ".$a->employee->last_name : "Unassigned.",
	 								"Employee Number"=>!empty($a->employee->employee_number) ? $a->employee->employee_number : null,
	 								"Model"=>!empty($a->model->name) ? $a->model->name : "No Information.",
	 								"Charger Serial Number"=>!empty($a->charger) ? $a->charger : null,
	 								"Notes"=>!empty($a->notes) ? $a->notes : null,
	 								"OS Image"=>!empty($a->image) ? $a->image : null,
	 								"RAM Upgrade"=>!empty($a->laptop_ram_upgrade) ? $a->laptop_ram_upgrade : null,
	 								"Location"=>!empty($a->location) ? $a->location : "No Information.",
	 								"Warranty Start Date"=>!empty($a->warranty_start) ? DateTime::createFromFormat("Y-m-d", $a->warranty_start)->format("F d, Y") : "No Information",
	 								"Warranty End Date"=>!empty($a->warranty_end) ? DateTime::createFromFormat("Y-m-d", $a->warranty_end)->format("F d, Y") : "No Information",
	 								"Date Added to System"=>DateTime::createFromFormat("Y-m-d H:i:s", $a->date_added)->format("F d, Y g:iA"),
	 								"Asset Type"=>$a->classification->name,
	 								"Status"=>$a->status,
	 								"x"=>strip_tags($a->assetlogs->first()->description)
	 						);
	 					}
	 				}
	 					
	 				else{
	 					$assetsArray = $assets->toArray();
	 				}
	 					
	 				Excel::create('client_assets_export_'.str_random(6), function($excel) use($assetsArray) {
	 				
	 					// Set the title
	 					$excel->setTitle('Client Assets Export');
	 				
	 					// Chain the setters
	 					$excel->setCreator('Vault')
	 					->setCompany('Vault');
	 				
	 					// Call them separately
	 					$excel->setDescription('Client Assets Data Export from IT Vault.');
	 				
	 					// Our first sheet
	 					$excel->sheet('Client Assets', function($sheet) use($assetsArray) {
	 						$sheet->fromArray(
	 								$assetsArray
	 						);
	 					});
	 							
	 				})->download('xlsx');
	 			}
	 			
	 			else{
	 				Input::flash();
	 				return Redirect::to('export/client')->with('info', "No records have been retrieved. Data export cancelled.");	
	 			}
	 		}	
 		}
	 			
 		else{
 			return Redirect::to("/");
 		}
	
	}
	
	public function exportNetwork(){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
		
			
			$view = View::make("Export.export_network");
			$view->nav = "system";
			$view->tab = "network";
			
			$view->assets =Asset::whereHas("classification",function($query){
 				$query->where("type","=","Network");
 			})->paginate(25);
 			
			$view->results = Asset::whereHas("classification",function($query){
 				$query->where("type","=","Network");
 			})->count();
	
			$getAssetClassifications = AssetClassification::where("type","=","Network")->get();
			$assetClassifications = array(""=>"All");
				
			foreach($getAssetClassifications as $gac){
				$assetClassifications[$gac->id]=$gac->name;
			}
	
			$view->assetClassifications = $assetClassifications;
	
			$getAssetModels = Model::whereHas('classification', function ($query){
				$query->where("type","=","Network");
			})->orderBy("name","asc")->get();
	
			$assetModels = array(""=>"--Select One--");
				
			foreach($getAssetModels as $gam){
				$assetModels[$gam->id] = $gam->name;
			}
	
			$view->assetModels = $assetModels;
	
			return $view;
		}
			
		else{
			return Redirect::to("/");
		}
	}
	
	public function exportNetworkBegin(){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
			
			if(isset($_GET["search"])){
			
				$view = View::make("Export.export_network");
				$view->nav = "system";
				$view->tab = "network";
				
				$input = Input::all();
				
				$asset_tag = trim($input["asset_tag"])!=null ? str_replace(' ', '%', trim($input["asset_tag"])) : "";
				$serial_number = trim($input["serial_number"])!=null ? str_replace(' ', '%', trim($input["serial_number"])) : "";
				$employee = trim($input["employee"])!=null ? trim($input["employee"]) : "";
				$classification_id = trim($input["classification_id"])!=null ? str_replace(' ', '%', trim($input["classification_id"])) : "";
				$asset_status = !empty($input["asset_status"]) ? $input["asset_status"] : "";
				$model = !empty($input["model"]) ? $input["model"] : "";
				$warranty_start = trim($input["warranty_start"])!=null ? str_replace(' ', '%', trim($input["warranty_start"])) : "";
				$warranty_end = trim($input["warranty_end"])!=null ? str_replace(' ', '%', trim($input["warranty_end"])) : "";
				
				
				$assets = Asset::where("asset_tag","LIKE","%$asset_tag%")
						->whereHas("classification",function ($query){
							$query->where("type","=","Network");
						})
						->where(function($query) use($serial_number){
							if(!empty($serial_number)){
								$query->where("serial_number","LIKE",$serial_number);
							}
						})
						->where(function($query) use($employee){
						
							$emp = "%".str_replace(' ', '%', $employee)."%";
							$emp = DB::connection()->getPdo()->quote($emp);
						
							if(!empty($employee)){
								$query->where("employee_number","LIKE",$employee)
								->orWhereHas("employee",function($q) use($employee,$emp){
									$q->whereRaw("concat(first_name,' ',last_name) LIKE $emp");
								})
								->orWhereHas("employee",function($q) use($employee,$emp){
									$q->whereRaw("concat(last_name,' ',first_name) LIKE $emp");
								});
							}
						})
						->where(function($query) use($classification_id){
							if(!empty($classification_id)){
								$query->where("classification_id","LIKE","$classification_id");
							}
						})
						->where(function($query) use($asset_status){
							if(!empty($asset_status)){
								$query->where("status","=","$asset_status");
							}
						})
						->where(function($query) use($model){
							if(!empty($model)){
								$query->where("model_id","=",$model);
							}
						})
						->where(function($query) use($warranty_start){
							if(!empty($warranty_start)){
								$query->where("warranty_start","LIKE","$warranty_start%");
							}
						})
						->where(function($query) use($warranty_end){
							if(!empty($warranty_end)){
								$query->where("warranty_end","LIKE","$warranty_end%");
							}
						})
						->orderBy("asset_tag","asc")
						->paginate(25);
				
				$results = Asset::where("asset_tag","LIKE","%$asset_tag%")
						->whereHas("classification",function ($query){
							$query->where("type","=","Network");
						})
						->where(function($query) use($serial_number){
							if(!empty($serial_number)){
								$query->where("serial_number","LIKE",$serial_number);
							}
						})
						->where(function($query) use($employee){
						
							$emp = "%".str_replace(' ', '%', $employee)."%";
							$emp = DB::connection()->getPdo()->quote($emp);
						
							if(!empty($employee)){
								$query->where("employee_number","LIKE",$employee)
								->orWhereHas("employee",function($q) use($employee,$emp){
									$q->whereRaw("concat(first_name,' ',last_name) LIKE $emp");
								})
								->orWhereHas("employee",function($q) use($employee,$emp){
									$q->whereRaw("concat(last_name,' ',first_name) LIKE $emp");
								});
							}
						})
						->where(function($query) use($classification_id){
							if(!empty($classification_id)){
								$query->where("classification_id","LIKE","$classification_id");
							}
						})
						->where(function($query) use($asset_status){
							if(!empty($asset_status)){
								$query->where("status","=","$asset_status");
							}
						})
						->where(function($query) use($model){
							if(!empty($model)){
								$query->where("model_id","=",$model);
							}
						})
						->where(function($query) use($warranty_start){
							if(!empty($warranty_start)){
								$query->where("warranty_start","LIKE","$warranty_start%");
							}
						})
						->where(function($query) use($warranty_end){
							if(!empty($warranty_end)){
								$query->where("warranty_end","LIKE","$warranty_end%");
							}
						})
						->count();
				
				$getAssetClassifications = AssetClassification::where("type","=","Network")->get();
				$assetClassifications = array(""=>"All");
				
				foreach($getAssetClassifications as $gac){
					$assetClassifications[$gac->id]=$gac->name;
				}
				
				$getAssetModels = Model::whereHas('classification', function ($query){
					$query->where("type","=","Network");
				})->orderBy("name","asc")->get();
				
				$assetModels = array(""=>"--Select One--");
				
				foreach($getAssetModels as $gam){
					$assetModels[$gam->id] = $gam->name;
				}
				
				$view->assetModels = $assetModels;
				$view->assets = $assets;
				$view->results = $results;
				$view->assetClassifications = $assetClassifications;
				Input::flash();
				return $view;
			}
			
			else if(isset($_GET["export"])){
				
				$input = Input::all();
				
				$asset_tag = trim($input["asset_tag"])!=null ? str_replace(' ', '%', trim($input["asset_tag"])) : "";
				$serial_number = trim($input["serial_number"])!=null ? str_replace(' ', '%', trim($input["serial_number"])) : "";
				$employee = trim($input["employee"])!=null ? trim($input["employee"]) : "";
				$classification_id = trim($input["classification_id"])!=null ? str_replace(' ', '%', trim($input["classification_id"])) : "";
				$asset_status = !empty($input["asset_status"]) ? $input["asset_status"] : "";
				$model = !empty($input["model"]) ? $input["model"] : "";
				$warranty_start = trim($input["warranty_start"])!=null ? str_replace(' ', '%', trim($input["warranty_start"])) : "";
				$warranty_end = trim($input["warranty_end"])!=null ? str_replace(' ', '%', trim($input["warranty_end"])) : "";
				
				
				$assets = Asset::where("asset_tag","LIKE","%$asset_tag%")
						->whereHas("classification",function ($query){
							$query->where("type","=","Network");
						})
						->where(function($query) use($serial_number){
							if(!empty($serial_number)){
								$query->where("serial_number","LIKE",$serial_number);
							}
						})
						->where(function($query) use($employee){
						
							$emp = "%".str_replace(' ', '%', $employee)."%";
							$emp = DB::connection()->getPdo()->quote($emp);
						
							if(!empty($employee)){
								$query->where("employee_number","LIKE",$employee)
								->orWhereHas("employee",function($q) use($employee,$emp){
									$q->whereRaw("concat(first_name,' ',last_name) LIKE $emp");
								})
								->orWhereHas("employee",function($q) use($employee,$emp){
									$q->whereRaw("concat(last_name,' ',first_name) LIKE $emp");
								});
							}
						})
						->where(function($query) use($classification_id){
							if(!empty($classification_id)){
								$query->where("classification_id","LIKE","$classification_id");
							}
						})
						->where(function($query) use($asset_status){
							if(!empty($asset_status)){
								$query->where("status","=","$asset_status");
							}
						})
						->where(function($query) use($model){
							if(!empty($model)){
								$query->where("model_id","=",$model);
							}
						})
						->where(function($query) use($warranty_start){
							if(!empty($warranty_start)){
								$query->where("warranty_start","LIKE","$warranty_start%");
							}
						})
						->where(function($query) use($warranty_end){
							if(!empty($warranty_end)){
								$query->where("warranty_end","LIKE","$warranty_end%");
							}
						})
						->orderBy("asset_tag")
						->get(array("id","asset_tag","serial_number","model_id","employee_number","warranty_start","warranty_end","notes","location","classification_id","date_added","status"));
				
				if($assets->count()>0){
					
					if(isset($_GET["format"])){
						$assetsArray = array();
						
						foreach($assets as $a){
							
							$assetsArray[$a->id] = array(
									"Asset Tag"=>$a->asset_tag,
									"Serial Number"=>$a->serial_number,
									"Employee"=>!empty($a->employee->first_name) ? $a->employee->first_name." ".$a->employee->last_name : "Unassigned.",
									"Employee Number"=>!empty($a->employee->employee_number) ? $a->employee->employee_number : null,
									"Model"=>!empty($a->model->name) ? $a->model->name : "No Information.",
									"Notes"=>!empty($a->notes) ? $a->notes : null,
									"Location"=>!empty($a->location) ? $a->location : "No Information.",
									"Warranty Start Date"=>!empty($a->warranty_start) ? DateTime::createFromFormat("Y-m-d", $a->warranty_start)->format("F d, Y") : "No Information",
									"Warranty End Date"=>!empty($a->warranty_end) ? DateTime::createFromFormat("Y-m-d", $a->warranty_end)->format("F d, Y") : "No Information",
									"Date Added to System"=>DateTime::createFromFormat("Y-m-d H:i:s", $a->date_added)->format("F d, Y g:iA"),
									"Asset Type"=>$a->classification->name,
									"Status"=>$a->status
							);
							
						}
						
					}
						
					else{
						$assetsArray = $assets->toArray();
					}
						
					Excel::create('network_assets_export_'.str_random(6), function($excel) use($assetsArray) {
				
						// Set the title
	 					$excel->setTitle('Network Assets Export');
	 				
	 					// Chain the setters
	 					$excel->setCreator('Vault')
	 					->setCompany('Vault');
	 				
	 					// Call them separately
	 					$excel->setDescription('Network Assets Data Export from IT Vault.');
	 				
	 					// Our first sheet
	 					$excel->sheet('Network Assets', function($sheet) use($assetsArray) {
	 						$sheet->fromArray(
	 								$assetsArray
	 						);
	 					});
								
					})->download('xlsx');
				}
				
				else{
					Input::flash();
					return Redirect::to('export/network')->with('info', "No records have been retrieved. Data export cancelled.");
				}
				
			}
		}
			
		else{
			return Redirect::to("/");
		}
		
	}
	
	public function exportOffice(){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
		
			$view = View::make("Export.export_office");
			$view->nav = "system";
			$view->tab = "office";
			
			$view->assets =Asset::whereHas("classification",function($query){
				$query->where("type","=","Office");
			})->paginate(25);
			
			$view->results = Asset::whereHas("classification",function($query){
				$query->where("type","=","Office");
			})->count();
		
			$getAssetClassifications = AssetClassification::where("type","=","Office")->get();
			$assetClassifications = array(""=>"All");
		
			foreach($getAssetClassifications as $gac){
				$assetClassifications[$gac->id]=$gac->name;
			}
		
			$view->assetClassifications = $assetClassifications;
		
			$getAssetModels = Model::whereHas('classification', function ($query){
				$query->where("type","=","Office");
			})->orderBy("name","asc")->get();
		
			$assetModels = array(""=>"--Select One--");
		
			foreach($getAssetModels as $gam){
				$assetModels[$gam->id] = $gam->name;
			}
		
			$view->assetModels = $assetModels;
		
			return $view;
		}
			
		else{
			return Redirect::to("/");
		}
		
	}
	
	public function exportOfficeBegin(){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
			
			if(isset($_GET["search"])){
				
				$view = View::make("Export.export_office");
				$view->nav="system";
				$view->tab = "office";
				
				$input = Input::all();
				
				$asset_tag = trim($input["asset_tag"])!=null ? str_replace(' ', '%', trim($input["asset_tag"])) : "";
				$serial_number = trim($input["serial_number"])!=null ? str_replace(' ', '%', trim($input["serial_number"])) : "";
				$employee = trim($input["employee"])!=null ? trim($input["employee"]) : "";
				$classification_id = trim($input["classification_id"])!=null ? str_replace(' ', '%', trim($input["classification_id"])) : "";
				$asset_status = !empty($input["asset_status"]) ? $input["asset_status"] : "";
				$model = !empty($input["model"]) ? $input["model"] : "";
				$warranty_start = trim($input["warranty_start"])!=null ? str_replace(' ', '%', trim($input["warranty_start"])) : "";
				$warranty_end = trim($input["warranty_end"])!=null ? str_replace(' ', '%', trim($input["warranty_end"])) : "";
				
				
				$assets = Asset::where("asset_tag","LIKE","%$asset_tag%")
				->whereHas("classification",function ($query){
					$query->where("type","=","Office");
				})
				->where(function($query) use($serial_number){
					if(!empty($serial_number)){
						$query->where("serial_number","LIKE",$serial_number);
					}
				})
				->where(function($query) use($employee){
				
					$emp = "%".str_replace(' ', '%', $employee)."%";
					$emp = DB::connection()->getPdo()->quote($emp);
				
					if(!empty($employee)){
						$query->where("employee_number","LIKE",$employee)
						->orWhereHas("employee",function($q) use($employee,$emp){
							$q->whereRaw("concat(first_name,' ',last_name) LIKE $emp");
						})
						->orWhereHas("employee",function($q) use($employee,$emp){
							$q->whereRaw("concat(last_name,' ',first_name) LIKE $emp");
						});
					}
				})
				->where(function($query) use($classification_id){
					if(!empty($classification_id)){
						$query->where("classification_id","LIKE","$classification_id");
					}
				})
				->where(function($query) use($asset_status){
					if(!empty($asset_status)){
						$query->where("status","=","$asset_status");
					}
				})
				->where(function($query) use($model){
					if(!empty($model)){
						$query->where("model_id","=",$model);
					}
				})
				->where(function($query) use($warranty_start){
					if(!empty($warranty_start)){
						$query->where("warranty_start","LIKE","$warranty_start%");
					}
				})
				->where(function($query) use($warranty_end){
					if(!empty($warranty_end)){
						$query->where("warranty_end","LIKE","$warranty_end%");
					}
				})
				->orderBy("asset_tag","asc")
				->paginate(25);
				
				$results = Asset::where("asset_tag","LIKE","%$asset_tag%")
				->whereHas("classification",function ($query){
					$query->where("type","=","Office");
				})
				->where(function($query) use($serial_number){
					if(!empty($serial_number)){
						$query->where("serial_number","LIKE",$serial_number);
					}
				})
				->where(function($query) use($employee){
				
					$emp = "%".str_replace(' ', '%', $employee)."%";
					$emp = DB::connection()->getPdo()->quote($emp);
				
					if(!empty($employee)){
						$query->where("employee_number","LIKE",$employee)
						->orWhereHas("employee",function($q) use($employee,$emp){
							$q->whereRaw("concat(first_name,' ',last_name) LIKE $emp");
						})
						->orWhereHas("employee",function($q) use($employee,$emp){
							$q->whereRaw("concat(last_name,' ',first_name) LIKE $emp");
						});
					}
				})
				->where(function($query) use($classification_id){
					if(!empty($classification_id)){
						$query->where("classification_id","LIKE","$classification_id");
					}
				})
				->where(function($query) use($asset_status){
					if(!empty($asset_status)){
						$query->where("status","=","$asset_status");
					}
				})
				->where(function($query) use($model){
					if(!empty($model)){
						$query->where("model_id","=",$model);
					}
				})
				->where(function($query) use($warranty_start){
					if(!empty($warranty_start)){
						$query->where("warranty_start","LIKE","$warranty_start%");
					}
				})
				->where(function($query) use($warranty_end){
					if(!empty($warranty_end)){
						$query->where("warranty_end","LIKE","$warranty_end%");
					}
				})
				->count();
				
				$getAssetClassifications = AssetClassification::where("type","=","Office")->get();
				$assetClassifications = array(""=>"All");
				
				foreach($getAssetClassifications as $gac){
					$assetClassifications[$gac->id]=$gac->name;
				}
				
				$getAssetModels = Model::whereHas('classification', function ($query){
					$query->where("type","=","Office");
				})->orderBy("name","asc")->get();
				
				$assetModels = array(""=>"--Select One--");
				
				foreach($getAssetModels as $gam){
					$assetModels[$gam->id] = $gam->name;
				}
				
				$view->assetModels = $assetModels;
				$view->assets = $assets;
				$view->results = $results;
				$view->assetClassifications = $assetClassifications;
				Input::flash();
				return $view;
				
			}
			
			else if(isset($_GET["export"])){

				$input = Input::all();
				
				$asset_tag = trim($input["asset_tag"])!=null ? str_replace(' ', '%', trim($input["asset_tag"])) : "";
				$serial_number = trim($input["serial_number"])!=null ? str_replace(' ', '%', trim($input["serial_number"])) : "";
				$employee = trim($input["employee"])!=null ? trim($input["employee"]) : "";
				$classification_id = trim($input["classification_id"])!=null ? str_replace(' ', '%', trim($input["classification_id"])) : "";
				$asset_status = !empty($input["asset_status"]) ? $input["asset_status"] : "";
				$model = !empty($input["model"]) ? $input["model"] : "";
				$warranty_start = trim($input["warranty_start"])!=null ? str_replace(' ', '%', trim($input["warranty_start"])) : "";
				$warranty_end = trim($input["warranty_end"])!=null ? str_replace(' ', '%', trim($input["warranty_end"])) : "";
				
				
				$assets = Asset::where("asset_tag","LIKE","%$asset_tag%")
						->whereHas("classification",function ($query){
							$query->where("type","=","Office");
						})
						->where(function($query) use($serial_number){
							if(!empty($serial_number)){
								$query->where("serial_number","LIKE",$serial_number);
							}
						})
						->where(function($query) use($employee){
						
							$emp = "%".str_replace(' ', '%', $employee)."%";
							$emp = DB::connection()->getPdo()->quote($emp);
						
							if(!empty($employee)){
								$query->where("employee_number","LIKE",$employee)
								->orWhereHas("employee",function($q) use($employee,$emp){
									$q->whereRaw("concat(first_name,' ',last_name) LIKE $emp");
								})
								->orWhereHas("employee",function($q) use($employee,$emp){
									$q->whereRaw("concat(last_name,' ',first_name) LIKE $emp");
								});
							}
						})
						->where(function($query) use($classification_id){
							if(!empty($classification_id)){
								$query->where("classification_id","LIKE","$classification_id");
							}
						})
						->where(function($query) use($asset_status){
							if(!empty($asset_status)){
								$query->where("status","=","$asset_status");
							}
						})
						->where(function($query) use($model){
							if(!empty($model)){
								$query->where("model_id","=",$model);
							}
						})
						->where(function($query) use($warranty_start){
							if(!empty($warranty_start)){
								$query->where("warranty_start","LIKE","$warranty_start%");
							}
						})
						->where(function($query) use($warranty_end){
							if(!empty($warranty_end)){
								$query->where("warranty_end","LIKE","$warranty_end%");
							}
						})
						->orderBy("asset_tag")
						->get(array("id","asset_tag","serial_number","model_id","employee_number","warranty_start","warranty_end","notes","location","classification_id","date_added","status"));
				
				if($assets->count()>0){
				
					if(isset($_GET["format"])){
						$assetsArray = array();
						foreach($assets as $a){
							$assetsArray[$a->id] = array(
									"Asset Tag"=>$a->asset_tag,
									"Serial Number"=>$a->serial_number,
									"Employee"=>!empty($a->employee->first_name) ? $a->employee->first_name." ".$a->employee->last_name : "Unassigned.",
									"Employee Number"=>!empty($a->employee->employee_number) ? $a->employee->employee_number : null,
									"Model"=>!empty($a->model->name) ? $a->model->name : "No Information.",
									"Notes"=>!empty($a->notes) ? $a->notes : null,
									"Location"=>!empty($a->location) ? $a->location : "No Information.",
									"Warranty Start Date"=>!empty($a->warranty_start) ? DateTime::createFromFormat("Y-m-d", $a->warranty_start)->format("F d, Y") : "No Information",
									"Warranty End Date"=>!empty($a->warranty_end) ? DateTime::createFromFormat("Y-m-d", $a->warranty_end)->format("F d, Y") : "No Information",
									"Date Added to System"=>DateTime::createFromFormat("Y-m-d H:i:s", $a->date_added)->format("F d, Y g:iA"),
									"Asset Type"=>$a->classification->name,
									"Status"=>$a->status
							);
								
						}
					}
				
					else{
						$assetsArray = $assets->toArray();
					}
				
					Excel::create('office_assets_export_'.str_random(6), function($excel) use($assetsArray) {
				
						// Set the title
						$excel->setTitle('Office Assets Export');
				
						// Chain the setters
						$excel->setCreator('Vault')
						->setCompany('Vault');
				
						// Call them separately
						$excel->setDescription('Office Assets Data Export from IT Vault.');
				
						// Our first sheet
						$excel->sheet('Office Assets', function($sheet) use($assetsArray) {
							$sheet->fromArray(
									$assetsArray
							);
						});
				
					})->download('xlsx');
				}
				
				else{
					Input::flash();
					return Redirect::to('export/network')->withInput()->with('info', "No records have been retrieved. Data export cancelled.");
				}
			}
			
		}
		
		else{
			return Redirect::to("/");
		}
	}
	
	public function exportSoftware(){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
		
			$view = View::make("Export.export_software");
				
			$view->nav = "system";
			$view->tab = "software";
				
			$view->software = Software::orderBy("asset_tag")->paginate(25);
			$view->results = Software::all()->count();
		
			$getSoftwareTypes = SoftwareType::all();
			$softwareTypes = array(""=>"--Select One--");
		
			foreach($getSoftwareTypes as $gst){
				$softwareTypes[$gst->id]=$gst->software_type;
			}
		
			$view->softwareTypes = $softwareTypes;
		
			return $view;
		}
			
		else{
			return Redirect::to("/");
		}
	}
	
	public function exportSoftwareBegin(){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
			
			if(isset($_GET["search"])){
				
				$view = View::make("Export.export_software");
				$view->nav="system";
				$view->tab = "software";
					
				$input = Input::all();
					
				$asset_tag = trim($input["asset_tag"])!=null ? str_replace(' ', '%', trim($input["asset_tag"])) : "";
				$employee = trim($input["employee"])!=null ? trim($input["employee"]) : "";
				$serial_number = trim($input["serial_number"])!=null ? str_replace(' ', '%', trim($input["serial_number"])) : "";
				$software_type = trim($input["software_type"])!=null ? str_replace(' ', '%', trim($input["software_type"])) : "";
				$asset_status = !empty($input["asset_status"]) ? $input["asset_status"] : "";
				$warranty_start = trim($input["warranty_start"])!=null ? str_replace(' ', '%', trim($input["warranty_start"])) : "";
				$warranty_end = trim($input["warranty_end"])!=null ? str_replace(' ', '%', trim($input["warranty_end"])) : "";
					
				$software = Software::where("asset_tag","LIKE","%$asset_tag%")
						->where(function($query) use($employee){
							$emp = "%".str_replace(' ', '%', $employee)."%";
							$emp = DB::connection()->getPdo()->quote($emp);
								
							if(!empty($employee)){
								$query->where("employee_number","LIKE",$employee)
								->orWhereHas("employee",function($q) use($employee,$emp){
									$q->whereRaw("concat(first_name,' ',last_name) LIKE $emp");
								})
								->orWhereHas("employee",function($q) use($employee,$emp){
									$q->whereRaw("concat(last_name,' ',first_name) LIKE $emp");
								});
							}
						})
						->where(function($query) use($serial_number){
							if(!empty($serial_number)){
								$query->where("assigned_to_serial_number","=",$serial_number);
							}
						})
						->where(function($query) use($software_type){
							if(!empty($$software_type)){
								$query->where("software_type_id","=",$software_type);
							}
						})
						->where(function($query) use($asset_status){
							if(!empty($asset_status)){
								$query->where("status","=",$asset_status);
							}
						})
						->where(function($query) use($warranty_start){
							if(!empty($warranty_start)){
								$query->where("warranty_start","LIKE","$warranty_start%");
							}
						})
						->where(function($query) use($warranty_end){
							if(!empty($warranty_end)){
								$query->where("warranty_end","LIKE","$warranty_end%");
							}
						})
						->orderBy("asset_tag")
						->paginate(25);
				
				$result = Software::where("asset_tag","LIKE","%$asset_tag%")
						->where(function($query) use($employee){
							$emp = "%".str_replace(' ', '%', $employee)."%";
							$emp = DB::connection()->getPdo()->quote($emp);
						
							if(!empty($employee)){
								$query->where("employee_number","LIKE",$employee)
								->orWhereHas("employee",function($q) use($employee,$emp){
									$q->whereRaw("concat(first_name,' ',last_name) LIKE $emp");
								})
								->orWhereHas("employee",function($q) use($employee,$emp){
									$q->whereRaw("concat(last_name,' ',first_name) LIKE $emp");
								});
							}
						})
						->where(function($query) use($serial_number){
							if(!empty($serial_number)){
								$query->where("assigned_to_serial_number","=",$serial_number);
							}
						})
						->where(function($query) use($software_type){
							if(!empty($$software_type)){
								$query->where("software_type_id","=",$software_type);
							}
						})
						->where(function($query) use($asset_status){
							if(!empty($asset_status)){
								$query->where("status","=",$asset_status);
							}
						})
						->where(function($query) use($warranty_start){
							if(!empty($warranty_start)){
								$query->where("warranty_start","LIKE","$warranty_start%");
							}
						})
						->where(function($query) use($warranty_end){
							if(!empty($warranty_end)){
								$query->where("warranty_end","LIKE","$warranty_end%");
							}
						})
						->count();
					
				$getSoftwareTypes = SoftwareType::all();
				$softwareTypes = array(""=>"--Select One--");
				
				foreach($getSoftwareTypes as $gst){
					$softwareTypes[$gst->id]=$gst->software_type;
				}
				
				$view->softwareTypes = $softwareTypes;
					
				$view->software = $software;
				$view->results = $result;
					
				Input::flash();
				return $view;
			}
			
			else if(isset($_GET["export"])){
					
				$input = Input::all();
					
				$asset_tag = trim($input["asset_tag"])!=null ? str_replace(' ', '%', trim($input["asset_tag"])) : "";
				$employee = trim($input["employee"])!=null ? trim($input["employee"]) : "";
				$serial_number = trim($input["serial_number"])!=null ? str_replace(' ', '%', trim($input["serial_number"])) : "";
				$software_type = trim($input["software_type"])!=null ? str_replace(' ', '%', trim($input["software_type"])) : "";
				$asset_status = !empty($input["asset_status"]) ? $input["asset_status"] : "";
				$warranty_start = trim($input["warranty_start"])!=null ? str_replace(' ', '%', trim($input["warranty_start"])) : "";
				$warranty_end = trim($input["warranty_end"])!=null ? str_replace(' ', '%', trim($input["warranty_end"])) : "";
					
				if(Session::has("secure") && Session::get("user_type")=="Root" && isset($_GET["pk"])){
					
					$software = Software::where("asset_tag","LIKE","%$asset_tag%")
						->where(function($query) use($employee){
							$emp = "%".str_replace(' ', '%', $employee)."%";
							$emp = DB::connection()->getPdo()->quote($emp);
						
							if(!empty($employee)){
								$query->where("employee_number","LIKE",$employee)
								->orWhereHas("employee",function($q) use($employee,$emp){
									$q->whereRaw("concat(first_name,' ',last_name) LIKE $emp");
								})
								->orWhereHas("employee",function($q) use($employee,$emp){
									$q->whereRaw("concat(last_name,' ',first_name) LIKE $emp");
								});
							}
						})
						->where(function($query) use($serial_number){
							if(!empty($serial_number)){
								$query->where("assigned_to_serial_number","=",$serial_number);
							}
						})
						->where(function($query) use($software_type){
							if(!empty($$software_type)){
								$query->where("software_type_id","=",$software_type);
							}
						})
						->where(function($query) use($asset_status){
							if(!empty($asset_status)){
								$query->where("status","=",$asset_status);
							}
						})
						->where(function($query) use($warranty_start){
							if(!empty($warranty_start)){
								$query->where("warranty_start","LIKE","$warranty_start%");
							}
						})
						->where(function($query) use($warranty_end){
							if(!empty($warranty_end)){
								$query->where("warranty_end","LIKE","$warranty_end%");
							}
						})->orderBy("asset_tag")->get();
				}
				
				else{
					
					$software = Software::where("asset_tag","LIKE","%$asset_tag%")
						->where(function($query) use($employee){
							$emp = "%".str_replace(' ', '%', $employee)."%";
							$emp = DB::connection()->getPdo()->quote($emp);
						
							if(!empty($employee)){
								$query->where("employee_number","LIKE",$employee)
								->orWhereHas("employee",function($q) use($employee,$emp){
									$q->whereRaw("concat(first_name,' ',last_name) LIKE $emp");
								})
								->orWhereHas("employee",function($q) use($employee,$emp){
									$q->whereRaw("concat(last_name,' ',first_name) LIKE $emp");
								});
							}
						})
						->where(function($query) use($serial_number){
							if(!empty($serial_number)){
								$query->where("assigned_to_serial_number","=",$serial_number);
							}
						})
						->where(function($query) use($software_type){
							if(!empty($$software_type)){
								$query->where("software_type_id","=",$software_type);
							}
						})
						->where(function($query) use($asset_status){
							if(!empty($asset_status)){
								$query->where("status","=",$asset_status);
							}
						})
						->where(function($query) use($warranty_start){
							if(!empty($warranty_start)){
								$query->where("warranty_start","LIKE","$warranty_start%");
							}
						})
						->where(function($query) use($warranty_end){
							if(!empty($warranty_end)){
								$query->where("warranty_end","LIKE","$warranty_end%");
							}
						})->orderBy("asset_tag")
						->get(array("id","asset_tag","location","warranty_start","warranty_end","notes","status","employee_number","assigned_to_serial_number","software_type_id","date_added"));
				}
				
				
						
					if($software->count()>0){
					
						if(isset($_GET["format"])){
							
							$softwareArray = array();
							
							if(Session::has("secure") && Session::get("user_type")=="Root" && isset($_GET["pk"])){
								
								foreach($software as $s){
									
									$softwareArray[$s->id] = array(
											"Asset Tag"=>$s->asset_tag,
											"Product Key"=>$s->product_key,
											"Employee"=>!empty($s->employee->first_name) ? $s->employee->first_name." ".$s->employee->last_name : "Unassigned.",
											"Employee Number"=>!empty($s->employee->employee_number) ? $s->employee->employee_number : null,
											"Location"=>!empty($s->location) ? $s->location : "No Information.",
											"Assigned to Laptop"=>!empty($s->assigned_to_serial_number) ? $s->assigned_to_serial_number : "No Information.",
											"Notes"=>!empty($s->notes) ? $s->notes : null,
											"Warranty Start Date"=>!empty($s->warranty_start) ? DateTime::createFromFormat("Y-m-d", $s->warranty_start)->format("F d, Y") : "No Information",
											"Warranty End Date"=>!empty($s->warranty_end) ? DateTime::createFromFormat("Y-m-d", $s->warranty_end)->format("F d, Y") : "No Information",
											"Date Added to System"=>DateTime::createFromFormat("Y-m-d H:i:s", $s->date_added)->format("F d, Y g:iA"),
											"Software Type"=>$s->type->software_type,
											"Status"=>$s->status
									);
								
								}
							}
							
							else{
								
								foreach($software as $s){
									$softwareArray[$s->id] = array(
											"Asset Tag"=>$s->asset_tag,
											"Employee"=>!empty($s->employee->first_name) ? $s->employee->first_name." ".$s->employee->last_name : "Unassigned.",
											"Employee Number"=>!empty($s->employee->employee_number) ? $s->employee->employee_number : null,
											"Location"=>!empty($s->location) ? $s->location : "No Information.",
											"Assigned to Laptop"=>!empty($s->assigned_to_serial_number) ? $s->assigned_to_serial_number : "No Information.",
											"Notes"=>!empty($s->notes) ? $s->notes : null,
											"Warranty Start Date"=>!empty($s->warranty_start) ? DateTime::createFromFormat("Y-m-d", $s->warranty_start)->format("F d, Y") : "No Information",
											"Warranty End Date"=>!empty($s->warranty_end) ? DateTime::createFromFormat("Y-m-d", $s->warranty_end)->format("F d, Y") : "No Information",
											"Date Added to System"=>DateTime::createFromFormat("Y-m-d H:i:s", $s->date_added)->format("F d, Y g:iA"),
											"Software Type"=>$s->type->software_type,
											"Status"=>$s->status
									);
										
								}
							}
						}
					
						else{
							$softwareArray = $software->toArray();
						}
					
						Excel::create('software_assets_export_'.str_random(6), function($excel) use($softwareArray) {
					
							// Set the title
							$excel->setTitle('Software Assets Export');
					
							// Chain the setters
							$excel->setCreator('Vault')
							->setCompany('Vault');
					
							// Call them separately
							$excel->setDescription('Software Assets Data Export from IT Vault.');
					
							// Our first sheet
							$excel->sheet('Software Assets', function($sheet) use($softwareArray) {
								$sheet->fromArray(
										$softwareArray
								);
							});
					
						})->download('xlsx');
					}
					
					else{
						Input::flash();
						return Redirect::to('export/software')->withInput()->with('info', "No records have been retrieved. Data export cancelled.");
					}
						
			}
			
			
		}
		
		else{
			return Redirect::to("/");
		}
	}
	
	public function exportEmployees(){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
			
			$view = View::make("Export.export_employees");
			$view->employees = Employee::orderBy("last_name","asc")->paginate(25);
			$view->nav="system";
			$view->tab="employees";
				
			$getManagers = Manager::orderBy('last_name','asc')->get();
			$managers = array("all"=>"All",""=>"None");
				
		
			foreach($getManagers as $manager){
				if(!empty($manager["first_name"])){
					$managers[$manager["id"]] = $manager["last_name"].", ".$manager["first_name"];
				}
					
				else{
					$managers[$manager["id"]] = $manager["last_name"];
				}
			}
		
			$view->managers = $managers;
			$view->result = Employee::all()->count();
			return $view;
				
		}
		
		else{
			return Redirect::to('/');
		}
	}
	
	public function exportEmployeesBegin(){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
			
			if(isset($_GET["search"])){
				
				$view = View::make("Export.export_employees");
				$view->nav="system";
				$view->tab="employees";
					
				$input = Input::all();
				
				$last_name = trim($input["last_name"])!=null ? str_replace(' ', '%', trim($input["last_name"])) : "";
				$first_name = trim($input["first_name"])!=null ? str_replace(' ', '%', trim($input["first_name"])) : "";
				$employee_number = trim($input["employee_number"])!=null ? str_replace(' ', '%', trim($input["employee_number"])) : "";
				$manager = trim($input["manager_id"])!=null ? str_replace(' ', '%', trim($input["manager_id"])) : "";
				$start_date = trim($input["start_date"])!=null ? str_replace(' ', '%', trim($input["start_date"])) : "";
				$status = trim($input["status"])!=null ? str_replace(' ', '%', trim($input["status"])) : "";
				
					
				if($manager!="all"){
					 
					$view->employees = Employee::where("last_name","LIKE","%$last_name%")
					->where("first_name","LIKE","%$first_name%")
					->where("employee_number","LIKE","%$employee_number%")
					->where("start_date","LIKE","$start_date%")
		   			->where(function($query) use($status){
						if(!empty($status)){
							$query->where("status","LIKE",$status);
						}
		   			})
					->where(function($query) use($manager){
						if(!empty($manager)){
							$query->where("manager_id","=",$manager);
						}
							
						else{
							$query->whereNull("manager_id");
						}
					})
					->orderBy("last_name","asc")
					->paginate(25);
					 
					$view->result =  Employee::where("last_name","LIKE","%$last_name%")
					->where("first_name","LIKE","%$first_name%")
					->where("employee_number","LIKE","%$employee_number%")
					->where("start_date","LIKE","$start_date%")
		   			->where(function($query) use($status){
						if(!empty($status)){
							$query->where("status","LIKE",$status);
						}
		   			})
					->where(function($query) use($manager){
						if(!empty($manager)){
							$query->where("manager_id","=",$manager);
						}
							
						else{
							$query->whereNull("manager_id");
						}
					})->count();
				}
				
				else{
					 
					$view->employees = Employee::where("last_name","LIKE","%$last_name%")
					->where("first_name","LIKE","%$first_name%")
					->where("employee_number","LIKE","%$employee_number%")
					->where("start_date","LIKE","$start_date%")
		   			->where(function($query) use($status){
						if(!empty($status)){
							$query->where("status","LIKE",$status);
						}
		   			})
					->orderBy("last_name","asc")
					->paginate(25);
				
					$view->result =  Employee::where("last_name","LIKE","%$last_name%")
					->where("first_name","LIKE","%$first_name%")
					->where("employee_number","LIKE","%$employee_number%")
					->where("start_date","LIKE","$start_date%")
		   			->where(function($query) use($status){
						if(!empty($status)){
							$query->where("status","LIKE",$status);
						}
		   			})
					->count();
					 
				}
				
				$getManagers = Manager::orderBy('last_name','asc')->get();
				$managers = array("all"=>"All",""=>"None");
				 
				foreach($getManagers as $manager){
					if(!empty($manager["first_name"])){
						$managers[$manager["id"]] = $manager["last_name"].", ".$manager["first_name"];
					}
				
					else{
						$managers[$manager["id"]] = $manager["last_name"];
					}
				}
				 
				$view->managers = $managers;
				
				Input::flash();
				return $view;
			}
			
			else if(isset($_GET["export"])){
				
				$input = Input::all();
				
				$last_name = trim($input["last_name"])!=null ? str_replace(' ', '%', trim($input["last_name"])) : "";
				$first_name = trim($input["first_name"])!=null ? str_replace(' ', '%', trim($input["first_name"])) : "";
				$employee_number = trim($input["employee_number"])!=null ? str_replace(' ', '%', trim($input["employee_number"])) : "";
				$manager = trim($input["manager_id"])!=null ? str_replace(' ', '%', trim($input["manager_id"])) : "";
				$start_date = trim($input["start_date"])!=null ? str_replace(' ', '%', trim($input["start_date"])) : "";
				$status = trim($input["status"])!=null ? str_replace(' ', '%', trim($input["status"])) : "";
				
					
				if($manager!="all"){
				
					$employees = Employee::where("last_name","LIKE","%$last_name%")
							->where("first_name","LIKE","%$first_name%")
							->where("employee_number","LIKE","%$employee_number%")
							->where("start_date","LIKE","$start_date%")
				   			->where(function($query) use($status){
								if(!empty($status)){
									$query->where("status","LIKE",$status);
								}
				   			})
							->where(function($query) use($manager){
								if(!empty($manager)){
									$query->where("manager_id","=",$manager);
								}
									
								else{
									$query->whereNull("manager_id");
								}
							})
							->orderBy("last_name")
							->get();
				}
				
				else{
				
					$employees = Employee::where("last_name","LIKE","%$last_name%")
							->where("first_name","LIKE","%$first_name%")
							->where("employee_number","LIKE","%$employee_number%")
							->where("start_date","LIKE","$start_date%")
				   			->where(function($query) use($status){
								if(!empty($status)){
									$query->where("status","LIKE",$status);
								}
				   			})
							->orderBy("last_name")
							->get();
				
				}
				
				if($employees->count()>0){
					
					if(isset($_GET["format"])){
							
						$employeesArray = array();
							
						foreach($employees as $e){
							$employeesArray[$e->id] = array(
									"Last Name"=>$e->last_name,
									"First Name"=>$e->first_name,
									"Employee Number"=>$e->employee_number,
									"Username"=>$e->username,
									"Nickname"=>$e->nickname,
									"Manager"=>!empty($e->manager->last_name) ? $e->manager->first_name." ".$e->manager->last_name : "No Information.",
									"Start Date"=>!empty($e->start_date) ? DateTime::createFromFormat("Y-m-d", $e->start_date)->format("F d, Y") : null,
									"End Date"=>!empty($e->end_date) ? DateTime::createFromFormat("Y-m-d", $e->end_date)->format("F d, Y") : null,
									"NSN ID"=>$e->nsn_id,
									"Email"=>$e->email,
									"Business Line"=>!empty($e->businessline->name) ? $e->businessline->name : "No Information.",
									"Unit"=>!empty($e->unit->name) ? $e->unit->name : "No Information.",
									"Subunit"=>$e->subunit,
									"Cellphone Number"=>$e->cellphone_number,
									"Status"=>$e->status
							);
						}
							
					}
					
					else{
						$employeesArray = $employees->toArray();
					}
					
					Excel::create('employees_export_'.str_random(6), function($excel) use($employeesArray) {
					
						// Set the title
						$excel->setTitle('Employees Export');
					
						// Chain the setters
						$excel->setCreator('Vault')
						->setCompany('Vault');
					
						// Call them separately
						$excel->setDescription('Employees Data Export from IT Vault.');
					
						// Our first sheet
						$excel->sheet('Employees', function($sheet) use($employeesArray) {
							$sheet->fromArray(
									$employeesArray
							);
						});
								
					})->download('xlsx');
				}
				
				else{
					Input::flash();
					return Redirect::to('export/employees')->withInput()->with('info', "No records have been retrieved. Data export cancelled.");
				}
			}
			
		}
		
		else{
			return Redirect::to('/');
		}
		
	}
	
// 	public function exportAssetLogs(){
		
// 		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin" || Session::get("user_type")=="User")){
				
// 			$view = View::make("Export.export_asset_logs");
// 			$view->nav="system";
// 			$view->tab="assetlogs";
		
// 			$assetsLogs = AssetLog::orderBy("datetime","desc")->paginate(25);
// 			$logsCount = AssetLog::all()->count();
				
// 			$view->assetsLogs = $assetsLogs;
// 			$view->logsCount = $logsCount;
// 			$view->q = $logsCount;
// 			return $view;
// 		}
		
// 		else{
// 			return Redirect::to("/");
// 		}
		
// 	}
	
// 	public function exportAssetLogsBegin(){
		
// 	}
	
}