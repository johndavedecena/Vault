<?php Session::put('page',Request::url()."?page=".Input::get('page')); ?>
<?php if(Session::has("page2")){ Session::pull("page2"); } ?>
<?php $keyword = empty($keyword) ? "" : $keyword ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>IP Assets | Vault</title>
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
               @include('Includes.Tabs.Assets.ip_asset_tabs')
            </ul>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane active">
                            <div class="col-md-4 fright checkbox-tab">
                                {{ Form::open(array("url"=>"assets/IP/search","method"=>"post","class"=>"col-md-4 col-md-offset-4 navbar-form navbar-right fright","role"=>"search")) }}
                                    <div class="form-group" style="padding-right:-10px">
                                        <div class="input-group">
                                            {{ Form::text("keyword",$keyword,array("class"=>"form-control fright","id"=>"navbarInput-01","placeholder"=>"Search IP Assets")) }}
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn"><span class="fui-search"></span></button>
                                            </span>
                                        </div>
                                    </div>
                                {{ Form::close() }}
                            </div>
                            {{ Form::open(array("url"=>URL("assets/IP/deleteassets"),"method"=>"post","onsubmit"=>"return checkedAnId()")) }}
                                <div class="row">
                                    <div class="col-md-6 checkbox-tab">
                                        @if(Session::get("user_type")!="User")
                                        <button class="btn btn-sm delete-employ" type="button" onclick="parent.location='{{ URL() }}/assets/IP/add'"><i class="fa fa-plus-circle fa-lg"></i> Add IP Asset</button>
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
	                                @if($ip->links()!=null)
	                                    {{ $ip->links() }}
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
                                        <th width="12%"><p><a href="{{ URL().'/assets/IP/search/'.urlencode($keyword).'/ip/'}}{{ $order=='asc' ? 'desc':'asc'  }}">@if($sortby=="ip") @if($order=="asc") <i class="fa fa-toggle-up"> @else <i class="fa fa-toggle-down">@endif</i> @else <i class="fa fa-square-o"></i> @endif  IP Address</p></th>
                                        <th width="8%"><p><a href="{{ URL().'/assets/IP/search/'.urlencode($keyword).'/ip_type/' }}{{ $order=='asc' ? 'desc':'asc'  }}">@if($sortby=="warranty_end") @if($order=="asc") <i class="fa fa-toggle-up"> @else <i class="fa fa-toggle-down">@endif</i> @else <i class="fa fa-square-o"></i> @endif  IP Type</p></th>
                                        <th width="8%"><p><a href="{{ URL().'/assets/IP/search/'.urlencode($keyword).'/subnet/' }}{{ $order=='asc' ? 'desc':'asc'  }}">@if($sortby=="software_type_id") @if($order=="asc") <i class="fa fa-toggle-up"> @else <i class="fa fa-toggle-down">@endif</i> @else <i class="fa fa-square-o"></i> @endif  Subnet</p></th>
                                        <th width="12%"><p><a href="{{ URL().'/assets/IP/search/'.urlencode($keyword).'/team/' }}{{ $order=='asc' ? 'desc':'asc'  }}">@if($sortby=="warranty_start") @if($order=="asc") <i class="fa fa-toggle-up"> @else <i class="fa fa-toggle-down">@endif</i> @else <i class="fa fa-square-o"></i> @endif  Team</p></th>
                                        <th width="12%"><p><a href="{{ URL().'/assets/IP/search/'.urlencode($keyword).'/requestor/' }}{{ $order=='asc' ? 'desc':'asc'  }}">@if($sortby=="warranty_end") @if($order=="asc") <i class="fa fa-toggle-up"> @else <i class="fa fa-toggle-down">@endif</i> @else <i class="fa fa-square-o"></i> @endif  Requestor</p></th>
                                        <th width="12%"><p><a href="{{ URL().'/assets/IP/search/'.urlencode($keyword).'/requestor/' }}{{ $order=='asc' ? 'desc':'asc'  }}">@if($sortby=="warranty_end") @if($order=="asc") <i class="fa fa-toggle-up"> @else <i class="fa fa-toggle-down">@endif</i> @else <i class="fa fa-square-o"></i> @endif  Notes</p></th>
                                        @else
                                        @if(Session::get('user_type')=="Root")
                                        <th width="10%"><p><span class="col-md-1 top-checkbox">{{ Form::checkbox('chk[]','',null,array("onchange"=>"toggle(this)","id"=>"checkbox1")) }}</span> Action</p></th>
                                        @else
                                        <th width="10%"><p>Action</p></th>
                                        @endif
                                        <th width="12%"><p><a href="{{ URL().'/assets/IP/view/ip/'}}{{ $order=='asc' ? 'desc':'asc'  }}">@if($sortby=="ip") @if($order=="asc") <i class="fa fa-toggle-up"> @else <i class="fa fa-toggle-down">@endif</i> @else <i class="fa fa-square-o"></i> @endif  IP Address</p></th>
                                        <th width="8%"><p><a href="{{ URL().'/assets/IP/view/ip_type/' }}{{ $order=='asc' ? 'desc':'asc'  }}">@if($sortby=="ip_type") @if($order=="asc") <i class="fa fa-toggle-up"> @else <i class="fa fa-toggle-down">@endif</i> @else <i class="fa fa-square-o"></i> @endif  IP Type</p></th>
                                        <th width="8%"><p><a href="{{ URL().'/assets/IP/view/subnet/' }}{{ $order=='asc' ? 'desc':'asc'  }}">@if($sortby=="subnet") @if($order=="asc") <i class="fa fa-toggle-up"> @else <i class="fa fa-toggle-down">@endif</i> @else <i class="fa fa-square-o"></i> @endif  Subnet</p></th>
                                        <th width="12%"><p><a href="{{ URL().'/assets/IP/view/team/' }}{{ $order=='asc' ? 'desc':'asc'  }}">@if($sortby=="team") @if($order=="asc") <i class="fa fa-toggle-up"> @else <i class="fa fa-toggle-down">@endif</i> @else <i class="fa fa-square-o"></i> @endif Team</p></th>
                                        <th width="12%"><p><a href="{{ URL().'/assets/IP/view/requestor/' }}{{ $order=='asc' ? 'desc':'asc'  }}">@if($sortby=="requestor") @if($order=="asc") <i class="fa fa-toggle-up"> @else <i class="fa fa-toggle-down">@endif</i> @else <i class="fa fa-square-o"></i> @endif Requestor</p></th>
                                        <th width="12%"><p>  Notes</p></th>
                                        @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	
                                        <?php foreach($ip as $i){ ?>
                                        <tr>
                                            <td><div class="row">
                                                @if(Session::get('user_type')=="Root")
                                                <span class="col-md-1">{{ Form::checkbox('ip_id[]',$i->id,null,array("id"=>$i->id)) }}</span>
                                                @endif
                                                @if(Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")
                                                <span class="col-md-6 fa-stack fa-lg"><a href="{{ URL() }}/assets/IP/update/{{ $i->id }}" title="Edit / Change Asset Information"><i class="fa fa-edit fa-stack-1x fa-inverse"></i></a></span>
                                                @endif
                                                <span class="col-md-1 fa-stack fa-lg"><a href="#{{ $i->id }}" data-toggle="modal" data-target="#moreInfo{{ $i->id }}" title="More Information"><i class="fa fa-newspaper-o fa-stack-1x fa-inverse"></i></a></span>
                                                <span class="col-md-1 fa-stack fa-lg"><a href="{{ URL() }}/assets/IP/logs/{{ $i->id }}" title="View Logs"><i class="fa fa-history fa-stack-1x fa-inverse"></i></a></span>
                                                </div>
                                                <!-- <span class="col-md-6 fa-stack fa-lg" onclick="confirmDelete({{ $i->id }})"><a title="Delete Employee"><i class="fa fa-minus-circle fa-stack-1x fa-inverse"></i></a></span>  -->
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
                                                                            <td>@if(!empty($i->employee->unit->name)) {{ $i->employee->unit->name }} @else {{ "No Information." }} @endif</td>
                                                                        </tr> 
                                                                        <tr>
                                                                            <td><p class="bold fright">Requestor :</p></td>
                                                                            <td>{{ $i->requestor }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><p class="bold fright">Notes :</p></td>
                                                                            <td>{{ $i->notes }}</td>
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
                                            <td>@if(!empty($i->ip)) {{ $i->ip }} @else {{ "No Information." }}@endif</td>
                                            <td>@if(!empty($i->ip_type)) {{ $i->ip_type }} @else {{ "No Information." }}@endif</td>
                                            <td>@if(!empty($i->subnet)) {{ $i->subnet }} @else {{ "No Information." }}@endif</td>
                                            <td>@if(!empty($i->employee->unit->name)) {{ $i->employee->unit->name }} @else {{ "No Information." }}@endif</td>
                                            <td>@if(!empty($i->employee->last_name)) {{ $i->employee->last_name.', '. $i->employee->first_name}} @else {{ "No Information." }}@endif</td>
                                            <td>@if(!empty($i->notes)) {{ $i->notes }} @else {{ "No Information." }}@endif</td>
                                        </tr>
                                        <?php } ?>
                                        
                                    </tbody>
                                </table>
                                {{ Form::close() }}
                            <div class="pagination center">
                                @if($ip->links()!=null)
                                    {{ $ip->links() }}
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