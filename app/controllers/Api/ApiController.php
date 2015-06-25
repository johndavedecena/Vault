<?php

class ApiController extends BaseController{
	
	public function employees(){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin" || Session::get("user_type")=="User")){
			
			$query = e(Input::get('q',''));
			
			if(!$query && $query == ''){
				return Response::json(array(), 400);
			}

			$query = "%".str_replace(' ', '%', $query)."%";
			$query = DB::connection()->getPdo()->quote($query);
			
			$employees = Employee::whereRaw("concat(first_name,' ',last_name) LIKE $query")
							 	->orWhereRaw("concat(last_name,' ',first_name) LIKE $query")
							 	->orWhereRaw("employee_number LIKE $query")
								->orderBy("first_name","asc")->get(array("employee_number","first_name","last_name","status"))->toArray();
			
			$data = $employees;
			
			return Response::json(array(
					'data'=>$data
			));
		}
		
		else{
			return Redirect::to("/");
		}	
	}
}