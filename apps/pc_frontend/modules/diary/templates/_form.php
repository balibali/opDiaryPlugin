<?php
$form->getWidget('title')->setAttribute('size', 40);
$form->getWidget('body')->setAttribute('rows', 10);
$form->getWidget('body')->setAttribute('cols', 50);

$options = array(
  'button' => __('Save'),
  'isMultipart' => true,
);

if ($form->isNew())
{
  $options['title'] = __('Post a diary');
  $options['url'] = url_for('diary_create');
}
else
{
  $options['title'] = __('Edit the diary');
  $options['url'] = url_for('diary_update', $diary);
}

op_include_form('diaryForm', $form, $options);
?>
