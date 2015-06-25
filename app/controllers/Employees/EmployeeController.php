<?php

class EmployeeController extends BaseController{
	
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
	
	public function index($sortby=null,$order=null){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin" || Session::get('user_type')=="User")){

			$view = View::make('Employees.employees');
			$view->nav="employees";
			
			if(empty($sortby) || empty($order)){
				$view->employees = Employee::orderBy('last_name','asc')->paginate(25);
				$view->result = Employee::all()->count();
				$view->sortby="last_name";
				$view->order="asc";
				return $view;
			}
			
			else{
				
				if(!in_array($sortby,array("employee_number","status","start_date","last_name","first_name","nsn_id","business_line")) || !in_array($order,array("asc","desc"))){
					return Redirect::to('employees/index');
				}
				
				$view->employees = Employee::orderBy($sortby,$order)->paginate(25);
				$view->result = Employee::all()->count();
				$view->sortby=$sortby;
				$view->order=$order;
				return $view;
			}
			
		}
		
		else{
			return Redirect::to('/');
		}
		
	}
	
	
	
	public function search(){
	
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin" || Session::get('user_type')=="User")){
				
			$keyword = stripslashes(Input::get('keyword'));
			$keyword = preg_replace('{/$}', '', $keyword);
				
			if(!empty($keyword)){
				//The withInput() extension to the URL is used to flash the search keyword the user has used.
				return Redirect::to('employees/search/'.urlencode($keyword))->withInput();
			}
				
			else{
				return Redirect::to('employees');
			}
		}
	
		else{
			return Redirect::to('/');
		}
	
	}
	
	public function searchKeyword($keyword,$sortby=null,$order=null){
	
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin" || Session::get('user_type')=="User")){
				
			$view = View::make('Employees.employees');
			$view->nav="employees";
			$view->intent="search";
			/*
			 * Getting the input
			* Removing unnecessary whitespaces
			* Inserting in the beginning, replacing the whitespaces in between,
			* and appending the last character to '%' for wildcard database query.
			*
			*/
			$view->keyword=urldecode($keyword);
			$keyword = str_replace(' ', '%', trim(urldecode($keyword)));
				
			/*
			 * $keywordRaw is used for whereRaw() method of Eloquent.
			* Same process is done as with $keyword, only this time the $keywordRaw is also quoted to avoid SQL injections
			* or suspicious database querying.
			*
			*/
				
			$keywordRaw =  "%".str_replace(' ', '%', $keyword)."%";
			$keywordRaw = DB::connection()->getPdo()->quote($keywordRaw);
			
			if(empty($sortby) || empty($order)){
				$view->employees = Employee::where("username","LIKE","%$keyword%")
				->orWhere("employee_number","=",$keyword)
				->orWhere("nsn_id","=",$keyword)
				->orWhere("email","LIKE","%$keyword%")
				->orWhere("last_name","LIKE","%$keyword%")
				->orWhere("first_name","LIKE","%$keyword%")
				->orWhere("status","LIKE","%$keyword%")
				->orWhereRaw("concat(last_name,' ',first_name) LIKE $keywordRaw")
				->orWhereRaw("concat(first_name,' ',last_name) LIKE $keywordRaw")
				->orderBy("last_name","asc")
				->paginate(25);
				
				$view->sortby="last_name";
				$view->order="asc";
			}
			
			else{
				if(!in_array($sortby,array("employee_number","status","start_date","last_name","first_name","nsn_id","business_line")) || !in_array($order,array("asc","desc"))){
					return Redirect::to('employees/index');
				}
				
				$view->employees = Employee::where("username","LIKE","%$keyword%")
					->orWhere("employee_number","=",$keyword)
					->orWhere("nsn_id","=",$keyword)
					->orWhere("email","LIKE","%$keyword%")
					->orWhere("last_name","LIKE","%$keyword%")
					->orWhere("first_name","LIKE","%$keyword%")
					->orWhere("status","LIKE","%$keyword%")
					->orWhereRaw("concat(last_name,' ',first_name) LIKE $keywordRaw")
					->orWhereRaw("concat(first_name,' ',last_name) LIKE $keywordRaw")
					->orderBy($sortby,$order)
					->paginate(25);
				
				$view->sortby=$sortby;
				$view->order=$order;
			}
			
			$view->result =  Employee::where("username","LIKE","%$keyword%")
				->orWhere("employee_number","=",$keyword)
				->orWhere("nsn_id","=",$keyword)
				->orWhere("email","LIKE","%$keyword%")
				->orWhere("last_name","LIKE","%$keyword%")
				->orWhere("first_name","LIKE","%$keyword%")
				->orWhere("status","LIKE","%$keyword%")
				->orWhereRaw("concat(last_name,' ',first_name) LIKE $keywordRaw")
				->orWhereRaw("concat(first_name,' ',last_name) LIKE $keywordRaw")
				->count();
			
			
// 			$view->encodedKeyword = 
			return $view;
		}
			
		else{
			return Redirect::to('/');
		}
	}
	
	public function filterEmployees($status,$sortby=null,$order=null){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin" || Session::get('user_type')=="User")){
			
			$view = View::make('Employees.filter_employees');
			$view->nav="employees";
			
			if(empty($status) || !in_array($status,array("ojt","academy","on-board","temporary","graduate"))){
				return Redirect::to("employees");
			}
			
			if(empty($sortby) || empty($order) || !in_array($sortby,array("employee_number","start_date","last_name","first_name","nsn_id","business_line")) || !in_array($order,array("desc","asc"))){
			
				if($status=="on-board"){
					$view->employees = Employee::where("status","=","on-board")
					->orWhere("status","=","resigned")
					->orderBy('last_name','asc')->paginate(25);
						
						
					$view->result = Employee::where("status","=","on-board")
					->orWhere("status","=","resigned")
					->count();
				}
				
				else if($status=="temporary"){
					
					$view->employees = Employee::where("status","=","contractual")
								->orWhere("status","=","nsn guest")
								->orWhere("status","=","obsolete")
								->orderBy('last_name','asc')->paginate(25);
					
					
					$view->result = Employee::where("status","=","contractual")
								->orWhere("status","=","nsn guest")
								->orWhere("status","=","obsolete")
								->count();
				}
				
				else if($status=="ojt"){
						
					$view->employees = Employee::where("status","=","ojt")
					->orWhere("status","=","ojt graduate")
					->orderBy('last_name','asc')->paginate(25);
						
						
					$view->result = Employee::where("status","=","ojt")
					->orWhere("status","=","ojt graduate")
					->count();
				}
				
				else if($status=="academy"){
					
					$view->employees = Employee::where("status","=","academy")
					->orWhere("status","=","graduate")
					->orderBy('last_name','asc')->paginate(25);
						
						
					$view->result = Employee::where("status","=","academy")
					->orWhere("status","=","graduate")
					->count();
				}
				
				$view->status=$status;
				$view->sortby="last_name";
				$view->order="asc";
				
				return $view;
			}
			
			else{
				
				if($status=="on-board"){
					$view->employees = Employee::where("status","=","on-board")
					->orWhere("status","=","resigned")
					->orderBy($sortby,$order)->paginate(25);
				
				
					$view->result = Employee::where("status","=","on-board")
					->orWhere("status","=","resigned")
					->count();
				}
				
				else if($status=="temporary"){
					$view->employees = Employee::where("status","=","contractual")
						->orWhere("status","=","nsn guest")
						->orderBy($sortby, $order)->paginate(25);
					
					$view->result = Employee::where("status","=","contractual")
									->orWhere("status","=","nsn guest")->count();
				}
				
				else if($status=="ojt"){
				
					$view->employees = Employee::where("status","=","ojt")
					->orWhere("status","=","ojt graduate")
					->orderBy($sortby,$order)->paginate(25);
				
				
					$view->result = Employee::where("status","=","ojt")
					->orWhere("status","=","ojt graduate")
					->count();
				}
				
				else if($status=="academy"){
					$view->employees = Employee::where("status","=","academy")
					->orWhere("status","=","graduate")
					->orderBy($sortby, $order)->paginate(25);
					
					$view->result = Employee::where("status","=","academy")
					->orWhere("status","=","graduate")->count();
				}
				
				else{
					$view->employees = Employee::where("status","=",$status)->orderBy($sortby, $order)->paginate(25);
					$view->result = Employee::where("status","=",$status)->orderBy($sortby, $order)->count();
				}
				
				$view->status=$status;
				$view->sortby=$sortby;
				$view->order=$order;
				
				return $view;
			}
		}
		
		else{
			return Redirect::to('/');
		}
	}
	
	public function filterEmployeesSearch($status){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin" || Session::get('user_type')=="User")){
			
			$keyword = stripslashes(Input::get('keyword'));
			$keyword = preg_replace('{/$}', '', $keyword);
			
			if(empty($status) || !in_array($status,array("ojt","academy","on-board","temporary","graduate"))){
				return Redirect::to("employees");
			}
			
			if(!empty($keyword)){
				//The withInput() extension to the URL is used to flash the search keyword the user has used.
				return Redirect::to("employees/searchfilter/$status/".urlencode($keyword))->withInput();
			}
			
			return Redirect::to("employees/filter/$status");
		}
	
		else{
			return Redirect::to('/');
		}
	}
	
	public function filterEmployeesSearchKeyword($status,$keyword,$sortby=null,$order=null){
	
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin" || Session::get('user_type')=="User")){
			
			if(empty($status) || !in_array($status,array("ojt","academy","on-board","temporary","graduate"))){
				return Redirect::to("employees");
			}
			
			$view = View::make('Employees.filter_employees');
			$view->nav="employees";
			$view->intent="search";
			
			/*
			 * Getting the input
			* Removing unnecessary whitespaces
			* Inserting in the beginning, replacing the whitespaces in between,
			* and appending the last character to '%' for wildcard database query.
			*
			*/
			
			$view->keyword=urldecode($keyword);
			$keyword = str_replace(' ', '%', trim(urldecode($keyword)));
				
			/*
			 * $keywordRaw is used for whereRaw() method of Eloquent.
			* Same process is done as with $keyword, only this time the $keywordRaw is also quoted to avoid SQL injections
			* or suspicious database querying.
			*
			*/
				
			$keywordRaw =  "%".str_replace(' ', '%', $keyword)."%";
			$keywordRaw = DB::connection()->getPdo()->quote($keywordRaw);
			
			if(empty($sortby) || empty($order)){
				
				if($status=="on-board"){
					$view->employees = Employee::where(function($query){ 
							$query->where("status","=","on-board")
								->orWhere("status","=","resigned"); })
						->where(function($query) use ($keyword,$keywordRaw){
							$query->where("username","LIKE","%$keyword%")
						->orWhere("employee_number","=",$keyword)
						->orWhere("nsn_id","=",$keyword)
						->orWhere("email","LIKE","%$keyword%")
						->orWhere("last_name","LIKE","%$keyword%")
						->orWhere("first_name","LIKE","%$keyword%")
						->orWhere("status","LIKE","%$keyword%")
						->orWhereRaw("concat(last_name,' ',first_name) LIKE $keywordRaw")
						->orWhereRaw("concat(first_name,' ',last_name) LIKE $keywordRaw");
					})->orderBy("last_name","asc")
					->paginate(25);
						
						
					$view->result = Employee::where(function($query){ 
							$query->where("status","=","on-board")
								->orWhere("status","=","resigned"); })
						->where(function($query) use ($keyword,$keywordRaw){
							$query->where("username","LIKE","%$keyword%")
						->orWhere("employee_number","=",$keyword)
						->orWhere("nsn_id","=",$keyword)
						->orWhere("email","LIKE","%$keyword%")
						->orWhere("last_name","LIKE","%$keyword%")
						->orWhere("first_name","LIKE","%$keyword%")
						->orWhere("status","LIKE","%$keyword%")
						->orWhereRaw("concat(last_name,' ',first_name) LIKE $keywordRaw")
						->orWhereRaw("concat(first_name,' ',last_name) LIKE $keywordRaw");
					})->count();
				}
				
				else if($status=="temporary"){
					
					$view->employees = Employee::where(function($query){ 
							$query->where("status","=","contractual")
								->orWhere("status","=","nsn guest")
								->orWhere("status","=","obsolete"); })
						->where(function($query) use ($keyword,$keywordRaw){
							$query->where("username","LIKE","%$keyword%")
						->orWhere("employee_number","=",$keyword)
						->orWhere("nsn_id","=",$keyword)
						->orWhere("email","LIKE","%$keyword%")
						->orWhere("last_name","LIKE","%$keyword%")
						->orWhere("first_name","LIKE","%$keyword%")
						->orWhere("status","LIKE","%$keyword%")
						->orWhereRaw("concat(last_name,' ',first_name) LIKE $keywordRaw")
						->orWhereRaw("concat(first_name,' ',last_name) LIKE $keywordRaw");
					})->orderBy("last_name","asc")
					->paginate(25);
					
					$view->result = Employee::where(function($query){ 
							$query->where("status","=","contractual")
								->orWhere("status","=","nsn guest")
								->orWhere("status","=","obsolete"); })
						->where(function($query) use ($keyword,$keywordRaw){
							$query->where("username","LIKE","%$keyword%")
						->orWhere("employee_number","=",$keyword)
						->orWhere("nsn_id","=",$keyword)
						->orWhere("email","LIKE","%$keyword%")
						->orWhere("last_name","LIKE","%$keyword%")
						->orWhere("first_name","LIKE","%$keyword%")
						->orWhere("status","LIKE","%$keyword%")
						->orWhereRaw("concat(last_name,' ',first_name) LIKE $keywordRaw")
						->orWhereRaw("concat(first_name,' ',last_name) LIKE $keywordRaw");
					})->count();
				}
				
				else if($status=="ojt"){
				
					$view->employees = Employee::where(function($query){ 
							$query->where("status","=","ojt")
								->orWhere("status","=","ojt graduate"); })
						->where(function($query) use ($keyword,$keywordRaw){
							$query->where("username","LIKE","%$keyword%")
						->orWhere("employee_number","=",$keyword)
						->orWhere("nsn_id","=",$keyword)
						->orWhere("email","LIKE","%$keyword%")
						->orWhere("last_name","LIKE","%$keyword%")
						->orWhere("first_name","LIKE","%$keyword%")
						->orWhere("status","LIKE","%$keyword%")
						->orWhereRaw("concat(last_name,' ',first_name) LIKE $keywordRaw")
						->orWhereRaw("concat(first_name,' ',last_name) LIKE $keywordRaw");
					})->orderBy("last_name","asc")
					->paginate(25);
				
				
					$view->result = Employee::where(function($query){ 
							$query->where("status","=","ojt")
								->orWhere("status","=","ojt graduate"); })
						->where(function($query) use ($keyword,$keywordRaw){
							$query->where("username","LIKE","%$keyword%")
						->orWhere("employee_number","=",$keyword)
						->orWhere("nsn_id","=",$keyword)
						->orWhere("email","LIKE","%$keyword%")
						->orWhere("last_name","LIKE","%$keyword%")
						->orWhere("first_name","LIKE","%$keyword%")
						->orWhere("status","LIKE","%$keyword%")
						->orWhereRaw("concat(last_name,' ',first_name) LIKE $keywordRaw")
						->orWhereRaw("concat(first_name,' ',last_name) LIKE $keywordRaw");
					})->count();
				}
				
				else if($status=="academy"){
					
					$view->employees = Employee::where(function($query){ 
							$query->where("status","=","academy")
								  ->orWhere("status","=","graduate"); })
						->where(function($query) use ($keyword,$keywordRaw){
							$query->where("username","LIKE","%$keyword%")
						->orWhere("employee_number","=",$keyword)
						->orWhere("nsn_id","=",$keyword)
						->orWhere("email","LIKE","%$keyword%")
						->orWhere("last_name","LIKE","%$keyword%")
						->orWhere("first_name","LIKE","%$keyword%")
						->orWhere("status","LIKE","%$keyword%")
						->orWhereRaw("concat(last_name,' ',first_name) LIKE $keywordRaw")
						->orWhereRaw("concat(first_name,' ',last_name) LIKE $keywordRaw");
					})->orderBy("last_name","asc")
					->paginate(25);
					
					$view->result = Employee::where(function($query){  
							$query->where("status","=","academy")
								  ->orWhere("status","=","graduate"); })
						->where(function($query) use ($keyword,$keywordRaw){
							$query->where("username","LIKE","%$keyword%")
						->orWhere("employee_number","=",$keyword)
						->orWhere("nsn_id","=",$keyword)
						->orWhere("email","LIKE","%$keyword%")
						->orWhere("last_name","LIKE","%$keyword%")
						->orWhere("first_name","LIKE","%$keyword%")
						->orWhere("status","LIKE","%$keyword%")
						->orWhereRaw("concat(last_name,' ',first_name) LIKE $keywordRaw")
						->orWhereRaw("concat(first_name,' ',last_name) LIKE $keywordRaw");
					})->count();
				}
				
				else{
					
					$view->employees = Employee::where("status","=","$status")
					->where(function($query) use ($keyword,$keywordRaw){
						$query->where("username","LIKE","%$keyword%")
						->orWhere("employee_number","=",$keyword)
						->orWhere("nsn_id","=",$keyword)
						->orWhere("email","LIKE","%$keyword%")
						->orWhere("last_name","LIKE","%$keyword%")
						->orWhere("first_name","LIKE","%$keyword%")
						->orWhereRaw("concat(last_name,' ',first_name) LIKE $keywordRaw")
						->orWhereRaw("concat(first_name,' ',last_name) LIKE $keywordRaw");
					})->orderBy("last_name","asc")
					->paginate(25);
					
					$view->result = Employee::where("status","=","$status")
					->where(function($query) use ($keyword,$keywordRaw){
						$query->where("username","LIKE","%$keyword%")
						->orWhere("employee_number","=",$keyword)
						->orWhere("nsn_id","=",$keyword)
						->orWhere("email","LIKE","%$keyword%")
						->orWhere("last_name","LIKE","%$keyword%")
						->orWhere("first_name","LIKE","%$keyword%")
						->orWhereRaw("concat(last_name,' ',first_name) LIKE $keywordRaw")
						->orWhereRaw("concat(first_name,' ',last_name) LIKE $keywordRaw");
					})->count();
				}
				
				$view->sortby="last_name";
				$view->order="asc";
			}
			
			else{
				
				if(!in_array($sortby,array("employee_number","start_date","last_name","first_name","nsn_id","business_line")) || !in_array($order,array("asc","desc"))){
					return Redirect::to('employees/index');
				}
				
				if($status=="on-board"){
					$view->employees = Employee::where(function($query){
						$query->where("status","=","on-board")
						->orWhere("status","=","resigned"); })
						->where(function($query) use ($keyword,$keywordRaw){
							$query->where("username","LIKE","%$keyword%")
							->orWhere("employee_number","=",$keyword)
							->orWhere("nsn_id","=",$keyword)
							->orWhere("email","LIKE","%$keyword%")
							->orWhere("last_name","LIKE","%$keyword%")
							->orWhere("first_name","LIKE","%$keyword%")
							->orWhere("status","LIKE","%$keyword%")
							->orWhereRaw("concat(last_name,' ',first_name) LIKE $keywordRaw")
							->orWhereRaw("concat(first_name,' ',last_name) LIKE $keywordRaw");
						})->orderBy($sortby,$order)
						->paginate(25);
				
				
						$view->result = Employee::where(function($query){
							$query->where("status","=","on-board")
							->orWhere("status","=","resigned"); })
							->where(function($query) use ($keyword,$keywordRaw){
								$query->where("username","LIKE","%$keyword%")
								->orWhere("employee_number","=",$keyword)
								->orWhere("nsn_id","=",$keyword)
								->orWhere("email","LIKE","%$keyword%")
								->orWhere("last_name","LIKE","%$keyword%")
								->orWhere("first_name","LIKE","%$keyword%")
								->orWhere("status","LIKE","%$keyword%")
								->orWhereRaw("concat(last_name,' ',first_name) LIKE $keywordRaw")
								->orWhereRaw("concat(first_name,' ',last_name) LIKE $keywordRaw");
							})->count();
				}
				
				else if($status=="temporary"){
					$view->employees = Employee::where(function($query){ 
							$query->where("status","=","contractual")
								->orWhere("status","=","nsn guest")
								->orWhere("status","=","obsolete"); })
					->where(function($query) use ($keyword,$keywordRaw){
						$query->where("username","LIKE","%$keyword%")
						->orWhere("employee_number","=",$keyword)
						->orWhere("nsn_id","=",$keyword)
						->orWhere("email","LIKE","%$keyword%")
						->orWhere("last_name","LIKE","%$keyword%")
						->orWhere("first_name","LIKE","%$keyword%")
						->orWhere("status","LIKE","%$keyword%")
						->orWhereRaw("concat(last_name,' ',first_name) LIKE $keywordRaw")
						->orWhereRaw("concat(first_name,' ',last_name) LIKE $keywordRaw");
					})->orderBy($sortby,$order)
					->paginate(25);
					
					$view->result = Employee::where(function($query){
						$query->where("status","=","contractual")
						->orWhere("status","=","nsn guest")
						->orWhere("status","=","obsolete"); })
						->where(function($query) use ($keyword,$keywordRaw){
							$query->where("username","LIKE","%$keyword%")
							->orWhere("employee_number","=",$keyword)
							->orWhere("nsn_id","=",$keyword)
							->orWhere("email","LIKE","%$keyword%")
							->orWhere("last_name","LIKE","%$keyword%")
							->orWhere("first_name","LIKE","%$keyword%")
							->orWhere("status","LIKE","%$keyword%")
							->orWhereRaw("concat(last_name,' ',first_name) LIKE $keywordRaw")
							->orWhereRaw("concat(first_name,' ',last_name) LIKE $keywordRaw");
						})->count();
				}
				
				else if($status=="ojt"){
				
					$view->employees = Employee::where(function($query){
						$query->where("status","=","ojt")
						->orWhere("status","=","ojt graduate"); })
						->where(function($query) use ($keyword,$keywordRaw){
							$query->where("username","LIKE","%$keyword%")
							->orWhere("employee_number","=",$keyword)
							->orWhere("nsn_id","=",$keyword)
							->orWhere("email","LIKE","%$keyword%")
							->orWhere("last_name","LIKE","%$keyword%")
							->orWhere("first_name","LIKE","%$keyword%")
							->orWhere("status","LIKE","%$keyword%")
							->orWhereRaw("concat(last_name,' ',first_name) LIKE $keywordRaw")
							->orWhereRaw("concat(first_name,' ',last_name) LIKE $keywordRaw");
						})->orderBy($sortby,$order)
						->paginate(25);
				
				
						$view->result = Employee::where(function($query){
							$query->where("status","=","ojt")
							->orWhere("status","=","ojt graduate"); })
							->where(function($query) use ($keyword,$keywordRaw){
								$query->where("username","LIKE","%$keyword%")
								->orWhere("employee_number","=",$keyword)
								->orWhere("nsn_id","=",$keyword)
								->orWhere("email","LIKE","%$keyword%")
								->orWhere("last_name","LIKE","%$keyword%")
								->orWhere("first_name","LIKE","%$keyword%")
								->orWhere("status","LIKE","%$keyword%")
								->orWhereRaw("concat(last_name,' ',first_name) LIKE $keywordRaw")
								->orWhereRaw("concat(first_name,' ',last_name) LIKE $keywordRaw");
							})->count();
				}
				
				else if($status=="academy"){
					
						$view->employees = Employee::where(function($query){
								$query->where("status","=","academy")
								->orWhere("status","=","graduate"); })
						->where(function($query) use ($keyword,$keywordRaw){
							$query->where("username","LIKE","%$keyword%")
							->orWhere("employee_number","=",$keyword)
							->orWhere("nsn_id","=",$keyword)
							->orWhere("email","LIKE","%$keyword%")
							->orWhere("last_name","LIKE","%$keyword%")
							->orWhere("first_name","LIKE","%$keyword%")
							->orWhere("status","LIKE","%$keyword%")
							->orWhereRaw("concat(last_name,' ',first_name) LIKE $keywordRaw")
							->orWhereRaw("concat(first_name,' ',last_name) LIKE $keywordRaw");
						})->orderBy($sortby,$order)
						->paginate(25);
							
						$view->result = Employee::where(function($query){
								$query->where("status","=","academy")
								->orWhere("status","=","graduate"); })
							->where(function($query) use ($keyword,$keywordRaw){
								$query->where("username","LIKE","%$keyword%")
								->orWhere("employee_number","=",$keyword)
								->orWhere("nsn_id","=",$keyword)
								->orWhere("email","LIKE","%$keyword%")
								->orWhere("last_name","LIKE","%$keyword%")
								->orWhere("first_name","LIKE","%$keyword%")
								->orWhere("status","LIKE","%$keyword%")
								->orWhereRaw("concat(last_name,' ',first_name) LIKE $keywordRaw")
								->orWhereRaw("concat(first_name,' ',last_name) LIKE $keywordRaw");
							})->count();
				}
				
				else{
						
					$view->employees = Employee::where("status","=","$status")
					->where(function($query) use ($keyword,$keywordRaw){
						$query->where("username","LIKE","%$keyword%")
						->orWhere("employee_number","=",$keyword)
						->orWhere("nsn_id","=",$keyword)
						->orWhere("email","LIKE","%$keyword%")
						->orWhere("last_name","LIKE","%$keyword%")
						->orWhere("first_name","LIKE","%$keyword%")
						->orWhereRaw("concat(last_name,' ',first_name) LIKE $keywordRaw")
						->orWhereRaw("concat(first_name,' ',last_name) LIKE $keywordRaw");
					})->orderBy($sortby,$order)
					->paginate(25);
						
					$view->result = Employee::where("status","=","$status")
					->where(function($query) use ($keyword,$keywordRaw){
						$query->where("username","LIKE","%$keyword%")
						->orWhere("employee_number","=",$keyword)
						->orWhere("nsn_id","=",$keyword)
						->orWhere("email","LIKE","%$keyword%")
						->orWhere("last_name","LIKE","%$keyword%")
						->orWhere("first_name","LIKE","%$keyword%")
						->orWhereRaw("concat(last_name,' ',first_name) LIKE $keywordRaw")
						->orWhereRaw("concat(first_name,' ',last_name) LIKE $keywordRaw");
					})->count();
				}
				
				$view->sortby=$sortby;
				$view->order=$order;
			}
			
			
			$view->status = $status;
			return $view;
		}
	
		else{
			return Redirect::to('/');
		}
	}
	
	public function advancedSearch(){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin" || Session::get('user_type')=="User")){
			$view = View::make("Employees.advanced_search_employees");
			$view->employees = Employee::orderBy("last_name","asc")->paginate(25);
			$view->nav="employees";
			
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
	
	public function advancedSearchEmployees(){
		
	   if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin" || Session::get("user_type")=="User")){
	   	
	   		$view = View::make("Employees.advanced_search_employees");
			$view->nav="employees";
			
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
	
		else{
			return Redirect::to('/');
		}
	}
	
	public function addEmployee(){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
				
			$view = View::make('Employees.add_employee');
			
			$getManagers = Manager::orderBy('last_name','asc')->get();
			$managers = array(""=>"None");
			
			foreach($getManagers as $manager){
				if(!empty($manager["first_name"])){
					$managers[$manager["id"]] = $manager["last_name"].", ".$manager["first_name"];
				}
				
				else{
					$managers[$manager["id"]] = $manager["last_name"];
				}
			}
			
			$getBusinessLines = BusinessLine::all();
			$businessLines = array(""=>"None");
			$units = array();
			
			
			foreach($getBusinessLines as $businessLine){
				$businessLines[$businessLine["id"]] = $businessLine["name"];
				
				//Check if there is a unit with the Business Line
				if(Unit::where("businessline_id","=",$businessLine["id"])->first()){
					
					//If a business line has a unit, get all the units that belong to the business line
					$getUnits = Unit::where("businessline_id","=",$businessLine["id"])->get();
					
					$unitLoad = array(""=>"None");
					
					foreach($getUnits as $unit){
						//Load the units fetched from the DB to $unitLoad as an array. I needed this as a single dimensional array to pass to a select form.
						$unitLoad[$unit->id] = $unit->name;
					}
					
					//Load the units to the business line they belong to.
					$units[$businessLine["id"]] = $unitLoad;
					
				}
			}

			$view->managers = $managers;
			$view->businessLines = $businessLines;
			$view->getBusinessLines = $getBusinessLines;
			$view->units = $units;
			$view->nav="employees";
			
// 			return var_dump($units);
			return $view;
		
		}
		
		else{
			return Redirect::to('/');
		}
		
	}
	
	public function submitNewEmployee(){
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
				
			$input = Input::all();
			$start_date = $input["start_date"]!=null ? $input["start_date"] : "1994-04-16";
			
			
			$validator = Validator::make(
					array(
						"last name"=>$input["last_name"],
						"first name"=>$input["first_name"],
						"employee number"=>$input["employee_number"],
						"start date"=>$input["start_date"],
						"end date"=>$input["end_date"],
						"status"=>$input["status"]
					),
					array(
						"last name"=>"required",
						"first name"=>"required",
						"employee number"=>"required|numeric",
						"start date"=>"required|date:Y-m-d",
						"end date"=>"date:Y-m-d|after:".$start_date,
						"status"=>"required"
					)
			);


			if($validator->fails()){
				Input::flash();
				return Redirect::to('employees/addemployee')->with('message', $validator->messages()->first());
			}
			
			else if(!preg_match('/^[\pL.-\s]+$/u', $input["first_name"]) || !preg_match('/^[\pL.-\s]+$/u', $input["last_name"]) || (!empty($input["nickname"]) && !preg_match('/^[\pL.-\s]+$/u', $input["nickname"]))){
				Input::flash();
				return Redirect::to('employees/addemployee')->with('message', "First name/last name/nickname fields must only contain alpabetic characters and whitespaces.");
			}
			
			else if(Employee::where("username","=",$input["username"])->first()){
				Input::flash();
				return Redirect::to('employees/addemployee')->with('message', "Username already exists.");
			}
			
			else if(empty($input["nsn_id"]) && !in_array(strtolower($input["status"]),array("academy","ojt","ojt graduate","graduate","contractual","obsolete"))){
				Input::flash();
				return Redirect::to('employees/addemployee')->with('message', "The NSN ID is required.");
			}
				
			else if(!empty($input["nsn_id"] && !is_numeric($input["nsn_id"]))){
				Input::flash();
				return Redirect::to('employees/addemployee')->with('message', "The NSN ID should be numeric.");
			}
			
			else if(Employee::where("employee_number","=",$input["employee_number"])->first()){
				Input::flash();
				return Redirect::to('employees/addemployee')->with('message', "Employee number already exists.");
			}
				
			else if(Employee::where("nsn_id","=",$input["nsn_id"])->first()){
				Input::flash();
				return Redirect::to('employees/addemployee')->with('message', "NSN ID already exists.");
			}
				
			else if(Employee::where("email","=",$input["email"])->first()){
				Input::flash();
				return Redirect::to('employees/addemployee')->with('message', "Email already exists.");
			}
			
			else if (!empty($input["end_date"]) && !preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$input["end_date"])){
				Input::flash();
				return Redirect::to('employees/addemployee')->with('message', "The end date format should follow YYYY-MM-DD date format.");
			}
			
			else if(!in_array(strtolower($input["status"]),array("ojt","ojt graduate","contractual","nsn guest","academy","graduate","on-board","obsolete","resigned"))){
				Input::flash();
				return Redirect::to('employees/addemployee')->with('message', "Please select a valid employee status.");
			}
				
			else{
		
				$desc = "(".Session::get('user_type').") "."<strong>".Session::get('username')."</strong> has added employee <strong>".trim($input["first_name"])." ".$input["last_name"]."</strong>, employee number <strong>".trim($input["employee_number"])."</strong>, with status <strong>".trim($input["status"])."</strong>.";
	
				//Create the new employee
				$employee = new Employee;
				
				$employee->last_name = trim($input["last_name"]);
				$employee->first_name = trim($input["first_name"]);
				$employee->nickname = trim($input["nickname"])!=null ? trim($input["nickname"]) : null;
				$employee->username = trim($input["username"])!=null ? trim($input["username"]) : null;
				$employee->employee_number = $input["employee_number"];
				$employee->status = $input["status"];
				$employee->manager_id = $input["manager_id"]!=null ? $input["manager_id"] : null;
				$employee->start_date = $input["start_date"];
				$employee->end_date = $input["end_date"]!=null ? $input["end_date"] : null;
				$employee->nsn_id = $input["nsn_id"]!=null ? $input["nsn_id"] : null;
				$employee->email= trim($input["email"])!=null ? trim($input["email"]) : null;
				$employee->business_line_id = $input["business_line"]!=null ? $input["business_line"] : null;
				$employee->unit_id = $input["unit"]!=null ? $input["unit"] : null;
				$employee->subunit = trim($input["subunit"])!=null ? trim($input["subunit"]) : null;
				$employee->cellphone_number = trim($input["cellphone_number"])!=null ? trim($input["cellphone_number"]) : null;
					
				$employee->save();
	
				//Log the changes made
				$newLog = new UserLog;
				$newLog->description = $desc;
				$newLog->user_id = Session::get('user_id');
				$newLog->type="Employees";
	
				$newLog->save();
	
				return Redirect::to('employees/addemployee')->with('success',"You have successfully added a new employee.");
				
			}
				
		}
		
		else{
			return Redirect::to('/');
		}
	}
	
	public function updateEmployee($id){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
			
			$view = View::make('Employees.update_employee');
			$employee = Employee::where("employee_number","=",$id)->first();
			
			if(!$employee){
				return Redirect::to('employees');	
			}
			
			$view->employee = $employee;
			
			$getManagers = Manager::orderBy('last_name','asc')->get();
			$managers = array(""=>"None");
				
			foreach($getManagers as $manager){
				if(!empty($manager["first_name"])){
					$managers[$manager["id"]] = $manager["last_name"].", ".$manager["first_name"];
				}
				
				else{
					$managers[$manager["id"]] = $manager["last_name"];
				}
			}
			
			$getBusinessLines = BusinessLine::all();
			$businessLines = array(""=>"None");
				
				
			foreach($getBusinessLines as $businessLine){
				$businessLines[$businessLine["id"]] = $businessLine["name"];
			}
			
			$getUnits = Unit::orderBy("name","asc")->get();
			$units = array(""=>"None");
			
			foreach($getUnits as $unit){
				$units[$unit["id"]] = $unit["name"];
			}
			
			$view->managers = $managers;
			$view->businessLines = $businessLines;
			$view->units = $units;
			$view->nav="employees";
			return $view;
				
		}
		
		else{
			return Redirect::to('/');
		}
		
	}
	
	public function submitEmployeeUpdate(){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
			
			$input = Input::all();
			$id = $input["id"];
			$employee = Employee::find($id);
			$start_date = $input["start_date"]!=null ? $input["start_date"] : "1994-04-16";
			
			if(!$employee){
				return Redirect::to('employees');
			}
			
			$validator = Validator::make(
					array(
						"id"=>$input["id"],
						"employee number"=>$input["employee_number"],
						"last name"=>$input["last_name"],
						"first name"=>$input["first_name"],
						"start date"=>$input["start_date"],
						"end date"=>$input["end_date"],
						"status"=>$input["status"]
					),
					array(
						"id"=>"required|numeric",
						"employee number"=>"required|numeric",
						"last name"=>"required",
						"first name"=>"required",
						"start date"=>"required|date:Y-m-d",
						"end date"=>"date:Y-m-d|after:".$start_date,
						"status"=>"required"
					)
			);
			
			if($validator->fails()){
				Input::flash();
				return Redirect::to('employees/updateemployee/'.$employee->employee_number)->with('message', $validator->messages()->first());
			}
			
			else if(empty($input["nsn_id"]) && !in_array(strtolower($input["status"]),array("academy","ojt","ojt graduate","graduate","contractual","obsolete"))){
				Input::flash();
				return Redirect::to('employees/updateemployee/'.$employee->employee_number)->with('message', "The NSN ID is required.");
			}
			
			else if(!empty($input["nsn_id"] && !is_numeric($input["nsn_id"]))){
				Input::flash();
				return Redirect::to('employees/updateemployee/'.$employee->employee_number)->with('message', "The NSN ID should be numeric.");
			}
			
			else if(!preg_match('/^[\pL.-\s]+$/u', $input["first_name"]) || !preg_match('/^[\pL.-\s]+$/u', $input["last_name"])){
				Input::flash();
				return Redirect::to('employees/updateemployee/'.$employee->employee_number)->with('message', "First name/last name fields must only contain alpabetic characters and whitespaces.");
			}
			
			else if(Employee::where("username","=",$input["username"])->first() && $employee->username!=$input["username"]){
				Input::flash();
				return Redirect::to('employees/updateemployee/'.$employee->employee_number)->with('message', "Username already exists.");
			}
			
			else if(Employee::where("employee_number","=",$input["employee_number"])->first() && $employee->employee_number!=$input["employee_number"]){
				Input::flash();
				return Redirect::to('employees/updateemployee/'.$employee->employee_number)->with('message', "Employee number already exists.");
			}
			
			else if(Employee::where("nsn_id","=",$input["nsn_id"])->first() && $employee->nsn_id!=$input["nsn_id"]){
				Input::flash();
				return Redirect::to('employees/updateemployee/'.$employee->employee_number)->with('message', "NSN ID already exists.");
			}
			
			else if(Employee::where("email","=",$input["email"])->first() && $employee->email!=$input["email"]){
				Input::flash();
				return Redirect::to('employees/updateemployee/'.$employee->employee_number)->with('message', "Email already exists.");
			}
			
			else if(!empty(trim($input["unit"])) && !Unit::where("id","=",$input["unit"])->where("businessline_id","=",$input["business_line"])->first()){
				Input::flash();
				return Redirect::to('employees/updateemployee/'.$employee->employee_number)->with('message', "The selected unit does not belong to the selected Business Line.");
			}
			
			else if (!empty($input["end_date"]) && !preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$input["end_date"])){
				Input::flash();
				return Redirect::to('employees/addemployee')->with('message', "The end date format should follow YYYY-MM-DD date format.");
			}
			
			else{
				
				//These variables are used to track if anything has been changed.
				$isChanged = false; //Boolean variable that checks if anything has been changed. Changes to true when a change has been detected.
				$changes = array(); //Collects the names of the columns that have been changed.
				$index=0; //Provides the index number of $changes array.
				
				if($input["last_name"]!=$employee->last_name){
					$isChanged = true;
					$changes[$index] = 1+$index.".) last name (from <strong>".$employee->last_name."</strong> to <strong>".trim($input["last_name"])."</strong>).<br/>";
					$index+=1;
				}
					
				if($input["first_name"]!=$employee->first_name){
					$isChanged = true;
					$changes[$index] = 1+$index.".) first name (from <strong>".$employee->first_name."</strong> to <strong>".trim($input["first_name"])."</strong>).<br/>";
					$index+=1;
				}
				
				if($input["nickname"]!=$employee->nickname){
					
					$oldNickname = !empty($employee->nickname) ? $employee->nickname : "none";
					$newNickname = !empty(trim($input["nickname"])) ? trim($input["nickname"]) : "none";
					
					$isChanged = true;
					$changes[$index] = 1+$index." nickname (from <strong>".$oldNickname."</strong> to <strong>".$newNickname."</strong>).<br/>";
					$index+=1;
				}
				
				if($input["username"]!=$employee->username){
					
					$oldUsername = !empty($employee->username) ? $employee->username : "none";
					$newUsername = !empty(trim($input["username"])) ? trim($input["username"]) : "none";
					
					$isChanged = true;
					$changes[$index] =1+$index.".) username (from <strong>".$oldUsername."</strong> to <strong>".$newUsername."</strong>).<br/>";
					$index+=1;
				}
				
				if($input["employee_number"]!=$employee->employee_number){
					$isChanged = true;
					$changes[$index] = 1+$index.".) employee number (from <strong>".$employee->employee_number."</strong> to <strong>".trim($input["employee_number"])."</strong>).<br/>";
					$index+=1;
				}
				
				if($input["status"]!=$employee->status){
					$isChanged = true;
					$changes[$index] = 1+$index.".) status (from <strong>".$employee->status."</strong> to <strong>".trim($input["status"])."</strong>).<br/>";
					$index+=1;
				}
				
				if($input["manager_id"]!=$employee->manager_id){
					
					$isChanged = true;
					$newManagerName = Manager::find($input["manager_id"]);
					
					$oldManager = !empty($employee->manager_id) ? $employee->manager->first_name." ".$employee->manager->last_name : "none";
					$newManager = !$newManagerName ? "none" : $newManagerName->first_name." ".$newManagerName->last_name;
					
					
					$changes[$index] = 1+$index.".) manager (from <strong>".$oldManager."</strong> to <strong>".$newManager."</strong>).<br/>";
					$index+=1;
				}
				
				if($input["start_date"]!=$employee->start_date){
					
					$isChanged = true;
					$changes[$index] = 1+$index.".) start date (from <strong>".$employee->start_date."</strong> to <strong>".$input["start_date"]."</strong>).<br/>";
					$index+=1;
				}
				
				if($input["end_date"]!=$employee->end_date){
					
					$oldEndDate = !empty($employee->end_date) ? $employee->end_date : "none";
					$newEndDate = !empty(trim($input["end_date"])) ? trim($input["end_date"]) : "none";
					
					$isChanged = true;
					$changes[$index] = 1+$index.".) end date (from <strong>".$oldEndDate."</strong> to <strong>".$newEndDate."</strong>).<br/>";
					$index+=1;
				}
				
				if($input["nsn_id"]!=$employee->nsn_id){
					
					$oldNsn = !empty($employee->nsn_id) ? $employee->nsn_id : "none";
					$newNsn = !empty(trim($input["nsn_id"])) ? trim($input["nsn_id"]) : "none";
					
					$isChanged = true;
					$changes[$index] = 1+$index.".) NSN ID (from <strong>".$oldNsn."</strong> to <strong>".$newNsn."</strong>).<br/>";
					$index+=1;
				}
				
				if($input["email"]!=$employee->email){
					
					$oldEmail = !empty($employee->email) ? $employee->email : "none";
					$newEmail = !empty(trim($input["email"])) ? trim($input["email"]) : "none";
					
					$isChanged = true;
					$changes[$index] = 1+$index.".) email (from <strong>".$oldEmail."</strong> to <strong>".$newEmail."</strong>).<br/>";
					$index+=1;
				}
				
				if($input["business_line"]!=$employee->business_line_id){
					$isChanged = true;
					$newBusinessLineName = BusinessLine::find($input["business_line"]);
					
					$oldBusinessLine = !empty($employee->businessline->name) ? $employee->businessline->name : "none";
					$newBusinessLine = !$newBusinessLineName ? "none" : $newBusinessLineName->name;
					
					$changes[$index] = 1+$index.".) business line (from <strong>".$oldBusinessLine."</strong> to <strong>".$newBusinessLine."</strong>).<br/>";
					$index+=1;
				}
				
				if($input["unit"]!=$employee->unit_id){
					$isChanged = true;
					
					$newUnitName = Unit::find($input["unit"]);
						
					$oldUnit = !empty($employee->unit->name) ? $employee->unit->name : "none";
					$newUnit = !$newUnitName ? "none" : $newUnitName->name;
					
					$changes[$index] = 1+$index.".) unit (from <strong>".$oldUnit."</strong> to <strong>".$newUnit."</strong>).<br/>";
					$index+=1;
				}
				
				if($input["subunit"]!=$employee->subunit){
					
					$oldSubunit = !empty($employee->subunit) ? $employee->subunit : "none";
					$newSubunit = !empty(trim($input["subunit"])) ? trim($input["subunit"]) : "none";
					
					$isChanged = true;
					$changes[$index] = 1+$index.".) subunit (from <strong>".$oldSubunit."</strong> to <strong>".$newSubunit."</strong>).<br/>";
					$index+=1;
				}
				
				if($input["cellphone_number"]!=$employee->cellphone_number){
					
					$oldCellphoneNumber = !empty($employee->cellphone_number) ? $employee->cellphone_number : "none";
					$newCellphoneNumber = !empty(trim($input["cellphone_number"])) ? trim($input["cellphone_number"]) : "none";
					
					$isChanged = true;
					$changes[$index] = 1+$index.".) cellphone number (from <strong>".$oldCellphoneNumber."</strong> to <strong>".$newCellphoneNumber."</strong>).<br/>";
					$index+=1;
				}
				
				if(!$isChanged){
					Input::flash();
					return Redirect::to('employees/updateemployee/'.$employee->employee_number)->with('info',"Nothing has changed. </3");
				}
				
				else{
					$changesMade = implode($changes,"");
					$desc = "(".Session::get('user_type').") "."<strong>".Session::get('username')."</strong> has updated employee <strong>".$employee->first_name." ".$employee->last_name."'s</strong> information. These are the fields that have been modified:<br/> ".$changesMade;
						
					//Save updates
					$employee->last_name = trim($input["last_name"]);
					$employee->first_name = trim($input["first_name"]);
					$employee->nickname = !empty(trim($input["nickname"])) ? trim($input["nickname"]) : null;
					$employee->username = !empty(trim($input["username"])) ? trim($input["username"]) : null;
					$employee->employee_number = $input["employee_number"];
					$employee->status = $input["status"];
 					$employee->manager_id = !empty(trim($input["manager_id"])) ? $input["manager_id"] : null;
					$employee->start_date = $input["start_date"];
					$employee->end_date = !empty(trim($input["end_date"])) ? trim($input["end_date"]) : null;
					$employee->nsn_id = !empty(trim($input["nsn_id"])) ? trim($input["nsn_id"]) : null;
					$employee->email= !empty(trim($input["email"])) ? trim($input["email"]) : null;
					$employee->business_line_id = !empty(trim($input["business_line"])) ? $input["business_line"] : null;
					$employee->unit_id = $input["unit"]!=null ? $input["unit"]!=null ? $input["unit"]:null : null;
					$employee->subunit = !empty(trim($input["subunit"])) ? trim($input["subunit"]) : null;
					$employee->cellphone_number = !empty(trim($input["cellphone_number"])) ? trim($input["cellphone_number"]) : null;
					
					$employee->save();
						
					//Log the changes made
					$newLog = new UserLog;
					$newLog->description = $desc;
					$newLog->user_id = Session::get('user_id');
					$newLog->type="Employees";
						
					$newLog->save();
						
					return Redirect::to('employees/updateemployee/'.$input["employee_number"])->with('success',"You have successfully updated the employee information.");
						
				}
				
			}
 		}
		
		else{
			return Redirect::to('/');
		}
		
	}
	
	public function import(){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
		
			$view = View::make('Employees.import_employees');
			$view->nav="employees";
			return $view;
				
		}
		
		else{
			return Redirect::to('/');
		}
	}
	
	public function postImport(){
		

		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")){
			
			if(!Input::hasFile('file')){
				Input::flash();
				return Redirect::to('employees/import')->with('message',"Please select a valid excel file.");
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
				return Redirect::to('employees/import')->with('message',"Invalid file selected.");
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
					
					if(isset($ex["employeenumber"]) && isset($ex["lastname"]) && isset($ex["firstname"]) && isset($ex["startdate"]) && isset($ex["status"])
					)
					{
						$excelIsValid = true;
					}
					
				}
				
/*				6. If file is invalid, redirect to import form and return an error. */
				
				if(!$excelIsValid){
					Input::flash();
					File::delete($readFile);
					return Redirect::to('employees/import')->with('message',"Excel file has invalid attributes. Please download the form.");
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
					
/*
 * 
 */
					$start_date = !empty(trim($r->startdate)) ? trim($r->startdate) : "1994-04-16";
					
					$validator = Validator::make(
							array(
									"employee number"=>trim($r->employeenumber),
									"last name"=>trim($r->lastname),
									"first name"=>trim($r->firstname),
									"username"=>trim($r->username),
									"start date"=>trim($r->startdate),
									"end date"=>trim($r->enddate),
									"email"=>trim($r->email),
									"status"=>trim($r->status),
							),
							array(
									"employee number"=>"required|numeric|unique:tbl_employees,employee_number",
									"last name"=>"required",
									"first name"=>"required",
									"username"=>"unique:tbl_employees,username",
									"start date"=>"required|date:Y-m-d",
									"end date"=>"date:Y-m-d|after:".$start_date,
									"email"=>"unique:tbl_employees,email",
									"status"=>"required"
							),
							array(
									"after"=>"The :attribute must be after the employee start date."
							)
					);
					
 					if($validator->fails()){
						
/* 					7. When error has been found, $rowsWithError is immediately updated. Also, $hasError and $rowHasError are set to true.*/
						$hasError=true;
						$rowHasError=true;
						$rowsWithErrors[$rowIndex]=$rowIndex;
						
/* 					8. Then I will check which fields has error.
 * 
*					9. If an error has been found in a certain field,
*					   I will loop through the errors found on that field, increment the $errorCount (which, again, tracks
*					   how many errors has been found on a certain row.), update the two-dimensional $error array. 
*					   Please note that the first array of $error contains the row number which the errors found belong to.
*
*/
						if($validator->messages()->get("employee number")){

							foreach($validator->messages()->get("employee number") as $e){
								$errorCount+=1;
								$error[$rowIndex][$errorCount] = $errorCount.". ".$e . "<br/>";
									
							}
						}
						 
						if($validator->messages()->get("last name")){
							foreach($validator->messages()->get("last name") as $e){
								$errorCount+=1;
								$error[$rowIndex][$errorCount] = $errorCount.". ".$e . "<br/>";
									
							}
						}
						
						if($validator->messages()->get("first name")){
							foreach($validator->messages()->get("first name") as $e){
								$errorCount+=1;
								$error[$rowIndex][$errorCount] = $errorCount.". ".$e . "<br/>";
									
							}
						}
						
						if($validator->messages()->get("username")){
							foreach($validator->messages()->get("username") as $e){
								$errorCount+=1;
								$error[$rowIndex][$errorCount] = $errorCount.". ".$e . "<br/>";
									
							}
						}
						
						if($validator->messages()->get("start date")){
							foreach($validator->messages()->get("start date") as $e){
								$errorCount+=1;
								$error[$rowIndex][$errorCount] = $errorCount.". ".$e . "<br/>";
									
							}
						}
						
						if($validator->messages()->get("end date")){
							foreach($validator->messages()->get("end date") as $e){
								$errorCount+=1;
								$error[$rowIndex][$errorCount] = $errorCount.". ".$e . "<br/>";
									
							}
						}
						
						if($validator->messages()->get("email")){
							foreach($validator->messages()->get("email") as $e){
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

					if(!preg_match('/^[\pL.-\s]+$/u', $r->firstname) || !preg_match('/^[\pL.-\s]+$/u', $r->lastname)){
						$hasError=true; //This will only matter if no errors has been found above.
						$rowHasError=true; //This will only matter if no errors has been found above.
						$rowsWithErrors[$rowIndex]=$rowIndex; //This will only matter if no errors has been found above.
					
						$errorCount+=1;
						$error[$rowIndex][$errorCount] = $errorCount.". " . "First name/last name fields must only contain alphabetic characters and whitespaces." . "<br/>";
					}
					
					if(!is_numeric($r->manager)){
						$hasError=true; //This will only matter if no errors has been found above.
						$rowHasError=true; //This will only matter if no errors has been found above.
						$rowsWithErrors[$rowIndex]=$rowIndex; //This will only matter if no errors has been found above.
						
						$errorCount+=1;
						$error[$rowIndex][$errorCount] = $errorCount.". " . "Manager ID should be numeric." . "<br/>";
					}
					
					if(is_numeric($r->manager) && !Manager::find($r->manager)){
						$hasError=true; //This will only matter if no errors has been found above.
						$rowHasError=true; //This will only matter if no errors has been found above.
						$rowsWithErrors[$rowIndex]=$rowIndex; //This will only matter if no errors has been found above.
						
						$errorCount+=1;
						$error[$rowIndex][$errorCount] = $errorCount.". " . "Invalid manager ID." . "<br/>";
					}
					
					if(empty(trim($r->nsnid)) && (!in_array(strtolower($r->status),array("academy","ojt","contractual","graduate","obsolete")))){
						$hasError=true; //This will only matter if no errors has been found above.
						$rowHasError=true; //This will only matter if no errors has been found above.
						$rowsWithErrors[$rowIndex]=$rowIndex; //This will only matter if no errors has been found above.
						
						$errorCount+=1;
						$error[$rowIndex][$errorCount] = $errorCount.". " . "The NSN ID is required." . "<br/>";
						
					}
					
					if(!empty($r->nsnid) && !is_numeric(trim($r->nsnid)) && (!in_array($r->status,array("academy","ojt","contractual","graduate","obsolete")))){
						$hasError=true; //This will only matter if no errors has been found above.
						$rowHasError=true; //This will only matter if no errors has been found above.
						$rowsWithErrors[$rowIndex]=$rowIndex; //This will only matter if no errors has been found above.
					
						$errorCount+=1;
						$error[$rowIndex][$errorCount] = $errorCount.". " . "The NSN ID should be numeric." . "<br/>";
					
					}
					
					if(!empty($r->nsnid) && Employee::where("nsn_id","=",$r->nsnid)->first()){
						$hasError=true; //This will only matter if no errors has been found above.
						$rowHasError=true; //This will only matter if no errors has been found above.
						$rowsWithErrors[$rowIndex]=$rowIndex; //This will only matter if no errors has been found above.
					
						$errorCount+=1;
						$error[$rowIndex][$errorCount] = $errorCount.". " . "NSN ID already exists." . "<br/>";
					}
					
					if (!empty($r->email) && !filter_var(trim($r->email), FILTER_VALIDATE_EMAIL)) {
						$hasError=true; //This will only matter if no errors has been found above.
						$rowHasError=true; //This will only matter if no errors has been found above.
						$rowsWithErrors[$rowIndex]=$rowIndex; //This will only matter if no errors has been found above.
					
						$errorCount+=1;
						$error[$rowIndex][$errorCount] = $errorCount.". " . "Invalid e-mail address." . "<br/>";
					}
					
					if(is_numeric($r->businessline) && !BusinessLine::find($r->businessline)){
						$hasError=true; //This will only matter if no errors has been found above.
						$rowHasError=true; //This will only matter if no errors has been found above.
						$rowsWithErrors[$rowIndex]=$rowIndex; //This will only matter if no errors has been found above.
							
						$errorCount+=1;
						$error[$rowIndex][$errorCount] = $errorCount.". " . "Invalid Business Line ID." . "<br/>";
					}
						
					if(is_numeric($r->unit) && !Unit::find($r->unit)){
						$hasError=true; //This will only matter if no errors has been found above.
						$rowHasError=true; //This will only matter if no errors has been found above.
						$rowsWithErrors[$rowIndex]=$rowIndex; //This will only matter if no errors has been found above.
							
						$errorCount+=1;
						$error[$rowIndex][$errorCount] = $errorCount.". " . "Invalid Unit ID." . "<br/>";
					}
					
					if((is_numeric($r->unit) && is_numeric($r->businessline)) && (Unit::find($r->unit) && !Unit::where("id","=",$r->unit)->where("businessline_id","=",$r->businessline)->first())){
						$hasError=true; //This will only matter if no errors has been found above.
						$rowHasError=true; //This will only matter if no errors has been found above.
						$rowsWithErrors[$rowIndex]=$rowIndex; //This will only matter if no errors has been found above.
							
						$errorCount+=1;
						$error[$rowIndex][$errorCount] = $errorCount.". " . "Selected Unit ID does not belong to the selected Business Line ID." . "<br/>";
					}
					
					if(!in_array(strtolower($r->status),array("ojt","contractual","nsn guest","academy","graduate","on-board","resigned","obsolete"))){
						$hasError=true; //This will only matter if no errors has been found above.
						$rowHasError=true; //This will only matter if no errors has been found above.
						$rowsWithErrors[$rowIndex]=$rowIndex; //This will only matter if no errors has been found above.
						
						$errorCount+=1;
						$error[$rowIndex][$errorCount] = $errorCount.". " . "Invalid employee status." . "<br/>";
					}

					if(!$rowHasError){
						
						$hasCorrectRows = true;
						
						$desc = "(".Session::get('user_type').") "."<strong>".Session::get('username')."</strong> has added employee <strong>".trim($r->firstname)." ".trim($r->lastname)."</strong>, employee number <strong>".trim($r->employeenumber)."</strong>, with status <strong>".trim($r->status)."</strong>.";
						
						$employee = new Employee;
						
						$employee->employee_number = $r->employeenumber;
						$employee->last_name = trim($r->lastname);
						$employee->first_name = trim($r->firstname);
						$employee->username = trim($r->username)!=null ? trim($r->username) : null;
						$employee->nickname = trim($r->nickname)!=null ? trim($r->nickname) : null;
						$employee->manager_id = $r->manager!=null ? $r->manager : null;
						$employee->start_date = $r->startdate;
						$employee->end_date = $r->enddate!=null ? $r->enddate : null;
						$employee->nsn_id = $r->nsnid!=null ? $r->nsnid : null;
						$employee->email = trim($r->email)!=null ? trim($r->email) : null;
						$employee->business_line_id = $r->businessline!=null ? $r->businessline : null;
						$employee->unit_id = $r->unit!=null ? $r->unit : null;
						$employee->subunit = trim($r->subunit)!=null ? trim($r->subunit) : null;
						$employee->cellphone_number = trim($r->cellphonenumber)!=null ? trim($r->cellphonenumber) : null;
						$employee->status = trim($r->status);
						
						$employee->save();
						
						//Log the changes made
						$newLog = new UserLog;
						$newLog->description = $desc;
						$newLog->user_id = Session::get('user_id');
						$newLog->type="Employees";
						
						$newLog->save();
						
 					}
				}

  				File::delete($readFile);
  				
  				if($hasCorrectRows){

  					//Log the changes made
  					$desc = "(".Session::get("user_type").") <b>".Session::get("username")."</b> has imported data to the employees database. ";
  					
  					$newLog = new UserLog;
  					$newLog->description = $desc;
  					$newLog->user_id = Session::get('user_id');
  					$newLog->type="Employees";
  					
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
			
			$view = View::make("Employees.import_result");
			$view->fileHasError = $fileHasError;
			
			if($rowsWithErrors!=null){
				$view->rowsWithErrors = $rowsWithErrors;
				$view->errorDetails = $errorDetails;
			}

			$view->hasCorrectRows = $hasCorrectRows;
			$view->nav="employees";
			
			return $view;
			
		}
		
		else{
			
		}
		
	}
	
	public function deleteEmployee(){
		
		
		if(Session::has('username') && (Session::get('user_type')=="Root")){
			
			$employees = Input::get("employee_id");
			$hasDeletedAny=false;
			$noOfDeletedEmployees = 0;
			
			foreach($employees as $e){
				
				$employee  = Employee::find($e);
					
				if(!$employee){
					continue;
				}
				
				
				$desc = "(".Session::get('user_type').") "."<strong>".Session::get('username')."</strong> has deleted employee <strong>".$employee->first_name." ".$employee->last_name." (Employee #: ".$employee->employee_number.") </strong>.";
				
				//Log the changes made
				$newLog = new UserLog;
				$newLog->description = $desc;
				$newLog->user_id = Session::get('user_id');
				$newLog->type="Employees";
					
				$newLog->save();
				
				$hasDeletedAny = true;
				$noOfDeletedEmployees+=1;
				
				$employee->delete();
				
			}
			
			if($hasDeletedAny){
				$desc = "(".Session::get('user_type').") "."<strong>".Session::get('username')."</strong> has deleted <strong>".$noOfDeletedEmployees."</strong> employee(s).";
				//Log the changes made
				$newLog = new UserLog;
				$newLog->description = $desc;
				$newLog->user_id = Session::get('user_id');
				$newLog->type="Employees";
					
				$newLog->save();
			}
			
			return Redirect::to(Session::get("page"));
			
		}
		
		else{
			return Redirect::to("/");
		}
	}
}