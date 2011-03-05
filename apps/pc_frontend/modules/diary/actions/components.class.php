<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * diary components.
 *
 * @package    OpenPNE
 * @subpackage diary
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class diaryComponents extends opDiaryPluginDiaryComponents
{
  public function executeSidemenu()
  {
    include_once('Calendar/Month/Weekdays.php');

    // Calendar
    if (!($this->year && $this->month))
    {
      $this->year = (int)date('Y');
      $this->month = (int)date('m');;
    }

    $this->calendar = new Calendar_Month_Weekdays($this->year, $this->month, 0);
    $this->calendar->build();

    $this->calendarDiaryDays = Doctrine::getTable('Diary')->getMemberDiaryDays($this->member->getId(), $this->getSnsMemberId(), $this->year, $this->month);

    // Recent Diary List
    $this->recentDiaryList = Doctrine::getTable('Diary')->getMemberDiaryList($this->member->getId(), 5, $this->getSnsMemberId());
  }
}
