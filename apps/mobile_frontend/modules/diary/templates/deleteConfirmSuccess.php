<?php
op_mobile_page_title(__('Delete the diary'));
?>

<?php echo __('Do you really delete this diary?') ?><br>
<br>

<form action="<?php echo url_for('diary_delete', $diary) ?>" method="post">
<?php echo $form[$form->getCSRFFieldName()] ?>
<input type="submit" value="<?php echo __('Delete') ?>"><br>
</form>

<?php echo link_to(__('Back'), 'diary_show', $diary) ?>
