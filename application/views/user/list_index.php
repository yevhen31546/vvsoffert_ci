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
                        <div class="table_title fl"><p style = "font-size: 30px;">Mina Projekt/Listor</p></div>
                        <div class="Export_content fr"><button type="button" class="btn btn-success" id = "add_project_modal_btn" style = "font-size: 16px" data-toggle="modal" data-target="#addProject"><span class="fa fa-plus" style = "margin-right: 5px;"></span> Lägg till Projekt/Lista</button></div>
                        <div class="clearfix"></div>
               		</div>
                	<div class="table-responsive" style = "font-size: 20px; margin-top: 30px;">
                    	<table id="datatable" class="table" >
                            <thead>
                                <tr>
                                    <th style = "width:100px;" scope="col">SL nr.</th>
                                    <th scope="col">Namn</th>
                                    <th scope="col">Skapat tid</th>
                                    <th scope="col">Visa</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(count($model) > 0){
                                    foreach ($model as $key => $value) {
                                ?>
                                <tr>
                                    <td data-label="SL nr." style = "padding-left: 15px;"><?=$key+1?></td>
                                    <td data-label="Namn"><a href=<?php echo site_url('list-details').'?id='.base64_encode($value->id); ?>><?=$value->name;?></a></td>
                                    <td data-label="Skapat tid"><?= $value->created_at; ?></td>
                                    <td data-label="Visa" width="100" class="xs_width">
                                    	<div class="option_btn">
                                    	    <div class= "col-md-6 col-sm-6" style="float:right !important;"><a class="" href="javascript:" id="<?=base64_encode($value->id)?>" onclick="editProject(this)" data-targetSlug="<?=$value->name?>"><i class="fa fa-edit fl"></i></a></div>
                                    	    <div class= "col-md-6 col-sm-6" style="float:right !important;"><a id="<?=$value->id?>" class="" href="javascript:;" onclick="deleteProductGroup(this)" data-targetSlug="<?=$value->id?>"><i class="fa fa-trash fr" style = "color:#d9534f"></i></a></div>
                                            <div class="clearfix"></div>
    									</div>
    								</td>
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