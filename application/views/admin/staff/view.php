<section id="main-content">
    <section class="wrapper">

        <div class="row">
            <div class="col-lg-12">

                <ul class="breadcrumb">
                    <li><a href="<?= base_url() ?>index.php/admin"><i class="fa fa-home"></i> Admin</a></li>
                    <li><a href="#">Staff Management</a></li>
                    <li class="active">view</li>
                </ul>

            </div>
        </div>

        <div class="row">

            <div class="col-lg-12">
                <section class="panel">
                    <div class="panel-body">
                        <ul class="summary-list">

                            <li>
                                <a href="#myModal3" data-toggle="modal">
                                    <i class="fa fa-tags text-success"></i>
                                    User Data
                                </a>
                            </li>

                            <?php if ($can_update_role) { ?>

                                <li>
                                    <a href="#role_dialogue" data-toggle="modal">
                                        <i class="fa fa-tags text-success"></i>
                                        Role
                                    </a>
                                </li>

                            <?php } ?>
                            <?php if ($can_update_group) { ?>
                                <li>
                                    <a href="#group_dialogue" data-toggle="modal">
                                        <i class="fa fa-tags text-success"></i>
                                        Group
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ($can_update_department) { ?>

                                <li>
                                    <a href="#department_dialogue" data-toggle="modal">
                                        <i class="fa fa-tags text-success"></i>
                                        Department
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if ($can_reset_password) { ?>

                                <li>
                                    <a id="reset_password" href="#">
                                        <i class="fa fa-tags text-success"></i>
                                        Reset User Password
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if ($can_delete_user) { ?>

                                <li>
                                    <a id="delete_user" href="#">
                                        <i class="fa fa-tags text-success"></i>
                                        Delete User
                                    </a>
                                </li>
                            <?php } ?>

                           

                            <?php if ($can_delete_user) { ?>
                            <li>
                                <!-- < ?php foreach($acct as $acc):?> -->
                                <!-- < ?php var_dump($acct)?> -->
                                <?php if($acct['account_status'] === "A"){?>
                                <a id="disenable_user" href="#">
                                <i class="fa fa-tags text-success"></i>
                                Disable User
                                </a>
                                    <?php } else{?>
                                <a id="enable_user" href="#">
                                <i class="fa fa-tags text-success"></i>
                                Enable User
                                </a>
                                <?php }?>
                                <!-- < ?php endforeach?> -->
                            </li>
                            <?php } ?>
                            
                        </ul>
                    </div>
                </section>
            </div>
        </div>
        </div>
        </div>


        <div class="row">
            <div class="col-lg-4">

                <section class="panel">
                    <div class="twt-feed blue-bg">
                        <h1><?php echo ucfirst($staff['first_name']) . " " . ucfirst($staff['middle_name']) . " " . ucfirst($staff['last_name']); ?></h1>

                        <p><?php echo $staff['staff_no']; ?></p>
                        <a href="#">
                            <?php if (isset($pic) && !empty($pic)) { ?>
                                <img src="<?= base_url() ?>assets/img/profiles/<?php echo $pic['picture']; ?>" alt="">
                            <?php } else { ?>
                                <img src="" alt="">
                            <?php } ?>
                        </a>
                    </div>
                    <div class="weather-category twt-category">
                        <ul>
                            <li class="active">
                                <h5><?php echo $age; ?></h5>
                                Age
                            </li>
                            <li>
                                <h5><?php if (sizeof($department) > 1) echo $department['name']; ?></h5>
                                Department
                            </li>
                            <li>
                                <h5><?php echo $dob; ?></h5>
                                Date Of Birth
                            </li>
                        </ul>
                    </div>
                    <hr/>
                    <div class="weather-category twt-category">
                        <ul>
                            <li class="active">
                                <h5><?php echo ucfirst($staff['sex']); ?></h5>
                                Sex
                            </li>
                            <li>
                                <h5><?php if (sizeof($role) > 1) echo $role['role_name']; ?></h5>
                                Role
                            </li>
                            <li>
                                <h5><?php echo $group['name']; ?></h5>
                                Group
                            </li>
                        </ul>
                    </div>


                    <div class="twt-write col-sm-12">

                    </div>
                    <footer class="twt-footer">


                    </footer>


                </section>


            </div>


            <div class="col-lg-8">

                <aside class="profile-info col-lg-12">

                    <section class="panel">

                        <div class="panel-body bio-graph-info">
                            <h3>Staff Number : <?php echo $staff['staff_no']; ?></h3>
                            <hr/>
                            <div class="row">
                                <div class="bio-row">
                                    <p><span>First Name </span>: <?php echo ucfirst($staff['first_name']); ?></p>
                                </div>
                                <div class="bio-row">
                                    <p><span>Last Name </span>: <?php echo ucfirst($staff['last_name']); ?></p>
                                </div>

                                <div class="bio-row">
                                    <p><span>Birthday</span>: <?php echo ucfirst($staff['dob']); ?></p>
                                </div>
                                <div class="bio-row">
                                    <p><span>Role </span>: <?php echo ucfirst($role['role_name']); ?></p>
                                </div>
                                <div class="bio-row">
                                    <p><span>Email </span>: <?php echo $staff['email']; ?></p>
                                </div>
                                <div class="bio-row">
                                    <p><span>Mobile </span>: <?php echo ucfirst($staff['mobile_number']); ?></p>
                                </div>
                                <div class="bio-row">
                                    <p><span>Phone </span>: <?php echo ucfirst($staff['cell_number']); ?></p>
                                </div>
                            </div>
                        </div>

                    </section>


                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="datauser"
                         class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">
                                        &#10006;</button>
                                    <h4 class="modal-title">Staff data</h4>
                                </div>
                                <div class="modal-body">
                                    <a id="viewdata" href="#datauser" data-toggle="modal"></a>

                                    <section class="panel">
                                        <header class="panel-heading tab-bg-dark-navy-blue "
                                                style="background: #00A8B3; height: 38px;">
                                            <ul class="nav nav-tabs">
                                                <li class="active">
                                                    <a data-toggle="tab" href="#home">Personal</a>

                                                </li>
                                                <li class="">
                                                    <a data-toggle="tab" href="#about">Address</a>
                                                </li>
                                            </ul>
                                        </header>
                                        <div class="panel-body">
                                            <div class="tab-content">
                                                <div id="home" class="tab-pane active">

                                                    <form name="personal_form" method="post"
                                                          action="<?= base_url() ?>index.php/staff/updatePersonalData">


                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">First Name</label>
                                                            <input type="text" class="form-control"
                                                                   value="<?php echo ucfirst($staff['first_name']); ?>"
                                                                   name="first_name" id="first_name"
                                                                   placeholder="First Name">
                                                            <input type="hidden" name="staff_no"
                                                                   value="<?php echo $staff['staff_no']; ?>"/>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Middle Name</label>
                                                            <input type="text" class="form-control"
                                                                   value="<?php echo ucfirst($staff['middle_name']); ?>"
                                                                   name="middle_name" id="middle_name"
                                                                   placeholder="Middle Name">

                                                        </div>


                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Last Name</label>
                                                            <input type="text" class="form-control"
                                                                   value="<?php echo ucfirst($staff['last_name']); ?>"
                                                                   name="last_name" id="last_name"
                                                                   placeholder="Last Name">

                                                        </div>


                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Date Of Birth</label>
                                                            <input name="dob" id="dob"
                                                                   class="form-control form-control-inline input-medium default-date-picker"
                                                                   size="16" type="text"
                                                                   value="<?php if (isset($dob)) echo $dob; ?>"/>
                                                        </div>


                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Marital Status</label>
                                                            <select class="form-control" name="marital_status"
                                                                    id="marital_status">


                                                                <option <?php if ($staff['marital_status'] == "M") echo "selected='selected'" ?>
                                                                    value="M">Married
                                                                </option>
                                                                <option <?php if ($staff['marital_status'] == "S") echo "selected='selected'" ?>
                                                                    value="S">Single
                                                                </option>

                                                            </select>

                                                        </div>

                                                        <input type="hidden" name="staff_no" value="<?php echo $staff['staff_no']; ?>"/>

                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Mobile Number</label>
                                                            <input name="mobile_number" id="mobile_number"
                                                                   value="<?php if (isset($staff['mobile_number'])) echo $staff['mobile_number']; ?>"
                                                                   type="text" placeholder=""
                                                                   data-mask="(999) 999-9999-999" class="form-control">
                                                            <span class="help-inline">(234) 809-9999-999</span>
                                                        </div>


                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Cell Number</label>
                                                            <input name="cell_number" id="cell_number"
                                                                   value="<?php if (isset($staff['cell_number'])) echo $staff['cell_number']; ?>"
                                                                   type="text" placeholder=""
                                                                   data-mask="(999) 999-9999-999" class="form-control">
                                                            <span class="help-inline">(234) 809-9999-999</span>
                                                        </div>


                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Email</label>
                                                            <input type="text" class="form-control"
                                                                   value="<?php echo strtolower($staff['email']); ?>"
                                                                   name="email" id="email" placeholder="Email">

                                                        </div>

                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Alternate Email</label>
                                                            <input type="text" class="form-control"
                                                                   value="<?php echo strtolower($staff['alt_email']); ?>"
                                                                   name="alt_email" id="alt_email"
                                                                   placeholder="Alt Email">

                                                        </div>


                                                        <button type="button" id="update_personal"
                                                                class="btn btn-default"
                                                                onclick="javascript:updatePersonal();">Update
                                                        </button>

                                                        <script>

                                                            function updatePersonal() {

                                                                var error = false;
                                                                //code
                                                                var firstname = $.trim($("input#first_name").val());
                                                                var lastname = $.trim($("input#last_name").val());


                                                                if (lastname == "") {
                                                                    //code

                                                                    error = true;
                                                                    alert("First Name Cannot be empty");
                                                                }

                                                                if (lastname == "") {
                                                                    //code
                                                                    error = true;

                                                                    alert("Last Name Cannot be empty");
                                                                }

                                                                if (error) {
                                                                    //code
                                                                }
                                                                else {

                                                                   // alert($("form[name=personal_form]").attr("action"));
                                                                    $("form[name=personal_form]").submit();
                                                                }

                                                            }

                                                        </script>

                                                    </form>


                                                </div>

                                                <!--address data-->
                                                <div id="about" class="tab-pane">

                                                    <form name="address_update" method="post"
                                                          action="<?= base_url() ?>index.php/staff/updateAddressData">

                                                        <input type="hidden" name="staff_no" value="<?php echo $staff['staff_no']; ?>"/>
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Address Line 1</label>
                                                            <input type="text" class="form-control"
                                                                   value="<?php echo ucwords($staff['address_line_1']); ?>"
                                                                   name="address_line_1" id="address_line_1"
                                                                   placeholder="Address Line 1">
                                                            <input type="hidden" name="staff_no"
                                                                   value="<?php echo $staff['staff_no']; ?>"/>
                                                        </div>


                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Address Line 2</label>
                                                            <input type="text" class="form-control"
                                                                   value="<?php echo ucwords($staff['address_line_2']); ?>"
                                                                   name="address_line_2" id="address_line_2"
                                                                   placeholder="Address Line 2">

                                                        </div>


                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">State</label>
                                                            <select class="form-control" name="address_state_code"
                                                                    id="address_state_code">

                                                                <?php foreach ($address_states as $u) { ?>
                                                                    <?php if ($u['state_code'] == $staff['address_state_code']) { ?>
                                                                        <option value="<?php echo $u['state_code']; ?>"
                                                                                selected="selected"> <?php echo ucwords($u['state_name']); ?></option>

                                                                    <?php } else { ?>
                                                                        <option
                                                                            value="<?php echo $u['state_code']; ?>"> <?php echo ucwords($u['state_name']); ?></option>
                                                                    <?php } ?>
                                                                <?php } ?>

                                                            </select>

                                                        </div>


                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Country</label>
                                                            <select class="form-control" name="address_country_code"
                                                                    id="address_country_code">

                                                                <?php foreach ($countries as $u) { ?>
                                                                    <?php if ($u['country_code'] == $staff['address_country_code']) { ?>
                                                                        <option
                                                                            value="<?php echo $u['country_code']; ?>"
                                                                            selected="selected"> <?php echo ucwords($u['country_name']); ?></option>

                                                                    <?php } else { ?>
                                                                        <option
                                                                            value="<?php echo $u['country_code']; ?>"> <?php echo ucwords($u['country_name']); ?></option>
                                                                    <?php } ?>
                                                                <?php } ?>


                                                            </select>

                                                        </div>

                                                        <script>

                                                            $(document).ready(function () {
                                                                $('select#address_country_code').change(function () {

                                                                    $('input#get_country_code').val($(this).val());

                                                                    getStatesByCountry("select#address_state_code");
                                                                });
                                                            });

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

                                                        </script>

                                                        <button type="button" id="update_address"
                                                                class="btn btn-default"
                                                                onclick="javascript:updateAddress();">Update
                                                        </button>

                                                        <script>

                                                            function updateAddress() {
                                                                //code

                                                                $("form[name=address_update]").submit();
                                                            }
                                                        </script>
                                                    </form>


                                                </div>


                                            </div>
                                        </div>
                                    </section>


                                </div>
                            </div>
                        </div>
                    </div>


                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal3"
                         class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">
                                        &#10006;</button>
                                    <h4 class="modal-title">Select Data to Upload</h4>
                                </div>
                                <div class="modal-body">


                                    <div class=" state-overview">
                                        <section class="panel">
                                            <div class="symbol red" style="background:#66ff60;">
                                                <i class="fa fa-picture-o"></i>
                                            </div>
                                            <div class="value">
                                                <a href="#" id="picdata">
                                                    <h1>Picture Data</h1>
                                                </a>

                                                <p></p>
                                            </div>
                                        </section>
                                    </div>


                                    <div class=" state-overview">
                                        <section class="panel">
                                            <div class="symbol red" style="background:#66ff60;">

                                                <i class="fa fa-folder-open"></i>

                                            </div>
                                            <div class="value">
                                                <a href="#" id="userdata">
                                                    <h1>User Data</h1>
                                                </a>

                                                <p></p>
                                            </div>
                                        </section>
                                    </div>

                                    <script>
                                        $(document).ready(function () {

                                            $("#userdata").click(function () {

                                                $("button.close").click();
                                                $("a#viewdata").click();


                                            });


                                            $("#picdata").click(function () {

                                                $("button.close").click();
                                                $("a#viewpicdata").click();


                                            });

                                        });
                                    </script>

                                </div>
                            </div>
                        </div>
                    </div>


                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="picturedata"
                         class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">
                                        &#10006;</button>
                                    <h4 class="modal-title">Profile Picture</h4>
                                </div>
                                <div class="modal-body">

                                    <a id="viewpicdata" href="#picturedata" data-toggle="modal"></a>




                                    <?php /**echo form_open_multipart(base_url()."index.php/patient/uploadPatientPic");**/ ?>

                                    <form name="uploadstaffpic" enctype="multipart/form-data"
                                          action="<?= base_url() ?>index.php/staff/uploadStaffPic" method="post">
                                        <input type="hidden" id="staff_no" value="<?php echo $staff['staff_no']; ?>"
                                               name="staff_no"/>


                                        <div class="form-group">
                                            <label class="control-label col-md-3">Select Profile Picture</label>

                                            <div class="controls col-md-9">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
<span class="btn btn-white btn-file">
<span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select Picture</span>
<span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>

<input id="pic" type="file" name="userfile" size="20" class="default"/>

</span>
                                                    <span class="fileupload-preview" style="margin-left:5px;"></span>
                                                    <a href="#" class="close fileupload-exists"
                                                       data-dismiss="fileupload"
                                                       style="float: none; margin-left:5px;"></a>
                                                </div>
                                            </div>
                                        </div>


                                        <button type="button" id="upload" class="btn btn-default"
                                                onclick="javascript:uploadPic();">Upload
                                        </button>
                                    </form>

                                    <script>

                                        function uploadPic() {
                                            //code
                                            $("form[name=uploadstaffpic]").submit();
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal2"
                         class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">
                                        &#10006;</button>
                                    <h4 class="modal-title"><?php if (isset($vitals['date_created'])) { ?>Vital Readings. Taken on <?php echo $vitals['date_created']; ?><?php } else echo "No Previous Vital Reading" ?></h4>
                                </div>
                                <div class="modal-body">

                                    <?php if (isset($vitals['blood_pressure']) && $vitals['blood_pressure'] != "") { ?>
                                        <div class=" state-overview">
                                            <section class="panel">
                                                <div class="symbol red">
                                                    <i class="fa fa-heart"></i>
                                                </div>
                                                <div class="value">
                                                    <h1><?php foreach ($unit as $u) {
                                                            if ($u['id'] == $vitals['blood_pressure_unit']) {
                                                                echo $vitals['blood_pressure'] . " " . $u['symbol'];
                                                                break;
                                                            }
                                                        }
                                                        ?></h1>

                                                    <p>Systolic Blood Pressure</p>
                                                </div>
                                            </section>
                                        </div>
                                    <?php } ?>

                                    <?php if (isset($vitals['blood_presure_diastolic']) && $vitals['blood_presure_diastolic'] != "") { ?>
                                        <div class=" state-overview">
                                            <section class="panel">
                                                <div class="symbol red">
                                                    <i class="fa fa-heart"></i>
                                                </div>
                                                <div class="value">
                                                    <h1><?php foreach ($unit as $u) {
                                                            if ($u['id'] == $vitals['blood_pressure_unit']) {
                                                                echo $vitals['blood_presure_diastolic'] . " " . $u['symbol'];
                                                                break;
                                                            }
                                                        }
                                                        ?></h1>

                                                    <p>Diastolic Blood Pressure</p>
                                                </div>
                                            </section>
                                        </div>
                                    <?php } ?>
                                    <?php if (isset($vitals['temperature']) && $vitals['temperature'] != "") { ?>
                                        <div class=" state-overview">
                                            <section class="panel">
                                                <div class="symbol red">
                                                    <i class="fa fa-tags"></i>
                                                </div>
                                                <div class="value">
                                                    <h1><?php foreach ($unit as $u) {
                                                            if ($u['id'] == $vitals['temperature_unit']) {
                                                                echo $vitals['temperature'] . " " . $u['symbol'];
                                                                break;
                                                            }
                                                        }
                                                        ?></h1>

                                                    <p>Temperature</p>
                                                </div>
                                            </section>
                                        </div>
                                    <?php } ?>
                                    <?php if (isset($vitals['respiratory_rate']) && $vitals['respiratory_rate'] != "") { ?>

                                        <div class=" state-overview">
                                            <section class="panel">
                                                <div class="symbol red">
                                                    <i class="fa fa-tags"></i>
                                                </div>
                                                <div class="value">
                                                    <h1><?php foreach ($unit as $u) {
                                                            if ($u['id'] == $vitals['respiratory_rate_unit']) {
                                                                echo $vitals['respiratory_rate'] . " " . $u['symbol'];
                                                                break;
                                                            }
                                                        }
                                                        ?></h1>

                                                    <p>Respiratory Rate</p>
                                                </div>
                                            </section>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal4"
                         class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">
                                        &#10006;</button>
                                    <h4 class="modal-title">Queue Check In</div>
                                <div class="modal-body">


                                    <form id="enterQueue" method="post">


                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Deparment</label>
                                            <input type="hidden" id="patient_number"
                                                   value="<?php echo $patient['patient_number']; ?>"
                                                   name="patient_number"/>

                                            <select class="form-control" name="dept_id" id="dept_id">
                                                <option value=""></option>
                                                <?php foreach ($departments as $dept) { ?>
                                                    <option
                                                        value="<?php echo $dept['dept_id']; ?>"> <?php echo $dept['name']; ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>


                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Doctor</label>

                                            <select class="form-control" name="staff_no" id="staff_no">
                                                <option value=""></option>
                                                <?php foreach ($doctors as $doctor) { ?>
                                                    <option
                                                        value="<?php echo $doctor['staff_no']; ?>"> <?php echo $doctor['first_name'] . " " . $doctor['last_name']; ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>


                                        <button type="button" id="join_queue" class="btn btn-default"
                                                onclick="javascript:patientCheckIn();">Join Queue
                                        </button>
                                    </form>
                                    <script>

                                        function patientCheckInee() {

                                            var department = $("select#dept_id").val();


                                            var url = "<?= base_url() ?>" + "index.php/patient/queueCheckIn";


                                            if (department == "") {
                                                alert("Please Select a Department");
                                                return false;
                                            }


                                            $("button#join_queue").attr("disabled", "diisabled");
                                            $("button#join_queue").addClass("spinner");


                                            $.ajax({
                                                type: "post",
                                                url: url,
                                                cache: false,
                                                data: $('form#enterQueue').serialize(),
                                                success: function (json) {

                                                    try {
                                                        var obj = jQuery.parseJSON(json);
                                                        //alert( obj['STATUS']);
                                                        if (obj['STATUS'] == "true") {
                                                            //code
                                                            //  $("button.close").click();
                                                            alert("Patient sucessfully added to the queue with number :" + obj['NUMBER']);
                                                            $("button.close").click();

                                                        }
                                                        else {
                                                            alert(obj['ERROR']);

                                                        }


                                                    } catch (e) {
                                                        alert('Exception while request..here');

                                                    }
                                                },
                                                error: function () {
                                                    alert('Error while request..');
                                                }


                                            });

                                            $("button#join_queue").removeClass("spinner");

                                            $("button#join_queue").removeAttr("disabled");

                                        }
                                    </script>


                                </div>
                            </div>
                        </div>
                    </div>


                    <form id="addVital" name="addVital" action="<?= base_url() ?>index.php/patient/recordVital"
                          method="post">
                        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal"
                             class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">
                                            &#10006;</button>
                                        <h4 class="modal-title">New Vital Readings </h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Temperature</label>
                                            <input type="text" class="form-control" name="temperature" id="temperature"
                                                   placeholder="Temperature">
                                            <input type="hidden" id="patient_number"
                                                   value="<?php echo $patient['patient_number']; ?>"
                                                   name="patient_number"/>
                                            <br/>
                                            <select class="form-control" name="temperature_unit" id="temperature_unit">

                                                <?php foreach ($unit as $u) { ?>
                                                    <option
                                                        value=" <?php echo $u['id']; ?>"> <?php echo $u['unit_name']; ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Blood Pressure Systolic</label>
                                            <input type="text" class="form-control" name="blood_pressure"
                                                   id="blood_pressure" placeholder="Systolic">
                                            <br/>
                                            <select class="form-control" name="blood_pressure_unit"
                                                    id="blood_pressure_unit">

                                                <?php foreach ($unit as $u) { ?>
                                                    <option
                                                        value=" <?php echo $u['id']; ?>"> <?php echo $u['unit_name']; ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Blood Pressure Systolic</label>
                                            <input type="text" class="form-control" name="blood_pressure_diastolic"
                                                   id="blood_pressure_diastolic" placeholder="Diastolic">
                                            <br/>
                                            <select class="form-control" name="blood_pressure_unit"
                                                    id="blood_pressure_unit">

                                                <?php foreach ($unit as $u) { ?>
                                                    <option
                                                        value=" <?php echo $u['id']; ?>"> <?php echo $u['unit_name']; ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Pulse</label>
                                            <input type="text" class="form-control" name="pulse" id="pulse"
                                                   placeholder="Pulse">
                                            <br/>
                                            <select class="form-control" name="pulse_unit" id="pulse_unit">

                                                <?php foreach ($unit as $u) { ?>
                                                    <option
                                                        value=" <?php echo $u['id']; ?>"> <?php echo $u['unit_name']; ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Respiratory rate</label>
                                            <input type="text" class="form-control" name="respiratory_rate"
                                                   id="respiratory_rate" placeholder="Respiratory rate">
                                            <br/>
                                            <select class="form-control" name="respiratory_rate_unit"
                                                    id="respiratory_rate_unit">

                                                <?php foreach ($unit as $u) { ?>
                                                    <option
                                                        value=" <?php echo $u['id']; ?>"> <?php echo $u['unit_name']; ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>


                                        <button type="button" id="save" class="btn btn-default"
                                                onclick="javascript:update_vital();">Save
                                        </button>
                    </form>
            </div>
        </div>
        </div>
        </div>

        </form>


        <!------------------------------              begining of change department dialogue box              ---------------->

        <form name="changeDept" id="changeDept" method="post"
              action="<?= base_url() ?>index.php/admin/updateDepartment">


            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="department_dialogue"
                 class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">
                                &#10006;</button>
                            <h4 class="modal-title">Department</h4>
                        </div>
                        <div class="modal-body">


                            <div class="form-group">
                                <label for="exampleInputEmail1">Department</label>

                                <input type="hidden" value="<?php echo $staff['staff_no']; ?>" name="staff_no"/>

                                <select class="form-control" type="text" name="dept_id" id="update_dept_id">
                                    <?php foreach ($departments as $d) { ?>

                                        <option value="<?php echo $d['dept_id']; ?>"
                                                <?php if ($staff['dept_id'] == $d['dept_id']){ ?>selected="selected"<?php } ?>><?php echo ucfirst($d['name']); ?></option>
                                    <?php } ?>
                                </select>


                            </div>


                            <button id="update_dept" type="button" class="btn btn-default">Change</button>


                            <script>

                                $(document).ready(function () {

                                    $("button#update_dept").click(function () {
                                        changeDept();
                                    });

                                });
                                function changeDept() {

                                    $("form#changeDept").submit();
                                }


                            </script>


                        </div>
                    </div>
                </div>
            </div>
        </form>


        <form name="admin_function" id="admin_function" method="post" action="">
            <input type="hidden" name="staff_no"
                   value="<?php echo $staff['staff_no']; ?>"/>
        </form>
        <!------------------------------              begining of change usergroup dialogue box              ---------------->

        <form name="changeGrp" id="changeGrp" method="post" action="<?= base_url() ?>index.php/admin/updateGroup">


            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="group_dialogue"
                 class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">
                                &#10006;</button>
                            <h4 class="modal-title">Group</h4>
                        </div>
                        <div class="modal-body">


                            <div class="form-group">
                                <label for="exampleInputEmail1">Group</label>

                                <input type="hidden" value="<?php echo $staff['staff_no']; ?>" name="staff_no"/>

                                <select class="form-control" type="text" name="group_id" id="update_group_id">
                                    <?php foreach ($groups as $d) { ?>

                                        <option value="<?php echo $d['user_group_id']; ?>"
                                                <?php if ($staff['group_id'] == $d['user_group_id']){ ?>selected="selected"<?php } ?>><?php echo ucfirst($d['name']); ?></option>
                                    <?php } ?>
                                </select>


                            </div>


                            <button id="update_grp" type="button" class="btn btn-default">Change</button>


                            <script>

                                $(document).ready(function () {

                                    $("button#update_grp").click(function () {
                                        changeGroup();
                                    });

                                });
                                function changeGroup() {

                                    $("form#changeGrp").submit();
                                }


                            </script>


                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!------------------------------              begining of change role dialogue box              ---------------->

        <form name="changeRole" id="changeRole" method="post" action="<?= base_url() ?>index.php/admin/updateRole">


            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="role_dialogue"
                 class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">
                                &#10006;</button>
                            <h4 class="modal-title">Role</h4>
                        </div>
                        <div class="modal-body">


                            <div class="form-group">
                                <label for="exampleInputEmail1">Role</label>

                                <input type="hidden" value="<?php echo $staff['staff_no']; ?>" name="staff_no"/>

                                <select class="form-control" type="text" name="role_id" id="update_role_id">
                                    <?php foreach ($roles as $r) { ?>

                                        <option value="<?php echo $r['role_id']; ?>"
                                                <?php if ($staff['role_id'] == $r['role_id']){ ?>selected="selected"<?php } ?>><?php echo ucfirst($r['role_name']); ?></option>
                                    <?php } ?>
                                </select>


                            </div>


                            <button id="update_role" type="button" class="btn btn-default">Change</button>


                            <script>

                                $(document).ready(function () {

                                    $("button#update_role").click(function () {
                                        changeRole();
                                    });

                                });
                                function changeRole() {

                                    $("form#changeRole").submit();
                                }


                            </script>


                        </div>
                    </div>
                </div>
            </div>
        </form>


        <form id="schedule" name="schedule" method="post">
            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal6"
                 class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">
                                &#10006;</button>
                            <h4 class="modal-title">Schedule Appointment</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Doctor</label>

                                <select class="form-control" name="staff_no" id="staff_no">
                                    <option value=""></option>
                                    <?php foreach ($doctors as $doctor) { ?>
                                        <option
                                            value="<?php echo $doctor['staff_no']; ?>"> <?php echo $doctor['first_name'] . " " . $doctor['last_name']; ?></option>
                                    <?php } ?>

                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Reason For Appointment</label>
                                <input type="text" class="form-control" name="reason" id="reason" placeholder="">

                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Date</label>
                                <input name="date" id="date"
                                       class="form-control form-control-inline input-medium default-date-picker"
                                       size="16" type="text"
                                       value=""/>
                                <span class="help-block">Select Appointment date</span>
                                <input type="hidden" id="patient_number"
                                       value="<?php echo $patient['patient_number']; ?>" name="patient_number"/>

                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Appointment time</label>

                                <div class="col-md-4">
                                    <div class="input-group bootstrap-timepicker">
                                        <input type="text" class="form-control timepicker-24" name="time">
<span class="input-group-btn">
<button class="btn btn-default" type="button"><i class="fa fa-clock-o"></i></button>
</span>
                                    </div>
                                </div>
                            </div>


                            <button type="button" id="save" class="btn btn-default"
                                    onclick="javascript:schedule_appointment();">Schedule
                            </button>
        </form>
        </div>
        </div>
        </div>
        </div>


        </form>

        <script>
            function schedule_appointment() {

                var url = "<?= base_url() ?>" + "index.php/patient/scheduleAppointment";
                // alert("test");
                var reason = $("#reason").val();
                var time = $("form#schedule input[name=time]").val();
                var staff_no = $("form#schedule select#staff_no").val();
                var date = $("form#schedule input#date").val();

                var error = false;
                if (time == "") {
                    alert("please select a valid appointment time");
                    error = true;
                }

                if (staff_no == "") {
                    alert("please select the consulting doctor");
                    error = true;
                }

                if (date == "") {
                    alert("please select a valid date");
                    error = true;
                }

                if (!error) {
                    $("button#join_queue").attr("disabled", "diisabled");
                    $("button#join_queue").addClass("spinner");


                    $.ajax({
                        type: "post",
                        url: url,
                        cache: false,
                        data: $('form#schedule').serialize(),
                        success: function (json) {

                            try {
                                var obj = jQuery.parseJSON(json);
                                //alert( obj['STATUS']);
                                if (obj['STATUS'] == "true") {
                                    //code
                                    //  $("button.close").click();
                                    alert("Appointment Sucessfully Scheduled");
                                    $("button.close").click();

                                }
                                else {
                                    alert(obj['ERROR']);

                                }


                            } catch (e) {
                                alert('Exception while request..here');

                            }
                        },
                        error: function () {
                            alert('Error while request..');
                        }


                    });

                    $("button#join_queue").removeClass("spinner");

                    $("button#join_queue").removeAttr("disabled");
                }
            }
            function update_vital() {
                var temperature = $("#temperature").val();
                var respiratory_rate = $("#respiratory_rate").val();
                var pulse = $("#pulse").val();
                var blood_pressure = $("#blood_pressure").val();

                if (temperature == "" && respiratory_rate == "" && pulse == "" && blood_pressure == "") {
                    alert("please fill at least one vital field");

                }
                else {
                    //alert($("#patient_number").val());
                    $("form#addVital").submit();
                }
            }


        </script>


        </aside>


        </div>


        </div>


        <form id="getStates" method="post">
            <input type="hidden" name="country_code" id="get_country_code" value=""/>
        </form>


    </section>
</section>
<script>


    $(document).ready(function () {


        $("a#reset_password").click(function () {

            var url = "<?= base_url() ?>index.php/admin/resetPassword";

            var confirmed = confirm("Do you want to reset the password of the selected user ?");

            if (confirmed) {

                $("form#admin_function").attr("action", url);
                $("form#admin_function").submit();

            }
        });

        $("a#disable_password").click(function () {

            var url = "<?= base_url() ?>index.php/admin/disPassword";

            var confirmed = confirm("Do you want to reset the password of the selected user ?");

            if (confirmed) {

                $("form#admin_function").attr("action", url);
                $("form#admin_function").submit();

            }
            });

        $("a#delete_user").click(function () {

            var url = "<?= base_url() ?>index.php/admin/deleteUser";

            var confirmed = confirm("Are you sure you want to delete the selected user ?");

            if (confirmed) {

                $("form#admin_function").attr("action", url);
                $("form#admin_function").submit();

            }
        });

        $("a#disenable_user").click(function () {

            var url = "<?= base_url() ?>index.php/admin/disenableUser";

            var confirmed = confirm("Are you sure you want to Disable this selected user ?");

            if (confirmed) {

                $("form#admin_function").attr("action", url);
                $("form#admin_function").submit();

                }
            });

            $("a#enable_user").click(function () {

            var url = "<?= base_url() ?>index.php/admin/enableUser";

            var confirmed = confirm("Are you sure you want to Enable this selected user ?");

            if (confirmed) {

            $("form#admin_function").attr("action", url);
            $("form#admin_function").submit();

            }
            });

        <?php
        
        
            if(isset($alert))
            {
                echo "alert('".$alert."');";
            }
            
        
        ?>

    });
</script>

<script src="<?= base_url() ?>assets/assets/fullcalendar/fullcalendar/fullcalendar.min.js"></script>