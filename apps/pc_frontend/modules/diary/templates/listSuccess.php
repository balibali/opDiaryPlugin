<?php use_helper('Date'); ?>

<div class="dparts searchResultList"><div class="parts">
<div class="partsHeading"><h3><?php echo __('Recently Posted Diaries') ?></h3></div>
<?php if ($pager->getNbResults()): ?>
<div class="pagerRelative"><p class="number"><?php echo pager_navigation($pager, 'diary/list?page=%d'); ?></p></div>
<div class="block">
<?php foreach ($pager->getResults() as $diary): ?>
<div class="ditem"><div class="item"><table><tbody><tr>
<td rowspan="4" class="photo"><a href="<?php echo url_for('diary_show', $diary) ?>"><?php echo image_tag_sf_image($diary->getMember()->getImageFilename(), array('size' => '76x76')) ?></a></td>
<th><?php echo __('Nickname') ?></th><td><?php echo $diary->getMember()->getName() ?></td>
</tr><tr>
<th><?php echo __('Title') ?></th><td><?php echo $diary->getTitle() ?></td>
</tr><tr>
<th><?php echo __('Body') ?></th><td><?php echo $diary->getBody() ?></td>
</tr><tr class="operation">
<th><?php echo __('Created at') ?></th><td><span class="text"><?php echo format_datetime($diary->getCreatedAt(), 'f') ?></span> <span class="moreInfo"><?php echo link_to(__('View this diary'), 'diary_show', $diary) ?></span></td>
</tr></tbody></table></div></div>
<?php endforeach; ?>
</div>
<div class="pagerRelative"><p class="number"><?php echo pager_navigation($pager, 'diary/list?page=%d'); ?></p></div>
<?php else: ?>
<div class="body">
<?php echo __('There are no diaries') ?>
</div>
<?php endif; ?>
</div></div>
