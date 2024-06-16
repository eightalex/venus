<?php
if(!empty($args)){
    extract($args);
}

$title = get_the_title();

if(is_tax() || is_category()){
    $title = get_queried_object()->name;
}

if(is_search()) {
    $title = __('Search results');
}
?>

<nav class="breadcrumbs<?php echo $inline ? ' breadcrumbs_inline' : '' ?>">
    <?php if (!$inline) : ?>
    <div class="container">
    <?php endif; ?>
        <ul class="breadcrumbs__inner">
            <li class="breadcrumbs__item">
               <a href="<?php echo home_url() ?>">
                   <?php echo __('Home'); ?>
               </a>
            </li>
            <li class="breadcrumbs__item">
                <?php echo $title ?>
            </li>
        </ul>
    <?php if (!$inline) : ?>
    </div>
    <?php endif; ?>
</nav>
