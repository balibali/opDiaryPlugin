<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opDiaryTestUnitTask
 *
 * @package    opDiaryPlugin
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class opDiaryTestUnitTask extends sfTestUnitTask
{
  protected function configure()
  {
    parent::configure();

    $this->namespace = 'opDiary';
    $this->name      = 'test-unit';
  }

  protected function execute($arguments = array(), $options = array())
  {
    $this->configuration->getPluginConfiguration('opDiaryPlugin')->connectPluginOnlyTests();

    return parent::execute($arguments, $options);
  }
}
