<?php
if(!empty($args)){
    extract($args);
}

if(is_front_page()){
    return;
};

$title = get_the_title();

if(is_tax() || is_category()){
    $title = get_queried_object()->name;
}

if(is_search()) {
    $title = __('Search results');
}

$class_inline =isset($inline)? ' breadcrumbs_inline': '';
?>

<nav class="breadcrumbs<?php echo $class_inline;?>">
    <?php if (!isset($inline)) : ?>
    <div class="container">
    <?php endif; ?>

    <?php
    if ( function_exists('yoast_breadcrumb') ) {
        yoast_breadcrumb(  );
      }

    if (!isset($inline)) : ?>
    </div>
    <?php endif; ?>
</nav>
