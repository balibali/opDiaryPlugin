<?php
op_mobile_page_title(__('Post a diary'));
?>

<?php if (Doctrine::getTable('SnsConfig')->get('op_diary_plugin_use_email_post', true)): ?>
<?php if('' != $sf_user->getMember()->getConfig('mobile_address')): ?>
[i:106]<?php echo op_mail_to('mail_diary_create', array(), __('Post via E-mail')) ?><br>
<?php echo __('You can attach photo files to e-mail.') ?><br>
<?php else: ?>
<?php echo __('To attach a photo file, please register your mobile address.') ?>(<a href="<?php echo url_for('member_config', array('category'=>'mobileAddress')); ?>"><?php echo __('Mobile E-mail Address Configuration'); ?></a>)<br>
<?php endif; ?>
<?php endif; ?>

<?php
$options['url'] = url_for('diary_create');
$options['button'] = __('Save');
op_include_form('formDiary', $form, $options);
?>
