<?php decorate_with('layoutB') ?>
<?php slot('op_sidemenu', get_component('diary', 'sidemenu', array('member' => $member))) ?>

<?php include_partial('form', array('form' => $form, 'diary' => $diary)) ?>

<div id="formDiaryDelete" class="dparts box"><div class="parts">
<div class="partsHeading">
<h3><?php echo __('Delete this diary') ?></h3>
</div>
<div class="block">
<form action="<?php echo url_for('diary_delete_confirm', $diary) ?>">
<div class="operation">
<ul class="moreInfo button">
<li>
<input type="submit" class="input_submit" value="<?php echo __('Delete') ?>" />
</li>
</ul>
</div>
</form>
</div>
</div></div>
