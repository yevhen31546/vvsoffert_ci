<style>
    .input-group.cust-img-upload-btn .input-group-addon{
        background: #5cb85c;
        color: #FFF;
        font-weight: 600;
        border: 1px solid #5cb85c;
        cursor: pointer;
    }
    .input-group.cust-img-upload-btn input {
        border-color: #5cb85c !important;
        border-top-right-radius: 3px !important;
        border-bottom-right-radius: 3px !important;
    }
</style>
<div class="col-xs-12 col-sm-9 col-xl-10 table_content">
    <div class="overall_content">
        <div class="section_content">
            <div class="table_header">
                <div class="table_title fl"><i class="fa fa-upload"></i> Importera Produkter RSK & Mängd</div>
                <div class="clearfix"></div>


                <div class="signup_screen">
                    <?php
                    $array = $this->session->flashdata('message');
                    if (!empty($array)) {
                        ?>
                        <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                            <strong>Klart!</strong> <?php echo $array['content']; ?>
                        </div> 

                        <?php
                        $this->session->unset_userdata('message');
                    }
                    $array = $this->session->flashdata('error');
                    if (!empty($array)) {
                        ?>
                        <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                            <strong>Förlåt!</strong> <?php echo $array['content']; ?>
                        </div> 

                        <?php
                        $this->session->unset_userdata('error');
                    }
                    ?>
                    <div class="signup_form">
                        <form action="" id="import_product_rsk_file_form" onsubmit="return checkpostdata(this);" name="import_product_rsk_file_form" method="post" enctype="multipart/form-data">
                            <div class="clearfix">
                                <div class="col-sm-12 col-md-12">
                                    <!--                                    <div class="col-sm-12 col-md-12">
                                                                            <div class="alert alert-info" role="alert" id="downloading_progress_estore" style="display: none;">
                                                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                                                <p class="text-center"><strong>Din förfrågan är under process. Vänligen vänta .. <br/> Din fil laddas ner automatiskt.</strong></p>
                                                                            </div>
                                                                        </div>-->
                                    <div class="form-group">
                                        <select class="form-control" id="user_list" name="user_list">
                                            <option value="">Välj lista</option>
                                            <?php foreach ($allList as $v) : ?>
                                                <option value="<?= $v->id ?>"><?= $v->name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="help-block"></div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group cust-img-upload-btn" onclick="$('#import_product_rsk_file').click();">
                                            <span class="input-group-addon" id="basic-addon1"><i class="fa fa-folder-open-o" aria-hidden="true"></i>&nbsp;&nbsp;Bläddra</span>
                                            <input type="text" disabled="true" class="form-control" id="import_product_rsk_file_name"/>
                                        </div>
                                        <input type="file" style="width: 0; height: 0;" name="import_product_rsk_file" id="import_product_rsk_file"/>
                                        <div class="help-block"></div>
                                    </div>
                                    <div class="import-action">
                                        <a href="<?php echo base_url() . 'uploads/sample_excel/Produkt_RSK_User_Import.xlsx'; ?>" target="_blank" class="btn btn-warning pull-left" download="Produkt_RSK_User_Import.xlsx">Öppna import mall</a>
                                        <button type="submit" class="btn btn-success pull-right reg-btn" disabled="true" id="btn-submit" name="submit" value="save">Ladda upp</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>  	
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>