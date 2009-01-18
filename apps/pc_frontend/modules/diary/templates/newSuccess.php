<?php decorate_with('layoutB') ?>
<?php slot('op_sidemenu', get_component('diary', 'sidemenu', array('member' => $member))) ?>

<?php include_partial('form', array('form' => $form)) ?>
