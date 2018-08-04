<?php
// Data Scripts of Company Info
$installer = $this;

$installer->startSetup();

// Create Company Info
$installer->setConfigData('footerinfo/companyinfo/company_name', 'SmartOSC');
$installer->setConfigData('footerinfo/companyinfo/company_address', '10th Floor, Hado Airport Building, No.2 Hong Ha Street, Ward 2, Tan Binh District, HCM');
$installer->setConfigData('footerinfo/companyinfo/company_phone', '(+84) 28 3848 6795');
$installer->setConfigData('footerinfo/companyinfo/company_email', 'smartosc@gmail.com');


$installer->endSetup();