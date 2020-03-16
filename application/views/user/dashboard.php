<style>
    .stat-box.stat-box-red {
    background-color: #F74949;
}
.stat-box {
    background-color: #F74949;
    border-radius: 2px;
    color: #fff;
    margin: 0 0 30px 0;
    padding: 25px 30px;
    position: relative;
}
.stat-box strong {
    font-size: 34px;
    font-weight: 300;
}
.stat-box strong, .stat-box span {
    display: block;
    line-height: 1;
    overflow: hidden;
    text-align: right;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.stat-box-icon {
    bottom: 0;
    color: rgba(255, 255, 255, 0.2);
    display: block;
    font-size: 80px;
    left: 0;
    position: absolute;
    transform: translateX(-20%) translateY(20%);
}
</style>        

<div class="col-xs-12 col-sm-9 col-xl-10 table_content">
            <div class="overall_content">
                <div class="section_content">
                	<div class="table_header">
                        <div class="table_title fl">Mina sidor</div>
                        <div class="clearfix"></div>
               		</div>
                	<div class="table-responsive">
                    	<div class="stats">
            <a href="<?php echo site_url('anvandarprofil'); ?>">
                <div class="col-md-6 col-lg-4">
              <div class="stat-box stat-box-red">
                <div class="stat-box-icon"><i class="fas fa-chart-pie"></i></div>
                
                <strong>Redigera</strong> <span> Profil</span> </div>
                
            </div></a>
            <a href="<?php echo site_url('andra-losenord'); ?>">
            <div class="col-md-6 col-lg-4">
              <div class="stat-box stat-box-blue">
                <div class="stat-box-icon"><i class="far fa-gem"></i></div>
                <strong>Byt</strong> <span>Lösenord</span> </div>
            </div>
            </a>
            <a href="<?php echo site_url('article'); ?>">
            <div class="col-md-6 col-lg-4">
              <div class="stat-box stat-box-purple">
                <div class="stat-box-icon"><i class="fa fa-database"></i></div>
                <strong>Mina</strong> <span>Listor</span> </div>
            </div>
            </a>
        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>