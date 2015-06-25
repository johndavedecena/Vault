<?php Session::put('page',Request::url()."?page=".Input::get('page')); ?>
<?php if(Session::has("page2")){ Session::pull("page2"); } ?>
<?php $keyword = empty($keyword) ? "" : $keyword ?>
<!DOCTYPE html>
<html lang="en">
<style type="text/css">
select { text-align:center; }
select .lt { text-align:left; }
</style> 
<head>
    <meta charset="utf-8">
    <title> Client {{ $asset_name }} | Vault</title>
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
               @include('Includes.Tabs.Assets.client_asset_tabs')
            </ul>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="users">
                            <div class="col-md-4 fright checkbox-tab">
                                {{ Form::open(array("url"=>"assets/client/search/$asset_key","method"=>"post","class"=>"col-md-4 col-md-offset-4 navbar-form navbar-right fright","role"=>"search")) }}
                                    <div class="form-group" style="padding-right:-10px">
                                        <div class="input-group">
                                            {{ Form::text("keyword",$keyword,array("class"=>"form-control fright","id"=>"navbarInput-01","placeholder"=>"Search $asset_name")) }}
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn"><span class="fui-search"></span></button>
                                            </span>
                                        </div>
                                    </div>
                                {{ Form::close() }}
                            </div>
                            {{ Form::open(array("url"=>URL("assets/client/deleteassets"),"method"=>"post","onsubmit"=>"return checkedAnId()")) }}
                                <div class="row">
                                    <div class="col-md-4 checkbox-tab">
                                    	@if(Session::get("user_type")=="Admin" || Session::get("user_type")=="Root")
                                        <button class="btn btn-sm delete-employ" type="button" onclick="parent.location='{{ URL() }}/assets/client/add/{{ $asset_key }}'"><i class="fa fa-plus-circle fa-lg"></i> Add an Asset</button>
                                        @endif
                                        @if(Session::get('user_type')=="Root")
                                        <button class="btn btn-sm delete-employ" type="submit"><i class="fa fa-minus-circle fa-lg"></i> Delete Assets</button>
                                        @endif
                                        <div class="tab_space"><p class="text-extrasmall"><b>Results : {{ number_format($result) }}</b></p></div>
                                    </div>
                                </div>
	                            <div class="pagination center">
	                                @if($assets->links()!=null)
	                                    {{ $assets->links() }}
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
                                        <th width="10%"><p><a href="{{ URL().'/assets/client/search/'.$asset_key.'/'.urlencode($keyword).'/asset_tag/'}}{{ $order=='asc' ? 'desc':'asc'  }}">@if($sortby=="asset_tag") @if($order=="asc") <i class="fa fa-toggle-up"> @else <i class="fa fa-toggle-down">@endif</i> @else <i class="fa fa-square-o"></i> @endif  Asset Tag</p></th>
                                        <th width="10%"><p><a href="{{ URL().'/assets/client/search/'.$asset_key.'/'.urlencode($keyword).'/serial_number/' }}{{ $order=='asc' ? 'desc':'asc'  }}">@if($sortby=="serial_number") @if($order=="asc") <i class="fa fa-toggle-up"> @else <i class="fa fa-toggle-down">@endif</i> @else <i class="fa fa-square-o"></i> @endif  Serial Number</p></th>
                                        <th width="15%"><p>Issued To</p></th>
                                        <th width="12%"><p><a href="{{ URL().'/assets/client/search/'.$asset_key.'/'.urlencode($keyword).'/model_id/' }}{{ $order=='asc' ? 'desc':'asc'  }}">@if($sortby=="model_id") @if($order=="asc") <i class="fa fa-toggle-up"> @else <i class="fa fa-toggle-down">@endif</i> @else <i class="fa fa-square-o"></i> @endif  Model</p></th>
                                        <th width="10%"><p><a href="{{ URL().'/assets/client/search/'.$asset_key.'/'.urlencode($keyword).'/warranty_start/' }}{{ $order=='asc' ? 'desc':'asc'  }}">@if($sortby=="warranty_start") @if($order=="asc") <i class="fa fa-toggle-up"> @else <i class="fa fa-toggle-down">@endif</i> @else <i class="fa fa-square-o"></i> @endif  Warranty Start</p></th>
                                        <th width="10%"><p><a href="{{ URL().'/assets/client/search/'.$asset_key.'/'.urlencode($keyword).'/warranty_end/' }}{{ $order=='asc' ? 'desc':'asc'  }}">@if($sortby=="warranty_end") @if($order=="asc") <i class="fa fa-toggle-up"> @else <i class="fa fa-toggle-down">@endif</i> @else <i class="fa fa-square-o"></i> @endif  Warranty End</p></th>
                                        <th width="6%"><p>Status</p></th>
                                        <th width="10%"><p><a href="{{ URL().'/assets/client/view/'.$asset_key.'/location/' }}{{ $order=='asc' ? 'desc':'asc'  }}">@if($sortby=="location") @if($order=="asc") <i class="fa fa-toggle-up"> @else <i class="fa fa-toggle-down">@endif</i> @else <i class="fa fa-square-o"></i> @endif Location</p></th>
                                    
                                        @if(Session::get('user_type')!="User")
                                         <?php if($asset_key == "laptops"){ ?>
                                        <th width="10%"><p><a href="{{ URL().'/assets/client/view/'.$asset_key.'/image/' }}{{ $order=='asc' ? 'desc':'asc'  }}">@if($sortby=="image") @if($order=="asc") <i class="fa fa-toggle-up"> @else <i class="fa fa-toggle-down">@endif</i> @else <i class="fa fa-square-o"></i> @endif Image</p></th>
                                        <?php  }?>
                                        @endif
                                       
                                        @else
                                        @if(Session::get('user_type')=="Root")
                                        <th width="10%"><p><span class="col-md-1 top-checkbox">{{ Form::checkbox('chk[]','',null,array("onchange"=>"toggle(this)","id"=>"checkbox1")) }}</span> Action</p></th>
                                        @else
                                        <th width="10%"><p>Action</p></th>
                                        @endif
                                        <th width="10%"><p><a href="{{ URL().'/assets/client/view/'.$asset_key.'/asset_tag/'}}{{ $order=='asc' ? 'desc':'asc'  }}">@if($sortby=="asset_tag") @if($order=="asc") <i class="fa fa-toggle-up"> @else <i class="fa fa-toggle-down">@endif</i> @else <i class="fa fa-square-o"></i> @endif  Asset Tag</p></th>
                                        <th width="10%"><p><a href="{{ URL().'/assets/client/view/'.$asset_key.'/serial_number/' }}{{ $order=='asc' ? 'desc':'asc'  }}">@if($sortby=="serial_number") @if($order=="asc") <i class="fa fa-toggle-up"> @else <i class="fa fa-toggle-down">@endif</i> @else <i class="fa fa-square-o"></i> @endif  Serial Number</p></th>
                                        <th width="15%"><p>Issued To</p></th>
                                        <th width="12%"><p><a href="{{ URL().'/assets/client/view/'.$asset_key.'/model_id/' }}{{ $order=='asc' ? 'desc':'asc'  }}">@if($sortby=="model_id") @if($order=="asc") <i class="fa fa-toggle-up"> @else <i class="fa fa-toggle-down">@endif</i> @else <i class="fa fa-square-o"></i> @endif  Model</p></th>
                                        <th width="10%"><p><a href="{{ URL().'/assets/client/view/'.$asset_key.'/warranty_start/' }}{{ $order=='asc' ? 'desc':'asc'  }}">@if($sortby=="warranty_start") @if($order=="asc") <i class="fa fa-toggle-up"> @else <i class="fa fa-toggle-down">@endif</i> @else <i class="fa fa-square-o"></i> @endif  Warranty Start</p></th>
                                        <th width="10%"><p><a href="{{ URL().'/assets/client/view/'.$asset_key.'/warranty_end/' }}{{ $order=='asc' ? 'desc':'asc'  }}">@if($sortby=="warranty_end") @if($order=="asc") <i class="fa fa-toggle-up"> @else <i class="fa fa-toggle-down">@endif</i> @else <i class="fa fa-square-o"></i> @endif Warranty End</p></th>
                                        <th width="6%"><p>Status</p></th>  
                                        <th width="10%"><p><a href="{{ URL().'/assets/client/view/'.$asset_key.'/location/' }}{{ $order=='asc' ? 'desc':'asc'  }}">@if($sortby=="location") @if($order=="asc") <i class="fa fa-toggle-up"> @else <i class="fa fa-toggle-down">@endif</i> @else <i class="fa fa-square-o"></i> @endif Location</p></th>
                                        @if(Session::get('user_type')!="User")
                                        <?php if($asset_key == "laptops"){ ?>
                                        <th width="10%"><p><a href="{{ URL().'/assets/client/view/'.$asset_key.'/image/' }}{{ $order=='asc' ? 'desc':'asc'  }}">@if($sortby=="image") @if($order=="asc") <i class="fa fa-toggle-up"> @else <i class="fa fa-toggle-down">@endif</i> @else <i class="fa fa-square-o"></i> @endif Image</p></th>
                                        <?php  }?>
                                        @endif
                                        @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($assets as $a){ ?>
                                        <tr>
                                            <td><div class="row">
                                                @if(Session::get('user_type')=="Root")
                                                <span class="col-md-1">{{ Form::checkbox('asset_id[]',$a->id,null,array("id"=>$a->id)) }}</span>
                                                @endif
                                                @if(Session::get('user_type')=="Root" || Session::get('user_type')=="Admin")
                                                <span class="col-md-6 fa-stack fa-lg"><a href="{{ URL() }}/assets/client/update/{{ $a->classification->url_key }}/{{ $a->id }}" title="Edit / Change Asset Information"><i class="fa fa-edit fa-stack-1x fa-inverse"></i></a></span>
                                                @endif
                                                <span class="col-md-1 fa-stack fa-lg"><a href="#{{ $a->id }}" data-toggle="modal" data-target="#moreInfo{{ $a->id }}" title="More Information"><i class="fa fa-newspaper-o fa-stack-1x fa-inverse"></i></a></span>
                                                <span class="col-md-1 fa-stack fa-lg"><a href="{{ URL() }}/assets/client/logs/{{ $a->id }}" title="View Logs"><i class="fa fa-history fa-stack-1x fa-inverse"></i></a></span>
                                                </div>
                                                <!-- <span class="col-md-6 fa-stack fa-lg" onclick="confirmDelete({{ $a->id }})"><a title="Delete Employee"><i class="fa fa-minus-circle fa-stack-1x fa-inverse"></i></a></span>  -->
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
                                                                        @if($a->classification->url_key=="laptops")
                                                                        <tr>
                                                                            <td><p class="bold fright">Charger Serial Number :</p></td>
                                                                            <td>@if(!empty($a->charger)) {{ $a->charger }} @else {{ "No Information." }}@endif</td>
                                                                        </tr>
                                                                        <tr>
                                                                        	<td><p class="bold fright">OS Image :</p></td>
                                                                            <td>@if(!empty($a->image)) {{ $a->image }} @else {{ "No Information." }}@endif</td>
                                                                        </tr>
                                                                        <tr>
                                                                        	<td><p class="bold fright">RAM Upgrade :</p></td>
                                                                            <td>@if(!empty($a->laptop_ram_upgrade)) {{ $a->laptop_ram_upgrade }} @else {{ "None." }}@endif</td>
                                                                        </tr>
                                                                        <tr>
                                                                        	<td><p class="bold fright">Anti Virus :</p></td>
                                                                            <td>@if(!empty($a->antivirus)) {{ $a->antivirus }} @else {{ "Not Done" }}@endif</td>
                                                                        </tr>
                                                                        @endif
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
                                            <td>@if(!empty($a->serial_number)) {{ $a->serial_number }} @endif</td>
                                            <td>@if(!empty($a->employee->last_name)) {{ $a->employee->last_name.", ".$a->employee->first_name }} @else {{ "None." }}@endif</td>
                                            <td>@if(!empty($a->model->name)) {{ $a->model->name }} @else {{ "No Information." }}@endif</td>
                                            <td>@if(!empty($a->warranty_start)) {{ DateTime::createFromFormat('Y-m-d', $a->warranty_start)->format('F d, Y') }} @else {{ "No Information." }} @endif</td>
                                            <td>@if(!empty($a->warranty_end)) {{ DateTime::createFromFormat('Y-m-d', $a->warranty_end)->format('F d, Y') }} @else {{ "No Information." }} @endif</td>
                                            <td>{{ $a->status }}</td>
                                            <td>@if(!empty($a->location)) {{ $a->location }} @else {{ "No Information." }} @endif</td>
                                               @if($a->classification->url_key=="laptops")
                                            <td> @if(Session::get('user_type')!="User")  <select name="image" id= "image"  <?php if($a->image == "NWL" ) {?> style="background-color: CornflowerBlue" <?php } elseif($a->image == "Nokia") {?> style="background-color: Lavender " <?php } elseif($a->image == "Ubuntu") { ?> style="background-color: White " <?php } elseif (empty($a->image) or ($a->image == "N/A")){ ?> style="background-color: DarkGray  " <?php  } ?>  onchange="changeav(this , '<?php echo $a->id?>', '<?php echo $a->asset_tag?>');">
                                            																							            										          	 
										        	<?php if($a->image == "NWL") {?>
										                 <option class="green" style="background-color: CornflowerBlue" value="NWL" selected = "selected">NWL</option>
														 <option class="green" style="background-color: Lavender" value="Nokia" > Nokia</option>
														 <option class="green" style="background-color: White" value="Ubuntu" > Ubuntu</option>
														 <option class="green" style="background-color: DarkGray" value="N/A" >N/A</option>
														 <?php } elseif($a->image == "Nokia") {?>
														 <option style="background-color: CornflowerBlue" value="NWL">NWL</option>
														 <option style="background-color: Lavender" value="Nokia" selected = "selected" > Nokia</option>
														 <option style="background-color: White" value="Ubuntu" > Ubuntu</option>
														 <option style="background-color: DarkGray" value="N/A" >N/A</option>	
														 <?php } elseif($a->image == "Ubuntu") {?>
														 <option style="background-color: CornflowerBlue" value="NWL">NWL</option>
														 <option style="background-color: Lavender" value="Nokia" > Nokia</option>
														 <option style="background-color: White" value="Ubuntu" selected = "selected" > Ubuntu</option>
														 <option style="background-color: DarkGray" value="N/A" >N/A</option>													 
														 <?php } elseif(empty($a->image) or ($a->image == "N/A")){ ?>
														 <option style="background-color: CornflowerBlue" value="NWL">NWL</option>
														 <option style="background-color: Lavender" value="Nokia" > Nokia</option>
														 <option style="background-color: White" value="Ubuntu" selected = "selected" > Ubuntu</option>
														 <option style="background-color: DarkGray" value="N/A" selected = "selected" >N/A</option>
														 <?php  } ?>					 														 
													</select>@endif</td>@endif
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            {{ Form::close() }}
                            <div class="pagination center">
                                @if($assets->links()!=null)
                                    {{ $assets->links() }}
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

<script>

	changeav = function(img, user_id, asset_tag){
    	var image_value = img.value;
        var userid = user_id;
        var assettag = asset_tag;
        var domain = window.location.host;
        var targetUrl = 'http://'+ domain +'/vault/assets/client/osImage';
    //alert(targetUrl);
    //alert(image_value);
   	//alert(userid);
    //alert(assettag);
    $.ajax({
        type: "GET",
        url: targetUrl,
        data: { function_params: image_value, userid: userid, assettag: asset_tag},
        Success: function(result){
            alert('Success');
        }
    });
}

</script>

</html>


