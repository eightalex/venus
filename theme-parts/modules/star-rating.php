<?php

/**
 * @var $id int - Version is needed to create unique IDs for SVG elements
 * @var $rating float - Rating of the item
 * @var $classname string - Additional class name for the container
 * @var $number_of_stars int - Number of stars to display
 * @var $bg_color string - Background color of the rating
 * @var $bg_stars bool - Whether to display a smooth background for the stars
 */
extract($args);

$id = $id ?? '';
$number_of_stars = $number_of_stars ?? 10;
$width_of_star = 32;
$pad = 8; // padding between stars
$image_width = ($number_of_stars * $width_of_star) - $pad;
$bg_stars = isset($bg_stars) && $bg_stars ? 'star-rating_with-bg' : '';

?>

<div
    class="star-rating <?= $classname ?> <?= $bg_stars ?>"
    data-rating="<?= $rating ?>"
    style="width: <?= $image_width ?>px"
>
    <svg
        xmlns="http://www.w3.org/2000/svg"
        width="<?= $image_width ?>"
        height="24"
        viewBox="0 0 <?= $image_width ?> 24"
    >
        <mask id="starMask<?= $id ?>">
            <rect width="<?= $image_width ?>" height="24" fill="#fff"/>
            <g fill="#000">
                <?php for ($i = 0; $i < $number_of_stars; $i++): ?>
                    <use href="#starPath<?= $id ?>" x="<?= $i * $width_of_star ?>" y="0"/>
                <?php endfor; ?>
            </g>
        </mask>
        <defs>
            <path id="starPath<?= $id ?>" d="M23.9374 9.20628C23.7803 8.7203 23.3493 8.37514 22.8393 8.32918L15.9123 7.7002L13.1731 1.28896C12.9712 0.8191 12.5112 0.514954 12.0001 0.514954C11.4891 0.514954 11.0291 0.8191 10.8271 1.29006L8.08797 7.7002L1.15982 8.32918C0.65077 8.37624 0.220828 8.7203 0.0628038 9.20628C-0.0952203 9.69225 0.0507185 10.2253 0.435799 10.5613L5.67183 15.1533L4.12785 21.9546C4.01487 22.4547 4.20897 22.9716 4.62389 23.2715C4.84692 23.4327 5.10785 23.5147 5.37098 23.5147C5.59786 23.5147 5.8229 23.4535 6.02487 23.3327L12.0001 19.7615L17.9732 23.3327C18.4103 23.5956 18.9612 23.5716 19.3752 23.2715C19.7904 22.9707 19.9843 22.4536 19.8713 21.9546L18.3273 15.1533L23.5633 10.5622C23.9484 10.2253 24.0955 9.69317 23.9374 9.20628Z"/>
        </defs>
        <rect
            width="<?= $image_width ?>"
            height="24"
            fill="<?= $bg_color ?? '#262c3a' ?>"
            mask="url(#starMask<?= $id ?>)"
        />
    </svg>
</div>
