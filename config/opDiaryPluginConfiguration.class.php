<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opDiaryPluginConfiguration
 *
 * @package    opDiaryPlugin
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class opDiaryPluginConfiguration extends sfPluginConfiguration
{
  public function connectPluginOnlyTests()
  {
    $this->dispatcher->connect('task.test.filter_test_files', array($this, 'filterPluginOnlyTestFiles'));
  }

  public function filterPluginOnlyTestFiles(sfEvent $event, $files)
  {
    $files = $this->filterTestFiles($event, $files);

    foreach ($files as $key => $file)
    {
      if (false === strpos($file, $this->rootDir))
      {
        unset($files[$key]);
      }
    }

    return $files;
  }
}
