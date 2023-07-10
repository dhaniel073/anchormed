<html>

<head>
    <title><?php echo $page; ?></title>
</head>


<?php if($page == "home"){ ?>
<body >

I am a home page

</body>
<?php }else{ ?>

    <body>

    I am the index page

    </body>


<?php } ?>
</html>
<script src="<?= base_url() ?>assets/js/jquery.js"></script>

<script>

$(document).ready(function(){

    var welcomeMessage = "<?php echo "Welcome to ".$page ?>" + " finally";

    <?php /*if()*/ ?>

    alert(welcomeMessage);

});

</script>




