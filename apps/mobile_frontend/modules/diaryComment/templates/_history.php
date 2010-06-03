<?php use_helper('opDiary') ?>

<?php if (count($list)): ?>
<?php
$result = array();
foreach ($list as $diaryCommentUpdate)
{
  $diary = $diaryCommentUpdate->Diary;
  $result[] = sprintf("[%s] %s<br>%s",
              op_format_date($diaryCommentUpdate->last_comment_time, 'XShortDate'),
              $diary->Member->name,
              link_to(op_diary_get_title_and_count($diary, false, 28), 'diary_show', $diary)
            );
}
$moreInfo = array();
$moreInfo[] = link_to(__('More'), '@diary_comment_history');
$options = array(
  'title'  => __('Diary Comment History'),
  'border' => true,
  'moreInfo' => $moreInfo,
);
op_include_list('diaryCommentHistory', $result, $options);
?>
<?php endif; ?>
