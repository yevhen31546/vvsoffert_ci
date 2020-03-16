    <style>
        .btn.btn-default:hover{
                background: white;
                border-color: #ccc;
        }
    </style>
    <div class="col-xs-12 col-sm-9 table_content">
        <div class="overall_content">
            <div class="section_content">
                <div style="min-height: 960px;" class="table_header">
                    <div class="table_title fl"><i class="fa fa-tablet-alt"></i> Beräkna ungefärlig kostnad</div>
                    <div class="clearfix"></div>
                   
                   
                    <div class="row">
                                    
                        <div class="col-xs-12 col-sm-10 col-sm-offset-1" id="new_service_cost" class="signup_form">
                            <hr style="border-top: 3px solid #ff9310;">
                            <?php echo form_open(); ?>
                                <input type="hidden" id="spUrl" value="<?= site_url('serviceprices?psid='); ?>">
                                <div class="col-xs-12 col-sm-4">
                                    <small style="padding-top: 5px;">Arbetsplats</small>
                                </div>
                                <div class="form-group col-xs-12 col-sm-8">
                                    <div id="my-btns" class="btn-group" data-toggle="buttons">
                                    	<label class="btn btn-default">
                                    		<input type="radio" autocomplete="off" value="1.00/Lagerhall"> Lagerhall
                                    	</label>
                                    	<label class="btn btn-default">
                                    		<input type="radio" autocomplete="off" value="1.05/Villa"> Villa
                                    	</label>
                                    	<label class="btn btn-default">
                                    		<input type="radio" autocomplete="off" value="1.15/Skola"> Skola
                                    	</label>
                                    	<label class="btn btn-default">
                                    		<input type="radio" autocomplete="off" value="1.10/Flerbostadshus"> Flerbostadshus/kontor
                                    	</label>
                                    	<label class="btn btn-default">
                                    		<input type="radio" autocomplete="off" value="1.20/Sjukhus"> Sjukhus
                                    	</label>
                                    	<input type="hidden" id="cc-place" name="cc-place"></input>
                                    </div>
                                </div>
                                <div style="height: 5px !important;" class="col-xs-12 col-sm-12 content-break">
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <small style="padding-top: 5px;">Arbetsmoment</small>
                                </div>
                                <div class="form-group col-xs-12 col-sm-8">
                                    <select class="form-control" id="cc-psId" name="cc-psId" disabled="disabled">
                                        <option value="0">Välj arbetsmoment</option>
                                    <?php 
                                    foreach($all_plumbing_services as $ps)
                                    {
                                        $selected = ($ps['title'] . '/' . $ps['id'] == $this->input->post('cc-psId')) ? ' selected="selected"' : "";

                                        echo '<option value="'.$ps['title'] . '/' . $ps['id'] . '" '.$selected.'>'.$ps['title'].'</option>';
                                    }
                                    ?>
                                    </select>
                                </div>
                                <div style="height: 5px !important;" class="col-xs-12 col-sm-12 content-break">
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <small style="padding-top: 5px;">Installation</small>
                                </div>
                                <div class="form-group col-xs-12 col-sm-8">
                                    <select class="form-control" id="cc-pspId" name="cc-pspId" disabled="disabled">
                                        <option value="0">Välj Installation</option>
                                    <?php 
                                    /*foreach($all_plumbing_service_prices as $psp)
                                    {
                                        $selected = ($psp['id'] == $this->input->post('pspId')) ? ' selected="selected"' : "";

                                        echo '<option value="'.$psp['id'].'" '.$selected.'>'.$psp['jobTitle'].'</option>';
                                    } */
                                    ?>
                                    </select>
                                </div>
                                <div style="height: 5px !important;" class="col-xs-12 col-sm-12 content-break">
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <small style="padding-top: 5px;">Beskrivning</small>
                                </div>
                                <div style="min-height: 34px;" class="form-group col-xs-12 col-sm-8">
                                    <small id="cc-job-description" ></small>
                                </div>
                                <div style="height: 5px !important;" class="col-xs-12 col-sm-12 content-break">
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <small style="padding-top: 5px;">Kvantitet</small>
                                </div>
                                <div class="form-group col-xs-12 col-sm-8">
                                    <input type="number" class="form-control" value="1" id="cc-quantity" name="cc-quantity" disabled="disabled">
                                </div>
                                <input type="hidden" name="finalPlace" id="finalPlace">
                                <input type="hidden" name="finalService" id="finalService">
                                <input type="hidden" name="finalJob" id="finalJob">
                                <div style="height: 20px !important;" class="col-xs-12 col-sm-12 content-break">
                                    <hr style="border-top: 2px solid #eeeeee;">
                                </div>
                                <div style="height: 10px !important;" class="col-xs-12 col-sm-12 content-break">
                                </div>
                                <div style="text-align: center; display: none;" class="form-group col-xs-6 col-sm-3">
                                    <small>Arbetstid :</small>
                                </div>
                                <div style="text-align: center; display: none;" class="form-group col-xs-6 col-sm-3">
                                    <label id="cc-service-time">---</label>
                                </div>
                                <div style="text-align: center; display: none;" class="form-group col-xs-6 col-sm-3">
                                    <small>Kostnad :</small>
                                </div>
                                <div style="text-align: center; display: none;" class="form-group col-xs-6 col-sm-3">
                                    <label id="cc-total-cost">---</label>
                                </div>
                                <div style="text-align: center;" class="col-xs-12 col-sm-12">
                                    <button disabled="disabled" id="add_service" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Lägg till</button>
                                </div>
                                <div class="clearfix"></div>
                          <?php echo form_close(); ?>
                        </div>
                        <!-- <div class="col-xs-12 col-sm-2">
                            <div class="col-xs-12 col-sm-12">TIME</div>
                                <div style="height: 10px !important;" class="col-xs-12 col-sm-12 content-break">
                                </div>
                            <div class="col-xs-12 col-sm-12"><label id="cc-service-time">---</label></div>
                                <div style="height: 10px !important;" class="col-xs-12 col-sm-12 content-break">
                                </div>
                            <div class="col-xs-12 col-sm-12">TIME</div>
                                <div style="height: 10px !important;" class="col-xs-12 col-sm-12 content-break">
                                </div>
                            <div class="col-xs-12 col-sm-12">TIME</div>
                        </div> -->


                        <div style="height: 300px !important;" class="col-xs-12 col-sm-12 content-break" id="tablespace">
                        </div>
                        <div class="box col-xs-12">
                          <div class="box-inner">
                            <div class="box-title">
                                <h2>Sammanställning</h2>
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Arbetsplats</th>
                                            <th>Arbetsmoment</th>
                                            <th>Produktnamn</th>
                                            <th>Kvantitet</th>
                                            <th>Arbetstid</th>
                                            <th>Kostnad</th>
                                        </tr>
                                    </thead>
                                    <tbody id="cost_rows">
                                    </tbody>
                                </table>
                            </div>
                                <div style="height: 20px !important;" class="col-xs-12 col-sm-12 content-break">
                                </div>
                                <div style="height: 40px !important;" class="col-xs-12 col-sm-12 content-break">
                                    <hr style="border-top: 2px solid #eeeeee;">
                                </div>
                                <div style="height: 20px !important;" class="col-xs-12 col-sm-12 content-break">
                                </div>
                                <input type="hidden" name="ccTotalTime" id="ccTotalTime" value="0">
                                <input type="hidden" name="ccTotalCost" id="ccTotalCost" value="0">
                                <div style="text-align: center;" class="form-group col-xs-12 col-sm-3">
                                    <b>Totalt Arbetstid :</b>
                                </div>
                                <div style="text-align: center;" class="form-group col-xs-12 col-sm-3">
                                    <label id="cc_time">0</label>
                                </div>
                                <div style="text-align: center;" class="form-group col-xs-12 col-sm-3">
                                    <b>Totala Kostnaden :</b>
                                </div>
                                <div style="text-align: center;" class="form-group col-xs-12 col-sm-3">
                                    <label id="cc_cost">0</label>
                                </div>
                          </div>
                        </div>
                </div>


            </div>
        </div>
    </div>
</div> 
    <div class="clearfix"></div>
</div>
<script>
    $('#my-btns .btn').on('click', function(event) {
        var val = $(this).find('input').val();
        $('#cc-place').val(val);
        var place = val;
        var placeCoefficient = parseFloat(place);
        if (placeCoefficient != 0) {
            $('#cc-psId').val(0);
            $('#cc-pspId').html('<option value="0">Välj Produkt</option>');
            $('#cc-psId').prop('disabled', false);
            $('#cc-pspId').prop('disabled', false);
            $('#cc-service-time').html('0');
            $('#cc-total-cost').html('0');
            $('#cc-job-description').html('');
        } else {
            $('#cc-psId').val('0');
            $('#cc-psId').prop('disabled', true);
            $('#cc-pspId').html('<option value="0">Välj Produkt</option>');
            $('#cc-pspId').prop('disabled', true);
            $('#cc-job-description').html('');
            $('#cc-service-time').html('---');
            $('#cc-total-cost').html('---');
        }
        $('#add_service').prop('disabled', true);
    
    });
</script>
