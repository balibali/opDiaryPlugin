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

    $this->setWidget('use_open_diary', new sfWidgetFormSelectRadio(array('choices' => $choices)));
    $this->setValidator('use_open_diary', new sfValidatorChoice(array('choices' => array_keys($choices))));
    $this->setDefault('use_open_diary', Doctrine::getTable('SnsConfig')->get('op_diary_plugin_use_open_diary', '1'));
    $this->widgetSchema->setHelp('use_open_diary', 'If this is used, members can select the "All Users on the Web" public flag. If not used, anonymous users can\'t view any diary pages.');

    $this->widgetSchema->setNameFormat('op_diary_plugin[%s]');
  }

  public function save()
  {
    $names = array('use_open_diary');

    foreach ($names as $name)
    {
      Doctrine::getTable('SnsConfig')->set('op_diary_plugin_'.$name, $this->getValue($name));
    }
  }
}
