<?php

// Data Scripts of Company Info
$installer = $this;

$installer->startSetup();

// Create new categories
$categoriesId = array();
$categories = array('Featured' , 'Bestseller', 'Sale');

foreach($categories as $category) {
    $current_category = Mage::getModel('catalog/category');
    $current_category->setPath('1') // set parent to be root category
    ->setStoreId(Mage_Core_Model_App::ADMIN_STORE_ID)
        ->setName($category)
        ->setIsActive(1)
        ->save();
    $categoriesId[$category] = $current_category->getId();
}

// Create new products
$productArr = array(
    array(
        'sku'       => 'ABC-001',
        'name'      => 'Iron Chair',
        'price'     => 400,
        'image'     => 'product-item-12.jpg',
        'cateIds'   => array($categoriesId['Featured'], $categoriesId['Bestseller'])
    ),
    array(
        'sku'       => 'ABC-002',
        'name'  => 'Vesper Floor Lamp',
        'price' => 400,
        'image' => 'product-item-13.jpg',
        'cateIds'   => array($categoriesId['Sale'], $categoriesId['Bestseller'])
    ),
    array(
        'sku'       => 'ABC-003',
        'name'  => 'Regal',
        'price' => 400,
        'image' => 'product-cart-02.jpg',
        'cateIds'   => array($categoriesId['Featured'], $categoriesId['Sale'])
    ),
    array(
        'sku'       => 'ABC-004',
        'name'  => 'Plaza Pendant Light',
        'price' => 400,
        'image' => 'product-item-15.jpg',
        'cateIds'   => array($categoriesId['Featured'], $categoriesId['Bestseller'])
    ),
    array(
        'sku'       => 'ABC-005',
        'name'  => 'Souvenir',
        'price' => 400,
        'image' => 'product-item-01.jpg',
        'cateIds'   => array($categoriesId['Sale'], $categoriesId['Bestseller'])
    ),
    array(
        'sku'       => 'ABC-006',
        'name'  => 'Flower Vase',
        'price' => 400,
        'image' => 'product-item-02.jpg',
        'cateIds'   => array($categoriesId['Featured'], $categoriesId['Sale'])
    ),
    array(
        'sku'       => 'ABC-007',
        'name'  => 'Lamp',
        'price' => 400,
        'image' => 'product-item-16.jpg',
        'cateIds'   => array($categoriesId['Featured'], $categoriesId['Bestseller'])
    ),
    array(
        'sku'       => 'ABC-008',
        'name'  => 'Clothes Tree',
        'price' => 400,
        'image' => 'product-item-17.jpg',
        'cateIds'   => array($categoriesId['Sale'], $categoriesId['Bestseller'])
    ),
    array(
        'sku'       => 'ABC-009',
        'name'  => 'Iron Chair 1',
        'price' => 400,
        'image' => 'product-cart-01.jpg',
        'cateIds'   => array($categoriesId['Featured'], $categoriesId['Sale'])
    ),
    array(
        'sku'       => 'ABC-010',
        'name'  => 'Ladder',
        'price' => 400,
        'image' => 'product-item-14.jpg',
        'cateIds'   => array($categoriesId['Featured'], $categoriesId['Bestseller'])
    ),
);

$websiteIds = Mage::getModel('core/website')->getCollection()
    ->addFieldToFilter('website_id', array('neq'=>0))
    ->getAllIds();

foreach($productArr as $current_product) {
    $product = Mage::getModel('catalog/product');
    $product->setWebsiteIds($websiteIds)
        ->setStoreId(0)
        ->setMediaGallery (array('images'=>array (), 'values'=>array ()))
        ->addImageToMediaGallery('media/products/'.$current_product['image'], array('image','thumbnail','small_image'), false, false) //assigning image, thumb and small image to media gallery
        ->setCategoryIds($current_product['cateIds'])
        ->setTypeId('simple')
        ->setPrice($current_product['price']);
    $product->addData(array(
        'name' => $current_product['name'],
        'attribute_set_id' => $product->getDefaultAttributeSetId(), //use the default attribute set or an other id if needed.
        'status' => Mage_Catalog_Model_Product_Status::STATUS_ENABLED, //set product as enabled
        'visibility' => Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH, //set visibility in catalog and search
        'price'=>$current_product['price'],
        'sku' => $current_product['sku'],
    ));
    $product->save();
}

// Update block to CMS Page
$page = Mage::getModel('cms/page')->load('hf-home', 'identifier');
$old_content=$page->getContent();
$cmsPage = <<<EOT
$old_content
{{block type="core/template" template="hf18/final/ourProduct.phtml"}}
EOT;
$page->setContent($cmsPage)->save();
$installer->endSetup();