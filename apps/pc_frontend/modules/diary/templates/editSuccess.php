<?php decorate_with('layoutB') ?>
<?php slot('op_sidemenu', get_component('diary', 'sidemenu', array('member' => $member))) ?>

<?php
$options = array('form' => array($form));
$title = __('Edit the diary');
$options['url'] = 'diary/update?id='.$diary->getId();
$options['button'] = __('Save');
$options['isMultipart'] = true;
include_box('formDiary', $title, '', $options);
?>

<div id="formDiaryDelete" class="dparts box"><div class="parts">
<div class="partsHeading">
<h3><?php echo __('Delete this diary') ?></h3>
</div>
<div class="block">
<form action="<?php echo url_for('diary_delete_confirm', $diary) ?>">
<div class="operation">
<ul class="moreInfo button">
<li>
<input class="input_submit" type="submit" value="<?php echo __('Delete') ?>" />
</li>
</ul>
</div>
</form>
</div>
</div></div>
