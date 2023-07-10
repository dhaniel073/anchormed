<section id="main-content">
    <section class="wrapper">

        <div class="row" style="min-height: 600px;">


            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Laboratory Test Creation Form
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
                                            <div>Test Info</div>
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

                                <?php echo form_open('laboratory/add') ?>


                                <fieldset title="Lab Test" class="step" id="default-step-0">

                                    <legend></legend>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Name</label>

                                        <div class="col-lg-10">
                                            <input name="name" value="<?php if (isset($name)) echo $name; ?>" id="name"
                                                   type="text" class="form-control" placeholder="Name">
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Description</label>

                                        <div class="col-lg-10">
                                            <input name="description"
                                                   value="<?php if (isset($description)) echo $description; ?>"
                                                   id="description" type="text" class="form-control"
                                                   placeholder="Description">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Required Sample Type</label>

                                        <div class="col-lg-10">
                                            <select name="required_sample_type" class="form-control">

                                                <?php
                                                foreach ($sample_types as $sample) {
                                                    ?>
                                                    <option
                                                        value="<?php echo $sample["sample_type_id"];?>"> <?php echo ucfirst($sample["name"]); ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Price</label>

                                        <div class="col-lg-10">
                                            <input name="price" value="<?php if (isset($price)) echo $price; ?>"
                                                   id="price" type="text" class="form-control" placeholder="Price">
                                        </div>
                                    </div>


                                </fieldset>


                                <input type="button" class="finish btn btn-success" value="Create"/>


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


<!------------------------------------------------ bill form selection ------------------------------------------------------->

<form>

    <a id="viewday" href="#user_appointment" data-toggle="modal"></a>

    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="select_bill_form"
         class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
                    <h4 class="modal-title">Choose a Bill Form</h4>
                </div>


                <div class="modal-body">

                    <div class="form-group">
                        <label for="exampleInputEmail1">Bill Forms</label>
                        <select class="form-control" name="Sbill_form" id="Sbill_form" placeholder="Bill Form">


                            <?php foreach ($drug_bill_forms as $form) { ?>
                                <option
                                    value="sub_<?php echo $form['drug_bill_package_id']; ?>"> <?php echo ucfirst($form['name']); ?> </option>
                            <?php } ?>
                        </select>
                    </div>


                    <button type="button" id="add_form" class="btn btn-default" onclick="javascript:addBillForm();">
                        Add
                    </button>


                    <script>

                        function addBillForm() {
                            var val = $("select#Sbill_form").val();

                            $("label[details=" + val + "]").show();

                            $("input[sub=" + val + "]").prop("checked", true);

                            $("div#" + val).show();
                            $("div#" + val + "_2").show();
                            $("div#" + val + "_3").show();

                            $("button.close").click();

                            createStockRules(getDefaultStockFormId());
                        }

                    </script>
                </div>


            </div>
        </div>
    </div>
</form>
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