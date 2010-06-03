<?php
if (!isset($keyword))
{
  $title = __('Recently Posted Diaries');
  $pagerLink = '@diary_list?page=%d';
}
else
{
  $title = __('Search Results');
  $pagerLink = '@diary_search?keyword='.mb_convert_encoding($keyword, 'SJIS-win', 'UTF-8').'&page=%d';
}
?>
<?php op_mobile_page_title($title) ?>
<?php use_helper('opDiary'); ?>

<?php if ($pager->getNbResults()): ?>

<center>
<?php op_include_pager_total($pager); ?>
</center>
<?php
$list = array();
foreach ($pager->getResults() as $diary)
{
  $list[] = sprintf("%s<br>%s (%s)",
              op_format_date($diary->created_at, 'XDateTime'),
              link_to(op_diary_get_title_and_count($diary, false, 28), 'diary_show', $diary),
              $diary->Member->name
            );
}
$options = array(
  'border' => true,
);
op_include_list('diaryList', $list, $options);
?>
<?php echo op_include_pager_navigation($pager, $pagerLink, array('is_total' => false)) ?>

<?php else: ?>

<?php echo (!isset($keyword)) ? __('There are no diaries.') : __('Your search "%1%" did not match any diaries.', array('%1%' => $keyword)) ?>

<?php endif; ?>

<?php slot('diarySearchForm') ?>
<form action="<?php echo url_for('@diary_search') ?>">
<input type="text" name="keyword" value="<?php if (isset($keyword)) echo $keyword ?>">
<input type="submit" value="<?php echo __('Search') ?>">
</form>
<?php end_slot() ?>
<?php
$options = array(
  'title' => __('Diary Search'),
);
op_include_box('diarySearchForm', get_slot('diarySearchForm'), $options)
?>
