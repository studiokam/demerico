<!doctype html>
<html class="no-js" lang="pl">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title><?= $title ?></title>
  <meta name="description" content="Typer dla kilku znajomych :)">
  <meta name="viewport" content="width=device-width, initial-scale=1">
 <!--  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"> -->
  <!-- <link rel="stylesheet" href="https://bootswatch.com/4/sandstone/bootstrap.min.css"> -->
  <!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/shards.css"> -->
  <link href="https://fonts.googleapis.com/css?family=Rajdhani:400,600,700|Signika:400,700|Ubuntu:400,400i,500i,700" rel="stylesheet"> 
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bs.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/mp.css">



  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/chung-timepicker.js" type="text/javascript" charset="utf-8"></script>

</head>

<body>

    <nav class="navbar fixed-topp navbar-dark bg-primary">
        <!-- <a class="navbar-brand" href="<?php echo base_url(); ?>terminarz"><span class="logo">deme</span><span class="logo">Rico</span></a> -->
        <a class="navbar-brand" href="<?php echo base_url(); ?>terminarz"><img src="<?php echo base_url().'assets/images/1.png'; ?>" width="40px"></a>
        <ul class="menu">
            <li><a href="<?php echo base_url(); ?>terminarz">Typuj</a></li>
            <li><a href="<?php echo base_url(); ?>ranking">Ranking</a></li>
            
            <?php if ($this->session->userdata('logged_in')): ?>
            <li><a href="<?php echo base_url(); ?>moje">Moje typy</a></li>
            <li><a href="<?php echo base_url(); ?>konto">Konto</a></li>
            <?php endif ?>
            <?php if (!$this->session->userdata('logged_in')): ?>
            <li class="nav-item">
                <a href="<?php echo base_url(); ?>users/login">Zaloguj</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo base_url(); ?>users/register">Rejestruj</a>
            </li>
            <?php endif ?>

        </ul>
    </nav>
    

    <!-- submenu -->
    <?php if ($this->session->userdata('admin') == 1): ?>
    <nav class="navbar navbar-dark bg-danger mb-4">
        <a class="navbar-brand" href="#">Admin: <?php echo date('Y-m-d H:i:s', time()); ?></a>      
       
        <ul class="menu">
          <li><a href="<?php echo base_url(); ?>admin/ligi">Ligi</a></li>
          <li><a href="<?php echo base_url(); ?>admin/grupyspotkan">Mecze</a></li>
        </ul>

    </nav>
    <?php endif ?>
    <?php if ($this->session->userdata('admin') != 1): ?>
        <div class="mt-40"></div>
    <?php endif ?>
            
     

    <div class="container">    
        <!-- flash message success -->
          <?php if ($this->session->flashdata('success')): ?>
            <p class="alert alert-success mt-20">
              <?php echo $this->session->flashdata('success'); ?>
            </p>    
          <?php endif ?>

          <!-- flash message error -->
          <?php if ($this->session->flashdata('error')): ?>
            <p class="alert alert-danger mt-20">
              <?php echo $this->session->flashdata('error'); ?>
            </p>    
          <?php endif ?>
    </div>
