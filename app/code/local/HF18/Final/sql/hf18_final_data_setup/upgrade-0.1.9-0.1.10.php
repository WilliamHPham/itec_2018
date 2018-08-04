<?php
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer = $this;
$installer->startSetup();

$table = $installer->getConnection()->newTable($installer->getTable('hf18_final/voucher'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
        'identity' => true,
    ), 'Voucher ID')
    ->addColumn('code', Varien_Db_Ddl_Table::TYPE_TEXT, 50, array(
        'nullable' => false,
    ), 'Voucher Code')
    ->addColumn('value', Varien_Db_Ddl_Table::TYPE_FLOAT, 50, array(
        'nullable' => false,
    ), 'Voucher Value')
    ->addColumn('active', Varien_Db_Ddl_Table::TYPE_BOOLEAN, 1, array(
        'default' => true,
    ), 'Status')
    ->addColumn('started_at', Varien_Db_Ddl_Table::TYPE_DATE, null, array(), 'Started At')
    ->addColumn('expire_at', Varien_Db_Ddl_Table::TYPE_DATE, null, array(), 'Expire At')
    ->addColumn('customer_id', Varien_Db_Ddl_Table::TYPE_VARCHAR, array(
        'nullable' => true,
    ), 'Customer')
    ->addColumn('customer_group', Varien_Db_Ddl_Table::TYPE_VARCHAR, array(
        'nullable' => true,
    ), 'Customer Group')
    ->addColumn("created_at", Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        "default" => Varien_Db_Ddl_Table::TIMESTAMP_INIT
    ), "Created At");
$installer->getConnection()->createTable($table);

$installer->endSetup();
