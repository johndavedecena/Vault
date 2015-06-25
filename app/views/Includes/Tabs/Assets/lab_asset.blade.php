<li @if(isset($tab) && $tab=="General Info") class="active" @endif><a href="{{ URL() }}/assets/IP">General Information</a></li>
<li @if(isset($tab) && $tab=="Usage Status") class="active" @endif><a href="{{ URL() }}/assets/IP">Usage Status</a></li>
<li @if(isset($tab) && $tab=="Reports") class="active" @endif><a href="{{ URL() }}/assets/IP">Reports</a></li>
@if(Session::get("user_type")!="User")
<li style="float:right;margin-right:-2px" @if(isset($tab) && $tab=="search") class="active" @endif><a href="{{ URL() }}/assets/IP/advancedsearch">Advanced Search</a></li>
@else
<li style="float:right;margin-right:-2px" @if(isset($tab) && $tab=="search") class="active" @endif><a href="{{ URL() }}/assets/IP/advancedsearch">Advanced Search</a></li>
@endif
