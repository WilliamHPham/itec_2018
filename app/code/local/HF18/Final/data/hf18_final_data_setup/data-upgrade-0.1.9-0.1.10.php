<?php

$installer = $this;
$installer -> startSetup();

$vouchers = array(
    array(
        'code'       => 'CODE1',
        'value'      => '500',
        'status'     => true,
        'started_at' => '2018-07-01',
        'expire_at'  => '2018-07-10'
    ),
    array(
        'code'       => 'CODE2',
        'value'      => '300',
        'status'     => true,
        'started_at' => '2018-06-01',
        'expire_at'  => '2018-06-30'
    ),
);

foreach($vouchers as $voucher) {
    $model = Mage::getModel('hf18_final/voucher')->setData($voucher);
    $model->save();
}

$installer->endSetup();
