<?php use_helper('opDiary') ?>

<?php if ($count): ?>
<span class="caution"><?php echo format_number_choice('[1]1 diary has new comments!|(1,Inf]%1% diaries have new comments!', array('%1%' => $count), $count) ?></span>
<?php echo link_to('<strong>'.__('Read diary').'</strong>', op_diary_url_for_show($diary)) ?>
<?php endif; ?>
