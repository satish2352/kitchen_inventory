@if(session('user_role') == '1')
@include('layouts.sidebar.superadmin')
@elseif(session('user_role') == '2')
@include('layouts.sidebar.admin')
@elseif(session('user_role') == '3')
@include('layouts.sidebar.manager')
@endif


<style>
     /* Loader Style */
     #custome_loader {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .spinner-border {
            width: 3rem;
            height: 3rem;
        }
    </style>

    <!-- Loader -->
<div id="custome_loader" style="display:none">
    <div class="spinner-border text-light" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>

   