<?php

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
