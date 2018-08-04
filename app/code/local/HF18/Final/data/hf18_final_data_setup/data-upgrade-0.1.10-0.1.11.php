<?php
// Data Scripts of Shipping method
$installer = $this;

$installer->startSetup();

// Update Shipping method
$installer->setConfigData('carriers/freeshipping/free_shipping_subtotal', '300.00');
$installer->setConfigData('carriers/freeshipping/active', true);
$installer->setConfigData('carriers/flatrate/price', '15.00');

$installer->endSetup();