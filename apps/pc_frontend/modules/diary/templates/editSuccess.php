<?php
$options = array('form' => array($form));
if ($form->isNew())
{
  $title = '日記を作成する';
  $options['url'] = 'diary/edit';
}
else
{
  $title = '日記を編集する';
  $options['url'] = 'diary/edit?id='.$diary->getId();
}
$options['button'] = '確定';
include_box('formDiary', $title, '', $options);
?>
