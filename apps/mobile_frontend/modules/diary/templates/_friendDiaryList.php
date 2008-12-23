<?php use_helper('Date') ?>

<?php if (count($diaryList)): ?>
<?php
$list = array();
foreach ($diaryList as $diary)
{
  $list[] = format_date($diary->getCreatedAt()).' '.link_to($diary->getTitle(), '@diary_by_id?id='.$diary->getId());
}
$moreInfo = array();
$moreInfo[] = link_to(__('More'), 'diary/listFriend');
$options = array(
  'title'  => __('Recently Posted Diaries of Friends'),
  'border' => true,
  'moreInfo' => $moreInfo,
);
include_list_box('friendDiaryList', $list, $options);
?>
<?php endif; ?>
