<?php //echo base_url('user/set_invoice'); exit; ?>
    <div class="col-xs-12 col-sm-9 col-xl-10 table_content">
        <form action="<?php echo base_url('/user/set_invoice');?>" method="post" id="set_invoice" accept-charset="utf-8">
            <!-- <form action="<?//php echo base_url('/user/set_invoice');?>" method="post" id="set_invoice" accept-charset="utf-8"> -->
            <!-- <div class="overall_content"> -->
                <!-- <div class="section_content"> -->
                
                    <!-- <div class="form-wrapper"> -->
                    <!-- <div class="form-horizontal"> -->
                        <div class="form-column">
                            <?php echo form_open(); ?>
                            <!-- Baseinformation group -->
                            <!-- <fieldset> -->
                                <legend data-i18n="CompanyFormCompanySettings">Company contact details</legend>
                                <div class="form-group required">
                                    <label style = "" class="form-label control-label" data-i18n="CompanyName">Company name</label>
                                    <!-- <div class="form-input" style = "width:62.5%"> -->
                                        <input style = "width:62.5%; display:inline-block;" type="text" id="name" class="form-control" data-bind="value: company.name, enterKeyAsTab: true" maxlength="100"><span class="field-validation-error" style="display: none;"></span>
                                    <!-- </div> -->
                                </div>

                                <div class="form-group required">
                                    <label class="form-label control-label" data-i18n="AddressLabel">Address</label>
                                    <div class="form-input">
                                        <input type="text" id="adress" class="form-control" data-bind="value: company.address1, enterKeyAsTab: true" maxlength="40"><span class="field-validation-error" style="display: none;"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-input no-label">
                                        <input type="text" id="adress2" class="form-control" data-bind="value: company.address2, enterKeyAsTab: true" maxlength="40"><span class="field-validation-error" style="display: none;"></span>
                                    </div>
                                </div>

                                <div class="form-group required">
                                    <label class="form-label control-label" data-i18n="ZipCodeLabel">Postcode</label>
                                    <div class="form-input">
                                        <input id="zipCode" class="form-control" data-bind="value: company.postalCode, numeric: true, enterKeyAsTab: true" maxlength="10" type="tel"><span class="field-validation-error" style="display: none;"></span>
                                    </div>
                                </div>
                                <div class="form-group required">
                                    <label class="form-label control-label" data-i18n="City">City</label>
                                    <div class="form-input">
                                        <input type="text" id="city" class="form-control" data-bind="value: company.city, enterKeyAsTab: true" maxlength="40"><span class="field-validation-error" style="display: none;"></span>
                                    </div>
                                </div>

                                <div class="form-group" data-bind="visible: app.session.isDanish() === false &amp;&amp; !app.session.isDutch()">
                                    <label class="form-label control-label" data-i18n="Residence">Place of domicile</label>
                                    <div class="form-input">
                                        <input type="text" id="residence" class="form-control" data-bind="value: company.residence, enterKeyAsTab: true" maxlength="80"><span class="field-validation-error" style="display: none;"></span>
                                    </div>
                                </div>

                                <div class="form-group required">
                                    <label class="form-label control-label" data-i18n="PhoneNumber">Phone no</label>
                                    <div class="form-input">
                                        <input id="phoneNumber" class="form-control" data-bind="value: company.phone, numeric: true, enterKeyAsTab: true" maxlength="20" type="tel"><span class="field-validation-error" style="display: none;"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label control-label" data-i18n="Cellphone">Mobile no</label>
                                    <div class="form-input">
                                        <input id="cellPhoneNumber" class="form-control" data-bind="value: company.mobile, numeric: true, enterKeyAsTab: true" maxlength="20" type="tel"><span class="field-validation-error" style="display: none;"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label control-label" data-i18n="EmailAddress">Email address</label>
                                    <div class="form-input">
                                        <input type="email" id="email" class="form-control" data-bind="value: company.email, enterKeyAsTab: true" maxlength="255"><span class="field-validation-error" style="display: none;"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label control-label" data-i18n="Homepage">Website</label>
                                    <div class="form-input">
                                        <input type="text" id="website" class="form-control" data-bind="value: company.web, enterKeyAsTab: true" maxlength="255"><span class="field-validation-error" style="display: none;"></span>
                                    </div>
                                </div>
                            <!-- </fieldset> -->
                            <!-- <fieldset>
                                <legend data-i18n="MiscDetails">Additional company details</legend>

                                <div class="form-group">
                                    <label class="form-label control-label" data-i18n="CorporateIdentityNumber">Corporate identity no</label>
                                    <div class="form-input required">
                                        <input type="text" id="corporateIdentityNumber" class="form-control" data-bind="value: company.corporateIdentityNumber, enable: app.session.isTrial, enterKeyAsTab: true" maxlength="20"><span class="field-validation-error" style="display: none;"></span>
                                        <span class="vismaicon vismaicon-sm vismaicon-filled vismaicon-info input-information" data-toggle="tooltip" data-placement="top" data-i18n="[title]CompanySettings_VerifyCorporateIdentityNumber_ButtonInfo" data-bind="visible: !app.session.isTrial" title="" style="display: none;" data-original-title="Click the button Verify to compare the corporate identity number to the one that Visma has registered for your company earlier. If the numbers do not match you can update to the one already registered. "></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-input no-label">
                                        <button id="verifyCorporateIdentityButton" data-bind="click: verifyCorporateIdentityWithOnline, enable: app.session.isActive(), visible: !app.session.isTrial, enterKeyAsTab: true" class="btn btn-default" data-i18n="CompanySettings_VerifyCorporateIdentityNumberButtonText" style="display: none;">Verify</button>
                                    </div>
                                </div>

                                <div class="form-group" data-bind="visible: !app.session.isDutch() &amp;&amp; !app.session.isFinnish() ">
                                    <label class="form-label control-label" data-i18n="GlnLabel">GLN</label>
                                    <div class="form-input">
                                        <input id="glnNumber" class="form-control" data-bind="value: company.ediGlnNumber, numeric: true, enterKeyAsTab: true" maxlength="255" type="tel"><span class="field-validation-error" style="display: none;"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label control-label" data-i18n="LocalCurrency">Local currency</label>
                                    <div class="form-input">
                                        <span id="localCurrency" data-bind="text: company.baseCurrencyCode, enterKeyAsTab: true">SEK</span>
                                    </div>
                                </div>

                                <div class="form-group" data-bind="visible: isVatNumberAvailable()">
                                    <label class="form-label control-label" data-i18n="VatNr">VAT no</label>
                                    <div class="form-input" data-bind="visible: !app.session.isDanish() &amp;&amp; !app.session.isFinnish()">
                                        <input id="vatCode" class="form-control" data-bind="value: company.vatCode, numeric: true, enterKeyAsTab: true" maxlength="14" type="tel"><span class="field-validation-error" style="display: none;"></span>
                                    </div>
                                    <div class="form-input" data-bind="visible: app.session.isDanish() || app.session.isFinnish(), enterKeyAsTab: true" style="display: none;">
                                        <span id="corporateIdentityNumberLabel" data-bind="text: company.vatCode, enterKeyAsTab: true"></span>
                                    </div>
                                </div>
                                <div class="form-group" data-bind="visible: isBankGiroAvailable() &amp;&amp; !app.session.isDutch() &amp;&amp; !app.session.isFinnish()">
                                    <label class="form-label control-label" data-i18n="Bankgiro">Bankgiro</label>
                                    <div class="form-input">
                                        <input id="bankgiroNumber" class="form-control" data-bind="value: company.bankgiroNumber, disable: disableBankgiro(), format: 'bankgiro', numeric: true, enterKeyAsTab: true" maxlength="9" type="tel"><span class="field-validation-error" style="display: none;"></span>
                                    </div>
                                </div>

                                <div class="form-group" data-bind="visible: isPlusGiroAvailable() &amp;&amp; !app.session.isDutch() &amp;&amp; !app.session.isFinnish()">
                                    <label class="form-label control-label" data-i18n="Plusgiro">PlusGiro</label>
                                    <div class="form-input">
                                        <input id="plusgiroNumber" class="form-control" data-bind="value: company.plusgiroNumber, disable: disablePostgiro(), format: 'plusgiro', numeric: true, enterKeyAsTab: true" maxlength="12" type="tel"><span class="field-validation-error" style="display: none;"></span>
                                    </div>
                                </div>

                                <div class="form-group" data-bind="visible: app.session.isSwedish()">
                                    <label class="form-label control-label" data-i18n="Settings_CompanySettings_Swish">Swish</label>
                                    <div class="form-input">
                                        <input id="paymentMethodSwish" class="form-control" data-bind="value: company.swish, numeric: true, enterKeyAsTab: true" maxlength="20" type="tel"><span class="field-validation-error" style="display: none;"></span>
                                    </div>
                                </div>
                            </fieldset> -->
                            <input type="submit" name="submit" id="sbmt" class="reg-btn" value="Uppdatering Profil">
                            <?php echo form_close(); ?>
                        </div>
                        <!-- <div class="form-column"> -->

                            <!-- ko if: app.session.hasWebshopModule || app.session.isWebshopAccountNumberForPaymentNeeded --><!-- /ko -->
                            <!-- ko if: (app.session.canEnablePayRoll() && app.session.accessToPayslip) || (!app.session.isDanish() && (app.session.hasOrdersModule || app.session.hasQuotesModule))  -->
                            <!-- <fieldset>                               
                                <legend data-i18n="CompanyHideShowModulesLegendText">Show/Hide modules</legend>
                                <div class="form-group checkbox-form">
                                    <div class="checkbox">
                                        <label>
                                            <input id="usesQuotes" type="checkbox" data-bind="checked: company.showQuote">
                                            <span data-i18n="CompanySettingsShowQuoteCheckbox">Show the Quotes module in menu</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group checkbox-form">
                                    <div class="checkbox">
                                        <label>
                                            <input id="usesOrder" type="checkbox" data-bind="checked: company.showOrder">
                                            <span data-i18n="CompanySettingsShowOrderCheckbox">Show the Orders module in menu</span>
                                        </label>
                                    </div>
                                </div>
                            </fieldset> -->
                            <!-- ko if: showUseCompanyAsTemplate --><!-- /ko -->
                            <!-- <fieldset>
                                <legend data-i18n="ResetCompanyLegendText">Reset company</legend>

                                <div class="form-group">
                                    <div class="input-text-block" data-bind="html: i18n.t('ResetCompanyLabel')">If you reset your company, everything in the program will be deleted except your company name and corporate identity number. Your user ID and password for Visma Spcs’ web services will remain the same. Resetting the company requires administrator privileges.
                                    </div>

                                    <div class="form-input">
                                        <button id="resetCompany" data-bind="click: resetCompany, enable: app.session.isActive()" class="btn btn-default" data-i18n="ResetCompanyButtonText" title="Reset">Reset</button>
                                    </div>
                                </div>
                            </fieldset> -->
                            <!-- ko if: showOldCompany -->
                            <!-- <fieldset>
                                <legend data-i18n="Settings_Company_ArchiveOldCompaniesLegendText">Archived companies</legend>

                                <div class="form-group">
                                    <div class="input-text-block" data-bind="html: i18n.t('Settings_Company_ArchiveOldCompaniesLabel_' + app.session.countryCode)">When you have restarted your company you can access your previous company data in a read-only version. You cannot change anything in the read-only version, but have the possibility to export data.</div>

                                    <label class="form-label control-label" data-i18n="Settings_Company_OldCompanies_lbl_PreviousCompanies">Select company</label>
                                    <div class="form-input">
                                        <div id="archivedCompaniesAutoCompleteBox" data-bind="selectBox: {
                                                sourceDisplayMember: 'userNameThatRestarted',
                                                sourceType: 'array',
                                                source: oldCompanies,
                                                paging: true,
                                                groupSortColumn: 'date',
                                                showInactiveCheckbox: false,
                                                width: 442,
                                                onSelectionChanged: onOldCompanyChanged,
                                                columns: [{
                                                    datafield: 'date',
                                                    name: i18n.t('Date'),
                                                    width: '30%'
                                                },
                                                {
                                                    datafield: 'type',
                                                    name: i18n.t('Type'),
                                                    width: '30%'
                                                },
                                                {
                                                    datafield: 'userNameThatRestarted',
                                                    name: i18n.t('User'),
                                                    width: '40%'
                                                }],
                                            } " class="vismaselectboxwrapper"><div class="vismaselectbox"><div class="notAbleToAddMore"><span>Currently it is not possible to add more than 50 customers to an invoice. If you want to send it to more customers make a copy of it and add the remaining ones.</span></div><input type="text" class="inputfield" uniquenumber="undefined"><button type="button" class="buttondropdown" tabindex="-1"><div class="dropdown-image"></div></button></div></div>
                                    </div>
                                </div>
                            </fieldset> -->
                            <!-- /ko -->
                        <!-- </div> -->
                    <!-- </div> -->
                <!-- </div> -->
            <!-- </div> -->
            <!-- <div class="footer flex-footer"> -->
                <!-- <div class="button-area"> -->
                    <!-- <div class="primary-buttons"> -->
                        <input type="submit" id="saveButton" class="btn btn-success" value="Save">
                        <input class="btn btn-secondary" id="cancelButton" value="Cancel">
                    <!-- </div> -->
                <!-- </div> -->
            <!-- </div> -->
        </form>
    </div>