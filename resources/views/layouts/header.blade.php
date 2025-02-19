<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8" />
      <!-- <link rel="manifest" href="/manifest.json"> -->
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />

      <!-- Add to homescreen for Chrome on Android -->
      <meta name="mobile-web-app-capable" content="yes">
      <meta name="application-name" content="PWA">
      <link rel="icon" sizes="512x512" href="/public/icons/icon-512x512.png">

      <link href="{{asset('/public/icons/splash-640x1136.png') }}" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
      <link href="{{asset('/public/icons/splash-750x1334.png') }}" media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
      <link href="{{asset('/public/icons/splash-1242x2208.png') }}" media="(device-width: 621px) and (device-height: 1104px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
      <link href="{{asset('/public/icons/splash-1125x2436.png') }}" media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
      <link href="{{asset('/public/icons/splash-828x1792.png') }}" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
      <link href="{{asset('/public/icons/splash-1242x2688.png') }}" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
      <link href="{{asset('/public/icons/splash-1536x2048.png') }}" media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
      <link href="{{asset('/public/icons/splash-1668x2224.png') }}" media="(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
      <link href="{{asset('/public/icons/splash-1668x2388.png') }}" media="(device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
      <link href="{{asset('/public/icons/splash-2048x2732.png') }}" media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
      <link href="{{asset('/public/icons/splash-2048x2732.png') }}" media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />


      <link rel="apple-touch-icon" href="/public/icons/icon-512x512.png">
      <meta name="apple-mobile-web-app-capable" content="yes">
      <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
      <meta name="apple-mobile-web-app-title" content="Buffalo Boss">


<link rel="manifest"  href="manifest.json">
<!-- Tile for Win8 -->
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="/images/icons/icon-512x512.png">

      <title></title>
      <link
         href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
         rel="stylesheet"
         />
      <!-- Bootstrap Icons -->
      <link
         href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"
         rel="stylesheet"
         />
      <link rel="stylesheet" href="{{ asset('css/dashboard.css')}}" />
      <link rel="stylesheet" href="{{ asset('css/shopping-list.css')}}" />
      <link rel="stylesheet" href="{{ asset('css/style.css')}}" />
      <!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" /> -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
      <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script> -->




   </head>
   <style>
  .error-text {
  color: red;
  font-size: 12px;
}

.is-invalid {
  border-color: red;
}

.is-valid {
  border-color: green;
}

/* Ensure table layout is consistent */
.table {
    table-layout: fixed;
    width: 100%;
}

/* Align table headers and data */
.table th, .table td {
    text-align: center;
    vertical-align: middle;
}

/* Center the input inside the td */
.qty-input-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
}

/* Style input to align properly */
.qty-input {
    width: 80%;
    text-align: center;
    padding: 5px;
    justify-self: center;
}


</style>
   <body>

   


