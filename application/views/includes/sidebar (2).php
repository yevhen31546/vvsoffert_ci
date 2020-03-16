<div class="dashbaord container">
    <div>
        <div class="col-xs-12 col-sm-3 col-xl-2 dashbaord_nav no-gutter">
            <ul class="list-unstyled">
                <li><a class="<?= ($this->router->fetch_class() == 'dashboard' && $this->router->fetch_method() == 'index') ? 'active' : '' ?>" href="<?php echo site_url('kontrollpanel'); ?>">Mina sidor </a></li>
                <li><a class="<?= ($this->router->fetch_class() == 'user' && $this->router->fetch_method() == 'useraccount_details') ? 'active' : '' ?>" href="<?php echo site_url('anvandarprofil'); ?>">Anvandarprofil</a></li>
                <!--<li><a class="<?= ($this->router->fetch_class() == 'user' && $this->router->fetch_method() == 'customer') ? 'active' : '' ?>" href="<?php echo site_url('kund'); ?>">Kund</a></li>-->
                <li>
                    <a class="<?= ($this->router->fetch_class() == 'user' && $this->router->fetch_method() == 'add_list') ? 'active' : '' ?>" href="<?php echo site_url('add-list'); ?>" >Mina Projekt/Listor <!--<i class="fa fa-sort-desc pull-right"></i>--></a>
                    <ul class= "nav list" style="font-size:20px; padding-left:20px;">
                        <li><a class="<?= ($this->router->fetch_class() == 'user' && $this->router->fetch_method() == 'customer') ? 'active' : '' ?>" href="<?php echo site_url('kund'); ?>">Offterter</a></li>
                        <li><a class="<?= ($this->router->fetch_class() == 'user' && $this->router->fetch_method() == 'customer') ? 'active' : '' ?>" href="<?php echo site_url('kund'); ?>">Order</a></li>
                        <li><a class="<?= ($this->router->fetch_class() == 'user' && $this->router->fetch_method() == 'customer') ? 'active' : '' ?>" href="<?php echo site_url('kund'); ?>">Kundfakturor</a></li>
                        <li><a class="<?= ($this->router->fetch_class() == 'user' && $this->router->fetch_method() == 'customer') ? 'active' : '' ?>" href="<?php echo site_url('kund'); ?>">Kunder</a></li>
                        <li><a class="<?= ($this->router->fetch_class() == 'user' && $this->router->fetch_method() == 'customer') ? 'active' : '' ?>" href="<?php echo site_url('kund'); ?>">Artiklar</a></li>
                    </ul>
                </li>
                <li><a class="<?= ($this->router->fetch_class() == 'user' && $this->router->fetch_method() == 'change_password') ? 'active' : '' ?>" href="<?php echo site_url('andra-losenord'); ?>">Ändra lösenord </a></li>
                <li><a class="<?= ($this->router->fetch_class() == 'user' && $this->router->fetch_method() == 'import_product_rsk_excel') ? 'active' : '' ?>" href="<?php echo site_url('import-product-rsk-quantity'); ?>">Importera Produkter</a></li>
                <li><a class="<?= ($this->router->fetch_class() == 'user' && ($this->router->fetch_method() == 'import_product_rsk_price_excel' || $this->router->fetch_method() == 'import_product_rsk_estore_price_excel')) ? 'active' : '' ?>" href="<?php echo site_url('import-product-rsk-estore'); ?>">Importera egen prislista</a></li>
                <li><a class="<?= ($this->router->fetch_class() == 'user' && $this->router->fetch_method() == 'cost_caclulator') ? 'active' : '' ?>" href="<?php echo site_url('snabb-kalkyl'); ?>"> Snabb Kalkyl</a></li>
            </ul>
        </div>