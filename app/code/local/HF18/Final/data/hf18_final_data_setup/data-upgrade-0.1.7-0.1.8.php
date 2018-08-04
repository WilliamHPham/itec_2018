<?php

$blogs = array(
    array(
        'title'       => 'BLOG 1',
        'url'      => 'blog-1',
        'post-content'     => 'This is Blog Test 1',
        'created-at'     => '2018-05-31 18:26:25',
        'image'   =>  's/i/blog-post-gama-01.jpg',
        'small-image' => 's/i/blog-post-gama-01.jpg',
        'thumbnail' => 's/i/blog-post-gama-01.jpg',
    ),
    array(
        'title'       => 'BLOG 2',
        'url'      => 'blog-2',
        'post-content'     => 'This is Blog Test 2',
        'created-at'     => '2018-05-31 18:26:25',
        'image'   =>  's/i/blog-post-gama-01.jpg',
        'small-image' => 's/i/blog-post-gama-01.jpg',
        'thumbnail' => 's/i/blog-post-gama-01.jpg',
    ),
    array(
        'title'       => 'BLOG 3',
        'url'      => 'blog-3',
        'post-content'     => 'This is Blog Test 3',
        'created-at'     => '2018-05-31 18:26:25',
        'image'   =>  's/i/blog-post-gama-01.jpg',
        'small-image' => 's/i/blog-post-gama-01.jpg',
        'thumbnail' => 's/i/blog-post-gama-01.jpg',
    ),
    array(
        'title'       => 'BLOG 4',
        'url'      => 'blog-4',
        'post-content'     => 'This is Blog Test 4',
        'created-at'     => '2018-05-31 18:26:25',
        'image'   =>  's/i/blog-post-gama-01.jpg',
        'small-image' => 's/i/blog-post-gama-01.jpg',
        'thumbnail' => 's/i/blog-post-gama-01.jpg',
    ),
    array(
        'title'       => 'BLOG 5',
        'url'      => 'blog-5',
        'post-content'     => 'This is Blog Test 5',
        'created-at'     => '2018-05-31 18:26:25',
        'image'   =>  's/i/blog-post-gama-01.jpg',
        'small-image' => 's/i/blog-post-gama-01.jpg',
        'thumbnail' => 's/i/blog-post-gama-01.jpg',
    ),
);

$installer = $this;

$installer -> startSetup();

foreach($blogs as $blog) {
    $product = Mage::getModel('evozon_blog/post');

    $product->setAttributeSetId($product->getDefaultAttributeSetId())
        ->setTitle($blog['title'])
        ->setUrlKey($blog['url'])
        ->setPostContent($blog['post-content'])
        ->setCreatedAt($blog['created-at'])
        ->setImage($blog['image'])
        ->setSmallImage($blog['small-image'])
        ->setThumbnail($blog['thumbnail']);

    $product->save();
}

$page = Mage::getModel('cms/page')->load('hf-home', 'identifier');
$old_content=$page->getContent();
$cmsPage = <<<EOT
$old_content
    {{block type="core/template" template="hf18/final/our_blog.phtml"}}
EOT;
$page->setContent($cmsPage)->save();

$installer->endSetup();
