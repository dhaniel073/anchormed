<?php

setlocale(LC_MONETARY, 'en_US');

$hospital_address = $this->session->userdata('hospital_address');
$currencySymbol = $this->session->userdata('currency_symbol');

$printAddressBase = "index.php/workbench/printReferalDoc/";


$print_mode = true;

/*if ($this->session->userdata('print_mode')) {

    $print_mode = $this->session->userdata('print_mode');
    $this->session->unset_userdata('print_mode');

}*/



?>




<script>
    $(document).ready(function () {


        <?php $notice = $this->session->userdata('notice');  $this->session->unset_userdata('notice'); if($notice && $notice != ""){ ?>

        alert("<?php echo $notice; ?>");


        <?php } ?>
    });
</script>



<section id="container" class="">

    <section id="main-content">
        <section class="wrapper site-min-height">
            <section style="position: absolute; left: 0px; top: 0px; width:100%;">
                <div class="panel panel-primary">

                    <div class="panel-body">
                        <div class="row invoice-list">
                            <div class="text-center corporate-id">
                                <p><?php if (isset($hospital_address)) echo $hospital_address; ?> </p>
                                <img src="<?= base_url() ?>assets/img/logo/logo_referal.png" alt="" height="100">
                            </div>
                            <div class="col-lg-4 col-sm-4">
                                <h4>Patient Details</h4>

                                <p>
								
								<p>Patient Number :  <?php if (isset($patient['patient_number'])) echo ucwords($patient['patient_number'] . " "); ?> </p>
								<p>Patient Type :  <?php if (isset($patient['patient_type_code'])) if($patient['patient_type_code']=='S') echo 'Standard'; elseif($patient['patient_type_code']=='H') echo 'Health Insurance'; elseif($patient['patient_type_code']=='F') echo 'Family'; ?></p>
								<p>HMO Code : <?php if (isset($patient['hmo_code'])) echo ucwords($patient['hmo_code'] . " "); ?> </p>
								<p>HMO Name : <?php if (isset($hmo_name['hmo_name'])) echo $hmo_name['hmo_name']; ?></p>
								<p>HMO No : <?php if (isset($patient['hmo_enrolee_id'])) echo ucwords($patient['hmo_enrolee_id'] . " "); ?></p>
								
                                    <?php if (isset($patient['first_name'])) echo ucwords($patient['first_name'] . " ");
                                    if (isset($patient['last_name'])) echo($patient['last_name']); ?> <br>
                                    <?php if (isset($patient['address_line_1'])) echo ucwords($patient['address_line_1']); ?>
                                    <br>
                                    <?php if (isset($patient['address_line_2'])) echo ucwords($patient['address_line_2'] . ". ");
                                    if (isset($state['state_name'])) echo $state['state_name']; ?><br>
                                    <?php if (isset($patient['country_name'])) echo ucwords($country['country_name']); ?>
                                    Tel: <?php if (isset($patient['mobile_number'])) echo $patient['mobile_number']; ?>
                                </p>
                            </div>

                                                       


                        </div>
                        


                

					<div>
						<p><b>Referal Reason: </b> </br><?php  if (isset($referaldetails['reason'])) echo($referaldetails['reason']);  ?></p>
						<p><b>Consulting Doctor:</b> </br><?php foreach($doctors as $doctor){ if($referaldetails['consulting_doctor'] == $doctor['staff_no']){echo ucfirst($doctor['first_name'])." ".ucfirst($doctor['last_name']); break;}} ?></p>
						<p><b>Doctors Notes:</b></br> <?php  if (isset($referaldetails['refferal_notes'])) echo($referaldetails['refferal_notes']);  ?></p>
						<p><b>Hospital Name:</b></br> <?php  if (isset($referaldetails['hospital_name'])) echo($referaldetails['hospital_name']);  ?></p>
						<p><b>Address:</b> </br><?php  if (isset($referaldetails['address'])) echo($referaldetails['address']);  ?></p>
					</div>

					
					
					


                        
                    </div>
					
					
					<div>
						<a id="printbutton" href="<?= base_url() ?><?php echo $printAddressBase . $referaldetails['id'];?>?print_mode=true" target="_blank" class="btn btn-info btn-lg"><i class="fa fa-print"></i> Print </a>
					</div>
					
					
                </div>

                


            </section>


        </section>
    </section>


</section>


</section>

</form>

 <style>

     strong{

         font-size: 15px;
     }
	 
	 @media print {
	  #printbutton {
		display: none;
	  }
	}

 </style>
 
 <script>

                            $(document).ready(function () {

                                <?php if($print_mode == "true"){
                                    ?>
                                window.print();
                                <?php
                                }?>

                            });
</script>