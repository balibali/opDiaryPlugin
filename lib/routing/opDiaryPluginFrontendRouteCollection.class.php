<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opDiaryPluginFrontendRouteCollection
 *
 * @package    opDiaryPlugin
 * @subpackage routing
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class opDiaryPluginFrontendRouteCollection extends opDiaryPluginBaseRouteCollection
{
  protected function generateRoutes()
  {
    return array(
      'diary_index' => new sfRoute(
        '/diary',
        array('module' => 'diary', 'action' => 'index')
      ),

      'diary_search' => new sfRoute(
        '/diary/search',
        array('module' => 'diary', 'action' => 'search'),
        array(),
        array('extra_parameters_as_query_string' => true)
      ),
      'diary_list' => new sfRoute(
        '/diary/list',
        array('module' => 'diary', 'action' => 'list'),
        array(),
        array('extra_parameters_as_query_string' => true)
      ),
      'diary_list_member_year_month_day' => new sfDoctrineRoute(
        '/diary/listMember/:id/:year/:month/:day',
        array('module' => 'diary', 'action' => 'listMember'),
        array('id' => '\d+', 'year' => '[12][0-9]{3}', 'month' => '(0?[1-9])|(1[0-2])', 'day' => '(0?[1-9])|([12][0-9])|(3[01])'),
        array('model' => 'Member', 'type' => 'object'),
        array('extra_parameters_as_query_string' => true)
      ),
      'diary_list_member_year_month' => new sfDoctrineRoute(
        '/diary/listMember/:id/:year/:month',
        array('module' => 'diary', 'action' => 'listMember'),
        array('id' => '\d+', 'year' => '[12][0-9]{3}', 'month' => '(0?[1-9])|(1[0-2])'),
        array('model' => 'Member', 'type' => 'object'),
        array('extra_parameters_as_query_string' => true)
      ),
      'diary_list_member' => new sfDoctrineRoute(
        '/diary/listMember/:id',
        array('module' => 'diary', 'action' => 'listMember'),
        array('id' => '\d+'),
        array('model' => 'Member', 'type' => 'object'),
        array('extra_parameters_as_query_string' => true)
      ),
      'diary_list_mine' => new sfRoute(
        '/diary/listMember',
        array('module' => 'diary', 'action' => 'listMember'),
        array(),
        array('extra_parameters_as_query_string' => true)
      ),
      'diary_list_friend' => new sfRoute(
        '/diary/listFriend',
        array('module' => 'diary', 'action' => 'listFriend'),
        array(),
        array('extra_parameters_as_query_string' => true)
      ),
      'diary_show' => new sfDoctrineRoute(
        '/diary/:id',
        array('module' => 'diary', 'action' => 'show'),
        array('id' => '\d+'),
        array('model' => 'Diary', 'type' => 'object')
      ),
      'diary_comment_history' => new sfRoute(
        '/diary/comment/history',
        array('module' => 'diaryComment', 'action' => 'history'),
        array(),
        array('extra_parameters_as_query_string' => true)
      ),

      'diary_new' => new sfRoute(
        '/diary/new',
        array('module' => 'diary', 'action' => 'new')
      ),
      'diary_create' => new sfRequestRoute(
        '/diary/create',
        array('module' => 'diary', 'action' => 'create'),
        array('sf_method' => array('post'))
      ),
      'diary_edit' => new sfDoctrineRoute(
        '/diary/edit/:id',
        array('module' => 'diary', 'action' => 'edit'),
        array('id' => '\d+'),
        array('model' => 'Diary', 'type' => 'object')
      ),
      'diary_update' => new sfDoctrineRoute(
        '/diary/update/:id',
        array('module' => 'diary', 'action' => 'update'),
        array('id' => '\d+', 'sf_method' => array('post')),
        array('model' => 'Diary', 'type' => 'object')
      ),
      'diary_delete_confirm' => new sfDoctrineRoute(
        '/diary/deleteConfirm/:id',
        array('module' => 'diary', 'action' => 'deleteConfirm'),
        array('id' => '\d+'),
        array('model' => 'Diary', 'type' => 'object')
      ),
      'diary_delete' => new sfDoctrineRoute(
        '/diary/delete/:id',
        array('module' => 'diary', 'action' => 'delete'),
        array('id' => '\d+', 'sf_method' => array('post')),
        array('model' => 'Diary', 'type' => 'object')
      ),

      'diary_comment_create' => new sfDoctrineRoute(
        '/diary/:id/comment/create',
        array('module' => 'diaryComment', 'action' => 'create'),
        array('id' => '\d+', 'sf_method' => array('post')),
        array('model' => 'Diary', 'type' => 'object')
      ),
      'diary_comment_delete_confirm' => new sfDoctrineRoute(
        '/diary/comment/deleteConfirm/:id',
        array('module' => 'diaryComment', 'action' => 'deleteConfirm'),
        array('id' => '\d+'),
        array('model' => 'DiaryComment', 'type' => 'object')
      ),
      'diary_comment_delete' => new sfDoctrineRoute(
        '/diary/comment/delete/:id',
        array('module' => 'diaryComment', 'action' => 'delete'),
        array('id' => '\d+', 'sf_method' => array('post')),
        array('model' => 'DiaryComment', 'type' => 'object')
      ),
    );
  }
}
