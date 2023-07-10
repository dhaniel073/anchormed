<section id="container" class="">

    <section id="main-content">
        <section class="wrapper site-min-height" style="min-height: 400px;">


            <div class="row">

                <div class="col-lg-12">

                    <ul class="breadcrumb">
                        <li><a href="<?=base_url()?>index.php/provider"><i class="fa fa-home"></i> HMO Central</a></li>
                        <li><a href="<?=base_url()?>index.php/provider/view/<?php echo $provider["hmo_code"];?>"><?php echo ucfirst($provider["hmo_name"]); ?></a></li>
                        <li class="active">bill breakdown</li>
                    </ul>

                </div>
            </div>

            <div class="row">


            <div class="row" style="min-height: 200px;">



                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            <?php echo ucfirst($provider["hmo_name"]) . "'s Bill Breakdown"; ?><span
                                class="tools pull-right">
<a href="javascript:;" class="fa fa-chevron-down"></a>
<a href="javascript:;" class="fa fa-times"></a>
</span>
                           </header>
                        <div class="panel-body">

                            <!-- begining of form section-->
                            <section class="panel">

                                <div class="panel-body">

                                    <p> Reference : <?php echo $hmo_bill["reference_id"]; ?></p>

                                    <p> Total Amount
                                        : <?php echo $this->session->userdata("currency_symbol") . " " . number_format($hmo_bill["total_amount"], 2); ?></p>

                                    <p> Total Amount
                                        Paid: <?php echo $this->session->userdata("currency_symbol") . " " . number_format($hmo_bill["amount_paid"], 2); ?></p>

                                    <?php if ($hmo_bill["status"] == "R") { ?>
                                        <p> Amount
                                            Remaining: <?php echo $this->session->userdata("currency_symbol") . " " . number_format($hmo_bill["total_amount"] - $hmo_bill["amount_paid"], 2); ?></p>
                                    <?php } ?>

                                </div>
                            </section>
                            <!-- end of form section-->
                        </div>
                    </section>
                </div>


                <div class="col-lg-12">

                    <section class="panel">
                        <header class="panel-heading">
                            Payments made with Dates
                        </header>
                        <div class="panel-body">
                            <div class="adv-table">
                                <table class="display table table-bordered table-striped" id="patient">
                                    <thead>


                                    <tr>

                                        <th>Date</th>
                                        <th>Amount Paid</th>
                                        <th>Description</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($transactions as $bill) { ?>
                                        <tr class="gradeX">


                                            <td><a><?php echo $bill['date_created']; ?></a></td>
                                            <td><?php echo $this->session->userdata("currency_symbol") . " " . number_format($bill['transaction_amount'], 2); ?></td>
                                            <td><a><?php echo $bill['description']; ?></a></td>

                                        </tr>

                                    <?php } ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </section>


                    <section class="panel">
                        <header class="panel-heading">
                           Detailed Bill Breakdown
                        </header>
                        <div class="panel-body">
                            <div class="adv-table">
                                <table class="display table table-bordered table-striped" id="patient">
                                    <thead>


                                    <tr>

                                        <th>Date</th>
                                        <th>Billed to</th>
                                        <th>Patient Number</th>
                                        <th>Bill Reference</th>
                                        <th>Amount</th>
                                        <th>Description</th>


                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($full_break_down["bills"] as $bill) { ?>
                                        <tr class="gradeX">


                                            <td><?php echo $bill['date_created']; ?></td>
                                            <td><a><?php echo $bill['patient']['first_name']." ".$bill['patient']['middle_name']
                                                    ." ".$bill['patient']['last_name']; ?></a></td>
                                            <td><a href=""><?php echo $bill['patient_number'] ;?></a></td>
                                            <td><a href="" ><?php echo $bill['reference_id'] ;?></a></td>
                                            <?php
                                            //calculate paid amount
                                            $paidAmount = 0;

                                            if(isset($bill["selling_price"]) && $bill["selling_price"] > 0 ){

                                                $paidAmount = $bill["selling_price"];
                                            }else{

                                                $paidAmount = $bill["qty"] * $bill["unit_price"];
                                            }

                                            ?>
                                            <td><?php echo $this->session->userdata("currency_symbol") . " " . number_format($paidAmount, 2); ?></td>
                                            <td><?php echo $bill['service_name']; ?></td>

                                        </tr>

                                    <?php } ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </section>


                    <section class="panel">
                        <header class="panel-heading">
                            Costs covered by patients
                        </header>
                        <div class="panel-body">
                            <div class="adv-table">
                                <table class="display table table-bordered table-striped" id="patient">
                                    <thead>


                                    <tr>

                                        <th>Date</th>
                                        <th>Billed to</th>
                                        <th>Patient Number</th>
                                        <th>Bill Reference</th>
                                        <th>Amount Paid</th>


                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($full_break_down["patientOffsets"] as $offset) { ?>
                                        <tr class="gradeX">


                                            <td><?php echo $offset['date_created']; ?></td>
                                            <td><a><?php echo $offset['patient']['first_name']." ".$offset['patient']['middle_name']
                                                        ." ".$offset['patient']['last_name']; ?></a></td>
                                            <td><a href=""><?php echo $offset['patient_number'] ;?></a></td>
                                            <td><a href="" ><?php echo $offset['bill_reference_id'] ;?></a></td>
                                            <td><?php echo $this->session->userdata("currency_symbol") . " " . number_format($offset['amount_paid'], 2); ?></td>

                                        </tr>

                                    <?php } ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </section>


                </div>

            </div>


        </section>
    </section>



 
 