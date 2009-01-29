<?php
op_mobile_page_title(__('Post a diary'));
?>

<?php
$options['url'] = url_for('diary/create');
$options['button'] = __('Save');
op_include_form('formDiary', $form, $options);
?>
