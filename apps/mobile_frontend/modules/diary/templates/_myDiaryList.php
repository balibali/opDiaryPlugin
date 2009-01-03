<?php use_helper('Date') ?>

<?php
$list = array();
foreach ($diaryList as $diary)
{
  $list[] = format_date($diary->getCreatedAt()).' '.link_to($diary->getTitle(), 'diary_show', $diary);
}
$moreInfo = array();
if (count($diaryList))
{
  $moreInfo[] = link_to(__('More'), 'diary/listMember?id='.$sf_user->getMemberId());
}
$moreInfo[] = link_to(__('Post a diary'), 'diary_new');
$options = array(
  'title'  => __('Recently Posted Diaries'),
  'border' => true,
  'moreInfo' => $moreInfo,
);
include_list_box('myDiaryList', $list, $options);
?>
