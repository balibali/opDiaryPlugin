<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opDiaryPluginConfigurationForm
 *
 * @package    OpenPNE
 * @subpackage opDiaryPlugin
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class opDiaryPluginConfigurationForm extends BaseForm
{
  public function configure()
  {
    $choices = array('1' => 'Use', '0' => 'Not use');

    $this->setWidget('use_email_post', new sfWidgetFormSelectRadio(array('choices' => $choices)));
    $this->setValidator('use_email_post', new sfValidatorChoice(array('choices' => array_keys($choices))));
    $this->setDefault('use_email_post', Doctrine::getTable('SnsConfig')->get('op_diary_plugin_use_email_post', '1'));
    $this->widgetSchema->setHelp('use_email_post', 'If this is used, "Post via E-mail" link is shown on the mobile pages.');

    $this->setWidget('update_activity', new sfWidgetFormSelectRadio(array('choices' => $choices)));
    $this->setValidator('update_activity', new sfValidatorChoice(array('choices' => array_keys($choices))));
    $this->setDefault('update_activity', Doctrine::getTable('SnsConfig')->get('op_diary_plugin_update_activity', '0'));
    $this->widgetSchema->setHelp('update_activity', 'If this is used, activity message is updated automatically by posting a diary. To show the activity list, see "Appearance" > "ガジェット設定".');

    $this->widgetSchema->setNameFormat('op_diary_plugin[%s]');
  }

  public function save()
  {
    $names = array('use_email_post', 'update_activity');

    foreach ($names as $name)
    {
      Doctrine::getTable('SnsConfig')->set('op_diary_plugin_'.$name, $this->getValue($name));
    }
  }
}
