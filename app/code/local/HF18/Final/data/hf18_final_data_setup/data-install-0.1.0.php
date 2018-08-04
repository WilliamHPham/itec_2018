<?php

Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

$cmsPage = array(
    'title' => 'HF Home',
    'identifier' => 'hf-home',
    'content' => '',
    'is_active' => 1,
    'sort_order' => 0,
    'stores' => array(0),
    'root_template' => 'one_column'
);

Mage::getModel('cms/page')->setData($cmsPage)->save();
Mage::getModel('core/config')->saveConfig('web/default/cms_home_page', 'hf-home');

$changeData = new Mage_Core_Model_Config();
$changeData->saveConfig('design/package/name', "HF18", 'default', 0);
$changeData->saveConfig('design/theme/template', "Final", 'default', 0);
$changeData->saveConfig('design/theme/layout', "Final", 'default', 0);

$this->setConfigData('tab1/general/text_field', 'FREE SHIPPING FOR STANDARD ORDER OVER $100');
$this->setConfigData('tab1/general/imagefield', 'default/Copy_of_SmartOSC_original_logo.png');
$this->setConfigData('tab1/general/text_field_gl', 'https://www.google.com/');
$this->setConfigData('tab1/general/text_field_fb', 'https://www.facebook.com/');
$this->setConfigData('tab1/general/text_field_tw', 'https://www.twitter.com/');
$this->setConfigData('tab1/general/text_field_pt', 'https://www.pinterest.com/');