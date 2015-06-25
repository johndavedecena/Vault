<?php

class ReportsController extends BaseController{
	
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
	
	public function allAssetsReports(){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin" || Session::get("user_type")=="User")){
			
			$view = View::make("Reports.all_assets_reports");
			$view->nav="system";
			$view->tab="all";
			
			//Summary
			$clientCount = Asset::whereHas("classification",function($q){
				$q->where("type","=","Client");
			})->get()->count();
			
			$networkCount = Asset::whereHas("classification",function($q){
				$q->where("type","=","Network");
			})->count();
			
			$officeCount = Asset::whereHas("classification",function($q){
				$q->where("type","=","Office");
			})->get()->count();
			
			$softwareCount = Software::all()->count();
			
			$totalAssets = $clientCount + $networkCount + $officeCount + $softwareCount;
			
			if($totalAssets>0){
				
				$clientPercentage = $clientCount>0 ? ($clientCount/$totalAssets)*100 : "0.00";
				$networkPercentage = $networkCount>0 ? ($networkCount/$totalAssets)*100 : "0.00";
				$officePercentage = $officeCount>0 ? ($officeCount/$totalAssets)*100 : "0.00";
				$softwarePercentage = $softwareCount>0 ? ($softwareCount/$totalAssets)*100 : "0.00";
			}
			
			else{
				$clientPercentage = "0.00";
				$networkPercentage = "0.00";
				$officePercentage = "0.00";
				$softwarePercentage = "0.00";
			}
			
			$view->totalAssets = $totalAssets;
			
			$view->clientCount = $clientCount;
			$view->networkCount = $networkCount;
			$view->officeCount = $officeCount;
			$view->softwareCount = $softwareCount;
			
			$view->clientPercentage = $clientPercentage;
			$view->networkPercentage = $networkPercentage;
			$view->officePercentage = $officePercentage;
			$view->softwarePercentage = $softwarePercentage;
			
			return $view;
		}
		
		else{
			return Redirect::to("/");
		}
	}
	
	public function clientAssetsReports(){
	
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin" || Session::get("user_type")=="User")){
			
			$view = View::make("Reports.client_assets_reports");
			$view->nav="system";
			$view->tab="client";
				
			$totalClientAssets = Asset::whereHas("classification",function($q){
							$q->where("type","=","Client");
						})->get()->count();
						
			//Summary
						
			$laptops = Asset::whereHas("classification",function($q){
							$q->where("name","=","Laptops");
						})->get()->count();
			
			$monitors = Asset::whereHas("classification",function($q){
							$q->where("name","=","Monitors");
						})->get()->count();
						
			$dockingstations = Asset::whereHas("classification",function($q){
				$q->where("name","=","Docking Stations");
			})->get()->count();
				
			if($totalClientAssets>0){
				$laptopsPercentage = $laptops>0 ? ($laptops/$totalClientAssets)*100 : "0.00";
				$monitorsPercentage = $monitors>0 ? ($monitors/$totalClientAssets)*100 : "0.00";
				$dockingstationsPercentage = $dockingstations>0 ? ($dockingstations/$totalClientAssets)*100 : "0.00";
			}
			
			else{
				$laptopsPercentage = "0.00";
				$monitorsPercentage = "0.00";
				$dockingstationsPercentage = "0.00";
			}
			
			$view->totalClientAssets = $totalClientAssets;
				
			$view->laptops = $laptops;
			$view->monitors = $monitors;
			$view->dockingStations = $dockingstations;
				
			$view->laptopsPercentage = $laptopsPercentage;
			$view->monitorsPercentage = $monitorsPercentage;
			$view->dockingStationsPercentage = $dockingstationsPercentage;
			
			//Status
			
			//Laptops Status
			
			if($laptops>0){
				$view->l_available = Asset::whereHas("classification", function($q){ $q->where("name","=","Laptops"); })->where("status","=","Available")->count();
				$view->l_available_for_issuance = Asset::whereHas("classification", function($q){ $q->where("name","=","Laptops"); })->where("status","=","Available for Issuance")->count();
				$view->l_available_for_test_case = Asset::whereHas("classification", function($q){ $q->where("name","=","Laptops"); })->where("status","=","Available for Test Case")->count();
				$view->l_pwu_cebu = Asset::whereHas("classification", function($q){ $q->where("name","=","Laptops"); })->where("status","=","PWU - Cebu")->count();
				$view->l_ewu = Asset::whereHas("classification", function($q){ $q->where("name","=","Laptops"); })->where("status","=","EWU")->count();
				$view->l_for_checking = Asset::whereHas("classification", function($q){ $q->where("name","=","Laptops"); })->where("status","=","For Checking")->count();
				$view->l_for_repair = Asset::whereHas("classification", function($q){ $q->where("name","=","Laptops"); })->where("status","=","For Repair")->count();
				$view->l_it_use = Asset::whereHas("classification", function($q){ $q->where("name","=","Laptops"); })->where("status","=","IT Use")->count();
				$view->l_lost = Asset::whereHas("classification", function($q){ $q->where("name","=","Laptops"); })->where("status","=","Lost")->count();
				$view->l_pwu = Asset::whereHas("classification", function($q){ $q->where("name","=","Laptops"); })->where("status","=","PWU")->count();
				$view->l_recruitment = Asset::whereHas("classification", function($q){ $q->where("name","=","Laptops"); })->where("status","=","Recruitment")->count();
				$view->l_retired = Asset::whereHas("classification", function($q){ $q->where("name","=","Laptops"); })->where("status","=","Retired")->count();
				$view->l_test_case = Asset::whereHas("classification", function($q){ $q->where("name","=","Laptops"); })->where("status","=","Test Case")->count();
			}
			
			else{
				$view->l_available = 0;
				$view->l_available_for_issuance = 0;
				$view->l_available_for_test_case = 0;
				$view->l_pwu_cebu = 0;
				$view->l_ewu = 0;
				$view->l_for_checking = 0;
				$view->l_for_repair = 0;
				$view->l_it_use = 0;
				$view->l_lost = 0;
				$view->l_pwu = 0;
				$view->l_recruitment = 0;
				$view->l_retired = 0;
				$view->l_test_case = 0;
			}
			
			//Monitors Status
			
			if($monitors>0){
				$view->m_available = Asset::whereHas("classification", function($q){ $q->where("name","=","Monitors"); })->where("status","=","Available")->count();
				$view->m_available_for_issuance = Asset::whereHas("classification", function($q){ $q->where("name","=","Monitors"); })->where("status","=","Available for Issuance")->count();
				$view->m_available_for_test_case = Asset::whereHas("classification", function($q){ $q->where("name","=","Monitors"); })->where("status","=","Available for Test Case")->count();
				$view->m_pwu_cebu = Asset::whereHas("classification", function($q){ $q->where("name","=","Monitors"); })->where("status","=","PWU - Cebu")->count();
				$view->m_ewu = Asset::whereHas("classification", function($q){ $q->where("name","=","Monitors"); })->where("status","=","EWU")->count();
				$view->m_for_checking = Asset::whereHas("classification", function($q){ $q->where("name","=","Monitors"); })->where("status","=","For Checking")->count();
				$view->m_for_repair = Asset::whereHas("classification", function($q){ $q->where("name","=","Monitors"); })->where("status","=","For Repair")->count();
				$view->m_it_use = Asset::whereHas("classification", function($q){ $q->where("name","=","Monitors"); })->where("status","=","IT Use")->count();
				$view->m_lost = Asset::whereHas("classification", function($q){ $q->where("name","=","Monitors"); })->where("status","=","Lost")->count();
				$view->m_pwu = Asset::whereHas("classification", function($q){ $q->where("name","=","Monitors"); })->where("status","=","PWU")->count();
				$view->m_recruitment = Asset::whereHas("classification", function($q){ $q->where("name","=","Monitors"); })->where("status","=","Recruitment")->count();
				$view->m_retired = Asset::whereHas("classification", function($q){ $q->where("name","=","Monitors"); })->where("status","=","Retired")->count();
				$view->m_test_case = Asset::whereHas("classification", function($q){ $q->where("name","=","Monitors"); })->where("status","=","Test Case")->count();
			}
				
			else{
				$view->m_available = 0;
				$view->m_available_for_issuance = 0;
				$view->m_available_for_test_case = 0;
				$view->m_pwu_cebu = 0;
				$view->m_ewu = 0;
				$view->m_for_checking = 0;
				$view->m_for_repair = 0;
				$view->m_it_use = 0;
				$view->m_lost = 0;
				$view->m_pwu = 0;
				$view->m_recruitment = 0;
				$view->m_retired = 0;
				$view->m_test_case = 0;
			}
			
			//Docking Stations Status
			
			if($monitors>0){
				$view->d_available = Asset::whereHas("classification", function($q){ $q->where("name","=","Docking Stations"); })->where("status","=","Available")->count();
				$view->d_available_for_issuance = Asset::whereHas("classification", function($q){ $q->where("name","=","Docking Stations"); })->where("status","=","Available for Issuance")->count();
				$view->d_available_for_test_case = Asset::whereHas("classification", function($q){ $q->where("name","=","Docking Stations"); })->where("status","=","Available for Test Case")->count();
				$view->d_pwu_cebu = Asset::whereHas("classification", function($q){ $q->where("name","=","Docking Stations"); })->where("status","=","PWU - Cebu")->count();
				$view->d_ewu = Asset::whereHas("classification", function($q){ $q->where("name","=","Docking Stations"); })->where("status","=","EWU")->count();
				$view->d_for_checking = Asset::whereHas("classification", function($q){ $q->where("name","=","Docking Stations"); })->where("status","=","For Checking")->count();
				$view->d_for_repair = Asset::whereHas("classification", function($q){ $q->where("name","=","Docking Stations"); })->where("status","=","For Repair")->count();
				$view->d_it_use = Asset::whereHas("classification", function($q){ $q->where("name","=","Docking Stations"); })->where("status","=","IT Use")->count();
				$view->d_lost = Asset::whereHas("classification", function($q){ $q->where("name","=","Docking Stations"); })->where("status","=","Lost")->count();
				$view->d_pwu = Asset::whereHas("classification", function($q){ $q->where("name","=","Docking Stations"); })->where("status","=","PWU")->count();
				$view->d_recruitment = Asset::whereHas("classification", function($q){ $q->where("name","=","Docking Stations"); })->where("status","=","Recruitment")->count();
				$view->d_retired = Asset::whereHas("classification", function($q){ $q->where("name","=","Docking Stations"); })->where("status","=","Retired")->count();
				$view->d_test_case = Asset::whereHas("classification", function($q){ $q->where("name","=","Docking Stations"); })->where("status","=","Test Case")->count();
			}
			
			else{
				$view->d_available = 0;
				$view->d_available_for_issuance = 0;
				$view->d_available_for_test_case = 0;
				$view->d_pwu_cebu = 0;
				$view->d_ewu = 0;
				$view->d_for_checking = 0;
				$view->d_for_repair = 0;
				$view->d_it_use = 0;
				$view->d_lost = 0;
				$view->d_pwu = 0;
				$view->d_recruitment = 0;
				$view->d_retired = 0;
				$view->d_test_case = 0;
			}
			
			//Models
			$laptopModels = Model::whereHas("classification",function($q){ $q->where("name","=","Laptops"); })->orderBy("name")->get();
			$monitorModels = Model::whereHas("classification",function($q){ $q->where("name","=","Monitors"); })->orderBy("name")->get();
			$dockingStationModels = Model::whereHas("classification",function($q){ $q->where("name","=","Docking Stations"); })->orderBy("name")->get();
			
			$view->laptopModels = $laptopModels;
			$view->monitorModels = $monitorModels;
			$view->dockingStationModels = $dockingStationModels;
			
			//Status by Models
			
			//Laptop status by models
			
			foreach($laptopModels as $lm){
				
				$l_models_available[$lm->id] = Asset::whereHas("model",function($query) use($lm){
					$query->where("id","=",$lm->id);
				})
				->where("status","=","Available")
				->count();
				
				$l_models_available_for_issuance[$lm->id] = Asset::whereHas("model",function($query) use($lm){
					$query->where("id","=",$lm->id);
				})
				->where("status","=","Available for Issuance")
				->count();
				
				$l_models_available_for_test_case[$lm->id] = Asset::whereHas("model",function($query) use($lm){
					$query->where("id","=",$lm->id);
				})
				->where("status","=","Available for Test Case")
				->count();
				
				$l_models_pwu_cebu[$lm->id] = Asset::whereHas("model",function($query) use($lm){
					$query->where("id","=",$lm->id);
				})
				->where("status","=","PWU - Cebu")
				->count();
				
				$l_models_ewu[$lm->id] = Asset::whereHas("model",function($query) use($lm){
					$query->where("id","=",$lm->id);
				})
				->where("status","=","EWU")
				->count();
				
				$l_models_for_checking[$lm->id] = Asset::whereHas("model",function($query) use($lm){
					$query->where("id","=",$lm->id);
				})
				->where("status","=","For Checking")
				->count();
				
				$l_models_for_repair[$lm->id] = Asset::whereHas("model",function($query) use($lm){
					$query->where("id","=",$lm->id);
				})
				->where("status","=","For Repair")
				->count();
				
				$l_models_it_use[$lm->id] = Asset::whereHas("model",function($query) use($lm){
					$query->where("id","=",$lm->id);
				})
				->where("status","=","IT Use")
				->count();
				
				$l_models_lost[$lm->id] = Asset::whereHas("model",function($query) use($lm){
					$query->where("id","=",$lm->id);
				})
				->where("status","=","Lost")
				->count();
				
				$l_models_pwu[$lm->id] = Asset::whereHas("model",function($query) use($lm){
					$query->where("id","=",$lm->id);
				})
				->where("status","=","PWU")
				->count();
				
				$l_models_recruitment[$lm->id] = Asset::whereHas("model",function($query) use($lm){
					$query->where("id","=",$lm->id);
				})
				->where("status","=","Recruitment")
				->count();
				
				$l_models_retired[$lm->id] = Asset::whereHas("model",function($query) use($lm){
					$query->where("id","=",$lm->id);
				})
				->where("status","=","Retired")
				->count();
				
				$l_models_test_case[$lm->id] = Asset::whereHas("model",function($query) use($lm){
					$query->where("id","=",$lm->id);
				})
				->where("status","=","Test Case")
				->count();
			}

			
			$view->l_models_available = $l_models_available;
			$view->l_models_available_for_issuance = $l_models_available_for_issuance;
			$view->l_models_available_for_test_case = $l_models_available_for_test_case;
			$view->l_models_pwu_cebu = $l_models_pwu_cebu;
			$view->l_models_ewu = $l_models_ewu;
			$view->l_models_for_checking = $l_models_for_checking;
			$view->l_models_for_repair = $l_models_for_repair;
			$view->l_models_it_use = $l_models_it_use;
			$view->l_models_lost = $l_models_lost;
			$view->l_models_pwu = $l_models_pwu;
			$view->l_models_recruitment = $l_models_recruitment;
			$view->l_models_retired = $l_models_retired;
			$view->l_models_test_case = $l_models_test_case;
			
			return $view;
		}
	
		else{
			return Redirect::to("/");
		}
	}
	
	public function networkAssetsReports(){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin" || Session::get("user_type")=="User")){
				
			$view = View::make("Reports.network_assets_reports");
			$view->nav="system";
			$view->tab="network";
		
			$totalNetworkAssets = Asset::whereHas("classification",function($q){
				$q->where("type","=","Network");
			})->get()->count();
		
			//Summary
			
			$accessPoints = Asset::whereHas("classification",function($q){
				$q->where("name","=","Access Points");
			})->get()->count();
			
			$routers = Asset::whereHas("classification",function($q){
				$q->where("name","=","Routers");
			})->get()->count();
			
			$switches = Asset::whereHas("classification",function($q){
				$q->where("name","=","Switches");
			})->get()->count();
			
			$sfp = Asset::whereHas("classification",function($q){
				$q->where("name","=","SFP");
			})->get()->count();
			
			$ups = Asset::whereHas("classification",function($q){
				$q->where("name","=","UPS");
			})->get()->count();
			
			$voip = Asset::whereHas("classification",function($q){
				$q->where("name","=","VoIP Phones");
			})->get()->count();
			
			$servers = Asset::whereHas("classification",function($q){
				$q->where("name","=","Servers");
			})->get()->count();
			
			if($totalNetworkAssets>0){
				
				$accessPointsPercentage = $accessPoints>0 ? ($accessPoints/$totalNetworkAssets)*100 : "0.00";
				$routersPercentage = $routers>0 ? ($routers/$totalNetworkAssets)*100 : "0.00";
				$switchesPercentage = $switches>0 ? ($switches/$totalNetworkAssets)*100 : "0.00";
				$sfpPercentage = $sfp>0 ? ($sfp/$totalNetworkAssets)*100 : "0.00";
				$upsPercentage = $ups>0 ? ($ups/$totalNetworkAssets)*100 : "0.00";
				$voipPercentage = $voip>0 ? ($voip/$totalNetworkAssets)*100 : "0.00";
				$serversPercentage = $servers>0 ? ($servers/$totalNetworkAssets)*100 : "0.00";
			}
				
			else{
				$accessPointsPercentage = "0.00";
				$routersPercentage = "0.00";
				$switchesPercentage = "0.00";
				$sfpPercentage = "0.00";
				$upsPercentage = "0.00";
				$voipPercentage ="0.00";
				$serversPercentage ="0.00";
			}
				
			$view->totalNetworkAssets = $totalNetworkAssets;
		
			$view->accessPoints = $accessPoints;
			$view->routers = $routers;
			$view->switches = $switches;
			$view->sfp = $sfp;
			$view->ups = $ups;
			$view->voip = $voip;
			$view->servers = $servers;
			
			$view->accessPointsPercentage = $accessPointsPercentage;
			$view->routersPercentage = $routersPercentage;
			$view->switchesPercentage = $switchesPercentage;
			$view->sfpPercentage = $sfpPercentage;
			$view->upsPercentage = $upsPercentage;
			$view->voipPercentage = $voipPercentage;
			$view->serversPercentage = $serversPercentage;
				
			//Status
			
			//Access Points Status
			$a_available = Asset::where("status","=","Available")->whereHas("classification",function($q){ $q->where("name","=","Access Points"); } )->count();
			$a_for_repair = Asset::where("status","=","For Repair")->whereHas("classification",function($q){ $q->where("name","=","Access Points"); } )->count();
			$a_installed = Asset::where("status","=","Installed")->whereHas("classification",function($q){ $q->where("name","=","Access Points"); } )->count();
			$a_lost = Asset::where("status","=","Lost")->whereHas("classification",function($q){ $q->where("name","=","Access Points"); } )->count();
			$a_retired = Asset::where("status","=","Retired")->whereHas("classification",function($q){ $q->where("name","=","Access Points"); } )->count();
				
			$view->a_available = $a_available;
			$view->a_for_repair = $a_for_repair;
			$view->a_installed = $a_installed;
			$view->a_lost = $a_lost;
			$view->a_retired = $a_retired;
			
			//Routers Status
			$r_available = Asset::where("status","=","Available")->whereHas("classification",function($q){ $q->where("name","=","Routers"); } )->count();
			$r_for_repair = Asset::where("status","=","For Repair")->whereHas("classification",function($q){ $q->where("name","=","Routers"); } )->count();
			$r_installed = Asset::where("status","=","Installed")->whereHas("classification",function($q){ $q->where("name","=","Routers"); } )->count();
			$r_lost = Asset::where("status","=","Lost")->whereHas("classification",function($q){ $q->where("name","=","Routers"); } )->count();
			$r_retired = Asset::where("status","=","Retired")->whereHas("classification",function($q){ $q->where("name","=","Routers"); } )->count();
			
			$view->r_available = $r_available;
			$view->r_for_repair = $r_for_repair;
			$view->r_installed = $r_installed;
			$view->r_lost = $r_lost;
			$view->r_retired = $r_retired;
			
			//Switches Status
			$s_available = Asset::where("status","=","Available")->whereHas("classification",function($q){ $q->where("name","=","Switches"); } )->count();
			$s_for_repair = Asset::where("status","=","For Repair")->whereHas("classification",function($q){ $q->where("name","=","Switches"); } )->count();
			$s_installed = Asset::where("status","=","Installed")->whereHas("classification",function($q){ $q->where("name","=","Switches"); } )->count();
			$s_lost = Asset::where("status","=","Lost")->whereHas("classification",function($q){ $q->where("name","=","Switches"); } )->count();
			$s_retired = Asset::where("status","=","Retired")->whereHas("classification",function($q){ $q->where("name","=","Switches"); } )->count();
				
			$view->s_available = $s_available;
			$view->s_for_repair = $s_for_repair;
			$view->s_installed = $s_installed;
			$view->s_lost = $s_lost;
			$view->s_retired = $s_retired;
			
			//SFP Status
			$sfp_available = Asset::where("status","=","Available")->whereHas("classification",function($q){ $q->where("name","=","SFP"); } )->count();
			$sfp_for_repair = Asset::where("status","=","For Repair")->whereHas("classification",function($q){ $q->where("name","=","SFP"); } )->count();
			$sfp_installed = Asset::where("status","=","Installed")->whereHas("classification",function($q){ $q->where("name","=","SFP"); } )->count();
			$sfp_lost = Asset::where("status","=","Lost")->whereHas("classification",function($q){ $q->where("name","=","SFP"); } )->count();
			$sfp_retired = Asset::where("status","=","Retired")->whereHas("classification",function($q){ $q->where("name","=","SFP"); } )->count();
			
			$view->sfp_available = $sfp_available;
			$view->sfp_for_repair = $sfp_for_repair;
			$view->sfp_installed = $sfp_installed;
			$view->sfp_lost = $sfp_lost;
			$view->sfp_retired = $sfp_retired;
			
			//UPS Status
			$u_available = Asset::where("status","=","Available")->whereHas("classification",function($q){ $q->where("name","=","UPS"); } )->count();
			$u_for_repair = Asset::where("status","=","For Repair")->whereHas("classification",function($q){ $q->where("name","=","UPS"); } )->count();
			$u_installed = Asset::where("status","=","Installed")->whereHas("classification",function($q){ $q->where("name","=","UPS"); } )->count();
			$u_lost = Asset::where("status","=","Lost")->whereHas("classification",function($q){ $q->where("name","=","UPS"); } )->count();
			$u_retired = Asset::where("status","=","Retired")->whereHas("classification",function($q){ $q->where("name","=","UPS"); } )->count();
				
			$view->u_available = $u_available;
			$view->u_for_repair = $u_for_repair;
			$view->u_installed = $u_installed;
			$view->u_lost = $u_lost;
			$view->u_retired = $u_retired;
			
			//VoiP Phones Status
			$v_available = Asset::where("status","=","Available")->whereHas("classification",function($q){ $q->where("name","=","VoIP Phones"); } )->count();
			$v_for_repair = Asset::where("status","=","For Repair")->whereHas("classification",function($q){ $q->where("name","=","VoIP Phones"); } )->count();
			$v_installed = Asset::where("status","=","Installed")->whereHas("classification",function($q){ $q->where("name","=","VoIP Phones"); } )->count();
			$v_lost = Asset::where("status","=","Lost")->whereHas("classification",function($q){ $q->where("name","=","VoIP Phones"); } )->count();
			$v_retired = Asset::where("status","=","Retired")->whereHas("classification",function($q){ $q->where("name","=","VoIP Phones"); } )->count();
				
			$view->v_available = $v_available;
			$view->v_for_repair = $v_for_repair;
			$view->v_installed = $v_installed;
			$view->v_lost = $v_lost;
			$view->v_retired = $v_retired;
			
			//Servers Status
			$se_available = Asset::where("status","=","Available")->whereHas("classification",function($q){ $q->where("name","=","Servers"); } )->count();
			$se_for_repair = Asset::where("status","=","For Repair")->whereHas("classification",function($q){ $q->where("name","=","Servers"); } )->count();
			$se_installed = Asset::where("status","=","Installed")->whereHas("classification",function($q){ $q->where("name","=","Servers"); } )->count();
			$se_lost = Asset::where("status","=","Lost")->whereHas("classification",function($q){ $q->where("name","=","Servers"); } )->count();
			$se_retired = Asset::where("status","=","Retired")->whereHas("classification",function($q){ $q->where("name","=","Servers"); } )->count();
			
			$view->se_available = $se_available;
			$view->se_for_repair = $se_for_repair;
			$view->se_installed = $se_installed;
			$view->se_lost = $se_lost;
			$view->se_retired = $se_retired;
			
			return $view;
		}
		
		else{
			return Redirect::to("/");
		}
		
	}
	
	public function officeAssetsReports(){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin" || Session::get("user_type")=="User")){
			
			$view = View::make("Reports.office_assets_reports");
			$view->nav="system";
			$view->tab="office";
			
			
			$totalOfficeAssets = Asset::whereHas("classification",function($q){
				$q->where("type","=","Office");
			})->get()->count();
			
			//Summary
				
			$printers = Asset::whereHas("classification",function($q){
				$q->where("name","=","Printers");
			})->get()->count();
			
			$projectors = Asset::whereHas("classification",function($q){
				$q->where("name","=","Projectors");
			})->get()->count();
			
			$otherAssets = Asset::whereHas("classification",function($q){
				$q->where("name","=","Other Assets");
			})->get()->count();
			
			if($totalOfficeAssets>0){
				$printersPercentage = $printers>0 ? ($printers/$totalOfficeAssets)*100 : "0.00";
				$projectorsPercentage = $projectors>0 ? ($projectors/$totalOfficeAssets)*100 : "0.00";
				$otherAssetsPercentage = $otherAssets>0 ? ($otherAssets/$totalOfficeAssets)*100 : "0.00";
			}
			
			else{
				$printersPercentage = "0.00";
				$projectorsPercentage = "0.00";
				$otherAssetsPercentage = "0.00";
			}
			
			$view->totalOfficeAssets = $totalOfficeAssets;
			
			$view->printers = $printers;
			$view->projectors = $projectors;
			$view->otherAssets = $otherAssets;
			
			$view->printersPercentage = $printersPercentage;
			$view->projectorsPercentage = $projectorsPercentage;
			$view->otherAssetsPercentage = $otherAssetsPercentage;
			
			//Status
			
			//Printer Status
			$p_available = Asset::where("status","=","Available")->whereHas("classification",function($q){ $q->where("name","=","Printers"); } )->count();
			$p_for_repair = Asset::where("status","=","For Repair")->whereHas("classification",function($q){ $q->where("name","=","Printers"); } )->count();
			$p_installed = Asset::where("status","=","Installed")->whereHas("classification",function($q){ $q->where("name","=","Printers"); } )->count();
			$p_lost = Asset::where("status","=","Lost")->whereHas("classification",function($q){ $q->where("name","=","Printers"); } )->count();
			$p_retired = Asset::where("status","=","Retired")->whereHas("classification",function($q){ $q->where("name","=","Printers"); } )->count();
			
			$view->p_available = $p_available;
			$view->p_for_repair = $p_for_repair;
			$view->p_installed = $p_installed;
			$view->p_lost = $p_lost;
			$view->p_retired = $p_retired;
			
			//Projector Status
			$pro_available = Asset::where("status","=","Available")->whereHas("classification",function($q){ $q->where("name","=","Projectors"); } )->count();
			$pro_for_repair = Asset::where("status","=","For Repair")->whereHas("classification",function($q){ $q->where("name","=","Projectors"); } )->count();
			$pro_installed = Asset::where("status","=","Installed")->whereHas("classification",function($q){ $q->where("name","=","Projectors"); } )->count();
			$pro_lost = Asset::where("status","=","Lost")->whereHas("classification",function($q){ $q->where("name","=","Projectors"); } )->count();
			$pro_retired = Asset::where("status","=","Retired")->whereHas("classification",function($q){ $q->where("name","=","Projectors"); } )->count();
				
			$view->pro_available = $pro_available;
			$view->pro_for_repair = $pro_for_repair;
			$view->pro_installed = $pro_installed;
			$view->pro_lost = $pro_lost;
			$view->pro_retired = $pro_retired;
			
			//Other Assets Status
			$o_available = Asset::where("status","=","Available")->whereHas("classification",function($q){ $q->where("name","=","Other Assets"); } )->count();
			$o_for_repair = Asset::where("status","=","For Repair")->whereHas("classification",function($q){ $q->where("name","=","Other Assets"); } )->count();
			$o_installed = Asset::where("status","=","Installed")->whereHas("classification",function($q){ $q->where("name","=","Other Assets"); } )->count();
			$o_lost = Asset::where("status","=","Lost")->whereHas("classification",function($q){ $q->where("name","=","Other Assets"); } )->count();
			$o_retired = Asset::where("status","=","Retired")->whereHas("classification",function($q){ $q->where("name","=","Other Assets"); } )->count();
			
			$view->o_available = $o_available;
			$view->o_for_repair = $o_for_repair;
			$view->o_installed = $o_installed;
			$view->o_lost = $o_lost;
			$view->o_retired = $o_retired;
			
			return $view;
		}
		
		else{
			return Redirect::to("/");
		}
	}
	
	public function softwareAssetsReports(){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin" || Session::get("user_type")=="User")){

			$view = View::make("Reports.software_assets_reports");
			$view->nav="system";
			$view->tab="software";

			$totalSoftwareAssets = Software::all()->count();
			
			$softwareTypes = SoftwareType::orderBy("software_type")->get();
			
			$available = Software::where("status","=","Available")->count();
			$pwu = Software::where("status","=","PWU")->count();
			$retired = Software::where("status","=","Retired")->count();
			$test_case = Software::where("status","=","Test Case")->count();
			$lost = Software::where("status","=","Lost")->count();
			
			$view->softwareTypes = $softwareTypes;
			
			$view->available = $available;
			$view->pwu = $pwu;
			$view->retired = $retired;
			$view->test_case = $test_case;
			$view->lost = $lost;
			
			$view->totalSoftwareAssets = $totalSoftwareAssets;
			
			return $view;
			
			
		}
		
		else{
			return Redirect::to("/");
		}
		
	}
	
	public function employeesReports(){
		
		if(Session::has('username') && (Session::get('user_type')=="Root" || Session::get('user_type')=="Admin" || Session::get("user_type")=="User")){
			
			$view = View::make("Reports.employees_reports");
			$view->nav="system";
			$view->tab="employees";
			
			$view->totalEmployees = Employee::all()->count();
			
			$view->onBoard = Employee::where("status","=","On-Board")->count();
			$view->ojt = Employee::where("status","=","OJT")->count();
			$view->ojtGraduate = Employee::where("status","=","OJT Graduate")->count();
			$view->academy = Employee::where("status","=","Academy")->count();
			$view->contractual = Employee::where("status","=","Contractual")->count();
			$view->nsnGuest = Employee::where("status","=","NSN Guest")->count();
			$view->graduate = Employee::where("status","=","Graduate")->count();
			$view->resigned = Employee::where("status","=","Resigned")->count();
			$view->obsolete = Employee::where("status","=","Obsolete")->count();
			
			return $view;
			
		}
		
		else{
			return Redirect::to("/");
		}
	}
	
}