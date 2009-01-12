<?php
$this->dispatcher->connect('routing.load_configuration', array('opDiaryPluginRouting', 'listenToRoutingLoadConfigurationEvent'));

sfPropelBehavior::registerHooks('diary_delete_image', array(
  ':delete:pre' => array('opDiaryPluginBehavior', 'deleteDiaryImage'),
));
sfPropelBehavior::add('File', array('diary_delete_image' => array()));
