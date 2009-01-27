<?php use_helper('opDiary') ?>

<?php if (count($diaryList)): ?>
<?php
$list = array();
foreach ($diaryList as $diary)
{
  $list[] = sprintf("[%s] %s<br>%s",
              op_format_date($diary->getCreatedAt(), 'XShortDate'),
              $diary->getMember()->getName(),
              link_to(op_diary_get_title_and_count($diary, false, 28), 'diary_show', $diary)
            );
}
$moreInfo = array();
$moreInfo[] = link_to(__('More'), 'diary/listFriend');
$options = array(
  'title'  => __('Recently Posted Diaries of Friends'),
  'border' => true,
  'moreInfo' => $moreInfo,
);
op_include_list('friendDiaryList', $list, $options);
?>
<?php endif; ?>
