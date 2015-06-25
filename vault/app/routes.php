<?php

/*
 * NetworkLabs Inc.
 * Vault Assets Management System
 * IT Team
 * 
 * 2014
 * 
 * Programmed by Christian Leroy M. Castillo
 * User Interface developed by Yves Hung
 * 
 |=========================================================|
 *
 *
 * Routes for Home Controller
 * 
 * Home Controller handles and manages the user accounts authentication.
 * This controller gives access or redirects the user to the user's home page,
 *  which depends on the user's access privileges.
 * 
 */

Route::get('/', 'HomeController@index' );
Route::get('login', 'HomeController@index');
Route::get('logout', 'HomeController@logout');
Route::post('authenticate','HomeController@authenticate');

/*
 * Routes for User Controller
 * 
 * User Controller handles the methods for User Accounts Management.
 * This controller is only accessible to users with 'Root Administrator' privileges.
 * 
 */

Route::get('accounts', 'AccountController@index');
Route::get('accounts/index', 'AccountController@index');
Route::get('accounts/addaccount','AccountController@addAccount');
Route::post('accounts/addaccount','AccountController@submitNewAccount');
Route::get('accounts/changestatus/{id}','AccountController@changeStatus');
Route::get('accounts/updateaccount/{id}','AccountController@updateAccount');
Route::post('accounts/submitaccountupdate','AccountController@submitAccountUpdate');
Route::post('accounts/search', 'AccountController@search');
Route::get('accounts/search/{keyword}', 'AccountController@searchKeyword');
Route::get('accounts/mysettings/{id}', 'AccountController@mysettings');
Route::post('accounts/savesettings', 'AccountController@savesettings');
Route::post('accounts/changepassword', 'AccountController@changepassword');
Route::get('accounts/passwordmanager', 'AccountController@passwordManager');
Route::post('accounts/resetpassword', 'AccountController@resetPassword');
Route::get('accounts/passwordgenerator', 'AccountController@passwordGenerator');
Route::post('accounts/generatepassword', 'AccountController@generatePassword');
Route::get('accounts/securesession','AccountController@secureSession');
Route::post('accounts/startsecuresession','AccountController@startSecureSession');
Route::get('accounts/closesecuresession','AccountController@closeSecureSession');

/*
 * Routes for Employee Controller
 * 
 * These routes are for the Employee Controller.
 * These routes are available to Admin and Root users only.
 * Used for managing the Employee databse.
 * 
 */

Route::get('employees','EmployeeController@index');
Route::get('employees/index','EmployeeController@index');
Route::get('employees/sort/{sortby}/{order}','EmployeeController@index');
Route::post('employees/search', 'EmployeeController@search');
Route::get('employees/search/{keyword}', 'EmployeeController@searchKeyword');
Route::get('employees/search/{keyword}/{sortby}/{order}', 'EmployeeController@searchKeyword');
Route::get('employees/filter/{status}','EmployeeController@filterEmployees');
Route::get('employees/filter/{status}/{sortby}/{order}','EmployeeController@filterEmployees');
Route::post('employees/searchfilter/{status}','EmployeeController@filterEmployeesSearch');
Route::get('employees/searchfilter/{status}/{keyword}','EmployeeController@filterEmployeesSearchKeyword');
Route::get('employees/searchfilter/{status}/{keyword}/{sortby}/{order}','EmployeeController@filterEmployeesSearchKeyword');
Route::get('employees/advancedsearch','EmployeeController@advancedSearch');
Route::get('employees/advancedsearch/search','EmployeeController@advancedSearchEmployees');
Route::get('employees/addemployee','EmployeeController@addEmployee');
Route::post('employees/submitnewemployee','EmployeeController@submitNewEmployee');
Route::get('employees/updateemployee/{id}','EmployeeController@updateEmployee');
Route::post('employees/submitemployeeupdate','EmployeeController@submitEmployeeUpdate');
Route::get('employees/import','EmployeeController@import');
Route::post('employees/postimport','EmployeeController@postImport');
Route::post('employees/deleteemployees','EmployeeController@deleteEmployee');
Route::get('employees/dummy','EmployeeController@dummy');

/*
 * Client Assets Controller
 * 
 * This controller is the controller for all client assets. Also the default for URL/assets
 * Accessible and manageable to root administrators and administrators.
 * Viewable for users.
 * 
 */

Route::get("assets", function(){ return Redirect::to('assets/client/view/laptops'); });
Route::get("assets/client/view/{assetClass}","ClientController@index");
Route::get("assets/client/view/{assetClass}/{sortby}/{order}","ClientController@index");
Route::post("assets/client/search/{assetClass}","ClientController@search");
Route::get("assets/client/search/{assetClass}/{keyword}","ClientController@searchKeyword");
Route::get("assets/client/search/{assetClass}/{keyword}/{sortby}/{order}","ClientController@searchKeyword");
Route::get("assets/client/advancedsearch","ClientController@advancedSearch");
Route::get("assets/client/advancedsearch/search","ClientController@advancedSearchAssets");
Route::get("assets/client/logs/{id}","ClientController@logs");
Route::get("assets/client/logs/{id}/{transaction}","ClientController@filterLogs");
Route::get("assets/client/add/{assetClass}","ClientController@addAsset");
Route::post("assets/client/submitnewasset","ClientController@submitNewAsset");
Route::get("assets/client/osImage","ClientController@osImage");
Route::get("assets/client/update/{assetClass}/{id}","ClientController@updateAsset");
Route::post("assets/client/submitassetupdate","ClientController@submitAssetUpdate");
Route::get("assets/client/returnasset/{id}","ClientController@logAsReturned");
Route::post("assets/client/returned","ClientController@returned");
Route::get("assets/client/lostasset/{id}","ClientController@logAsLost");
Route::post("assets/client/lost","ClientController@lost");
Route::get("assets/client/transferasset/{id}","ClientController@transferAsset");
Route::post("assets/client/transfer","ClientController@transfer");
Route::get("assets/client/image/{id}","ClientController@image");
Route::post("assets/client/saveimage","ClientController@saveImage");
Route::get("assets/client/remarks/{id}","ClientController@assetRemarks");
Route::get("assets/client/addremarks/{id}","ClientController@addRemarks");
Route::post("assets/client/submitnewremarks","ClientController@submitNewRemarks");
Route::get("assets/client/updateremark/{remark_id}","ClientController@updateRemarks");
Route::post("assets/client/submitremarkupdate","ClientController@submitRemarkUpdate");
Route::get("assets/client/deleteremark/{id}","ClientController@deleteremark");
Route::get("assets/client/generatewaiver/{assetClass}/{id}","ClientController@generateWaiver");
Route::get('assets/client/import','ClientController@import');
Route::post('assets/client/postimport','ClientController@postImport');
Route::post("assets/client/deleteassets","ClientController@deleteAssets");
Route::get("assets/client/redirector/{assetClassId}/{intent}","ClientController@redirector");
Route::get("assets/client/redirector/{assetClassId}/{intent}/{id}","ClientController@redirector");

/*
* Network Assets Controller
*
* This controller is the controller for all network assets.
* Accessible and manageable to root administrators and administrators.
* Viewable for users.
*
*/

Route::get("assets/network", function(){ return Redirect::to('assets/network/view/accesspoints'); });
Route::get("assets/network/view/{assetClass}","NetworkController@index");
Route::get("assets/network/view/{assetClass}/{sortby}/{order}","NetworkController@index");
Route::post("assets/network/search/{assetClass}","NetworkController@search");
Route::get("assets/network/search/{assetClass}/{keyword}","NetworkController@searchKeyword");
Route::get("assets/network/search/{assetClass}/{keyword}/{sortby}/{order}","NetworkController@searchKeyword");
Route::get("assets/network/advancedsearch","NetworkController@advancedSearch");
Route::get("assets/network/advancedsearch/search","NetworkController@advancedSearchAssets");
Route::get("assets/network/logs/{id}","NetworkController@logs");
Route::get("assets/network/logs/{id}/{transaction}","NetworkController@filterLogs");
Route::get("assets/network/add/{assetClass}","NetworkController@addAsset");
Route::post("assets/network/submitnewasset","NetworkController@submitNewAsset");
Route::get("assets/network/update/{assetClass}/{id}","NetworkController@updateAsset");
Route::post("assets/network/submitassetupdate","NetworkController@submitAssetUpdate");
Route::get("assets/network/lostasset/{id}","NetworkController@logAsLost");
Route::post("assets/network/lost","NetworkController@lost");
Route::get("assets/network/transferasset/{id}","NetworkController@transferAsset");
Route::post("assets/network/transfer","NetworkController@transfer");
Route::get('assets/network/import','NetworkController@import');
Route::post('assets/network/postimport','NetworkController@postImport');
Route::post("assets/network/deleteassets","NetworkController@deleteAssets");
Route::get("assets/network/redirector/{assetClassId}/{intent}","NetworkController@redirector");
Route::get("assets/network/redirector/{assetClassId}/{intent}/{id}","NetworkController@redirector");

/*
* Office Assets Controller
*
* This controller is the controller for all office assets.
* Accessible and manageable to root administrators and administrators.
* Viewable for users.
*
*/

Route::get("assets/office", function(){ return Redirect::to('assets/office/view/printers'); });
Route::get("assets/office/view/{assetClass}","OfficeController@index");
Route::get("assets/office/view/{assetClass}/{sortby}/{order}","OfficeController@index");
Route::post("assets/office/search/{assetClass}","OfficeController@search");
Route::get("assets/office/search/{assetClass}/{keyword}","OfficeController@searchKeyword");
Route::get("assets/office/search/{assetClass}/{keyword}/{sortby}/{order}","OfficeController@searchKeyword");
Route::get("assets/office/advancedsearch","OfficeController@advancedSearch");
Route::get("assets/office/advancedsearch/search","OfficeController@advancedSearchAssets");
Route::get("assets/office/logs/{id}","OfficeController@logs");
Route::get("assets/office/logs/{id}/{transaction}","OfficeController@filterLogs");
Route::get("assets/office/add/{assetClass}","OfficeController@addAsset");
Route::post("assets/office/submitnewasset","OfficeController@submitNewAsset");
Route::get("assets/office/update/{assetClass}/{id}","OfficeController@updateAsset");
Route::post("assets/office/submitassetupdate","OfficeController@submitAssetUpdate");
Route::get("assets/office/lostasset/{id}","OfficeController@logAsLost");
Route::post("assets/office/lost","OfficeController@lost");
Route::get("assets/office/transferasset/{id}","OfficeController@transferAsset");
Route::post("assets/office/transfer","OfficeController@transfer");
Route::get('assets/office/import','OfficeController@import');
Route::post('assets/office/postimport','OfficeController@postImport');
Route::post("assets/office/deleteassets","OfficeController@deleteAssets");
Route::get("assets/office/redirector/{assetClassId}/{intent}","OfficeController@redirector");
Route::get("assets/office/redirector/{assetClassId}/{intent}/{id}","OfficeController@redirector");

/*
 * Software Assets Controller
*
* This controller is the controller for all software assets.
* Accessible and manageable to root administrators and administrators.
* Viewable for users.
*
*/

Route::get("assets/software",function(){ return Redirect::to("assets/software/view"); });
Route::get("assets/software/view","SoftwareController@index");
Route::get("assets/software/view/{sortby}/{order}","SoftwareController@index");
Route::post("assets/software/search","SoftwareController@search");
Route::get("assets/software/search/{keyword}","SoftwareController@searchKeyword");
Route::get("assets/software/search/{keyword}/{sortby}/{order}","SoftwareController@searchKeyword");
Route::get("assets/software/advancedsearch","SoftwareController@advancedSearch");
Route::get("assets/software/advancedsearch/search","SoftwareController@advancedSearchAssets");
Route::get("assets/software/logs/{id}","SoftwareController@logs");
Route::get("assets/software/logs/{id}/{transaction}","SoftwareController@filterLogs");
Route::get("assets/software/add","SoftwareController@addAsset");
Route::post("assets/software/submitnewasset","SoftwareController@submitNewAsset");
Route::get("assets/software/update/{id}","SoftwareController@updateAsset");
Route::post("assets/software/submitassetupdate","SoftwareController@submitAssetUpdate");
Route::get("assets/software/lostasset/{id}","SoftwareController@logAsLost");
Route::post("assets/software/lost","SoftwareController@lost");
Route::get("assets/software/transferasset/{id}","SoftwareController@transferAsset");
Route::post("assets/software/transfer","SoftwareController@transfer");
Route::get('assets/software/import','SoftwareController@import');
Route::post('assets/software/postimport','SoftwareController@postImport');
Route::post("assets/software/deleteassets","SoftwareController@deleteAssets");

/*
 * IP Assets Controller
*
* This controller is the controller for all IP assets.
* Accessible and manageable to root administrators and administrators.
* Viewable for users.
*
*/

Route::get("assets/IP",function(){ return Redirect::to("assets/IP/view"); });
Route::get("assets/IP/view","IPController@index");
Route::get("assets/IP/view/{sortby}/{order}","IPController@index");
Route::get("assets/IP/add","IPController@addAsset");
Route::post("assets/IP/submitnewasset","IPController@submitNewAsset");
Route::post("assets/IP/search","IPController@search");
Route::get("assets/IP/search/{keyword}","IPController@searchKeyword");
Route::get("assets/IP/search/{keyword}/{sortby}/{order}","IPController@searchKeyword");
Route::get("assets/IP/update/{id}","IPController@updateAsset");
Route::post("assets/IP/submitassetupdate","IPController@submitAssetUpdate");
Route::get("assets/IP/logs/{id}","IPController@logs");
Route::get("assets/IP/logs/{id}/{transaction}","IPController@filterLogs");
Route::get("assets/IP/transferasset/{id}","IPController@transferAsset");
Route::post("assets/IP/transfer","IPController@transfer");
Route::get("assets/IP/advancedsearch","IPController@advancedSearch");
Route::get("assets/IP/advancedsearch/search","IPController@advancedSearchAssets");
Route::post("assets/IP/deleteassets","IPController@deleteAssets");

/*
 * Settings Controller
 * 
 * This controller is the controller
 * for miscellaneous settings of the system.
 * 
 */

Route::get('settings/employees/managers','SettingsController@managers');
Route::get('settings/employees/managers/search','SettingsController@searchManagers');
Route::get('settings/employees/addmanager','SettingsController@addManager');
Route::post('settings/employees/submitnewmanager','SettingsController@submitNewManager');
Route::get('settings/employees/updatemanager/{id}','SettingsController@updateManager');
Route::post('settings/employees/submitmanagerupdate','SettingsController@submitManagerUpdate');
Route::get('settings/employees/transferemployees','SettingsController@transferEmployees');
Route::post('settings/employees/committransfer','SettingsController@commitTransfer');
Route::get('settings/employees/deletemanager/{id}','SettingsController@deleteManager');
Route::get('settings/employees/businesslines','SettingsController@businessLines');
Route::get('settings/employees/businesslines/search','SettingsController@searchBusinessLines');
Route::get('settings/employees/addbusinessline','SettingsController@addBusinessLine');
Route::post('settings/employees/submitnewbusinessline','SettingsController@submitNewBusinessLine');
Route::get('settings/employees/updatebusinessline/{id}','SettingsController@updateBusinessLine');
Route::post('settings/employees/submitbusinesslineupdate','SettingsController@submitBusinessLineUpdate');
Route::get('settings/employees/deletebusinessline/{id}','SettingsController@deleteBusinessline');
Route::get('settings/employees/units','SettingsController@units');
Route::get('settings/employees/units/search','SettingsController@searchUnits');
Route::get('settings/employees/addunit','SettingsController@addUnit');
Route::post('settings/employees/submitnewunit','SettingsController@submitNewUnit');
Route::get('settings/employees/updateunit/{id}','SettingsController@updateUnit');
Route::post('settings/employees/submitunitupdate','SettingsController@submitUnitUpdate');
Route::get('settings/employees/deleteunit/{id}','SettingsController@deleteUnit');
Route::get('settings/employees/updatephonenumbers','SettingsController@updatePhoneNumbers');
Route::post('settings/employees/postphonenumbersupdate','SettingsController@postPhoneNumbersUpdate');
Route::get('settings/employees/phonenumbersupdateresult','SettingsController@phoneNumbersUpdateResult');
Route::get('settings/assets/assetmodels','SettingsController@assetModels');
Route::get('settings/assets/assetmodels/search','SettingsController@searchAssetModels');
Route::get('settings/assets/addassetmodel','SettingsController@addAssetModel');
Route::post('settings/assets/submitnewassetmodel','SettingsController@submitNewAssetModel');
Route::get('settings/assets/updateassetmodel/{id}','SettingsController@updateAssetModel');
Route::post('settings/assets/submitassetmodelupdate','SettingsController@submitAssetModelUpdate');
Route::get('settings/assets/deleteassetmodel/{id}','SettingsController@deleteAssetModel');
Route::get('settings/assets/softwaretypes','SettingsController@softwareTypes');
Route::get('settings/assets/softwaretypes/search','SettingsController@searchSoftwareTypes');
Route::get('settings/assets/addsoftwaretype','SettingsController@addSoftwareType');
Route::post('settings/assets/submitnewsoftwaretype','SettingsController@submitNewSoftwareType');
Route::get('settings/assets/updatesoftwaretype/{id}','SettingsController@updateSoftwareType');
Route::post('settings/assets/submitsoftwaretypeupdate','SettingsController@submitSoftwareTypeUpdate');
Route::get('settings/assets/deletesoftwaretype/{id}','SettingsController@deleteSoftwareType');

/*
 * Export Routes
 * 
 * These are the routes for Export Controller.
 * Export controller handles all the
 * processes in exporting data from the system.
 * 
 * 
 */

Route::get("export/client","ExportController@exportClient");
Route::get("export/client/begin","ExportController@exportClientBegin");
Route::get("export/network","ExportController@exportNetwork");
Route::get("export/network/begin","ExportController@exportNetworkBegin");
Route::get("export/office","ExportController@exportOffice");
Route::get("export/office/begin","ExportController@exportOfficeBegin");
Route::get("export/software","ExportController@exportSoftware");
Route::get("export/software/begin","ExportController@exportSoftwareBegin");
Route::get("export/employees","ExportController@exportEmployees");
Route::get("export/employees/begin","ExportController@exportEmployeesBegin");
// Route::get("export/assetlogs","ExportController@exportAssetLogs");
// Route::get("export/assetlogs/begin","ExportController@exportAssetLogsBegin");

/*
 * Reports Routes
 * 
 * Routes for reports generation.
 * 
 */

Route::get("reports","ReportsController@allAssetsReports");
Route::get("reports/allassets","ReportsController@allAssetsReports");
Route::get("reports/clientassets","ReportsController@clientAssetsReports");
Route::get("reports/networkassets","ReportsController@networkAssetsReports");
Route::get("reports/officeassets","ReportsController@officeAssetsReports");
Route::get("reports/softwareassets","ReportsController@softwareAssetsReports");
Route::get("reports/employees","ReportsController@employeesReports");

/*
 * Logs Routes
 * 
 * 
 */

Route::get("logs",function(){ return Redirect::to("logs/system"); });
Route::get("logs/system","LogsController@systemLogs");
Route::get("logs/system/filter","LogsController@filterSystemLogs");
Route::get("logs/assets","LogsController@assetsLogs");
Route::get("logs/assets/filter","LogsController@filterAssetsLogs");
Route::get("logs/softwareassets","LogsController@softwareAssetsLogs");
Route::get("logs/softwareassets/filter","LogsController@filtersoftwareAssetsLogs");
Route::get("logs/ipassets","LogsController@IPAssetsLogs");
Route::get("logs/ipassets/filter","LogsController@filterIPAssetsLogs");

/*
 * 
 * API Routes
 * 
 * This routes serves API requests, such as AJAX.
 * 
 */

Route::get("api/employees","ApiController@employees");

/*
 * Dummy Route
 * 
 * These routes are solely used for testing and experiments, and are not part of the actual application.
 * These routes are intended to be removed when the application is fully released.
 * 
 */



Route::get('pdf', function()
{
// 	$html = '<html><body>'
// 			. '<p>Put your html here, or generate it with your favourite '
// 					. 'templating system.</p>'
// 							. '</body></html>';

	$html = View::make("Others.waiver_view")->render();
	return PDF::load($html, 'A4', 'portrait')->show();

// 	$view = View::make("Others.waiver_view");
// 	return $view;
	
});

Route::get("404",function(){
	return View::make("error");
});

Route::get("viewdummy",function(){
	
	return View::make("dummy");
	
});

Route::get("viewdummy2",function(){

	return View::make("Others.waiver_view");

});

Route::get('dummy',function(){
	
	
	$employees = Employee::whereHas("assets",function($q){
				$q->whereHas("model",function($q){
					$q->where("name","=","HP Probook 640 G1");
				});
		})->get();
		
	echo count($employees)."<br/>";
	

});

Route::get('dummy2',function(){

	$cols = 10;
	$rows = 10;
	
	echo "<table border=\"1\">";
	
	for ($r =1; $r <= $rows; $r++){
	
		echo'<tr>';
	
		for ($c = 1; $c <= $cols; $c++)
			echo '<td>' .$c*$r.'</td>';
			echo '</tr>'; // close tr tag here
	
	}
	
	echo "</table>";
	
	$m=6;
	
	
	echo "<table border=\"1\">";
	
	for($i=1;$i<=$m;$i++){
		for($j=1;$j<=$m;$j++){
			echo $i*$j." ";
		}
		echo "<br/>";
	}
	
	echo"</table>";

});

Route::get('test',function(){
	
	return View::make("error");
	
});

Route::get("dummy3",function(){
	
// 	$em = Employee::has("manager")->get();
// 	echo $em->manager->first()->id;
// 	echo $em->count();
	
// 	foreach($em as $e){
// 		echo $e->manager->first_name;
// 	}

// 	$employees = Employee::paginate(10);
	
// 	foreach($employees as $e){
// 		//KEEP IN MIND TO CHECK IF NULL. BECAUSE IF IT IS, IT WILL RETURN A FUCKING ERROR YOU SANOVA BITCH
// 		if(!empty($e->manager->first_name))
// 		echo $e->manager->first_name."<br/>";
		
// 		else
// 			echo "null biiiitch<br/>";
// 	}

	$key = "4";
	$asset = Asset::where("serial_number","LIKE","$key")
				  ->orWhere("id","=",$key)
				  ->orWhereHas("employee", function($q) use($key){
				  		$q->where("last_name","LIKE","%$key%");
				  })->get();

	foreach($asset as $a){
		echo $a->employee->last_name."<br/>";
	}

});


Route::get("dummy4", function(){
	
// 	$logs = UserLog::whereBetween("datetime",array("2014-12-01","2014-12-02"." 23:59:59.000000"))->get();
	
// 	foreach($logs as $l){
// 		echo $l->datetime."<br/>";
// 	}

// 	$g1 = Asset::whereHas("classification",function($query){
// 			$query->where("name","=","Laptops");
// 		  })
// 		  ->whereHas("model",function($query){
// 			$query->where("id","=",1);
// 		  })
// 		  ->where("status","=","Available")
// 		  ->get();

// 	echo count($g1);			
				
	
	$models = Model::whereHas("classification",function($query){
						$query->where("name","=","Laptops");
			  })
			  ->get();
			  
			  
	foreach($models as $m){
		
		$assets[$m->id] = Asset::whereHas("model",function($query) use($m){
					$query->where("id","=",$m->id);
				})
				->where("status","=","Available")
				->count();
		
// 		echo $m->name.": ".count($assets)."<br/>";
		
	}

	//loop models again
	
	foreach($models as $m){
		echo $m->name.": ".$assets[$m->id]."<br/>";	
	}
	
});

