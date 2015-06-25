@if(isset($search))
<?php Session::put('page',Request::url()."?keyword=".urlencode(Input::get("keyword"))."&page=".Input::get('page')); ?>
@else
<?php Session::put('page',Request::url()."?page=".Input::get('page')); ?>
@endif
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Settings - Software Types | Vault</title>
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
                                        <button class="btn btn-sm delete-employ" type="button" onclick="parent.location='{{ URL() }}/settings/assets/addsoftwaretype'"><i class="fa fa-plus-circle fa-lg"></i>Add Software Type</button>
                                    </div>
                                    <div class="col-md-4 col-md-offset-1">
                                            <h4>Software Types</h4>
                                    </div>
                                    <div class="col-md-8 col-md-offset-4 text-left small">
                                            <strong>Note: </strong> Only software types with zero (0) assets can be deleted.
                                    </div><br/>
                                    {{ Form::open(array("method"=>"get","url"=>URL()."/settings/assets/softwaretypes/search")) }}
	                                <div class="form-group">
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
	                                                    {{ Form::text("keyword","",array('class'=>'form-control input-sm','placeholder'=>'Search Asset Models')); }}
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
                                            <th width="20%"><p>Software Type</p></th>
                                            <th width="20%"><p># of Assets</p></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <?php foreach ($softwareTypes as $st) { ?>
                                        <tr>
                                            <td></td>
                                            @if(Session::get("user_type")=="Root")
	                                            <td>
	                                            @if(count($st->softwareassets)==0)
	                                            <span class="fa-stack fa-lg" onclick="confirmDelete({{ $st->id }})"><i class="fa fa-close fa-stack-1x fa-inverse"></i></span>
	                                            @endif
	                                            </td>
                                            @endif
                                            <td><a href="{{ URL() }}/settings/assets/updatesoftwaretype/{{ $st->id }}">{{ str_pad($st->id,4,0,STR_PAD_LEFT) }}</a></td>
                                            <td>{{ $st->software_type }}</td>
                                            <td>{{ count($st->softwareassets) }}</td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            @if($softwareTypes->links()!=null)
                            <div class="pagination center">
                                {{ $softwareTypes->appends(Input::except('token'))->links() }}
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
            var con = confirm("Are you sure you want to delete this software type?");
            if(con==true){
                    parent.location="{{ URL() }}/settings/assets/deletesoftwaretype/"+id;
            }
    }
</script>
</body>
</html>