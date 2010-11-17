<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

if (empty($_app))
{
  $_app = 'pc_frontend';
}
$_env = 'test';

$configuration = ProjectConfiguration::getApplicationConfiguration($_app, $_env, true);
new sfDatabaseManager($configuration);

try
{
  if (3 > (int)Doctrine::getTable('SnsConfig')->get('opDiaryPlugin_test_revision'))
  {
    throw new Exception();
  }
}
catch (Exception $e)
{
  $task = new sfDoctrineBuildTask($configuration->getEventDispatcher(), new sfFormatter());
  $task->setConfiguration($configuration);
  $task->run(array(), array(
    'no-confirmation' => true,
    'db'              => true,
    'and-load'        => false,
    'application'     => $_app,
    'env'             => $_env,
  ));

  $task = new sfDoctrineDataLoadTask($configuration->getEventDispatcher(), new sfFormatter());
  $task->setConfiguration($configuration);
  $task->run(array(
    dirname(__FILE__).'/../../../../data/fixtures/010_import_sns_terms.yml',
    dirname(__FILE__).'/../../../../data/fixtures/003_import_admin_user.yml',
    dirname(__FILE__).'/../fixtures',
  ));
}
