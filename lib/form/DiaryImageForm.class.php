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
      'file1' => new sfWidgetFormInputFile(),
      'file2' => new sfWidgetFormInputFile(),
      'file3' => new sfWidgetFormInputFile(),
    ));

    $options = array('required' => false, 'mime_types' => 'web_images');
    $this->setValidators(array(
      'file1' => new sfValidatorFile($options),
      'file2' => new sfValidatorFile($options),
      'file3' => new sfValidatorFile($options),
    ));
  }
}
