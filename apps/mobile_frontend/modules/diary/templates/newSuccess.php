<?php
include_page_title(__('Post a diary'));
?>

<?php
$options = array('form' => array($form));
$options['url'] = 'diary/create';
$options['button'] = __('Save');
include_box('formDiary', '', '', $options);
?>
