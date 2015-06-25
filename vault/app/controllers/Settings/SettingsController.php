<?php

class SettingsController extends BaseController{
	
	public function __construct(){
	
		if(Session::has('username')){
			date_default_timezone_set("Asia/Manila");
				
			$user = User::where('username','=',Session::get("username"))->first();
	
			Session::put('user_id',$user->id);
			Session::put('username',$user->username);
			Session::put('first_name',$user->first_name);
			Session::put('last_name',$user->last_name);
			Session::put('user_type',$user->user_type);
		}
	}
	
	//Manager
	public function managers(){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
			
			$view = View::make('Settings.Employees.settings_managers');
			$view->nav = "system";
			$view->tab = "managers";
			
			$view->managers = Manager::orderBy("last_name")->paginate(50);
			return $view;
		}
	
		else{
			return Redirect::to("/");
		}
	}
	
	public function searchManagers(){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
			
			$view = View::make('Settings.Employees.settings_managers');
			
			$input = Input::all();
			
			$keyword = !empty(trim($input["keyword"])) ? trim($input["keyword"]) : "";
			$keywordRaw =  "%".str_replace(' ', '%', $keyword)."%";
			$keywordRaw = DB::connection()->getPdo()->quote($keywordRaw);
			
			$managers = Manager::where("id","=",$keyword)
				  		->orWhere(function($query) use($keywordRaw){
							$query->whereRaw("concat(last_name,' ',first_name) LIKE $keywordRaw")
							->orWhereRaw("concat(first_name,' ',last_name) LIKE $keywordRaw");
						})
						->orderBy("last_name")
						->paginate(25);
			
			$view->managers = $managers;
			
			$view->nav = "system";
			$view->tab = "managers";
			$view->search = true;
			
			Input::flash();
			return $view;
			
		}
		
		else{
			return Redirect::to("/");
		}
		
	}
	
	public function addManager(){
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
			$view = View::make('Settings.Employees.settings_add_manager');
			$view->nav = "system";
			return $view;
		}
		
		else{
			return Redirect::to("/");
		}
	}
	
	public function submitNewManager(){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
			
			$validator = Validator::make(
					array("last name"=>Input::get("last_name")),
					array("last name"=>"required")
			);
			
			if($validator->fails()){
				Input::flash();
				return Redirect::to('settings/employees/addmanager')->with('message', $validator->messages()->first());
			}
			
			else if((!empty(Input::get("first_name") && !preg_match('/^[\pL.-\s]+$/u', Input::get("first_name")))) || !preg_match('/^[\pL.-\s]+$/u', Input::get("last_name"))){
				Input::flash();
				return Redirect::to('settings/employees/addmanager')->with('message', "First name/last name fields must only contain alpabetic characters and whitespaces.");
			}
			
			else{
				
				$desc = "(".Session::get('user_type').") "."<strong>".Session::get('username')."</strong> has added a new manager: <strong>".Input::get("first_name")." ".Input::get("last_name")."<br/>";
				
				$manager = new Manager;
				$manager->first_name = !empty(Input::get("first_name")) ? trim(Input::get("first_name")) : null;
				$manager->last_name = trim(Input::get("last_name"));
				
				$manager->save();
				
				//Log the changes made
				$newLog = new UserLog;
				$newLog->description = $desc;
				$newLog->user_id = Session::get('user_id');
				$newLog->type="System";
				
				$newLog->save();
				
				return Redirect::to('settings/employees/addmanager')->with('success',"You have successfully added a new manager.");
				
			}
			
		}
		
		else{
			return Redirect::to("/");
		}
	}
	
	public function updateManager($id){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
			$view = View::make('Settings.Employees.settings_update_manager');
			$view->manager = Manager::find($id);
			
			if(!$view->manager){
				return Redirect::to("settings/employees/managers");
			}
			
			$view->nav = "system";
			return $view;
		}
		
		else{
			return Redirect::to("/");
		}
		
	}
	
	public function submitManagerUpdate(){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
			
			$input = Input::all();
			$id = $input["id"];
			$manager = Manager::find($id);
				
			if(!$manager){
				return Redirect::to('settings/employees/managers');
			}
				
			$validator = Validator::make(
					array(
							"last name"=>$input["last_name"]
					),
					array(
							"last name"=>"required"
					)
			);
			
			if($validator->fails()){
				Input::flash();
				return Redirect::to('settings/employees/updatemanager/'.$manager->id)->with('message', $validator->messages()->first());
			}
			
			else if((!empty(Input::get("first_name") && !preg_match('/^[\pL.-\s]+$/u', Input::get("first_name")))) || !preg_match('/^[\pL.-\s]+$/u', Input::get("last_name"))){
				Input::flash();
				return Redirect::to('settings/employees/updatemanager/'.$manager->id)->with('message', "First name/last name fields must only contain alpabetic characters and whitespaces.");
			}
			
			else{
				//These variables are used to track if anything has been changed.
				$isChanged = false; //Boolean variable that checks if anything has been changed. Changes to true when a change has been detected.
				$changes = array(); //Collects the names of the columns that have been changed.
				$index=0; //Provides the index number of $changes array.
				
				if($input["last_name"]!=$manager->last_name){
					$isChanged = true;
					$changes[$index] = "last name";
					$index+=1;
				}
					
				if($input["first_name"]!=$manager->first_name){
					$isChanged = true;
					$changes[$index] = "first name";
					$index+=1;
				}
				
				if(!$isChanged){
					Input::flash();
					return Redirect::to('settings/employees/updatemanager/'.$manager->id)->with('info',"Nothing has changed. </3");
				}
				
				else{
					
					$changesMade = implode($changes,", ");
					$desc = "(".Session::get('user_type').") "."<strong>".Session::get('username')."</strong> has updated manager information of <strong>".$manager->last_name ." - ". $manager->first_name." </strong>. These are the fields that have been changed: ".$changesMade.".";
				
					//Save updates
					$manager->last_name = trim($input["last_name"]);
					$manager->first_name = trim($input["first_name"]);
						
					$manager->save();
				
					//Log the changes made
					$newLog = new UserLog;
					$newLog->description = $desc;
					$newLog->user_id = Session::get('user_id');
					$newLog->type="System";
				
					$newLog->save();
				
					return Redirect::to('settings/employees/updatemanager/'.$manager->id)->with('success',"You have successfully updated the manager information.");
				
				}
			}
			
		}
		
		else{
			return Redirect::to("/");
		}
	}
	
	public function transferEmployees(){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
			$view = View::make('Settings.Employees.settings_transfer_employees');
			
			$getManagers = Manager::orderBy('last_name','asc')->get();
			$managers = array(""=>"--Select One--");
				
			foreach($getManagers as $manager){
				if(!empty($manager["first_name"])){
					$managers[$manager["id"]] = $manager["last_name"].", ".$manager["first_name"];
				}
			
				else{
					$managers[$manager["id"]] = $manager["last_name"];
				}
			}
			
			$view->managers = $managers;
			$view->nav = "system";
			return $view;
		}
		
		else{
			return Redirect::to("/");
		}
	}
	
	public function commitTransfer(){
	if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
			
			$input = Input::all();
			$old_manager = Manager::find($input["old_manager"]);
			$new_manager = Manager::find($input["new_manager"]);
			
			$validator = Validator::make(
					array(
						"Old Manager"=>$input["old_manager"],
						"New Manager"=>$input["new_manager"]
					),
					array(
						"Old Manager"=>"required|exists:tbl_managers,id",
						"New Manager"=>"required|exists:tbl_managers,id"
					)
			);
			
			if($validator->fails()){
				Input::flash();
				return Redirect::to("settings/employees/transferemployees")->with("message",$validator->messages()->first());
			}
			
			else if(count($old_manager->employees)==0){
				Input::flash();
				return Redirect::to("settings/employees/transferemployees")->with("info","Selected old manager does not have employees to transfer.");
			}
			
			else if($input["old_manager"]==$input["new_manager"]){
				Input::flash();
				return Redirect::to("settings/employees/transferemployees")->with("message","Cannot transfer employees to the same manager.");
			}
			
			else{
				
				$desc = "(".Session::get('user_type').") "."<strong>".Session::get('username')."</strong> has transferred the employees of manager <strong>".$old_manager->last_name." (ID #".$old_manager->id.")</strong> to manager <strong>".$new_manager->last_name." (ID #".$new_manager->id.")"."</strong>.";
				
				//Log the changes made
				$newLog = new UserLog;
				$newLog->description = $desc;
				$newLog->user_id = Session::get('user_id');
				$newLog->type="System";
				
				$newLog->save();
				
				//Commit transfer
				$transfer = DB::table('tbl_employees')->where("manager_id",$input["old_manager"])->whereIn("status",array("On-Board","OJT","Academy","Contractual","NSN Guest"))->update(array("manager_id"=>$input["new_manager"]));
				Input::flash();
				return Redirect::to("settings/employees/transferemployees")->with("success","You have successfully transferred the employees.");
			}
		
		}
		
		else{
			return Redirect::to("/");
		}
	}
	
	public function deleteManager($id){
		
		if(Session::has('username') && (Session::get('user_type')=="Root")){
			
			if(!is_numeric($id) || !Manager::find($id)){
				redirect("settings/employees/managers");
			}
			
			$manager = Manager::find($id);
			
			$desc = "(".Session::get('user_type').") "."<strong>".Session::get('username')."</strong> has deleted manager <strong>".$manager->first_name." ".$manager->last_name."</strong>.";
			
			//Log the changes made
			$newLog = new UserLog;
			$newLog->description = $desc;
			$newLog->user_id = Session::get('user_id');
			$newLog->type="System";
				
			$newLog->save();
			$manager->delete();
			
			return Redirect::to("settings/employees/managers");
			
		}
		
		else{
			redirect("/");
		}
	}
	
	public function businessLines(){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
			
			$view = View::make('Settings.Employees.settings_business_lines');
			$view->nav = "system";
			$view->tab = "business_lines";
			
			$view->businessLines = BusinessLine::orderBy("name")->paginate(50);
			return $view;
		}
	
		else{
			return Redirect::to("/");
		}
	}
	
	public function searchBusinessLines(){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
			
			$view = View::make('Settings.Employees.settings_business_lines');
				
			$input = Input::all();
				
			$keyword = !empty(trim($input["keyword"])) ? trim($input["keyword"]) : "";
				
			$businessLines = BusinessLine::where("id","=",$keyword)
								->orWhere("name","LIKE","%$keyword%")
								->orderBy("name")
								->paginate(25);
				
			$view->businessLines = $businessLines;
				
			$view->nav = "system";
			$view->tab = "business_lines";
			$view->search = true;
				
			Input::flash();
			return $view;
			
		}
		
		else{
			return Redirect::to("/");
		}
		
	}
	
	public function addBusinessLine(){
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
			$view = View::make('Settings.Employees.settings_add_business_line');
			$view->nav = "system";
			
			return $view;
		}
		
		else{
			return Redirect::to("/");
		}
	}
	
	public function submitNewBusinessLine(){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
				
			$validator = Validator::make(
					array("name"=>Input::get("name")),
					array("name"=>"required")
			);
				
			if($validator->fails()){
				Input::flash();
				return Redirect::to('settings/employees/addbusinessline')->with('message', $validator->messages()->first());
			}
				
			else{
		
				$desc = "(".Session::get('user_type').") "."<strong>".Session::get('username')."</strong> has created a new Business Line: <strong>".Input::get("name")."</strong>";
		
				$businessLine = new BusinessLine;
				$businessLine->name = trim(Input::get("name"));
		
				$businessLine->save();
		
				//Log the changes made
				$newLog = new UserLog;
				$newLog->description = $desc;
				$newLog->user_id = Session::get('user_id');
				$newLog->type="System";
		
				$newLog->save();
		
				return Redirect::to('settings/employees/addbusinessline')->with('success',"You have successfully created a  new Business Line.");
		
			}
				
				
		}
		
		else{
			return Redirect::to("/");
		}
	}
	
	public function updateBusinessLine($id){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
			$view = View::make('Settings.Employees.settings_update_business_line');
			$view->businessLine = BusinessLine::find($id);
			
			if(!$view->businessLine){
				return Redirect::to("settings/employees/businesslines");
			}
			
			$view->nav = "system";
			return $view;
		}
		
		else{
			return Redirect::to("/");
		}
	}
	
	public function submitBusinessLineUpdate(){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
			
			$input = Input::all();
			$id = $input["id"];
			$businessLine = BusinessLine::find($id);
				
			if(!$businessLine){
				return Redirect::to('settings/employees/businesslines');
			}
				
			$validator = Validator::make(
					array("name"=>$input["name"]),
					array("name"=>"required")
			);
			
			if($validator->fails()){
				Input::flash();
				return Redirect::to('settings/employees/updatebusinessline/'.$businessLine->id)->with('message', $validator->messages()->first());
			}
			
			else{
				
				$isChanged = false; //Boolean variable that checks if anything has been changed. Changes to true when a change has been detected.
				
				if($input["name"]!=$businessLine->name){
					$isChanged = true;
				}
				
				if(!$isChanged){
					Input::flash();
					return Redirect::to('settings/employees/updatebusinessline/'.$businessLine->id)->with('info',"Nothing has changed. </3");
				}
				
				else{
					
					$desc = "(".Session::get('user_type').") "."<strong>".Session::get('username')."</strong> has updated Business Line <strong>".$businessLine->name. "</strong> to <strong>".$input["name"].".</strong>";
				
					//Save updates
					$businessLine->name = trim($input["name"]);
						
					$businessLine->save();
				
					//Log the changes made
					$newLog = new UserLog;
					$newLog->description = $desc;
					$newLog->user_id = Session::get('user_id');
					$newLog->type="System";
				
					$newLog->save();
				
					return Redirect::to('settings/employees/updatebusinessline/'.$businessLine->id)->with('success',"You have successfully updated the business line.");
				
				}
			}
			
		}
		
		else{
			return Redirect::to("/");
		}
	}
	
	public function deleteBusinessLine($id){
		
		if(Session::has('username') && (Session::get('user_type')=="Root")){
				
			if(!is_numeric($id) || !BusinessLine::find($id)){
				redirect("settings/employees/managers");
			}
				
			$businessLine = BusinessLine::find($id);
				
			$desc = "(".Session::get('user_type').") "."<strong>".Session::get('username')."</strong> has deleted business line <strong>".$businessLine->name."</strong>.";
				
			//Log the changes made
			$newLog = new UserLog;
			$newLog->description = $desc;
			$newLog->user_id = Session::get('user_id');
			$newLog->type="System";
		
			$newLog->save();
			$businessLine->delete();
				
			return Redirect::to("settings/employees/businesslines");
				
		}
		
		else{
			redirect("/");
		}
	}
	
	public function units(){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
			$view = View::make('Settings.Employees.settings_units');
			$view->nav = "system";
			$view->tab = "units";
			
			$view->units = Unit::orderBy("name")->paginate(50);
			return $view;
		}
		
		else{
			return Redirect::to("/");
		}
	}
	
	public function searchUnits(){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
			
			$view = View::make('Settings.Employees.settings_units');
			
			$input = Input::all();
			
			$keyword = !empty(trim($input["keyword"])) ? trim($input["keyword"]) : "";
			
			$units = Unit::where("id","=",$keyword)
							->orWhere("name","LIKE","%$keyword%")
							->orderBy("name")
							->paginate(25);
			
			$view->units = $units;
			
			$view->nav = "system";
			$view->tab = "units";
			$view->search = true;
			
			Input::flash();
			return $view;
			
		}
		
		else{
			return Redirect::to("/");
		}
		
	}
	
	public function addUnit(){
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
			$view = View::make('Settings.Employees.settings_add_unit');
			$view->nav = "system";
			
			$getBusinessLines = BusinessLine::all();
			$businessLines = array(""=>"--Select One--");
			
			foreach($getBusinessLines as $businessLine){
				$businessLines[$businessLine["id"]] = $businessLine["name"];
			}
			$view->businessLines = $businessLines;
			return $view;
		}
		
		else{
			return Redirect::to("/");
		}
	}
	
	public function submitNewUnit(){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
		
			$validator = Validator::make(
					array("name"=>Input::get("name"),"business_line"=>Input::get("business_line")),
					array("name"=>"required","business_line"=>"required")
			);
		
			if($validator->fails()){
				Input::flash();
				return Redirect::to('settings/employees/addunit')->with('message', $validator->messages()->first());
			}
			
			else if(!BusinessLine::find(Input::get("business_line"))){
				Input::flash();
				return Redirect::to('settings/employees/addunit')->with('message', "Invalid business line.");
			}
		
			else{
		
				$desc = "(".Session::get('user_type').") "."<strong>".Session::get('username')."</strong> has created a new Unit: <strong>".Input::get("name")."</strong>";
		
				$unit = new Unit;
				$unit->name = trim(Input::get("name"));
				$unit->businessline_id = Input::get("business_line");
		
				$unit->save();
		
				//Log the changes made
				$newLog = new UserLog;
				$newLog->description = $desc;
				$newLog->user_id = Session::get('user_id');
				$newLog->type="System";
		
				$newLog->save();
		
				return Redirect::to('settings/employees/addunit')->with('success',"You have successfully created a new unit.");
		
			}
		
		
		}
		
		else{
			return Redirect::to("/");
		}
	}
	
	public function updateUnit($id){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
			$view = View::make('Settings.Employees.settings_update_unit');
			$view->unit = Unit::find($id);
			
			if(!$view->unit){
				return Redirect::to("settings/employees/units");
			}
			
			$getBusinessLines = BusinessLine::all();
			$businessLines = array(""=>"--Select One--");
				
			foreach($getBusinessLines as $businessLine){
				$businessLines[$businessLine["id"]] = $businessLine["name"];
			}
			
			$view->businessLines = $businessLines;
			$view->nav = "system";
			return $view;
		}
		
		else{
			return Redirect::to("/");
		}
	}
	
	public function submitUnitUpdate(){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
				
			$input = Input::all();
			$id = $input["id"];
			$unit = Unit::find($id);
		
			if(!$unit){
				return Redirect::to('settings/employees/units');
			}
		
			$validator = Validator::make(
					array("name"=>Input::get("name"),"business_line"=>Input::get("business_line")),
					array("name"=>"required","business_line"=>"required")
			);
				
			if($validator->fails()){
				Input::flash();
				return Redirect::to('settings/employees/updateunit/'.$unit->id)->with('message', $validator->messages()->first());
			}
			
			else if(!BusinessLine::find(Input::get("business_line"))){
				Input::flash();
				return Redirect::to('settings/employees/updateunit/'.$unit->id)->with('message', "Invalid business line.");
			}
				
			else{
		
				$isChanged = false; //Boolean variable that checks if anything has been changed. Changes to true when a change has been detected.
				$changes = array(); //Collects the names of the columns that have been changed.
				$index=0; //Provides the index number of $changes array.
				
				if($input["name"]!=$unit->name){
					$isChanged = true;
					$changes[$index] = "unit name";
					$index+=1;
				}
					
				if($input["business_line"]!=$unit->businessline_id){
					$isChanged = true;
					$changes[$index] = "business line";
					$index+=1;
				}
		
				if(!$isChanged){
					Input::flash();
					return Redirect::to('settings/employees/updateunit/'.$unit->id)->with('info',"Nothing has changed. </3");
				}
		
				else{
					$changesMade = implode($changes,", ");
					$desc = "(".Session::get('user_type').") "."<strong>".Session::get('username')."</strong> has updated unit <strong>".$unit->name ."</strong>. These fields have been changed: ".$changesMade.".";
		
					//Save updates
					$unit->name = trim($input["name"]);
					$unit->businessline_id = $input["business_line"];
					
					$unit->save();
		
					//Log the changes made
					$newLog = new UserLog;
					$newLog->description = $desc;
					$newLog->user_id = Session::get('user_id');
					$newLog->type="System";
		
					$newLog->save();
		
					return Redirect::to('settings/employees/updateunit/'.$unit->id)->with('success',"You have successfully updated the unit.");
		
				}
			}
				
		}
		
		else{
			return Redirect::to("/");
		}
	}
	
	public function deleteUnit($id){
	
		if(Session::has('username') && (Session::get('user_type')=="Root")){
	
			if(!is_numeric($id) || !Unit::find($id)){
				return Redirect::to("settings/employees/units");
			}
	
			$unit = Unit::find($id);
	
			$desc = "(".Session::get('user_type').") "."<strong>".Session::get('username')."</strong> has deleted unit <strong>".$unit->name."</strong>.";
	
			//Log the changes made
			$newLog = new UserLog;
			$newLog->description = $desc;
			$newLog->user_id = Session::get('user_id');
			$newLog->type="System";
	
			$newLog->save();
			$unit->delete();
	
			return Redirect::to("settings/employees/units");
	
		}
	
		else{
			return Redirect::to("/");
		}
	}
	
	public function updatePhoneNumbers(){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
			
			$view = View::make('Settings.Employees.settings_update_phone_numbers');
			$view->nav = "system";
			$view->tab = "phone";
			
			return $view;
			
		}
		
		else{
			return Redirect::to("/");
		}
		
	}
	
	public function postPhoneNumbersUpdate(){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
			
			if(!Input::hasFile('file')){
				return Redirect::to('settings/employees/updatephonenumbers')->withInput()->with('message',"Please select a valid excel file.");
			}
				
			else{
				return $this->processPhoneNumbersUpdate(Input::file("file"));
			}
		}
		
		else{
			return Redirect::to("/");
		}
	}
	
	private function processPhoneNumbersUpdate($file){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
			
			if(!in_array($file->getClientOriginalExtension(),array("xls","xlsx","csv"))){
				Input::flash();
				return Redirect::to('settings/employees/updatephonenumbers')->with('message',"Invalid file selected.");
			}
				
			else{
					
				$filename = "upload-".str_random(9).".".$file->getClientOriginalExtension();
				$file->move("uploads",$filename);
					
				$readFile = "uploads/".$filename;
				$reader = Excel::selectSheetsByIndex(0)->load($readFile, function($reader){})->get();
					
				
				$excelChecker = Excel::selectSheetsByIndex(0)->load($readFile, function($reader){})->get()->toArray();
				$excelIsValid = false;
				
				foreach($excelChecker as $ex){
						
					if(isset($ex["employeenumber"])){
						$excelIsValid = true;
					}
						
				}
					
				if(!$excelIsValid){
					Input::flash();
					File::delete($readFile);
					return Redirect::to('settings/employees/updatephonenumbers')->with('message',"Excel file has invalid attributes. Please download the form.");
				}
				
					
				$hasError = false; //Detects if there are any errors.
				$hasCorrectRows = false;
				$rowIndex=1; //Indexes which row the reader is reading.
				$rowsWithErrors = array(); //This is used to contain in an array the row numbers of the rows with error.
				$error=array(); //Error details collector.
					
				foreach($reader as $r){
						
					$rowIndex+=1;
					$errorCount = 0; //Counts the number of errors for the currect row.
					$rowHasError = false; //Check if this row has error. I will use this before the reading of the row ends.
					//					If $rowHasError is still false by end of the reading, then I will write it in the database.
			
			
					$validator = Validator::make(
							array(
									"employee number"=>trim($r->employeenumber),
							),
							array(
									"employee number"=>"required|exists:tbl_employees,employee_number",
							)
					);
						
					if($validator->fails()){
						
						$hasError=true;
						$rowHasError=true;
						$rowsWithErrors[$rowIndex]=$rowIndex;
						
						if($validator->messages()->get("employee number")){
								
							foreach($validator->messages()->get("employee number") as $e){
								$errorCount+=1;
								$error[$rowIndex][$errorCount] = $errorCount.". ".$e . "<br/>";
			
							}
						}
					}
					
					if(!$rowHasError){
							
							$hasCorrectRows = true;
							
							//Save Updates
							//Find the employee by employee number.
							$employee = Employee::where("employee_number","=",trim($r->employeenumber))->first();
							$employee->cellphone_number = trim($r->phonenumber)!=null ? trim($r->phonenumber) : null;
							
							$employee->save();
					}
				}
					
				File::delete($readFile);
				
				if($hasCorrectRows){
					
					//Log the changes made
					$desc = "(".Session::get("user_type").") <b>".Session::get("username")."</b> has updated employees phone numbers. ";
					
					$newLog = new UserLog;
					$newLog->description = $desc;
					$newLog->user_id = Session::get('user_id');
					$newLog->save();
				
				}	
				
				return $this->phoneNumbersUpdateResult($hasError, $hasCorrectRows, $rowsWithErrors, $error);
			}
		}
		
		else{
			return Redirect::to("/");
		}
	}
	
	private function phoneNumbersUpdateResult($fileHasError,$hasCorrectRows,$rowsWithErrors=null,$errorDetails=null){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
				
			$view = View::make('Settings.Employees.settings_update_phone_numbers_result');
			$view->nav = "system";
			$view->tab = "phone";
			
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
			return Redirect::to("/");
		}
	}
	
	public function assetModels(){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
			
			$view = View::make("Settings.Assets.settings_asset_models");
			$assetModels = Model::orderBy("name","asc")->paginate(25);
			
			$getAssetTypes = AssetClassification::orderBy("name")->get();
			$assetTypes = array(""=>"All");
				
			foreach($getAssetTypes as $assetType){
				$assetTypes[$assetType->id] = $assetType->name;
			}
			
			$view->assetModels = $assetModels;
			$view->assetTypes = $assetTypes;
			
			$view->nav = "system";
			$view->tab="models";
			
			return $view;
		}
		
		else{
			return Redirect::to("/");
		}
	}
	
	public function searchAssetModels(){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
			
			$view = View::make("Settings.Assets.settings_asset_models");
			
			$getAssetTypes = AssetClassification::orderBy("name")->get();
			$assetTypes = array(""=>"All");
			
			foreach($getAssetTypes as $assetType){
				$assetTypes[$assetType->id] = $assetType->name;
			}
			
			$input = Input::all();
			
			$keyword = !empty(trim($input["keyword"])) ? trim($input["keyword"]) : "";
			$asset_type = !is_null($input["asset_type"]) ? $input["asset_type"] : "";
			
			$assetModels = Model::whereHas("classification",function($query) use($asset_type){
									if(!empty($asset_type) && $asset_type!="all"){
										$query->where("classification_id","=",$asset_type);
									}
								})
								->where(function($query) use($keyword){
									$query->where("id","=",$keyword)
										  ->orWhere("name","LIKE","%$keyword%");
								})
								->orderBy("name")
								->paginate(25);
								
			$view->assetModels = $assetModels;
			$view->assetTypes = $assetTypes;
			
			$view->nav = "system";
			$view->tab="models";
			$view->search = true;
			
			Input::flash();
			return $view;
			
		}
		
		else{
			return Redirect::to("/");
		}
		
	}
	
	public function addAssetModel(){
		
		$view = View::make("Settings.Assets.settings_add_asset_model");
	
		$getAssetClassifications = AssetClassification::orderBy("name")->get();
		$assetClassifications = array("--Select One--");
			
		foreach($getAssetClassifications as $gac){
			$assetClassifications[$gac->id]=$gac->name;
		}
			
		$view->assetClassifications = $assetClassifications;
		$view->nav = "settings";
		return $view;
		
	}
	
	public function submitNewAssetModel(){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
			
			$validator = Validator::make(
					array(
							"model name"=>Input::get("name"),
							"asset type"=>Input::get("asset_class_id")
			),
					array(
							"model name"=>"required",
							"asset type"=>"required|exists:tbl_asset_classifications,id")
			);
				
			if($validator->fails()){
				Input::flash();
				return Redirect::to('settings/assets/addassetmodel')->with('message', $validator->messages()->first());
			}
			
			else if(Model::where("name","=",trim(Input::get("name")))->where("classification_id","=",Input::get("asset_class_id"))->first()){
				Input::flash();
				return Redirect::to('settings/assets/addassetmodel')->with('message',"Asset model already exists for the same asset type.");
			}
			
			else{
				
				$classification = AssetClassification::find(Input::get("asset_class_id"));
				$desc = "(".Session::get('user_type').") "."<strong>".Session::get('username')."</strong> has added a new asset model: <strong>".Input::get("name")."</strong> for <strong>".strtolower($classification->name)."</strong>.";
		
				$assetModel = new Model;
				$assetModel->name = Input::get("name");
				$assetModel->classification_id = Input::get("asset_class_id");
		
				$assetModel->save();
		
				//Log the changes made
				$newLog = new UserLog;
				$newLog->description = $desc;
				$newLog->user_id = Session::get('user_id');
				$newLog->type="System";
		
				$newLog->save();
		
				return Redirect::to('settings/assets/addassetmodel')->with('success',"You have successfully added a new asset model for ".strtolower($classification->name).".");
		
			}
				
		}
		
		else{
			return Redirect::to("/");
		}
	}
	
	public function updateAssetModel($id){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
			
			$view = View::make("Settings.Assets.settings_update_asset_model");
			$assetModel = Model::find($id);
			
			if(!$assetModel){
				return Redirect::to("settings/assets/assetmodels");
			}
			
			$getAssetClassifications = AssetClassification::orderBy("name")->get();
			$assetClassifications = array("--Select One--");
				
			foreach($getAssetClassifications as $gac){
				$assetClassifications[$gac->id]=$gac->name;
			}
				
			$view->assetClassifications = $assetClassifications;
			$view->assetModel = $assetModel;
			$view->nav = "system";
			return $view;
		}
		
		else{
			return Redirect::to("/");
		}
	}
	
	public function submitAssetModelUpdate(){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
				
			$input = Input::all();
			$id = $input["id"];
			$assetModel = Model::find($id);
		
			if(!$assetModel){
				return Redirect::to("settings/assets/assetmodels");
			}
		
			$validator = Validator::make(
					array(
							"model name"=>Input::get("name")
			),
					array(
							"model name"=>"required")
			);
				
			if($validator->fails()){
				Input::flash();
				return Redirect::to('settings/assets/updateassetmodel/'.$assetModel->id)->with('message', $validator->messages()->first());
			}
				
			else{
		
				$isChanged = false; //Boolean variable that checks if anything has been changed. Changes to true when a change has been detected.
				$changes = array(); //Collects the names of the columns that have been changed.
				$index=0; //Provides the index number of $changes array.
				
				if($input["name"]!=$assetModel->name){
					$changes[$index] = "model name";
					$index+=1;
					$isChanged = true;
				}
		
				if(!$isChanged){
					Input::flash();
					return Redirect::to('settings/assets/updateassetmodel/'.$assetModel->id)->with('info',"Nothing has changed. </3");
				}
		
				else{
						
					$changesMade = implode($changes,", ");
					$desc = "(".Session::get('user_type').") "."<strong>".Session::get('username')."</strong> has asset model <strong>".$assetModel->name."</strong> (ID: ".str_pad($assetModel->id,4,'0',STR_PAD_LEFT)."). These are the fields modified: ".$changesMade.".";
		
					//Save updates
					$assetModel->name = $input["name"];
					$assetModel->save();
		
					//Log the changes made
					$newLog = new UserLog;
					$newLog->description = $desc;
					$newLog->user_id = Session::get('user_id');
					$newLog->type = "System";
		
					$newLog->save();
		
					return Redirect::to('settings/assets/updateassetmodel/'.$assetModel->id)->with('success',"You have successfully updated the asset model.");
		
				}
			}
				
		}
		
		else{
			return Redirect::to("/");
		}
	}
	
	public function deleteAssetModel($id){
		
		if(Session::has('username') && (Session::get('user_type')=="Root")){
	
			if(!is_numeric($id) || !Model::find($id)){
				return Redirect::to("settings/assets/assetmodels");
			}
	
			
			$assetModel = Model::find($id);
	
			$desc = "(".Session::get('user_type').") "."<strong>".Session::get('username')."</strong> has deleted asset model <strong>".$assetModel->name."</strong>.";
	
			//Log the changes made
			$newLog = new UserLog;
			$newLog->description = $desc;
			$newLog->user_id = Session::get('user_id');
			$newLog->type="System";
	
			$newLog->save();
			$assetModel->delete();
	
			return Redirect::to("settings/assets/assetmodels");
	
		}
	
		else{
			return Redirect::to("/");
		}
	}
	
	public function softwareTypes(){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
			
			$view = View::make("Settings.Assets.settings_software_types");
			$softwareTypes = SoftwareType::orderBy("software_type","asc")->paginate(25);
			$view->softwareTypes = $softwareTypes;
			$view->nav = "system";
			$view->tab="software";
			
			return $view;
		}
		
		else{
			return Redirect::to("/");
		}
		
	}
	
	public function searchSoftwareTypes(){
	
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
				
			$view = View::make("Settings.Assets.settings_software_types");
				
			$input = Input::all();
				
			$keyword = !empty(trim($input["keyword"])) ? trim($input["keyword"]) : "";
				
			$softwareTypes = SoftwareType::where(function($query) use($keyword){
							$query->where("id","=",$keyword)
							->orWhere("software_type","LIKE","%$keyword%");
						})
						->orderBy("software_type")
						->paginate(25);
	
			$view->softwareTypes = $softwareTypes;

			$view->nav = "system";
			$view->tab="software";
			$view->search = true;
				
			Input::flash();
			return $view;
				
		}
	
		else{
			return Redirect::to("/");
		}
	
	}
	
	public function addSoftwareType(){
		
		$view = View::make("Settings.Assets.settings_add_software_type");
		$view->nav = "system";
		
		return $view;
	}
	
	public function submitNewSoftwareType(){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
				
			$validator = Validator::make(
					array(
							"software type name"=>Input::get("name")
					),
					array(
							"software type name"=>"required|unique:tbl_software_types,software_type")
			);
		
			if($validator->fails()){
				Input::flash();
				return Redirect::to('settings/assets/addsoftwaretype')->with('message', $validator->messages()->first());
			}
				
			else if(Model::where("name","=",trim(Input::get("name")))->where("classification_id","=",Input::get("asset_class_id"))->first()){
				Input::flash();
				return Redirect::to('settings/assets/addsoftwaretype')->with('message',"Asset model already exists for the same asset type.");
			}
				
			else{
		
				$desc = "(".Session::get('user_type').") "."<strong>".Session::get('username')."</strong> has added a new software type: <strong>".Input::get("name")."</strong>.";
		
				$softwareType = new SoftwareType;
				$softwareType->software_type = Input::get("name");
		
				$softwareType->save();
		
				//Log the changes made
				$newLog = new UserLog;
				$newLog->description = $desc;
				$newLog->user_id = Session::get('user_id');
				$newLog->type="System";
		
				$newLog->save();
		
				return Redirect::to('settings/assets/addsoftwaretype')->with('success',"You have successfully added a new software type.");
		
			}
		
		}
		
		else{
			return Redirect::to("/");
		}
		
	}
	
	public function updateSoftwareType($id){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
				
			$view = View::make("Settings.Assets.settings_update_software_type");
			$softwareType = SoftwareType::find($id);
				
			if(!$softwareType){
				return Redirect::to("settings/assets/softwaretypes");
			}
			
			$view->softwareType = $softwareType;
			$view->nav = "system";
			
			return $view;
		}
		
		else{
			return Redirect::to("/");
		}
		
	}
	
	public function submitSoftwareTypeUpdate(){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
		
			$input = Input::all();
			$id = $input["id"];
			$softwareType = SoftwareType::find($id);
		
			if(!$softwareType){
				return Redirect::to("settings/assets/softwaretypes");
			}
		
			$validator = Validator::make(
					array(
							"software type name"=>Input::get("name")
					),
					array(
							"software type name"=>"required")
			);
		
			if($validator->fails()){
				Input::flash();
				return Redirect::to('settings/assets/updatesoftwaretype/'.$softwareType->id)->with('message', $validator->messages()->first());
			}
			
			else if($softwareType->software_type!=$input["name"] && SoftwareType::where("software_type","=",$input["name"])->first()){
				Input::flash();
				return Redirect::to('settings/assets/updatesoftwaretype/'.$softwareType->id)->with('message', "Software type already exists. Nice try, though.");
			}
		
			else{
		
				
				if($softwareType->software_type==trim($input["name"])){
					Input::flash();
					return Redirect::to('settings/assets/updatesoftwaretype/'.$softwareType->id)->with('info',"Nothing has changed. </3");
				}
				
				else{
		
					$desc = "(".Session::get('user_type').") <strong>".Session::get("username")."</strong> has updated software type <strong>".$softwareType->software_type."</strong> to <strong>".trim($input["name"])."</strong>.";
		
					//Save updates
					$softwareType->software_type = trim($input["name"]);
					$softwareType->save();
		
					//Log the changes made
					$newLog = new UserLog;
					$newLog->description = $desc;
					$newLog->user_id = Session::get('user_id');
					$newLog->type="System";
		
					$newLog->save();
		
					return Redirect::to('settings/assets/updatesoftwaretype/'.$softwareType->id)->with('success',"You have successfully updated the software type.");
		
				}
			}
		
		}
		
		else{
			return Redirect::to("/");
		}
	}
	
	public function deleteSoftwareType($id){
		
		if(Session::has('username') && (Session::get('user_type')=="Root")){
		
			if(!is_numeric($id) || !SoftwareType::find($id)){
				return Redirect::to("settings/assets/softwaretypes");
			}
			
			else if(count(SoftwareType::find($id)->softwareassets)>0){
				return Redirect::to("settings/assets/softwaretypes");
			}
		
				
			$softwareType = SoftwareType::find($id);
		
			$desc = "(".Session::get('user_type').") "."<strong>".Session::get('username')."</strong> has deleted software type <strong>".$softwareType->software_type."</strong>.";
		
			//Log the changes made
			$newLog = new UserLog;
			$newLog->description = $desc;
			$newLog->user_id = Session::get('user_id');
			$newLog->type="System";
		
			$newLog->save();
			
			$softwareType->delete();
		
			return Redirect::to("settings/assets/softwaretypes");
		
		}
		
		else{
			return Redirect::to("/");
		}
		
	}
	
}