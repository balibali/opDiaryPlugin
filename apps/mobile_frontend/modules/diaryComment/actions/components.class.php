<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * diaryComment components.
 *
 * @package    OpenPNE
 * @subpackage diary
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class diaryCommentComponents extends opDiaryPluginDiaryCommentComponents
{
  protected function getPager(sfWebRequest $request)
  {
    $pager = parent::getPager($request);
    $pager->setMaxPerPage(5);

    return $pager;
  }
}
