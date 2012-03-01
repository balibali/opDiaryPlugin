<?php
op_mobile_page_title(__('Post a diary'));
?>

<?php if ('example.com' !== sfConfig::get('op_mail_domain')): ?>
<?php if ($member->getConfig('mobile_address')): ?>
[i:106]<?php echo op_mail_to('mail_diary_create', array(), __('Post from E-mail')) ?><br>
<?php echo __('You can attach photo files to e-mail.') ?><br>
<?php else: ?>
<?php echo __('To attach a photo file, please register your mobile address.') ?>
(<?php echo link_to(__('Mobile E-mail Address Configuration'), 'member/config?category=mobileAddress') ?>)<br>
<?php endif; ?>
<?php endif; ?>

<?php
$options['url'] = url_for('diary_create');
$options['button'] = __('Save');
op_include_form('formDiary', $form, $options);
?>
