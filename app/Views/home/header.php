<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Bus | NewBus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <link rel="stylesheet" href="<?PHP ECHO BASE_URL();?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?PHP ECHO BASE_URL();?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?PHP ECHO BASE_URL();?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/home.css">
</head>

<body>
    


<main>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="<?=base_url()?>">NewBus</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="<?=BASE_URL()?>">Home</a>
        </li>
        <?php if ($isLoggedin==true): ?>
          <li class="nav-item">
          <a class="nav-link" href="<?=BASE_URL()?>tickets/">Tickets</a>
        </li> 
        <li class="nav-item">
          <a class="nav-link" href="<?=BASE_URL()?>refund">Refunded Tickets</a>
        </li>
         <li class="nav-item">
          <a class="nav-link" href="<?=BASE_URL()?>profile/">Profile</a>
        </li>
        <?php if ($role_id=='111'): ?>
          <li class="nav-item">
             <a class="nav-link" href="<?=BASE_URL()?>admin">Admin</a>
          </li>
          <?php endif;?>
        <?php endif;?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa-solid fa-circle-user"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
          <?php if ($isLoggedin==false): ?>

            <li><a class="dropdown-item" href="<?=BASE_URL()?>login#login">Login</a></li>
            <li><a class="dropdown-item" href="<?=BASE_URL()?>login#register">Register</a></li>
            <?php else:?>
                <li><a class="dropdown-item" href="<?=BASE_URL()?>logout">Log Out</a></li>
            <?php endif;?>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<?php foreach (['success', 'error', 'warning', 'info'] as $msg): ?>
    <?php if (session()->getFlashdata($msg)): ?>
        <div class="alert alert-<?= $msg ?>">
            <?= session()->getFlashdata($msg) ?>
        </div>
    <?php endif; ?>
<?php endforeach; ?>
