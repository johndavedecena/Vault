<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Export Employees | Vault</title>
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
               @include('Includes.Tabs.Export.export_tabs')
            </ul>
            <div class="panel panel-default">
                <div class="panel-body">
                	@if(Session::get('info'))
                    <div class="alert alert-info alert-dismissible text-center" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <strong>Information. </strong> {{ htmlentities(Session::get('info')) }}
                    </div>
                    @endif    
                    <div class="tab-content">
                        <div class="tab-pane active">    
                            <div class="table_space"></div>
                            <div class="row">
                                <div class="col-md-4">
                                    <!-- advanced search -->
                                    {{ Form::open(array("url"=>URL("export/employees/begin"),"method"=>"get","class"=>"form-horizontal")) }}
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
                                        <div class="form-group">
                                            <label class="col-sm-5 control-label">Format</label>
                                            <div class="col-sm-7 input-group-sm">
                                            	<span class="col-md-1"><input type="checkbox" name="format" checked value="human"></span><p class="text-extrasmall">Human Readable Format</p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-5 col-sm-7">
                                                <button name="search" type="submit" class="btn btn-sm delete-employ">Search</button>
                                                <button name="export" type="submit" class="btn btn-sm delete-employ">Export</button>
                                            </div>
                                        </div>
                                    {{ Form::close() }}
                                    <!-- end of advanced search -->
                                </div>
                                <div class="col-md-8">
                                	<div class="col-md-4 tab_space"><p class="text-extrasmall"><b>Results : {{ number_format($result) }}</b></p></div>
                                        <div class='sub_space'></div>    
                                        <table class="table table-condensed table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th width="10%"><p>Action</p></th>
                                                    <th width="13%"><p>Last Name</p></th>
                                                    <th width="15%"><p>First Name</p></th>
                                                    <th width="12%"><p>Employee #</p></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach($employees as $e){ ?>
                                                <tr>
                                                    <td><div class="row">
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