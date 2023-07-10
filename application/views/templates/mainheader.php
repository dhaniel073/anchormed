
<body class="full-width">
<section id="container" class="">
 
<header class="header white-bg">
<div class="navbar-header">
<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
<span class="fa fa-bars"></span>
</button>
 
<a href="<?=base_url()?>index.php/home" class="logo"><i class="fa fa-plus-square"></i> MEDI<span>PHIX</span><small> v 1.2</small></a>
 
<div class="horizontal-menu navbar-collapse collapse ">
<ul class="nav navbar-nav">
<li class="active"><a href="#"><?php

//if this is the module workbench
    if(isset($currentmodule['number']) && $currentmodule['number'] == 4)
    {
        echo ucfirst($user_role['role_name'])."'s WorkBench";
    }
    else
    {
        echo ucfirst($currentmodule['title']);
    }
    
    
    ?></a></li>
<li class="dropdown">
<a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#">Menu <b class=" fa fa-angle-down"></b></a>
<ul class="dropdown-menu">
<li><a href="<?= base_url() ?>index.php/workbench"">WorkBench</a></li>
<li><a href="<?= base_url() ?>index.php/frontdesk">Front Desk</a></li>
<li><a href="<?= base_url() ?>index.php/provider">HMO Central</a></li>
<li><a href="<?= base_url() ?>index.php/laboratory">Laboratory</a></li>
<li><a href="<?= base_url() ?>index.php/pharmacy">Pharmacy</a></li>
<li><a href="<?= base_url() ?>index.php/billing">Billing</a></li>
<li><a href="<?= base_url() ?>index.php/cashier">Cashier</a></li>
<li><a href="<?= base_url() ?>index.php/inpatient">In Patient</a></li>
<li><a href="<?= base_url() ?>index.php/reports">Reports</a></li>

</ul>
</li>

<?php
//settings module registered with id 1
    $module = 1;
    $authorised = FALSE;
    foreach($usermodules as $usermod)
    {
        if($usermod['module_id'] == $module)
        {
            $authorised = TRUE;
        }
    }
    
    if($authorised)
    {
?>

<li class="dropdown">
<a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#">System Settings <b class=" fa fa-angle-down"></b></a>
<ul class="dropdown-menu">
<li><a href="<?= base_url() ?>index.php/admin">Hospital Admin</a></li>
<li><a href="<?=base_url()?>index.php/upload">Data Upload</a></li>

</ul>
</li>

<?php } ?>



</ul>
</div>
<div class="nav notify-row" id="top_menu">
 
<ul class="nav top-menu">

 
 
<li id="header_inbox_bar" class="dropdown">
<a data-toggle="dropdown" class="dropdown-toggle" href="#">
<i class="fa fa-envelope-o"></i>
<span class="badge bg-important" message_counter="1">0</span>
</a>
<ul class="dropdown-menu extended inbox"  style="overflow-x: hidden; overflow-y:scroll; width:300px; height: 300px;">
<div class="notify-arrow notify-arrow-red"></div>

<li id="message_preview_header">
<p class="red">You have <span message_counter="1">0 </span> new message(s)</p>
</li>

<li>
<a href="#">See all messages</a>
</li>
</ul>
</li>
 
 
<li id="header_notification_bar" class="dropdown">
<a data-toggle="dropdown" class="dropdown-toggle" href="#">
<i class="fa fa-bell-o"></i>
<span class="badge bg-warning nofication_count" id="notif_main">0</span>
</a>
<ul class="dropdown-menu extended notification">
<div class="notify-arrow notify-arrow-yellow"></div>
<li>
<p class="yellow">You have <span class="nofication_count">0</span> new notifications</p>
</li>

<li>
<a href="#">
New Patient
<span class="small italic">10 mins</span>
</a>
</li>

 
</ul>
</div>
<script>
    
    $(document).keypress(function(e){
            var search_url = "<?=base_url()?><?php if(isset($search_url))echo $search_url?>";
           
            if (e.which == 13 && $.trim($("input#universal-search").val()) !="") {
               
               $("form#uni-search").attr("action",search_url).submit();
               
               //alert($("form#uni-search").attr("action"));
               
               
               
               
            }
        
        });
</script>

<div class="top-nav ">
<ul class="nav pull-right top-menu">
    
<li>
<?php if(isset($search_url)){?>
<form id="uni-search" method="post">
<input type="text" name="name" id="universal-search" class="form-control search" placeholder=" Search">
<?php if(isset($return_url)){ ?>
        <input type="hidden" name="return_url" value="<?php echo $return_url; ?>" >
    <?php }?>
<?php if(isset($return_base)){ ?>
        <input type="hidden" name="return_base" value="<?php echo $return_base; ?>" >
    <?php }?>
    
    </form>
<?php }?>
</li>

 
<li class="dropdown">
<a data-toggle="dropdown" class="dropdown-toggle" href="#">
<img alt="35" width="35" height="" src="<?= base_url() ?>assets/img/profiles/<?php echo $this->session->userdata('picture'); ?>">
<span class="username"><?php echo $this->session->userdata('username'); ?></span>
<b class="caret"></b>
</a>
<ul class="dropdown-menu extended logout">
<div class="log-arrow-up"></div>
<li><a href="#"><i class=" fa fa-suitcase"></i>Profile</a></li>
<li><a href="#"><i class="fa fa-cog"></i> Settings</a></li>
<li><a href="#"><i class="fa fa-bell-o"></i> Notification</a></li>
<li><a href="<?= base_url() ?>index.php/logout"><i class="fa fa-key"></i> Log Out</a></li>
</ul>
</li>
 
</ul>
</div>
</div>
</header>