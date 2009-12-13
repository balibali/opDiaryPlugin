<div class="parts searchFormLine">
<form action="<?php echo url_for('@monitoring_diary_search') ?>" method="get">
<p class="form">
<?php echo __('ID') ?>:
<input type="text" class="input_text" name="id" size="10" value="<?php if ($sf_request->hasParameter('id')) echo $sf_request->getParameter('id') ?>" />
<input type="submit" value="<?php echo __('Search') ?>" />
</p>
</form>
</div>

<div class="parts searchFormLine">
<form action="<?php echo url_for('@monitoring_diary_search') ?>" method="get">
<p class="form">
<?php echo __('Keyword') ?>:
<input type="text" class="input_text" name="keyword" size="30" value="<?php if ($sf_request->hasParameter('keyword')) echo $sf_request->getParameter('keyword') ?>" />
<input type="submit" value="<?php echo __('Search') ?>" />
</p>
</form>
</div>
