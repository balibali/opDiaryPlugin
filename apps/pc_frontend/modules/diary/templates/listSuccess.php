<?php use_helper('opDiary'); ?>

<div id="diarySearchFormLine" class="parts searchFormLine">
<form action="<?php echo url_for('@diary_search') ?>" method="get">
<p class="form">
<input id="keyword" type="text" class="input_text" name="keyword" size="30" value="<?php if (isset($keyword)) echo $keyword ?>" />
<input type="submit" value="<?php echo __('Search') ?>" />
</p>
</form>
</div>

<?php
if (!isset($keyword))
{
  $title = __('Recently Posted Diaries');
  $pagerLink = '@diary_list?page=%d';
}
else
{
  $title = __('Search Results');
  $pagerLink = '@diary_search?keyword='.$keyword.'&page=%d';
}
?>
<?php if ($pager->getNbResults()): ?>
<div class="dparts searchResultList"><div class="parts">
<div class="partsHeading"><h3><?php echo $title ?></h3></div>
<?php echo op_include_pager_navigation($pager, $pagerLink); ?>
<div class="block">
<?php foreach ($pager->getResults() as $diary): ?>
<div class="ditem"><div class="item"><table><tbody><tr>
<td rowspan="4" class="photo"><a href="<?php echo url_for('diary_show', $diary) ?>"><?php echo image_tag_sf_image($diary->Member->getImageFilename(), array('size' => '76x76')) ?></a></td>
<th><?php echo __('%Nickname%') ?></th><td><?php echo $diary->Member->name ?></td>
</tr><tr>
<th><?php echo __('Title') ?></th><td><?php echo op_diary_get_title_and_count($diary) ?><?php echo op_diary_image_icon($diary) ?></td>
</tr><tr>
<th><?php echo __('Body') ?></th><td><?php echo op_truncate(op_decoration($diary->body, true), 36, '', 3) ?></td>
</tr><tr class="operation">
<th><?php echo __('Created at') ?></th><td><span class="text"><?php echo op_format_date($diary->created_at, 'XDateTimeJa') ?></span> <span class="moreInfo"><?php echo link_to(__('View this diary'), 'diary_show', $diary) ?></span></td>
</tr></tbody></table></div></div>
<?php endforeach; ?>
</div>
<?php echo op_include_pager_navigation($pager, $pagerLink); ?>
</div></div>
<?php else: ?>
<?php op_include_box('diaryList', (!isset($keyword)) ? __('There are no diaries.') : __('Your search "%1%" did not match any diaries.', array('%1%' => $keyword)), array('title' => $title)) ?>
<?php endif; ?>
