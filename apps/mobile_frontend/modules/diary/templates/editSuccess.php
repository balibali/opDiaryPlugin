<?php
if ($form->isNew())
{
  $title = __('Post a diary');
}
else
{
  $title = __('Edit the diary');
}
include_page_title($title);
?>

<?php
$options = array('form' => array($form));
if ($form->isNew())
{
  $options['url'] = 'diary/edit';
}
else
{
  $options['url'] = 'diary/edit?id='.$diary->getId();
}
$options['button'] = __('Save');
$options['isMultipart'] = true;
include_box('formDiary', '', '', $options);
?>
