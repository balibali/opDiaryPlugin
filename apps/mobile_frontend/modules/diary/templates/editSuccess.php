<?php
op_mobile_page_title(__('Edit the diary'));
?>

<?php
$options['url'] = 'diary/update?id='.$diary->getId();
$options['button'] = __('Save');
op_include_form('formDiary', $form, $options);
?>
