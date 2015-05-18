
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->helper('url');
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php $title ?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/bootswatch.min.css">
        <!-- estilo formulario -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> 
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    </head>

    <body>
        <?php (isset($log) && $log) ? $this->load->view('header') : $this->load->view('header_default'); ?>

        <form action="<?php echo base_url(); ?>User/doLogin" method="post" class="form-horizontal">
            <div class="container" style="height: 220px; width: 33%;">
                <fieldset>
                    <center><legend>Login de usuario</legend></center>
                <div class="form-group">
                    <label for="email" class="col-lg-2 control-label" style="text-align: left ">Email</label>
                    <div class="col-lg-10">
                        <input class="form-control" type="text" placeholder="Email" name="email" id="email"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-lg-2 control-label" >Password</label>
                    <div class="col-lg-10">
                        <input class="form-control" type="text" placeholder="Password" name="password" id="password"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        <button type="submit" class="btn btn-primary " value="Enter" name="whocares">Submit</button>
                        <a href="#">¿Desea registrarse?</a> 
                    </div>
                </div>
                </fieldset>
            </div>
            
        </form>

        <?php echo (isset($error) && $error == 1) ? $error_message : ""; ?>
        <?php $this->load->view('footer'); ?>
    </body>
</html>