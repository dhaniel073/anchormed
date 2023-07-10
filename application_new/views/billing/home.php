<section id="main-content">
    <section class="wrapper">

        <div class="row">


            <div class="col-lg-12" style="margin-top:100px;margin-bottom:100px;">
                <section class="panel">
                    <header class="panel-heading">
                        Bill Management
<span class="tools pull-right">
<a href="javascript:;" class="fa fa-chevron-down"></a>
<a href="javascript:;" class="fa fa-times"></a>
</span>
                    </header>
                    <div class="panel-body" style="margin-top:50px;">

                        <script>
                            $(document).ready(function () {

                                console.log("checking for the patient number ");
                                console.log("<?php echo $this->session->userdata('patient_number'); ?>");
                            });
                        </script>

                        <div style="width:100%; text-align: center; margin-bottom:200px;">
                            <?php

                            $patient_number = $this->session->userdata('patient_number');
                            $patient_name = $this->session->userdata('patient_name');


                            if ($this->session->userdata('submit')) {
                                $data = $this->session->userdata('data');


                                if (isset($data['bill'])) {

                                    $patient_name = $data['patient_name'];
                                    $patient_number = $data['patient_number'];
                                    $bill_id = $data['bill']['bill_id'];
                                    $bill_name = $data['bill']['service_name'];
                                    $bill_description = $data['bill']['description'];
                                    $bill_unit_price = $data['bill']['unit_price'];
                                }

                                $this->session->unset_userdata('submit');
                                $this->session->unset_userdata('data');
                            }
                            $this->session->unset_userdata('patient_name');
                            $this->session->unset_userdata('patient_number');


                            if (isset($patient_number) && $patient_number != "") { ?>
                                <a href="#myModal" id="create-bill" data-toggle="modal">
                                    <div class="option-icon">
                                        <i class="fa fa-tags fa-5x"></i>

                                        <p>Raise A Bill</p>
                                        <script>

                                            $(document).ready(function () {
                                                <?php if(isset($patient_number) && $patient_number != ""){?>

                                                $("a#create-bill").click();
                                                <?php } ?>
                                            });
                                        </script>
                                    </div>
                                </a>
                            <?php }else{ ?>

                                <!--a id="bill_patient_search" href="#"-->
                                <a id="bill_patient_type_select" data-toggle="modal" href="#patient_select">
                                    <div class="option-icon">
                                        <i class="fa fa-tags fa-5x"></i>

                                        <p>Raise A Bill</p>

                                    </div>
                                </a>

                                <a id="bill_patient_search" href="#"></a>


                                <form id="patient_search" name="patient_search"
                                      action="<?= base_url() ?>index.php/patient/search" method="post">
                                    <input type="hidden" name="return_base"
                                           value="<?= base_url() ?>index.php/billing/patientbill"/>
                                    <input type="hidden" name="non_patient" value="false"/>
                                    <input type="hidden" name="walk_in_patient_name" id="walk_in_patient_name"
                                           value=""/>
                                </form>

                                <script>
                                    $(document).ready(function () {

                                        $("a#bill_patient_search").click(function () {
                                            $("form[name=patient_search]").submit();
                                        });

                                    });
                                </script>

                            <?php } ?>

                            <!--a  href="#patientSearch" data-toggle="modal" purpose="post" class="patient_function" url="<?= base_url() ?>index.php/billing/currentBill" >
     <div class="option-icon">
        <i class="fa fa-credit-card fa-5x"></i>
        <p>Post Bill</p>
        
    </div>
   </a-->

                            <a href="#reports" data-toggle="modal" upload="lga">
                                <div class="option-icon">
                                    <i class="fa fa-file-excel-o fa-5x"></i>

                                    <p>Reports</p>

                                </div>
                            </a>


                            <a href="#patientSearch" data-toggle="modal" purpose="print" class="patient_function"
                               url="<?= base_url() ?>index.php/billing/processedBills">
                                <div class="option-icon">
                                    <i class="fa fa-print fa-5x"></i>

                                    <p>Paid Bills</p>

                                </div>
                            </a>

                            <div class="option-icon">

                                <p>&nbsp;</p>

                            </div>


                        </div>

                    </div>
                </section>
            </div>


        </div>



        <form name="createBill" id="createBill" action="<?= base_url() ?>index.php/billing/create" method="post">
            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal"
                 class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">
                                &#10006;</button>
                            <h4 class="modal-title">Raise Bill</div>
                        <div class="modal-body" id="create-bill">


                            <div class="form-group">
                                <label for="exampleInputEmail1">Patient Name</label>
                                <input type="text" class="form-control" disabled="disabled" name="patient_name"
                                       value="<?php echo ucwords($patient_name); ?>" id="patient_name"
                                       placeholder="Name">
                                <input type="hidden" name="patient_number" value="<?php echo $patient_number; ?>"/>
                                <input type="hidden" name="patient_name" value="<?php echo $patient_name; ?>"/>
                                <input type="hidden" name="bill_id"
                                       value="<?php if (isset($bill_id)) echo $bill_id; ?>"/>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Department</label>

                                <input type="hidden" id="staff_no"
                                       value="<?php echo $this->session->userdata('staff_no'); ?>" name="staff_no"/>
                                <input type="hidden" id="return_url" value="index.php/billing/bill" name="return_url"/>
                                <br/>
                                <select class="form-control" name="dept_id" id="dept_id">

                                    <option value=""></option>
                                    <?php foreach ($departments as $department) { ?>
                                        <option
                                            value=" <?php echo $department['dept_id']; ?>"> <?php echo $department['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <a id="select_bill" href="#" class="btn btn-xs btn-success">
                                    Select Bill</a>
                                <script>

                                    $(document).ready(function () {

                                        $("a#select_bill").click(function () {
                                            $("form[name=createBill]").attr("action", "<?=base_url()?>index.php/billing/search").submit();
                                        });
                                    });
                                </script>

                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Service Name</label>

                                <input type="text" value="<?php if (isset($bill_name)) echo $bill_name; ?>"
                                       disabled="disabled" class="form-control" name="service_name" id="service_name"
                                       placeholder="Service Name">

                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Description</label>

                                <input type="text" disabled="disabled"
                                       value="<?php if (isset($bill_description)) echo $bill_description; ?>"
                                       class="form-control" name="description" id="desc" placeholder="Description">

                            </div>

                            <div class="form-group" id="unit_price_group">
                                <label for="exampleInputEmail1">Unit Price</label>
                                <input type="text" disabled="disabled"
                                       value="<?php if (isset($bill_unit_price)) echo $bill_unit_price; ?>"
                                       class="form-control" name="unit_price" id="unit_price" placeholder="Unit Price">

                            </div>


                            <div class="form-group">
                                <script>

                                    $(document).ready(function () {


                                        var serviceName = $("input#service_name").val();
                                        serviceName = serviceName.toLowerCase();


                                        if ($.trim(serviceName) == "deposit") {

                                            $("div#unit_price_group").hide();

                                            $("span#units_place_holder").html("Deposit Amount");
                                        }


                                        $("input#qty").change(function () {
                                            var isnumeric = $.isNumeric($(this).val());

                                            if (isnumeric) {
                                                //code
                                                $("input#total").val($("input#unit_price").val() * $(this).val());
                                            }
                                            else {
                                                $(this).val("1");
                                            }

                                        });
                                    });
                                </script>

                                <label for="exampleInputEmail1"><span
                                        id="units_place_holder">Number of Units</span></label>
                                <input type="text" class="form-control"
                                       value="<?php if (isset($bill_unit_price)) echo "1"; ?>" name="qty" id="qty"
                                       placeholder="Quantity">

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Total</label>
                                    <input type="text" disabled="disabled"
                                           value="<?php if (isset($bill_unit_price)) echo $bill_unit_price; ?>"
                                           class="form-control" name="total" id="total" placeholder="Unit Price">

                                </div>


                            </div>


                            <button type="button" id="upload" class="btn btn-default"
                                    onclick="javascript:CreateBill();">Raise
                            </button>


                            <script>
                                $(document).ready(function () {
                                    $("button#add").click(function () {

                                        $("form#createBill").attr("action", "<?=base_url()?>index.php/billing/add");
                                        CreateBill();
                                    });


                                    $("a.patient_function").click(function () {

                                        var return_base = $(this).attr("url");
                                        var purpose = $(this).attr("purpose");
                                        $("input#return_base").val(return_base);

                                        if (purpose == "print") {
                                            //code
                                            $("div[func=print], button[func=print]").show();
                                        }
                                        else {
                                            $("div[func=print], button[func=print]").hide();
                                        }

                                    });

                                });

                                function CreateBill() {

                                    //code
                                    var error = false;
                                    var department = $("select#dept_id").val();

                                    var description = $("input#desc").val();

                                    var qty = $("input#qty").val();

                                    var unit_price = $("input#unit_price").val();

                                    if (department == "") {
                                        //code
                                        error = true;
                                        alert("Please choose a department");
                                    }

                                    if (description == "") {
                                        //code
                                        error = true;
                                        alert("Please fill out a description");
                                    }

                                    if (qty == "") {
                                        //code
                                        error = true;
                                        alert("Please fill out a quantity");
                                    }

                                    if (unit_price == "") {
                                        //code
                                        error = true;
                                        alert("Please fill out the unit price");
                                    }


                                    if (!$.isNumeric(qty)) {
                                        //code
                                        error = true;
                                        alert("invalid quantity");
                                    }
                                    if (!$.isNumeric(unit_price)) {
                                        //code
                                        error = true;
                                        alert("invalid Unity Price");
                                    }


                                    if (error) {
                                        //code
                                        return false;
                                    }
                                    else {
                                        $("input#patient_name").removeAttr("disabled");
                                        $("form#createBill").submit();
                                        return true;
                                    }
                                }

                            </script>

                        </div>
                    </div>
                </div>
            </div>


        </form>


        <form id="find" method="post" action="<?= base_url() ?>index.php/patient/number">
            <input type="hidden" name="return_base" id="return_base" value=""/>

            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="patientSearch"
                 class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">
                                &#10006;</button>
                            <h4 class="modal-title">Find Patient</h4>
                        </div>
                        <div class="modal-body">


                            <div class="form-group">
                                <label for="exampleInputEmail1">Name</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Name">
                            </div>

                            <button type="button" id="find_all_hmo_patients" class="btn btn-default"
                                    onclick="javascript:findPatientByName();">Find By Name
                            </button>

                            <hr/>

                            <div class="form-group" func="print">
                                <label for="exampleInputEmail1">Reference</label>
                                <input type="text" class="form-control" name="ref" id="ref" placeholder="Name">
                            </div>

                            <button func="print" type="button" id="find_ref" class="btn btn-default"
                                    onclick="javascript:findRecieptByRef();">Find By Reference
                            </button>


                            <script>

                                function findRecieptByRef() {
                                    if ($("#ref").val() != "") {
                                        $("form#find").attr("action", "<?=base_url()?>index.php/billing/searchBillByReference").submit();
                                        //  document.location.replace("<?=base_url()?>index.php/billing/viewBill/"+$("#ref").val());
                                    }
                                    else alert("Enter Reciept Ref ");
                                }

                                function findPatientByName() {
                                    if ($("#name").val() != "") {
                                        $("form#find").attr("action", "<?=base_url()?>index.php/patient/search").submit();
                                    }
                                    else alert("Enter Patient Name");
                                }


                            </script>

                        </div>
                    </div>
                </div>
            </div>
        </form>


        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="patient_select"
             class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
                        <h4 class="modal-title">Create Bill</div>
                    <div class="modal-body" id="upform2">


                        <div class="form-group">
                            <label for="exampleInputEmail1">Select Patient Category</label>
                            <select name="patient_category" class="form-control" id="patient_category">

                                <option selected="selected" value="R">Registered Patient</option>
                                <option value="U">Walk in Patient</option>

                            </select>
                        </div>


                        <div class="form-group" id="full_name">
                            <label for="exampleInputEmail1">Name</label>
                            <input type="text" class="form-control" name="patient_full_name" id="patient_full_name"
                                   placeholder="Enter Full Name">
                        </div>


                        <button type="button" class="btn btn-default" onclick="javascript:createABill();">Raise A Bill

                        </button>


                        <script>

                            $(document).ready(function () {


                                <?php $notice = $this->session->userdata('notice');if(isset($notice) && $notice != "") {
                                $this->session->unset_userdata('notice');
                                ?>

                                alert("<?php echo $notice; ?>");


                                <?php  }?>


                                $("div#full_name").hide();

                                $("select#patient_category").change(function () {

                                    if ($(this).val() == "U") {
                                        //code
                                        $("div#full_name").show();
                                    }
                                    else {
                                        $("div#full_name").hide();
                                    }
                                    //  alert($(this).val());

                                });


                            });


                            function createABill() {
                                //code
                                var patientCategory = $("select#patient_category").val();

                                if (patientCategory == "U" && $.trim($("input#patient_full_name").val()) == "") {
                                    //code
                                    alert("please fill in the patient name");
                                    return false;
                                }
                                else if (patientCategory == "U") {
                                    //code
                                    $("input[name=non_patient]").val("true");
                                    $("input[name=walk_in_patient_name]").val($("input#patient_full_name").val());

                                }

                                $("a#bill_patient_search").click();
                                return true;
                            }

                        </script>

                    </div>
                </div>
            </div>
        </div>
    </section>
</section>
 