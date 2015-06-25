<?php

class OfficeController extends BaseController{
	
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
	
	public function index($assetClass,$sortby=null,$order=null){
	
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin" || Session::get("user_type")=="User")){
				
			$view = View::make("Assets.Office.office_assets");
			$view->nav = "assets";
			$view->tab = $assetClass;
				
			$checkClass = AssetClassification::where("url_key","=",$assetClass)->where("type","=","Office")->first();
	
			if(!$checkClass){
				return Redirect::to('assets/office');
			}
				
				
			if(empty($sortby) || empty($order)){
				$assets = Asset::whereHas('classification', function ($query) use($checkClass){
					$query->where("name","=",$checkClass->name);
				})->orderBy("asset_tag","asc")->paginate(25);
			}
				
			else{
	
				if(!in_array($sortby, array("asset_tag","serial_number","model_id","warranty_start","warranty_end")) || !in_array($order,array("asc","desc"))){
					return Redirect::to("assets/office/view/".$assetClass);
				}
	
				$assets = Asset::whereHas('classification', function ($query) use($checkClass){
					$query->where("name","=",$checkClass->name);
				})->orderBy($sortby,$order)->paginate(25);
			}
				
			$result = Asset::whereHas('classification', function ($query) use($checkClass){
				$query->where("name","=",$checkClass->name);
			})->count();
				
	
			$view->sortby= $sortby;
			$view->order=$order;
				
			$view->assets = $assets;
			$view->result = $result;
				
			$view->asset_name = $checkClass->name;
			$view->asset_key = $checkClass->url_key;
				
			return $view;
				
		}
	
		else{
			return Redirect::to('/');
		}
	}
	
	public function search($assetClass){
	
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin" || Session::get("user_type")=="User")){
	
			if(!AssetClassification::where("url_key","=",$assetClass)->where("type","=","Office")->first()){
				return Redirect::to("assets/office/view/printers");
			}
				
			$keyword = trim(stripslashes(Input::get('keyword')));
			$keyword = preg_replace('{/$}', '', $keyword);
	
			if(!empty($keyword)){
				//The withInput() extension to the URL is used to flash the search keyword the user has used.
				return Redirect::to('assets/office/search/'.$assetClass.'/'.urlencode($keyword))->withInput();
			}
	
			else{
				return Redirect::to('assets/office/view/'.$assetClass);
			}
		}
	
		else{
			return Redirect::to('/');
		}
	
	}
	
	public function searchKeyword($assetClass,$keyword,$sortby=null,$order=null){
	
			
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin" || Session::get("user_type")=="User")){
	
			$view = View::make('Assets.Office.office_assets');
			$view->nav="assets";
			$view->intent="search";
				
			$checkClass = AssetClassification::where("url_key","=",$assetClass)->where("type","=","Office")->first();
				
			if(!$checkClass){
				return Redirect::to("assets/office");
			}
				
				
			/*
			* 1. Get the input
			* 2. Remove unnecessary whitespaces
			* 3. Insert wildcard '%' in the beginning and end of the keyword, and also in replace the whitespaces.
			* 	 I need to this so that mySQL will find all matched characters in a string. Example: MySQL finding 'gel' in 'angelica'.
			*
			*/
				
			$view->keyword = trim(urldecode($keyword));
			$keyword = str_replace(' ', '%', trim(urldecode($keyword)));
				
			/*
			 * $keywordRaw is used for whereRaw() method of Eloquent.
			*  Processed the sameway $keyword was processed, but $keywordRaw is also quoted to avoid SQL injections, which
			*  the Eloquent method whereRaw() is prone.
			*
			*/
				
			$keywordRaw =  "%".str_replace(' ', '%', $keyword)."%";
			$keywordRaw = DB::connection()->getPdo()->quote($keywordRaw);
	
			if(empty($sortby) || empty($order)){
	
				$view->assets = Asset::whereHas("classification", function($query) use($assetClass){
					$query->where("url_key","=",$assetClass);
				})
				->where(function($query) use($keyword,$keywordRaw){
					$query->where("serial_number","=",$keyword)
					->orWhere("asset_tag","=",$keyword)
					->orWhereHas("employee",function($query) use($keyword,$keywordRaw){
						$query->where("last_name","LIKE","%$keyword%"); })
					->orWhereHas("employee",function($query) use($keyword,$keywordRaw){
						$query->where("first_name","LIKE","%$keyword%"); })
					->orWhereHas("employee",function($query) use($keyword,$keywordRaw){
						$query->WhereRaw("concat(last_name,' ',first_name) LIKE $keywordRaw"); })
					->orWhereHas("employee",function($query) use($keyword,$keywordRaw){
						$query->WhereRaw("concat(first_name,' ',last_name) LIKE $keywordRaw"); });
				})->orderBy("asset_tag","asc")
				->paginate(25);
					
			}
	
			else{
	
				if(!in_array($sortby,array("asset_tag","serial_number","model_id","warranty_start","warranty_end")) || !in_array($order,array("asc","desc"))){
					return Redirect::to('assets/office/view/'.$assetClass);
				}
					
				$view->assets = Asset::whereHas("classification", function($query) use($assetClass){
					$query->where("url_key","=",$assetClass);
				})
				->where(function($query) use($keyword,$keywordRaw){
					$query->where("serial_number","=",$keyword)
					->orWhere("asset_tag","=",$keyword)
					->orWhereHas("employee",function($query) use($keyword,$keywordRaw){
						$query->where("last_name","LIKE","%$keyword%"); })
					->orWhereHas("employee",function($query) use($keyword,$keywordRaw){
						$query->where("first_name","LIKE","%$keyword%"); })
					->orWhereHas("employee",function($query) use($keyword,$keywordRaw){
						$query->WhereRaw("concat(last_name,' ',first_name) LIKE $keywordRaw"); })
					->orWhereHas("employee",function($query) use($keyword,$keywordRaw){
						$query->WhereRaw("concat(first_name,' ',last_name) LIKE $keywordRaw"); });
				})->orderBy($sortby,$order)
				->paginate(25);
			}
	
			$view->result =  Asset::whereHas("classification", function($query) use($assetClass){
				$query->where("url_key","=",$assetClass);
			})
			->where(function($query) use($keyword,$keywordRaw){
				$query->where("serial_number","=",$keyword)
				->orWhere("asset_tag","=",$keyword)
				->orWhereHas("employee",function($query) use($keyword,$keywordRaw){
					$query->where("last_name","LIKE","%$keyword%"); })
				->orWhereHas("employee",function($query) use($keyword,$keywordRaw){
					$query->where("first_name","LIKE","%$keyword%"); })
				->orWhereHas("employee",function($query) use($keyword,$keywordRaw){
					$query->WhereRaw("concat(last_name,' ',first_name) LIKE $keywordRaw"); })
				->orWhereHas("employee",function($query) use($keyword,$keywordRaw){
					$query->WhereRaw("concat(first_name,' ',last_name) LIKE $keywordRaw"); });
			})
			->count();
	
			$view->sortby=$sortby;
			$view->order=$order;
				
			$view->asset_name = $checkClass->name;
			$view->asset_key = $checkClass->url_key;
			$view->tab = $checkClass->url_key;
	
			return $view;
		}
	
		else{
			return Redirect::to('/');
		}
	
	}
	
	public function advancedSearch(){
			
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin" || Session::get("user_type")=="User")){
	
			$view = View::make("Assets.Office.office_advanced_search");
			$view->nav = "assets";
			$view->tab = "search";
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
	
	public function advancedSearchAssets(){
			
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin" || Session::get("user_type")=="User")){
				
			$view = View::make("Assets.Office.office_advanced_search");
			$view->nav="assets";
			$view->tab = "search";
				
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
	
		else{
			return Redirect::to("/");
		}
	}
	
	public function logs($id){
			
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin" || Session::get("user_type")=="User")){
	
			$view = View::make("Assets.Office.office_logs");
			$view->nav = "assets";
	
			$asset = Asset::where("id","=",$id)->whereHas("classification",function($query){
				$query->where("type","=","Office");
			})->first();
	
			if(!$asset){
				return Redirect::to("assets/office");
			}
	
			if(Session::get("user_type")=="Root" || Session::get("user_type")=="Admin"){
 				$view->asset = $asset;
 				$view->transaction = "all";
 				$view->logs = AssetLog::where("asset_id","=",$id)->orderBy("datetime","desc")->paginate(25);
 				$view->logCount = AssetLog::where("asset_id","=",$id)->orderBy("datetime","desc")->count();
 			}
 			
 			else{
 				$view->asset = $asset;
 				$view->logs = AssetLog::where("asset_id","=",$id)->where("transaction","=","History")->orderBy("datetime","desc")->paginate(25);
 				$view->logCount = AssetLog::where("asset_id","=",$id)->where("transaction","=","History")->orderBy("datetime","desc")->count();
 			}
	
			return $view;
		}
			
		else{
			return Redirect::to("/");
		}
			
	}
	
	public function filterLogs($id,$transaction){
	
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin" || Session::get("user_type")=="User")){
			
			if(Session::get("user_type")=="User"){
				return Redirect::to("assets/office/logs/".$id);
			}
			
			$view = View::make("Assets.Office.office_logs");
			$view->nav = "assets";
	
			$asset = Asset::where("id","=",$id)->whereHas("classification",function($query){
				$query->where("type","=","Office");
			})->first();
	
			if(!$asset){
				return Redirect::to("assets");
			}
	
			if(!in_array($transaction,array("history","updates"))){
				return Redirect::to("assets");
			}
	
			$view->asset = $asset;
			$view->transaction = $transaction;
			$view->logs = AssetLog::where("asset_id","=",$id)
			->where("transaction","=",$transaction)
			->orderBy("datetime","desc")->paginate(25);
	
	
			$view->logCount = AssetLog::where("asset_id","=",$id)
			->where("transaction","=",$transaction)
			->orderBy("datetime","desc")->count();
	
			return $view;
		}
	
		else{
			return Redirect::to("/");
		}
	
	}
	
	public function addAsset($assetClass){
			
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
	
			$view = View::make("Assets.Office.add_office_asset");
	
			$view->nav = "assets";
			$view->tab = $assetClass;
				
			$checkClass = AssetClassification::where("url_key","=",$assetClass)->where("type","=","Office")->first();
	
			if(!$checkClass){
				return Redirect::to("assets/office");
			}
				
			$getAssetClassifications = AssetClassification::where("type","=","Office")->get();
			$assetClassifications = array();
				
			foreach($getAssetClassifications as $gac){
				$assetClassifications[$gac->id]=$gac->name;
			}
				
			$getAssetModels = Model::whereHas('classification', function ($query) use($checkClass){
				$query->where("name","=",$checkClass->name);
			})->orderBy("name","asc")->get();
	
			$assetModels = array(""=>"--Select One--");
				
			foreach($getAssetModels as $gam){
				$assetModels[$gam->id] = $gam->name;
			}
			
			$view->locations = array(
					""=>"None",
					"Bldg I - 2F Left Wing"=>"Bldg I - 2F Left Wing",
					"Bldg I - 2F Meeting Rooms"=>"Bldg I - 2F Meeting Rooms",
					"Bldg I - 2F Operations"=>"Bldg I - 2F Operations",
					"Bldg I - 2F Pantry"=>"Bldg I - 2F Pantry",
					"Bldg I - 2F Right Wing"=>"Bldg I - 2F Right Wing",
					"Bldg I - 3F Left Wing"=>"Bldg I - 3F Left Wing",
					"Bldg I - 3F Meeting Rooms"=>"Bldg I - 3F Meeting Rooms",
					"Bldg I - 3F Operations"=>"Bldg I - 3F Operations",
					"Bldg I - 3F Pantry"=>"Bldg I - 3F Pantry",
					"Bldg I - 3F Right Wing"=>"Bldg I - 3F Right Wing",
					"Bldg I - Administration"=>"Bldg I - Administration",
					"Bldg I - Data Center"=>"Bldg I - Data Center",
					"Bldg I - Electrical Room"=>"Bldg I - Electrical Room",
					"Bldg I - Facilities"=>"Bldg I - Facilities",
					"Bldg I - GF Meeting Rooms"=>"Bldg I - GF Meeting Rooms",
					"Bldg I - GF Operations"=>"Bldg I - GF Operations",
					"Bldg I - GF Pantry"=>"Bldg I - GF Pantry",
					"Bldg I - IT"=>"Bldg I - IT",
					"Bldg I - Laboratory"=>"Bldg I - Laboratory",
					"Bldg I - Security Room"=>"Bldg I - Security Room",
					"Bldg O - 2F Left Wing"=>"Bldg O - 2F Left Wing",
					"Bldg O - 2F Meeting Rooms"=>"Bldg O - 2F Meeting Rooms",
					"Bldg O - 2F Operations"=>"Bldg O - 2F Operations",
					"Bldg O - 2F Pantry"=>"Bldg O - 2F Pantry",
					"Bldg O - 2F Right Wing"=>"Bldg O - 2F Right Wing",
					"Bldg O - Administration"=>"Bldg O - Administration",
					"Bldg O - Data Center"=>"Bldg O - Data Center",
					"Bldg O - Electrical Room"=>"Bldg O - Electrical Room",
					"Bldg O - Facilities"=>"Bldg O - Facilities",
					"Bldg O - GF Meeting Rooms"=>"Bldg O - GF Meeting Rooms",
					"Bldg O - GF Operations"=>"Bldg O - GF Operations",
					"Bldg O - GF Pantry"=>"Bldg O - GF Pantry",
					"Bldg O - IT"=>"Bldg O - IT",
					"Bldg O - Laboratory"=>"Bldg O - Laboratory",
					"Bldg O - Security Room"=>"Bldg O - Security Room",
					"Others"=>"Others"
					
			);
				
			$view->assetModels = $assetModels;
			$view->assetClassifications = $assetClassifications;
			$view->asset_class_id = $checkClass->id;
			$view->asset_key = $checkClass->url_key;
			$view->asset_name = $checkClass->name;
				
			return $view;
	
		}
			
		else{
			return Redirect::to("/");
		}
	}
	
	public function submitNewAsset(){
			
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
	
			$input = Input::all();
			$warranty_start = $input["warranty_start"]!=null ? $input["warranty_start"] : "1994-04-16";
			$notes = Input::get("notes")!=null ? trim(Input::get("notes")) : "";
	
			$validator = Validator::make(
					array(
							"asset tag"=>$input["asset_tag"],
							"employee number"=>trim($input["employee_number"]),
							"serial number"=>$input["serial_number"],
 							"model"=>$input["model_id"],
							"warranty start date"=>$input["warranty_start"],
							"warranty end date"=>$input["warranty_end"],
							"asset type"=>$input["asset_class_id"],
							"status"=>$input["asset_status"]
					),
					array(
							"asset tag"=>"required|unique:tbl_assets,asset_tag",
							"employee number"=>"numeric|exists:tbl_employees,employee_number",
							"serial number"=>"required|unique:tbl_assets,serial_number",
 							"model"=>"exists:tbl_asset_models,id",
							"warranty start date"=>"required_with:warranty end date|date:Y-m-d",
							"warranty end date"=>"date:Y-m-d|after:".$warranty_start,
							"asset type"=>"required|exists:tbl_asset_classifications,id",
							"status"=>"required|in:Available,PWU,For Repair,Installed,Lost,Retired,For Borrowing"
					)
			);
	
			if($validator->fails()){
				Input::flash();
				return Redirect::to('assets/office/add/'.$input["asset_key"])->with('message', $validator->messages()->first());
			}
	
			else if($input["asset_status"]!="Lost" && Employee::where("employee_number","=",$input["employee_number"])->whereIn("status",array("OJT Graduate","Graduate","Resigned","Obsolete"))->first()){
				Input::flash();
				return Redirect::to('assets/office/add/'.$input["asset_key"])->with('message', "Cannot assign asset to employees no longer working in the company.");
			}
	
			else{
	
				//Create the asset
				$asset = new Asset;
					
				$asset->asset_tag = trim($input["asset_tag"]);
				$asset->serial_number = trim($input["serial_number"])!=null ? trim($input["serial_number"]) : null;
				$asset->notes = !empty($notes) ? $notes : null;
				$asset->model_id = $input["model_id"]!=null ? $input["model_id"] : null;
				$asset->location = !empty($input["location"]) ? $input["location"] : null;
				$asset->employee_number = trim($input["employee_number"])!=null ? trim($input["employee_number"]) : null;
				$asset->warranty_start = trim($input["warranty_start"])!=null ? trim($input["warranty_start"]) : null;
				$asset->warranty_end = trim($input["warranty_end"])!=null ? trim($input["warranty_end"]) : null;
				$asset->classification_id = $input["asset_class_id"];
				$asset->status = $input["asset_status"];
				$asset->date_added = date("Y-m-d H:i:s");
					
				$asset->save();
	
				//Log the new asset to asset logs
				if(!empty(trim($input["employee_number"]))){
					$employee = Employee::where("employee_number","=",Input::get("employee_number"))->first();
					$desc = "Office Asset <strong>".$asset->asset_tag.",</strong> SN: <strong>".$asset->serial_number."</strong> added to the database and assigned to employee <strong>".$employee->first_name." ".$employee->last_name."</strong> with asset status <strong>".$asset->status."</strong>.";
				}
					
				else{
					$desc = "Office Asset <strong>".$asset->asset_tag."</strong>, SN: <strong>".$asset->serial_number."</strong> added to the database with status <strong>".$asset->status."</strong>.";
				}
					
				$assetLog = new AssetLog;
				$assetLog->user_id = Session::get("user_id");
				$assetLog->asset_id = $asset->id;
				$assetLog->employee_id = !empty($asset->employee->id) ? $asset->employee->id : null;
				$assetLog->description = $desc;
				$assetLog->transaction = "History";
				$assetLog->save();
					
				//Parallel logging to system logs
				$desc = "(".Session::get('user_type').") "."<strong>".Session::get('username')."</strong> added office asset <strong>".$asset->asset_tag."</strong>, SN: <strong>".$asset->serial_number."</strong> ";
				$newLog = new UserLog;
				$newLog->description = $desc;
				$newLog->user_id = Session::get('user_id');
				$newLog->type="System";
	
				$newLog->save();
					
				return Redirect::to('assets/office/add/'.$input["asset_key"])->with('success',"You have successfully added a new office asset.");
	
			}
		}
			
		else{
			return Redirect::to("/");
		}
	}
	
	public function updateAsset($assetClass,$id){
			
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
	
			$view = View::make("Assets.Office.update_office_asset");
			$view->nav = "assets";
			$view->tab = $assetClass;
	
			$checkClass = AssetClassification::where("url_key","=",$assetClass)->where("type","=","Office")->first();
			$asset = Asset::where("id","=",$id)->whereHas("classification",function($query){
				$query->where("type","=","Office");
			})->first();
	
			if(!$checkClass || !$asset){
				return Redirect::to('assets/office');
			}
	
			$view->asset = $asset;
	
			$getAssetClassifications = AssetClassification::where("type","=","Office")->get();
			$assetClassifications = array();
				
			foreach($getAssetClassifications as $gac){
				$assetClassifications[$gac->id]=$gac->name;
			}
				
			$getAssetModels = Model::whereHas('classification', function ($query) use($checkClass){
				$query->where("name","=",$checkClass->name);
			})->orderBy("name","asc")->get();
	
			$assetModels = array(""=>"--Select One--");
				
			foreach($getAssetModels as $gam){
				$assetModels[$gam->id] = $gam->name;
			}
			
			$view->locations = array(
					""=>"None",
					"Bldg I - 2F Left Wing"=>"Bldg I - 2F Left Wing",
					"Bldg I - 2F Meeting Rooms"=>"Bldg I - 2F Meeting Rooms",
					"Bldg I - 2F Operations"=>"Bldg I - 2F Operations",
					"Bldg I - 2F Pantry"=>"Bldg I - 2F Pantry",
					"Bldg I - 2F Right Wing"=>"Bldg I - 2F Right Wing",
					"Bldg I - 3F Left Wing"=>"Bldg I - 3F Left Wing",
					"Bldg I - 3F Meeting Rooms"=>"Bldg I - 3F Meeting Rooms",
					"Bldg I - 3F Operations"=>"Bldg I - 3F Operations",
					"Bldg I - 3F Pantry"=>"Bldg I - 3F Pantry",
					"Bldg I - 3F Right Wing"=>"Bldg I - 3F Right Wing",
					"Bldg I - Administration"=>"Bldg I - Administration",
					"Bldg I - Data Center"=>"Bldg I - Data Center",
					"Bldg I - Electrical Room"=>"Bldg I - Electrical Room",
					"Bldg I - Facilities"=>"Bldg I - Facilities",
					"Bldg I - GF Meeting Rooms"=>"Bldg I - GF Meeting Rooms",
					"Bldg I - GF Operations"=>"Bldg I - GF Operations",
					"Bldg I - GF Pantry"=>"Bldg I - GF Pantry",
					"Bldg I - IT"=>"Bldg I - IT",
					"Bldg I - Laboratory"=>"Bldg I - Laboratory",
					"Bldg I - Security Room"=>"Bldg I - Security Room",
					"Bldg O - 2F Left Wing"=>"Bldg O - 2F Left Wing",
					"Bldg O - 2F Meeting Rooms"=>"Bldg O - 2F Meeting Rooms",
					"Bldg O - 2F Operations"=>"Bldg O - 2F Operations",
					"Bldg O - 2F Pantry"=>"Bldg O - 2F Pantry",
					"Bldg O - 2F Right Wing"=>"Bldg O - 2F Right Wing",
					"Bldg O - Administration"=>"Bldg O - Administration",
					"Bldg O - Data Center"=>"Bldg O - Data Center",
					"Bldg O - Electrical Room"=>"Bldg O - Electrical Room",
					"Bldg O - Facilities"=>"Bldg O - Facilities",
					"Bldg O - GF Meeting Rooms"=>"Bldg O - GF Meeting Rooms",
					"Bldg O - GF Operations"=>"Bldg O - GF Operations",
					"Bldg O - GF Pantry"=>"Bldg O - GF Pantry",
					"Bldg O - IT"=>"Bldg O - IT",
					"Bldg O - Laboratory"=>"Bldg O - Laboratory",
					"Bldg O - Security Room"=>"Bldg O - Security Room",
					"Others"=>"Others"
			
			);
	
			$view->assetClassifications = $assetClassifications;
			$view->assetModels = $assetModels;
	
			$view->asset_class_id = $checkClass->id;
			$view->asset_key = $checkClass->url_key;
	
			$view->asset_name = $checkClass->name;
	
			return $view;
	
		}
			
		else{
			return Redirect::to("/");
		}
	}
	
	public function submitAssetUpdate(){
			
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
	
			$input = Input::all();
			$asset = Asset::where("id","=",$input["id"])->whereHas("classification",function($query){
	   				$query->where("type","=","Office");
 			})->first();
	
			if(!$asset){
				return Redirect::to("assets/office");
			}
	
			if(Session::get("user_type")!="Root" && $asset->status=="Lost"){
				return Redirect::to("assets/office");
			}
	
			if($input["action"]==""){
				return Redirect::to('assets/office/update/'.$input["asset_key"]."/".$input["id"])->with('message',"Please select an action to commit.");
			}
	
			else if($input["action"]=="transfer"){
				return Redirect::to("assets/office/transferasset/".$input["id"]);
			}
	
			else if($input["action"]=="lost"){
				return Redirect::to("assets/office/lostasset/".$input["id"]);
			}
	
			$warranty_start = $input["warranty_start"]!=null ? $input["warranty_start"] : "1994-04-16";
			$notes = Input::get("notes")!=null ? trim(Input::get("notes")) : "";
	
			$validator = Validator::make(
					array(
							"asset tag"=>$input["asset_tag"],
							"serial_number"=>$input["serial_number"],
 							"model"=>$input["model_id"],
							"warranty start date"=>$input["warranty_start"],
							"warranty end date"=>$input["warranty_end"],
							"asset type"=>$input["asset_class_id"],
							"status"=>$input["asset_status"]
					),
					array(
							"asset tag"=>"required",
							"serial_number"=>"required",
 							"model"=>"exists:tbl_asset_models,id",
							"warranty start date"=>"required_with:warranty end date|date:Y-m-d",
							"warranty end date"=>"date:Y-m-d|after:".$warranty_start,
							"asset type"=>"required|exists:tbl_asset_classifications,id",
							"status"=>"required|in:Available,PWU,For Repair,Installed,Lost,Retired,For Borrowing"
					)
			);
	
	
			if($validator->fails()){
				Input::flash();
				return Redirect::to('assets/office/update/'.$input["asset_key"]."/".$input["id"])->with('message', $validator->messages()->first());
			}
	
			else if($input["asset_tag"]!=null && (Asset::where("asset_tag","=",$input["asset_tag"])->first() &&  $asset->asset_tag!=$input["asset_tag"])){
				Input::flash();
				return Redirect::to('assets/office/update/'.$input["asset_key"]."/".$input["id"])->with('message',"Asset tag already exists in the database. This field should be unique.");
			}
			
			else if(Asset::where("serial_number","=",$input["serial_number"])->first() && $asset->serial_number!=$input["serial_number"]){
 				Input::flash();
 				return Redirect::to('assets/office/update/'.$input["asset_key"]."/".$input["id"])->with('message',"Serial number already exists in the database. This field should be unique.");
 			}
	
			else{
					
				//These variables are used to track if anything has been changed.
				$isChanged = false; //Boolean variable that checks if anything has been changed. Changes to true when a change has been detected.
				$changes = array(); //Collects the names of the columns that have been changed.
				$index=0; //Provides the index number of $changes array.
	
				if($input["asset_tag"]!=$asset->asset_tag){
					$isChanged = true;
					$changes[$index] = 1+$index.".) asset tag (from <strong>".$asset->asset_tag."</strong> to <strong>".$input["asset_tag"]."</strong>)<br/>";
					$index+=1;
				}
					
				if($input["serial_number"]!=$asset->serial_number){
					$isChanged = true;
					$changes[$index] = 1+$index.".) serial number (from <strong>".$asset->serial_number."</strong> to <strong>".$input["serial_number"]."</strong>)<br/>";
					$index+=1;
				}
	
				if($notes!=$asset->notes){
					$isChanged = true;
					$oldNotes = !empty($asset->notes) ? $asset->notes : "none";
					$newNotes = !empty($notes) ? $notes : "none";
	
					$changes[$index] = 1+$index.".) notes (from <strong>".$oldNotes."</strong> to <strong>".$newNotes."</strong>)<br/>";
					$index+=1;
				}
	
				if($input["model_id"]!=$asset->model_id){
					$isChanged = true;
					$newModelName = Model::find($input["model_id"]);
						
					$newModel = !$newModelName ? "none" : $newModelName->name;
					$oldModel = empty($asset->model->name) ? "none" : $asset->model->name;
						
					$changes[$index] = 1+$index.".) model (from <strong>".$oldModel."</strong> to <strong>".$newModel."</strong>)<br/>";
					$index+=1;
				}
				
				if($input["location"]!=$asset->location){
					$isChanged = true;
					$newLocation = $input["location"];
				
					$newLocation = empty(trim($newLocation)) ? "none" : $newLocation;
					$oldLocation = empty($asset->location) ? "none" : $asset->location;
				
					$changes[$index] = 1+$index.".) asset location (from <strong>".$oldLocation."</strong> to <strong>".$newLocation."</strong>)<br/>";
					$index+=1;
				}
	
				if($input["warranty_start"]!=$asset->warranty_start){
					
					$oldWarrantyStart = !empty($asset->warranty_start) ? $asset->warranty_start : "none";
					$newWarrantyStart = !empty(trim($input["warranty_start"])) ? trim($input["warranty_start"]) : "none";
					
					$isChanged = true;
					$changes[$index] = 1+$index.".) warranty start date (from <strong>".$oldWarrantyStart."</strong> to <strong>".$newWarrantyStart."</strong>)<br/>";
					$index+=1;
				}
	
				if($input["warranty_end"]!=$asset->warranty_end){
					
					$oldWarrantyEnd = !empty($asset->warranty_end) ? $asset->warranty_end : "none";
					$newWarrantyEnd = !empty(trim($input["warranty_end"])) ? trim($input["warranty_end"]) : "none";
					
					$isChanged = true;
					$changes[$index] = 1+$index.".) warranty end date (from <strong>".$oldWarrantyEnd."</strong> to <strong>".$newWarrantyEnd."</strong>)<br/>";
					$index+=1;
				}
	
				if($input["asset_class_id"]!=$asset->classification_id){
					$isChanged = true;
					$newClassification = AssetClassification::find($input["asset_class_id"]);
					$changes[$index] = 1+$index.".) asset type (from <strong>".$asset->classification->name."</strong> to <strong>".$newClassification->name."</strong>)<br/>";
					$index+=1;
				}
	
				if($input["asset_status"]!=$asset->status){
					$isChanged = true;
					$changes[$index] = 1+$index.".) status (from <strong>".$asset->status."</strong> to <strong>".$input["asset_status"]."</strong>)<br/>";
					$index+=1;
				}
	
				if(!$isChanged){
					Input::flash();
					return Redirect::to('assets/office/update/'.$input["asset_key"].'/'.$asset->id)->with('info',"Nothing has changed. </3");
				}
	
				else{
	
					//Save updates
					$asset->asset_tag = $input["asset_tag"];
					$asset->serial_number = trim($input["serial_number"])!=null ? trim($input["serial_number"]) : null;
					$asset->notes = !empty($notes) ? $notes : null;
					$asset->model_id = $input["model_id"]!=null ? $input["model_id"] : null;
					$asset->location = !empty(trim($input["location"])) ? trim($input["location"]) : null;
					$asset->warranty_start = trim($input["warranty_start"])!=null ? trim($input["warranty_start"]) : null;
					$asset->warranty_end = trim($input["warranty_end"]) ? trim($input["warranty_end"]) : null;
					$asset->classification_id = $input["asset_class_id"];
					$asset->status = $input["asset_status"];
					$asset->save();
						
					$changesMade = implode($changes,"");
					$desc = "(".Session::get('user_type').") "."<strong>".Session::get('username')."</strong> has updated office asset <strong>".$asset->asset_tag."'s</strong> information. These are the fields that have been modified:<br/>".$changesMade;
	
	
					//Log the changes made
					$newLog = new UserLog;
					$newLog->description = $desc;
					$newLog->user_id = Session::get('user_id');
					$newLog->type="System";
	
					$newLog->save();
						
					//Parallel logging to asset logs
					$assetLog = new AssetLog;
					$assetLog->asset_id = $asset->id;
					$assetLog->user_id = Session::get("user_id");
					$assetLog->description = $desc;
					$assetLog->transaction = "Updates";
					$assetLog->save();
	
					return Redirect::to('assets/office/update/'.$input["asset_key"]."/".$asset->id)->with('success',"You have successfully updated the network asset information.");
	
				}
			}
		}
			
		else{
			return Redirect::to("/");
		}
	}
	
	public function logAsLost($id){
			
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
	
			$view = View::make("Assets.Office.office_asset_lost");
	
			$asset = Asset::where("id","=",$id)->whereHas("classification",function($query){
				$query->where("type","=","Office");
			})->first();
	
			if(!$asset){
				return Redirect::to("assets/office");
			}
			
			if($asset->status=="Lost"){
				return Redirect::to("assets/office/update/".$asset->classification->url_key."/".$asset->id);
			}
	
			$view->asset = $asset;
			$view->nav = "assets";
			return $view;
		}
			
		else{
			return Redirect::to("/");
		}
	}
	
	public function lost(){
	
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
	
			$asset = Asset::where("id","=",Input::get("id"))->whereHas("classification",function($query){
				$query->where("type","=","Office");
			})->first();
				
			$input = Input::all();
	
			if(!$asset){
				return Redirect::to("assets/office");
			}
			
			if($asset->status=="Lost"){
				return Redirect::to("assets/office/update/".$asset->classification->url_key."/".$asset->id);
			}
	
			$validator = Validator::make(
					array("employee number"=>trim(Input::get("employee_number"))),
					array("employee number"=>"numeric|exists:tbl_employees,employee_number")
			);
	
			if($validator->fails()){
				return Redirect::to("assets/office/lostasset/".Input::get("id"))->withInput()->with("message",$validator->messages()->first());
			}
	
			else if($input["employee_number"]!=null && !empty($asset->employee->last_name) && $asset->employee_number==$input["employee_number"]){
				return Redirect::to("assets/office/lostasset/".Input::get("id"))->withInput()->with("message","Cannot reassign an asset to the same employee.");
			}
	
			else{
	
				if(!empty($asset->employee->last_name)){
	
					if($input["employee_number"]!=null){
	
						//Get the employee
						$employee = Employee::where("employee_number","=",$input["employee_number"])->first();
						$desc = "Office Asset <strong>".$asset->asset_tag."</strong>, SN: <strong>".$asset->serial_number."</strong> lost by <strong>".$asset->employee->first_name." ".$asset->employee->last_name."</strong> and assigned to employee <strong>".$employee->first_name." ".$employee->last_name."</strong>.";
	
						//Reassign the asset to the employee
						$asset->employee_number = $employee->employee_number;
						$asset->status = "Lost";
						$asset->save();
	
					}
	
					else{
						$desc = "Office Asset <strong>".$asset->asset_tag."</strong>, SN: <strong>".$asset->serial_number."</strong> lost by <strong>".$asset->employee->first_name." ".$asset->employee->last_name."</strong>.";
	
						$asset->status = "Lost";
						$asset->save();
					}
				}
	
				else{
	
					if($input["employee_number"]!=null){
	
						//Get the employee
						$employee = Employee::where("employee_number","=",$input["employee_number"])->first();
						$desc = "Office Asset <strong>".$asset->asset_tag."</strong>, SN: <strong>".$asset->serial_number."</strong> lost and assigned to <strong>".$employee->first_name." ".$employee->last_name."</strong>.";
	
						//Reassign the asset to the employee
						$asset->employee_number = $employee->employee_number;
						$asset->save();
	
					}
	
					else{
						$asset->status = "Lost";
						$asset->save();
						$desc = "Office Asset <strong>".$asset->asset_tag."</strong>, SN: <strong>".$asset->serial_number."</strong> lost.";
					}
				}
	
				//Log to asset logs
				$assetLog = new AssetLog;
				$assetLog->user_id = Session::get("user_id");
				$assetLog->asset_id = $asset->id;
				$assetLog->employee_id = !empty($asset->employee->id) ? $asset->employee->id : null;
				$assetLog->description = $desc;
				$assetLog->transaction = "History";
	
				$assetLog->save();
	
				return Redirect::to("assets/office/update/".$asset->classification->url_key."/".Input::get("id"))->with("success","You have successfully logged the transaction.");
	
			}
		}
	
		else{
			return Redirect::to("/");
		}
	}
	
	public function transferAsset($id){
			
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
	
			$view = View::make("Assets.Office.office_transfer_asset");
	
			$asset = Asset::where("id","=",$id)->whereHas("classification",function($query){
				$query->where("type","=","Office");
			})->first();
	
			if(!$asset){
				return Redirect::to("assets/office");
			}
			
			if($asset->status=="Lost"){
				return Redirect::to("assets/office/update/".$asset->classification->url_key."/".$asset->id);
			}
	
			$view->asset = $asset;
			$view->nav = "assets";
			return $view;
		}
			
		else{
			return Redirect::to("/");
		}
	}
	
	public function transfer(){
			
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
				
			$asset = Asset::where("id","=",Input::get("id"))->whereHas("classification",function($query){
				$query->where("type","=","Office");
			})->first();
				
			$input = Input::all();
				
			if(!$asset){
				return Redirect::to("assets/office");
			}
			
			if($asset->status=="Lost"){
				return Redirect::to("assets/office/update/".$asset->classification->url_key."/".$asset->id);
			}
				
			$validator = Validator::make(
					array(
							"employee number"=>trim($input["employee_number"]),
							"asset status"=>$input["asset_status"]
					),
					array(
							"employee number"=>"required|numeric|exists:tbl_employees,employee_number",
							"asset status"=>"required|in:Available,For Repair,Installed,Retired,PWU"
					)
			);
				
			if($validator->fails()){
				return Redirect::to("assets/office/transferasset/".Input::get("id"))->withInput()->with("message",$validator->messages()->first());
			}
				
			else if($input["employee_number"]!=null && !empty($asset->employee->last_name) && $asset->employee_number==$input["employee_number"]){
				return Redirect::to("assets/office/transferasset/".Input::get("id"))->withInput()->with("message","Cannot transfer an asset to the same employee.");
			}
				
			else if($asset->status!="Lost" && Employee::where("employee_number","=",$input["employee_number"])->whereIn("status",array("OJT Graduate","Graduate","Resigned","Obsolete"))->first()){
				Input::flash();
				return Redirect::to("assets/office/transferasset/".Input::get("id"))->with('message', "Cannot assign asset to employees no longer working in the company.");
			}
				
			else{
					
				if(!empty($asset->employee->last_name)){
						
					//Get the employee
					$employee = Employee::where("employee_number","=",$input["employee_number"])->first();
					$desc = "Office Asset <strong>".$asset->asset_tag."</strong>, SN: <strong>".$asset->serial_number."</strong> transferred from <strong>".$asset->employee->first_name." ".$asset->employee->last_name."</strong> and assigned to employee <strong>".$employee->first_name." ".$employee->last_name."</strong>, with status <strong>".$input["asset_status"]."</strong>.";
						
					//Reassign the asset to the employee
					$asset->employee_number = $employee->employee_number;
					$asset->status = $input["asset_status"];
					$asset->save();
						
				}
					
				else{
						
					//Get the employee
					$employee = Employee::where("employee_number","=",$input["employee_number"])->first();
					$desc = "Office Asset <strong>".$asset->asset_tag."</strong>, SN: <strong>".$asset->serial_number."</strong> transferred to <strong>".$employee->first_name." ".$employee->last_name."</strong>, with status <strong>".$input["asset_status"]."</strong>.";
						
					//Reassign the asset to the employee
					$asset->employee_number = $employee->employee_number;
					$asset->status = $input["asset_status"];
					$asset->save();
						
				}
					
				//Log to asset logs
				$assetLog = new AssetLog;
				$assetLog->user_id = Session::get("user_id");
				$assetLog->asset_id = $asset->id;
				$assetLog->employee_id = !empty($asset->employee->id) ? $asset->employee->id : null;
				$assetLog->description = $desc;
				$assetLog->transaction = "History";
					
				$assetLog->save();
					
				return Redirect::to("assets/office/transferasset/".Input::get("id"))->with("success","You have successfully transferred the asset.");
					
			}
		}
			
		else{
			return Redirect::to("/");
		}
	}
	
	public function import(){
			
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get("user_type")=="Admin")){
			
			$view = View::make("Assets.Office.import_office");
			$view->nav = "assets";
			$view->tab = "import";
	
			$getAssetClassifications = AssetClassification::where("type","=","Office")->get();
			$assetClassifications = array("--Select One--");
				
			foreach($getAssetClassifications as $gac){
				$assetClassifications[$gac->id]=$gac->name;
			}
	
			$view->assetClassifications = $assetClassifications;
			return $view;
		}
			
		else{
			return Redirect::to("/");
		}
	}
	
	public function postImport(){
			
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
	
			$validator = Validator::make(
					array(
							"asset type"=>Input::get("asset_class_id")
					),
					array(
							"asset type"=>"required|exists:tbl_asset_classifications,id"
					)
			);
	
			if($validator->fails()){
				return Redirect::to('assets/office/import')->withInput()->with('message',"Please select an asset type.");
			}
			
			else if(!AssetClassification::where("id","=",Input::get("asset_class_id"))->where("type","=","Office")->first()){
				return Redirect::to('assets/office/import')->withInput()->with('message',"Please select an office asset type.");
			}
	
			else if(!Input::hasFile('file')){
				return Redirect::to('assets/office/import')->withInput()->with('message',"Please select a valid excel file.");
			}
				
			else{
				return $this->processImport(Input::file("file"),Input::get("asset_class_id"));
			}
				
		}
			
		else{
			return Redirect::to('/');
		}
	}
	
	private function processImport($file,$assetClass){
	
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
				
				
			if(!in_array($file->getClientOriginalExtension(),array("xls","xlsx","csv"))){
				Input::flash();
				return Redirect::to('assets/office/import')->with('message',"Invalid file selected.");
			}
				
			else{
					
				$filename = "upload-".str_random(9).".".$file->getClientOriginalExtension();
				$file->move("uploads",$filename);
					
				$readFile = "uploads/".$filename;
				$reader = Excel::selectSheetsByIndex(0)->load($readFile, function($reader){})->get();
					
					
				/*
				 * 				Before validating each rows of the file uploaded, the file itself is checked if it has the valid attributes (columns)
				* 				using the algorithm found below.
				*
				* 				1. File is read.
				* 				2. Boolean variable $excelIsValid to check if the file is valid. Set to false by default.
				*
				*/
				$excelChecker = Excel::selectSheetsByIndex(0)->load($readFile, function($reader){})->get()->toArray();
				$excelIsValid = false;
					
				/*
				 * 				3. Loop through the excel file and check if at least once all the columns have been present.
				* 				4. If it does, $excelIsValid is set to true.
				* 				5. If $excelIsValid is still false by end of the loop, it is automatically assumed that the file is:
				* 					A.) Empty
				* 					B.) Does not have the right attributes.
				* 					C.) Has valid columns, but does not have any valid entry.
				*
				*/
				foreach($excelChecker as $ex){
						
					if(isset($ex["assettag"]) && isset($ex["serialnumber"]) && isset($ex["status"])){
						$excelIsValid = true;
					}
						
				}
					
				/*				6. If file is invalid, redirect to import form and return an error. */
					
				if(!$excelIsValid){
					Input::flash();
					File::delete($readFile);
					return Redirect::to('assets/office/import')->with('message',"Excel file has invalid attributes. Please download the form.");
				}
					
				/*
				 * 				CHECKING EXCEL FILE FOR ERRORS WHILE READING THE ROWS
				*
				* 				1. $hasError is a Boolean variable that is simply used to tell if any error has been found.
				* 					This variable is, by default, set to false. If any error has been detected, it is set to true,
				* 					regardless of how many errors has been detected.
				*
				* 				2. $rowIndex indexes which row the reader is currently reading. Default value set to 1 because
				* 					the first row of excel files is automatically set as the attribute row. When the reader reads each row,
				* 					$rowIndex is incremented. For example, reader is currently reading row 2, $rowIndex will then be incremented,
				* 					setting its value to 2, thus the row number.
				*
				* 				3. $rowsWithErrors is the array of the rows with errors. To explain further, let's say excel file has 10 readable (non-attrib)
				* 					rows. No errors were found from rows number 2-8, but errors were found in rows 9, 10, and 11. These 9, 10, and 11
				* 					will then be in the $rowsWithError.
				*
				* 				4. $error array is the variable that will be used to collect all errors found from the excel file.
				* 					This is a two-dimensional array.
				*
				*
				*/
					
				$hasError = false; //Detects if there are any errors.
				$hasCorrectRows = false;
				$rowIndex=1; //Indexes which row the reader is reading.
				$rowsWithErrors = array(); //This is used to contain in an array the row numbers of the rows with error.
				$error=array(); //Error details collector.
					
				foreach($reader as $r){
						
					/*
					 * 				5. Here, we immediately increment the value of $rowIndex, since the variable will be used in the core logic of this method.
					*
					* 				6. $errorCount variable is a variable used in every loop. Set to 0 when the loop begins, so it always comes back to 0 for every loop.
					* 					$errorCount is used to track the number of errors for the current row. This variable goes hand in hand with the
					* 					$rowsWithError array when publishing the rows with errors, and the error details for each row with error.
					*
					* 					This is how $rowsWithError and $rowCount will be used:
					*
					* 					for each $rowWithErrors:
					* 						Row $rowWithErrors Index:
					* 							Errors Found :
					* 							$rowCount 1. Foo bar
					* 							$rowCount 2. Jane Doe etc..
					*
					*
					*/
						
					$rowIndex+=1;
					$errorCount = 0; //Counts the number of errors for the currect row.
					$rowHasError = false; //Check if this row has error. I will use this before the reading of the row ends.
					//					If $rowHasError is still false by end of the reading, then I will write it in the database.

					
	
					$warranty_start = !empty(trim($r->warrantystart)) ? trim($r->warrantystart) : "1994-04-16";
					
					$validator = Validator::make(
							array(
									"asset tag"=>trim($r->assettag),
									"serial number"=>trim($r->serialnumber),
									"model"=>trim($r->modelid),
									"employee number"=>trim($r->employeenumber),
									"status"=>trim($r->status),
									"warranty start date"=>trim($r->warrantystart),
									"warranty end date"=>trim($r->warrantyend),
							),
							array(
									"asset tag"=>"required|unique:tbl_assets,asset_tag",
									"serial number"=>"required|unique:tbl_assets,serial_number",
									"model"=>"exists:tbl_asset_models,id",
									"employee number"=>"numeric|exists:tbl_employees,employee_number",
									"status"=>"required|in:Available,PWU,For Repair,Installed,Lost,Retired,For Borrowing",
									"warranty start date"=>"required_with:warranty end date|date:Y-m-d",
									"warranty end date"=>"date:Y-m-d|after:".$warranty_start,
							),
							array(
									"after"=>"The :attribute must be after the warranty start date."
							)
					);
						
					if($validator->fails()){
							
						/* 					7. When error has been found, $rowsWithError is immediately updated. Also, $hasError and $rowHasError are set to true.*/
						$hasError=true;
						$rowHasError=true;
						$rowsWithErrors[$rowIndex]=$rowIndex;
							
						/* 					8. Then I will check which fields have errors.
						 *
						*					9. If an error has been found in a certain field,
						*					   I will loop through the errors found on that field, increment the $errorCount (which, again, tracks
								*					   how many errors has been found on a certain row.), update the two-dimensional $error array.
						*					   Please note that the first array of $error contains the row number which the errors found belong to.
						*
						*/
						if($validator->messages()->get("asset tag")){
								
							foreach($validator->messages()->get("asset tag") as $e){
								$errorCount+=1;
								$error[$rowIndex][$errorCount] = $errorCount.". ".$e . "<br/>";
	
							}
						}
	
						if($validator->messages()->get("serial number")){
							foreach($validator->messages()->get("serial number") as $e){
								$errorCount+=1;
								$error[$rowIndex][$errorCount] = $errorCount.". ".$e . "<br/>";
	
							}
						}
							
						if($validator->messages()->get("model")){
							foreach($validator->messages()->get("model") as $e){
								$errorCount+=1;
								$error[$rowIndex][$errorCount] = $errorCount.". ".$e . "<br/>";
									
							}
						}
							
						if($validator->messages()->get("employee number")){
							foreach($validator->messages()->get("employee number") as $e){
								$errorCount+=1;
								$error[$rowIndex][$errorCount] = $errorCount.". ".$e . "<br/>";
	
							}
						}
							
						if($validator->messages()->get("status")){
							foreach($validator->messages()->get("status") as $e){
								$errorCount+=1;
								$error[$rowIndex][$errorCount] = $errorCount.". ".$e . "<br/>";
	
							}
						}
							
						if($validator->messages()->get("warranty start date")){
							foreach($validator->messages()->get("warranty start date") as $e){
								$errorCount+=1;
								$error[$rowIndex][$errorCount] = $errorCount.". ".$e . "<br/>";
	
							}
						}
							
						if($validator->messages()->get("warranty end date")){
							foreach($validator->messages()->get("warranty end date") as $e){
								$errorCount+=1;
								$error[$rowIndex][$errorCount] = $errorCount.". ".$e . "<br/>";
									
							}
						}
							
					}
						
					if($r->status!="Lost" && Employee::where("employee_number","=",$r->employeenumber)->whereIn("status",array("OJT Graduate","Graduate","Resigned","Obsolete"))->first()){
						$hasError=true; //This will only matter if no errors has been found above.
						$rowHasError=true; //This will only matter if no errors has been found above.
						$rowsWithErrors[$rowIndex]=$rowIndex; //This will only matter if no errors has been found above.
	
						$errorCount+=1;
						$error[$rowIndex][$errorCount] = $errorCount.". " . "Cannot assign an asset to employees no longer working in the company." . "<br/>";
					}
	
					if($r->modelid!=null && !Model::where("classification_id","=",$assetClass)->where("id","=",$r->modelid)->first()){
						$hasError=true; //This will only matter if no errors has been found above.
						$rowHasError=true; //This will only matter if no errors has been found above.
						$rowsWithErrors[$rowIndex]=$rowIndex; //This will only matter if no errors has been found above.
							
						$errorCount+=1;
						$error[$rowIndex][$errorCount] = $errorCount.". " . "The asset model does not belong to the selected asset type." . "<br/>";
					}
						
					if(!$rowHasError){
							
						$hasCorrectRows = true;
						//To set image as null if asset class is not laptop.
							
						//Add the new asset
						$asset = new Asset;
						$asset->asset_tag = trim($r->assettag);
						$asset->serial_number = trim($r->serialnumber)!=null ? trim($r->serialnumber) : null;
						$asset->model_id = $r->modelid!=null ? $r->modelid : null;
						$asset->location = $r->location!=null ? $r->location : null;
						$asset->employee_number = $r->employeenumber!=null ? trim($r->employeenumber) : null;
						$asset->warranty_start = trim($r->warrantystart)!=null ? trim($r->warrantystart) : null;
						$asset->warranty_end = trim($r->warrantyend)!=null ? $r->warrantyend : null;
						$asset->classification_id = $assetClass;
						$asset->status = trim($r->status);
						$asset->notes = trim($r->notes)!=null ? trim($r->notes) : null;
						$asset->date_added = date("Y-m-d H:i:s");
						
						$asset->save();
	
						//Log the new asset to asset logs
						if(!empty(trim($r->employeenumber))){
							$employee = Employee::where("employee_number","=",$r->employeenumber)->first();
							$desc = "Office Asset <strong>".$asset->asset_tag.",</strong> SN: <strong>".$asset->serial_number."</strong> added to the database and assigned to employee <strong>".$employee->first_name." ".$employee->last_name."</strong> with asset status <strong>".$asset->status."</strong>.";
						}
							
						else{
							$desc = "Office Asset <strong>".$asset->asset_tag."</strong>, SN: <strong>".$asset->serial_number."</strong> added to the database with status <strong>".$asset->status."</strong>.";
						}
							
						$assetLog = new AssetLog;
						$assetLog->user_id = Session::get("user_id");
						$assetLog->asset_id = $asset->id;
						$assetLog->employee_id = !empty($asset->employee->id) ? $asset->employee->id : null;
						$assetLog->description = $desc;
						$assetLog->transaction = "History";
						$assetLog->save();
						
						//Parallel logging to system logs
						$desc = "(".Session::get('user_type').") "."<strong>".Session::get('username')."</strong> added office asset <strong>".$asset->asset_tag."</strong>, SN: <strong>".$asset->serial_number."</strong> ";
						$newLog = new UserLog;
						$newLog->description = $desc;
						$newLog->user_id = Session::get('user_id');
						$newLog->type="System";
						
						$newLog->save();
							
					}
				}
					
				File::delete($readFile);
					
				if($hasCorrectRows){
				
					//Log the changes made
					$desc = "(".Session::get("user_type").") <b>".Session::get("username")."</b> has imported data to office assets database. ";
						
					$newLog = new UserLog;
					$newLog->description = $desc;
					$newLog->user_id = Session::get('user_id');
					$newLog->type="System";
					
					$newLog->save();
					
				}
					
				return $this->importResult($hasError, $hasCorrectRows, $rowsWithErrors, $error);
	
			}
		}
	
		else{
			return Redirect::to('/');
		}
	}
	
	private function importResult($fileHasError, $hasCorrectRows, $rowsWithErrors=null, $errorDetails=null){
	
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
				
			$view = View::make("Assets.Office.import_office_result");
			$view->fileHasError = $fileHasError;
				
			if($rowsWithErrors!=null){
				$view->rowsWithErrors = $rowsWithErrors;
				$view->errorDetails = $errorDetails;
			}
	
			$view->hasCorrectRows = $hasCorrectRows;
			$view->nav="assets";
				
			return $view;
				
		}
	
		else{
			return Redirect::to('/');
		}
	
	}
	
	public function deleteAssets(){
	
		if(Session::has('username') && (Session::get('user_type')=="Root")){
	
			$assets = Input::get("asset_id");
			$hasDeletedAny=false;
			$noOfDeletedAssets = 0;
				
			foreach($assets as $a){
	
				$asset = Asset::where("id","=",$a)->whereHas("classification",function($query){
					$query->where("type","=","Office");
				})->first();
	
				if(!$asset){
					continue;
				}
	
	
				$desc = "(".Session::get('user_type').") "."<strong>".Session::get('username')."</strong> has deleted office asset ( type: ".$asset->classification->name.") <strong>".$asset->asset_tag."</strong>, SN: <strong>".$asset->serial_number."</strong>.";
	
				//Log the changes made
				$newLog = new UserLog;
				$newLog->description = $desc;
				$newLog->user_id = Session::get('user_id');
				$newLog->type="System";
	
				$newLog->save();
	
				$hasDeletedAny = true;
				$noOfDeletedAssets+=1;
	
				$asset->delete();
	
			}
				
			if($hasDeletedAny){
					
				$desc = "(".Session::get('user_type').") "."<strong>".Session::get('username')."</strong> has deleted <strong>".$noOfDeletedAssets."</strong> office asset(s).";
				//Log the changes made
				$newLog = new UserLog;
				$newLog->description = $desc;
				$newLog->user_id = Session::get('user_id');
				$newLog->type="System";
				
				$newLog->save();
					
			}
				
			return Redirect::to(Session::get("page"));
		}
			
		else{
			return Redirect::to("/");
		}
	}
	
	public function redirector($assetClassId,$intent,$id=null){
			
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
	
			//This method works like magic.
			$assetClassification = AssetClassification::where("id","=",$assetClassId)->where("type","=","Office")->first();
				
			if(!$assetClassification){
				return Redirect::to("assets/office");
			}
				
			if($intent=="add"){
				return Redirect::to("assets/office/add/".$assetClassification->url_key);
			}
				
			return Redirect::to("assets/office/update/".$assetClassification->url_key."/".$id);
		}
			
		else{
			return Redirect::to("/");
		}
	}
	
}