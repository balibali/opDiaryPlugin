<?php use_helper('opDiary') ?>

<?php if ($pager->getNbResults()): ?>
<?php /* {{{ commentList */ ?>
<div class="dparts commentList"><div class="parts">
<div class="partsHeading"><h3><?php echo __('Comments') ?></h3></div>

<?php if (min($sf_data->getRaw('sizes')) < $pager->getNbResults()): ?>
<div class="pagerRelative">
<?php foreach ($sizes as $n): ?>
  <?php if ($n !== $size): ?>
    <?php echo link_to(__('%1%件ずつ表示', array('%1%' => $n)), '@diary_show?id='.$diary->getId().'&size='.$n.'&order='.$order) ?>
  <?php endif; ?>
<?php endforeach; ?>
<?php if ($pager->haveToPaginate()): ?>
  <?php if (Criteria::ASC === $order): ?>
    <?php echo link_to(__('最新を表示'), '@diary_show?id='.$diary->getId().'&size='.$size) ?>
  <?php else: ?>
    <?php echo link_to(__('最初から表示'), '@diary_show?id='.$diary->getId().'&size='.$size.'&order='.Criteria::ASC) ?>
  <?php endif; ?>
<?php endif; ?>
</div>
<?php endif; ?>

<?php if ($pager->haveToPaginate()): ?>
<div class="pagerRelative">
<?php if ($pager->hasEarlierPage()): ?><p class="prev"><?php echo link_to('前を表示', '@diary_show?id='.$diary->getId().'&page='.$pager->getEarlierPage().'&size='.$size.'&order='.$order) ?></p><?php endif; ?>
<p class="number"><?php echo __('%1%番～%2%番を表示', array('%1%' => $pager->getFirstItem()->getNumber(), '%2%' => $pager->getLastItem()->getNumber())) ?></p>
<?php if ($pager->hasLaterPage()): ?><p class="next"><?php echo link_to('次を表示', '@diary_show?id='.$diary->getId().'&page='.$pager->getLaterPage().'&size='.$size.'&order='.$order) ?></p><?php endif; ?>
</div>
<?php endif; ?>

<?php foreach ($pager->getResults() as $comment): ?>
<dl>
<dt><?php echo nl2br(op_diary_format_date($comment->getCreatedAt(), 'XDateTimeJaBr')) ?></dt>
<dd>
<div class="title">
<p class="heading"><strong><?php echo $comment->getNumber() ?></strong>:
<?php if ($_member = $comment->getMember()): ?> <?php echo link_to($_member->getName(), 'member/profile?id='.$_member->getId()) ?><?php endif; ?>
<?php if ($diary->getMemberId() === $sf_user->getMemberId() || $comment->getMemberId() === $sf_user->getMemberId()): ?>
 <?php echo link_to(__('Delete'), 'diary_comment_delete_confirm', $comment) ?>
<?php endif; ?>
</p>
</div>
<div class="body">
<?php $images = $comment->getDiaryCommentImages() ?>
<?php if (count($images)): ?>
<ul class="photo">
<?php foreach ($images as $image): ?>
<li><a href="<?php echo sf_image_path($image->getFile()) ?>" target="_blank"><?php echo image_tag_sf_image($image->getFile(), array('size' => '120x120')) ?></a></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
<p class="text">
<?php echo auto_link_text(nl2br($comment->getBody()), 'urls', array('target' => '_blank'), true, 57) ?>
</p>
</div>
</dd>
</dl>
<?php endforeach; ?>
</div></div>
<?php /* }}} */ ?>
<?php endif; ?>
