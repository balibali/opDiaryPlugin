<?php use_helper('opDiary') ?>

<?php
$list = array();
foreach ($diaryList as $diary)
{
  $list[] = sprintf('[%s] %s',
              op_diary_format_date($diary->getCreatedAt(), 'XShortDate'),
              link_to($diary->getTitleAndCount(false), 'diary_show', $diary)
            );
}
$moreInfo = array();
if (count($diaryList))
{
  $moreInfo[] = link_to(__('More'), 'diary_list_mine');
}
$moreInfo[] = link_to(__('Post a diary'), 'diary_new');
$options = array(
  'title'  => __('My Diaries'),
  'border' => true,
  'moreInfo' => $moreInfo,
);
op_include_list('myDiaryList', $list, $options);
?>
