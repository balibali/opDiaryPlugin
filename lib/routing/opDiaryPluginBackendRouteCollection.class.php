<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opDiaryPluginBackendRouteCollection
 *
 * @package    opDiaryPlugin
 * @subpackage routing
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class opDiaryPluginBackendRouteCollection extends opDiaryPluginBaseRouteCollection
{
  protected function generateRoutes()
  {
    return array(
      'opDiaryPlugin' => new sfRoute(
        '/opDiaryPlugin',
        array('module' => 'opDiaryPlugin', 'action' => 'index')
      ),

      'monitoring_diary' => new sfRoute(
        '/monitoring/diary',
        array('module' => 'diary', 'action' => 'list'),
        array(),
        array('extra_parameters_as_query_string' => true)
      ),
      'monitoring_diary_search' => new sfRoute(
        '/monitoring/diary/search',
        array('module' => 'diary', 'action' => 'search'),
        array(),
        array('extra_parameters_as_query_string' => true)
      ),

      'monitoring_diary_comment' => new sfRoute(
        '/monitoring/diary/comment',
        array('module' => 'diaryComment', 'action' => 'list'),
        array(),
        array('extra_parameters_as_query_string' => true)
      ),
      'monitoring_diary_comment_search' => new sfRoute(
        '/monitoring/diary/comment/search',
        array('module' => 'diaryComment', 'action' => 'search'),
        array(),
        array('extra_parameters_as_query_string' => true)
      ),

      'monitoring_diary_delete_confirm' => new sfDoctrineRoute(
        '/monitoring/diary/deleteConfirm/:id',
        array('module' => 'diary', 'action' => 'deleteConfirm'),
        array('id' => '\d+'),
        array('model' => 'Diary', 'type' => 'object')
      ),
      'monitoring_diary_delete' => new sfDoctrineRoute(
        '/monitoring/diary/delete/:id',
        array('module' => 'diary', 'action' => 'delete'),
        array('id' => '\d+', 'sf_method' => array('post')),
        array('model' => 'Diary', 'type' => 'object')
      ),

      'monitoring_diary_comment_delete_confirm' => new sfDoctrineRoute(
        '/monitoring/diary/comment/deleteConfirm/:id',
        array('module' => 'diaryComment', 'action' => 'deleteConfirm'),
        array('id' => '\d+'),
        array('model' => 'DiaryComment', 'type' => 'object')
      ),
      'monitoring_diary_comment_delete' => new sfDoctrineRoute(
        '/monitoring/diary/comment/delete/:id',
        array('module' => 'diaryComment', 'action' => 'delete'),
        array('id' => '\d+', 'sf_method' => array('post')),
        array('model' => 'DiaryComment', 'type' => 'object')
      ),
    );
  }
}
