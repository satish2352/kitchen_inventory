@if(session('user_role') == '1')
@include('layouts.sidebar.superadmin')
@elseif(session('user_role') == '2')
@include('layouts.sidebar.admin')
@elseif(session('user_role') == '3')
@include('layouts.sidebar.manager')
@endif

   