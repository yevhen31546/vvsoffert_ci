<?php //echo base_url('assets/css/magnific-popup.css'); exit; ?>
    <div class="col-xs-12 col-sm-9 col-xl-10 table_content">
        <!-- <form action="<?php echo base_url('/user/set_invoice');?>" method="post" id="set_invoice" accept-charset="utf-8"> -->
        <form action="https://vvsoffert.se/user/add_new_project" method="post" id="set_invoice" accept-charset="utf-8">
            <div class="overall_content">
                <div class="section_content">
                    <div class="form-wrapper">
                        <div class="form-horizontal">
                            <div class="form-column">
                                <fieldset>
                                    <legend data-i28n="SalesSettings">Sales invoicing</legend>
                                    <!-- <hr style="border-top: 3px solid #ff9310;"> -->

                                    <div class="form-group checkbox-form" data-bind="visible: isFTaxCardAvailable()">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" id="hasFTaxCard" data-bind="checked: company.hasFTaxCard, enterKeyAsTab: true">
                                                <span data-i18n="HasFTax">Approved for F-tax</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group checkbox-form" data-bind="visible: isReverseChargeOnConstructionServicesAvailable()">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" id="usesReverseConstructionVat" data-bind="checked: company.usesReverseConstructionVat, enterKeyAsTab: true">
                                                <span data-i18n="HasReverseConstructionVat">Construction sector, VAT reverse charge rules apply</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group checkbox-form" data-bind="visible: isMiddlemansSaleOfGoodsAvailable">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" id="usesMiddlemansSaleOfGoodsEc" data-bind="checked: company.usesMiddlemansSaleOfGoodsEc, enterKeyAsTab: true">
                                                <span data-i18n="MiddlemansSaleOfGoodsEc">EU intermediary, VAT triangulation rules apply</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group checkbox-form" data-bind="visible: showUsesMossCheckbox">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" id="usesMoss" data-bind="checked: company.usesMoss, enterKeyAsTab: true">
                                                <span data-i18n="Settings_Company_ckb_label_Moss">Telecom, broadcasting and electronic services, MOSS rules apply</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group checkbox-form" data-bind="visible: !app.session.isFinnish()">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" id="showPricesExclVatPC" data-bind="checked: company.showPricesExclVatPC, enterKeyAsTab: true">
                                                <span data-i18n="Settings_Company_ckb_label_ShowPricesExclVatPC">Show prices excl. VAT for private individuals</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group checkbox-form" data-bind="visible: app.session.hasProductVariantInvoicingCollaboration() &amp;&amp; app.session.isAdvisorOrBirastodtConsultant" style="display: none;">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" id="allowEndUserToRecordPaymentCheckbox" data-bind="checked: company.allowEndUserToRecordPayment, enterKeyAsTab: true">
                                                <span data-i18n="Settings_Company_ckb_label_AllowEndUserToRecordPaymet">Allow client to record invoice payments</span>
                                                <span style="top:-0.7px" class="vismaicon vismaicon-sm vismaicon-filled vismaicon-info" data-toggle="tooltip" data-placement="top" data-i18n="[title]CompanySettings_AllowUserToRecordPayment_ButtonInfo" title="" data-original-title="Check this box to allow your client to record payments of invoices. If the box is not checked, the client will only be able to create invoices."></span>
                                            </label>
                                        </div>

                                    </div>

                                    <div class="form-group" data-bind="if: showInvoiceRoundingSettings()">
                                        <label class="form-label control-label" data-i18n="CompanySettings_InvoiceSettings_lbl_RoundingSettings">Rounding</label>
                                        <div class="form-input">
                                            <span class="select-wrapper"><select id="invoiceRoundingSettingsDropdown" class="custom hasCustomSelect" data-bind="options: invoiceRoundingSettings, optionsText: 'name', optionsValue: 'id', value: company.domesticCurrencyRounding, enterKeyAsTab: true" style="-webkit-appearance: menulist-button; position: absolute; opacity: 0;"><option value="0">No rounding</option><option value="1">Round to nearest krona</option></select><span class="holder customSelect custom" style="display: inline-block;"><span class="customSelectInner" style="display: inline-block;">Round to nearest krona</span></span></span><span class="field-validation-error" style="display: none;"></span>
                                        </div>
                                    </div>

                                </fieldset>
                                <!-- ko if: isRotReductionAvailable()-->
                                <fieldset>
                                    <legend data-i18n="Settings_CompanySettings_legend_HouseWork">Domestic services</legend>

                                    <div class="form-group checkbox-form" data-bind="visible: isRotReductionAvailable()">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" id="usesRotReducedInvoicing" data-bind="checked: company.usesRotReducedInvoicing, enterKeyAsTab: true">
                                                <span data-i18n="HasRotReducedInvoicing">Domestic services to private individuals, ROT/RUT rules apply</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div data-bind="visible: company.usesRotReducedInvoicing() &amp;&amp; isRotReductionAvailable()" style="display: none;">
                                        <div class="form-group"><span class="form-label control-label" data-i18n="Settings_Company_InvoiceSettings_RutWork">RUT entitlement</span></div>
                                        <div class="form-group">
                                            <label class="form-label control-label" data-i18n="Settings_Company_InvoiceSettings_PrivatePersonAgeBelow65">Limit, buyers under 65 y/o</label>
                                            <div class="form-input has-suffix">
                                                <input id="rutMaxAmountForPersBelow65Year" class="form-control text-right" data-bind="value: company.rutMaxAmountForPersBelow65Year, format: 'decimal', numeric: true, enterKeyAsTab: true" maxlength="9" type="tel"><span class="field-validation-error" style="display: none;"></span>
                                            </div>
                                            <span class="suffix" data-bind="text: company.baseCurrencyCode">SEK</span>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label control-label" data-i18n="Settings_Company_InvoiceSettings_PrivatePersonAgeOver65">Limit, buyers over 65 y/o</label>
                                            <div class="form-input has-suffix">
                                                <input id="rutMaxAmountForPersOver65Year" class="form-control text-right" data-bind="value: company.rutMaxAmountForPersOver65Year, format: 'decimal', numeric: true, enterKeyAsTab: true" maxlength="9" type="tel"><span class="field-validation-error" style="display: none;"></span>
                                            </div>
                                            <span class="suffix" data-bind="text: company.baseCurrencyCode">SEK</span>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label control-label" data-i18n="Settings_Company_InvoiceSettings_ReductionPercent">Percentage of work eligible</label>
                                            <div class="form-input has-suffix">
                                                <input id="rutReducedInvoicingPercent" class="form-control text-right" data-bind="value: company.rutReducedInvoicingPercent, format: 'decimal', numeric: true, enterKeyAsTab: true" maxlength="5" type="tel"><span class="field-validation-error" style="display: none;"></span>
                                            </div>
                                            <span class="suffix">%</span>
                                        </div>
                                        <br>
                                        <div class="form-group"><span class="form-label control-label" data-i18n="Settings_Company_InvoiceSettings_RotWork">ROT entitlement</span></div>
                                        <div class="form-group">
                                            <label class="form-label control-label" data-i18n="RotReducedInvoicingAmount">Limit</label>
                                            <div class="form-input has-suffix">
                                                <input id="rotReducedInvoicingMaxAmount" class="form-control text-right" data-bind="value: company.rotReducedInvoicingMaxAmount, format: 'decimal', numeric: true, enterKeyAsTab: true" maxlength="9" type="tel"><span class="field-validation-error" style="display: none;"></span>
                                            </div>
                                            <span class="suffix" data-bind="text: company.baseCurrencyCode">SEK</span>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label control-label" data-i18n="Settings_Company_InvoiceSettings_ReductionPercent">Percentage of work eligible</label>
                                            <div class="form-input has-suffix">
                                                <input id="rotReducedInvoicingPercent" class="form-control text-right" data-bind="value: company.rotReducedInvoicingPercent, format: 'decimal', numeric: true, enterKeyAsTab: true" maxlength="5" type="tel"><span class="field-validation-error" style="display: none;"></span>
                                            </div>
                                            <span class="suffix">%</span>
                                        </div>
                                    </div>
                                </fieldset>
                                <!-- /ko -->
                                <!-- ko ifnot: app.session.hasProductVariantSolo()-->
                                <fieldset>
                                    <legend data-i18n="CompanySettingsPaymentReminder">Payment reminders</legend>

                                    <div class="form-group">
                                        <label class="form-label control-label" data-i18n="CompanySettingsLatePaymentFee">Late payment fee</label>
                                        <div class="form-input has-suffix">
                                            <input id="latePaymentFee" class="form-control text-right" data-bind="value: company.latePaymentFee, format: 'decimal', numeric: true, enterKeyAsTab: true" maxlength="9" type="tel"><span class="field-validation-error" style="display: none;"></span>
                                        </div>
                                        <span class="suffix" data-bind="text: company.baseCurrencyCode">SEK</span>
                                    </div>

                                    <div class="form-group checkbox-form">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" id="firstPaymentReminderWithoutFee" data-bind="checked: company.firstPaymentReminderWithoutFee, enterKeyAsTab: true">
                                                <span data-i18n="FirstPaymentReminderWithoutFee">First reminder free of charge</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group" style="margin-top: 8px; display: none;" data-bind="visible: showCollectionFields()">
                                        <label class="form-label control-label" data-i18n="CollectionThresholdLabel">Number of reminders before collection warning </label>
                                        <div class="form-input has-suffix">
                                            <input type="text" id="collectionThreshold" data-bind="value: company.collectionThreshold, enterKeyAsTab: true" maxlength="2" class=""><span class="field-validation-error" style="display: none;"></span>
                                        </div>
                                    </div>
                                </fieldset>
                                <!-- /ko -->
                                <fieldset data-bind="visible: app.session.isNorwegian() || app.session.isFinnish() || app.session.isDutch()" style="display: none;">
                                    <legend data-i18n="NumberSeries">Number series (next document number)</legend>

                                    <!-- ko if: app.session.hasQuotesModule && company.showQuote -->
                                    <div class="form-group">
                                        <label class="form-label control-label" data-i18n="CompanySettingsViewNextQuoteNumber">Quote</label>
                                        <div class="form-input">
                                            <span data-bind="text: company.nextQuoteNumber, visible: company.isQuoteNumberLocked" style="display: none;">1</span>
                                            <input id="nextQuoteNumber" class="form-control" data-bind="value: company.nextQuoteNumber, visible: !company.isQuoteNumberLocked(), format: 'digits', numeric: true, enterKeyAsTab: true" type="tel"><span class="field-validation-error" style="display: none;"></span>
                                        </div>
                                    </div>
                                    <!-- /ko -->
                                    <!-- ko if: app.session.hasOrdersModule && company.showOrder -->
                                    <div class="form-group">
                                        <label class="form-label control-label" data-i18n="CompanySettingsViewNextOrderNumber">Order</label>
                                        <div class="form-input">
                                            <span data-bind="text: company.nextOrderNumber, visible: company.isOrderNumberLocked" style="display: none;">1</span>
                                            <input id="nextOrderNumber" class="form-control" data-bind="value: company.nextOrderNumber, visible: !company.isOrderNumberLocked(), format: 'digits', numeric: true, enterKeyAsTab: true" type="tel"><span class="field-validation-error" style="display: none;"></span>
                                        </div>
                                    </div>
                                    <!-- /ko -->

                                    <div class="form-group">
                                        <label class="form-label control-label" data-i18n="CompanySettingsViewNextCustomerInvoiceNumber">Sales invoice</label>
                                        <div class="form-input">
                                            <span data-bind="text: company.nextCustomerInvoiceNumber, visible: company.isCustomerInvoiceNumberLocked" style="display: none;">1</span>
                                            <input id="nextCustomerInvoiceNumber" class="form-control" data-bind="value: company.nextCustomerInvoiceNumber, visible: !company.isCustomerInvoiceNumberLocked(), format: 'digits', numeric: true, enterKeyAsTab: true" type="tel"><span class="field-validation-error" style="display: none;"></span>
                                        </div>
                                    </div>
                                </fieldset>

                                <!-- <fieldset data-bind="visible: app.session.isNorwegian()" style="display: none;">
                                    <legend data-i18n="Settings_CompanySettings_MobilePaymentInformation">Mobile payment information</legend>
                                    <div class="edit-table">
                                        <div class="header-row">
                                            <div class="columns col-xs-4">
                                                <label data-i18n="Settings_CompanySettings_Hdr_MobilePayment_PaymentMethod" onmouseover="app.shell.toolTip(this)">Payment method</label>
                                            </div>
                                            <div class="columns col-xs-6-5">
                                                <label data-i18n="Settings_CompanySettings_Hdr_MobilePayment_PhoneNumber" onmouseover="app.shell.toolTip(this)">Payment ID</label>
                                            </div>
                                        </div>
                                        <div class="col-addremove-buttons columns"></div>
                                    </div>

                                    <div class="edit-table" id="rowContainerOne" data-bind="template: { name: 'mobilePaymentInformation', foreach: company.mobilePayRows}">
                                        <div class="edit-row">
                                            <div class="columns col-xs-4">
                                                <div class="form-group">
                                                    <div class="form-input" style="width: 100%">
                                                        <span class="select-wrapper"><select class="custom hasCustomSelect" data-bind="options: dropdownItems, optionsText: 'name', optionsValue: 'id', value: selectedItem, attr: { id: 'mobilePayOptionsRow_' + uniqueNumber }" id="mobilePayOptionsRow_0" style="-webkit-appearance: menulist-button; position: absolute; opacity: 0;"><option value="1">Vipps</option><option value="2">Mcash</option><option value="3">MobilePay</option></select><span class="holder customSelect custom" style="display: inline-block;"><span class="customSelectInner" style="display: inline-block;">Vipps</span></span></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="columns col-xs-6-5" data-bind="visible: displayTwentyRow" style="display: none;">
                                                <input data-bind="value: phoneNumber, numeric: true, format: 'digits', attr: { id: 'optionsRow_' + uniqueNumber }" maxlength="20" type="tel" id="optionsRow_0">
                                            </div>
                                            <div class="columns col-xs-6-5" data-bind="visible: displaySixRow">
                                                <input data-bind="value: phoneNumber, numeric: true, format: 'digits', attr: { id: 'optionsRow_' + uniqueNumber }" maxlength="6" type="tel" id="optionsRow_0">
                                            </div>
                                            <div class="col-addremove-buttons columns text-right">
                                                <button class="add-remove vismaicon vismaicon-add-circle" data-bind="click: $root.company.addMobilePayRow, enterKey:$root.company.addMobilePayRow, enable: $root.company.enableMobilePayAddButton, attr: { id: 'addRowButton_' + uniqueNumber }" id="addRowButton_0"></button>
                                                <button class="add-remove vismaicon vismaicon-remove-circle" data-bind="click: $root.company.removeMobilePayRow, enterKey: $root.company.removeMobilePayRow,  attr: { id: 'removeRowButton_' + uniqueNumber }" id="removeRowButton_0"></button>
                                            </div>
                                        </div>

                                    <div class="additional-drag-space">&nbsp;</div>
                                    </div>
                                </fieldset> -->
                                <fieldset data-bind="visible: !app.session.hasProductVariantInvoicing() ">
                                    <legend data-i18n="DashboardViewSupplierInvoices">Purchase invoices</legend>
                                    <div data-bind="visible: (app.session.isNorwegian() || app.session.isFinnish()) &amp;&amp; !app.session.hasProductVariantSolo(), css: company.PurchaseInvoiceApprovalCss()" class="form-group checkbox-form" style="display: none;">
                                        <div class="form-input">
                                            <div class="checkbox approval-checkbox">
                                                <label>
                                                    <input type="checkbox" id="usesSupplierInvoiceApproval" data-bind="checked: company.usesSupplierInvoiceApproval, enable: !company.disabledForConsultantWhenCollaboration(), enterKeyAsTab: true">
                                                    <span data-i18n="UsesSupplierInvoiceApproval">Purchase invoices must be approved</span>
                                                </label>
                                            </div>
                                            <span class="vismaicon vismaicon-sm vismaicon-filled vismaicon-info input-information" data-toggle="tooltip" data-placement="top" data-bind="attr: { title: company.approvalSettingsTooltip() }, visible: company.disabledForConsultantWhenCollaboration()" title="" style="display: none;" data-original-title="Your client is using a variant of Visma eEkonomi that does not support the approval feature. To enable the setting and use the feature your client needs to upgrade to Visma eEkonomi Smart or Pro."></span>
                                        </div>
                                    </div>
                                    <!-- ko if: app.session.areSupplierInvoicesEditable -->
                                    <div data-bind="css: company.PurchaseInvoiceApprovalCss()" class="form-group checkbox-form">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" id="usesSupplierInvoiceEdit" data-bind="checked: company.usesSupplierInvoiceEdit, enterKeyAsTab: true">
                                                <span data-i18n="UsesSupplierInvoiceEdit">Allow editing of purchase invoices</span>
                                            </label>
                                        </div>
                                    </div>
                                    <!-- /ko -->
                                    <div data-bind="css: company.PurchaseInvoiceApprovalCss(), visible: app.session.isPaymentFileAvailable" class="form-group checkbox-form">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" id="activatePaymentFile" data-bind="checked: company.paymentFileActivated, click: activatePaymentFile, enterKeyAsTab: true">
                                                <span data-i18n="ActivatePaymentFile">Use payment files for outgoing payments</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div data-bind="css: company.PurchaseInvoiceApprovalCss(), visible: canUseDeferredPaymentSending()" class="form-group checkbox-form" style="display: none;">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" id="activatePaymentFile" data-bind="checked: company.usesDeferredPaymentSending, enterKeyAsTab: true">
                                                <span data-i18n="CompanySettings_lbl_InvoiceSettings_UsesDeferredPaymentSending">Confirm selection of purchase invoices for payment</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div data-bind="css: company.PurchaseInvoiceApprovalCss()" class="form-group checkbox-form">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" id="useAdvancedMode" data-bind="checked: company.useAdvancedMode, enterKeyAsTab: true">
                                                <span data-bind="text: i18n.t(app.session.isFinnish() ? 'CompanySettings_lbl_InvoiceSettings_ShowDebitCreditDefaultRows' : 'AdvancedMode')">Show debit and credit on purchase invoices</span>
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="form-column">
                                <fieldset data-bind="visible: company.canUseAutoInvoiceFunctionality() &amp;&amp; company.showAutoInvoiceOutbound() &amp;&amp; app.session.isFinnish()" style="display: none;">
                                    <legend data-i18n="CompanySettings_hdr_AutoInvoiceBankNetwork">AutoInvoice - Bank network</legend>
                                    <div class="form-group" data-bind="visible: company.showAutoInvoiceB2C" style="display: none;">
                                        <div class="input-text-block" data-i18n="Settings_CompanySettings_InvoiceSettings_AutoInvoice_BankNetwork_Activation_Info">Before you can start to send and receive e-invoices via bank operators, you must approve the agreement with the bank.</div>

                                        <div class="form-input">
                                            <button id="showAutoInvoiceB2CSettings" data-bind="click: showAutoInvoiceB2CSettings, enable: !company.isAutoInvoiceBankNetworkPending()" class="btn btn-default" data-i18n="Settings_CompanySettings_InvoiceSettings_AutoInvoice_B2C_Activation_Button">To the agreement</button>
                                        </div>
                                        <div class="input-text-block" style="font-style: italic; display: none;" data-bind="visible: company.isAutoInvoiceBankNetworkPending()" data-i18n="Settings_CompanySettings_InvoiceSettings_AutoInvoice_BankNetwork_Pending_Info">Maventa bank network opening is pending.</div>
                                    </div>
                                    <div class="form-group" data-bind="visible: !company.showAutoInvoiceB2C()">
                                        <div class="input-text-block" data-i18n="Settings_CompanySettings_InvoiceSettings_AutoInvoice_BankNetwork_Activated_Info">Bank agreement is activated.</div>
                                    </div>
                                </fieldset>
                                <fieldset data-bind="visible: company.canUseAutoInvoiceFunctionality() &amp;&amp; company.showAutoInvoiceOutbound() &amp;&amp; app.session.isFinnish()" style="display: none;">
                                    <legend data-i18n="CompanySettings_hdr_AutoInvoiceSend">Sending electronic invoices/AutoInvoice</legend>
                                    <div class="form-group">
                                        <div class="input-text-block" style="margin-bottom: 1.5rem;">
                                            <span class="no-ellipsis" data-i18n="Settings_CompanySettings_InvoiceSettings_AutoInvoice_ReadMore_FI">Read more about how it works and prices </span>
                                            <a id="showInvoiceScanningPrices" data-i18n="CompanySettings_link_ScanningPrices" data-bind="click: company.setScanningInvoicePriceLink">here.</a>
                                        </div>
                                        <div class="input-text-block" style="margin-bottom: 1.5rem;" data-i18n="Settings_CompanySettings_InvoiceSettings_AutoInvoice_SetAutomatically_text_FI">Your company is automatically set up to send e-invoices to companies.</div>
                                    </div>
                                    <div class="form-group checkbox-form" data-bind="visible: !company.showAutoInvoiceB2C()">
                                        <div class="checkbox">
                                            <span class="vismaicon vismaicon-sm vismaicon-filled vismaicon-info" style="vertical-align: middle;" data-toggle="tooltip" data-placement="top" data-i18n="[title]Settings_CompanySettings_InvoiceSettings_AutoInvoice_SI_Info" title="" data-original-title="Turning on this setting makes it possible to send e-invoices to private individuals. When a customer choose to receive e-invoices from your company the program will automatically update the customer record enabling the sending of e-invoices to that customer."></span>
                                            <label style="vertical-align: middle;">
                                                <input type="checkbox" id="usesAutoInvoiceSenderInfo" data-bind="checked: company.autoInvoiceSIActive, click: function() { showChangeSenderInfoWarning(); return true; }, enterKeyAsTab: true">
                                                <span data-i18n="Settings_CompanySettings_InvoiceSettings_AutoInvoice_SI_Checkbox">Send e-invoices to private individuals</span>
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>
                                <!-- ko if: company.canUseAutoInvoiceFunctionality() --><!-- /ko-->

                                <fieldset data-bind="visible: !(app.session.isNorwegian() || app.session.isFinnish() || app.session.isDutch())" style="margin-top: 0;">
                                    <legend data-i18n="NumberSeries">Number series (next document number)</legend>
                                    <!-- ko if: app.session.hasQuotesModule && company.showQuote -->
                                    <div class="form-group">
                                        <label class="form-label control-label" data-i18n="CompanySettingsViewNextQuoteNumber">Quote</label>
                                        <div class="form-input">
                                            <span data-bind="text: company.nextQuoteNumber, visible: company.isQuoteNumberLocked" style="display: none;">1</span>
                                            <input id="nextQuoteNumber" class="form-control" data-bind="value: company.nextQuoteNumber, visible: !company.isQuoteNumberLocked(), format: 'digits', numeric: true, enterKeyAsTab: true" type="tel"><span class="field-validation-error" style="display: none;"></span>
                                        </div>
                                    </div>
                                    <!-- /ko -->
                                    <!-- ko if: app.session.hasOrdersModule && company.showOrder -->
                                    <div class="form-group">
                                        <label class="form-label control-label" data-i18n="CompanySettingsViewNextOrderNumber">Order</label>
                                        <div class="form-input">
                                            <span data-bind="text: company.nextOrderNumber, visible: company.isOrderNumberLocked" style="display: none;">1</span>
                                            <input id="nextOrderNumber" class="form-control" data-bind="value: company.nextOrderNumber, visible: !company.isOrderNumberLocked(), format: 'digits', numeric: true, enterKeyAsTab: true" type="tel"><span class="field-validation-error" style="display: none;"></span>
                                        </div>
                                    </div>
                                    <!-- /ko -->

                                    <div class="form-group">
                                        <label class="form-label control-label" data-i18n="CompanySettingsViewNextCustomerInvoiceNumber">Sales invoice</label>
                                        <div class="form-input">
                                            <span data-bind="text: company.nextCustomerInvoiceNumber, visible: company.isCustomerInvoiceNumberLocked" style="display: none;">1</span>
                                            <input id="nextCustomerInvoiceNumber" class="form-control" data-bind="value: company.nextCustomerInvoiceNumber, visible: !company.isCustomerInvoiceNumberLocked(), format: 'digits', numeric: true, enterKeyAsTab: true" type="tel"><span class="field-validation-error" style="display: none;"></span>
                                        </div>
                                    </div>
                                </fieldset>

                                <!-- ko if: app.session.isNorwegian() || app.session.isSwedish() || app.session.isFinnish() || app.session.isDutch()-->
                                <fieldset data-bind="visible: company.canUseAutoInvoiceFunctionality() &amp;&amp; company.showAutoInvoiceInbound()" class="areaAutoInvoice" style="display: none;">
                                    <legend data-i18n="CompanySettings_hdr_AutoInvoiceReceive" data-bind="visible: app.session.isNorwegian() || app.session.isFinnish() || app.session.isDutch()" style="display: none;">AutoInvoice - Receive</legend>
                                    <legend data-i18n="Settings_CompanySettings_InvoiceSettings_AutoInvoice_Title" data-bind="visible: app.session.isSwedish()">AutoInvoice</legend>

                                    <div class="form-group checkbox-form">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" id="usesAutoInvoiceInbound" data-bind="checked: company.usesAutoInvoiceInbound, click: function() { showChangeInvoiceScanningStatusWarningDisableInbound(); return true; }, enterKeyAsTab: true">
                                                <span class="no-ellipsis" data-bind="text: company.getUsesAutoInvoiceInboundLabel()">Receive e-invoices (invoice 3,00 SEK and 0,50 SEK per attachment)</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div data-bind="visible:company.usesAutoInvoiceInbound()" class="usesAutoInvoiceInbound" style="display: none;">
                                        <!-- ko if: app.session.isNorwegian() || app.session.isFinnish() || app.session.isDutch() --><!-- /ko -->
                                        <div class="form-group checkbox-form">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" id="activateScanningInvoice" data-bind="checked: company.usesAutoInvoiceScanInvoice, click: function() { showChangeInvoiceScanningStatusWarningDisableScanning(); return true; }, enterKeyAsTab: true">
                                                    <span class="no-ellipsis" data-i18n="ComanySettings_text_InvoiceScanning_Activate">Activate the scanning service to convert invoices from your suppliers to e-invoices. Read more about the service and prices</span>
                                                    <a id="showInvoiceScanningPrices" data-i18n="CompanySettings_link_ScanningPrices" data-bind="click: company.setScanningInvoicePriceLink">here.</a>
                                                </label>
                                            </div>
                                        </div>
                                        <div data-bind="visible: company.usesAutoInvoiceScanInvoice() &amp;&amp; company.electronicInvoiceScanning()" style="display: none;">
                                            <div class="form-group">

                                            </div>
                                            <div class="form-group">
                                                <div class="input-text-block" data-i18n="CompanySettings_imsg_SupplierInvoiceScanInfoMessage">To get the purchase invoices scanned, instruct your suppliers to send the invoices to the below address.</div>
                                            </div>

                                            <!-- ko if:  !app.session.isDutch() -->
                                            <div class="form-group">
                                                <label class="form-label control-label" data-i18n="CompanySettings_lbl_InvoiceScanning_InvoicePostalAdress">Address for printed invoices</label>
                                                <div class="form-input">
                                                    <input type="text" id="autoInvoiceCompanyName" class="form-control" data-bind="value: company.scanningElectronicAddressName, enterKeyAsTab: true" readonly="readonly"><span class="field-validation-error" style="display: none;"></span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-input no-label">
                                                    <input type="text" id="autoInvoiceFirstAddress" class="form-control" data-bind="value: company.scanningElectronicAddressAddress1, enterKeyAsTab: true" readonly="readonly"><span class="field-validation-error" style="display: none;"></span>
                                                </div>
                                            </div>
                                            <div class="form-group" data-bind="visible: company.scanningElectronicAddressAddress2" style="display: none;">
                                                <div class="form-input no-label">
                                                    <input type="text" id="autoInvoiceSecondAddress" class="form-control" data-bind="value: company.scanningElectronicAddressAddress2, enterKeyAsTab: true" readonly="readonly"><span class="field-validation-error" style="display: none;"></span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-input no-label">
                                                    <input type="text" id="autoInvoiceZipCode" class="form-control" data-bind="value: company.scanningElectronicAddressPostalCode, enterKeyAsTab: true" readonly="readonly"><span class="field-validation-error" style="display: none;"></span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-input no-label">
                                                    <input type="text" id="autoInvoiceCity" class="form-control" data-bind="value: company.scanningElectronicAddressCity, enterKeyAsTab: true" readonly="readonly"><span class="field-validation-error" style="display: none;"></span>
                                                </div>
                                            </div>
                                            <!-- /ko -->
                                            <div class="form-group">
                                                <label class="form-label control-label" data-i18n="CompanySettings_lbl_InvoiceScanning_EmailAdress">Address for e-mailed invoices</label>
                                                <div class="form-input">
                                                    <input type="text" id="autoInvoiceEmailAddress" class="form-control" readonly="readonly" data-bind="value: company.scanningElectronicAddressEmail, enterKeyAsTab: true"><span class="field-validation-error" style="display: none;"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div data-bind="visible: company.usesAutoInvoiceScanInvoice()" class="autoinvoice-active" style="display: none;">
                                            <div class="form-group">
                                                <div class="input-text-block" data-i18n="CompanySettings_text_AutoInvoiceReceive">If the invoice cannot be scanned and interpreted electronically, AutoInvoice will send the documents to the address below.</div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label control-label required" data-i18n="CompanySettings_lbl_InvoiceScanning_EmailAdress_2">E-mail address</label>
                                                <div class="form-input">
                                                    <input type="text" id="emailForFailedInvoices" class="form-control" data-bind="value: company.failScannInvoiceEmail, enterKeyAsTab: true"><span class="field-validation-error" style="display: none;"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </fieldset>
                                <!-- /ko -->
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="footer flex-footer">
                <div class="button-area">
                    <div class="primary-buttons">
                        <button id="saveButton" class="btn btn-success" data-i18n="Save" title="Save">Save</button>
                        <button class="btn btn-secondary" id="cancelButton" title="Cancel">Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>