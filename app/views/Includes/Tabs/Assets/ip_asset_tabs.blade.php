<li @if(isset($tab) && $tab=="IP") class="active" @endif><a href="{{ URL() }}/assets/IP">IP Assets</a></li>
@if(Session::get("user_type")!="User")
<li style="float:right;margin-right:-2px" @if(isset($tab) && $tab=="search") class="active" @endif><a href="{{ URL() }}/assets/IP/advancedsearch">Advanced Search</a></li>
@else
<li style="float:right;margin-right:-2px" @if(isset($tab) && $tab=="search") class="active" @endif><a href="{{ URL() }}/assets/IP/advancedsearch">Advanced Search</a></li>
@endif
