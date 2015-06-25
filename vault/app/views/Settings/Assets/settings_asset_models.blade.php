@if(isset($search))
<?php Session::put('page',Request::url()."?keyword=".urlencode(Input::get("keyword"))."&asset_type=".urlencode(Input::get("asset_type"))."&page=".Input::get('page')); ?>
@else
<?php Session::put('page',Request::url()."?page=".Input::get('page')); ?>
@endif
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Settings - Asset Models | Vault</title>
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
                @include("Includes.Tabs.Settings.settings_assets_tabs")
            </ul>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane active">
                                <div class="row">
                                    <div class="col-md-4 checkbox-tab">
                                        <button class="btn btn-sm delete-employ" type="button" onclick="parent.location='{{ URL() }}/settings/assets/addassetmodel'"><i class="fa fa-plus-circle fa-lg"></i> Add Asset Model</button>
                                    </div>
                                    <div class="col-md-4 col-md-offset-1">
                                            <h4>Asset Models</h4>
                                    </div>
                                </div>
                                {{ Form::open(array("method"=>"get","url"=>URL()."/settings/assets/assetmodels/search")) }}
                                <div class="form-group">
                                  	<table class="table table-condensed table-striped table-hover" style="margin:auto;width:400px">
	                                    <thead>
	                                        <tr>
	                                            <th width="50%"></th>
	                                            <th width="50%"></th>
	                                        </tr>
	                                    </thead>
	                                    <tbody>
	                                        <tr>
	                                            <td>
	                                                <div class="input-group input-group-sm" style="width:200px">
                                                    {{ Form::text("keyword","",array('class'=>'form-control input-sm','placeholder'=>'Search Asset Models')); }}
	                                                </div>
	                                            </td>
	                                            <td>
	                                                <div class="input-group input-group-sm" style="width:200px">
	                                                    {{ Form::select("asset_type",$assetTypes,'',array('class'=>'form-control input-sm')); }}
	                                                </div>
		                                            </td>
		                                            <td></td>
		                                        </tr>
		                                        <tr>
		                                            <td colspan="2" align="center">{{ Form::button('Search',array("class"=>"btn btn-sm btn-info","style"=>"margin-left:30px","type"=>"submit")) }}</td>
		                                        </tr>
				                       	</tbody>
			                        </table>
                                </div>
                                {{ Form::close() }}
                                <table class="table table-condensed table-striped table-hover" style="margin:auto;width:900px">
                                    <thead>
                                        <tr>
                                            <th width="20%"></th>
                                            @if(Session::get("user_type")=="Root")
                                            <th width="10%"><p>Delete</p></th>
                                            @endif
                                            <th width="10%"><p>ID</p></th>
                                            <th width="20%"><p>Name</p></th>
                                            <th width="20%"><p>Asset Type</p></th>
                                            <th width="20%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <?php foreach ($assetModels as $am) { ?>
                                        <tr>
                                            <td></td>
                                            @if(Session::get("user_type")=="Root")
                                            <td><span class="fa-stack fa-lg" onclick="confirmDelete({{ $am->id }})"><i class="fa fa-close fa-stack-1x fa-inverse"></i></span></td>
                                            @endif
                                            <td><a href="{{ URL() }}/settings/assets/updateassetmodel/{{ $am->id }}">{{ str_pad($am->id,4,0,STR_PAD_LEFT) }}</a></td>
                                            <td>{{ $am->name }}</td>
                                            <td>{{ $am->classification->name }}</td>
                                            <td></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            @if($assetModels->links()!=null)
                            <div class="pagination center">
                                {{ $assetModels->appends(Input::except('token'))->links() }}
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
            var con = confirm("Are you sure you want to delete this asset model?");
            if(con==true){
                    parent.location="{{ URL() }}/settings/assets/deleteassetmodel/"+id;
            }
    }
</script>
</body>
</html>