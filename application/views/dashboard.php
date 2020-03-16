<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('front_css_path'); ?>jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('front_css_path'); ?>fullcalendar.css">
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('front_css_path'); ?>mdp.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('front_css_path'); ?>jquery-ui.css" />
<!--<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('front_css_path'); ?>pepper-ginder-custom.css"/>-->

<!-- Timer JS and CSS -->
<script src="<?php echo $this->config->item('front_js_path'); ?>jquery.timepicker.js"></script>
<script src="<?php echo $this->config->item('front_js_path'); ?>datepair.js"></script>
<link rel="stylesheet" type="text/css" href="https://jonthornton.github.io/jquery-timepicker/jquery.timepicker.css" />
<!-- For Growl Message -->
<script type="text/javascript">
    $(document).ready(function () {
<?php if ($this->session->flashdata('warning')) { ?>
            $.growl.warning({title: "Warning", message: "<?php echo $this->session->flashdata('warning'); ?>"});
<?php } elseif ($this->session->flashdata('welcome')) { ?>
            $.growl.notice({title: "Welcome", message: "<?php echo $this->session->flashdata('welcome'); ?>"});
<?php } elseif ($this->session->flashdata('error')) { ?>
            $.growl.error({title: "Error", message: "<?php echo $this->session->flashdata('error'); ?>"});
<?php } elseif ($this->session->flashdata('success')) { ?>
            $.growl.notice({title: "Success", message: "<?php echo $this->session->flashdata('success'); ?>"});
<?php } ?>
    });
</script>
    <!--<section class="title">	<h1>Dashboard</h1> </section>-->
<section class="attendence">
    <div class="container">
        <div class="m-b-30">
            <div class="current_status">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="promo-code"> Current Promotion Code:
                            <?php
                            if (count($promocode) > 0) {
                                foreach ($promocode as $promo) {

                                    $todaydate = date('Y-m-d');
                                    $expiredate = $promo->todate;
                                    if ($expiredate > $todaydate) {
                                        ?>
                                        <span><?php echo $promo->code . ','; ?></span>
                                        <?php
                                    }
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="current_rating">
                            <div class="col-lg-9 col-sm-6"> Current Rating: </div>
                            <div class="col-lg-3">
                                <input id="rating" name="rating" class="rate" value="<?php echo $rating; ?>" class="rating-loading">
                                <script>
                                    $(document).on('ready', function () {
                                        $('#rating').rating({displayOnly: true, step: 0.5});
                                    });
                                </script> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="gym_box">
                    <div class="gym_box_title"><?php echo $gymdata[0]->name; ?></div>
                    <div class="board">
                        <div class="board-inner">
                            <ul class="nav nav-tabs" id="myTab">
                                <li class="active col-sm-2 col-xs-6"> <a href="#classmodule" data-toggle="tab" title="Class" id="classClick"> <span class="round-tabs three"></span>
                                        <!--<div>My Booked Class</div>-->
                                        <!--infoway-->
                                        <div>Schedule Class</div>
                                        <!--infoway-->
                                    </a> </li>
                                <li class="col-sm-2 col-xs-6"> <a href="#calendarmodule" class="animate_scroll" data-toggle="tab" title="Calendar" id="calendarClick"> <span class="round-tabs two"></span>
                                        <!--<div>Edit Calendar</div>-->
                                        <!--infoway-->
                                        <div>Weekly Calendar</div>
                                        <!--infoway-->
                                    </a> </li>
                                <li class="col-sm-2 col-xs-6"> <a href="#cashOutCreditsmodule" class="animate_scroll" data-toggle="tab" title="Cash Out Credits" id="cashOutCreditClick"> <span class="round-tabs one"></span>
                                        <div>Cash Out Credits</div>
                                    </a> </li>
                                <li class="col-sm-2 col-xs-6"> <a href="#trainermodule" class="animate_scroll" data-toggle="tab" title="My Trainer" id="trainerClick"> <span class="round-tabs five"></span>
                                        <div>My Trainer</div>
                                    </a> </li>
                                <li class="col-sm-2 col-xs-6"> <a href="#locationmodule" class="animate_scroll" data-toggle="tab" title="My Location" id="locationClick"> <span class="round-tabs four"></span>
                                        <div>My Location</div>
                                    </a> </li>
                                <li class="col-sm-2 col-xs-6"> <a href="#printmemodule" class="animate_scroll" data-toggle="tab" title="Print me" id="printmeClick"> <span class="round-tabs six"></span>
                                        <div>Point Value</div>
                                    </a> </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="classmodule">
                                <div class="col-sm-12">
                                    <div class="card-box table-responsive">
                                        <!--<h4 class="m-b-20"><strong>Booked Class Details</strong></h4>-->
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <div class="add_class">
                                                    <?php if (isset($qrcodestatus) && $qrcodestatus != '0') { ?>
                                                        <!--<a class="btn add_btn" href="javascript:;" id="addClass">Click here to Add classes to your schedule</a>-->
                                                    <?php } ?>
                                                    <!--<a class="btn add_btn archiveclass" href="javascript:;" id="showArchiveData">Archive List</a>-->
                                                </div>
                                            </div>
                                        </div>
                                        <!--                                                                                <div id="normallist1">
                                                                                                                            <table id="classlist" class="table table-striped table-bordered">
                                                                                                                                <thead>
                                                                                                                                    <tr>
                                                                                                                                        <th>Service</th>
                                                                                                                                        <th>Class date</th>
                                                                                                                                        <th>Class time</th>
                                                                                                                                        <th>Trainer Name</th>
                                                                                                                                        <th>User Limit</th>
                                                                                                                                        <th>No of Booked User</th>
                                                                                                                                        <th>Status</th>
                                                                                                                                        <th width="160px;">Action</th>
                                                                                                                                    </tr>
                                                                                                                                </thead>
                                                                                                                                <tbody>
                                                                                                                                </tbody>
                                                                                                                            </table>
                                                                                                                        </div>-->
                                        <div id="normallist1">
                                            <div class="main stl-cla-top-17">
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6">

                                                        <div><strong>Booked Class Details</strong></div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 cst-fr-center">
                                                        <div class="day-class-1">
                                                            <a href="javascript:;" id="day" onclick="getBookingData(this, '1');" data-val="1" class="btn btn-default nw-act-cls">Today</a>
                                                            <a href="javascript:;" id="week" onclick="getBookingData(this, '7');" data-val="7" class="btn btn-default">Week</a>
                                                            <a href="javascript:;" id="month" onclick="getBookingData(this, '30');" data-val="30" class="btn btn-default">Month</a>
                                                            <div class="btn-only-mob">
                                                                <a href="javascript:;" id="appointment" onclick="getBookingData(this, '30');" data-val="appointment" class="btn btn-default">Appointment</a>
                                                                <a href="javascript:;" id="booking_archive" onclick="getBookingArchiveData(this);" class="btn btn-default">Archive list</a>
                                                            </div>
                                                        </div>  
                                                    </div>
                                                </div>

                                            </div>
                                            <div id="booking_list">
                                                <?php
                                                $startDate = date('Y-m-d');
                                                $user_id = $this->session->userdata('user_id');
                                                $total_loop = 1;
                                                for ($i = 0; $i < $total_loop; $i++) {
                                                    ?>
                                                    <?php
                                                    $newDate = date("Y-m-d", strtotime("+" . $i . " days", strtotime($startDate)));
                                                    $sql = 'Select bm.booking_user_id,bm.booking_id,bm.status as bm_status,bm.class_date as bm_class_date,cm.* from booking_master as bm join class_master as cm ON bm.class_id=cm.class_id where '
                                                            . 'bm.class_date="' . $newDate . '" AND '
                                                            . 'bm.user_id="' . $user_id . '" AND '
                                                            . 'cm.status!="canceled" ';
                                                    $result = $this->db->query($sql)->result();
                                                    ?>
                                                    <?php
                                                    if (count($result) > 0) {
                                                        ?>
                                                        <div class="stl-cla-top-18">
                                                            <div class="row">
                                                                <div class="col-md-6 col-md-offset-3 col-xs-12">
                                                                    <div class="text-center">
                                                                        <h2><?= date('D m/d', strtotime($newDate)) ?></h2>
                                                                        <ul>
                                                                            <?php
                                                                            foreach ($result as $k => $v) {
                                                                                $userData = getListdata(array("user_id" => $v->booking_user_id), 'user_master');
                                                                                ?>
                                                                                <input type="hidden" name="username_<?= $v->booking_id ?>" id="username_<?= $v->booking_id ?>" value="<?= $userData[0]->name . ' ' . $userData[0]->last_name ?>">
                                                                                <input type="hidden" name="timer_<?= $v->booking_id ?>" id="timer_<?= $v->booking_id ?>" value="<?= $v->timer1 ?>">
                                                                                <input type="hidden" name="classDate_<?= $v->booking_id ?>" id="classDate_<?= $v->booking_id ?>" value="<?= date('m/d/y', strtotime($newDate)) ?>">
                                                                                <?php
                                                                                if ($v->bm_status == "confirmed") {
                                                                                    ?>
                                                                                    <li class="confirmed" id="li_<?= $v->booking_id ?>">
                                                                                        <span class="cst-spn-nw-1"><?= $userData[0]->name . ' ' . $userData[0]->last_name ?> | <?= $v->timer1 ?> | <?= date('m/d/y', strtotime($newDate)) ?></span>
                                                                                        <span class="cst-spn-nw-2">CONFIRMED <i class="fa fa-check" aria-hidden="true"></i></span>
                                                                                    </li>
                                                                                <?php } else if ($v->bm_status == "canceled") { ?>
                                                                                    <li class="denied" id="li_<?= $v->booking_id ?>">
                                                                                        <span class="cst-spn-nw-1"><?= $userData[0]->name . ' ' . $userData[0]->last_name ?> | <?= $v->timer1 ?> | <?= date('m/d/y', strtotime($newDate)) ?></span>
                                                                                        <span class="cst-spn-nw-2"><i class="fa fa-ban" aria-hidden="true"></i>DENIED</span>
                                                                                    </li>
                                                                                <?php } else { ?>
                                                                                    <?php if ($v->open_floor == 0 || $v->open_floor == 1) { ?>
                                                                                        <li class="no_appointment" id="li_<?= $v->booking_id ?>">
                                                                                            <span>Scheduled Session</span>
                                                                                            <span class="fr-only-ln-bk"><?= $userData[0]->name . ' ' . $userData[0]->last_name ?> | <?= $v->timer1 ?> | <?= date('m/d/y', strtotime($newDate)) ?></span>
                                                                                            <span>
                                                                                                <div class="checkbox checkbox-warning">
                                                                                                    <input id="appointment_checkbox<?= $v->booking_id ?>" type="checkbox" onclick="bookclass_normal('<?= $v->booking_id ?>');">
                                                                                                    <label for="appointment_checkbox<?= $v->booking_id ?>">
                                                                                                        CHECK-IN
                                                                                                    </label>
                                                                                                </div>
                                                                                            </span>

                                                                                        </li> 
                                                                                    <?php } else { ?>
                                                                                        <li class="appointment" id="li_<?= $v->booking_id ?>">
                                                                                            <span>New Appointment</span>
                                                                                            <span class="fr-only-ln-bk"><?= $userData[0]->name . ' ' . $userData[0]->last_name ?> | <?= $v->timer1 ?> | <?= date('m/d/y', strtotime($newDate)) ?></span>
                                                                                            <span>
                                                                                                <div class="checkbox checkbox-warning">
                                                                                                    <input id="accept<?= $v->booking_id ?>" type="checkbox" onclick="bookclass_appointment('<?= $v->booking_id; ?>');">
                                                                                                    <label for="accept<?= $v->booking_id ?>">
                                                                                                        ACCEPT
                                                                                                    </label>
                                                                                                </div>
                                                                                                <div class="checkbox checkbox-warning">
                                                                                                    <input id="deny<?= $v->booking_id ?>" type="checkbox" onclick="denyclass('<?= $v->booking_id; ?>');">
                                                                                                    <label for="deny<?= $v->booking_id ?>">
                                                                                                        DENY
                                                                                                    </label>
                                                                                                </div>
                                                                                            </span>
                                                                                        </li> 
                                                                                    <?php } ?>


                                                                                <?php } ?>
                                                                            <?php } ?>
                                                                        </ul>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="stl-cla-top-18">
                                                            <div class="row">
                                                                <div class="col-md-6 col-md-offset-3 col-xs-12">
                                                                    <div class="text-center">
                                                                        <h2><?= date('D m/d', strtotime($newDate)) ?></h2>
                                                                        <ul>
                                                                            <li class="no_booking">
                                                                                <span>No Booking For Today</span>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </div>
                                                    <?php } ?>
                                                <?php } ?>
                                            </div>


                                            <!--booking archive list-->
                                            <div id="booking_archive_list_div" style="display:none; margin-top: 10px;">
                                                <table id="booking_archive_list_table" class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Service</th>
                                                            <th>Class date</th>
                                                            <th>Class time</th>
<!--                                                            <th>Trainer Name</th>
                                                            <th>User Limit</th>
                                                            <th>No of Booked User</th>
                                                            <th>Status</th>-->
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!--booking archive list-->



                                        </div> <!-- end normallist1 div-->

                                        <!--                                        <div id="archivelist">
                                                                                    <table id="classlistarchive" class="table table-striped table-bordered">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th>Service</th>
                                                                                                <th>Class date</th>
                                                                                                <th>Class time</th>
                                                                                                <th>Trainer Name</th>
                                                                                                <th>User Limit</th>
                                                                                                <th>No of Booked User</th>
                                                                                                <th>Status</th>
                                                                                                <th>Action</th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>-->
                                    </div>
                                </div>
                            </div><!-- classmodule End -->

                            <div class="tab-pane fade" id="calendarmodule">
                                <div class="col-sm-12 cal_add_btn">
                                    <div class="card-box p-b-0">
                                        <?php if (isset($qrcodestatus) && $qrcodestatus != '0') { ?>
                                            <a class="btn add_btn" href="javascript:void(0);" id="calendarAddClass">Click here to Add classes to your schedule</a>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="card-box new-crd-bx">
                                        <!--<div id='calendar'></div>-->
                                        <div class="choose-date clearfix" id="weekly_cal" style="margin-bottom: 10px;">
                                            <?php
                                            $weeks = array('SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT');
                                            ?>
                                            <ul class="weekly_calendar_ul">
                                                <!--li loop start-->
                                                <?php
                                                foreach ($weeks as $key => $day) {
                                                    ?>
                                                    <li class="parent_li" style="">
                                                        <div class="day_head">
                                                            <?= $day ?>
                                                        </div>
                                                        <!---loop start--->
                                                        <?php
                                                        $nowDate = date('Y-m-d');
                                                        $user_id = $this->session->userdata('user_id');
                                                        $sql = 'Select * from class_master where '
                                                                . '(FIND_IN_SET(DATE_FORMAT(`class_date`, "%a"), "' . $day . '")!=0 OR FIND_IN_SET("' . $day . '",`week_days`)!=0) AND '
                                                                . '(`class_date`>="' . $nowDate . '" OR `class_date`="0000-00-00") AND '
                                                                . '`weekly`=1 AND '
                                                                . '`status`!="canceled" AND '
                                                                . '`user_id`="' . $user_id . '" ';
                                                        $result = $this->db->query($sql)->result();
                                                        if (count($result) > 0) {
                                                            $file_data_array = [];
                                                            foreach ($result as $key => $value) {
                                                                $file_data_array[$value->class_id] = strtotime($value->timer1);
                                                            }
                                                            asort($file_data_array);
                                                            $result = [];
                                                            foreach ($file_data_array as $key => $value) {
                                                                $result1 = getListdata(array("class_id" => $key), 'class_master', '', '');
                                                                $result[] = $result1[0];
                                                            }


                                                            foreach ($result as $class_val) {
                                                                ?>
                                                                <?php
                                                                $to_time = strtotime(date('H:i', strtotime($class_val->timer2)));
                                                                $from_time = strtotime(date('H:i', strtotime($class_val->timer1)));
                                                                $time_diff = round(abs($to_time - $from_time) / 60, 2) . " min";
                                                                ?>
                                                                <div class="class_details <?= ($class_val->open_floor == 1) ? ' openfloor' : ' normal_class' ?> <?= ($time_diff >= 120) ? ' big_padding' : '' ?>">
                                                                    <!--<span><?php // echo $class_val->name.'-'.$class_val->class_id;      ?></span>-->
                                                                    <span><?php echo $class_val->name; ?></span>
                                                                    <span><?= $class_val->timer1 . '-' . $class_val->timer2; ?></span>
                                                                    <span style="font-weight: bold;"><?= ($class_val->open_floor == 1) ? 'Open floor' : '' ?></span>
                                                                    <div class="btn-wrap-new-cal">
                                                                        <a href="javascript:;" class="btn btn-danger nw-stl-btn" onclick="cancleclass_weekly('<?= $class_val->class_id ?>');"><i class="fa fa-times-circle" title="Cancel Class"></i></a>
                                                                        <a href="javascript:;" class="btn btn-blue nw-stl-btn" id="edit" onclick="editclass('<?= $class_val->class_id ?>');"><i class="fa fa-pencil" title="Edit Class"></i></a>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                            }
                                                        } else {
                                                            ?>
                                                            <span class="no_class">No Class</span>
                                                        <?php } ?>
                                                        <!---loop end--->
                                                    </li>
                                                    <!--li loop end-->
                                                    <?php
                                                }
                                                ?>
                                            </ul>

                                        </div>
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <div class="add_class">
                                                    <?php if (isset($qrcodestatus) && $qrcodestatus != '0') { ?>
                                                        <a class="btn add_btn" href="javascript:;" id="addClass">Add Single Class</a>
                                                    <?php } ?>
                                                    <a class="btn add_btn archiveclass" href="javascript:;" id="showArchiveData">Archive List</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="normallist" class="table-responsive" style="margin-top: 8px;">
                                            <table id="classlist_weekly" class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Service</th>
                                                        <th>Class date</th>
                                                        <th>Class time</th>
<!--                                                        <th>Trainer Name</th>
                                                        <th>User Limit</th>
                                                        <th>No of Booked User</th>
                                                        <th>Status</th>-->
                                                        <th>Action</th>
                                                        <!--<th width="160px;">Action</th>-->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div id="archivelist">
                                            <table id="classlistarchive" class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Service</th>
                                                        <th>Class date</th>
                                                        <th>Class time</th>
                                                        <th>Trainer Name</th>
                                                        <th>User Limit</th>
                                                        <th>No of Booked User</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>


                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="cashOutCreditsmodule">
                                <div class="col-sm-12">
                                    <div class="card-box table-responsive">
                                        <h4 class="m-b-20"><strong>Cash out Credit Details</strong></h4>
                                        <table class="table table-striped  table-bordered m-t-b-20">
                                            <thead>
                                                <tr>
                                                    <!-- Ramon[9/28/17]:: SHow number of Hopper Visits                       
                                                                        <!-- <th>Points</th>-->
                                                    <th>Hopper Visits</th>
                                                    <th>$Value</th>
                                                    <th>Updated Date</th>
                                                    <th>Details</th>
                                                </tr>
                                            </thead>
                                            <tbody id="cashOutCreditlist">
                                            </tbody>
                                        </table>
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Cash Value</th>
                                                    <th>Transaction Id</th>
                                                    <!--<th>Remaining $Values</th>-->
                                                    <th>Date Paid</th>
                                                    <th>Request Date</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody id="cashOutCreditPayoutlist">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="trainermodule">
                                <div class="col-sm-12">
                                    <div class="card-box table-responsive">
                                        <h4 class="m-b-20"><strong>Trainer Details</strong></h4>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="add_class"> <a class="btn add_btn" href="javascript:;" id="addTrainer">Add Trainer</a> </div>
                                            </div>
                                        </div>
                                        <table id="trainerlist" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Contact</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="locationmodule">
                                <div class="col-sm-12">
                                    <div class="card-box table-responsive">
                                        <div class="map_details">
                                            <div id="map_canvas" style="width: 100%; height: 100%"></div>
                                        </div>
                                        <input type="hidden" name="hdn_default_lat" id="hdn_default_lat" value="<?php echo $default_latitude; ?>">
                                        <input type="hidden" name="hdn_default_long" id="hdn_default_long" value="<?php echo $default_longitude; ?>">
                                        <input type="hidden" name="hdn_service_img" id="hdn_service_img" value="<?php echo $gymdata[0]->serviceimage; ?>">
                                        <h4 class="m-b-10"><strong>My Location Details</strong></h4>
                                        <?php
                                        echo validation_errors();
                                        if ($this->session->flashdata('success')) {
                                            echo '<div class="alert alert-success">' . $this->session->flashdata("success") . '</div>';
                                        }
                                        if ($this->session->flashdata('error')) {
                                            echo '<div class="alert alert-danger">' . $this->session->flashdata("error") . '</div>';
                                        }
                                        ?>
                                        <div class="row">
                                            <div class="col-sm-12 m-b-10">
                                                <table class="table table-bordered table-striped">
                                                    <tr>
                                                        <th>Registered Address</th>
                                                        <th>City</th>
                                                        <th>State</th>
                                                        <th>Country</th>
                                                        <th>Zipcode</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    <tr>

                                                        <td><?php echo $gymdata[0]->address; ?></td>
                                                        <td><?php echo $gymdata[0]->city; ?></td>
                                                        <td><?php echo $gymdata[0]->state; ?></td>
                                                        <td><?php echo $gymdata[0]->country; ?></td>
                                                        <td><?php echo $gymdata[0]->zipcode; ?></td>
                                                        <td><a class="btn btn-grey" href="<?php echo $this->config->item('base_url'); ?>gymeditprofile">Go to Profile</a></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>

                                        <hr class="brd-btm" />

                                        <!--<div class="row">
                                          <div class="col-sm-3">
                                            <div class="add_class"> <a class="btn add_btn" href="javascript:;" id="addLocation">Add Location</a> </div>
                                          </div>
                                        </div>
                                        <table id="locationlist" class="table table-striped table-bordered">
                                          <thead>
                                            <tr>
                                              <th>Address</th>
                                              <th>City</th>
                                              <th>State</th>
                                              <th>Country</th>
                                              <th>Zipcode</th>
                                              <!--<th>Default</th>--
                                              <th>Action</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                          </tbody>
                                        </table>-->
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="printmemodule">
                                <div class="col-sm-12">
                                    <div class="card-box">
                                        <?php //if(count($qrcodelist) == 0){ ?>
                                        <form action="" name="printform" method="post" id="class_add">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Type Service:</label>
                                                        <select class="form-control" name="printservicetype" id="printservicetype">
                                                            <option value="">Service Type</option>
                                                            <?php foreach ($services as $ser) { ?>
                                                                <option value="<?php echo $ser->service_id; ?>" <?php
                                                                if (isset($gymdata[0]->service_id) && $gymdata[0]->service_id == $ser->service_id) {
                                                                    echo "selected=selected";
                                                                }
                                                                ?> ><?php echo $ser->name; ?></option>
                                                                    <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="ontrol-label">Type of class:</label>
                                                        <select class="form-control" name="typeofclass" id="typeofclass">
                                                            <option value="">Type of Class</option>
                                                            <?php foreach ($classtype as $type) { ?>
                                                                <option value="<?php echo $type->class_type_id; ?>"  <?php
                                                                if (isset($gymdata[0]->class_type_id) && $gymdata[0]->class_type_id == $type->class_type_id) {
                                                                    echo "selected=selected";
                                                                }
                                                                ?>><?php echo $type->name; ?></option>
                                                                    <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Gym's current monthly membership price :</label>
                                                        <input class="form-control" type="text" name="monthly_price" id="monthly_price" value="<?php
                                                        if (count($qrcodelist) > 0) {
                                                            echo $qrcodelist[0]->monthly_price;
                                                        }
                                                        ?>">
                                                        <span class="help-block" id="monthly_price" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <button type="button" name="sbmt_print" id="sbmt_print" class="btn btn-grey m-t-5" onclick="savePoints();">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="table-responsive">
                                                    <h4 class="m-b-20"><strong>Qrcode Details</strong></h4>
                                                    <table class="table table-striped table-bordered m-t-b-20">
                                                        <thead>
                                                            <tr>
                                                                <th>Created Date</th>
                                                                <th>Name</th>
                                                                <th>Class</th>
                                                                <th>Service</th>
                                                                <th>Monthly Price</th>
                                                                <th>Class Point</th>
                                                                <th>Cancel Message</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="qrcodedetails">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row m-t-20 qr-code-image"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- My Booked Class Modal Popup Start Here -->
<div class="modal fade" id="add_class" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close close_2" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Class</h4>
            </div>
            <div class="modal-body">
                <!--<form action="" method="post" id="class_add">-->
                <form action="" method="post" id="class_add_new">
                    <!--1 for weekly 0 for single class-->
                    <input type="hidden" id="single_or_weekly_class" name="single_or_weekly_class" value="" placeholder="1=>weekly 0 =>single class">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Class Name:</label>
                                <input class="form-control" type="text" name="class_name" id="class_name">
                                <span class="help-block" id="class_name" /> </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Trainer Name:</label>
                                <select class="form-control" name="trainer_id" id="trainer_id">
                                    <option value="0">--- Select Trainer ---</option>
                                    <?php
//pr($trainer_list_data);
                                    foreach ($trainer_list_data as $trainerListData) {
                                        ?>
                                        <option value="<?php echo $trainerListData->trainer_id; ?>"><?php echo $trainerListData->name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!--infoway-->
                    <div class="row weekly_class" style="display:none;">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label" class="class_type new-lbl-cls">Class Type:</label>
<!--                                <input type="radio" name="class_type" value="0">Class or
                                <input type="radio" name="class_type" value="1">Open Floor-->
                                <div class="row"></div>
                                <div class="radio radio-primary rd-for-inline">
                                    <input type="radio" name="class_or_openfloor" id="radio1" value="0">
                                    <label for="radio1">
                                        Class or
                                    </label>
                                </div>
                                <div class="radio radio-primary rd-for-inline">
                                    <input type="radio" name="class_or_openfloor" id="radio2" value="1">
                                    <label for="radio2">
                                        Open Floor
                                    </label>
                                </div>
                                <div class="radio radio-primary rd-for-inline">
                                    <input type="radio" name="class_or_openfloor" id="radio3" value="2">
                                    <label for="radio3">
                                        Appointment
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row lst-for-btm1" id="basicExample">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Select Day:</label>
                                        <?php
                                        $weeks = array('SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT');
                                        ?>
                                        <ul class="weekdays_ul list-inline nw-li-cls">
                                            <?php
                                            foreach ($weeks as $key => $value) {
                                                ?>
                                                <li id="<?= $value ?>" data-val="<?= $value ?>" class="" onclick="weekdaysClick(this)"><?= $value ?></li>
                                                <?php
                                            }
                                            ?>
                                        </ul>
                                        <input type="hidden" name="week_days" id="week_days" value="" readonly="readonly">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--infoway-->



                    <div class="row">
<!--                        <div class="col-sm-6 weekly_class" style="display:none;">
                            <div class="form-group">
                                <label class="control-label">Appointment:</label>
                                <div class="checkbox checkbox-warning">
                                    <input id="appointment_checkbox" type="checkbox" onclick="appointmentCheck();">
                                    <label for="appointment_checkbox" class="custom_appointment_22">
                                        Appointment
                                    </label>
                                </div>
                                <input type="hidden" name="appointment" id="appointment" value="0">
                            </div>
                        </div>-->
                        <div class="col-sm-6 class_date">
                            <div class="form-group">
                                <label class="control-label">Class Date:</label>
                                <div class="multidate">
                                    <input id="multidates" name="multidates" class="box form-control" type="text" />
                                    <i class="fa fa-calendar calendar_icon"></i>
                                    <input type="text" name="singledates" id="singledates" class="box form-control" style="display:none;">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row" id="basicExample">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Start Time:</label>
                                        <input type="text" class="time start form-control" name="timepicker1" id="timepicker1" />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label class="control-label">End Time:</label>
                                    <input type="text" class="time end form-control" name="timepicker2" id="timepicker2" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Description:</label>
                                <textarea class="form-control" cols="4"  name="description" id="description"></textarea>
                                <span class="help-block" id="description" /> </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">User Limit:</label>
                                <input class="form-control" type="text" name="user_limit" id="user_limit">
                                <span class="help-block" id="user_limit" /> </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Type of class:</label>
                                <select class="form-control" name="servicetype" id="servicetype">
                                    <option value="0">--- Class types ---</option>
                                    <?php
//echo "<pre>";print_r($services);exit;
                                    foreach ($services as $ser) {
                                        ?>
                                        <option value="<?php echo $ser->service_id; ?>"><?php echo $ser->name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="hdn_gym_user_id" id="hdn_gym_user_id" value="<?php echo $this->session->userdata('user_id'); ?>">
                    <input type="hidden" name="hdn_class_id" id="hdn_class_id" value="">
                    <input type="hidden" name="hdn_class_type" id="hdn_class_type" value="Add">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <button type="button" name="sbmt_class" id="sbmt_class" class="btn btn-primary nw-pp-btn" onclick="saveClass();">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- My Booked Class Modal Popup End Here --> 

<!-- My Booked Class for User Details Modal Popup Start Here -->
<div class="modal fade" id="user_details" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">User Details</h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Date Time</th>
                                <th>Status</th>
                                <th>Used Points</th>
                            </tr>
                        </thead>
                        <tbody id="userdetail">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- My Booked Class User Details Modal Popup End Here --> 

<!-- Cash out Credits Modal Popup Start Here -->
<div class="modal fade" id="request_popup" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Cash Request Details</h4>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="request_popup_add">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Cash $Value:</label>
                                <input class="form-control" type="text" name="cash_value" id="cash_value" readonly>
                                <span class="help-block" id="price" /> </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Points:</label>
                                <input class="form-control" type="text" name="point" id="point" readonly>
                                <span class="help-block" id="price" /> </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Message:</label>
                                <textarea class="form-control" cols="5" name="message" id="message"></textarea>
                                <span class="help-block" id="msg" /> </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Date Range:</label>
                                <input class="form-control" type="text" name="date" id="date" value="<?php echo date('Y-m-d'); ?>" readonly>
                                <span class="help-block" id="msg" /> </div>
                        </div>
                    </div>
                    <input type="hidden" name="" id="">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input class="form-control" type="hidden" name="account_num" id="account_num">
                                <input class="form-control" type="hidden" name="bank_name" id="bank_name">
                                <input class="form-control" type="hidden" name="ifsc_code" id="ifsc_code">
                                <input type="button" name="sbmt_request" id="sbmt_request" value="Submit" class="btn btn-primary" onclick="saveGymPointChat();">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Cash out Credits Modal Popup End Here --> 

<!-- Location Modal Popup Start Here -->
<div class="modal fade" id="add_location" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Location</h4>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="location_add">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Address:</label>
                                <input id="address" name="address" type="text" size="50" class="google_location form-control" placeholder="Enter a location" autocomplete="on" runat="server" />  
                                <input type="hidden" id="city2" name="city2" />
                                <input type="hidden" id="cityLat" name="cityLat" />
                                <input type="hidden" id="cityLng" name="cityLng" />  
                                <span class="help-block" id="address" /> </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">City:</label>
                                <input class="form-control" type="text" name="city" id="city">
                                <span class="help-block" id="city" /> </div>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">State:</label>
                                <input class="form-control" type="text" name="state" id="state">
                                <span class="help-block" id="state" /> </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Zipcode:</label>
                                <input class="form-control" type="text" name="zipcode" id="zipcode">
                                <span class="help-block" id="zipcode" /> </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Country:</label>
                                <input class="form-control" type="text" name="country" id="country">
                                <span class="help-block" id="country" /> </div>
                        </div>

                    </div>

                    <input type="hidden" name="hdn_location_id" id="hdn_location_id" value="">
                    <input type="hidden" name="hdn_location_type" id="hdn_location_type" value="Add">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="button" name="sbmt_location" id="sbmt_location" value="Submit" class="btn btn-primary" onclick="saveLocation();">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyAniNJCKF6qNWYUSNZuxrWJ--ZtF9T7OoQ" type="text/javascript"></script>

<script type="text/javascript">
                                    function initialize() {

                                        var options = {
                                            //types: ['(cities)'],
                                            componentRestrictions: {country: "us"}
                                        };

                                        var input = document.getElementById('address');
                                        var autocomplete = new google.maps.places.Autocomplete(input, options);
                                        google.maps.event.addListener(autocomplete, 'place_changed', function () {

                                            var place = autocomplete.getPlace();
                                            var a = place.address_components;
                                            var zipcode = "";
                                            var city = "";
                                            var state = "";
                                            var country = "";

                                            $.each(a, function (key, value) {

                                                if (value.types == "locality,political") {
                                                    city = value.long_name; // city
                                                }

                                                if (value.types == "administrative_area_level_1,political") {
                                                    state = value.long_name; // state
                                                }

                                                if (value.types == "country,political") {
                                                    country = value.short_name; // country
                                                }

                                                if (value.types == "postal_code") {
                                                    zipcode = value.long_name;
                                                }
                                            });

                                            $("#city").val(city);
                                            $("#state").val(state);
                                            $("#country").val(country);
                                            $("#zipcode").val(zipcode);

                                            document.getElementById('city2').value = place.name;
                                            document.getElementById('cityLat').value = place.geometry.location.lat();
                                            document.getElementById('cityLng').value = place.geometry.location.lng();
                                        });
                                    }
                                    google.maps.event.addDomListener(window, 'load', initialize);
</script>

<!-- Location Modal Popup End Here --> 

<!-- Trainer Modal Popup Start Here -->
<div class="modal fade" id="add_trainer" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Trainer</h4>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="trainer_add">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Name:</label>
                                <input class="form-control" type="text" name="tname" id="tname">
                                <span class="help-block" id="tname" /> </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Email:</label>
                                <input class="form-control" type="text" name="temail" id="temail">
                                <span class="help-block" id="temail" /> </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Contact:</label>
                                <input class="form-control" type="text" name="tcontact" id="tcontact">
                                <span class="help-block" id="tcontact" /> </div>
                        </div>
                    </div>
                    <input type="hidden" name="hdn_trainer_id" id="hdn_trainer_id" value="">
                    <input type="hidden" name="hdn_trainer_type" id="hdn_trainer_type" value="Add">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="button" name="sbmt_trainer" id="sbmt_trainer" value="Submit" class="btn btn-primary" onclick="saveTrainer();">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Trainer Modal Popup End Here --> 

<!--Datatable Jquery Start--> 
<script src="<?php echo $this->config->item('front_js_path'); ?>jquery.dataTables.min.js"></script> 
<script src="<?php echo $this->config->item('front_js_path'); ?>dataTables.bootstrap.js"></script> 
<!--Datatable Jquery End--> 

<!--Calendar Jquery Start--> 
<script src="<?php echo $this->config->item('front_js_path'); ?>moment.min.js"></script> 
<script src="<?php echo $this->config->item('front_js_path'); ?>fullcalendar.min.js"></script> 
<!--Calendar Jquery End--> 

<script type="text/javascript">
                                    /*  function resize(){
                                     alert('resize called');
                                     var width = $(window).width();
                                     alert(width);
                                     if(width >= 300 && width <= 800){
                                     $('.editon').parents('.fc-day-grid-event fc-h-event fc-event fc-start fc-end').removeClass('hidden-xs');
                                     }
                                     else{
                                     $('.editon').parents('.fc-day-grid-event fc-h-event fc-event fc-start fc-end').removeClass('hidden-xs');
                                     }
                                     }
                                     resize();//trigger the resize event on page load. */
                                    $("#archivelist").css("display", "none");
                                    $(document).ready(function () {
                                        classListData();
                                        classListArchiveData();
                                        multicalender();

                                        $(document).on('click', '#showArchiveData', function () {
                                            if ("Archive List" == $("#showArchiveData").text())
                                            {
                                                $("#showArchiveData").text("Unarchive List");
                                                $("#normallist").css("display", "none");
                                                $("#archivelist").css("display", "block");
                                            } else {
                                                $("#showArchiveData").text("Archive List");
                                                $("#normallist").css("display", "block");
                                                $("#archivelist").css("display", "none");
                                            }

                                            $(window).bind('resize', function () {
                                                archivetable.fnAdjustColumnSizing();
                                            });
                                        });
                                    });

                                    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                                        moveMarkerMap();
                                    });
</script> 

<!-- loads jquery and jquery ui --> 
<script type="text/javascript" src="<?php echo $this->config->item('front_js_path'); ?>jquery-ui-1.11.1.js"></script> 
<script type="text/javascript" src="<?php echo $this->config->item('front_js_path'); ?>jquery-ui.multidatespicker.js"></script> 
<script>

                                    /* function openmodal(point){
                                     $("#hdn_remain_value").val(point);
                                     alert(point);
                                     } */

                                    function generteqrcode(obj) {
                                        var user_id = $(obj).attr("data-userid");
                                        var qr_code_id = $(obj).attr("data-qr_code_id");
                                        $.ajax({
                                            url: '<?php echo base_url(); ?>dashboard/generteqrcode',
                                            //dataType: 'json',
                                            type: 'post',
                                            data: {user_id: user_id, qr_code_id: qr_code_id},
                                            success: function (data) {
                                                //alert("Response "+data)
                                                funprintme();
                                            }
                                        });
                                    }

                                    function multicalender(flag) {
                                        $('#multidates').multiDatesPicker({
                                            showAnim: "", // Disables the show/hide animation.
                                            dateFormat: "mm/dd/yy",
                                            minDate: "0",
                                            multidate: true,
                                            defaultDate: "0d",
                                            rangeSelect: 'false',
                                            onSelect: function (dates) {

                                                var datepickerObj = $(this).data("datepicker");
                                                var datepickerSettings = datepickerObj.settings;

                                                // Get the last date picked.
                                                var tempDay = datepickerObj.selectedDay;
                                                var tempMonth = datepickerObj.selectedMonth + 1;
                                                var tempYear = datepickerObj.selectedYear;
                                                var pickedDate = tempMonth + "/" + tempDay + "/" + tempYear;

                                                // Remove previous "defaultDate" property.
                                                delete datepickerSettings["defaultDate"];

                                                // Add a new defaultDate property : value.
                                                datepickerSettings.defaultDate = pickedDate;
                                                // "Hacky trick" to avoid having to click twice on prev/next month.
                                                $("#multidates").blur();
                                                setTimeout(function () {
                                                    $("#multidates").focus();
                                                }, 1);								// 1 millisecond delay seems to be enought!!!
                                            }
                                        });
                                    }

                                    $('#basicExample .time').timepicker({
                                        'showDuration': true,
                                        'timeFormat': 'g:ia'
                                    });

                                    $("#singledates").datepicker({
                                        showAnim: "", // Disables the show/hide animation.
                                        dateFormat: "mm/dd/yy",
                                        minDate: "0",
                                        multidate: true,
                                        defaultDate: "0d",
                                        rangeSelect: 'false'
                                    });

                                    var basicExampleEl = document.getElementById('basicExample');
                                    var datepair = new Datepair(basicExampleEl);
</script>

<script>
    function moveMarkerMap() {

        $.ajax({
            url: '<?php echo base_url(); ?>dashboard/getLocations',
            dataType: 'json',
            type: 'post',
            success: function (data) {
                //alert(data); return false;
                latti = $("#hdn_default_lat").val();
                longi = $("#hdn_default_long").val();
                serviceimg = '<?php echo $this->config->item('front_image_path'); ?>' + $("#hdn_service_img").val();

                var map = new google.maps.Map(document.getElementById('map_canvas'), {
                    center: new google.maps.LatLng(latti, longi),
                    zoom: 2
                });

                var beaches = data;
                var infowindow = new google.maps.InfoWindow();
                var image = {
                    url: serviceimg,
                    size: new google.maps.Size(20, 32),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(0, 32)
                };
                for (var i = 0; i < beaches.length; i++) {
                    var beach = beaches[i];
                    var marker = new google.maps.Marker({
                        position: {lat: beach[0], lng: beach[1]},
                        map: map,
                        icon: serviceimg,
                    });
                }
            },
        });
    }
</script> 
<script>
    $(document).ready(function () {
        $('html, body').animate({scrollTop: '+=320px'}, 800);
    });
</script>
<script>
    $(".animate_scroll").click(function (event) {
        $('html, body').animate({scrollTop: '+=200px'}, 800);
    });
    function appointmentCheck() {
        if ($('#appointment_checkbox:checked').val() == 'on') {
            $('#appointment').val('1');
        } else {
            $('#appointment').val('0');
        }
    }
    function bookclass_normal(booking_id) {
        $('#booking_list').show();
        $('#booking_archive_list_div').hide();
        var status = '1';
        var username = $('#username_' + booking_id).val();
        var timer = $('#timer_' + booking_id).val();
        var classDate = $('#classDate_' + booking_id).val();
        $('#li_' + booking_id).removeClass();
        $('#li_' + booking_id).addClass('confirmed');
        $('#li_' + booking_id).html('<span class="cst-spn-nw-1">' + username + ' | ' + timer + ' | ' + classDate + '</span>' +
                '<span class="cst-spn-nw-2">CONFIRMED <i class="fa fa-check" aria-hidden="true"></i></span>');
        $.ajax({
            url: '<?php echo base_url(); ?>dashboard/updateBookingStatusNormal',
            data: {"booking_id": booking_id,
                "chkValue": status},
            type: 'post',
            success: function (data) {
//			alert(data);
//			location.reload(); 
            },
        });
    }
    function bookclass_appointment(booking_id) {
        $('#booking_list').show();
        $('#booking_archive_list_div').hide();
        var status = '1';
        var username = $('#username_' + booking_id).val();
        var timer = $('#timer_' + booking_id).val();
        var classDate = $('#classDate_' + booking_id).val();
        $('#li_' + booking_id).removeClass();
        $('#li_' + booking_id).addClass('confirmed');
        $('#li_' + booking_id).html('<span class="cst-spn-nw-1">' + username + ' | ' + timer + ' | ' + classDate + '</span>' +
                '<span class="cst-spn-nw-2">CONFIRMED <i class="fa fa-check" aria-hidden="true"></i></span>');
        $.ajax({
            url: '<?php echo base_url(); ?>dashboard/updateBookingStatusAppointment',
            data: {"booking_id": booking_id,
                "chkValue": status},
            type: 'post',
            success: function (data) {
//			alert(data);
//			location.reload(); 
            },
        });
    }
    function denyclass(booking_id) {
    $('#booking_list').show();
    $('#booking_archive_list_div').hide();
        var status = '2';
        var username = $('#username_' + booking_id).val();
        var timer = $('#timer_' + booking_id).val();
        var classDate = $('#classDate_' + booking_id).val();
        $('#li_' + booking_id).removeClass();
        $('#li_' + booking_id).addClass('denied');
        $('#li_' + booking_id).html('<span class="cst-spn-nw-1">' + username + ' | ' + timer + ' | ' + classDate + '</span>' +
                '<span class="cst-spn-nw-2"><i class="fa fa-ban" aria-hidden="true"></i>DENIED</span>');
        $.ajax({
            url: '<?php echo base_url(); ?>dashboard/updateBookingStatusDeny',
            data: {"booking_id": booking_id,
                "chkValue": status},
            type: 'post',
            success: function (data) {
//			alert(data);
//			location.reload(); 
            },
        });
    }

    function getBookingData(item, loop_count) {
    $('#booking_list').show();
    $('#booking_archive_list_div').hide();
        loader_start();
        var val = $("#" + item.id).attr('data-val');
        $.ajax({
            url: '<?php echo base_url(); ?>dashboard/getBookingData',
            data: {"loop_count": loop_count, "val": val},
            type: 'post',
            success: function (data) {
                $('#booking_list').html(data);
                $('.day-class-1 a').removeClass('nw-act-cls');
                $("#" + item.id).addClass('nw-act-cls');
                loader_stop();
            },
        });
    }

    function getBookingArchiveData(item) {
                $('.day-class-1 a').removeClass('nw-act-cls');
                $("#" + item.id).addClass('nw-act-cls');
    $('#booking_list').hide();
    $('#booking_archive_list_div').show();
        //Start: Load datatable content using ajax calling
        archivetable = $('#booking_archive_list_table').DataTable({
            "ajax": base_url() + '/dashboard/getBookingListArchiveData',
            "oLanguage": {
                "sSearch": "Search:",
                "sEmptyTable": "No Class Available!"
            },
            "pagingType": "full_numbers",
            //"aLengthMenu": [[2, 5, 10, 15, 20, 25, 30,50, 100, 150, 200, 500, -1], [2, 5, 10, 15, 20, 25, 30, 50, 100, 150, 200, 500, "All"]],
            "iDisplayLength": 30,
            "sPaginationType": "full_numbers",
            "bLengthChange": false,
            "dom": 'T<"clear">lfrtip',
            "columnDefs": [
                {orderable: false, targets: -1},
            ],
            "columns": [
                {"data": "service"},
                {"data": "class_date"},
                {"data": "time"},
//                {"data": "trainer_name"},
//                {"data": "user_limit"},
//                {"data": "bookedusercnt"},
                //{"data": "description"},
//                {"data": "status"},
                {"data": "caction"}
            ],
            "fnDrawCallback": function () {
                // Show pagination if more data coming from database and that data count it greater than iDisplayLength that you define
                var $paginate = this.siblings('.dataTables_paginate');

                if (this.api().data().length <= this.fnSettings()._iDisplayLength) {
                    $paginate.hide();
                } else {
                    $paginate.show();
                }
            },
            "bDestroy": true
        });
    }

</script>