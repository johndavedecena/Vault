<?php Session::put('page',URL("assets/network/advancedsearch")."?page=".Input::get('page')); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Advanced Search Network Assets | Vault</title>
    @include('Includes.css_tb')
    @if(Session::get("user_type")=="Root")
    <script type="text/javascript">
        function checkedAnId(){       
            var checkedAny = false;           
        <?php foreach($assets as $a){ ?>
            if(document.getElementById("<?php echo $a->id?>").checked){
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
            checkboxes = document.getElementsByName('asset_id[]');
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
                @include('Includes.Tabs.Assets.network_asset_tabs')
            </ul>
            <div class="panel panel-default">
                <div class="panel-body">    
                    <div class="tab-content">
                        <div class="tab-pane active">    
                            <div class="table_space"></div>
                            <div class="row">
                                <div class="col-md-4">
                                    <!-- advanced search -->
                                    {{ Form::open(array("url"=>URL("assets/network/advancedsearch/search"),"method"=>"get","class"=>"form-horizontal")) }}
                                        <div class="form-group">
                                            <label class="col-sm-5 control-label">Asset Tag</label>
                                            <div class="col-sm-7 input-group-sm">
                                                {{ Form::text("asset_tag",'',array("class"=>"form-control","placeholder"=>"Asset Tag")) }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-5 control-label">Serial Number</label>
                                            <div class="col-sm-7 input-group-sm">
                                                {{ Form::text("serial_number",'',array("class"=>"form-control","placeholder"=>"Serial Number")) }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-5 control-label">Employee</label>
                                            <div class="col-sm-7 input-group-sm">
                                                {{ Form::text("employee",'',array("class"=>"form-control","placeholder"=>"Employee Name or Number")) }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-5 control-label">Asset Type</label>
                                            <div class="col-sm-7 input-group-sm">
                                                {{ Form::select("classification_id",$assetClassifications,'',array("class"=>"form-control")) }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-5 control-label">Asset Status</label>
                                            <div class="col-sm-7 input-group-sm">
                                                {{
                                                    Form::select("asset_status",array(
                                                            ""=>"--Select One--",
                                                            "Available"=>"Available",
                                                            "For Repair"=>"For Repair",
                                                            "Installed"=>"Installed",
                                                            "Lost"=>"Lost",
                                                            "Retired"=>"Retired"),'',array("class"=>"form-control"));

                                                }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-5 control-label">Model</label>
                                            <div class="col-sm-7 input-group-sm">
                                                {{ Form::select("model",$assetModels,'',array("class"=>"form-control")) }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-5 control-label">Warranty Start Date</label>
                                            <div class="col-sm-7 input-group-sm">
                                                {{ Form::text("warranty_start",'',array("class"=>"form-control","id"=>"start-datepicker","placeholder"=>"Start Date")) }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-5 control-label">Warranty End Date</label>
                                            <div class="col-sm-7 input-group-sm"> 
                                                {{ Form::text("warranty_end",'',array("class"=>"form-control","id"=>"end-datepicker","placeholder"=>"End Date")) }}
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
                                       {{ Form::open(array("url"=>URL("assets/network/deleteassets"),"method"=>"post","onsubmit"=>"return checkedAnId()")) }}
                                        @if(Session::get("user_type")=="Root")
                                        <div class="row">
                                            <div class="col-md-4 checkbox-tab">
                                                 <button class="btn btn-sm delete-employ" type="submit"><i class="fa fa-minus-circle fa-lg"></i> Delete Assets</button>
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
                                                    <th width="13%"><p>Asset Tag</p></th>
                                                    <th width="15%"><p>Serial Number</p></th>
                                                    <th width="12%"><p>Asset Type</p></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($assets as $a) {?>
                                                <tr>
                                                    <td><div class="row">
                                                        @if(Session::get("user_type")=="Root")
                                                        <span class="col-md-1">{{ Form::checkbox('asset_id[]',$a->id,null,array("id"=>$a->id)) }}</span>
                                                        @endif
                                                        @if(Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")
                                                        <span class="col-md-6 fa-stack fa-lg"><a href="{{ URL() }}/assets/network/update/{{ $a->classification->url_key }}/{{ $a->id }}" title="Edit / Change Asset Information"><i class="fa fa-edit fa-stack-1x fa-inverse"></i></a></span>
                                                        @endif
                                                        <span class="col-md-1 fa-stack fa-lg"><a href="#" data-toggle="modal" data-target="#moreInfo{{ $a->id }}" title="More Information"><i class="fa fa-newspaper-o fa-stack-1x fa-inverse"></i></a></span>
                                                        @if(Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")
                                                        <span class="col-md-1 fa-stack fa-lg"><a href="{{ URL() }}/assets/network/logs/{{ $a->id }}" title="View Logs"><i class="fa fa-history fa-stack-1x fa-inverse"></i></a></span>
                                                        @endif
                                                        </div>
                                                        <!-- Modal -->
                                                        <div class="employee-modal modal fade" id="moreInfo{{ $a->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog" style="width:900px">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h6 class="modal-title" id="myModalLabel"><strong>{{ $a->asset_tag }}</strong></h6>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <table class="table">
                                                                            <tbody>
                                                                                @if(!empty($a->employee->last_name))
                                                                                <tr>
                                                                                    <td><p class="bold fright">Issued To :</p></td>
                                                                                    <td>{{ $a->employee->last_name.", ".$a->employee->first_name }}</td>
                                                                                </tr>
                                                                                @endif
                                                                                <tr>
                                                                                    <td><p class="bold fright">Serial Number :</p></td>
                                                                                    <td>@if(!empty($a->serial_number)) {{ $a->serial_number }} @else {{ "No Information." }}@endif</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><p class="bold fright">Model Name :</p></td>
                                                                                    <td>@if(!empty($a->model->name)) {{ $a->model->name }} @else {{ "No Information." }}@endif</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><p class="bold fright">Warranty Start Date :</p></td>
                                                                                    <td>@if(!empty($a->warranty_start)) {{ DateTime::createFromFormat('Y-m-d', $a->warranty_start)->format('F d, Y') }} @else {{ "No Information." }} @endif</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><p class="bold fright">Warranty End Date :</p></td>
                                                                                    <td>@if(!empty($a->warranty_end)) {{ DateTime::createFromFormat('Y-m-d', $a->warranty_end)->format('F d, Y') }} @else {{ "No Information." }} @endif</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><p class="bold fright">Status :</p></td>
                                                                                    <td>{{ $a->status }}</td>
                                                                                </tr>
		                                                                        <tr>
		                                                                            <td><p class="bold fright">Notes :</p></td>
		                                                                            <td>{{ htmlentities($a->notes) }}</td>
		                                                                        </tr>
		                                                                        <tr>
	                                                                            <td><p class="bold fright">Date Added :</p></td>
		                                                                            <td>{{ DateTime::createFromFormat('Y-m-d H:i:s', $a->date_added)->format('F d, Y g:iA') }}</td>
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
                                                    <td>{{ $a->asset_tag }}</td>
                                                    <td>@if(!empty($a->serial_number)) {{ $a->serial_number }} @else {{ "No Information." }}@endif</td>
                                                    <td>{{ $a->classification->name }}</td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    {{ Form::close() }}
                                    <div class="col-md-8 col-md-offset-2">
                                        <div class="pagination">
										@if($assets->links()!=null)
                                            {{ $assets->appends(Input::except('token'))->links() }}
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