<?php

class AccountController extends BaseController {
	
/*
 * ======================================================================================================
 * __construct
 * ======================================================================================================
 * - In all controllers, constructor method (__construct) checks sessions, updates (if necessary), and
 * sets the date default timezone to Asia/Manila for accurate date and time stamps.
 * 
 * ======================================================================================================
 * index()
 * ======================================================================================================
 * - Default method for AccountController. Displays/lists all the user accounts of system, their status, 
 * and other relevant information.
 * 
 * ======================================================================================================
 * addAccount()
 * ======================================================================================================
 * -Displays the view for adding a user account.
 * 
 * ======================================================================================================
 * submitNewAccount()
 * ======================================================================================================
 * -POST method.
 * -Gets the user input and processes.
 * -Returns an error or success message, depending on the results of the input processing.
 * -If everything has been successful, adds a new user account.
 * 
 * ======================================================================================================
 * changeStatus()
 * ======================================================================================================
 * -I call this a simple method.
 * -A logged in Root user just basically have to visit the URL calling this method, and this method would
 * work accordingly depending on certain circumstances.
 * -Changes the user account status to "activated" or "deactivated".
 * 
 * ======================================================================================================
 * updateAccount($id)
 * -Displays the view for updating a user account.
 * -Parameter value $id is the ID of a user account to be updated.
 * -If everything has been successful, saves user account update.
 * 
 * ======================================================================================================
 * submitAccountUpdate()
 * ======================================================================================================
 * -POST method
 * -Processes user input and updates
 * -Returns an error, success, or information message depending on the input process results.
 * -Information message is released when nothing was changed in the account.
 * -Take note that I did not need an $id variable in the parameters list because the ID has been embedded
 *  as a hidden input field.
 * 
 * ======================================================================================================
 * search()
 * ======================================================================================================
 * -POST method
 * -Processes user input from the search box, does essential changes to the input, and passes the processed
 *  input value ($keyword) to searchKeyword().
 * 
 * ======================================================================================================
 * searchKeyword($keyword)
 * ======================================================================================================
 * -Uses $keyword [passed by method search() or manually written by a user(unsafe)] to search the user 
 *  accounts.
 * -Returns a view with all the user accounts retrieved based on $keyword.
 * 
 * ======================================================================================================
 * mySettings()
 * ======================================================================================================
 * -Displays the view for the user's account settings page.
 * 
 * ======================================================================================================
 * saveSettings()
 * ======================================================================================================
 * -POST method.
 * -Processes user input.
 * -Returns an error or success message, depending on the results of the input processing.
 * -If everything has been successful, saves the user settings.
 * 
 * ======================================================================================================
 * changePassword()
 * ======================================================================================================
 * -POST method.
 * -Similar to saveSettings(), but this one updates the password, something that saveSettings() does not
 * perform.
 * -If everything has been successful, saves the new password.
 * 
 * ======================================================================================================
 * passwordManager()
 * ======================================================================================================
 * -Displays the Password Manager page.
 * 
 * ======================================================================================================
 * resetPassword()
 * ======================================================================================================
 * -POST method.
 * -Processes user input.
 * -Returns an error or success depending on the input process results.
 * -If everything has been successful, updates the password of a user account.
 * 
 * ======================================================================================================
 * passwordGenerator()
 * ======================================================================================================
 * -Displays the Password Generator page.
 * -Password Generator just generates a hashed/encrypted password for backend (database) updating of
 * user account passwords. Rarely useful.
 * 
 * ======================================================================================================
 * generatePassword()
 * ======================================================================================================
 * -POST method.
 * -Returns the generated hashed/encrypted password.
 * 
 * ======================================================================================================
 * secureSession()
 * ======================================================================================================
 * -Displays the page for starting a secure session.
 * 
 * ======================================================================================================
 * startSecureSession()
 * ======================================================================================================
 * -POST method.
 * -Processes user inputs.
 * -Returns an error or success message, depending on input process results.
 * -Starts a secure session if everything has been successful.
 * -Secure session is an additional privilege provided to Root user accounts that allows them to view
 * and export product keys of software assets (only these, as of now).
 * -The privileges included with the secure session module may or may not be expanded in future updates of 
 * this application.
 * -All I want is to be paid $123 million in one payment for doing something great that would not result in
 * me dying/suffering.
 * 
 */	
	
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
	
	public function index(){
		
		if(Session::has('username') && Session::get('user_class')=="Root"){
			
			$view = View::make('Accounts.accounts');
			$view->users = User::where("id","!=","1")->orderBy('last_name')->paginate(25);
			$view->nav="accounts";
			
			return $view;
		}
		
		elseif(Session::has('username') && (Session::get('user_class')=="IT"  && Session::get('user_type')=="Admin")){
			$view = View::make('Accounts.accounts');
			$view->users = User::where("id","!=","1")->where("user_class","=","IT")->orderBy('last_name')->paginate(25); // will be removed?
			$view->nav="accounts";
				
			return $view;
		}
		
		elseif(Session::has('username') && (Session::get('user_class')=="LAB"  && Session::get('user_type')=="Admin")){
			$view = View::make('Accounts.accounts');
			$view->users = User::where("id","!=","1")->where("user_class","=","LAB")->orderBy('last_name')->paginate(25); // will be removed?
			$view->nav="accounts";
		
			return $view;
		}
		
		else{
			return Redirect::to('/');
		}
	}
	
	public function addAccount(){
		
		if(Session::has('username') && Session::get('user_class')=="Root"){
				
			$view = View::make('Accounts.add_account');
			$view->nav="accounts";
				
			return $view;
		}
		
		elseif(Session::has('username') && (Session::get('user_class')=="IT"  && Session::get('user_type')=="Admin")){
			$view = View::make('Accounts.add_account');
			$view->nav="accounts";
		
			return $view;
		}
		
		elseif(Session::has('username') && (Session::get('user_class')=="LAB"  && Session::get('user_type')=="Admin")){
			$view = View::make('Accounts.add_account');
			$view->nav="accounts";
		
			return $view;
		}
		
		else{
			return Redirect::to('/');
		}
		
	}
	
	public function submitNewAccount(){
		
		if(Session::has('username') && Session::get('user_type')=="Root"){
			
			$user = Input::all();
			
			
			$validator = Validator::make(
				array(
					"username"=>$user["username"],
					"first_name"=>$user["first_name"],
					"last_name"=>$user["last_name"],
					"password"=>$user["password"],
					"password2"=>$user["password2"],
					"user_class"=>$user["user_class"],
					"user_type"=>$user["user_type"]
						
				),
				array(
					"username"=>"required|alpha_dash|min:4|max:15",
					"first_name"=>"required",
					"last_name"=>"required",
					"password"=>"required|min:8|max:20",
					"password2"=>"required|min:8|max:20",
					"user_class"=>"required",
					"user_type"=>"required"
				)
			);
			
			if($validator->fails()){
				Input::flashExcept("password","password2");
				return Redirect::to('accounts/addaccount')->with('message',$validator->messages()->first());
			}
			
			else if(!preg_match('/^[\pL\s]+$/u', $user["first_name"]) || !preg_match('/^[\pL\s]+$/u', $user["last_name"])){
				Input::flash();
				return Redirect::to('accounts/addaccount')->with('message', "First name and last name must only contain alpabetic characters and whitespaces.");
			}
			
			else if($user["password"]!=$user["password2"]){
				Input::flashExcept("password","password2");
				return Redirect::to('accounts/addaccount')->with('message',"Passwords didn't match. Please try again.");
			}
			
			else if(User::where("username","=",$user["username"])->first()){
				Input::flashExcept("password","password2");
				return Redirect::to('accounts/addaccount')->with('message', "Username already exists!");
			}
			
			else{
				
				$desc = "(".Session::get('user_class')." -> ".Session::get('user_type').") "."<strong>".Session::get('username')."</strong> has created a new <strong>".strtolower($user["user_type"])."</strong> account under ".$user["user_class"]." department: <strong>".$user["username"]."</strong>.";
				
				$newUser = new User;
				$newUser->username = trim($user["username"]);
				$newUser->first_name = trim($user["first_name"]);
				$newUser->last_name = trim($user["last_name"]);
				$newUser->password = Hash::make($user["password"]);
				$newUser->user_class = $user["user_class"];
				$newUser->user_type = $user["user_type"];
				
				$newUser->save();
				
				//Log the changes made
				$newLog = new UserLog;
				$newLog->description = $desc;
				$newLog->user_id = Session::get('user_id');
				$newLog->type="System";
					
				$newLog->save();
				
				return Redirect::to('accounts/addaccount')->with('success',"You have successfully created a new account.");
			}
			
		}
		
		else{
			return Redirect::to('/');
			
		}
	}
	
	public function changeStatus($id){
		
		if(Session::has('username') && Session::get('user_type')=="Root"){
			
			//This method changes the activation status of a user account.
			$user = User::find($id);
			
			if($user){
				
				if($user->status==1){
					$user->status = 0;
					$user->save();
					return Redirect::to(Session::pull('page'));
				}
				
				else{
					$user->status = 1;
					$user->save();
					return Redirect::to(Session::pull('page'));
				}
				
			}
			
			else{
				return Redirect::to('/');
			}
			
		}

		else{
			return Redirect::to('/');
		}
		
		
	}
	
	public function updateAccount($id){
		
		if(Session::has('username') && Session::get('user_type')=="Root"){
			
			$user = User::find($id);
			
			if($user){
			
				$view = View::make('Accounts.update_account');
				$view->user = User::find($id);
				$view->nav="accounts";
				
				return $view;
			
			}
			
			else{
				return Redirect::to('/');
			}
		}
		
		else{
			return Redirect::to('/');
		}
	}
	
	public function submitAccountUpdate(){
		
		if(Session::has('username') && Session::get('user_type')=="Root"){
			
			//These variables are used to track if anything has been changed.
			$isChanged = false; //Boolean variable that checks if anything has been changed. Changes to true when a change has been detected.
			$changes = array(); //Collects the names of the columns that have been changed.
			$index=0; //Provides the index number of $changes array.
			
			$input = Input::all();
			$id = $input["id"];
			$user = User::find($id);
			
			if(!$user){
				return Redirect::to('/');
			}
			
			$validator = Validator::make(
					array(
							"username"=>$input["username"],
							"first_name"=>$input["first_name"],
							"last_name"=>$input["last_name"],
							"user_class"=>$input["user_class"],
							"user_type"=>$input["user_type"]
					),
					array(
							"username"=>"required|alpha_dash|min:4|max:15",
							"first_name"=>"required",
							"last_name"=>"required",
							"user_class"=>"required",
							"user_type"=>"required"
					)
			);
			
					
			if($validator->fails()){
				Input::flash();
				return Redirect::to('accounts/updateaccount/'.$id)->with('message',$validator->messages()->first());
			}
			
			else if(!preg_match('/^[\pL\s]+$/u', $input["first_name"]) || !preg_match('/^[\pL\s]+$/u', $input["last_name"])){
				Input::flash();
				return Redirect::to('accounts/updateaccount/'.$id)->with('message', "First name and last name must only contain alpabetic characters and whitespaces.");
			}

			else if(User::where("username","=",$input["username"])->first() && $user->username!=$input["username"]){
				
				Input::flash();
				return Redirect::to('accounts/updateaccount/'.$id)->with('message', "Username already exists!");
			}
			
			else{
				
				if($input["username"]!=$user->username){
					$isChanged = true;
					$changes[$index] = "Username (from '".$user->username."' to '".$input["username"]."')";
					$index+=1;
				}
					
				if($input["first_name"]!=$user->first_name){
					$isChanged = true;
					$changes[$index] = "First Name (from '".$user->first_name."' to '".$input["first_name"]."')";
					$index+=1;
				}
				
				if($input["last_name"]!=$user->last_name){
					$isChanged = true;
					$changes[$index] = "Last name (from '".$user->last_name."' to '".$input["last_name"]."')";
					$index+=1;
				}
				
				if($input["user_class"]!=$user->user_class){
					$isChanged = true;
					$changes[$index] = "Department (from '".$user->user_class."' to '".$input["user_class"]."')";
					$index+=1;
				}
				
				if($input["user_type"]!=$user->user_type){
					$isChanged = true;
					$changes[$index] = "User Type (from '".$user->user_type."' to '".$input["user_type"]."')";
					$index+=1;
				}
				
				if(!$isChanged){
					Input::flash();
					return Redirect::to('accounts/updateaccount/'.$id)->with('info',"Nothing has changed. </3");
				}
				
				else{
					$changesMade = implode($changes,", ");
					$desc = "(".Session::get('user_class')."->".Session::get('user_type').") "."<strong>".Session::get('username')."</strong> has updated <strong>".$user->username."'s</strong> account. These are the fields that have been modified : ".$changesMade.".";
							
					
					//Save updates
					$user->username = trim($input["username"]);
					$user->first_name = trim($input["first_name"]);
					$user->last_name = trim($input["last_name"]);
					$user->user_class = $input["user_class"];
					$user->user_type = $input["user_type"];
					
					$user->save();
					
					//Log the changes made
					$newLog = new UserLog;
					$newLog->description = $desc;
					$newLog->user_id = Session::get('user_id');
					$newLog->type="System";
					
					$newLog->save();
					
					
					if($user->id==Session::get("user_id")){
						
						Session::put('username',$input["username"]);
						Session::put('first_name',$input["first_name"]);
						Session::put('last_name',$input["last_name"]);
						Session::put('user_type',$input["user_type"]);
					}
					
					return Redirect::to('accounts/updateaccount/'.$id)->with('success',"You have successfully updated the user account.");
					
				}
				
				
			}
		}
		
		else{
			return Redirect::to('/');
		}
	}
	
	public function search(){
		
		if(Session::has('username') && Session::get('user_type')=="Root"){
			
			$keyword = stripslashes(Input::get('keyword'));
			$keyword = preg_replace('{/$}', '', $keyword);
			
			if(!empty($keyword)){
				return Redirect::to('accounts/search/'.urlencode($keyword))->withInput();
			}
			
			else{
				return Redirect::to('accounts');
			}
		}
		
		else{
			return Redirect::to('/');
		}
		
	}
	
	public function searchKeyword($keyword){
		
		if(Session::has('username') && Session::get('user_type')=="Root"){
			
			$view = View::make('Accounts.accounts');
			$view->nav="accounts";
			
			if(strtolower($keyword)=="activated" || strtolower($keyword)=="deactivated"){
				
				$status = $keyword=="activated"?1:0;
				$users = User::where("status","=",$status)
								->paginate(1);
				
				$view->default = $keyword;
				
			}
			
			else{
				
				/*
				* 1. Get the input
				* 2. Remove unnecessary whitespaces
				* 3. Insert wildcard '%' in the beginning and end of the keyword, and also in replace the whitespaces.
				* 	 I need to this so that mySQL will find all matched characters in a string. Example: MySQL finding 'gel' in 'angelica'.
				*
				*/
				
				$keyword = str_replace(' ', '%', trim(urldecode($keyword)));
					
				/*
				 * $keywordRaw is used for whereRaw() method of Eloquent.
				*  Processed the sameway $keyword was processed, but $keywordRaw is also quoted to avoid SQL injections, which
				*  the Eloquent method whereRaw() is prone.
				*
				*/
					
				$keywordRaw =  "%".str_replace(' ', '%', $keyword)."%";
				$keywordRaw = DB::connection()->getPdo()->quote($keywordRaw);
				
				$users = User::where("username","LIKE","%$keyword%")
				->orWhere("last_name","LIKE","%$keyword%")
				->orWhere("first_name","LIKE","%$keyword%")
				->orWhereRaw("concat(last_name,' ',first_name) LIKE $keywordRaw")
				->orWhereRaw("concat(first_name,' ',last_name) LIKE $keywordRaw")
				->orWhere("user_type","=", $keyword)
				->orderBy("last_name")
				->paginate(10);
			}
			
			
			$view->users = $users;
		
			return $view;
		}
			
		else{
			return Redirect::to('/');
		}
	}

	public function mySettings($id){
		
		if(Session::has('username') && Session::get("user_id")==$id){
			
			$user = User::find($id);
			
			if(!$user){
				return Redirect::to('/');
			}
			
			$view = View::make('Accounts.account_settings');
			$view->user = $user;
			$view->nav="accounts";
			
			return $view;
		}
		
		else{
			return Redirect::to('/');
		}
		
	}

	public function saveSettings(){
		
		if(Session::has('username') && Session::get("user_id")==Input::get("id")){
			
			$input = Input::all();
			$user = User::find($input["id"]);
			$id = $input["id"];
			
			
			if(!$user){
				return Redirect::to('/');
			}
			
			$validator = Validator::make(
					array(
							"username"=>$input["username"],
							"first_name"=>$input["first_name"],
							"last_name"=>$input["last_name"]
								
					),
					array(
							"username"=>"required|alpha_dash|min:4|max:15",
							"first_name"=>"required",
							"last_name"=>"required"
					)
			);
					
			if($validator->fails()){
				Input::flash();
				return Redirect::to('accounts/mysettings/'.$id)->with('message',$validator->messages()->first());
			}
				
			else if(User::where("username","=",$input["username"])->first() && $input["username"]!=Session::get("username")){
				Input::flash();
				return Redirect::to('accounts/mysettings/'.$id)->with('message', "Username already exists. Please be original.");
			}
				
			else if(!preg_match('/^[\pL\s]+$/u', $input["first_name"]) || !preg_match('/^[\pL\s]+$/u', $input["last_name"])){
				Input::flash();
				return Redirect::to('accounts/mysettings/'.$id)->with('message', "First name and last name must only contain alpabetic characters and whitespaces.");
			}
			
			else{
				//Save updates
				$user->username = $input["username"];
				$user->first_name = $input["first_name"];
				$user->last_name = $input["last_name"];
					
				$user->save();
				
				Session::put('username',$input["username"]);
				Session::put('first_name',$input["first_name"]);
				Session::put('last_name',$input["last_name"]);
				
				return Redirect::to('accounts/mysettings/'.$id)->with('success', "You have successfully updated your account settings.");
				
			}
			
			
		}
		
		else{
			return Redirect::to('/');
		}
	}
	
	public function changePassword(){
		
		if(Session::has('username') && Session::get("user_id")==Input::get("id")){
				
			$input = Input::all();
			$user = User::find($input["id"]);
			$id = $input["id"];
			
			if(!$user){
				return Redirect::to('/');
			}
			
			$validator = Validator::make(
				array("old_password"=>$input["old_password"],
					  "new_password"=>$input["new_password"],
					  "retype password field"=>$input["new_password2"]
				),
				array(
					  "old_password"=>"required",
					  "new_password"=>"required|min:8",
					  "retype password field"=>"required|min:8"
				)
			);
			
			if($validator->fails()){
				Input::flash();
				return Redirect::to('accounts/mysettings/'.$id)->with('message',$validator->messages()->first());
			}
			
			else if(!Hash::check($input["old_password"],$user->password)){
				Input::flash();
				return Redirect::to('accounts/mysettings/'.$id)->with('message',"Invalid old password entered.");
			}
			
			else if($input["new_password"]!=$input["new_password2"]){
				Input::flash();
				return Redirect::to('accounts/mysettings/'.$id)->with('message',"New passwords didn't match. Try again.");
			}
			
			else{
				
				$user->password = Hash::make($input["new_password"]);
				$user->save();
				
				return Redirect::to('accounts/mysettings/'.$id)->with('success',"Password has been successfully changed.");
			}
			
		}
		
		else{
			return Redirect::to('/');
		}
	}
	
	public function passwordManager(){
		
		if(Session::has('username') && Session::get('user_type')=="Root"){
			
			$view = View::make('Accounts.reset_password');
			$view->nav="accounts";
			return $view;
		}
		
		else{
			return Redirect::to('/');
		}
		
	}
	
	public function resetPassword(){
		
		if(Session::has('username') && Session::get('user_type')=="Root"){
		
			$input = Input::all();
			
			$validator =  Validator::make(
					array(
						"username"=>$input["username"],
						"new_password"=>$input["new_password"],
						"new_password2"=>$input["new_password2"],
						"root_password"=>$input["root_password"]
							
					),
					array(
						"username"=>"required|alpha_dash|exists:tbl_user_accounts,username",
						"new_password"=>"required|min:8",
						"new_password2"=>"required|min:8",
						"root_password"=>"required"
					)
				);
			
			if($validator->fails()){
				Input::flash();
				return Redirect::to('accounts/passwordmanager')->with('message',$validator->messages()->first());
			}
			//!Auth::attempt(array('username'=>$username,'password'=>$password))
			else if(!Auth::attempt(array('username'=>Session::get('username'),'password'=>$input['root_password']))){
				Input::flash();
				return Redirect::to('accounts/passwordmanager')->with('message',"Invalid root password. Try again.");
			}
			
			else if($input["new_password"]!=$input["new_password2"]){
				Input::flash();
				return Redirect::to('accounts/passwordmanager')->with('message',"New passwords didn't match. Try again.");
			}
			
			else{
				
				$user = User::where("username","=",$input["username"])->first();
				
				if($user->user_type=="Root"){
					Input::flash();
					return Redirect::to('accounts/passwordmanager')->with('message',"Cannot reset password of root administrator accounts.");
				}
				
				$user->password = Hash::make(trim($input["new_password"]));
				$user->save();
				
				$desc = "(".Session::get('user_type').") "."<strong>".Session::get('username')."</strong> has reset the password of <strong>".$user->username."</strong>.";
				
				//Log the changes made
				$newLog = new UserLog;
				$newLog->description = $desc;
				$newLog->user_id = Session::get('user_id');
				$newLog->type="System";
					
				$newLog->save();
				
				return Redirect::to('accounts/passwordmanager')->with('success',"User <b>".$input['username']."'s</b> password has been changed. ");
			}
			
		}
		
		else{
			return Redirect::to('/');
		}
	}
	
	public function passwordGenerator(){
		if(Session::has('username') && Session::get('user_type')=="Root"){
				
			$view = View::make('Accounts.password_generator');
			$view->nav="accounts";
			return $view;
		}
		
		else{
			return Redirect::to('/');
		}
	}
	
	public function generatePassword(){
		
		if(Session::has('username') && Session::get('user_type')=="Root"){
		
			$password = Input::get("password");
			
			$view = View::make('Accounts.password_generator');
			$view->nav="accounts";
			
			if(empty($password)){
				$view->message = "Please enter a password to encrypt.";
				return $view;
			}
			
			else{
				$view->hashedPassword = Hash::make($password);
				return $view;
			}
			
		}
		
		else{
			return Redirect::to('/');
		}
	}
	
	public function secureSession(){
		
		if(Session::has('username') && (Session::get('user_type')=="Root")){
			
			if(Session::has("secure")){
				return Redirect::to("assets/software");
			}
			
			$view = View::make("Accounts.account_secure_session");
			return $view;
		}
		
		else{
			return Redirect::to('/');
		}
	}
	
	public function startSecureSession(){
	
		if(Session::has('username') && Session::get('user_type')=="Root" && !Session::has("secure")){
			
			$input = Input::all();
			
			if(!Auth::attempt(array('username'=>Session::get('username'),'password'=>$input['root_password']))){
				Input::flash();
				return Redirect::to('accounts/securesession')->with('message',"Invalid root password. Try again.");
			}
				
			Session::put("secure",Session::get("username"));
			return Redirect::to("assets/software");
		}
	
		else{
			return Redirect::to('/');
		}
	}
	
	public function closeSecureSession(){
		
		if(Session::has('username') && Session::get('user_type')=="Root"){
				
			Session::pull("secure");
			return Redirect::to("accounts/securesession")->with("success","Secure session has now been closed.");
		}
		
		else{
			return Redirect::to('/');
		}
	}
}