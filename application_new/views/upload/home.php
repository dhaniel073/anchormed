<section id="main-content">
    <section class="wrapper">

        <div class="row">


            <div class="col-lg-6">
                <section class="panel">
                    <header class="panel-heading">
                        BaseData Upload
<span class="tools pull-right">
<a href="javascript:;" class="fa fa-chevron-down"></a>
<a href="javascript:;" class="fa fa-times"></a>
</span>
                    </header>
                    <div class="panel-body">


                        <div style="width:100%; text-align: center; margin-bottom:200px;">

                            <a href="#myModal" data-toggle="modal" upload="country">
                                <div class="option-icon">
                                    <i class="fa fa-file-excel-o fa-5x"></i>

                                    <p>Country Data</p>

                                </div>
                            </a>

                            <a href="#myModal" data-toggle="modal" upload="state">
                                <div class="option-icon">
                                    <i class="fa fa-file-excel-o fa-5x"></i>

                                    <p>State Data</p>

                                </div>
                            </a>

                            <a href="#myModal" data-toggle="modal" upload="lga">
                                <div class="option-icon">
                                    <i class="fa fa-file-excel-o fa-5x"></i>

                                    <p>Local Government Data</p>

                                </div>
                            </a>

                            <a href="#myModal" data-toggle="modal" upload="hmo">
                                <div class="option-icon" key="new">
                                    <i class="fa fa-file-excel-o fa-5x"></i>

                                    <p>HMO Data</p>

                                </div>
                            </a>



                            <a href="#myModal" data-toggle="modal" upload="drug">
                                <div class="option-icon">
                                    <i class="fa fa-file-excel-o fa-5x"></i>

                                    <p>Pharmacy Drugs</p>

                                </div>
                            </a>


                        </div>

                    </div>
                </section>
            </div>


            <div class="col-lg-6">
                <section class="panel">
                    <header class="panel-heading">
                        Patient Data Upload
<span class="tools pull-right">
<a href="javascript:;" class="fa fa-chevron-down"></a>
<a href="javascript:;" class="fa fa-times"></a>
</span>
                    </header>
                    <div class="panel-body">


                        <div style="width:100%; text-align: center; margin-bottom:200px;">
                            <a href="#myModal" data-toggle="modal" upload="patient">
                                <div class="option-icon">
                                    <i class="fa fa-file-excel-o fa-5x"></i>

                                    <p>Patient Data</p>

                                </div>
                            </a>
                            <a href="#myModal2" data-toggle="modal" upload="family">
                                <div class="option-icon">
                                    <i class="fa fa-file-zip-o fa-5x"></i>

                                    <p>Patient History Data</p>

                                </div>
                            </a>


                        </div>

                    </div>
                </section>
            </div>


        </div>


        <div class="row">


            <div class="col-lg-6">
                <section class="panel">
                    <header class="panel-heading">
                        Excel Template Download
<span class="tools pull-right">
<a href="javascript:;" class="fa fa-chevron-down"></a>
<a href="javascript:;" class="fa fa-times"></a>
</span>
                    </header>
                    <div class="panel-body">


                        <div style="width:100%; text-align: center; margin-bottom:200px;">
                            <a href="<?= base_url() ?>assets/download/templates.zip">
                                <div class="option-icon">
                                    <i class="fa fa-download fa-5x"></i>

                                    <p>Download Excel Templates</p>


                                </div>
                            </a>


                        </div>

                    </div>
                </section>
            </div>


        </div>

        <script>


            $("a[data-toggle=modal]").click(function () {
                var upload = $(this).attr("upload");


                $("#upload_type").val(upload);

                if (upload == "lga") {
                    //code
                    $("span#uplaoadtype").html("Local Government ");

                }
                else if (upload == "state") {
                    //code
                    $("span#uplaoadtype").html("State ");
                }
                else if (upload == "country") {
                    //code
                    $("span#uplaoadtype").html("Country ");
                }
                else if (upload == "patient") {
                    //code
                    $("span#uplaoadtype").html("Patient ");
                }
                else if (upload == "hmo") {
                    //code
                    $("span#uplaoadtype").html("Provider ");
                }
                else if (upload == "family") {
                    //code
                    $("span#uplaoadtype").html("Patient History ");
                }else if(upload == "drug"){

                    $("span#uplaoadtype").html("Pharmacy Drugs ");
                }
            });

        </script>

        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal"
             class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
                        <h4 class="modal-title"><span id="uplaoadtype">Test </span>Uploader</div>
                    <div class="modal-body" id="upform">


                        <?php echo form_open_multipart('/upload/do_upload'); ?>


                        <div class="form-group">
                            <label class="control-label col-md-3">Select excel file</label>

                            <div class="controls col-md-9">
                                <div class="fileupload fileupload-new" data-provides="fileupload">
<span class="btn btn-white btn-file">
<span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select file</span>
<span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
<input id="excel" type="file" name="userfile" size="20" class="default"/>
<input id="upload_type" name="upload_type" type="hidden"/>
</span>
                                    <span class="fileupload-preview" style="margin-left:5px;"></span>
                                    <a href="#" class="close fileupload-exists" data-dismiss="fileupload"
                                       style="float: none; margin-left:5px;"></a>
                                </div>
                            </div>
                        </div>


                        <button type="button" id="upload-excel" class="btn btn-default" <!--onclick="javascript:uploadFile();"-->>
                            Upload
                        </button>
                        </form>

                        <script>

                            $(document).ready(function () {
                                $("div#upform").find("form").attr("id", "upload_form");

                                $("div#upform2").find("form").attr("id", "history_form");

                                $("button#upload-excel").click(function(){
                                    uploadFile();
                                });

                                <?php if(isset($error) && trim($error) != ""){echo "alert(\"".$error."\");";} else if(isset($sucess)) echo "alert(\"".$sucess."\");"; ?>
                            });

                            function uploadFile() {
                                //code
                                var error = false;
                                var excel = $("input#excel").val();
                                if (excel == "") {
                                    //code
                                    error = true;
                                    alert("Please choose valid excel file");
                                }

                                if (error) {
                                    //code
                                    return false;
                                }
                                else {
                                    $("div#upform form").submit();
                                    return true;
                                }
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
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
                        <h4 class="modal-title"><span id="uplaoadtype">Test </span>Uploader</div>
                    <div class="modal-body" id="upform2">


                        <?php echo form_open_multipart('/upload/uploadLegacyHistory'); ?>


                        <div class="form-group">
                            <label class="control-label col-md-3">Select zip file</label>

                            <div class="controls col-md-9">
                                <div class="fileupload fileupload-new" data-provides="fileupload">
<span class="btn btn-white btn-file">
<span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select zip file</span>
<span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
<input id="zipfile" type="file" name="userfile" size="20" class="default"/>
<input id="upload_type" name="upload_type" type="hidden"/>
</span>
                                    <span class="fileupload-preview" style="margin-left:5px;"></span>
                                    <a href="#" class="close fileupload-exists" data-dismiss="fileupload"
                                       style="float: none; margin-left:5px;"></a>
                                </div>
                            </div>
                        </div>


                        <button type="button" id="upload" class="btn btn-default" onclick="javascript:uploadZipFile();">
                            Upload
                        </button>
                        </form>

                        <script>

                            function uploadZipFile() {



                                //code
                                var error = false;
                                var zipfile = $("input#zipfile").val();
                                if (zipfile == "") {
                                    //code
                                    error = true;
                                    alert("Please choose valid zip file");
                                }

                                if (error) {
                                    //code
                                    return false;
                                }
                                else {
                                    $("div#upform2 form").submit();
                                    return true;
                                }
                            }

                        </script>

                    </div>
                </div>
            </div>
        </div>
    </section>
</section>
 