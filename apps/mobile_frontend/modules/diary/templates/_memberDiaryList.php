<?php use_helper('Date') ?>

<?php if (count($diaryList)): ?>
<?php
$list = array();
foreach ($diaryList as $diary)
{
  $list[] = format_date($diary->getCreatedAt()).' '.link_to($diary->getTitle(), '@diary_by_id?id='.$diary->getId());
}
$moreInfo = array();
$moreInfo[] = link_to(__('More'), 'diary/listMember?id='.$memberId);
$options = array(
  'title'  => __('Recently Posted Diaries'),
  'border' => true,
  'moreInfo' => $moreInfo,
);
include_list_box('memberDiaryList', $list, $options);
?>
<?php endif; ?>
