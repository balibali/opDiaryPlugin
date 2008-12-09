<?php

/**
 * Diary form.
 *
 * @package    OpenPNE
 * @subpackage form
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class DiaryForm extends BaseDiaryForm
{
  public function configure()
  {
    unset($this->widgetSchema['member_id']);
    $this->widgetSchema['title'] = new sfWidgetFormInput();

    unset($this['created_at']);
    unset($this['updated_at']);
  }
}
