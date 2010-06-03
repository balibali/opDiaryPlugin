<?php use_helper('opDiary') ?>

<?php if (count($diaryList)): ?>
<?php
$list = array();
foreach ($diaryList as $diary)
{
  $list[] = sprintf('[%s] %s',
              op_format_date($diary->created_at, 'XShortDate'),
              link_to(op_diary_get_title_and_count($diary, false, 28), 'diary_show', $diary)
            );
}
$moreInfo = array();
$moreInfo[] = link_to(__('More'), '@diary_list_member?id='.$memberId);
$options = array(
  'title'  => __('Recently Posted Diaries'),
  'border' => true,
  'moreInfo' => $moreInfo,
);
op_include_list('memberDiaryList', $list, $options);
?>
<?php endif; ?>
