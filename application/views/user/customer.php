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
                            <div class="col-md-4 col-md-12" style = "float:left;">
                                <label style = "font-size: 35px;color:#1E9F2E ">Alla kunder</label>
                            </div>
                            <div class="col-md-8">
                                <button type="button" class="btn btn-success" style="float:right;">
                                    <a href="<?php echo site_url('add-new-customer') . '?id=' . $_GET['id'].'&type=1'; ?>" style = "font-size: 20px; color: white;">
                                        <i class="far fa-file" style = "margin-right: 5px;"></i> Ny Kund
                                    </a>
                                    </div>
                                </button>
                            </div>
                            <div class="clearfix"></div>
               		    </div>
                    <div class="table-responsive" style = "font-size: 20px; margin-top: 0px;">
                    	<table id="datatable" class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Kundnr</th>
                                    <th scope="col">Kundnamn</th>
                                    <th scope="col">Senaste fakturan</th>
                                    <th scope="col">Obetalda fakturor</th>
                                    <th scope="col">Försäljning senaste året</th>
                                    <th scope="col">Visa</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(count($customers) > 0){
                                    foreach ($customers as $key => $customer) {
                                ?>
                                <tr>
                                    <td data-label="Kundnr" style = "padding-left: 15px;"><?=$customer->id + 50;?></td>
                                    <td data-label="Kundnamn"><?=$customer->first_name.' '.$customer->last_name;?></a></td>
                                    <td data-label="Senaste fakturan"><?=$customer->created_at;?></td>
                                    <td data-label="Obetalda fakturor">0</td>
                                    <td data-label="Försäljning senaste året">0</td>
                                    <td data-label="Visa">
                                    	<div class="option_btn">
                                    	    <!-- <div class= "col-sm-6"><a class="" href="javascript:" id="<?=$customer->id?>" onclick="editCustomerNew(this)" data-targetSlug='<?=json_encode($customer)?>'><i class="fa fa-edit fl"></i></a></div> -->
                                    	    <div class= "col-sm-6"><a class="" href="<?php echo site_url('edit-customer'). '?&id='.$customer->id;?>" id="<?=$customer->id?>" data-targetSlug='<?=json_encode($customer)?>'><i class="fa fa-edit fl" style="float:right !important;margin-right:5%"></i></a></div>
                                    	    <div class= "col-sm-6"><a id="<?=$customer->id?>" class="" href="javascript:;" onclick="deleteCustomer(this)" data-targetSlug="<?=$customer->id?>"><i class="fa fa-trash fr" style = "color:#d9534f;float:right!important;margin-right:5%;"></i></a></div>
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
       <div class="modal fade
        <?php $error = $this->session->flashdata('error');
            if($error){ echo "onload_show"; } 
        ?> " id="addCustomer" tabindex="-1" role="dialog" aria-labelledby="addCustomerLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-slideout modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h2 class="modal-title" style = "padding-left: 15px;" id="addCustomerLabel">Add Customer</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style = "margin-top: -40px; font-size: 35px;">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
              <div class="modal-body">
                    <div class="signup_form">
                        <form action="https://vvsoffert.se/user/add_new_customer" method="post" id="add_customer_form" accept-charset="utf-8">
                            <div class="form-group col-xs-12 col-sm-12">
                                <?php $error = $this->session->flashdata('error');
                                if($error){ ?>
                                
                                   <div class="alert alert-danger">
                                       <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                                      <strong>Klart!</strong> The Customer already exists!
                                    </div> 
                                    
                                <?php  $this->session->unset_userdata('error'); } ?>
                                <div class="icon-addon">
                                    <?php
                                    if(isset($singlelist)){
                                    ?>
                                     <input type="hidden" name="id" id = "id" value="<?= base64_encode($singlelist->id)?>">
                                    <?php } ?>
                                    <div class = "col-sm-12" style = "margin-bottom: 10px;">
                                        <div class="col-sm-5">
                                            <label for="first_name" class="" rel="tooltip" style = "font-size: 20px; padding:5px 15px;">First Name:</label>
                                            <input type="text" placeholder="first name" class="form-control" style = "padding-left: 15px; font-size:20px; height:45px;" id="first_name" name="first_name">
                                            <span style="color:red; display: none;" id = "check_first_name">This field is required!</span>
                                        </div>
                                        <div class="col-sm-1">
                                        </div>
                                        <div class = "col-sm-5">
                                            <label for="last_name" class="" rel="tooltip" style = "font-size: 20px; padding:5px 15px;">Last Name:</label>
                                            <input type="text" placeholder="last name" class="form-control" style = "padding-left: 15px; font-size:20px; height:45px;" id="last_name" name="last_name">
                                            <span style="color:red; display: none;" id = "check_last_name">This field is required!</span>
                                        </div>
                                        <div class="col-sm-1">
                                        </div>
                                    </div>
                                    <div class = "col-sm-12" style = "margin-bottom: 10px;">
                                        <div class="col-sm-6">
                                            <label for="email" class="" rel="tooltip" style = "font-size: 20px; padding:5px 15px;">E-Mail:</label>
                                            <input type="text" placeholder="E Mail" class="form-control" style = "padding-left: 15px; font-size:20px; height:45px;" id="email" name="email">
                                            <span style="color:red; display: none;" id = "check_email">This field is required!</span>
                                        </div>
                                        
                                        <div class = "col-sm-6">
                                            <label for="webaddress" class="" rel="tooltip" style = "font-size: 20px; padding:5px 15px;">Web Address:</label>
                                            <input type="text" placeholder="Web Address" class="form-control" style = "padding-left: 15px; font-size:20px; height:45px;" id="webaddress" name="webaddress">
                                            <!--<span style="color:red; display: none;" id = "check_webaddress">This field is required!</span>-->
                                        </div>
                                    </div>
                                    <div class = "col-sm-12" style = "margin-bottom: 10px;">
                                        <div class="col-sm-3">
                                            <label for="postcode" class="" rel="tooltip" style = "font-size: 20px; padding:5px 15px;">Post Code::</label>
                                            <input type="text" placeholder="Post Code" class="form-control" style = "padding-left: 15px; font-size:20px; height:45px;" id="postcode" name="postcode">
                                            <!--<span style="color:red; display: none;" id = "check_postcode">This field is required!</span>-->
                                        </div>
                                        <div class = "col-sm-4">
                                            <label for="phonenumber" class="" rel="tooltip" style = "font-size: 20px; padding:5px 15px;">Phone Number:</label>
                                            <input type="text" placeholder="Phone Number" class="form-control" style = "padding-left: 15px; font-size:20px; height:45px;" id="phonenumber" name="phonenumber">
                                            <!--<span style="color:red; display: none;" id = "check_phonenumber">This field is required!</span>-->
                                        </div>
                                        <div class = "col-sm-5">
                                            <label for="company" class="" rel="tooltip" style = "font-size: 20px; padding:5px 15px;">Company:</label>
                                            <input type="text" placeholder="Company" class="form-control" style = "padding-left: 15px; font-size:20px; height:45px;" id="company" name="company">
                                            <!--<span style="color:red; display: none;" id = "check_phonenumber">This field is required!</span>-->
                                        </div>
                                    </div>
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
                <button type="button" class="btn btn-success" style = "font-size:18px;<?php if(isset($singlelist)){?>display:none;<? } ?>" id ="add_customer_btn" >Bekräfta</button>
                <button type="button" class="btn btn-success" style = "font-size:18px; display: none" id ="edit_customer_btn"> Redigera</button>
                <button type="button" class="btn btn-secondary" style = "font-size:18px" data-dismiss="modal">Annullera</button>
              </div>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
    </div>