<?php
op_mobile_page_title(__('Delete the comment'));
?>

<?php echo __('Do you really delete this comment?') ?><br>
<br>

<form action="<?php echo url_for('diary_comment_delete', $diaryComment) ?>" method="post">
<?php echo $form[$form->getCSRFFieldName()] ?>
<input type="submit" value="<?php echo __('Delete') ?>"><br>
</form>

<?php echo link_to(__('Back'), 'diary_show', $diary) ?>
