<?php

Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
 
//create CMS Pages
$cmsPages = array(
    array(
        'title' => 'HF Blog',
        'identifier' => 'hf_blog',
        'content' => 'This is Blog',
        'is_active' => 1,
        'sort_order' => 0,
        'stores' => array(0),
        'root_template' => 'one_column'
    ),
    array(
        'title' => 'HF Featured',
        'identifier' => 'hf_featured',
        'content' => 'This is Featured',
        'is_active' => 1,
        'sort_order' => 0,
        'stores' => array(0),
        'root_template' => 'one_column'
    ),
    array(
        'title' => 'HF Privacy Policy',
        'identifier' => 'hf_privacy_policy',
        'content' => 'This is Privacy Policy',
        'is_active' => 1,
        'sort_order' => 0,
        'stores' => array(0),
        'root_template' => 'one_column'
    ),
    array(
        'title' => 'HF Products',
        'identifier' => 'hf_products',
        'content' => 'This is Products',
        'is_active' => 1,
        'sort_order' => 0,
        'stores' => array(0),
        'root_template' => 'one_column'
    ),);

foreach ($cmsPages as $cmsPage)
{
    Mage::getModel('cms/page')->setData($cmsPage)->save();
}
//end of create CMS Pages

//create CMS Static Blocks
$content_link = '<div class="footer-link">
<div class="link-header">link</div>
<ul class="link">
<li><a href="{{store direct_url="hf_products"}}">Products</a></li>
<li><a href="{{store direct_url="hf_featured"}}">Featured</a></li>
<li><a href="{{store direct_url="hf_privacy_policy"}}">Privacy Policy</a></li>
<li><a href="{{store direct_url="hf_blog"}}">Blog</a></li>
</ul>
</div>';

$content_shop = '<div class="footer-shop">
<div class="shop-header">shop</div>
<ul class="shop">
<li><a href="#">Men</a></li>
<li><a href="#">Women</a></li>
</ul>
</div>';

$content_instagram = '<div class="ins-header">Instagram</div>
<ul class="ins-list">
<li><a href="images/ins-09.jpg" data-lightbox="roadtrip"><img alt="Instagram" src="{{media url="wysiwyg/ins-09.jpg"}}" /></a></li>
<li><a href="images/ins-10.jpg" data-lightbox="roadtrip"><img alt="Instagram" src="{{media url="wysiwyg/ins-10.jpg"}}" /></a></li>
<li><a href="images/ins-11.jpg" data-lightbox="roadtrip"><img alt="Instagram" src="{{media url="wysiwyg/ins-11.jpg"}}" /></a></li>
<li><a href="images/ins-12.jpg" data-lightbox="roadtrip"><img alt="Instagram" src="{{media url="wysiwyg/ins-12.jpg"}}" /></a></li>
<li><a href="images/ins-13.jpg" data-lightbox="roadtrip"><img alt="Instagram" src="{{media url="wysiwyg/ins-13.jpg"}}" /></a></li>
<li><a href="images/ins-14.jpg" data-lightbox="roadtrip"><img alt="Instagram" src="{{media url="wysiwyg/ins-14.jpg"}}" /></a></li>
<li><a href="images/ins-15.jpg" data-lightbox="roadtrip"><img alt="Instagram" src="{{media url="wysiwyg/ins-15.jpg"}}" /></a></li>
<li><a href="images/ins-16.jpg" data-lightbox="roadtrip"><img alt="Instagram" src="{{media url="wysiwyg/ins-16.jpg"}}" /></a></li>
</ul>';

$staticBlocks = array(
    array(
        'title' => 'block link',
        'identifier' => 'block_link',
        'content' => $content_link,
        'is_active' => 1,
        'stores' => array(0)
    ),
    array(
        'title' => 'block shop',
        'identifier' => 'block_shop',
        'content' => $content_shop,
        'is_active' => 1,
        'stores' => array(0)
    ),
    array(
        'title' => 'block instagram',
        'identifier' => 'block_instagram',
        'content' => $content_instagram,
        'is_active' => 1,
        'stores' => array(0)
    ),);

foreach ($staticBlocks as $staticBlock)
{
    Mage::getModel('cms/block')->setData($staticBlock)->save();
}
//end of create CMS Static Blog
