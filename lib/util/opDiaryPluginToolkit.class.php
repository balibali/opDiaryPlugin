<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opDiaryPluginToolkit
 *
 * @package    OpenPNE
 * @subpackage diary
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 * @author     Shinichi Urabe <urabe@tejimaya.com>
 */
class opDiaryPluginToolkit
{
  static protected $mailTemplates = array();

  static public function parseKeyword($keyword)
  {
    $keywords = array();

    // replace double-byte space with single-byte space
    $keyword = str_replace('　', ' ', $keyword);

    $parts = explode(' ', $keyword);
    foreach ($parts as $part)
    {
      $part = trim($part);
      if ('' !== $part)
      {
        $keywords[] = $part;
      }
    }

    return $keywords;
  }

  static public function getMailTemplate($env, $templateName, $lang = 'ja_JP')
  {
    $tmpName = $env.'_'.$templateName;
    if (isset(self::$mailTemplates[$tmpName]))
    {
      return self::$mailTemplates[$tmpName];
    }

    $notificationMail = Doctrine::getTable('NotificationMail')
      ->createQuery()
      ->where('name = ?', $tmpName)
      ->fetchOne();

    if ($notificationMail)
    {
      self::$mailTemplates[$tmpName] = $notificationMail->Translation[$lang]->template;

      return self::$mailTemplates[$tmpName];
    }

    $mailTemplateConfig = include(sfContext::getInstance()->getConfigCache()->checkConfig('config/mail_template.yml'));
    $config = isset($mailTemplateConfig[$env][$templateName]) ? $mailTemplateConfig[$env][$templateName] : null;
    $sample = isset($config['sample'][$lang]) ? $config['sample'][$lang] : null;
    if (is_array($sample) && count($sample) >= 2)
    {
      return self::$mailTemplates[$tmpName] = $sample[1];
    }
    else if ($sample)
    {
      return self::$mailTemplates[$tmpName] = $sample;
    }

    throw new LogicException(sprintf("Not found template: %s", $templateName));
  }
}
