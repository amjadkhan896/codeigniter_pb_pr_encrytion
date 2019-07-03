<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>List pincodes</title>

    <!-- Bootstrap core CSS -->
    <link href="https://v4-alpha.getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="https://v4-alpha.getbootstrap.com/examples/dashboard/dashboard.css" rel="stylesheet">
  <!--  <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">-->
</head>


<body>
<nav class="navbar navbar-toggleable-md navbar-inverse fixed-top bg-inverse">
    <button class="navbar-toggler navbar-toggler-right hidden-lg-up" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#">Dashboard</a>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">

        </ul>

    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <nav class="col-sm-3 col-md-2 hidden-xs-down bg-faded sidebar">
            <ul class="nav nav-pills flex-column">

                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('/pincode/upload_pincodes') ?>">Upload Pincodes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('/pincode') ?>">List Pincodes</a>
                </li>

            </ul>

        </nav>

        <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
            <h1>List Pincodes</h1>
           <div class="table-responsive">

               <form class="form-inline" action="/pincode" method="get">
                   <div class="form-group mb-2">
                       <input class="form-control " name="search_input" type="text" placeholder="Search using pincode" aria-label="Search">
                   </div>
                   &nbsp;&nbsp;
                   <button type="submit" class="btn btn-secondary mb-2">Search</button>
               </form>


                <table class="table table-striped" id="example">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Serial No</th>
                        <th>Pincode</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    $CI =& get_instance();

                if(count($pincodes) >0){
                    foreach ($pincodes as $key=>$val){

                        $CI->load->library('PublicPrivateKeyEncryption');

                        ?>

                    <tr>
                        <td><?php echo $key+1 ?></td>
                        <td><?php echo $val->serial_no ?></td>
                        <td><?php echo $CI->publicprivatekeyencryption->decrypt($val->pincode); ?></td>

                    </tr>
                    <?php }
                }else { ?>
                    <tr>
                        <td colspan="3">No records available</td>

                    </tr>
                    <?php } ?>

                    </tbody>
                </table>



               <nav aria-label="Page navigation example">
                   <?php echo $links ?>

               </nav>
            </div>
        </main>
    </div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<!--<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#example').DataTable();
    } );
</script>-->
</body>
</html>


