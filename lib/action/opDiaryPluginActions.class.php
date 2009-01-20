<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * base actions class for the opDiaryPlugin.
 *
 * @package    OpenPNE
 * @subpackage diary
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class opDiaryPluginActions extends sfActions
{
  public function preExecute()
  {
    if (is_callable(array($this->getRoute(), 'getObject')))
    {
      $object = $this->getRoute()->getObject();
      if ($object instanceof Diary)
      {
        $this->diary = $object;
        $this->member = $this->diary->getMember();
      }
      elseif ($object instanceof DiaryComment)
      {
        $this->diaryComment = $object;
        $this->diary = $this->diaryComment->getDiary();
        $this->member = $this->diary->getMember();
      }
      elseif ($object instanceof Member)
      {
        $this->member = $object;
      }
    }

    if (empty($this->member))
    {
      $this->member = $this->getUser()->getMember();
    }
  }

  public function postExecute()
  {
    $this->setNavigation($this->member);

    if ($this->pager instanceof sfPager)
    {
      $this->pager->init();
    }
  }

  protected function setNavigation(Member $member)
  {
    if ($member->getId() !== $this->getUser()->getMemberId())
    {
      sfConfig::set('sf_nav_type', 'friend');
      sfConfig::set('sf_nav_id', $member->getId());
    }
  }

  protected function isAuthor()
  {
    if ($this->diary->getMemberId() === $this->getUser()->getMemberId())
    {
      return true;
    }

    return false;
  }

  protected function isViewable()
  {
    return DiaryPeer::isViewable($this->diary, $this->getUser()->getMemberId());
  }
}
