<?php Session::put('page',Request::url()."?page=".Input::get('page')); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>User Accounts - Root Administrator | Vault</title>
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
                <li class="active"><a href="#users" role="tab" data-toggle="tab">Manage Accounts</a></li>
            </ul>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="users">
                            <div class="row">
                                <div class="col-md-4 fleft">
                                    <button class="btn btn-sm" onclick="parent.location='{{ URL('accounts/addaccount') }}'"><i class="fa fa-plus-circle fa-lg"></i> Add An Account</button>
                                </div>
                                <div class="col-md-4 col-md-offset-4">
                                {{ Form::open(array("url"=>"accounts/search","method"=>"post","class"=>"col-md-4 col-md-offset-4 navbar-form navbar-right fright","role"=>"search")) }}
                                    <div class="form-group">
                                        <div class="input-group">
                                            {{ Form::text("keyword",'',array("class"=>"form-control fright","id"=>"navbarInput-01","placeholder"=>"Search Accounts")) }}
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn"><span class="fui-search"></span></button>
                                            </span>            
                                        </div>
                                    </div>               
                                {{ Form::close() }}
                                </div>
                                <div class="pagination center">
                                    @if($users->links()!=null)
                                        {{ $users->links() }}
                                    @endif
                                </div>
                            </div>
                            <table class="table table-condensed table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="10%"><p>Action</p></th>
                                        <th width="16%"><p>Username</p></th>
                                        <th width="16%"><p>Last Name</p></th>
                                        <th width="20%"><p>First Name</p></th>
                                        <th width="13%"><p>Department</p></th>
                                        <th width="13%"><p>User Type</p></th>
                                        <th width="12%"><p>Status</p></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($users as $u){ ?>
                                    <tr>
                                        <td>
                                            <span class="col-md-6 fa-stack fa-lg"><a href="{{ URL() }}/accounts/updateaccount/{{ $u->id }}" title="Update User Account"><i class="fa fa-edit fa-stack-1x fa-inverse"></i></a></span>
                                        </td>
                                        <td>{{ $u->username }}</td>
                                        <td>{{ $u->last_name }}</td>
                                        <td>{{ $u->first_name }}</td>
                                        <td>@if(!empty($u->user_class)) {{ $u->user_class }} @else {{ "No Information." }} @endif</td>
                                        <td>{{ $u->user_type }}</td>
                                        <td>
                                            <input type="checkbox"<?php if($u->username=="root") echo "disabled" ?> @if($u->status==1) {{ "checked" }} @endif name="activate-deactivate" onchange="changeStatus({{ $u->id }})" />
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <div class="row">
	                            <div class="pagination center">
	                                 @if($users->links()!=null)
	                                    {{ $users->links() }}
	                                 @endif
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
<script>
        function changeStatus(id){
                parent.location="{{ URL('accounts/changestatus') }}/"+id;
        }
</script>
</body>
</html>