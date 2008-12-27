<?php

/**
 * DiaryComment form.
 *
 * @package    OpenPNE
 * @subpackage form
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class DiaryCommentForm extends BaseDiaryCommentForm
{
  public function configure()
  {
    unset($this['id']);
    unset($this['diary_id']);
    unset($this['member_id']);
    unset($this['number']);
    unset($this['created_at']);
    unset($this['updated_at']);
  }
}
