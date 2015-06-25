<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Import Client Assets | Vault</title>
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
                @include('Includes.Tabs.Assets.client_asset_tabs')
            </ul>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane active">
                            <h5 class="in-line">Import Client Assets <a class="text-small" href="{{ URL() }}/forms/import_client_assets.xlsx">(Download Form)</a> </h5>
                            @if(Session::get('message'))
                            <div class="alert alert-danger alert-dismissible text-center" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <strong>Import Failed. </strong> {{ Session::get('message') }}
                            </div><br/>
                            @endif
                            {{ Form::open(array("url"=>"assets/client/postimport","method"=>"post","files"=>true)) }} 
                            <div class="input-group input-group-sm col-md-10 col-md-offset-3">
                                {{ Form::select("asset_class_id",$assetClassifications,'',array("class"=>"form-control input-sm","id"=>"asset_class","onchange"=>"redirector()","style"=>"width:200px;height:40px")) }}
                                {{ Form::file('file',array("class"=>"form-control","style"=>"width:300px;height:40px","enctype"=>"multipart/form-data")) }}
                                {{ Form::button('Upload',array("type"=>"submit","class"=>"btn btn-info")) }}
                            </div>
                            {{ Form::close() }}
                            <div class="space"></div>
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