<?php
$this->startSetup();
Mage::register('isSecureArea', 1);

// Force the store to be admin
Mage::app()->setUpdateMode(false);
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);


$category = Mage::getModel('catalog/category');

$category->setPath('1/2') // set parent to be root category
->setStoreId(Mage_Core_Model_App::ADMIN_STORE_ID)
    ->setName('Menu')
    ->setIsActive(1)
    ->save();

$menu=$category->getPath();

$category = Mage::getModel('catalog/category');
$category->setPath($menu) // set parent to be root category
->setStoreId(Mage_Core_Model_App::ADMIN_STORE_ID)
    ->setName('Home')
    ->setIsActive(1)
    ->save();

$category = Mage::getModel('catalog/category');
$category->setPath($menu) // set parent to be root category
->setStoreId(Mage_Core_Model_App::ADMIN_STORE_ID)
    ->setName('Shop')
    ->setIsActive(1)
    ->save();

$shop=$category->getPath();

$category = Mage::getModel('catalog/category');
$category->setPath($shop) // set parent to be root category
->setStoreId(Mage_Core_Model_App::ADMIN_STORE_ID)
    ->setName('Men')
    ->setIsActive(1)
    ->save();

$category = Mage::getModel('catalog/category');
$category->setPath($shop) // set parent to be root category
->setStoreId(Mage_Core_Model_App::ADMIN_STORE_ID)
    ->setName('Women')
    ->setIsActive(1)
    ->save();

$category = Mage::getModel('catalog/category');
$category->setPath($menu) // set parent to be root category
->setStoreId(Mage_Core_Model_App::ADMIN_STORE_ID)
    ->setName('Contact')
    ->setIsActive(1)
    ->save();

$category = Mage::getModel('catalog/category');
$category->setPath($menu) // set parent to be root category
->setStoreId(Mage_Core_Model_App::ADMIN_STORE_ID)
    ->setName('About')
    ->setIsActive(1)
    ->save();


$this->endSetup();