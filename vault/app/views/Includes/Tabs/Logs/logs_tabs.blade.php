@if(Session::get("user_type")=="User")
<li @if(isset($tab) && $tab=="system") class="active" @endif><a href="{{ URL() }}/logs/system">Employees Logs</a></li>
@else
<li @if(isset($tab) && $tab=="system") class="active" @endif><a href="{{ URL() }}/logs/system">System Logs</a></li>
@endif
<li @if(isset($tab) && $tab=="assets") class="active" @endif><a href="{{ URL() }}/logs/assets">Assets Logs</a></li>
<li @if(isset($tab) && $tab=="software") class="active" @endif><a href="{{ URL() }}/logs/softwareassets">Software Assets Logs</a></li>
<li @if(isset($tab) && $tab=="ip") class="active" @endif><a href="{{ URL() }}/logs/ipassets">IP Assets Logs</a></li>

