<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * MemberConfigDiaryForm.
 *
 * @package    opDiaryPlugin
 * @subpackage form
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class MemberConfigDiaryForm extends MemberConfigForm
{
  const PUBLIC_FLAG = 'diary_public_flag';

  protected $category = 'diary';

  public function configure()
  {
    $this->widgetSchema[self::PUBLIC_FLAG] = new sfWidgetFormChoice(array(
      'choices'  => Doctrine::getTable('Diary')->getPublicFlags(),
      'expanded' => true,
      'default'  => $this->getConfig(self::PUBLIC_FLAG, DiaryTable::PUBLIC_FLAG_SNS),
      'label'    => 'Public flag',
    ));
    $this->widgetSchema->setHelp(self::PUBLIC_FLAG, 'Default public flag for your new diaries. Past diaries are not changed.');

    $this->validatorSchema[self::PUBLIC_FLAG] = new sfValidatorChoice(array(
      'choices' => array_keys(Doctrine::getTable('Diary')->getPublicFlags()),
    ));
  }

  protected function getConfig($name, $default = null)
  {
    $value = $this->member->getConfig($name);
    if (null === $value)
    {
      $value = $default;
    }

    return $value;
  }
}
