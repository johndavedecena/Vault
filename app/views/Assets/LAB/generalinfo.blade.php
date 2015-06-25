<?php Session::put('page',Request::url()."?page=".Input::get('page')); ?>
<?php if(Session::has("page2")){ Session::pull("page2"); } ?>
<?php $keyword = empty($keyword) ? "" : $keyword ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>LAB Assets | Vault</title>
    @include('Includes.css_tb')
     @if(Session::get("user_type")=="Root")
    <script type="text/javascript">
        function checkedAnId(){       
            var checkedAny = false;           
        <?php foreach($software as $s){ ?>
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
            checkboxes = document.getElementsByName('software_id[]');
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
               @include('Includes.Tabs.Assets.lab_asset_tabs')
            </ul>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane active">
                            <div class="col-md-4 fright checkbox-tab">
                                {{ Form::open(array("url"=>"assets/software/search","method"=>"post","class"=>"col-md-4 col-md-offset-4 navbar-form navbar-right fright","role"=>"search")) }}
                                    <div class="form-group" style="padding-right:-10px">
                                        <div class="input-group">
                                            {{ Form::text("keyword",$keyword,array("class"=>"form-control fright","id"=>"navbarInput-01","placeholder"=>"Search Software Assets")) }}
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn"><span class="fui-search"></span></button>
                                            </span>
                                        </div>
                                    </div>
                                {{ Form::close() }}
                            </div>
                            {{ Form::open(array("url"=>URL("assets/software/deleteassets"),"method"=>"post","onsubmit"=>"return checkedAnId()")) }}
                                <div class="row">
                                    <div class="col-md-6 checkbox-tab">
                                        @if(Session::get("user_type")!="User")
                                        <button class="btn btn-sm delete-employ" type="button" onclick="parent.location='{{ URL() }}/assets/software/add'"><i class="fa fa-plus-circle fa-lg"></i> Add Software Asset</button>
                                        @endif
                                        @if(Session::get('user_type')=="Root")
                                        <button class="btn btn-sm delete-employ" type="submit"><i class="fa fa-minus-circle fa-lg"></i> Delete Assets</button>
                                        @endif
                                        @if(Session::has("secure"))
                                        <button class="btn btn-sm delete-employ" type="button" onclick="parent.location='{{ URL() }}/accounts/closesecuresession'"><i class="fa fa-lock fa-lg"></i> Close Secure Session</button>
                                        @endif
                                        <div class="tab_space"><p class="text-extrasmall"><b>Results : {{ number_format($result) }}</b></p></div>
                                    </div>
                                </div>
	                            <div class="pagination center">
	                                @if($software->links()!=null)
	                                    {{ $software->links() }}
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
                                        <th width="10%"><p><a href="{{ URL().'/assets/software/search/'.urlencode($keyword).'/asset_tag/'}}{{ $order=='asc' ? 'desc':'asc'  }}">@if($sortby=="asset_tag") @if($order=="asc") <i class="fa fa-toggle-up"> @else <i class="fa fa-toggle-down">@endif</i> @else <i class="fa fa-square-o"></i> @endif  Asset Tag</p></th>
                                        @if(Session::has("secure") && Session::get("user_type")=="Root")
                                        <th width="12%"><p><a href="{{ URL().'/assets/software/search/'.urlencode($keyword).'/product_key/' }}{{ $order=='asc' ? 'desc':'asc'  }}">@if($sortby=="product_key") @if($order=="asc") <i class="fa fa-toggle-up"> @else <i class="fa fa-toggle-down">@endif</i> @else <i class="fa fa-square-o"></i> @endif  Product Key</p></th>
                                        @endif
                                        <th width="15%"><p>Issued To</p></th>
                                        <th width="12%"><p><a href="{{ URL().'/assets/software/search/'.urlencode($keyword).'/software_type_id/' }}{{ $order=='asc' ? 'desc':'asc'  }}">@if($sortby=="software_type_id") @if($order=="asc") <i class="fa fa-toggle-up"> @else <i class="fa fa-toggle-down">@endif</i> @else <i class="fa fa-square-o"></i> @endif  Model</p></th>
                                        <th width="12%"><p><a href="{{ URL().'/assets/software/search/'.urlencode($keyword).'/warranty_start/' }}{{ $order=='asc' ? 'desc':'asc'  }}">@if($sortby=="warranty_start") @if($order=="asc") <i class="fa fa-toggle-up"> @else <i class="fa fa-toggle-down">@endif</i> @else <i class="fa fa-square-o"></i> @endif  Warranty Start</p></th>
                                        <th width="12%"><p><a href="{{ URL().'/assets/software/search/'.urlencode($keyword).'/warranty_end/' }}{{ $order=='asc' ? 'desc':'asc'  }}">@if($sortby=="warranty_end") @if($order=="asc") <i class="fa fa-toggle-up"> @else <i class="fa fa-toggle-down">@endif</i> @else <i class="fa fa-square-o"></i> @endif  Warranty End</p></th>
                                        <th width="6%"><p>Status</p></th>
                                        <th width="12%"><p><a href="{{ URL().'/assets/software/search/'.urlencode($keyword).'/location/' }}{{ $order=='asc' ? 'desc':'asc'  }}">@if($sortby=="location") @if($order=="asc") <i class="fa fa-toggle-up"> @else <i class="fa fa-toggle-down">@endif</i> @else <i class="fa fa-square-o"></i> @endif  Location</p></th>
                                        @else
                                        @if(Session::get('user_type')=="Root")
                                        <th width="10%"><p><span class="col-md-1 top-checkbox">{{ Form::checkbox('chk[]','',null,array("onchange"=>"toggle(this)","id"=>"checkbox1")) }}</span> Action</p></th>
                                        @else
                                        <th width="10%"><p>Action</p></th>
                                        @endif
                                        <th width="10%"><p><a href="{{ URL().'/assets/software/view/asset_tag/'}}{{ $order=='asc' ? 'desc':'asc'  }}">@if($sortby=="asset_tag") @if($order=="asc") <i class="fa fa-toggle-up"> @else <i class="fa fa-toggle-down">@endif</i> @else <i class="fa fa-square-o"></i> @endif  Asset Tag</p></th>
                                        @if(Session::has("secure") && Session::get("user_type")=="Root")
                                        <th width="12%"><p><a href="{{ URL().'/assets/software/view/product_key/' }}{{ $order=='asc' ? 'desc':'asc'  }}">@if($sortby=="product_key") @if($order=="asc") <i class="fa fa-toggle-up"> @else <i class="fa fa-toggle-down">@endif</i> @else <i class="fa fa-square-o"></i> @endif  Product Key</p></th>
                                        @endif
                                        <th width="15%"><p>Issued To</p></th>
                                        <th width="12%"><p><a href="{{ URL().'/assets/software/view/software_type_id/' }}{{ $order=='asc' ? 'desc':'asc'  }}">@if($sortby=="software_type_id") @if($order=="asc") <i class="fa fa-toggle-up"> @else <i class="fa fa-toggle-down">@endif</i> @else <i class="fa fa-square-o"></i> @endif  Software Type</p></th>
                                        <th width="12%"><p><a href="{{ URL().'/assets/software/view/warranty_start/' }}{{ $order=='asc' ? 'desc':'asc'  }}">@if($sortby=="warranty_start") @if($order=="asc") <i class="fa fa-toggle-up"> @else <i class="fa fa-toggle-down">@endif</i> @else <i class="fa fa-square-o"></i> @endif  Warranty Start</p></th>
                                        <th width="12%"><p><a href="{{ URL().'/assets/software/view/warranty_end/' }}{{ $order=='asc' ? 'desc':'asc'  }}">@if($sortby=="warranty_end") @if($order=="asc") <i class="fa fa-toggle-up"> @else <i class="fa fa-toggle-down">@endif</i> @else <i class="fa fa-square-o"></i> @endif Warranty End</p></th>
                                        <th width="6%"><p>Status</p></th>  
                                        <th width="12%"><p><a href="{{ URL().'/assets/software/view/location/' }}{{ $order=='asc' ? 'desc':'asc'  }}">@if($sortby=="location") @if($order=="asc") <i class="fa fa-toggle-up"> @else <i class="fa fa-toggle-down">@endif</i> @else <i class="fa fa-square-o"></i> @endif Location</p></th>
                                        @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($software as $s){ ?>
                                        <tr>
                                            <td><div class="row">
                                                @if(Session::get('user_type')=="Root")
                                                <span class="col-md-1">{{ Form::checkbox('software_id[]',$s->id,null,array("id"=>$s->id)) }}</span>
                                                @endif
                                                @if(Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")
                                                <span class="col-md-6 fa-stack fa-lg"><a href="{{ URL() }}/assets/software/update/{{ $s->id }}" title="Edit / Change Asset Information"><i class="fa fa-edit fa-stack-1x fa-inverse"></i></a></span>
                                                @endif
                                                <span class="col-md-1 fa-stack fa-lg"><a href="#{{ $s->id }}" data-toggle="modal" data-target="#moreInfo{{ $s->id }}" title="More Information"><i class="fa fa-newspaper-o fa-stack-1x fa-inverse"></i></a></span>
                                                <span class="col-md-1 fa-stack fa-lg"><a href="{{ URL() }}/assets/software/logs/{{ $s->id }}" title="View Logs"><i class="fa fa-history fa-stack-1x fa-inverse"></i></a></span>
                                                </div>
                                                <!-- <span class="col-md-6 fa-stack fa-lg" onclick="confirmDelete({{ $s->id }})"><a title="Delete Employee"><i class="fa fa-minus-circle fa-stack-1x fa-inverse"></i></a></span>  -->
                                                <!-- Modal -->
                                                <div class="employee-modal modal fade" id="moreInfo{{ $s->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" style="width:900px">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h6 class="modal-title" id="myModalLabel"><strong>{{ $s->asset_tag }}</strong></h6>
                                                            </div>
                                                            <div class="modal-body">
                                                                <table class="table">
                                                                    <tbody>
                                                                        @if(!empty($s->employee->last_name))
                                                                        <tr>
                                                                            <td><p class="bold fright">Issued To :</p></td>
                                                                            <td>{{ $s->employee->last_name.", ".$s->employee->first_name }}</td>
                                                                        </tr>
                                                                        @endif
                                                                        <tr>
                                                                            <td><p class="bold fright">Assigned to Laptop :</p></td>
                                                                            <td>@if(!empty($s->assigned_to_serial_number)) {{ $s->assigned_to_serial_number }} @else {{ "No Information." }}@endif</td>
                                                                        </tr>
                                                                        @if(Session::has("secure") && Session::get("user_type")=="Root")
                                                                        <tr>
                                                                            <td><p class="bold fright">Product Key :</p></td>
                                                                            <td>{{ $s->product_key }}</td>
                                                                        </tr>
                                                                        @endif
                                                                        <tr>
                                                                            <td><p class="bold fright">Software Type :</p></td>
                                                                            <td>{{ $s->type->software_type }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><p class="bold fright">Location :</p></td>
                                                                            <td>@if(!empty($s->location)) {{ $s->location }} @else {{ "No Information." }} @endif</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><p class="bold fright">Warranty Start Date :</p></td>
                                                                            <td>@if(!empty($s->warranty_start)) {{ DateTime::createFromFormat('Y-m-d', $s->warranty_start)->format('F d, Y') }} @else {{ "No Information." }} @endif</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><p class="bold fright">Warranty End Date :</p></td>
                                                                            <td>@if(!empty($s->warranty_end)) {{ DateTime::createFromFormat('Y-m-d', $s->warranty_end)->format('F d, Y') }} @else {{ "No Information." }} @endif</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><p class="bold fright">Status :</p></td>
                                                                            <td>{{ $s->status }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><p class="bold fright">Notes :</p></td>
                                                                            <td>{{ htmlentities($s->notes) }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><p class="bold fright">Date Added :</p></td>
                                                                            <td>{{ DateTime::createFromFormat('Y-m-d H:i:s', $s->date_added)->format('F d, Y g:iA') }}</td>
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
                                            <td>{{ $s->asset_tag }}</td>
                                            @if(Session::has("secure") && Session::get("user_type")=="Root")
                                            <td>{{ $s->product_key }}</td>
                                            @endif
                                            <td>@if(!empty($s->employee->last_name)) {{ $s->employee->last_name.", ".$s->employee->first_name }} @else {{ "None." }}@endif</td>
                                            <td>{{ $s->type->software_type  }}</td>
                                            <td>@if(!empty($s->warranty_start)) {{ DateTime::createFromFormat('Y-m-d', $s->warranty_start)->format('F d, Y') }} @else {{ "No Information." }} @endif</td>
                                            <td>@if(!empty($s->warranty_end)) {{ DateTime::createFromFormat('Y-m-d', $s->warranty_end)->format('F d, Y') }} @else {{ "No Information." }} @endif</td>
                                            <td>{{ $s->status }}</td>
                                            <td>@if(!empty($a->location)) {{ $a->location }} @else {{ "No Information." }}@endif</td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                {{ Form::close() }}
                            <div class="pagination center">
                                @if($software->links()!=null)
                                    {{ $software->links() }}
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