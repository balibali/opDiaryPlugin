<?php
op_mobile_page_title(__('Edit the diary'));
?>

<?php
$options['url'] = url_for('diary_update', $diary);
$options['button'] = __('Save');
op_include_form('formDiary', $form, $options);
?>
