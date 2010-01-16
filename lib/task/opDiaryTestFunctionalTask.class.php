<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opDiaryTestFunctionalTask
 *
 * @package    opDiaryPlugin
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class opDiaryTestFunctionalTask extends sfTestFunctionalTask
{
  protected function configure()
  {
    parent::configure();

    $this->namespace = 'opDiary';
    $this->name      = 'test-functional';
  }

  protected function execute($arguments = array(), $options = array())
  {
    $this->configuration->getPluginConfiguration('opDiaryPlugin')->connectPluginOnlyTests();

    return parent::execute($arguments, $options);
  }
}
