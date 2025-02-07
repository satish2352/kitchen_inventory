<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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