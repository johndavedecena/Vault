@if(isset($search))
<?php Session::put('page',Request::url()."?keyword=".urlencode(Input::get("keyword"))."&page=".Input::get('page')); ?>
@else
<?php Session::put('page',Request::url()."?page=".Input::get('page')); ?>
@endif
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Settings - Managers | Vault</title>
        @include('Includes.css_tb')
    </head>
    <body>
        <div class="container">
            <nav class="navbar" role="navigation">
                @include('Includes.Menu.admin_menu')
            </nav><!-- /navbar -->

            <div class="main_contain">
                <div class="space"></div>
                <ul class="nav nav-tabs" role="tablist">
                    @include('Includes.Tabs.Settings.settings_employees_tabs')
                </ul>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="tab-pane active">
                                <div class="row">
                                    <div class="col-md-4 checkbox-tab">
                                        <button class="btn btn-sm delete-employ" onclick="parent.location='{{ URL() }}/settings/employees/addmanager'"><i class="fa fa-plus-circle fa-lg"></i> Add Manager</button>
                                        <button class="btn btn-sm delete-employ text-meduim" type="button" onclick="parent.location='{{ URL() }}/settings/employees/transferemployees'"><i class="fa fa-exchange fa-lg"></i> Transfer Employees</button>
                                    </div>
                                    <div class="col-md-10 col-md-offset-1" align="center">
                                        <h4>Managers</h4>
                                    </div><br/>
                                    {{ Form::open(array("method"=>"get","url"=>URL()."/settings/employees/managers/search")) }}
	                                <div class="form-group col-md-10 col-md-offset-1">
	                                  	<table class="table table-condensed table-striped table-hover" style="margin:auto;width:400px">
		                                    <thead>
		                                        <tr>
		                                            <th width="80%"></th>
		                                            <th width="20%"></th>
		                                        </tr>
		                                    </thead>
		                                    <tbody>
		                                        <tr>
		                                            <td>
		                                                <div class="input-group input-group-sm" style="width:250px">
	                                                    {{ Form::text("keyword","",array('class'=>'form-control input-sm','placeholder'=>'Search Managers')); }}
		                                                </div>
		                                            </td>
		                                            <td>
			                                            <div align="left">
			                                            {{ Form::button('Search',array("class"=>"btn btn-sm btn-info","style"=>"width:130px;margin-right:10px;","type"=>"submit")) }}
		                                            	</div>
		                                            </td>
		                                        </tr>
					                       	</tbody>
				                        </table>
	                                </div>
	                                {{ Form::close() }}
                                </div>
                                <table class="table table-condensed table-striped table-hover" style="margin:auto;width:900px">
                                    <thead>
                                        <tr>
                                            <th width="20%"></th>
                                            @if(Session::get("user_type")=="Root")
                                            <th width="10%"><p>Delete</p></th>
                                            @endif
                                            <th width="10%"><p>ID</p></th>
                                            <th width="20%"><p>Name</p></th>
                                            <th width="20%"><p class="text-center">On-Board Employees</p></th>
                                            <th width="20%"><p class="text-center">All Employees</p></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($managers as $manager){ ?>
                                        <tr>
                                            <td></td>
                                            @if(Session::get("user_type")=="Root")
                                            <td><span class="fa-stack fa-lg"onclick="confirmDelete({{ $manager->id }})"><i class="fa fa-close fa-stack-1x fa-inverse"></i></span></td>
                                            @endif
                                            <td><a href="{{ URL() }}/settings/employees/updatemanager/{{ $manager->id }}">{{ str_pad($manager->id,4,0,STR_PAD_LEFT) }}</a></td>
                                            <td>@if(!empty($manager->first_name)) {{ $manager->last_name.", ".$manager->first_name }} @else {{ $manager->last_name }}  @endif</td>
                                            <td class="text-center">{{ count($manager->employees()->where("status","=","On-Board")->get()) }}</td>
                                            <td class="text-center">{{ count($manager->employees) }}</td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                                @if($managers->links()!=null)
                                <div class="pagination center">
                                    {{ $managers->appends(Input::except('token'))->links() }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container -->
        @include('Includes.footer')
	<!-- /.footer -->
    <!-- Load JS here for greater good =============================-->
    @include('Includes.Scripts.scripts')   
    <script type="text/javascript">
        function confirmDelete(id){

                var con = confirm("Are you sure you want to delete this manager?");

                if(con==true){
                        parent.location="{{ URL() }}/settings/employees/deletemanager/"+id;
                }
        }
    </script>
    </body>
</html>