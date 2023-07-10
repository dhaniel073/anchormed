<body class="login-body">
<div class="container">

    <form class="form-signin" id="login" action="" method="post">
        <h2 class="form-signin-heading">sign in now</h2>

        <div id="login-div" class="login-wrap">
            <input type="text" group="login" id="username" name="username" class="form-control" placeholder="User ID"
                   autofocus>
            <input type="password" group="login" id="password" name="password" class="form-control"
                   placeholder="Password">
            <label class="checkbox">
<span class="pull-right"><!--
<a data-toggle="modal" href="#myModal"> Forgot Password?</a>-->
</span>
            </label>

           <!-- <button style="margin-bottom: 10px" class="btn bnp-donation-btn"
                    type="button" ref="RZEGB3FMA5" >Contribute for State Fire disaster recovery</button>

-->

            <button class="btn btn-lg btn-login btn-block " id="login" type="button"
                    onclick="javascript:makeAjaxCall();">Sign in
            </button>
            <div id="login-error"></div>


        </div>

        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal"
             class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Forgot Password ?</h4>
                    </div>
                    <div class="modal-body">
                        <p>Enter your e-mail address below to reset your password.</p>
                        <input type="text" name="email" placeholder="Email" autocomplete="off"
                               class="form-control placeholder-no-fix">
                    </div>

                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>


                        <button class="btn btn-success" type="button">Submit</button>
                    </div>



                </div>
            </div>
        </div>

    </form>
</div>
<script src="<?= base_url() ?>assets/js/jquery.js"></script>
<!-- Jquery Validate PLugin -->
<script src="<?= base_url() ?>assets/js/jquery.validate.js"></script>
<script src="<?= base_url() ?>assets/isloading/jquery.isloading.min.js"></script>
<!--
<script src="http://159.122.189.172:9996/resources/js/donation.button.plugin.js?q=2"></script>
-->

<script>
    $(document).ready(function () {
       // $( "div#login-div" ).isLoading();
        $("div#login-error").hide();


    });

    var url = "<?= base_url() ?>" + "index.php/login/signin";

    $(document).keypress(function (e) {

        if (e.which == 13) {
            makeAjaxCall();
        }

    });

    function makeAjaxCall() {


     $.isLoading({ text: "Please Wait" });

        var username = $('input#username').val();
        var password = $('input#password').val();

        if (username == "") {
            alert("username cannot be empty");
            $.isLoading( "hide" );
            return false;
        }

        if (password == "") {
            alert("please supply the user password");
            $.isLoading( "hide" );
            return false;
        }


        $("button#login").attr("disabled", "diisabled");
        $("input[group=login]").addClass("spinner");
        $("div#login-error").hide();
        
        
        $.ajax({
            type: "post",
            url: url,
            cache: false,
            data: $('form#login').serialize(),
            success: function (json) {
                try {
                    var obj = jQuery.parseJSON(json);
                    //alert( obj['STATUS']);
                    if (obj['STATUS'] == "true") {
                        //code
                        location.replace("<?= base_url() ?>");
                    }
                    else {
                        $("div#login-error").html("<p align='center'>" + obj['ERROR'] + "</p>").show();

                        $.isLoading( "hide" );
                    }


                } catch (e) {
                    console.log('Exception while request..');
                    $.isLoading( "hide" );
                }
            },
            error: function () {
                console.log('Error while request..');
                $.isLoading( "hide" );
            }


        });

        $("input[group=login]").removeClass("spinner");

        $("button#login").removeAttr("disabled");
    }
</script>

</body>