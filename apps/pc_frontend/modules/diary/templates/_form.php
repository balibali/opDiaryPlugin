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
  $options['url'] = 'diary/create';
}
else
{
  $options['title'] = __('Edit the diary');
  $options['url'] = 'diary/update?id='.$diary->getId();
}

op_include_parts('form', 'diaryForm', $form, $options);
?>
