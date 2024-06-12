<?php
$title = get_the_title();
if(is_tax() || is_category()){
    $title = get_queried_object()->name;
}

?>

<nav class="breadcrumbs">
    <div class="container">
        <ul class="breadcrumbs__inner">
            <li class="breadcrumbs__item">
               <a href="<?php echo home_url()?>">Home</a>
            </li>

            <li class="breadcrumbs__item">
                <?php echo $title?>
            </li>
        </ul>
    </div>
</nav>