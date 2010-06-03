<?php slot('title', __('Delete the diary')) ?>

<?php slot('submenu') ?>
<?php include_component('monitoring', 'submenu') ?>
<?php end_slot() ?>

<p><?php echo __('Do you really delete this diary?') ?></p>

<table>
<?php include_partial('diary', array('diary' => $diary)) ?>
<tr><td colspan="2">
<form action="<?php echo url_for('@monitoring_diary_delete?id='.$diary->id) ?>" method="post">
<?php echo $form[$form->getCSRFFieldName()] ?>
<input class="input_submit" type="submit" value="<?php echo __('Delete') ?>" />
</form>
</td></tr>
</table>

<?php use_helper('Javascript') ?>
<?php echo link_to_function(__('Back to previous page'), 'history.back()') ?>
