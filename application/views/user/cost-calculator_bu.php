    <div class="col-xs-12 col-sm-9 table_content">
        <div class="overall_content">
            <div class="section_content">
                <div class="table_header">
                    <div class="table_title fl"><i class="fa fa-tablet-alt"></i> Beräkna ungefärlig kostnad</div>
                    <div class="clearfix"></div>
                   
                   
                    <div class="signup_screen">
                         <?php $array = $this->session->flashdata('message');
                        if(count($array) > 0){ ?>
                           <div class="alert alert-success">
                               <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
  <strong>Framgång!</strong> <?php echo $array['content']; ?>
</div> 
                            
                       <?php  $this->session->unset_userdata('message'); } ?>
                        
                        <div class="signup_form">
                            <?php echo form_open(); ?>
                                <input type="hidden" id="spUrl" value="<?= site_url('serviceprices?psid='); ?>">
                                <div class="col-xs-12 col-sm-4">
                                    <p style="padding-top: 10px;">Arbetsplats</p>
                                </div>
                                <div class="form-group col-xs-12 col-sm-8">
                                    <select class="form-control" id="cc-place" name="cc-place">
                                        <option value="0">Välj arbetsplats</option>
                                        <option value="1.10">Lagerhall</option>
                                        <option value="1.05">Villa</option>
                                        <option value="1.00">Skola</option>
                                        <option value="0.95">Flerbostadshus</option>
                                        <option value="0.90">Sjukhus</option>
                                    </select>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <p style="padding-top: 10px;">Byggdel</p>
                                </div>
                                <div class="form-group col-xs-12 col-sm-8">
                                    <select class="form-control" id="cc-psId" name="cc-psId" disabled="disabled">
                                        <option value="0">Välj byggdel</option>
                                    <?php 
                                    foreach($all_plumbing_services as $ps)
                                    {
                                        $selected = ($ps['id'] == $this->input->post('psId')) ? ' selected="selected"' : "";

                                        echo '<option value="'.$ps['id'].'" '.$selected.'>'.$ps['title'].'</option>';
                                    }
                                    ?>
                                    </select>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <p style="padding-top: 10px;">Arbetsmoment</p>
                                </div>
                                <div class="form-group col-xs-12 col-sm-8">
                                    <select class="form-control" id="cc-pspId" name="cc-pspId" disabled="disabled">
                                        <option value="0">Välj 	Produkt</option>
                                    <?php 
                                    /*foreach($all_plumbing_service_prices as $psp)
                                    {
                                        $selected = ($psp['id'] == $this->input->post('pspId')) ? ' selected="selected"' : "";

                                        echo '<option value="'.$psp['id'].'" '.$selected.'>'.$psp['jobTitle'].'</option>';
                                    } */
                                    ?>
                                    </select>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <small style="padding-top: 10px;">Beskrivning/small>
                                </div>
                                <div class="form-group col-xs-12 col-sm-8">
                                    <small id="cc-job-description" ></small>
                                </div>
                                <div style="height: 50px !important;" class="col-xs-12 col-sm-12 content-break">
                                    <hr style="border-top: 3px solid #eeeeee;">
                                </div>
                                <div style="text-align: center;" class="form-group col-xs-6 col-sm-6">
                                    <label>Arbetstid :</label>
                                </div>
                                <div style="text-align: center;" class="form-group col-xs-6 col-sm-6">
                                    <label id="cc-service-time">---</label>
                                </div>
                                <div style="text-align: center;" class="form-group col-xs-6 col-sm-6">
                                    <label>Kostnad :</label>
                                </div>
                                <div style="text-align: center;" class="form-group col-xs-6 col-sm-6">
                                    <label id="cc-total-cost">---</label>
                                </div>
                                <div class="clearfix"></div>
                          <?php echo form_close(); ?>
                        </div>  	
                    </div>
                </div>


            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>