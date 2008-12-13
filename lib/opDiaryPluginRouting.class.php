<?php

/**
 * Diary routing.
 *
 * @package    OpenPNE
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class opDiaryPluginRouting
{
  static public function listenToRoutingLoadConfigurationEvent(sfEvent $event)
  {
    $routing = $event->getSubject();
    $routing->prependRoute('diary_by_id',
      new sfRoute(
        '/diary/:id',
        array('module' => 'diary', 'action' => 'show'),
        array('id' => '\d+')
      )
    );
  }
}
