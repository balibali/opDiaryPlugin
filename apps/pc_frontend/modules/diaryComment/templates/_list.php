<?php use_helper('opDiary') ?>

<?php if ($pager->getNbResults()): ?>
<?php /* {{{ commentList */ ?>
<div class="dparts commentList"><div class="parts">
<div class="partsHeading"><h3><?php echo __('Comments') ?></h3></div>

<?php if (min($sf_data->getRaw('sizes')) < $pager->getNbResults()): ?>
<div class="pagerRelative">
<?php foreach ($sizes as $n): ?>
  <?php if ($n !== $size): ?>
    <?php echo link_to(__('View %1% per page', array('%1%' => $n)), '@diary_show?id='.$diary->id.'&size='.$n.'&order='.$order) ?>
  <?php endif; ?>
<?php endforeach; ?>
<?php if ($pager->haveToPaginate()): ?>
  <?php if (sfReversibleDoctrinePager::ASC === $order): ?>
    <?php echo link_to(__('View Latest'), '@diary_show?id='.$diary->id.'&size='.$size) ?>
  <?php else: ?>
    <?php echo link_to(__('View Oldest First'), '@diary_show?id='.$diary->id.'&size='.$size.'&order='.sfReversibleDoctrinePager::ASC) ?>
  <?php endif; ?>
<?php endif; ?>
</div>
<?php endif; ?>

<?php if ($pager->haveToPaginate()): ?>
<div class="pagerRelative">
  <?php if ($pager->hasOlderPage()): ?><p class="prev"><?php echo link_to(__('Older'), '@diary_show?id='.$diary->id.'&page='.$pager->getOlderPage().'&size='.$size.'&order='.$order) ?></p><?php endif; ?>
  <p class="number"><?php echo __('No. %1% - %2%', array('%1%' => $pager->getFirstItem()->getNumber(), '%2%' => $pager->getLastItem()->getNumber())) ?></p>
  <?php if ($pager->hasNewerPage()): ?><p class="next"><?php echo link_to(__('Newer'), '@diary_show?id='.$diary->id.'&page='.$pager->getNewerPage().'&size='.$size.'&order='.$order) ?></p><?php endif; ?>
</div>
<?php endif; ?>

<?php foreach ($pager->getResults() as $comment): ?>
<dl>
<dt><?php echo nl2br(op_format_date($comment->created_at, 'XDateTimeJaBr')) ?></dt>
<dd>
<div class="title">
<p class="heading"><strong><?php echo $comment->number ?></strong>:
<?php if ($_member = $comment->Member): ?> <?php echo link_to($_member->name, '@obj_member_profile?id='.$_member->id) ?><?php endif; ?>
<?php if ($diary->member_id === $sf_user->getMemberId() || $comment->member_id === $sf_user->getMemberId()): ?>
 <?php echo link_to(__('Delete'), 'diary_comment_delete_confirm', $comment) ?>
<?php endif; ?>
</p>
</div>
<div class="body">
<?php if ($comment->has_images): ?>
<?php $images = $comment->getDiaryCommentImagesJoinFile() ?>
<ul class="photo">
<?php foreach ($images as $image): ?>
<li><a href="<?php echo sf_image_path($image->File) ?>" target="_blank"><?php echo image_tag_sf_image($image->File, array('size' => '120x120')) ?></a></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
<p class="text">
<?php echo op_url_cmd(nl2br($comment->body)) ?>
</p>
</div>
</dd>
</dl>
<?php endforeach; ?>
</div></div>
<?php /* }}} */ ?>
<?php endif; ?>
