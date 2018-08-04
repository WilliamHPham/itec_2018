<?php
/*script run FrontEnd Home 2 Block*/
/* file css to style in branch 100 */
// Update block to CMS Page
$page = Mage::getModel('cms/page')->load('hf-home', 'identifier');
$old_content=$page->getContent();
$cmsPage = <<<EOT
$old_content
<div id="two-blocks">
<div class="container mt-4 pb-4">
  <div class="row">
      <div class="col-md-6">
        {{widget type="cms/widget_block" template="cms/widget/static_block/default.phtml" block_id="home-two-block1"}}
      </div>
      <div class="col-md-6">
          {{widget type="cms/widget_block" template="cms/widget/static_block/default.phtml" block_id="home-two-block2"}}
      </div>
  </div>
</div>
</div>
EOT;
$page->setContent($cmsPage)->save();


/*script run Backend Home 2 block*/
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
$content = '
<div class="categories-item categories-item-beta">
    <div class="categories-image">
        <a href="#">
            <img src="http://templates.aucreative.co/raven/images/categories-04.jpg" alt="20% Sale on All Product">
        </a>
    </div>
    <div class="categories-name">
        <h3 class="title">
            <a href="#">20% Sale on All Product</a>
        </h3>
    </div>
</div>
';
$staticBlock = array();
$item = array(
    'title' => 'HomeTwoBlock1',
    'identifier' => 'home-two-block1',
    'content' => $content,
    'is_active' => 1,
    'stores' => array(0)
);
array_push($staticBlock, $item);
$content = '
<div class="categories-item categories-item-beta">
    <div class="categories-image">
        <a href="#">
            <img src="http://templates.aucreative.co/raven/images/categories-05.jpg" alt="20% Sale on All Product">
        </a>
    </div>
    <div class="categories-name">
        <h3 class="title">
            <a href="#">20% Sale on All Product</a>
        </h3>
    </div>
</div>
';
$item = array(
    'title' => 'HomeTwoBlock2',
    'identifier' => 'home-two-block2',
    'content' => $content,
    'is_active' => 1,
    'stores' => array(0)
);
array_push($staticBlock, $item);
foreach ($staticBlock as $staticBlock) {
    Mage::getModel('cms/block')->setData($staticBlock)->save();
}
