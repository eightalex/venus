<?php
extract($args); 

if(!comments_open( $id )){
    return;
}

$f_args = array(
   'class_form' => 'form-reply__form',
   'comment_notes_after' => '',
   'comment_notes_before' => '',
   'title_reply' => '' ,
   'fields' => array (
        'author' => '<div class="form-reply__input input-label">
                        <label for="name" class="input-label__label">Name*</label>
                        <input type="text" id="name" class="input" placeholder="Type your text here">
                    </div>',
        'email' => '<div class="form-reply__input input-label">
                        <label for="email" class="input-label__label">Email*</label>
                        <input type="email" id="email" class="input" placeholder="Type your text here">
                    </div>',
        'url' => '<div class="form-reply__input input-label">
                    <label for="url" class="input-label__label">Website</label>
                    <input type="text" id="url" class="input" placeholder="Type your text here">
                </div>',  
        'cookies' => '<div class="form-reply__input checkbox">
                <input type="checkbox" id="checkbox" class="checkbox__input">
                <label for="checkbox" class="checkbox__label">Save my name, email, and website in this browser for the next time I comment.</label>
            </div>',                
    ),
);	

$fr_bg = !empty($content['fr_bg'])? $content['fr_bg']: get_stylesheet_directory_uri()."/assets/images/section/bg4.jpeg";
?>
<style>
    .section_bg_4::before{
        background-image: url(<?php echo $fr_bg?>); 
    }
</style>

<section class="section section_bg section_bg_4">
    <div class="container">
        <div class="section__inner">
            <div class="form-reply">
                <?php
                if(!empty($content['fr_title']) || !empty($content['fr_subtitle'])):
                    ?>
                    <header class="form-reply__header">
                        <?php
                        if(!empty($content['fr_title'])):
                            ?>
                            <div class="form-reply__title"><?php echo $content['fr_title']?></div>
                            <?php
                        endif;

                        if(!empty($content['fr_subtitle'])):
                            ?>
                            <div class="form-reply__subtitle"><?php echo $content['fr_subtitle']?></div>
                            <?php
                        endif;
                        ?>
                    </header>
                    <?php
                endif;

                comment_form($f_args);
                ?>
                <!-- <form action="http://trd/wp-comments-post.php" method="post" id="commentform" class="form-reply__form">
                    <div class="form-reply__input input-label">
                        <label for="author" class="input-label__label">Name*</label>
                        <input type="text" id="author" class="input" placeholder="Type your text here">
                    </div>
                    <div class="form-reply__input input-label">
                        <label for="email" class="input-label__label">Email*</label>
                        <input type="email" id="email" class="input" placeholder="Type your text here">
                    </div>
                    <div class="form-reply__input input-label">
                        <label for="url" class="input-label__label">Website</label>
                        <input type="text" id="url" class="input" placeholder="Type your text here">
                    </div>
                    <div class="form-reply__input checkbox">
                        <input type="checkbox" id="cookies" class="checkbox__input">
                        <label for="cookies" class="checkbox__label">Save my name, email, and website in this browser for the next time I comment.</label>
                    </div>
                    <div class="form-reply__input input-label">
                        <label for="comment" class="input-label__label">Comment*</label>
                        <textarea id="comment" class="input input_textarea" placeholder="Type your text here"></textarea>
                    </div>
                    <div class="form-reply__cta">
                        <button class="form-reply__button button">Post Comment</button>
                    </div>
                </form> -->
            </div>
        </div>
    </div>
</section>