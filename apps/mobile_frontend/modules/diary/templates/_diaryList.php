<?php use_helper('opDiary') ?>

<?php if (count($diaryList)): ?>
<?php
$list = array();
foreach ($diaryList as $diary)
{
  $list[] = sprintf('[%s] %s',
              op_diary_format_date($diary->getCreatedAt(), 'XShortDate'),
              link_to($diary->getTitleAndCount(false), 'diary_show', $diary)
            );
}
$options = array(
  'title'  => __('Recently Posted Diaries of All'),
  'border' => true,
  'moreInfo' => array(link_to(__('More'), 'diary/list')),
);
include_list_box('diaryList', $list, $options);
?>
<?php endif; ?>
