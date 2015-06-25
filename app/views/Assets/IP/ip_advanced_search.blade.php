<?php Session::put('page',URL("assets/IP/advancedsearch")."?page=".Input::get('page')); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>IP Advanced Search | Vault</title>
    @include('Includes.css_tb')
    @if(Session::get("user_type")=="Root")
    <script type="text/javascript">
        function checkedAnId(){       
            var checkedAny = false;           
        <?php foreach($ip as $s){ ?>
            if(document.getElementById("<?php echo $s->id?>").checked){
                checkedAny=true;
            }   
        <?php } ?>          
            if(!checkedAny){
                return false;
            }       
            else{
                var con = confirm("Are you sure you want to delete these assets?");
                if(con==true){
                    return true;
                }
                else{
                    return false;
                }
            }
        }

        function toggle(source){
            checkboxes = document.getElementsByName('ip_id[]');
            for(var i=0, n=checkboxes.length;i<n;i++) {
              checkboxes[i].checked = source.checked;
            }
        }
    </script>
    @endif
</head>
<body>
    <div class="container">
        <nav class="navbar" role="navigation">
            @include('Includes.Menu.admin_menu')
        </nav><!-- /navbar -->

        <div class="main_contain">
            <div class="space"></div>
            <ul class="nav nav-tabs" role="tablist">
                @include('Includes.Tabs.Assets.ip_asset_tabs')
            </ul>
            <div class="panel panel-default">
                <div class="panel-body">    
                    <div class="tab-content">
                        <div class="tab-pane active">    
                            <div class="table_space"></div>
                            <div class="row">
                                <div class="col-md-4">
                                    <!-- advanced search -->
                                    {{ Form::open(array("url"=>URL("assets/IP/advancedsearch/search"),"method"=>"get","class"=>"form-horizontal")) }}
                                        <div class="form-group">
                                            <label class="col-sm-5 control-label">IP Address</label>
                                            <div class="col-sm-7 input-group-sm">
                                                {{ Form::text("ip",'',array("class"=>"form-control","placeholder"=>"IP Address")) }}
                                            </div>	
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-5 control-label">IP Type</label>
                                            <div class="col-sm-7 input-group-sm">
                                                {{ Form::select("ip_type",$IPTypes,'',array("class"=>"form-control input-sm")) }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-5 control-label">Subnet</label>
                                            <div class="col-sm-7 input-group-sm">
                                                {{ Form::text("subnet",'',array("class"=>"form-control","placeholder"=>"Subnet")) }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-5 control-label">Requestor</label>
                                            <div class="col-sm-7 input-group-sm">
                                                {{ Form::text("requestor",'',array("id"=>"employee_search","class"=>"form-control input-sm","placeholder"=>"Requestor")) }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-5 control-label">Team</label>
                                            <div class="col-sm-7 input-group-sm">
                                                {{ Form::text("team",'',array("class"=>"form-control input-sm","placeholder"=>"Team")) }}
                                            </div>
                                        </div>   
                                        <div class="form-group">
                                            <div class="col-sm-offset-5 col-sm-7">
                                                <button type="submit" class="btn btn-sm delete-employ">Submit</button>
                                            </div>
                                        </div>
                                    {{ Form::close() }}
                                    <!-- end of advanced search -->
                                </div>
                                <div class="col-md-8">
                                       {{ Form::open(array("url"=>URL("assets/IP/deleteassets"),"method"=>"post","onsubmit"=>"return checkedAnId()")) }}
                                        @if(Session::get("user_type")=="Root")
                                        <div class="row">
                                            <div class="col-md-6 checkbox-tab">
                                                 <button class="btn btn-sm delete-employ" type="submit"><i class="fa fa-minus-circle fa-lg"></i> Delete Assets</button>
                                            	@if(Session::has("secure"))
		                                        <button class="btn btn-sm delete-employ" type="button" onclick="parent.location='{{ URL() }}/accounts/closesecuresession'"><i class="fa fa-lock fa-lg"></i> Close Secure Session</button>
		                                        @endif
                                            </div>
                                        </div>
                                        @endif
                                        <div class="col-md-4 tab_space"><p class="text-extrasmall"><b>Results : {{ number_format($results) }}</b> </p></div>
                                        <div class="sub_space"></div>
                                        <table class="table table-condensed table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    @if(Session::get("user_type")=="Root")
                                                    <th width="10%"><p><span class="col-md-1 top-checkbox">{{ Form::checkbox('chk[]','',null,array("onchange"=>"toggle(this)","id"=>"checkbox1")) }}</span> Action</p></th>
                                                    @else
                                                    <th width="10%"><p>Action</p></th>
                                                    @endif
                                                    <th width="13%"><p>IP Address</p></th>
                                                    <th width="15%"><p>Requestor</p></th>
                                                    <th width="12%"><p>Team</p></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($ip as $i) {?>
                                                <tr>
                                                    <td><div class="row">
                                                        @if(Session::get("user_type")=="Root")
                                                        <span class="col-md-1">{{ Form::checkbox('ip_id[]',$i->id,null,array("id"=>$i->id)) }}</span>
                                                        @endif
                                                        @if(Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")
                                                        <span class="col-md-6 fa-stack fa-lg"><a href="{{ URL() }}/assets/IP/update/{{ $i->id }}" title="Edit / Change Asset Information"><i class="fa fa-edit fa-stack-1x fa-inverse"></i></a></span>
                                                        @endif
                                                        <span class="col-md-1 fa-stack fa-lg"><a href="#" data-toggle="modal" data-target="#moreInfo{{ $i->id }}" title="More Information"><i class="fa fa-newspaper-o fa-stack-1x fa-inverse"></i></a></span>
                                                        @if(Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")
                                                        <span class="col-md-1 fa-stack fa-lg"><a href="{{ URL() }}/assets/IP/logs/{{ $i->id }}" title="View Logs"><i class="fa fa-history fa-stack-1x fa-inverse"></i></a></span>
                                                        @endif
                                                        </div>
                                                       <!-- Modal -->
		                                                <div class="employee-modal modal fade" id="moreInfo{{ $i->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		                                                    <div class="modal-dialog" style="width:900px">
		                                                        <div class="modal-content">
		                                                            <div class="modal-header">
		                                                                <h6 class="modal-title" id="myModalLabel"><strong>{{ $i->ip }}</strong></h6>
		                                                            </div>
		                                                             <div class="modal-body">
		                                                                <table class="table">
		                                                                    <tbody>
		                                                                    	<tr>
		                                                                            <td><p class="bold fright">IP Type :</p></td>
		                                                                            <td>@if(!empty($i->ip_type)) {{ $i->ip_type }} @else {{ "No Information." }} @endif</td>
		                                                                        </tr>
		                                                                        <tr>
		                                                                            <td><p class="bold fright">Subnet :</p></td>
		                                                                            <td>@if(!empty($i->subnet)) {{ $i->subnet }} @else {{ "No Information." }} @endif</td>
		                                                                        </tr>
		                                                                        <tr>
		                                                                            <td><p class="bold fright">Team :</p></td>
		                                                                            <td>@if(!empty($i->team)) {{ $i->team }} @else {{ "No Information." }} @endif</td>
		                                                                        </tr> 
		                                                                        <tr>
		                                                                            <td><p class="bold fright">Requestor :</p></td>
		                                                                            <td>{{ $i->requestor }}</td>
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
                                                    <td>{{ $i->ip }}</td>
                                                    <td>@if(!empty($i->employee->last_name)) {{ $i->employee->last_name.', '. $i->employee->first_name}} @else {{ "No Information." }}@endif</td>
                                                    <td>@if(!empty($i->employee->unit->name)) {{ $i->employee->unit->name }} @else {{ "No Information." }}@endif</td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    {{ Form::close() }}
                                    <div class="col-md-8 col-md-offset-2">
                                        <div class="pagination">
											@if($ip->links()!=null)
                                            	{{ $ip->appends(Input::except('token'))->links() }}
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