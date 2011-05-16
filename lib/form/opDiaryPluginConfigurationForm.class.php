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

    $this->setWidget('use_email_post', new sfWidgetFormSelectRadio(array('choices' => $choices)));
    $this->setValidator('use_email_post', new sfValidatorChoice(array('choices' => array_keys($choices))));
    $this->setDefault('use_email_post', Doctrine::getTable('SnsConfig')->get('op_diary_plugin_use_email_post', '1'));
    $this->widgetSchema->setHelp('use_email_post', 'If this is used, "Post via E-mail" link is shown on the mobile pages.');

    $this->setWidget('update_activity', new sfWidgetFormSelectRadio(array('choices' => $choices)));
    $this->setValidator('update_activity', new sfValidatorChoice(array('choices' => array_keys($choices))));
    $this->setDefault('update_activity', Doctrine::getTable('SnsConfig')->get('op_diary_plugin_update_activity', '0'));
    $this->widgetSchema->setHelp('update_activity', 'If this is used, activity message is updated automatically by posting a diary. To show the activity list, see "Appearance" > "ガジェット設定".');

    $this->setWidget('search_enable', new sfWidgetFormSelectRadio(array('choices' => $choices)));
    $this->setValidator('search_enable', new sfValidatorChoice(array('choices' => array_keys($choices))));
    $this->setDefault('search_enable', Doctrine::getTable('SnsConfig')->get('op_diary_plugin_search_enable', '1'));
    $this->widgetSchema->setHelp('search_enable', 'If this is used, diary search is enabled.');

    $this->setWidget('search_period_enable', new sfWidgetFormSelectRadio(array('choices' => $choices)));
    $this->setValidator('search_period_enable', new sfValidatorChoice(array('choices' => array_keys($choices))));
    $this->setDefault('search_period_enable', Doctrine::getTable('SnsConfig')->get('op_diary_plugin_search_period_enable', '0'));
    $this->widgetSchema->setHelp('search_period_enable', 'If this is used, diary search is enabled only within the days set.');

    $this->setWidget('search_period', new sfWidgetFormInput());
    $this->setValidator('search_period', new sfValidatorInteger(array('min' => 0), array('min' => 'Please input 0 or greater.')));
    $this->setDefault('search_period', Doctrine::getTable('SnsConfig')->get('op_diary_plugin_search_period', '30'));
    $this->widgetSchema->setHelp('search_period', 'Please input the number of days that reflects to the diary search.');

    $this->widgetSchema->setNameFormat('op_diary_plugin[%s]');
  }

  public function save()
  {
    $names = array('use_open_diary', 'use_email_post', 'update_activity', 'search_enable', 'search_period_enable', 'search_period');

    foreach ($names as $name)
    {
      Doctrine::getTable('SnsConfig')->set('op_diary_plugin_'.$name, $this->getValue($name));
    }
  }
}
