<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

class diaryActions extends opDiaryPluginDiaryActions
{
  public function executeShow(sfWebRequest $request)
  {
    $this->forwardIf(!$this->getUser()->hasCredential('SNSMember') && !$this->diary->is_open, 'member', 'login');

    parent::executeShow($request);
  }
}
