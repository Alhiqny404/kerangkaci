<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">

  <title><?php echo $title; ?> &mdash; </title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?= base_url('stisla/'); ?>assets/modules/bootstrap/css/bootstrap.min.css">

  <link rel="stylesheet" href="<?= base_url('stisla/'); ?>assets/modules/fontawesome/css/all.min.css">
  <link rel="stylesheet" href="<?= base_url('stisla/'); ?>assets/modules/izitoast/css/iziToast.min.css">
  <script src="<?= base_url('stisla/'); ?>assets/modules/sweetalert/sweetalert.min.js"></script>
  <script src="<?= base_url('stisla/'); ?>assets/modules/izitoast/js/iziToast.min.js"></script>
  <!-- Template CSS -->
  <link rel="stylesheet" href="<?= base_url('stisla/'); ?>assets/css/style.css">
  <link rel="stylesheet" href="<?= base_url('stisla/'); ?>assets/css/components.css">
  <!-- Start GA -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
  <script src="<?= base_url('stisla/'); ?>assets/modules/jquery.min.js"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-94034622-3');
  </script>
  <!-- /END GA -->
</head>