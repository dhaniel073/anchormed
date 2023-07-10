<section id="main-content">
    <section class="wrapper">

        <div class="row" style="min-height: 600px;">


            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Patient Creation Form
<span class="tools pull-right">
<a href="javascript:;" class="fa fa-chevron-down"></a>
<a href="javascript:;" class="fa fa-times"></a>
</span>
                    </header>
                    <div class="panel-body">

                        <!-- begining of form section-->
                        <section class="panel">

                            <div class="panel-body">
                                <div class="stepy-tab">
                                    <ul id="default-titles" class="stepy-titles clearfix">
                                        <li id="default-title-0" class="current-step">
                                            <div>Step 1</div>
                                        </li>
                                        <li id="default-title-1" class="">
                                            <div>Step 2</div>
                                        </li>
                                        <li id="default-title-2" class="">
                                            <div>Step 3</div>
                                        </li>
                                    </ul>
                                </div>
                                <!--form class="form-horizontal" id="default"-->

                                <?php echo validation_errors(); ?>

                                <?php echo form_open('patient/add') ?>


                                <fieldset title="Step 1" class="step" id="default-step-0">
                                    <legend></legend>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">First Name</label>
                                        <div class="col-lg-10">
                                            <input name="first_name"
                                                   value="<?php if (isset($first_name)) echo $first_name; ?>"
                                                   id="first_name" type="text" class="form-control"
                                                   placeholder="First Name">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Middle Name</label>
                                        <div class="col-lg-10">
                                            <input name="middle_name"
                                                   value="<?php if (isset($middle_name)) echo $middle_name; ?>"
                                                   id="middle_name" type="text" class="form-control"
                                                   placeholder="Middle Name">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Last Name</label>
                                        <div class="col-lg-10">
                                            <input name="last_name" id="last_name"
                                                   value="<?php if (isset($last_name)) echo $last_name; ?>" type="text"
                                                   class="form-control" placeholder="Last Name">
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-lg-2 control-label" for="inputSuccess">Sex</label>
                                        <div class="col-lg-10">
                                            <select name="sex" id="sex" class="form-control m-bot15">
                                                <option value="F">Female</option>
                                                <option value="M">Male</option>

                                                <script>
                                                    <?php if(isset($sex)){?>
                                                    $(document).ready(function () {

                                                        $("select#sex").val("<?php echo $sex;?>");
                                                    });
                                                    <?php }?>

                                                </script>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Date Of Birth</label>
                                        <div class="col-md-3 col-xs-11">
                                            <input name="dob" id="dob"
                                                   class="form-control form-control-inline input-medium default-date-picker"
                                                   size="16" type="text"
                                                   value="<?php if (isset($dob)) echo $dob; ?>"/>
                                            <span class="help-block">Select date</span>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Email Address</label>
                                        <div class="col-lg-10">
                                            <input name="email" id="email"
                                                   value="<?php if (isset($email)) echo $email; ?>" type="text"
                                                   class="form-control" placeholder="Email Address">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Alt Email Address</label>
                                        <div class="col-lg-10">
                                            <input name="alt_email" id="alt_email"
                                                   value="<?php if (isset($alt_email)) echo $alt_email; ?>" type="text"
                                                   class="form-control" placeholder="Alt Email Address">
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Mobile Number</label>
                                        <div class="col-sm-10">
                                            <input name="mobile_number" id="mobile_number"
                                                   value="<?php if (isset($mobile_number)) echo $mobile_number; ?>"
                                                   type="text" placeholder="" data-mask="(999) 999-9999-999"
                                                   class="form-control">
                                            <span class="help-inline">(234) 809-9999-999</span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Cell Number</label>
                                        <div class="col-sm-10">
                                            <input name="cell_number"
                                                   value="<?php if (isset($cell_number)) echo $cell_number; ?>"
                                                   id="cell_number" type="text" placeholder=""
                                                   data-mask="(999) 999-9999-999" class="form-control">
                                            <span class="help-inline">(234) 809-9999-999</span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-2 control-label" for="inputSuccess">Marrital Status</label>
                                        <div class="col-lg-10">
                                            <select name="marital_status" id="marital_status"
                                                    class="form-control m-bot15">
                                                <?php
                                                foreach ($marital_stats as $m_stats) {
                                                    ?>
                                                    <option
                                                        value="<?php echo $m_stats['marital_status']; ?>"><?php echo ucfirst($m_stats['description']); ?></option>
                                                    <?php

                                                }
                                                ?>

                                                <script>
                                                    <?php if(isset($marital_status)){?>
                                                    $(document).ready(function () {

                                                        $("select#marital_status").val("<?php echo $marital_status;?>");
                                                    });
                                                    <?php }?>

                                                </script>

                                            </select>
                                        </div>


                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-2 control-label" for="inputSuccess">Religion</label>
                                        <div class="col-lg-10">
                                            <select name="religion_id" id="religion_id" class="form-control m-bot15">
                                                <?php
                                                foreach ($religions as $religion) {
                                                    echo "<option value='" . $religion['religion_id'] . "'>" . ucfirst($religion['religion_name']) . "</option>";
                                                }
                                                ?>

                                                <script>
                                                    <?php if(isset($religion_id)){?>
                                                    $(document).ready(function () {

                                                        $("select#religion_id").val("<?php echo $religion_id;?>");
                                                    });
                                                    <?php }?>

                                                </script>

                                            </select>

                                            <a href="#myModal" data-toggle="modal" class="btn btn-xs btn-success">
                                                Add New Religion
                                            </a>

                                        </div>


                                    </div>


                                    <div class="form-group">
                                        <label class="col-lg-2 control-label" for="inputSuccess">Occupation</label>
                                        <div class="col-lg-10">
                                            <select name="occupation_id" id="occupation_id"
                                                    class="form-control m-bot15">
                                                <?php
                                                foreach ($occupations as $occupation) {
                                                    echo "<option value='" . $occupation['occupation_id'] . "'>" . ucfirst($occupation['occupation_name']) . "</option>";
                                                }
                                                ?>

                                                <script>
                                                    <?php if(isset($occupation_id)){?>
                                                    $(document).ready(function () {

                                                        $("select#occupation_id").val("<?php echo $occupation_id;?>");
                                                    });
                                                    <?php }?>

                                                </script>

                                            </select>

                                            <a href="#myModal2" data-toggle="modal" class="btn btn-xs btn-success">
                                                Add New Occupation
                                            </a>

                                        </div>

                                    </div>


                                    <div class="form-group">
                                        <label class="col-lg-2 control-label" for="inputSuccess">Country Of
                                            Origin</label>
                                        <div class="col-lg-10">
                                            <select name="orign_country_code" id="orign_country_code"
                                                    class="form-control m-bot15">
                                                <?php
                                                foreach ($countries as $country) {
                                                    echo "<option value='" . $country['country_code'] . "'>" . ucfirst($country['country_name']) . "</option>";
                                                }
                                                ?>

                                                <script>

                                                    <?php if(isset($orign_country_code)){?>
                                                    $(document).ready(function () {

                                                        $("select#orign_country_code").val("<?php echo $orign_country_code;?>");
                                                    });
                                                    <?php }?>

                                                </script>

                                            </select>

                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-lg-2 control-label" for="inputSuccess">State Of Origin</label>
                                        <div class="col-lg-10">
                                            <select name="state_of_origin" id="state_of_origin"
                                                    class="form-control m-bot15">

                                                <script>


                                                </script>

                                            </select>

                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-lg-2 control-label" for="inputSuccess">Local Government Of
                                            Origin</label>
                                        <div class="col-lg-10">
                                            <select name="origin_lga_id" id="origin_lga_id"
                                                    class="form-control m-bot15">

                                                <script>
                                                    <?php if(isset($origin_lga_id)){?>
                                                    $(document).ready(function () {

                                                        $("select#origin_lga_id").val("<?php echo $origin_lga_id;?>");
                                                    });
                                                    <?php }?>

                                                </script>
                                            </select>

                                        </div>
                                    </div>


                                </fieldset>
                                <fieldset title="Step 2" class="step" id="default-step-1">
                                    <legend></legend>


                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Address</label>
                                        <div class="col-lg-10">
                                            <input name="address_line_1"
                                                   value="<?php if (isset($address_line_1)) echo $address_line_1; ?>"
                                                   id="address_line_1" type="text" class="form-control"
                                                   placeholder="Address">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Address Line 2</label>
                                        <div class="col-lg-10">
                                            <input name="address_line_2"
                                                   value="<?php if (isset($address_line_2)) echo $address_line_2; ?> "
                                                   id="address_line_2" type="text" class="form-control"
                                                   placeholder="Address Line 2">
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-lg-2 control-label" for="inputSuccess">Resident
                                            Country</label>
                                        <div class="col-lg-10">
                                            <select name="address_country_code" id="address_country_code"
                                                    class="form-control m-bot15">
                                                <?php
                                                foreach ($countries as $country) {
                                                    echo "<option value='" . $country['country_code'] . "'>" . ucfirst($country['country_name']) . "</option>";
                                                }
                                                ?>


                                                <script>
                                                    <?php if(isset($address_country_code)){?>
                                                    $(document).ready(function () {

                                                        $("select#address_country_code").val("<?php echo $address_country_code;?>");
                                                    });
                                                    <?php }?>

                                                </script>


                                            </select>

                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-lg-2 control-label" for="inputSuccess">Resident State</label>
                                        <div class="col-lg-10">
                                            <select name="address_state_code" id="address_state_code"
                                                    class="form-control m-bot15">

                                                <script>


                                                </script>
                                            </select>

                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-lg-2 control-label" for="inputSuccess">File Type</label>
                                        <div class="col-lg-10">
                                            <select name="patient_type_code" id="patient_type_code"
                                                    class="form-control m-bot15">
                                                <?php
                                                foreach ($patient_types as $type) {
                                                    echo "<option value='" . $type['patient_type_code'] . "'>" . ucfirst($type['patient_type_name']) . "</option>";
                                                }
                                                ?>

                                                <script>
                                                    <?php if(isset($patient_type_code)){?>
                                                    $(document).ready(function () {

                                                        $("select#patient_type_code").val("<?php echo $patient_type_code;?>");
                                                    });
                                                    <?php }?>

                                                </script>

                                            </select>

                                        </div>
                                    </div>


                                    <div class="form-group" id="hmo">
                                        <label class="col-lg-2 control-label" for="inputSuccess">HMO</label>
                                        <div class="col-lg-10">
                                            <select name="hmo_id" id="hmo_id" class="form-control m-bot15">
                                                <option></option>
                                                <?php
                                                foreach ($hmo as $h) {
                                                    echo "<option value='" . $h['hmo_code'] . "'>" . ucfirst($h['hmo_name']) . "</option>";
                                                }
                                                ?>

                                                <script>
                                                    <?php if(isset($hmo_id)){?>
                                                    $(document).ready(function () {

                                                        $("select#hmo_id").val("<?php echo $hmo_id;?>");
                                                    });
                                                    <?php }?>

                                                </script>

                                            </select>

                                            <script>

                                                var standardnumber = "<?php echo date("Y") . "S" . ($counters['standard'] + 1);?>";
                                                var familynumber = "<?php echo date("Y") . "F" . ($counters['family'] + 1);?>";
                                                var hmonumber = "<?php echo($counters['hmo'] + 1);?>";
                                                var yearString = "<?php echo date("Y");?>";


                                                $(document).ready(function () {
                                                    $("#e_addy").html($("#email").val());

                                                    $("#ph").html($("#mobile_number").val());


                                                    //hide the enrole div
                                                    $("#enrolee_number_field").hide();

                                                    var fullnames = $("#first_name").val() + " " + $("#middle_name").val() + " " + $("#last_name").val();
                                                    $("#full_name").html(fullnames);


                                                    $("#first_name,#last_name,#middle_name").change(function () {

                                                        var fullname = $("#first_name").val() + " " + $("#middle_name").val() + " " + $("#last_name").val();
                                                        $("#full_name").html(fullname);
                                                    });

                                                    $("#email").change(function () {

                                                        $("#e_addy").html((this).val());
                                                    });

                                                    $("#mobile_number").change(function () {

                                                        $("#ph").html((this).val());
                                                    });

                                                    $("#patient_number, #f_no").val(familynumber);
                                                    $("#f_no").html(familynumber);

                                                    <?php if(isset($patient_number)){?>


                                                    $("input#patient_number").val("<?php echo $patient_number;?>");
                                                    $("#f_no").html("<?php echo $patient_number;?>");

                                                    <?php }?>



                                                    $("div#hmo").hide();

                                                    $("#hmo_id").change(function () {

                                                        var newnumber = yearString + $(this).val() + hmonumber;
                                                        $("#patient_number, #f_no").val(newnumber);
                                                        $("#f_no").html(newnumber);

                                                    });

                                                    var patienttype = $("select#patient_type_code").val();

                                                    if (patienttype == "H") {

                                                        $("div#hmo").show();
                                                    }

                                                    $("select#patient_type_code").change(function () {

                                                        if ($(this).val() == "H") {

                                                            $("div#hmo").show();
                                                            var newnumber = yearString + $("#hmo_id").val() + hmonumber;
                                                            $("#patient_number, #f_no").val(newnumber);
                                                            $("#f_no").html(newnumber);
                                                            $("#enrolee_number_field").show();

                                                        }
                                                        else {
                                                            if ($(this).val() == "S") {
                                                                $("#patient_number, #f_no").val(standardnumber);
                                                                $("#f_no").html(standardnumber);
                                                            }

                                                            if ($(this).val() == "F") {
                                                                $("#patient_number, #f_no").val(familynumber);
                                                                $("#f_no").html(familynumber);
                                                            }
                                                            $("div#hmo").hide();
                                                            $("#enrolee_number_field").hide();
                                                        }

                                                    });
                                                });
                                            </script>

                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">File Number</label>
                                        <div class="col-lg-10">
                                            <input disabled="disabled" name="patient_number" id="patient_number"
                                                   type="text" class="form-control" placeholder="File Number">
                                        </div>
                                    </div>

                                        <div class="form-group" id="hmo">
                                            <label class="col-lg-2 control-label">HMO Enrolled Number</label>
                                            <div class="col-lg-10">
                                                <input name="enrolle_id" id="enrolle_id"
                                                       type="text" class="form-control" placeholder="HMO Enrolled Number">
                                            </div>


                                        </div>
										
																			
										
										<div class="form-group" id="hmo">
                                            <label class="col-lg-2 control-label">Primary Enrolled Number</label>
                                            <div class="col-lg-10">
                                                <input name="pri_enrolle_id" id="pri_enrolle_id"
                                                       type="text" class="form-control" placeholder="Primary Enrolled Number">
                                            </div>


                                        </div>
										
										
										<div class="form-group" id="hmo">
											<label class="col-lg-2 control-label" for="inputSuccess">Relationship to Primary Enrollee</label>
												<div class="col-lg-10">
													<select name="rel_to_primary_enrollee" id="rel_to_primary_enrollee" class="form-control m-bot15">
														<option></option>
														<?php
														foreach ($relationships as $h) {
															echo "<option value='" . $h['relationship_id'] . "'>" . ucfirst($h['relationship_name']) . "</option>";
														}
														?>
													</select>
												</div>
										</div>


                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">File Type Classification</label>
                                            <div class="col-lg-10">
                                                <select class="form-control" name="free_code_1" id="free_code_1" required>
                                                    <option value=""></option>
                                                    <?php foreach ($freecodes as $code) { ?>
                                                        <option
                                                            value="<?php echo $code["id"]; ?>"><?php echo ucfirst($code["name"]); ?></option>
                                                    <?php } ?>

                                                </select>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Free Code 2</label>
                                            <div class="col-lg-10">
                                                <select class="form-control" name="free_code_2" id="free_code_2">
                                                    <option value=""></option>
                                                    <?php foreach ($freecodes2 as $code) { ?>
                                                        <option
                                                            value="<?php echo $code["id"]; ?>"><?php echo ucfirst($code["name"]); ?></option>
                                                    <?php } ?>

                                                </select>
                                            </div>
                                        </div>


                                </fieldset>
                                <fieldset title="Step 3" class="step" id="default-step-2">
                                    <legend></legend>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Full Name</label>
                                        <div class="col-lg-10">
                                            <p class="form-control-static" id="full_name"></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Email Address</label>
                                        <div class="col-lg-10">
                                            <p class="form-control-static" id="e_addy">

                                            </p>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Phone</label>
                                        <div class="col-lg-10">
                                            <p class="form-control-static" id="ph"></p>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">File Number</label>
                                        <div class="col-lg-10">
                                            <p class="form-control-static" id="f_no"></p>
                                        </div>
                                    </div>


									<div class="row">
										<div class="col-md-6">
											<div id="my_camera"></div>
											<br/>
											<input type=button value="Take Snapshot" onClick="take_snapshot()">
											<input type="hidden" name="image" class="image-tag">
										</div>
										<div class="col-md-6">
											<div id="results">Your captured image will appear here...</div>
										</div>
										<div class="col-md-12 text-center">
											<br/>
											
										</div>
									</div>


                                </fieldset>
                                <input type="submit" class="finish btn btn-danger" id="finish" value="Finish"/>
                                </form>
                            </div>
                        </section>
                        <!-- end of form section-->
                    </div>
                </section>
            </div>


        </div>


    </section>
</section>


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
                <h4 class="modal-title">Define New Religion</h4>
            </div>
            <div class="modal-body">
                <form role="form" id="add-new-religon" name="add-new-religon" method="post" action="text.php">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Religion name</label>
                        <input type="text" class="form-control" name="religion_name" id="religion_name"
                               placeholder="Enter Religion Name">
                    </div>
                    <div id="religion-create-error"></div>
                    <button type="button" id="add-religion" class="btn btn-default"
                            onclick="javascript:makeAjaxCall();">Add Religion
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal2" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
                <h4 class="modal-title">Define New Occupation</h4>
            </div>
            <div class="modal-body">
                <form role="form" id="add-new-occupation" name="add-new-occupation" method="post" action="text.php">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Occupation name</label>
                        <input type="text" class="form-control" name="occupation_name" id="occupation_name"
                               placeholder="Enter Occupation Name">
                    </div>
                    <div id="occupation-create-error"></div>
                    <button type="button" id="add-occupation" class="btn btn-default"
                            onclick="javascript:makeOccAjaxCall();">Add Occupation
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<form id="getReligions"></form>

<!-- for add religon function-->

<form id="getStates">

    <input type="hidden" name="country_code" id="country_code_input"/>
</form>

<form id="getlgas">

    <input type="hidden" name="state_code" id="state_code_input"/>
</form>


<script src="<?=base_url() ?>assets/js/webcam.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
 
 <script language="JavaScript">
    Webcam.set({
        width: 225,
        height: 175,
        image_format: 'jpeg',
        jpeg_quality: 90
    });
  
    Webcam.attach( '#my_camera' );
  
    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            $(".image-tag").val(data_uri);
            document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
        } );
    }
</script>

<script>
    $(document).ready(function () {
        $("div#religion-create-error").hide();

        $("input#finish").click(function () {
            $("input#patient_number").removeAttr("disabled");

        });

    });

    var url = "<?= base_url() ?>" + "index.php/religion/addNewReligion";

    var selectitem = "";

    function getReligionList() {


        var url = "<?= base_url() ?>" + "index.php/religion/getReligionsJson";

        $.ajax({
            type: "post",
            url: url,
            cache: false,
            data: $('form#getReligions').serialize(),
            success: function (json) {
                try {
                    var obj = jQuery.parseJSON(json);
                    //alert( obj['STATUS']);

                    $('#religion_id')
                        .find('option')
                        .remove()
                        .end()
                    //.append('<option value="whatever">text</option>')
                    //.val('whatever')
                    ;
                    var arrayLength = obj.length;
                    for (var i = 0; i < arrayLength; i++) {
                        var newoption = "<option  style='text-transform: capitalize' value='" + obj[i]['religion_id'] + "'>" + obj[i]['religion_name'] + "</option>";
                        if (obj[i]['religion_name'].toLowerCase() == selectitem.toLowerCase()) {
                            //code
                            $('#religion_id').append(newoption).val(obj[i]['religion_id']);
                        }
                        else {
                            $('#religion_id').append(newoption);
                        }
                        //Do something
                    }


                } catch (e) {
                    alert('Exception while request..');
                }
            },
            error: function () {
                alert('Error while request..');
            }

        });
    }

    function makeAjaxCall() {


        var religon_name = $('form#add-new-religon input#religion_name').val();

        if (religon_name == "") {
            alert("Please enter religion name");
            return false;
        }

        selectitem = religon_name;


        $("button#add-religion").attr("disabled", "diisabled");
        $("input#religion_name").addClass("spinner");
        $("div#religion-create-error").hide();
        $.ajax({
            type: "post",
            url: url,
            cache: false,
            data: $('form#add-new-religon').serialize(),
            success: function (json) {
                try {
                    var obj = jQuery.parseJSON(json);
                    //alert( obj['STATUS']);
                    if (obj['STATUS'] == "true") {
                        //code
                        $("button.close").click();
                        getReligionList();
                    }
                    else {
                        $("div#religion-create-error").html("<p align='center'>" + obj['ERROR'] + "</p>").show();

                    }


                } catch (e) {
                    alert('Exception while request..');
                }
            },
            error: function () {
                alert('Error while request..');
            }


        });

        $("input#religion_name").removeClass("spinner");

        $("button#add-religion").removeAttr("disabled");
    }
</script>


<!-- for add occupation function-->

<script>

    function getStatesOfOrigin(country_code) {

        $("input#country_code_input").val(country_code);
        var selectid = "#state_of_origin";
        getStatesByCountry(selectid);

    }

    function getAddStatesOfOrigin(country_code) {

        $("input#country_code_input").val(country_code);
        var selectid = "#address_state_code";
        getStatesByCountry(selectid);

    }

    function getLgasOfOrigin(state_code) {

        $("input#state_code_input").val(state_code);
        var selectid = "#origin_lga_id";
        getLgasByState(selectid);

    }

    function getLgasByState(selectid) {
        var obj = "";
        var url = "<?= base_url() ?>" + "index.php/lga/getLgasByStateJson";


        $.ajax({
            type: "post",
            url: url,
            cache: false,
            data: $('form#getlgas').serialize(),
            success: function (json) {
                try {
                    obj = jQuery.parseJSON(json);

                    //return obj;

                    $(selectid)
                        .find('option')
                        .remove()
                        .end()
                    //.append('<option value="whatever">text</option>')
                    //.val('whatever')
                    ;
                    var arrayLength = obj.length;
                    for (var i = 0; i < arrayLength; i++) {
                        var newoption = "<option  style='text-transform: capitalize' value='" + obj[i]['lga_id'] + "'>" + obj[i]['lga_name'] + "</option>";

                        $(selectid).append(newoption);
                        //Do something

                    }

                } catch (e) {
                    alert('Exception while request..');
                }
            },
            error: function () {
                alert('Error while request..');
            }

        });


    }


    function getStatesByCountry(selectid) {
        var obj = "";
        var url = "<?= base_url() ?>" + "index.php/state/getStatesByCountryJson";


        $.ajax({
            type: "post",
            url: url,
            cache: false,
            data: $('form#getStates').serialize(),
            success: function (json) {
                try {
                    obj = jQuery.parseJSON(json);

                    //return obj;

                    $(selectid)
                        .find('option')
                        .remove()
                        .end()
                    //.append('<option value="whatever">text</option>')
                    //.val('whatever')
                    ;
                    var arrayLength = obj.length;
                    for (var i = 0; i < arrayLength; i++) {
                        var newoption = "<option  style='text-transform: capitalize' value='" + obj[i]['state_code'] + "'>" + obj[i]['state_name'] + "</option>";

                        $(selectid).append(newoption);

                        //fix to make lga work too
                        if (i == 0) {
                            $("input#state_code_input").val(obj[i]['state_code']);
                        }
                        //Do something
                        $('#origin_lga_id')
                            .find('option')
                            .remove()
                            .end();

                        //if has submitted before
                        <?php if(isset($state_of_origin)){?>


                        $("select#state_of_origin").val("<?php echo $state_of_origin;?>");

                        <?php }?>

                        <?php if(isset($address_state_code)){?>


                        $("select#address_state_code").val("<?php echo $address_state_code;?>");

                        <?php }?>

                        getLgasOfOrigin($("input#state_code_input").val());
                    }

                } catch (e) {
                    alert('Exception while request..');
                }
            },
            error: function () {
                alert('Error while request..');
            }

        });


    }


    $(document).ready(function () {
        $("div#occupation-create-error").hide();


        getAddStatesOfOrigin($("select#address_country_code").val());
        getStatesOfOrigin($("select#orign_country_code").val());


        $("select#address_country_code").change(function () {

            //clear the states and lga drop down

            $('#address_state_code')
                .find('option')
                .remove()
                .end();

            getAddStatesOfOrigin($(this).val());


            //make ajax call to get the states

        });


        $("select#orign_country_code").change(function () {

            //clear the states and lga drop down

            $('#state_of_origin, #origin_lga_id')
                .find('option')
                .remove()
                .end();

            getStatesOfOrigin($(this).val());


            //make ajax call to get the states

        });

        $("select#state_of_origin").change(function () {

            //clear the states and lga drop down


            $('#origin_lga_id')
                .find('option')
                .remove()
                .end();

            getLgasOfOrigin($(this).val());


            //make ajax call to get the states

        });

    });


    var selectoccitem = "";

    function getOccupationList() {


        var url = "<?= base_url() ?>" + "index.php/occupation/getOccupationsJson";

        $.ajax({
            type: "post",
            url: url,
            cache: false,
            data: $('form#getOccupations').serialize(),
            success: function (json) {
                try {
                    var obj = jQuery.parseJSON(json);
                    //alert( obj['STATUS']);

                    $('#occupation_id')
                        .find('option')
                        .remove()
                        .end()
                    //.append('<option value="whatever">text</option>')
                    //.val('whatever')
                    ;
                    var arrayLength = obj.length;
                    for (var i = 0; i < arrayLength; i++) {
                        var newoption = "<option  style='text-transform: capitalize' value='" + obj[i]['occupation_id'] + "'>" + obj[i]['occupation_name'] + "</option>";
                        if (obj[i]['occupation_name'].toLowerCase() == selectoccitem.toLowerCase()) {
                            //code
                            $('#occupation_id').append(newoption).val(obj[i]['occupation_id']);
                        }
                        else {
                            $('#occupation_id').append(newoption);
                        }
                        //Do something
                    }


                } catch (e) {
                    alert('Exception while request..');
                }
            },
            error: function () {
                alert('Error while request..');
            }

        });
    }

    function makeOccAjaxCall() {

        var url = "<?= base_url() ?>" + "index.php/occupation/addNewOccupation";


        var occupation_name = $('form#add-new-occupation input#occupation_name').val();

        if (occupation_name == "") {
            alert("Please enter Occupation name");
            return false;
        }

        selectoccitem = occupation_name;


        $("form#add-new-occupation button#add-occupation").attr("disabled", "diisabled");
        $("form#add-new-occupation input#occupation_name").addClass("spinner");
        $("div#occupation-create-error").hide();


        $.ajax({
            type: "post",
            url: url,
            cache: false,
            data: $('form#add-new-occupation').serialize(),
            success: function (json) {
                try {
                    var obj = jQuery.parseJSON(json);
                    //alert( obj['STATUS']);
                    if (obj['STATUS'] == "true") {
                        //code
                        $("button.close").click();
                        getOccupationList();
                    }
                    else {
                        $("div#occupation-create-error").html("<p align='center'>" + obj['ERROR'] + "</p>").show();

                    }


                } catch (e) {
                    alert('Exception while request..');
                }
            },
            error: function () {
                alert('Error while request..');
            }


        });

        $("form#add-new-occupation input#occupation_name").removeClass("spinner");

        $("form#add-new-occupation button#add-occupation").removeAttr("disabled");
    }
</script>
<script src="<?= base_url() ?>assets/js/jquery.stepy.js"></script>


<script>

    //step wizard

    $(function () {
        $('#default').stepy({
            backLabel: 'Previous',
            block: true,
            nextLabel: 'Next',
            titleClick: true,
            titleTarget: '.stepy-tab'
        });
    });
</script>