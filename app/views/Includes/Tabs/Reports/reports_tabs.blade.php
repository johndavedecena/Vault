<li @if(isset($tab) && $tab=="all") class="active" @endif><a href="{{ URL() }}/reports/allassets">All Assets</a></li>
<li @if(isset($tab) && $tab=="client") class="active" @endif><a href="{{ URL() }}/reports/clientassets">Client Assets</a></li>
<li @if(isset($tab) && $tab=="network") class="active" @endif><a href="{{ URL() }}/reports/networkassets">Network Assets</a></li>
<li @if(isset($tab) && $tab=="office") class="active" @endif><a href="{{ URL() }}/reports/officeassets">Office Assets</a></li>
<li @if(isset($tab) && $tab=="software") class="active" @endif><a href="{{ URL() }}/reports/softwareassets">Software Assets</a></li>
<li @if(isset($tab) && $tab=="employees") class="active" @endif><a href="{{ URL() }}/reports/employees">Employees</a></li>
