<?php use_helper('opDiary') ?>

<?php if (count($diaryList)): ?>
<?php
$list = array();
foreach ($diaryList as $diary)
{
  $list[] = sprintf("[%s] %s<br>%s",
              op_format_date($diary->created_at, 'XShortDate'),
              $diary->Member->name,
              link_to(op_diary_get_title_and_count($diary, false, 28), 'diary_show', $diary)
            );
}
$options = array(
  'title'  => __('Recently Posted Diaries of All'),
  'border' => true,
  'moreInfo' => array(link_to(__('More'), '@diary_list')),
);
op_include_list('diaryList', $list, $options);
?>
<?php endif; ?>
