<?php
$form->getWidget('title')->setAttribute('size', 40);
$form->getWidget('body')->setAttribute('rows', 10);
$form->getWidget('body')->setAttribute('cols', 50);

$options = array(
  'form' => $form,
  'button' => __('Save'),
  'isMultipart' => true,
);

if ($form->isNew())
{
  $title = __('Post a diary');
  $options['url'] = 'diary/create';
}
else
{
  $title = __('Edit the diary');
  $options['url'] = 'diary/update?id='.$diary->getId();
}

include_box('formDiary', $title, '', $options);
?>
