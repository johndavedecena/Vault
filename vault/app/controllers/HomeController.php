<?php

class HomeController extends BaseController {

	
/* 
 * ======================================================================================================
 * __construct
 * ======================================================================================================
 * - In all controllers, constructor method (__construct) checks sessions, updates (if necessary), and
 * sets the date default timezone to Asia/Manila for accurate date and time stamps.
 * 
 * ======================================================================================================
 * logout()
 * ======================================================================================================
 * -Self explanatory.
 * -Flushes all sessions and logs a user out.
 * 
 * ======================================================================================================
 * authenticate()
 * ======================================================================================================
 * -POST method.
 * -Processes login requests.
 * -If everything has been successful, starts user session and sends user to his/her designated home page.
 * 
 */
	
	public function __construct(){
		
		//Resetting the session every time a logged-in user visits a page is needed to make real-time changes on the account immediately printed upon the user's session.
		//For example, if a Root became an Admin while he/she is still online, his/her session & user privileges should be updated quickly for security reasons.
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

	public function index(){
		
		if(Session::has('username') && Session::get('user_type')=="Root"){
			return Redirect::to('accounts');
		}
		
		else if(Session::has('username') && Session::get('user_type')=="Admin"){
			return Redirect::to('employees');
		}
		
		else if(Session::has('username') && Session::get('user_type')=="User"){
			return Redirect::to('assets');
		}
		
		else{
			$view = View::make('Home.home');
			return $view;
		}
		
	}
	
	public function logout(){
		
		Session::flush();
		return Redirect::to('/');
		
	}
	
	public function authenticate(){
		
		
		if(Session::has('username') && Session::get('user_type')=="root"){
			return Redirect::to('accounts');
		}
		
		else if(Session::has('username') && Session::get('user_type')=="admin"){
			return Redirect::to('assets');
		}
		
		else{
			$username = Input::get('username');
			$password = Input::get('password');
			
			$validator = Validator::make(
					array('username'=>trim($username),
							'password'=>$password
					),
					array('username'=>'required|alphadash',
							'password'=>'required'
					)
			);
			
			if($validator->fails()){
				Input::flashExcept('password');
				return Redirect::to('login')->with('message',$validator->messages()->first());
			}
			
			else{
					
				if(!Auth::attempt(array('username'=>$username,'password'=>$password))){
					Input::flashExcept('password');
					return Redirect::to('login')->with('message','Invalid login credentials.');
				}
					
				else if(!Auth::attempt(array('username'=>$username,'password'=>$password,'status'=>1))){
					Input::flashExcept('password');
					return Redirect::to('login')->with('message','Account not yet activated. Please contact your administrator.');
				}
					
				else{
			
					$user = User::where('username','=',$username)->first();
			
					Session::put('user_id',$user->id);
					Session::put('username',$username);
					Session::put('first_name',$user->first_name);
					Session::put('last_name',$user->last_name);
					Session::put('user_type',$user->user_type);
					
					return Redirect::to('/');
			
				}
			}
		}
	}
}
