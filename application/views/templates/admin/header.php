<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="author" content="Hiren Macwan">
    <link rel="icon" href="<?php echo base_url('assets/img/favicon.ico'); ?>">
    <title><?= (isset($site_settings) && $site_settings['site_name'] != '') ? $site_settings['site_name'] : 'HM'  ?> | <?php echo $page_title ?></title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/plugins/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/plugins/Ionicons/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- flag-icon-css -->
    <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/plugins/flag-icon-css/css/flag-icon.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/plugins/daterangepicker/daterangepicker.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/css/adminlte.min.css">

    <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/css/style.css">

    <!-- jquery datatable -->
    <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/plugins/datatables/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/plugins/datatables/css/dataTables.jqueryui.min.css">
    <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/plugins/datatables/css/dataTables.bootstrap4.min.css">

    <!-- jQuery 3 -->
    <script src="<?php echo base_url('assets'); ?>/plugins/jquery/jquery.min.js"></script>

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">



</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <?php $this->load->view('templates/admin/header_menu'); ?>
        </nav>
        <!-- Left side column. contains the logo and sidebar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- sidebar: style can be found in sidebar.less -->
            <!-- Brand Logo -->
            <a href="<?php echo base_url(); ?>" class="brand-link">
                <!-- <img src="<?php echo base_url(); ?>/assets/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
                <img src="<?php echo base_url(); ?>/assets/img/company/<?= (isset($site_settings) && $site_settings['logo'] != '') ? $site_settings['logo'] : 'logo.png'; ?>" alt="Company Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light"><?= (isset($site_settings) && $site_settings['site_name'] != '') ? $site_settings['site_name'] : 'HM'  ?></span>
            </a>
            <div class="sidebar">
                <?php $this->load->view('templates/admin/sidebar_menu'); ?>
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark"><?php echo $page_title; ?></h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <?php
                                if (isset($breadcrumb) && !empty($breadcrumb)) {
                                    $b_size = sizeof($breadcrumb);
                                    $b_count = 1;
                                    foreach ($breadcrumb as $m_link => $m_name) {
                                        $is_home = '';
                                        if ($b_count == 1) {
                                            $is_home = '<i class="fa fa-dashboard"></i>';
                                        }
                                        if ($b_count == $b_size) {
                                ?>
                                            <li class="breadcrumb-item active"><?php echo $is_home . ' ' . ucwords($m_name); ?></li>
                                        <?php
                                        } else {
                                        ?>
                                            <li class="breadcrumb-item"><a href="<?= ($m_link != '') ? base_url($m_link) : base_url(); ?>"><?php echo $is_home . ' ' . ucwords($m_name); ?></a></li>
                                <?php
                                        }
                                        $b_count++;
                                    }
                                }
                                ?>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <?php if ($this->session->flashdata('error') || $this->session->flashdata('success') || $this->session->flashdata('message')) { ?>
                        <!-- <div class="row" style="margin:20px auto 0px; float:none;"> -->
                        <div class="row d-flex justify-content-center mb-2">
                            <div class="col-md-12">
                                <?php if ($this->session->flashdata('error')) { ?>
                                    <div class="alert alert-danger alert-dismissible" style="margin-bottom: 0px;">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Message!</strong> <?php echo $this->session->flashdata('error'); ?>
                                    </div>

                                <?php } ?>
                                <?php if ($this->session->flashdata('success')) { ?>
                                    <div class="alert alert-success alert-dismissible" style="margin-bottom: 0px;">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Message!</strong> <?php echo $this->session->flashdata('success'); ?>
                                    </div>

                                <?php } ?>

                                <?php if ($this->session->flashdata('message')) { ?>
                                    <div class="alert alert-warning alert-dismissible" style="margin-bottom: 0px;">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Message!</strong> <?php echo $this->session->flashdata('message'); ?>
                                    </div>

                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>