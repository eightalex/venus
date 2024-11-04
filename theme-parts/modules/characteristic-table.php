<?php 
    $p_id                      = get_the_ID();
    $characteristic_title      = carbon_get_post_meta($p_id, 'characteristics_title');
    $characteristic_attributes = carbon_get_post_meta($p_id, 'characteristics_attributes');

    if (isset($characteristic_attributes) && count($characteristic_attributes) !== 0):
?>

<div class="characteristic-table">
    <h2 class="section__title characteristic-table__title">
    <?php echo do_shortcode($characteristic_title) ?>
    </h2>
    <div class="characteristic-table__container">
        <table class="characteristic-table__table">
            <?php foreach($characteristic_attributes as $characteristic): ?>
            <tr>
            <td><?php echo $characteristic['attribute'] ?></td>
            <td><?php echo $characteristic['attribute_value'] ?></td>
            </tr>
            <?php endforeach?>
        </table>
    </div>
</div>
<?php endif  ?>