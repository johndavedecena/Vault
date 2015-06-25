<div class="header_footer">
	<div class="navbar-header">
		<a class="navbar-brand" href="{{ URL() }}"><img alt="logo"
			src="{{ URL() }}/images/nwl/nwllogo.png" /></a>
	</div>
	@if(Session::get('user_class')=="Root")
		<div class="top-navigation">
			<ul class="nav navbar-nav">
				<li><a
					class="main_nav underline <?php if(isset($nav) && $nav=="accounts") echo "active" ?>"
					href="{{ URL('accounts/index') }}">Accounts</a></li>	
				<li><a
					class="main_nav underline <?php if(isset($nav) && $nav=="employees") echo "active" ?>"
					href="{{ URL('employees') }}">Employees</a></li>
				<li class="dropdown main_nav"><a href="#"
					class="dropdown-toggle underline <?php if(isset($nav) && $nav=="assets") echo "active" ?>"
					data-toggle="dropdown">IT Assets <i class="fa fa-chevron-down"></i></a>
					<span class="dropdown-arrow"></span>
					<ul class="dropdown-menu">
						<li class="dropdown dropdown-submenu"><a href="#"
							class="dropdown-toggle" data-toggle="dropdown">Client</a>
							<ul class="dropdown-menu">
								<li><a href="{{ URL() }}/assets/client/view/laptops">Laptops</a></li>
								<li><a href="{{ URL() }}/assets/client/view/monitors">Monitors</a></li>
								<li><a href="{{ URL() }}/assets/client/view/dockingstations">Docking
										Stations</a></li>
								<li class="divider"></li>
								<li><a href="{{ URL() }}/assets/client/advancedsearch">Advanced
										Search</a></li>
								<li><a href="{{ URL() }}/assets/client/import">Import</a></li>
							</ul></li>
						<li class="dropdown dropdown-submenu"><a href="#"
							class="dropdown-toggle" data-toggle="dropdown">Network</a>
							<ul class="dropdown-menu">
								<li><a href="{{ URL() }}/assets/network/view/accesspoints">Access
										Points</a></li>
								<li><a href="{{ URL() }}/assets/network/view/routers">Routers</a></li>
								<li><a href="{{ URL() }}/assets/network/view/switches">Switches</a></li>
								<li><a href="{{ URL() }}/assets/network/view/sfp">SFP</a></li>
								<li><a href="{{ URL() }}/assets/network/view/ups">UPS</a></li>
								<li><a href="{{ URL() }}/assets/network/view/voip">VoIP Phones</a></li>
								<li><a href="{{ URL() }}/assets/network/view/servers">Servers</a></li>
								<li class="divider"></li>
								<li><a href="{{ URL() }}/assets/network/advancedsearch">Advanced
										Search</a></li>
								<li><a href="{{ URL() }}/assets/network/import">Import</a></li>
							</ul></li>
						<li class="dropdown dropdown-submenu"><a href="#"
							class="dropdown-toggle" data-toggle="dropdown">Office Equipment</a>
							<ul class="dropdown-menu">
								<li><a href="{{ URL() }}/assets/office/view/printers">Printers</a></li>
								<li><a href="{{ URL() }}/assets/office/view/projectors">Projectors</a></li>
								<li><a href="{{ URL() }}/assets/office/view/otherassets">Other
										Assets</a></li>
								<li class="divider"></li>
								<li><a href="{{ URL() }}/assets/office/advancedsearch">Advanced
										Search</a></li>
								<li><a href="{{ URL() }}/assets/office/import">Import</a></li>
							</ul></li>
						<li><a href="{{ URL() }}/assets/software/view">Software</a></li>
						<li><a href="{{ URL() }}/assets/IP/view">IP</a></li>
					</ul></li>
				<li class="dropdown main_nav"><a href="#"
					class="dropdown-toggle underline <?php if(isset($nav) && $nav=="assets") echo "active" ?>"
					data-toggle="dropdown">LAB Assets <i class="fa fa-chevron-down"></i></a>
					<span class="dropdown-arrow"></span>
					<ul class="dropdown-menu">
						<li><a href="{{ URL() }}/assets/geninfo">General Info</a></li>
						<li><a href="{{ URL() }}/assets/usagestat/view">Usage Status</a></li>
						<li><a href="{{ URL() }}/assets/IP/view">Reservation</a></li>
						<li><a href="{{ URL() }}/assets/reports/view">Reports</a></li>
					</ul>
				</li>
				<li class="dropdown main_nav"><a href="#"
					class="dropdown-toggle underline <?php if(isset($nav) && $nav=="system") echo "active" ?>"
					data-toggle="dropdown">System<i class="fa fa-chevron-down"></i></a>
					<span class="dropdown-arrow"></span>
					<ul class="dropdown-menu">
						<li class="dropdown dropdown-submenu"><a href="#"
							class="dropdown-toggle" data-toggle="dropdown">Logs</a>
							<ul class="dropdown-menu">
								<li><a href="{{ URL() }}/logs/system">System Logs</a></li>
								<li><a href="{{ URL() }}/logs/assets">Assets Logs</a></li>
								<li><a href="{{ URL() }}/logs/softwareassets">Software Assets
										Logs</a></li>
								<li><a href="{{ URL() }}/logs/ipassets">IP Assets
										Logs</a></li>
							</ul></li>
						<li class="dropdown dropdown-submenu"><a href="#"
							class="dropdown-toggle" data-toggle="dropdown">Reports</a>
							<ul class="dropdown-menu">
								<li><a href="{{ URL() }}/reports">All Assets</a></li>
								<li><a href="{{ URL() }}/reports/clientassets">Client Assets</a></li>
								<li><a href="{{ URL() }}/reports/networkassets">Network Assets</a></li>
								<li><a href="{{ URL() }}/reports/officeassets">Office Assets</a></li>
								<li><a href="{{ URL() }}/reports/softwareassets">Software Assets</a></li>
								<li><a href="{{ URL() }}/reports/employees">Employees</a></li>
							</ul></li>
					</ul></li>
			</ul>
			<div class="dropdown navbar-right">
				<a class="dropdown-toggle" href="#" data-toggle="dropdown"><img
					class="circle" src="{{ URL() }}/images/users/default.gif" /></a> <span
					class="dropdown-arrow"></span>
				<ul class="dropdown-menu">
					<li><a
						href="{{ URL() }}/accounts/mysettings/{{ Session::get('user_id') }}">Settings</a></li>
					@if(Session::get('user_type')=="Root") @if(Session::has("secure"))
					<li><a href="{{ URL() }}/accounts/closesecuresession">Close Secure
							Session</a></li> @else
					<li><a href="{{ URL() }}/accounts/securesession">Start Secure
							Session</a></li> @endif
					<li><a href="{{ URL() }}/accounts/passwordmanager">Password Manager</a></li>
					@endif
					<li><a href="{{ URL() }}/logout">Logout</a></li>
				</ul>
			</div>
			<p class="navbar-text navbar-right">{{ Session::get('first_name').'
				'.Session::get('last_name') }}</p>
			<p class="navbar-text navbar-right">Signed in as</p>
		</div>
	@elseif(Session::get('user_class')=="IT")
		<div class="top-navigation">
			<ul class="nav navbar-nav">
				@if(Session::get('user_type')=="Admin")
				<li><a
					class="main_nav underline <?php if(isset($nav) && $nav=="accounts") echo "active" ?>"
					href="{{ URL('accounts/index') }}">Accounts</a></li> @endif
				@if(Session::get('user_type')=="Admin" || Session::get("user_type")=="User")
				<li><a
					class="main_nav underline <?php if(isset($nav) && $nav=="employees") echo "active" ?>"
					href="{{ URL('employees') }}">Employees</a></li>
				<li class="dropdown main_nav"><a href="#"
					class="dropdown-toggle underline <?php if(isset($nav) && $nav=="assets") echo "active" ?>"
					data-toggle="dropdown">IT Assets <i class="fa fa-chevron-down"></i></a>
					<span class="dropdown-arrow"></span>
					<ul class="dropdown-menu">
						<li class="dropdown dropdown-submenu"><a href="#"
							class="dropdown-toggle" data-toggle="dropdown">Client</a>
							<ul class="dropdown-menu">
								<li><a href="{{ URL() }}/assets/client/view/laptops">Laptops</a></li>
								<li><a href="{{ URL() }}/assets/client/view/monitors">Monitors</a></li>
								<li><a href="{{ URL() }}/assets/client/view/dockingstations">Docking
										Stations</a></li>
								<li class="divider"></li>
								<li><a href="{{ URL() }}/assets/client/advancedsearch">Advanced
										Search</a></li>
								<li><a href="{{ URL() }}/assets/client/import">Import</a></li>
							</ul></li>
						<li class="dropdown dropdown-submenu"><a href="#"
							class="dropdown-toggle" data-toggle="dropdown">Network</a>
							<ul class="dropdown-menu">
								<li><a href="{{ URL() }}/assets/network/view/accesspoints">Access
										Points</a></li>
								<li><a href="{{ URL() }}/assets/network/view/routers">Routers</a></li>
								<li><a href="{{ URL() }}/assets/network/view/switches">Switches</a></li>
								<li><a href="{{ URL() }}/assets/network/view/sfp">SFP</a></li>
								<li><a href="{{ URL() }}/assets/network/view/ups">UPS</a></li>
								<li><a href="{{ URL() }}/assets/network/view/voip">VoIP Phones</a></li>
								<li><a href="{{ URL() }}/assets/network/view/servers">Servers</a></li>
								<li class="divider"></li>
								<li><a href="{{ URL() }}/assets/network/advancedsearch">Advanced
										Search</a></li>
								<li><a href="{{ URL() }}/assets/network/import">Import</a></li>
							</ul></li>
						<li class="dropdown dropdown-submenu"><a href="#"
							class="dropdown-toggle" data-toggle="dropdown">Office Equipment</a>
							<ul class="dropdown-menu">
								<li><a href="{{ URL() }}/assets/office/view/printers">Printers</a></li>
								<li><a href="{{ URL() }}/assets/office/view/projectors">Projectors</a></li>
								<li><a href="{{ URL() }}/assets/office/view/otherassets">Other
										Assets</a></li>
								<li class="divider"></li>
								<li><a href="{{ URL() }}/assets/office/advancedsearch">Advanced
										Search</a></li>
								<li><a href="{{ URL() }}/assets/office/import">Import</a></li>
							</ul></li>
						<li><a href="{{ URL() }}/assets/software/view">Software</a></li>
						<li><a href="{{ URL() }}/assets/IP/view">IP</a></li>
					</ul>
				</li>
				<li class="dropdown main_nav"><a href="#"
					class="dropdown-toggle underline <?php if(isset($nav) && $nav=="system") echo "active" ?>"
					data-toggle="dropdown">System<i class="fa fa-chevron-down"></i></a>
					<span class="dropdown-arrow"></span>
					<ul class="dropdown-menu">
						<li class="dropdown dropdown-submenu"><a href="#"
							class="dropdown-toggle" data-toggle="dropdown">Logs</a>
							<ul class="dropdown-menu">
								<li><a href="{{ URL() }}/logs/system">System Logs</a></li>
								<li><a href="{{ URL() }}/logs/assets">Assets Logs</a></li>
								<li><a href="{{ URL() }}/logs/softwareassets">Software Assets
										Logs</a></li>
								<li><a href="{{ URL() }}/logs/ipassets">IP Assets
										Logs</a></li>
							</ul></li>
						<li class="dropdown dropdown-submenu"><a href="#"
							class="dropdown-toggle" data-toggle="dropdown">Reports</a>
							<ul class="dropdown-menu">
								<li><a href="{{ URL() }}/reports">All Assets</a></li>
								<li><a href="{{ URL() }}/reports/clientassets">Client Assets</a></li>
								<li><a href="{{ URL() }}/reports/networkassets">Network Assets</a></li>
								<li><a href="{{ URL() }}/reports/officeassets">Office Assets</a></li>
								<li><a href="{{ URL() }}/reports/softwareassets">Software Assets</a></li>
								<li><a href="{{ URL() }}/reports/employees">Employees</a></li>
							</ul></li>
					</ul></li> @endif
			</ul>
				<div class="dropdown navbar-right">
				<a class="dropdown-toggle" href="#" data-toggle="dropdown"><img
					class="circle" src="{{ URL() }}/images/users/default.gif" /></a> <span
					class="dropdown-arrow"></span>
				<ul class="dropdown-menu">
					<li><a
						href="{{ URL() }}/accounts/mysettings/{{ Session::get('user_id') }}">Settings</a></li>
					@if(Session::get('user_type')=="Root") @if(Session::has("secure"))
					<li><a href="{{ URL() }}/accounts/closesecuresession">Close Secure
							Session</a></li> @else
					<li><a href="{{ URL() }}/accounts/securesession">Start Secure
							Session</a></li> @endif
					<li><a href="{{ URL() }}/accounts/passwordmanager">Password Manager</a></li>
					@endif
					<li><a href="{{ URL() }}/logout">Logout</a></li>
				</ul>
			</div>
			<p class="navbar-text navbar-right">{{ Session::get('first_name').'
				'.Session::get('last_name') }}</p>
			<p class="navbar-text navbar-right">Signed in as</p>
		</div>
	@elseif(Session::get('user_class')=="LAB")
		<div class="top-navigation">
			<ul class="nav navbar-nav">
				@if(Session::get('user_type')=="Admin")
				<li><a
					class="main_nav underline <?php if(isset($nav) && $nav=="accounts") echo "active" ?>"
					href="{{ URL('accounts/index') }}">Accounts</a></li>
				@endif
				@if(Session::get('user_type')=="Admin" || Session::get('user_type')=="User")
				<li class="dropdown main_nav"><a href="#"
					class="dropdown-toggle underline <?php if(isset($nav) && $nav=="assets") echo "active" ?>"
					data-toggle="dropdown">LAB Assets <i class="fa fa-chevron-down"></i></a>
					<span class="dropdown-arrow"></span>
					<ul class="dropdown-menu">
						<li><a href="{{ URL() }}/assets/geninfo">General Info</a></li>
						<li><a href="{{ URL() }}/assets/software/view">Usage Status</a></li>
						<li><a href="{{ URL() }}/assets/IP/view">Reservation</a></li>
						<li><a href="{{ URL() }}/assets/IP/view">Reports</a></li>
					</ul>
				</li>
				<li class="dropdown main_nav"><a href="#"
					class="dropdown-toggle underline <?php if(isset($nav) && $nav=="system") echo "active" ?>"
					data-toggle="dropdown">System<i class="fa fa-chevron-down"></i></a>
					<span class="dropdown-arrow"></span>
					<ul class="dropdown-menu">
						<li class="dropdown dropdown-submenu"><a href="#"
							class="dropdown-toggle" data-toggle="dropdown">Logs</a>
							<ul class="dropdown-menu">
								<li><a href="{{ URL() }}/logs/system">System Logs</a></li>
								<li><a href="{{ URL() }}/logs/assets">Assets Logs</a></li>
								<li><a href="{{ URL() }}/logs/softwareassets">Software Assets
										Logs</a></li>
								<li><a href="{{ URL() }}/logs/ipassets">IP Assets
										Logs</a></li>
							</ul></li>
						<li class="dropdown dropdown-submenu"><a href="#"
							class="dropdown-toggle" data-toggle="dropdown">Reports</a>
							<ul class="dropdown-menu">
								<li><a href="{{ URL() }}/reports">All Assets</a></li>
								<li><a href="{{ URL() }}/reports/clientassets">Client Assets</a></li>
								<li><a href="{{ URL() }}/reports/networkassets">Network Assets</a></li>
								<li><a href="{{ URL() }}/reports/officeassets">Office Assets</a></li>
								<li><a href="{{ URL() }}/reports/softwareassets">Software Assets</a></li>
								<li><a href="{{ URL() }}/reports/employees">Employees</a></li>
							</ul></li>@endif
					</ul></li> 
			</ul>
			<div class="dropdown navbar-right">
				<a class="dropdown-toggle" href="#" data-toggle="dropdown"><img
					class="circle" src="{{ URL() }}/images/users/default.gif" /></a> <span
					class="dropdown-arrow"></span>
				<ul class="dropdown-menu">
					<li><a
						href="{{ URL() }}/accounts/mysettings/{{ Session::get('user_id') }}">Settings</a></li>
					@if(Session::get('user_type')=="Root") @if(Session::has("secure"))
					<li><a href="{{ URL() }}/accounts/closesecuresession">Close Secure
							Session</a></li> @else
					<li><a href="{{ URL() }}/accounts/securesession">Start Secure
							Session</a></li> @endif
					<li><a href="{{ URL() }}/accounts/passwordmanager">Password Manager</a></li>
					@endif
					<li><a href="{{ URL() }}/logout">Logout</a></li>
				</ul>
			</div>
			<p class="navbar-text navbar-right">{{ Session::get('first_name').'
				'.Session::get('last_name') }}</p>
			<p class="navbar-text navbar-right">Signed in as</p>
		</div>
	@elseif(Session::get('user_class')=="F&A")
		<div class="top-navigation">
			<ul class="nav navbar-nav">
				@if(Session::get('user_type')=="Root")
				<li><a
					class="main_nav underline <?php if(isset($nav) && $nav=="accounts") echo "active" ?>"
					href="{{ URL('accounts/index') }}">Accounts</a></li> @endif
				@if(Session::get("user_type")!="User")
				<li><a
					class="main_nav underline <?php if(isset($nav) && $nav=="employees") echo "active" ?>"
					href="{{ URL('employees') }}">Employees</a></li>
				<li class="dropdown main_nav"><a href="#"
					class="dropdown-toggle underline <?php if(isset($nav) && $nav=="assets") echo "active" ?>"
					data-toggle="dropdown">IT Assets <i class="fa fa-chevron-down"></i></a>
					<span class="dropdown-arrow"></span>
					<ul class="dropdown-menu">
						<li class="dropdown dropdown-submenu"><a href="#"
							class="dropdown-toggle" data-toggle="dropdown">Client</a>
							<ul class="dropdown-menu">
								<li><a href="{{ URL() }}/assets/client/view/laptops">Laptops</a></li>
								<li><a href="{{ URL() }}/assets/client/view/monitors">Monitors</a></li>
								<li><a href="{{ URL() }}/assets/client/view/dockingstations">Docking
										Stations</a></li>
								<li class="divider"></li>
								<li><a href="{{ URL() }}/assets/client/advancedsearch">Advanced
										Search</a></li>
								<li><a href="{{ URL() }}/assets/client/import">Import</a></li>
							</ul></li>
						<li class="dropdown dropdown-submenu"><a href="#"
							class="dropdown-toggle" data-toggle="dropdown">Network</a>
							<ul class="dropdown-menu">
								<li><a href="{{ URL() }}/assets/network/view/accesspoints">Access
										Points</a></li>
								<li><a href="{{ URL() }}/assets/network/view/routers">Routers</a></li>
								<li><a href="{{ URL() }}/assets/network/view/switches">Switches</a></li>
								<li><a href="{{ URL() }}/assets/network/view/sfp">SFP</a></li>
								<li><a href="{{ URL() }}/assets/network/view/ups">UPS</a></li>
								<li><a href="{{ URL() }}/assets/network/view/voip">VoIP Phones</a></li>
								<li><a href="{{ URL() }}/assets/network/view/servers">Servers</a></li>
								<li class="divider"></li>
								<li><a href="{{ URL() }}/assets/network/advancedsearch">Advanced
										Search</a></li>
								<li><a href="{{ URL() }}/assets/network/import">Import</a></li>
							</ul></li>
						<li class="dropdown dropdown-submenu"><a href="#"
							class="dropdown-toggle" data-toggle="dropdown">Office Equipment</a>
							<ul class="dropdown-menu">
								<li><a href="{{ URL() }}/assets/office/view/printers">Printers</a></li>
								<li><a href="{{ URL() }}/assets/office/view/projectors">Projectors</a></li>
								<li><a href="{{ URL() }}/assets/office/view/otherassets">Other
										Assets</a></li>
								<li class="divider"></li>
								<li><a href="{{ URL() }}/assets/office/advancedsearch">Advanced
										Search</a></li>
								<li><a href="{{ URL() }}/assets/office/import">Import</a></li>
							</ul></li>
						<li><a href="{{ URL() }}/assets/software/view">Software</a></li>
						<li><a href="{{ URL() }}/assets/IP/view">IP</a></li>
					</ul></li>
				<li class="dropdown main_nav"><a href="#"
					class="dropdown-toggle underline <?php if(isset($nav) && $nav=="system") echo "active" ?>"
					data-toggle="dropdown">LAB Assets<i class="fa fa-chevron-down"></i></a>
					<span class="dropdown-arrow"></span>
					<ul class="dropdown-menu">
						<li class="dropdown dropdown-submenu"><a href="#"
							class="dropdown-toggle" data-toggle="dropdown">Assets</a>
							<ul class="dropdown-menu">
								<li><a href="{{ URL() }}/settings/assets/assetmodels">Asset
										Models</a></li>
								<li><a href="{{ URL() }}/settings/assets/softwaretypes">Software
										Types</a></li>
							</ul></li>
						<li class="dropdown dropdown-submenu"><a href="#"
							class="dropdown-toggle" data-toggle="dropdown">Employees</a>
							<ul class="dropdown-menu">
								<li><a href="{{ URL() }}/settings/employees/managers">Managers</a></li>
								<li><a href="{{ URL() }}/settings/employees/businesslines">Business
										Lines</a></li>
								<li><a href="{{ URL() }}/settings/employees/units">Units</a></li>
								<li><a href="{{ URL() }}/settings/employees/updatephonenumbers">Update
										Phone Numbers</a></li>
							</ul></li>
						<li class="dropdown dropdown-submenu"><a href="#"
							class="dropdown-toggle" data-toggle="dropdown">Export Data</a>
							<ul class="dropdown-menu">
								<li><a href="{{ URL() }}/export/client">Client Assets</a></li>
								<li><a href="{{ URL() }}/export/network">Network Assets</a></li>
								<li><a href="{{ URL() }}/export/office">Office Assets</a></li>
								<li><a href="{{ URL() }}/export/software">Software Assets</a></li>
								<li><a href="{{ URL() }}/export/employees">Employees</a></li>
							</ul></li>
						<li class="dropdown dropdown-submenu"><a href="#"
							class="dropdown-toggle" data-toggle="dropdown">Logs</a>
							<ul class="dropdown-menu">
								<li><a href="{{ URL() }}/logs/system">System Logs</a></li>
								<li><a href="{{ URL() }}/logs/assets">Assets Logs</a></li>
								<li><a href="{{ URL() }}/logs/softwareassets">Software Assets
										Logs</a></li>
								<li><a href="{{ URL() }}/logs/ipassets">IP Assets Logs</a></li>
							</ul></li>
						<li class="dropdown dropdown-submenu"><a href="#"
							class="dropdown-toggle" data-toggle="dropdown">Reports</a>
							<ul class="dropdown-menu">
								<li><a href="{{ URL() }}/reports">All Assets</a></li>
								<li><a href="{{ URL() }}/reports/clientassets">Client Assets</a></li>
								<li><a href="{{ URL() }}/reports/networkassets">Network Assets</a></li>
								<li><a href="{{ URL() }}/reports/officeassets">Office Assets</a></li>
								<li><a href="{{ URL() }}/reports/softwareassets">Software Assets</a></li>
								<li><a href="{{ URL() }}/reports/employees">Employees</a></li>
							</ul></li>
					</ul>
				</li>
				<li class="dropdown main_nav"><a href="#"
					class="dropdown-toggle underline <?php if(isset($nav) && $nav=="system") echo "active" ?>"
					data-toggle="dropdown">System<i class="fa fa-chevron-down"></i></a>
					<span class="dropdown-arrow"></span>
					<ul class="dropdown-menu">
						<li class="dropdown dropdown-submenu"><a href="#"
							class="dropdown-toggle" data-toggle="dropdown">Logs</a>
							<ul class="dropdown-menu">
								<li><a href="{{ URL() }}/logs/system">System Logs</a></li>
								<li><a href="{{ URL() }}/logs/assets">Assets Logs</a></li>
								<li><a href="{{ URL() }}/logs/softwareassets">Software Assets
										Logs</a></li>
								<li><a href="{{ URL() }}/logs/ipassets">IP Assets
										Logs</a></li>
							</ul></li>
						<li class="dropdown dropdown-submenu"><a href="#"
							class="dropdown-toggle" data-toggle="dropdown">Reports</a>
							<ul class="dropdown-menu">
								<li><a href="{{ URL() }}/reports">All Assets</a></li>
								<li><a href="{{ URL() }}/reports/clientassets">Client Assets</a></li>
								<li><a href="{{ URL() }}/reports/networkassets">Network Assets</a></li>
								<li><a href="{{ URL() }}/reports/officeassets">Office Assets</a></li>
								<li><a href="{{ URL() }}/reports/softwareassets">Software Assets</a></li>
								<li><a href="{{ URL() }}/reports/employees">Employees</a></li>
							</ul></li>
					</ul>
				</li> @endif
			</ul>
			<div class="dropdown navbar-right">
				<a class="dropdown-toggle" href="#" data-toggle="dropdown"><img
					class="circle" src="{{ URL() }}/images/users/default.gif" /></a> <span
					class="dropdown-arrow"></span>
				<ul class="dropdown-menu">
					<li><a
						href="{{ URL() }}/accounts/mysettings/{{ Session::get('user_id') }}">Settings</a></li>
					@if(Session::get('user_type')=="Root") @if(Session::has("secure"))
					<li><a href="{{ URL() }}/accounts/closesecuresession">Close Secure
							Session</a></li> @else
					<li><a href="{{ URL() }}/accounts/securesession">Start Secure
							Session</a></li> @endif
					<li><a href="{{ URL() }}/accounts/passwordmanager">Password Manager</a></li>
					@endif
					<li><a href="{{ URL() }}/logout">Logout</a></li>
				</ul>
			</div>
			<p class="navbar-text navbar-right">{{ Session::get('first_name').'
				'.Session::get('last_name') }}</p>
			<p class="navbar-text navbar-right">Signed in as</p>
		</div>
	@endif
</div>