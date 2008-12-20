<?php

/**
 * DiaryImage form.
 *
 * @package    OpenPNE
 * @subpackage form
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class DiaryImageForm extends BaseDiaryImageForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'photo_1' => new sfWidgetFormInputFile(),
      'photo_2' => new sfWidgetFormInputFile(),
      'photo_3' => new sfWidgetFormInputFile(),
    ));
    $this->setValidators(array(
      'photo_1' => new opValidatorImageFile(array('required' => false)),
      'photo_2' => new opValidatorImageFile(array('required' => false)),
      'photo_3' => new opValidatorImageFile(array('required' => false)),
    ));
  }
}
