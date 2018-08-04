<?php
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
$content = <<<EOT
<div id="products-collection">
    <div id="collection-container">
        <img src="{{media url="sofa-collection/call-to-action-03.jpg"}}" alt="">
        <div id="collection-content">
            <h1 class="text-center text-uppercase">The Sofa Collection</h1>
            <p class="text-center">Pellentesque habitant morbi tristique senectus et netus et malesuada
            fames ac turpis egestas. Donec non bibendum neque, sit amet mattis arcu</p>
            <div class="text-center">
                    <button class="btn text-uppercase">View more</button>
            </div>
        </div>
    </div>
</div>
EOT;
$staticBlock = array();
$item = array(
    'title' => 'SofaCollection',
    'identifier' => 'sofa-collection-block',
    'content' => $content,
    'is_active' => 1,
    'stores' => array(0)
);
array_push($staticBlock, $item);
foreach ($staticBlock as $staticBlock) {
    Mage::getModel('cms/block')->setData($staticBlock)->save();
}

$page = Mage::getModel('cms/page')->load('hf-home', 'identifier');
$old_content=$page->getContent();
$cmsPage = <<<EOT
$old_content
{{widget type="cms/widget_block" template="cms/widget/static_block/default.phtml" block_id="sofa-collection-block"}}
EOT;


$page->setContent($cmsPage)->save();
