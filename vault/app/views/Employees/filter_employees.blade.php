<?php Session::put('page',Request::url()."?page=".Input::get('page')); ?>
<?php $keyword = empty($keyword) ? "" : $keyword ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Employees | Vault</title>
        @include('Includes.css_tb')
	    <script type="text/javascript">
	        function checkedAnId(){       
	            var checkedAny = false;           
	        <?php foreach($employees as $e){ ?>
	            if(document.getElementById("<?php echo $e->id?>").checked){
	                checkedAny=true;
	            }   
	        <?php } ?>          
	            if(!checkedAny){
	                return false;
	            }       
	            else{
	                var con = confirm("Are you sure you want to delete these employees?");
	                if(con==true){
	                    return true;
	                }
	                else{
	                    return false;
	                }
	            }
	        }
	        function toggle(source){
	            checkboxes = document.getElementsByName('employee_id[]');
	            for(var i=0, n=checkboxes.length;i<n;i++) {
	              checkboxes[i].checked = source.checked;
	            }
	        }
	    </script>
    </head>
    <body>
        <div class="container">
            <nav class="navbar" role="navigation">
                @include('Includes.Menu.admin_menu')
            </nav><!-- /navbar -->

            <div class="main_contain">
                <div class="space"></div>
                 <ul class="nav nav-tabs" role="tablist">
                    <li><a href="{{ URL() }}/employees"> All Employees</a></li>
                    <li @if(!empty($status) && $status=="on-board") class="active" @endif><a href="{{ URL() }}/employees/filter/on-board" role="tab">On-Board</a></li>
                    <li @if(!empty($status) && $status=="temporary") class="active" @endif><a href="{{ URL() }}/employees/filter/temporary" role="tab">Temporary Employees</a></li>
                    <li @if(!empty($status) && $status=="ojt") class="active" @endif><a href="{{ URL() }}/employees/filter/ojt" role="tab">OJT</a></li>
                    <li @if(!empty($status) && $status=="academy") class="active" @endif><a href="{{ URL() }}/employees/filter/academy" role="tab">Academy</a></li>
                    @if(Session::get("user_type")!="User")
                    <li style="float:right;margin-right:-2px"><a href="{{ URL() }}/employees/import">Import Data</a></li>
                    <li style="float:right"><a href="{{ URL() }}/employees/advancedsearch">Advanced Search</a></li>
                    @else
                    <li style="float:right;margin-right:-2px"><a href="{{ URL() }}/employees/advancedsearch">Advanced Search</a></li>
                    @endif
                </ul>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="tab-pane active">
                                <div class="col-md-4 fright checkbox-tab">
                                    {{ Form::open(array("url"=>"employees/searchfilter/$status","method"=>"post","class"=>"col-md-4 col-md-offset-4 navbar-form navbar-right fright","role"=>"search")) }}
                                        <div class="form-group" style="padding-right:-10px">
                                            <div class="input-group">
                                            	{{ Form::text("keyword",$keyword,array("class"=>"form-control fright","id"=>"navbarInput-01","placeholder"=>"Search Employees")) }}
                                                <span class="input-group-btn">
                                                    <button type="submit" class="btn"><span class="fui-search"></span></button>
                                                </span>            
                                            </div>
                                        </div>               
                                    {{ Form::close() }}
                                </div>
                                {{ Form::open(array("url"=>URL("employees/deleteemployees"),"method"=>"post","onsubmit"=>"return checkedAnId()")) }}
                                <div class="row">
	                                <div class="col-md-4 checkbox-tab">
	                                    @if(Session::get("user_type")!="User")
	                                    <button class="btn btn-sm delete-employ" type="button" onclick="parent.location='{{ URL() }}/employees/addemployee'"><i class="fa fa-plus-circle fa-lg"></i> Add Employee</button>
	                                    @endif
	                                    @if(Session::get('user_type')=="Root")
	                                    <button class="btn btn-sm delete-employ" type="submit"><i class="fa fa-minus-circle fa-lg"></i> Delete Employees</button>
	                                    @endif
	                                    <div class="tab_space"><p class="text-extrasmall"><b>Results : {{ $result }}</b></p></div>
	                                </div>
                                </div>
                                <div class="pagination center">
                                    @if($employees->links()!=null)
                                        {{ $employees->links() }}
                                    @endif
                                </div>
                                <table class="table table-condensed table-striped table-hover">
                                    <thead>
                                        <tr>
                                        @if(isset($intent) && $intent=="search")<!-- <input type="checkbox" onchange="toggle(this)" name="chk[]"/> -->
                                            @if(Session::get('user_type')=="Root")
                                            <th width="10%"><p><span class="col-md-1 top-checkbox">{{ Form::checkbox('chk[]','',null,array("onchange"=>"toggle(this)","id"=>"checkbox1")) }}</span> Action</p></th>
                                            @else
                                            <th width="10%"><p>Action</p></th>
                                            @endif
                                            <th width="10%"><p><a href="{{ URL().'/employees/searchfilter/'.$status.'/'.urlencode($keyword).'/employee_number/' }}{{ $order=='asc' ? 'desc':'asc'  }}">@if($sortby=="employee_number") @if($order=="asc") <i class="fa fa-toggle-up"> @else <i class="fa fa-toggle-down">@endif</i> @else <i class="fa fa-square-o"></i> @endif Employee #</a></p></th>
                                            <th width="10%"><p>Status</p></th>
                                            <th width="12%"><p><a href="{{ URL().'/employees/searchfilter/'.$status.'/'.urlencode($keyword).'/start_date/' }}{{ $order=='asc' ? 'desc':'asc'  }}">@if($sortby=="start_date") @if($order=="asc") <i class="fa fa-toggle-up"> @else <i class="fa fa-toggle-down">@endif</i> @else <i class="fa fa-square-o"></i> @endif Start Date</p></th>
                                            <th width="15%"><p><a href="{{ URL().'/employees/searchfilter/'.$status.'/'.urlencode($keyword).'/last_name/' }}{{ $order=='asc' ? 'desc':'asc'  }}">@if($sortby=="last_name") @if($order=="asc") <i class="fa fa-toggle-up"> @else <i class="fa fa-toggle-down">@endif</i> @else <i class="fa fa-square-o"></i> @endif Last Name</a></p></th>
                                            <th width="16%"><p><a href="{{ URL().'/employees/searchfilter/'.$status.'/'.urlencode($keyword).'/first_name/' }}{{ $order=='asc' ? 'desc':'asc'  }}">@if($sortby=="first_name") @if($order=="asc") <i class="fa fa-toggle-up"> @else <i class="fa fa-toggle-down">@endif</i> @else <i class="fa fa-square-o"></i> @endif First Name<a/></p></th>
                                            <th width="12%"><p>Business Line</p></th>
                                            <th width="15%"><p>Email</p></th>
                                        @else
                                            @if(Session::get('user_type')=="Root")
                                            <th width="10%"><p><span class="col-md-1 top-checkbox">{{ Form::checkbox('chk[]','',null,array("onchange"=>"toggle(this)","id"=>"checkbox1")) }}</span> Action</p></th>
                                            @else
                                            <th width="10%"><p>Action</p></th>
                                            @endif
                                            <th width="10%"><p><a href="{{ URL().'/employees/filter/'.$status.'/employee_number/' }}{{ $order=='asc' ? 'desc':'asc'  }}">@if($sortby=="employee_number") @if($order=="asc") <i class="fa fa-toggle-up"> @else <i class="fa fa-toggle-down">@endif</i> @else <i class="fa fa-square-o"></i> @endif Employee #</a></p></th>
                                            <th width="10%"><p>Status</p></th>
                                            <th width="12%"><p><a href="{{ URL().'/employees/filter/'.$status.'/start_date/' }}{{ $order=='asc' ? 'desc':'asc'  }}">@if($sortby=="start_date") @if($order=="asc") <i class="fa fa-toggle-up"> @else <i class="fa fa-toggle-down">@endif</i> @else <i class="fa fa-square-o"></i> @endif Start Date</p></th>
                                            <th width="15%"><p><a href="{{ URL().'/employees/filter/'.$status.'/last_name/' }}{{ $order=='asc' ? 'desc':'asc'  }}">@if($sortby=="last_name") @if($order=="asc") <i class="fa fa-toggle-up"> @else <i class="fa fa-toggle-down">@endif</i> @else <i class="fa fa-square-o"></i> @endif Last Name</a></p></th>
                                            <th width="16%"><p><a href="{{ URL().'/employees/filter/'.$status.'/first_name/' }}{{ $order=='asc' ? 'desc':'asc'  }}">@if($sortby=="first_name") @if($order=="asc") <i class="fa fa-toggle-up"> @else <i class="fa fa-toggle-down">@endif</i> @else <i class="fa fa-square-o"></i> @endif First Name<a/></p></th>
                                            <th width="12%"><p>Business Line</p></th>
                                            <th width="15%"><p>Email</p></th>
                                        @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($employees as $e){ ?>
                                        <tr>
                                            <td><div class="row">
                                                @if(Session::get('user_type')=="Root")
                                                <span class="col-md-1">{{ Form::checkbox('employee_id[]',$e->id,null,array("id"=>$e->id)) }}</span>
                                                @endif
                                                @if(Session::get("user_type")!="User")
                                                <span class="col-md-6 fa-stack fa-lg"><a href="{{ URL() }}/employees/updateemployee/{{ $e->employee_number }}" title="Edit / Change Employee Information"><i class="fa fa-edit fa-stack-1x fa-inverse"></i></a></span>
                                                @endif
                                                <span class="col-md-1 fa-stack fa-lg"><a href="#{{ $e->id }}" data-toggle="modal" data-target="#moreInfo{{ $e->employee_number }}" title="More Information"><i class="fa fa-newspaper-o fa-stack-1x fa-inverse"></i></a></span>
                                                </div>
                                                <!-- <span class="col-md-6 fa-stack fa-lg" onclick="confirmDelete({{ $e->id }})"><a title="Delete Employee"><i class="fa fa-minus-circle fa-stack-1x fa-inverse"></i></a></span>  -->
                                                <!-- Modal -->
                                                <div class="employee-modal modal fade" id="moreInfo{{ $e->employee_number }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" style="width:900px">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                              <h6 class="modal-title" id="myModalLabel"><selection>Employee #</selection> {{ $e->employee_number }} ({{ $e->status }}) </h6>
                                                            </div>
                                                            <div class="modal-body">
                                                                <table class="table">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td><p class="bold fright">Full Name :</p></td>
                                                                            <td> {{ $e->first_name ." ". $e->last_name }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><p class="bold fright">Nickname :</p></td>
                                                                            <td>{{ $e->nickname }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><p class="bold fright">Status :</p></td>
                                                                            <td>{{ $e->status }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><p class="bold fright">Start Date :</p></td>
                                                                            <td>{{ DateTime::createFromFormat("Y-m-d",$e->start_date)->format("F d, Y") }}</td>
                                                                        </tr>
                                                                        @if(!empty($e->end_date)) 
                                                                        <tr>
                                                                            <td><p class="bold fright">End Date :</p></td>
                                                                            <td>{{ DateTime::createFromFormat("Y-m-d",$e->end_date)->format("F d, Y") }}</td>
                                                                        </tr>
                                                                        @endif
                                                                        <tr>
                                                                            <td><p class="bold fright">NSN ID :</p></td>
                                                                            <td>{{ $e->nsn_id }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><p class="bold fright">Cellphone Number :</p></td>
                                                                            <td>{{ $e->cellphone_number }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><p class="bold fright">Manager :</p></td>
                                                                            <td>@if(!empty($e->manager->last_name)) {{ $e->manager->first_name ." ". $e->manager->last_name }} @else {{ "None" }} @endif</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><p class="bold fright">Business Line :</p></td>
                                                                            <td>@if(!empty($e->businessline->name)) {{ $e->businessline->name }} @else {{ "No Information" }} @endif</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><p class="bold fright">Unit :</p></td>
                                                                            <td>@if(!empty($e->unit->name)) {{ $e->unit->name }} @else {{ "No Information" }} @endif</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><p class="bold fright">Subunit :</p></td>
                                                                            <td>{{ $e->subunit }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><p class="bold fright">Email :</p></td>
                                                                            <td>{{ $e->email }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><p class="bold fright">Username :</p></td>
                                                                            <td>{{ $e->username }}</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="modal-footer">
                                                              <button type="button" class="btn btn-sm" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- End of Modal -->
                                            </td>
                                            <td>{{ $e->employee_number }}</td>
                                            <td>{{ $e->status }}</td>
                                            <td>{{ DateTime::createFromFormat("Y-m-d",$e->start_date)->format("F d, Y") }}</td>
                                            <td>{{ $e->last_name }}</td>
                                            <td>{{ $e->first_name }}</td>
                                            <td>@if(!empty($e->businessline->name)) {{ $e->businessline->name }} @endif</td>
                                            <td>{{ $e->email }}</td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                {{ Form::close() }}
                                <div class="pagination center">
                                    @if($employees->links()!=null)
                                        {{ $employees->links() }}
                                    @endif
                                </div>
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
    </body>
</html>