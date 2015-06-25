<?php

class LABController extends BaseController{
	
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
			Session::put('user_class',$user->user_class);
		}
	}
	
	public function index($sortby=null,$order=null){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin" || Session::get("user_type")=="User")){
		
			$view = View::make("Assets.LAB.generalinfo");
			$view->nav = "assets";
			$view->tab = "General Information";
		
			if(empty($sortby) || empty($order)){
				$software = Software::orderBy("asset_tag")->paginate(25);
			}
		
			else{
				$software = Software::orderBy($sortby,$order)->paginate(25);
			}
		
			$result = Software::count();
		
		
			$view->sortby= $sortby;
			$view->order=$order;
		
			$view->software = $software;
			$view->result = $result;
		
			return $view;
		
		}
		
		else{
			return Redirect::to('/');
		}
	}
	
	public function search(){
	
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin" || Session::get("user_type")=="User")){
			
			$keyword = trim(stripslashes(Input::get('keyword')));
			$keyword = preg_replace('{/$}', '', $keyword);
	
			if(!empty($keyword)){
				//The withInput() extension to the URL is used to flash the search keyword the user has used.
				return Redirect::to('assets/software/search/'.urlencode($keyword))->withInput();
			}
	
			else{
				return Redirect::to('assets/software/view');
			}
		}
	
		else{
			return Redirect::to('/');
		}
	
	}
	
	public function searchKeyword($keyword,$sortby=null,$order=null){
	
			
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin" || Session::get("user_type")=="User")){
	
			$view = View::make('Assets.Software.software_assets');
			$view->nav="assets";
			$view->intent="search";
			$view->tab = "software";
			
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
	
				$view->software = Software::where(function($query) use($keyword,$keywordRaw){
					$query->where("product_key","=",$keyword)
					->orWhere("asset_tag","=",$keyword)
					->orWhereHas("employee",function($query) use($keyword,$keywordRaw){
						$query->whereRaw("concat(last_name,' ',first_name) LIKE $keywordRaw"); })
					->orWhereHas("employee",function($query) use($keyword,$keywordRaw){
						$query->whereRaw("concat(first_name,' ',last_name) LIKE $keywordRaw"); });
				})->orderBy("asset_tag","asc")
				->paginate(25);
					
			}
	
			else{
	
				if(!in_array($sortby,array("asset_tag","serial_number","model_id","warranty_start","warranty_end")) || !in_array($order,array("asc","desc"))){
					return Redirect::to('assets/office/view/'.$assetClass);
				}
					
				$view->assets = Software::where(function($query) use($keyword,$keywordRaw){
					$query->where("product_key","=",$keyword)
					->orWhere("asset_tag","=",$keyword)
					->orWhereHas("employee",function($query) use($keyword,$keywordRaw){
						$query->WhereRaw("concat(last_name,' ',first_name) LIKE $keywordRaw"); })
					->orWhereHas("employee",function($query) use($keyword,$keywordRaw){
						$query->WhereRaw("concat(first_name,' ',last_name) LIKE $keywordRaw"); });
				})->orderBy($sortby,$order)
				->paginate(25);
			}
	
			$view->result =  Software::where(function($query) use($keyword,$keywordRaw){
					$query->where("product_key","=",$keyword)
					->orWhere("asset_tag","=",$keyword)
					->orWhereHas("employee",function($query) use($keyword,$keywordRaw){
						$query->WhereRaw("concat(last_name,' ',first_name) LIKE $keywordRaw"); })
					->orWhereHas("employee",function($query) use($keyword,$keywordRaw){
						$query->WhereRaw("concat(first_name,' ',last_name) LIKE $keywordRaw"); });
			})->count();
	
			$view->sortby=$sortby;
			$view->order=$order;

			return $view;
		}
	
		else{
			return Redirect::to('/');
		}
	
	}
	
	public function advancedSearch(){
			
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin" || Session::get("user_type")=="User")){
	
			$view = View::make("Assets.Software.software_advanced_search");
			
			$view->nav = "assets";
			$view->tab = "search";
			
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
	
	public function advancedSearchAssets(){
			
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin" || Session::get("user_type")=="User")){
	
			$view = View::make("Assets.Software.software_advanced_search");
			$view->nav="assets";
			$view->tab = "search";
	
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
	
		else{
			return Redirect::to("/");
		}
	}
	
	public function logs($id){
			
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin" || Session::get("user_type")=="User")){
	
			$view = View::make("Assets.Software.software_logs");
			$view->nav = "assets";
	
			$software = Software::find($id);
	
			if(!$software){
				return Redirect::to("assets/software");
			}
	
			$view->software = $software;
			
			if(Session::get("user_type")=="Root" || Session::get("user_type")=="Admin"){
				
				$view->transaction = "all";
				$view->logs = SoftwareLog::where("software_id","=",$id)->orderBy("datetime","desc")->paginate(25);
				$view->logCount = SoftwareLog::where("software_id","=",$id)->count();
			}
	
			else{
				$view->logs = SoftwareLog::where("software_id","=",$id)->where("transaction","=","History")->orderBy("datetime","desc")->paginate(25);
				$view->logCount = SoftwareLog::where("software_id","=",$id)->where("transaction","=","History")->count();
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
				return Redirect::to("assets/software/logs/".$id);
			}
				
			$view = View::make("Assets.Software.software_logs");
			$view->nav = "assets";
	
			$software = Software::find($id);
	
			if(!$software){
				return Redirect::to("assets/software");
			}
	
			$view->software = $software;
	
			if(!in_array($transaction,array("history","updates"))){
				return Redirect::to("assets/software/logs/".$id);
			}
	
			$view->transaction = $transaction;
			
			$view->logs = SoftwareLog::where("software_id","=",$id)
							->where("transaction","=",$transaction)
							->orderBy("datetime","desc")
							->paginate(25);
			
			$view->logCount = SoftwareLog::where("software_id","=",$id)
							->where("transaction","=",$transaction)
							->count();
	
			return $view;
		}
	
		else{
			return Redirect::to("/");
		}
	
	}
	
	public function addAsset(){
			
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
	
			$view = View::make("Assets.Software.add_software_asset");
	
			$view->nav = "assets";
			$view->tab = "software";
				
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
	
	public function submitNewAsset(){
			
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
	
			$input = Input::all();
			$warranty_start = $input["warranty_start"]!=null ? $input["warranty_start"] : "1994-04-16";
			$notes = Input::get("notes")!=null ? trim(Input::get("notes")) : "";
	
			$validator = Validator::make(
					array(
							"software asset tag"=>$input["asset_tag"],
							"product key"=>$input["product_key"],
							"employee number"=>trim($input["employee_number"]),
							"laptop"=>$input["serial_number"],
							"software type"=>$input["software_type"],
							"warranty start date"=>$input["warranty_start"],
							"warranty end date"=>$input["warranty_end"],
							"status"=>$input["asset_status"],
					),
					array(
							"software asset tag"=>"required|unique:tbl_software_assets,asset_tag|unique:tbl_assets,asset_tag",
							"product key"=>"required",
							"employee number"=>"exists:tbl_employees,employee_number",
							"laptop"=>"exists:tbl_assets,serial_number",
							"software type"=>"required|exists:tbl_software_types,id",
							"warranty start date"=>"required_with:warranty end date|date:Y-m-d",
							"warranty end date"=>"date:Y-m-d|after:".$warranty_start,
							"status"=>"required|in:Available,PWU,Retired,Test Case,Lost",
					)
			);
	
			if($validator->fails()){
				Input::flash();
				return Redirect::to('assets/software/add/')->with('message', $validator->messages()->first());
			}
	
			else if(Employee::where("employee_number","=",$input["employee_number"])->whereIn("status",array("OJT Graduate","Graduate","Resigned","Obsolete"))->first()){
				Input::flash();
				return Redirect::to('assets/software/add/')->with('message', "Cannot assign software asset to employees no longer working in the company.");
			}
			
			else if(!empty(trim($input["serial_number"])) && !Asset::where("serial_number","=",$input["serial_number"])->whereHas("classification",function($q){ $q->where("name","=","Laptops"); })->first()){
				Input::flash();
				return Redirect::to('assets/software/add/')->with('message', "Cannot assign software asset to non-laptop assets. Please check the serial number and try again.");
			}
	
			else{
	
				//Create the asset
				$software = new Software;
				$software->asset_tag = trim($input["asset_tag"]);
				$software->product_key = trim($input["product_key"]);
				$software->employee_number = trim($input["employee_number"])!=null ? trim($input["employee_number"]) : null;
				$software->assigned_to_serial_number = trim($input["serial_number"])!=null ? trim($input["serial_number"]) : null;
				$software->location = trim($input["location"])!=null ? trim($input["location"]) : null;
				$software->software_type_id = $input["software_type"];
				$software->warranty_start = $input["warranty_start"];
				$software->warranty_end = $input["warranty_end"];
				$software->status = $input["asset_status"];
				$software->notes = trim($input["notes"])!=null ? trim($input["notes"]) : null;
				$software->date_added = date("Y-m-d H:i:s");
					
				$software->save();
	
				//Log the new asset to asset logs
				if(!empty(trim($input["employee_number"]))){
					$employee = Employee::where("employee_number","=",Input::get("employee_number"))->first();
					$desc = "Software Asset <strong>".$software->asset_tag."</strong> added to the database and assigned to employee <strong>".$employee->first_name." ".$employee->last_name."</strong> with asset status <strong>".$software->status."</strong>.";
				}
					
				else{
					$desc = "Software Asset <strong>".$software->asset_tag."</strong> added to the database with status <strong>".$software->status."</strong>.";
				}
					
				$softwareLog = new SoftwareLog;
				$softwareLog->user_id = Session::get("user_id");
				$softwareLog->software_id = $software->id;
				$softwareLog->employee_id = !empty($software->employee->id) ? $software->employee->id : null;
				$softwareLog->description = $desc;
				$softwareLog->transaction = "History";
				$softwareLog->save();
					
				//Parallel logging to system logs
				$desc = "(".Session::get('user_type').") "."<strong>".Session::get('username')."</strong> added software asset <strong>".$software->asset_tag."</strong>.";
				$newLog = new UserLog;
				$newLog->description = $desc;
				$newLog->user_id = Session::get('user_id');
				$newLog->type="System";
	
				$newLog->save();
					
				return Redirect::to('assets/software/add')->with('success',"You have successfully added a new software asset.");
	
			}
	
		}
			
		else{
			return Redirect::to("/");
		}
	}
	
	public function updateAsset($id){
			
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
	
			$view = View::make("Assets.Software.update_software_asset");
			$view->nav = "assets";
			$view->tab = "software";
	
			
			$software = Software::find($id);
	
			if(!$software){
				return Redirect::to('assets/software');
			}
	
			$view->software = $software;
	
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
	
	public function submitAssetUpdate(){
			
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
	
			$input = Input::all();
			$software = Software::find($input["id"]);
			
			if(!$software){
				return Redirect::to("assets/software");
			}
			
			if(Session::get("user_type")!="Root" && $software->status=="Lost"){
				return Redirect::to("assets/software/update/".$software->id);
			}
	
			if($input["action"]==""){
				return Redirect::to('assets/software/update/'.$input["id"])->with('message',"Please select an action to commit.");
			}
	
			else if($input["action"]=="transfer"){
				return Redirect::to("assets/software/transferasset/".$input["id"]);
			}
	
			else if($input["action"]=="lost"){
				return Redirect::to("assets/software/lostasset/".$input["id"]);
			}
	
			if(Session::has("secure")){
				$product_key = trim($input["product_key"]!=null) ? trim($input["product_key"]) : null;
			}
			
			$warranty_start = $input["warranty_start"]!=null ? $input["warranty_start"] : "1994-04-16";
			$notes = Input::get("notes")!=null ? trim(Input::get("notes")) : "";
	
			$validator = Validator::make(
					array(
							"software asset tag"=>$input["asset_tag"],
							"laptop"=>$input["serial_number"],
							"software type"=>$input["software_type"],
							"warranty start date"=>$input["warranty_start"],
							"warranty end date"=>$input["warranty_end"],
							"status"=>$input["asset_status"],
					),
					array(
							"software asset tag"=>"required",
							"laptop"=>"exists:tbl_assets,serial_number",
							"software type"=>"required|exists:tbl_software_types,id",
							"warranty start date"=>"required_with:warranty end date|date:Y-m-d",
							"warranty end date"=>"date:Y-m-d|after:".$warranty_start,
							"status"=>"required|in:Available,PWU,Retired,Test Case",
					)
			);
	
	
			if($validator->fails()){
				Input::flash();
				return Redirect::to('assets/software/update/'.$input["id"])->with('message', $validator->messages()->first());
			}
	
			else if($software->asset_tag!=$input["asset_tag"] && (Software::where("asset_tag","=",$input["asset_tag"])->first() || Asset::where("asset_tag","=",$input["asset_tag"])->first())){
				Input::flash();
				return Redirect::to('assets/software/update/'.$input["id"])->with('message',"Asset tag already exists in the database. This field should be unique.");
			}
			
			else if(Session::has("secure") && Session::get("user_type")=="Root" && empty(trim($input["product_key"]))){
				Input::flash();
				return Redirect::to('assets/software/update/'.$input["id"])->with('message',"Product key is required.");
			}
			
			else if(!empty(trim($input["serial_number"])) && !Asset::where("serial_number","=",$input["serial_number"])->whereHas("classification",function($q){ $q->where("name","=","Laptops"); })->first()){
				Input::flash();
				return Redirect::to('assets/software/update/'.$input["id"])->with('message', "Cannot assign software asset to non-laptop assets. Please check the serial number and try again.");
			}
	
			else{
					
				//These variables are used to track if anything has been changed.
				$isChanged = false; //Boolean variable that checks if anything has been changed. Changes to true when a change has been detected.
				$changes = array(); //Collects the names of the columns that have been changed.
				$index=0; //Provides the index number of $changes array.
	
				if($input["asset_tag"]!=$software->asset_tag){
					
// 					$oldAssetTag = !empty($software->asset_tag) ? $software->asset_tag : "none";
// 					$newAssetTag = !empty(trim($input["asset_tag"])) ? trim($input["asset_tag"]) : "none";
					
					$isChanged = true;
					$changes[$index] = 1+$index.".) asset tag (from <strong>".$software->asset_tag."</strong> to <strong>".trim($input["asset_tag"])."</strong>)<br/>";
					$index+=1;
				}
					
				if(Session::has("secure") && Session::get("user_type")=="Root" && $input["product_key"]!=$software->product_key){
					$isChanged = true;
					//$changes[$index] = 1+$index.".) product key (from <strong>".$software->product_key."</strong> to <strong>".$input["product_key"]."</strong>)<br/>";
					$changes[$index] = 1+$index.".) product key (changes have been hidden).<br/>";
					$index+=1;
				}
				
				if($input["serial_number"]!=$software->assigned_to_serial_number){
					$isChanged = true;
					$changes[$index] = 1+$index.".) laptop assignment (from <strong>".$software->assigned_to_serial_number."</strong> to <strong>".$input["serial_number"]."</strong>)<br/>";
					$index+=1;
				}
				
				if($input["location"]!=$software->location){
					
					$newLocation = $input["location"];
					
					$newLocation = empty(trim($newLocation)) ? "none" : $newLocation;
					$oldLocation = empty($software->location) ? "none" : $software->location;
					
					$isChanged = true;
					$changes[$index] = 1+$index.".) location (from <strong>".$oldLocation."</strong> to <strong>".$newLocation."</strong>)<br/>";
					$index+=1;
				}
				
				if($input["software_type"]!=$software->software_type_id){
					
					$newSoftwareType = SoftwareType::find($input["software_type"]);
					
					$isChanged = true;
					$changes[$index] = 1+$index.".) software type (from <strong>".$software->type->software_type."</strong> to <strong>".$newSoftwareType->software_type."</strong>)<br/>";
					$index+=1;
				}
				
				if($input["warranty_start"]!=$software->warranty_start){
					
					$oldWarrantyStart = !empty($software->warranty_start) ? $software->warranty_start : "none";
					$newWarrantyStart = !empty(trim($input["warranty_start"])) ? trim($input["warranty_start"]) : "none";
					
					$isChanged = true;
					$changes[$index] = 1+$index.".) warranty start date (from <strong>".$oldWarrantyStart."</strong> to <strong>".$newWarrantyStart."</strong>)<br/>";
					$index+=1;
				}
				
				if($input["warranty_end"]!=$software->warranty_end){
					
					$oldWarrantyEnd = !empty($software->warranty_end) ? $software->warranty_end : "none";
					$newWarrantyEnd = !empty(trim($input["warranty_end"])) ? trim($input["warranty_end"]) : "none";
					
					$isChanged = true;
					$changes[$index] = 1+$index.".) warranty end date (from <strong>".$oldWarrantyEnd."</strong> to <strong>".$newWarrantyEnd."</strong>)<br/>";
					$index+=1;
				}
				
				if($input["asset_status"]!=$software->status){
					$isChanged = true;
					$changes[$index] = 1+$index.".) software asset status (from <strong>".$software->status."</strong> to <strong>".$input["asset_status"]."</strong>)<br/>";
					$index+=1;
				}
	
				if($notes!=$software->notes){
					$isChanged = true;
					$oldNotes = !empty($software->notes) ? $software->notes : "none";
					$newNotes = !empty($software) ? $notes : "none";
	
					$changes[$index] = 1+$index.".) notes (from <strong>".$oldNotes."</strong> to <strong>".$newNotes."</strong>)<br/>";
					$index+=1;
				}
	
				if(!$isChanged){
					Input::flash();
					return Redirect::to('assets/software/update/'.$software->id)->with('info',"Nothing has changed. </3");
				}
	
				else{
	
					//Save updates
					if(Session::has("secure") && Session::get("user_type")=="Root"){
						
						$software->asset_tag = $input["asset_tag"];
						$software->product_key = trim($input["product_key"]);
						$software->assigned_to_serial_number = trim($input["serial_number"])!=null ? trim($input["serial_number"]) : null;
						$software->location = !empty(trim($input["location"])) ? trim($input["location"]) : null;
						$software->software_type_id = $input["software_type"];
						$software->warranty_start = trim($input["warranty_start"])!=null ? trim($input["warranty_start"]) : null;
						$software->warranty_end = trim($input["warranty_end"]) ? trim($input["warranty_end"]) : null;
						$software->status = $input["asset_status"];
						$software->notes = !empty($notes) ? $notes : null;
						$software->save();
					}
					
					else{
						$software->asset_tag = $input["asset_tag"];
						$software->assigned_to_serial_number = trim($input["serial_number"])!=null ? trim($input["serial_number"]) : null;
						$software->location = !empty(trim($input["location"])) ? trim($input["location"]) : null;
						$software->software_type_id = $input["software_type"];
						$software->warranty_start = trim($input["warranty_start"])!=null ? trim($input["warranty_start"]) : null;
						$software->warranty_end = trim($input["warranty_end"]) ? trim($input["warranty_end"]) : null;
						$software->status = $input["asset_status"];
						$software->notes = !empty($notes) ? $notes : null;
						$software->save();
					}
					
					$changesMade = implode($changes,"");
					$desc = "(".Session::get('user_type').") "."<strong>".Session::get('username')."</strong> has updated software asset <strong>".$software->asset_tag."'s</strong> information. These are the fields that have been modified:<br/>".$changesMade;
	
	
					//Log the changes made
					$newLog = new UserLog;
					$newLog->description = $desc;
					$newLog->user_id = Session::get('user_id');
					$newLog->type="System";
	
					$newLog->save();
	
					//Parallel logging to asset logs
					$softwareLog = new SoftwareLog;
					$softwareLog->software_id = $software->id;
					$softwareLog->user_id = Session::get("user_id");
					$softwareLog->description = $desc;
					$softwareLog->transaction = "Updates";
					$softwareLog->save();
	
					return Redirect::to('assets/software/update/'.$software->id)->with('success',"You have successfully updated the software asset information.");
	
				}
			}
		}
			
		else{
			return Redirect::to("/");
		}
	}
	
	public function logAsLost($id){
			
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
	
			$view = View::make("Assets.Software.software_asset_lost");
			$software = Software::find($id);
	
			if(!$software){
				return Redirect::to("assets/software");
			}
			
			if($software->status=="Lost"){
				return Redirect::to("assets/software/update/".$software->id);
			}
	
			$view->software = $software;
			$view->nav = "assets";
			return $view;
		}
			
		else{
			return Redirect::to("/");
		}
	}
	
	public function lost(){
	
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
	
			
			$input = Input::all();
			$software = Software::find($input["id"]);
	
			if(!$software){
				return Redirect::to("assets/software");
			}
			
			if($software->status=="Lost"){
				return Redirect::to("assets/software/update/".$software->id);
			}
	
			$validator = Validator::make(
					array("employee number"=>trim(Input::get("employee_number"))),
					array("employee number"=>"numeric|exists:tbl_employees,employee_number")
			);
	
			if($validator->fails()){
				return Redirect::to("assets/software/lostasset/".Input::get("id"))->withInput()->with("message",$validator->messages()->first());
			}
	
			else if($input["employee_number"]!=null && !empty($software->employee->last_name) && $software->employee_number==$input["employee_number"]){
				return Redirect::to("assets/software/lostasset/".Input::get("id"))->withInput()->with("message","Cannot reassign an asset to the same employee.");
			}
	
			else{
	
				if(!empty($software->employee->last_name)){
	
					if($input["employee_number"]!=null){
	
						//Get the employee
						$employee = Employee::where("employee_number","=",$input["employee_number"])->first();
						$desc = "Software Asset <strong>".$software->asset_tag."</strong> lost by <strong>".$software->employee->first_name." ".$software->employee->last_name."</strong> and assigned to employee <strong>".$employee->first_name." ".$employee->last_name."</strong>.";
	
						//Reassign the asset to the employee
						$software->employee_number = $employee->employee_number;
						$software->status = "Lost";
						$software->save();
	
					}
	
					else{
						$desc = "Software Asset <strong>".$software->asset_tag."</strong> lost by <strong>".$software->employee->first_name." ".$software->employee->last_name."</strong>.";
	
						$software->status = "Lost";
						$software->save();
					}
				}
	
				else{
	
					if($input["employee_number"]!=null){
	
						//Get the employee
						$employee = Employee::where("employee_number","=",$input["employee_number"])->first();
						$desc = "Software Asset <strong>".$software->asset_tag."</strong> lost and assigned to <strong>".$employee->first_name." ".$employee->last_name."</strong>.";
	
						//Reassign the asset to the employee
						$software->employee_number = $employee->employee_number;
						$software->save();
	
					}
	
					else{
						$software->status = "Lost";
						$software->save();
						$desc = "Software Asset <strong>".$software->asset_tag."</strong> lost.";
					}
				}
	
				//Log to software logs
				$softwareLog = new SoftwareLog;
				$softwareLog->user_id = Session::get("user_id");
				$softwareLog->software_id = $software->id;
				$softwareLog->employee_id = !empty($software->employee->id) ? $software->employee->id : null;
				$softwareLog->description = $desc;
				$softwareLog->transaction = "History";
	
				$softwareLog->save();
	
				return Redirect::to("assets/software/update/".Input::get("id"))->with("success","You have successfully logged the transaction.");
	
			}
		}
	
		else{
			return Redirect::to("/");
		}
	}
	
	public function transferAsset($id){
			
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
	
			$view = View::make("Assets.Software.software_transfer_asset");
			$software = Software::find($id);
	
			if(!$software){
				return Redirect::to("assets/software");
			}
	
			if($software->status=="Lost"){
				return Redirect::to("assets/software/update/".$software->id);
			}
			
			$view->software = $software;
			$view->nav = "assets";
			return $view;
		}
			
		else{
			return Redirect::to("/");
		}
	}
	
	public function transfer(){
			
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
	
			$input = Input::all();
			$software = Software::find($input["id"]);
	
			if(!$software){
				return Redirect::to("assets/software");
			}
			
			if($software->status=="Lost"){
				return Redirect::to("assets/software/update/".$software->id);
			}
	
			$validator = Validator::make(
					array(
							"employee number"=>trim($input["employee_number"]),
							"asset status"=>$input["asset_status"]
					),
					array(
							"employee number"=>"required|numeric|exists:tbl_employees,employee_number",
							"asset status"=>"required|in:Available,PWU,Retired,Test Case,Lost"
					)
			);
	
			if($validator->fails()){
				return Redirect::to("assets/software/transferasset/".Input::get("id"))->withInput()->with("message",$validator->messages()->first());
			}
	
			else if($input["employee_number"]!=null && !empty($software->employee->last_name) && $software->employee_number==$input["employee_number"]){
				return Redirect::to("assets/office/transferasset/".Input::get("id"))->withInput()->with("message","Cannot transfer an asset to the same employee.");
			}
	
			else if($software->status!="Lost" && Employee::where("employee_number","=",$input["employee_number"])->whereIn("status",array("OJT Graduate","Graduate","Resigned","Obsolete"))->first()){
				Input::flash();
				return Redirect::to("assets/software/transferasset/".Input::get("id"))->with('message', "Cannot assign asset to employees no longer working in the company.");
			}
	
			else{
					
				if(!empty($software->employee->last_name)){
	
					//Get the employee
					$employee = Employee::where("employee_number","=",$input["employee_number"])->first();
					$desc = "Software Asset <strong>".$software->asset_tag."</strong> transferred from <strong>".$software->employee->first_name." ".$software->employee->last_name."</strong> and assigned to employee <strong>".$employee->first_name." ".$employee->last_name."</strong>, with status <strong>".$input["asset_status"]."</strong>.";
	
					//Reassign the asset to the employee
					$software->employee_number = $employee->employee_number;
					$software->status = $input["asset_status"];
					$software->save();
	
				}
					
				else{
	
					//Get the employee
					$employee = Employee::where("employee_number","=",$input["employee_number"])->first();
					$desc = "Software Asset <strong>".$software->asset_tag."</strong> transferred to <strong>".$employee->first_name." ".$employee->last_name."</strong>, with status <strong>".$input["asset_status"]."</strong>.";
	
					//Reassign the asset to the employee
					$software->employee_number = $employee->employee_number;
					$software->status = $input["asset_status"];
					$software->save();
	
				}
					
				//Log to software logs
				$softwareLog = new SoftwareLog;
				$softwareLog->user_id = Session::get("user_id");
				$softwareLog->software_id = $software->id;
				$softwareLog->employee_id = !empty($software->employee->id) ? $software->employee->id : null;
				$softwareLog->description = $desc;
				$softwareLog->transaction = "History";
	
				$softwareLog->save();
					
				return Redirect::to("assets/software/transferasset/".Input::get("id"))->with("success","You have successfully transferred the asset.");
					
			}
		}
			
		else{
			return Redirect::to("/");
		}
	}
	
	public function import(){
			
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get("user_type")=="Admin")){
				
			$view = View::make("Assets.Software.import_software");
			$view->nav = "assets";
			$view->tab = "import";
			
			return $view;
		}
			
		else{
			return Redirect::to("/");
		}
	}
	
	public function postImport(){
			
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
	
			if(!Input::hasFile('file')){
				return Redirect::to('assets/software/import')->withInput()->with('message',"Please select a valid excel file.");
			}
	
			else{
				return $this->processImport(Input::file("file"));
			}
	
		}
			
		else{
			return Redirect::to('/');
		}
	}
	
	private function processImport($file){
	
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
	
	
			if(!in_array($file->getClientOriginalExtension(),array("xls","xlsx","csv"))){
				Input::flash();
				return Redirect::to('assets/software/import')->with('message',"Invalid file selected.");
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
	
					if(isset($ex["productkey"]) && isset($ex["softwaretype"]) && isset($ex["status"])){
						$excelIsValid = true;
					}
	
				}
					
				/*				6. If file is invalid, redirect to import form and return an error. */
					
				if(!$excelIsValid){
					Input::flash();
					File::delete($readFile);
					return Redirect::to('assets/software/import')->with('message',"Excel file has invalid attributes. Please download the form.");
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
									"software asset tag"=>trim($r->assettag),
									"product key"=>trim($r->productkey),
									"employee number"=>trim($r->employeenumber),
									"laptop serial number"=>trim($r->laptopsn),
									"software type"=>trim($r->softwaretype),
									"warranty start date"=>trim($r->warrantystart),
									"warranty end date"=>trim($r->warrantyend),
									"status"=>trim($r->status),
							),
							array(
									"software asset tag"=>"required|unique:tbl_software_assets,asset_tag|unique:tbl_assets,asset_tag",
									"product key"=>"required",
									"employee number"=>"exists:tbl_employees,employee_number",
									"laptop serial number"=>"exists:tbl_assets,serial_number",
									"software type"=>"required|exists:tbl_software_types,software_type",
									"warranty start date"=>"required_with:warranty end date|date:Y-m-d",
									"warranty end date"=>"date:Y-m-d|after:".$warranty_start,
									"status"=>"required|in:Available,PWU,Retired,Test Case,Lost",
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
						if($validator->messages()->get("software asset tag")){
	
							foreach($validator->messages()->get("software asset tag") as $e){
								$errorCount+=1;
								$error[$rowIndex][$errorCount] = $errorCount.". ".$e . "<br/>";
	
							}
						}
	
						if($validator->messages()->get("product key")){
							foreach($validator->messages()->get("product key") as $e){
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
						
						if($validator->messages()->get("laptop serial number")){
							foreach($validator->messages()->get("laptop serial number") as $e){
								$errorCount+=1;
								$error[$rowIndex][$errorCount] = $errorCount.". ".$e . "<br/>";
						
							}
						}
							
						if($validator->messages()->get("software type")){
							foreach($validator->messages()->get("software type") as $e){
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
							
						if($validator->messages()->get("status")){
							foreach($validator->messages()->get("status") as $e){
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
					
					if(trim($r->laptopsn)!=null && !Asset::where("serial_number","=",$r->laptopsn)->whereHas("classification",function($q){ $q->where("name","=","Laptops"); })->first()){
						
						$hasError=true; //This will only matter if no errors has been found above.
						$rowHasError=true; //This will only matter if no errors has been found above.
						$rowsWithErrors[$rowIndex]=$rowIndex; //This will only matter if no errors has been found above.
						
						$errorCount+=1;
						$error[$rowIndex][$errorCount] = $errorCount.". " . "Cannot assign software asset to non-laptop assets. Please check the serial number and try again." . "<br/>";
						
					}
	
					if(!$rowHasError){
							
						$hasCorrectRows = true;
						$software_type_id = SoftwareType::where("software_type","=",$r->softwaretype)->get(array("id"))->first();	
						
						//Create the asset
						$software = new Software;
						$software->asset_tag = trim($r->assettag)!=null ? trim($r->assettag) : null;
						$software->product_key = trim($r->productkey);
						$software->employee_number = trim($r->employeenumber)!=null ? trim($r->employeenumber) : null;
						$software->assigned_to_serial_number = trim($r->laptopsn)!=null ? trim($r->laptopsn) : null;
						$software->location = trim($r->location)!=null ? trim($r->location) : null;
						$software->software_type_id = $software_type_id->id;
						$software->warranty_start = trim($r->warrantystart);
						$software->warranty_end = trim($r->warrantyend);
						$software->status = trim($r->status);
						$software->notes = trim($r->notes)!=null ? trim($r->notes) : null;
						$software->date_added = date("Y-m-d H:i:s");
							
						$software->save();
						
						//Log the new asset to asset logs
						if(!empty(trim($r->employeenumber))){
							$employee = Employee::where("employee_number","=",trim($r->employeenumber))->first();
							$desc = "Software Asset <strong>".$software->asset_tag."</strong> added to the database and assigned to employee <strong>".$employee->first_name." ".$employee->last_name."</strong> with asset status <strong>".$software->status."</strong>.";
						}
							
						else{
							$desc = "Software Asset <strong>".$software->asset_tag."</strong> added to the database with status <strong>".$software->status."</strong>.";
						}
							
						$softwareLog = new SoftwareLog;
						$softwareLog->user_id = Session::get("user_id");
						$softwareLog->software_id = $software->id;
						$softwareLog->employee_id = !empty($software->employee->id) ? $software->employee->id : null;
						$softwareLog->description = $desc;
						$softwareLog->transaction = "History";
						$softwareLog->save();
							
						//Parallel logging to system logs
						$desc = "(".Session::get('user_type').") "."<strong>".Session::get('username')."</strong> added software asset <strong>".$software->asset_tag."</strong>.";
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
					$desc = "(".Session::get("user_type").") <b>".Session::get("username")."</b> has imported data to software assets database. ";
						
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
	
			$view = View::make("Assets.Software.import_software_result");
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
	
			$software = Input::get("software_id");
			$hasDeletedAny=false;
			$noOfDeletedAssets = 0;
	
			foreach($software as $s){
	
				$soft = Software::find($s);
	
				if(!$soft){
					continue;
				}
	
				$desc = "(".Session::get('user_type').") "."<strong>".Session::get('username')."</strong> has deleted software asset ( type: ".$soft->type->software_type.") <strong>".$soft->asset_tag."</strong>.";
	
				//Log the changes made
				$newLog = new UserLog;
				$newLog->description = $desc;
				$newLog->user_id = Session::get('user_id');
				$newLog->type="System";
	
				$newLog->save();
	
				$hasDeletedAny = true;
				$noOfDeletedAssets+=1;
				
				$soft->delete();
	
			}
	
			if($hasDeletedAny){
					
				$desc = "(".Session::get('user_type').") "."<strong>".Session::get('username')."</strong> has deleted <strong>".$noOfDeletedAssets."</strong> software asset(s).";
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
	
}