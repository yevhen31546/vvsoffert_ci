        <div class="col-xs-12 col-sm-9 col-xl-10 table_content">
            <div class="overall_content">
                <div class="section_content">
                    <?php $array = $this->session->flashdata('message');
                        if($array){ ?>
                           <div class="alert alert-success">
                               <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                              <strong>Klart!</strong> <?php echo $array['content']; ?>
                            </div> 
                            
                        <?php  $this->session->unset_userdata('message'); } ?>
                        
                	<div class="table_header">
                        <div class="col-md-12">
                            
                            <div class="col-md-4 col-sm-12" style = "float:left;">
                                <label style = "font-size: 35px;color:#1E9F2E ">Alla artiklar</label>
                            </div>
                            <div class="col-md-8 col-sm-12">
                                <!-- <button type="button" class="btn btn-success" style="float:right;margin:5px;">
                                    <a href="<?php echo site_url('add-new-article-form'); ?>" style = "font-size: 20px; color: white;">
                                        <i class="far fa-file" style = "margin-right: 5px;"></i> Ny artikel
                                    </a>
                                </button> -->
                                <button type="button" class="btn btn-success" style="float:right;margin:5px;">
                                    <a href="<?php echo site_url('export-excel-new'); ?>" style = "font-size: 20px; color: white;">
                                        <i class="far fa-file" style = "margin-right: 5px;"></i> Best Price
                                    </a>
                                </button>
                                <button type="button" class="btn btn-success" style="float:right;margin:5px;">
                                    <a href="<?php echo site_url('add-new-article-form'); ?>" style = "font-size: 20px; color: white;">
                                        <i class="far fa-file" style = "margin-right: 5px;"></i> Ny artikel
                                    </a>
                                </button>
                            </div>
                            <!-- <div class="col-md-2 col-sm-12">
                                <button type="button" class="btn btn-success" style="float:right;">
                                    <a href="<?php echo site_url('add-new-article-form'); ?>" style = "font-size: 20px; color: white;">
                                        <i class="far fa-file" style = "margin-right: 5px;"></i> Ny artikel
                                    </a>
                                </button>
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <button type="button" class="btn btn-success" style="float:right;">
                                    <a href="<?php echo site_url('add-new-article-form'); ?>" style = "font-size: 20px; color: white;">
                                        <i class="far fa-file" style = "margin-right: 5px;"></i> Ny artikel
                                    </a>
                                </button>
                            </div> -->
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="table-responsive" style = "font-size: 20px; margin-top: 0px; overflow-x:inherit;">
                        <table id="datatable" class="table" >
                            <thead>
                                <tr>
                                    <!-- <th scope="col">Nej</th> -->
                                    <th scope="col">Artikelnummer</th>
                                    <th scope="col">Artikelnamn</th>
                                    <th scope="col">Enhet</th>
                                    <th scope="col">Pris exkl.VAT</th>
                                    <th scope="col">Pris inkl. Moms</th>
                                    <th scope="col">Visa</th>
                                    <!-- <th scope="col">Art.in lager</th> -->
                                    <!-- <th scope="col">Reserved sty</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(count($articles) > 0){
                                    foreach ($articles as $key => $value) {
                                ?>
                                <tr>
                                    <!-- <td data-label="No"><?=$key+1?></td> -->
                                    <td data-label="Article Num"><?=$value->art_num;?></td>
                                    <td data-label="Article Name"><?=$value->art_name;?></td>
                                    <td data-label="Unit"><?=$value->unit;?></td>
                                    <td data-label="Price excl.VAT"><?=$value->sale_price_excl;?></td>
                                    <td data-label="Price incl.VAT"><?=$value->sale_price_incl;?></td>
                                    <td data-label="Visa">
                                    	<div class="option_btn">
                                    	    <div class= "col-sm-6"><a class="" href="<?php echo site_url('edit-article'). '?&id='.$value->id;?>"><i class="fa fa-edit fl" style="float:right !important;margin-right:5%"></i></a></div>
                                    	    <div class= "col-sm-6"><a class="" href="<?php echo site_url('delete-article'). '?&id='.$value->id;?>"><i class="fa fa-trash fr" style = "color:#d9534f;float:right!important;margin-right:5%;"></i></a></div>
                                            <div class="clearfix"></div>
    									</div>
    								</td>
                                    <!-- <td data-label="Art.in stock"><?=$value->stock_bal;?></td> -->
                                    <!-- <td data-label="Reserved sty"><?=$value->unit_reserve;?></td> -->
                                </tr>
                                    <?php }}else{ ?>
                                <tr>
                                    <td colspan="3">Ingen lista hittades</td>  
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="addProject" tabindex="-1" role="dialog" aria-labelledby="addProjectLabel" aria-hidden="true">
            <?php $error = $this->session->flashdata('error');
                if($error){ echo "onload_show"; } 
            ?> 
            <div class="modal-dialog modal-dialog-slideout modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" style = "padding-left: 15px;" id="addProjectLabel">Add Project</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style = "margin-top: -40px; font-size: 35px;">
                        <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="signup_form">
                            <form action="user/add_new_project" method="post" id="add_project_form" accept-charset="utf-8">
                                <div class="form-group col-xs-12 col-sm-12">
                                    <?php $error = $this->session->flashdata('error');
                                    if($error){ ?>
                                    
                                        <div class="alert alert-danger">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                                        <strong>Klart!</strong> The project already exists!
                                        </div> 
                                        
                                    <?php  $this->session->unset_userdata('error'); } ?>
                                    <div class="icon-addon">
                                        <?php
                                        if(isset($singlelist)){
                                        ?>
                                        <input type="hidden" name="id" id = "id" value="<?= base64_encode($singlelist->id)?>">
                                        <?php } ?>
                                        <label for="name" class="" rel="tooltip" style = "font-size: 20px; padding:5px 15px;">Lista namn:</label>
                                        <input type="text" placeholder="Lista namn" class="form-control" style = "padding-left: 15px; font-size:20px; height:45px;" id="name" name="name" value="<?=(isset($singlelist) && $singlelist->name!='')?$singlelist->name:''?>">
                                        <span style="color:red; display: none;" id = "check_field">This field is required!</span>
                                    </div>
                                </div>
                                
                                <!--<div class="form-group text-center account_btn">-->
                                    <!--<a href="#" class="reg-btn">Create an Account</a>-->
                                <!--    <input type="submit" name="submit" id="sbmt" class="reg-btn" value="Lämna">-->
                                <!--</div>-->
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" style = "font-size:18px;<?php if(isset($singlelist)){?>display:none;<? } ?>" id ="add_project_btn" >Bekräfta</button>
                        <button type="button" class="btn btn-success" style = "font-size:18px; display: none" id ="edit_project_btn"> Redigera</button>
                        <button type="button" class="btn btn-secondary" style = "font-size:18px" data-dismiss="modal">Annullera</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <!-- </div> -->