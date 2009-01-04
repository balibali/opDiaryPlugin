<div id="formDiaryDelete" class="dparts box"><div class="parts">
<div class="partsHeading">
<h3><?php echo __('Delete the diary') ?></h3>
</div>
<div class="block">
<p><?php echo __('Do you really delete this diary?') ?></p>
<form action="<?php echo url_for('@diary_delete?id='.$diary->getId()) ?>" method="post">
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

<?php echo link_to(__('Go back to the diary page'), 'diary_show', $diary) ?>
