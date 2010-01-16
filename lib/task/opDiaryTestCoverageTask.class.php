<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opDiaryTestCoverageTask
 *
 * @package    opDiaryPlugin
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class opDiaryTestCoverageTask extends sfTestCoverageTask
{
  protected function configure()
  {
    parent::configure();

    $this->namespace = 'opDiary';
    $this->name      = 'test-coverage';
  }

  protected function execute($arguments = array(), $options = array())
  {
    $arguments['test_name'] = 'plugins/opDiaryPlugin/'.$arguments['test_name'];
    $arguments['lib_name']  = 'plugins/opDiaryPlugin/'.$arguments['lib_name'];

    return parent::execute($arguments, $options);
  }
}
