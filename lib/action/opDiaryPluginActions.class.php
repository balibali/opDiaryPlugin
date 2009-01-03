<?php

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
        $this->setNavigation($this->diary->getMemberId());
      }
      elseif ($object instanceof DiaryComment)
      {
        $this->diaryComment = $object;
        $this->diary = $this->diaryComment->getDiary();
        $this->setNavigation($this->diary->getMemberId());
      }
      elseif ($object instanceof Member)
      {
        $this->member = $object;
        $this->setNavigation($this->member->getId());
      }
    }
  }

  protected function setNavigation($memberId)
  {
    if ($memberId !== $this->getUser()->getMemberId())
    {
      sfConfig::set('sf_navi_type', 'friend');
      sfConfig::set('sf_navi_id', $memberId);
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
