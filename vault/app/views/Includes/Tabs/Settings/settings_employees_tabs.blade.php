<li @if(isset($tab) && $tab=="managers") class="active" @endif><a href="{{ URL() }}/settings/employees/managers">Managers</a></li>
<li @if(isset($tab) && $tab=="business_lines") class="active" @endif><a href="{{ URL() }}/settings/employees/businesslines">Business Lines</a></li>
<li @if(isset($tab) && $tab=="units") class="active" @endif><a href="{{ URL() }}/settings/employees/units">Units</a></li>
<li @if(isset($tab) && $tab=="phone") class="active" @endif><a href="{{ URL() }}/settings/employees/updatephonenumbers">Update Phone Numbers</a></li>