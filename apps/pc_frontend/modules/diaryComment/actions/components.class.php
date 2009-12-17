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
  public function executeList(sfWebRequest $request)
  {
    $this->sizes = array(20, 100);

    $this->size = (int)$request['size'];
    if (!in_array($this->size, $this->sizes))
    {
      $this->size = $this->sizes[0];
    }

    parent::executeList($request);
  }
}
