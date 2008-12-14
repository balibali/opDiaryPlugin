<?php use_helper('Pagination', 'Date'); ?>

<div class="dparts searchResultList"><div class="parts">
<div class="partsHeading"><h3>最新日記</h3></div>
<?php if ($pager->getNbResults()): ?>
<div class="pagerRelative"><p class="number"><?php echo pager_navigation($pager, 'diary/list?page=%d'); ?></p></div>
<div class="block">
<?php foreach ($pager->getResults() as $diary): ?>
<div class="ditem"><div class="item"><table><tbody><tr>
<td rowspan="4" class="photo"><?php echo image_tag_sf_image($diary->getMember()->getImage(), array('size' => '76x76')) ?></td>
<th>ニックネーム</th><td><?php echo $diary->getMember()->getName() ?></td>
</tr><tr>
<th>タイトル</th><td><?php echo $diary->getTitle() ?></td>
</tr><tr>
<th>本文</th><td><?php echo $diary->getBody() ?></td>
</tr><tr class="operation">
<th>作成日時</th><td><span class="text"><?php echo format_datetime($diary->getCreatedAt(), 'f') ?></span> <span class="moreInfo"><?php echo link_to('詳細を見る', '@diary_by_id?id='.$diary->getId()) ?></span></td>
</tr></tbody></table></div></div>
<?php endforeach; ?>
</div>
<div class="pagerRelative"><p class="number"><?php echo pager_navigation($pager, 'diary/list?page=%d'); ?></p></div>
<?php else: ?>
<div class="body">
日記はまだありません
</div>
<?php endif; ?>
</div></div>

<?php echo link_to('日記を作成する', 'diary/edit') ?>
