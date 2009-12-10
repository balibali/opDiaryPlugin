<?php slot('title', __('Delete the comment')) ?>

<?php slot('submenu') ?>
<?php include_component('monitoring', 'submenu') ?>
<?php end_slot() ?>

<p><?php echo __('Do you really delete this comment?') ?></p>

<table>
<tr><th><?php echo __('ID') ?></th><td><?php echo $diaryComment->id ?></td></tr>
<tr><th><?php echo __('Diary') ?></th><td><?php echo $diaryComment->Diary->title ?> (<?php echo __('ID') ?>: <?php echo $diaryComment->diary_id ?>)</td></tr>
<tr><th><?php echo __('Author') ?></th><td><?php echo $diaryComment->Member->name ?></td></tr>
<tr><th><?php echo __('Created at') ?></th><td><?php echo op_format_date($diaryComment->created_at, 'XDateTimeJa') ?></td></tr>
<tr><th><?php echo __('Body') ?></th><td><?php echo nl2br($diaryComment->body) ?></td></tr>
<tr><td colspan="2">
<form action="<?php echo url_for('diaryComment/delete?id='.$diaryComment->id) ?>" method="post">
<?php echo $form[$form->getCSRFFieldName()] ?>
<input class="input_submit" type="submit" value="<?php echo __('Delete') ?>" />
</form>
</td></tr>
</table>

<?php use_helper('Javascript') ?>
<?php echo link_to_function(__('Back to previous page'), 'history.back()') ?>
