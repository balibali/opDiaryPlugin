<?php
op_mobile_page_title(__('Post a diary'));
?>

<?php if ('example.com' !== sfConfig::get('op_mail_domain')): ?>
[i:106]<?php echo op_mail_to('mail_diary_create', array(), __('Post from E-mail')) ?><br>
<?php echo __('You can attach photo files to e-mail.') ?><br>
<?php endif; ?>

<?php
$options['url'] = url_for('diary_create');
$options['button'] = __('Save');
op_include_form('formDiary', $form, $options);
?>
