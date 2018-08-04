<?php
// Data Scripts of home slider
$installer = $this;

$installer->startSetup();

// Create Slider 1
$installer->setConfigData('contenttab/homeslider1/slider_title1', 'New Trend');
$installer->setConfigData('contenttab/homeslider1/slider_content1', 'Chair Collection');
$installer->setConfigData('contenttab/homeslider1/slider_image1', 'default/revo-03.jpg');
$installer->setConfigData('contenttab/homeslider1/slider_button1', '/admin');

// Create Slider 2
$installer->setConfigData('contenttab/homeslider2/slider_title2', 'Hot Trend');
$installer->setConfigData('contenttab/homeslider2/slider_content2', 'Table Collection');
$installer->setConfigData('contenttab/homeslider2/slider_image2', 'default/revo-02.jpg');
$installer->setConfigData('contenttab/homeslider2/slider_button2', '/admin');

// Create Slider 3
$installer->setConfigData('contenttab/homeslider3/slider_title3', 'New Trend');
$installer->setConfigData('contenttab/homeslider3/slider_content3', 'Sofa Collection');
$installer->setConfigData('contenttab/homeslider3/slider_image3', 'default/revo-01.jpg');
$installer->setConfigData('contenttab/homeslider3/slider_button3', '/admin');

// Update block to CMS Page
$page = Mage::getModel('cms/page')->load('hf-home', 'identifier');
$old_content=$page->getContent();
$cmsPage = <<<EOT
$old_content
{{block type="core/template" template="hf18/final/slider.phtml"}}
EOT;
$page->setContent($cmsPage)->save();

$installer->endSetup();