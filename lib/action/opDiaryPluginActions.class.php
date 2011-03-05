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
  public function initialize($context, $moduleName, $actionName)
  {
    parent::initialize($context, $moduleName, $actionName);

    $this->security['all'] = array('is_secure' => true, 'credentials' => 'SNSMember');
  }

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
    elseif ($this->member->getId() !== $this->getUser()->getMemberId())
    {
      $relation = Doctrine::getTable('MemberRelationship')->retrieveByFromAndTo($this->member->getId(), $this->getUser()->getMemberId());
      $this->forwardIf($relation && $relation->getIsAccessBlock(), 'default', 'error');
    }

    $this->myMemberId = $this->getSnsMemberId();
  }

  public function postExecute()
  {
    if ($this->isSnsMember())
    {
      $this->setNavigation($this->member);

      // to display header navigations
      $this->setIsSecure();
    }

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

  protected function setIsSecure()
  {
    if (!$this->isSecure())
    {
      $security = $this->getSecurityConfiguration();

      $actionName = strtolower($this->getActionName());

      $security[$actionName]['is_secure'] = true;

      $this->setSecurityConfiguration($security);
    }
  }

  protected function isDiaryAuthor()
  {
    return $this->diary->isAuthor($this->getUser()->getMemberId());
  }

  protected function isDiaryViewable()
  {
    return $this->diary->isViewable($this->getUser()->getMemberId());
  }

  protected function isSnsMember()
  {
    return $this->getUser()->isAuthenticated() && $this->getUser()->hasCredential('SNSMember');
  }

  protected function getSnsMemberId()
  {
    return $this->isSnsMember() ? $this->getUser()->getMemberId() : null;
  }
}
