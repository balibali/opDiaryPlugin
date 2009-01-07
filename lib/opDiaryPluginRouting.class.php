<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

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

    $routes = array(
      'diary_index' => new sfRoute(
        '/diary',
        array('module' => 'diary', 'action' => 'index')
      ),

      'diary_list' => new sfRoute(
        '/diary/list',
        array('module' => 'diary', 'action' => 'list')
      ),
      'diary_list_member' => new sfPropelRoute(
        '/diary/listMember/:id',
        array('module' => 'diary', 'action' => 'listMember'),
        array('id' => '\d+'),
        array('model' => 'Member', 'type' => 'object')
      ),
      'diary_list_friend' => new sfRoute(
        '/diary/listFriend',
        array('module' => 'diary', 'action' => 'listFriend')
      ),
      'diary_show' => new sfPropelRoute(
        '/diary/:id',
        array('module' => 'diary', 'action' => 'show'),
        array('id' => '\d+'),
        array('model' => 'Diary', 'type' => 'object')
      ),

      'diary_new' => new sfRoute(
        '/diary/new',
        array('module' => 'diary', 'action' => 'new')
      ),
      'diary_create' => new sfRoute(
        '/diary/create',
        array('module' => 'diary', 'action' => 'create'),
        array('sf_method' => array('post'))
      ),
      'diary_edit' => new sfPropelRoute(
        '/diary/edit/:id',
        array('module' => 'diary', 'action' => 'edit'),
        array('id' => '\d+'),
        array('model' => 'Diary', 'type' => 'object')
      ),
      'diary_update' => new sfPropelRoute(
        '/diary/update/:id',
        array('module' => 'diary', 'action' => 'update'),
        array('id' => '\d+', 'sf_method' => array('post')),
        array('model' => 'Diary', 'type' => 'object')
      ),
      'diary_delete_confirm' => new sfPropelRoute(
        '/diary/deleteConfirm/:id',
        array('module' => 'diary', 'action' => 'deleteConfirm'),
        array('id' => '\d+'),
        array('model' => 'Diary', 'type' => 'object')
      ),
      'diary_delete' => new sfPropelRoute(
        '/diary/delete/:id',
        array('module' => 'diary', 'action' => 'delete'),
        array('id' => '\d+', 'sf_method' => array('post')),
        array('model' => 'Diary', 'type' => 'object')
      ),

      'diary_comment_create' => new sfPropelRoute(
        '/diary/:id/comment/create',
        array('module' => 'diaryComment', 'action' => 'create'),
        array('id' => '\d+', 'sf_method' => array('post')),
        array('model' => 'Diary', 'type' => 'object')
      ),
      'diary_comment_delete_confirm' => new sfPropelRoute(
        '/diary/comment/deleteConfirm/:id',
        array('module' => 'diaryComment', 'action' => 'deleteConfirm'),
        array('id' => '\d+'),
        array('model' => 'DiaryComment', 'type' => 'object')
      ),
      'diary_comment_delete' => new sfPropelRoute(
        '/diary/comment/delete/:id',
        array('module' => 'diaryComment', 'action' => 'delete'),
        array('id' => '\d+', 'sf_method' => array('post')),
        array('model' => 'DiaryComment', 'type' => 'object')
      ),

      'diary_nodefaults' => new sfRoute(
        '/diary/*',
        array('module' => 'default', 'action' => 'error')
      ),
    );

    $routes = array_reverse($routes);
    foreach ($routes as $name => $route)
    {
      $routing->prependRoute($name, $route);
    }
  }
}
