<?php use_helper('opDiary') ?>

<?php if (count($list)): ?>
<?php
$result = array();
foreach ($list as $diaryCommentUpdate)
{
  $diary = $diaryCommentUpdate->getDiary();
  $result[] = sprintf("[%s] %s<br>%s",
              op_format_date($diaryCommentUpdate->getLastCommentTime(), 'XShortDate'),
              $diary->getMember()->getName(),
              link_to(op_diary_get_title_and_count($diary, false, 28), 'diary_show', $diary)
            );
}
$moreInfo = array();
$moreInfo[] = link_to(__('More'), 'diaryComment/history');
$options = array(
  'title'  => __('Diary Comment History'),
  'border' => true,
  'moreInfo' => $moreInfo,
);
op_include_list('diaryCommentHistory', $result, $options);
?>
<?php endif; ?>
