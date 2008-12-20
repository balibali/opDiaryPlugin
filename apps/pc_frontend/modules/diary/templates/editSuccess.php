<?php
$options = array('form' => array($form));
if ($form->isNew())
{
  $title = __('Post a diary');
  $options['url'] = 'diary/edit';
}
else
{
  $title = __('Edit the diary');
  $options['url'] = 'diary/edit?id='.$diary->getId();
}
$options['button'] = __('Save');
$options['isMultipart'] = true;
include_box('formDiary', $title, '', $options);
?>
