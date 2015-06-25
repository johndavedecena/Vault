<?php Session::put('page',URL("employees/advancedsearch")."?page=".Input::get('page')); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Advanced Search Employees | Vault</title>
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
                <li><a href="{{ URL() }}/employees">All Employees</a></li>
                <li @if(!empty($status) && $status=="on-board") class="active" @endif><a href="{{ URL() }}/employees/filter/on-board" role="tab">On-Board</a></li>
                <li @if(!empty($status) && $status=="temporary") class="active" @endif><a href="{{ URL() }}/employees/filter/temporary" role="tab">Temporary Employees</a></li>
                <li @if(!empty($status) && $status=="ojt") class="active" @endif><a href="{{ URL() }}/employees/filter/ojt" role="tab">OJT</a></li>
                <li @if(!empty($status) && $status=="academy") class="active" @endif><a href="{{ URL() }}/employees/filter/academy" role="tab">Academy</a></li>
                @if(Session::get("user_type")!="User")
                <li style="float:right;margin-right:-2px"><a href="{{ URL() }}/employees/import">Import Data</a></li>
                <li class="active" style="float:right"><a href="{{ URL() }}/employees/advancedsearch">Advanced Search</a></li>
                @else
                <li class="active" style="float:right;margin-right:-2px"><a href="{{ URL() }}/employees/advancedsearch">Advanced Search</a></li>
                @endif
            </ul>
            <div class="panel panel-default">
                <div class="panel-body">    
                    <div class="tab-content">
                        <div class="tab-pane active">    
                            <div class="table_space"></div>
                            <div class="row">
                                <div class="col-md-4">
                                    <!-- advanced search -->
                                    {{ Form::open(array("url"=>URL("employees/advancedsearch/search"),"method"=>"get","class"=>"form-horizontal")) }}
                                        <div class="form-group">
                                            <label for="inputLast" class="col-sm-5 control-label">Last Name</label>
                                            <div class="col-sm-7 input-group-sm">
                                                    {{ Form::text('last_name','',array("class"=>"form-control","placeholder"=>"Last Name")) }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputFirst" class="col-sm-5 control-label">First Name</label>
                                            <div class="col-sm-7 input-group-sm">
                                                {{ Form::text('first_name','',array("class"=>"form-control","placeholder"=>"First Name")) }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputNumber" class="col-sm-5 control-label">Employee Number</label>
                                            <div class="col-sm-7 input-group-sm">
                                                {{ Form::text('employee_number','',array("class"=>"form-control","placeholder"=>"Employee Number")) }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputStatus" class="col-sm-5 control-label">Manager</label>
                                            <div class="col-sm-7 input-group-sm">
                                                 {{ Form::select("manager_id",$managers,"all",array('class'=>'form-control input-sm','placeholder'=>'Manager')); }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputDate" class="col-sm-5 control-label">Start Date</label>
                                            <div class="col-sm-7 input-group-sm">
                                                {{ Form::text("start_date",'',array("class"=>"form-control","id"=>"start-datepicker","placeholder"=>"Start Date")) }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputStatus" class="col-sm-5 control-label">Status</label>
                                            <div class="col-sm-7 input-group-sm">
                                                {{ Form::select("status", array(
                                                                                ""=>"--Select--",
                                                                                "Academy"=>"Academy",
                                                    							"Contractual"=>"Contractual",
                                                    							"Graduate"=>"Graduate",
                                                    							"NSN Guest"=>"NSN Guest",
                                                    							"Obsolete"=>"Obsolete",
                                                    							"OJT"=>"OJT",
                                                    							"OJT Graduate"=>"OJT Graduate",
                                                    							"On-Board"=>"On-Board",
                                                    							"Resigned"=>"Resigned"
                                                                                ),
                                                                          '',
                                                                          array("class"=>"form-control input-sm")
                                                                            );

                                                }}
                                            </div>
                                        </div>
                                        <!--  
                                        <div class="form-group">
                                            <label for="inputID" class="col-sm-5 control-label">NSN ID</label>
                                            <div class="col-sm-7 input-group-sm">
                                                {{ Form::text('nsn_id','',array("class"=>"form-control","placeholder"=>"NSN ID")) }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputUser" class="col-sm-5 control-label">Username</label>
                                            <div class="col-sm-7 input-group-sm">
                                                {{ Form::text('username','',array("class"=>"form-control","placeholder"=>"Username")) }}
                                            </div>
                                        </div>
                                        -->
                                        <div class="form-group">
                                            <div class="col-sm-offset-5 col-sm-7">
                                                <button type="submit" class="btn btn-sm delete-employ">Submit</button>
                                            </div>
                                        </div>
                                    {{ Form::close() }}
                                    <!-- end of advanced search -->
                                </div>
                                <div class="col-md-8">
                                    {{ Form::open(array("url"=>URL("employees/deleteemployees"),"method"=>"post","onsubmit"=>"return checkedAnId()")) }}
                                        @if(Session::get('user_type')=='Root')
                                        <div class="row">
                                            <div class="col-md-4 checkbox-tab">
                                                 <button class="btn btn-sm delete-employ" type="submit"><i class="fa fa-minus-circle fa-lg"></i> Delete Employees</button>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="col-md-4 tab_space"><p class="text-extrasmall"><b>Results : {{ number_format($result) }}</b></p></div>
                                        <div class='sub_space'></div>    
                                        <table class="table table-condensed table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    @if(Session::get("user_type")=="Root")
                                                    <th width="10%"><p><span class="col-md-1 top-checkbox">{{ Form::checkbox('chk[]','',null,array("onchange"=>"toggle(this)","id"=>"checkbox1")) }}</span> Action</p></th>
                                                    @else
                                                    <th width="10%"><p>Action</p></th>
                                                    @endif
                                                    <th width="13%"><p>Last Name</p></th>
                                                    <th width="15%"><p>First Name</p></th>
                                                    <th width="12%"><p>Employee #</p></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach($employees as $e){ ?>
                                                <tr>
                                                    <td><div class="row">
                                                        @if(Session::get('user_type')=="Root")
                                                        <span class="col-md-1">{{ Form::checkbox('employee_id[]',$e->id,null,array("id"=>$e->id)) }}</span>
                                                        @endif
                                                        @if(Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")
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
                                                                                    <td>@if(!empty($e->businessline->name)) {{ $e->businessline->name }} @endif</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><p class="bold fright">Unit :</p></td>
                                                                                    <td>@if(!empty($e->unit->name)) {{ $e->unit->name }} @endif</td>
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
                                                    <td>{{ $e->last_name }}</td>
                                                    <td>{{ $e->first_name }}</td>
                                                    <td>{{ $e->employee_number }}</td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    {{ Form::close() }}
                                    <div class="col-md-8 col-md-offset-2">
                                        <div class="pagination">
                                        @if($employees->links()!=null)
                                            {{ $employees->appends(Input::except('token'))->links() }}
                                        @endif
                                        </div>
                                    </div>
                                </div>
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