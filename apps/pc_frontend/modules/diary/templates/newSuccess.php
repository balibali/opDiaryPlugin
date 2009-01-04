<?php decorate_with('layoutB') ?>
<?php slot('op_sidemenu', get_component('diary', 'sidemenu', array('member' => $member))) ?>

<?php
$options = array('form' => array($form));
$title = __('Post a diary');
$options['url'] = 'diary/create';
$options['button'] = __('Save');
$options['isMultipart'] = true;
include_box('formDiary', $title, '', $options);
?>
