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

    if (!Doctrine::getTable('SnsConfig')->get('op_diary_plugin_use_open_diary', true))
    {
      $this->security = array();
    }

    $this->security['all'] = array('is_secure' => true, 'credentials' => 'SNSMember');
  }

  public function preExecute()
  {
    if (is_callable(array($this->getRoute(), 'getObject')))
    {
      try
      {
        $object = $this->getRoute()->getObject();
      }
      catch (sfError404Exception $e)
      {
        $this->forwardUnless($this->isSNSMember(),
            sfConfig::get('sf_login_module'), sfConfig::get('sf_login_action'));

        throw $e;
      }

      if ($object instanceof Diary)
      {
        $this->diary = $object;
        $this->member = $this->diary->Member;
      }
      elseif ($object instanceof DiaryComment)
      {
        $this->diaryComment = $object;
        $this->diary = $this->diaryComment->Diary;
        $this->member = $this->diary->Member;
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
    elseif ($this->member->id !== $this->getUser()->getMemberId())
    {
      $relation = Doctrine::getTable('MemberRelationship')->retrieveByFromAndTo($this->member->id, $this->getUser()->getMemberId());
      $this->forwardIf($relation && $relation->is_access_block, 'default', 'error');
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
    if ($member->id !== $this->getUser()->getMemberId())
    {
      sfConfig::set('sf_nav_type', 'friend');
      sfConfig::set('sf_nav_id', $member->id);
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
