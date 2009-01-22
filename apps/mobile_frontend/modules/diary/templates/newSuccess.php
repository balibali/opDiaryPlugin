<?php
op_mobile_page_title(__('Post a diary'));
?>

<?php
$options['url'] = 'diary/create';
$options['button'] = __('Save');
op_include_form('formDiary', $form, $options);
?>
