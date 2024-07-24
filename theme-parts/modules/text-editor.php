<?php
extract($args);

if(empty($content['text_editor'])){
    return;
}

$get_params           	= $_GET;
$pagi_lnks              = [
    'term',
    'bonuses-cat',
    'casinos-cat',
    'games-cat',
	'posts-page',
    'bonuses-page',
    'casinois-page',
    'games-page'
];

$is_paginavi = false;

foreach($get_params as $p => $v){
    if(in_array($p, $pagi_lnks)){
        $is_paginavi = true;
    }
}

$txt = $content['text_editor'];

if($is_paginavi){
    return;
}
?>
<section class="section section_suits">
    <div class="container">
        <div class="section__inner">
            <div class="variable-content">
                <?php
                   echo apply_filters('the_content',$txt);
                ?>
            </div>
        </div>
    </div>
</section>