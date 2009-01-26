<?php use_helper('opDiary') ?>

<?php if ($pager->getNbResults()): ?>
<hr>
<center>
<?php echo __('Comments') ?><br>
<?php echo __('No. %1% - %2%', array('%1%' => $pager->getFirstItem()->getNumber(), '%2%' => $pager->getLastItem()->getNumber())) ?><br>
</center>

<?php foreach ($pager->getResults() as $comment): ?>
<hr>
<?php echo op_diary_within_page_link() ?>
[<?php printf('%03d', $comment->getNumber()) ?>]<?php echo op_format_date($comment->getCreatedAt(), 'XDateTime') ?>
<?php if ($diary->getMemberId() === $sf_user->getMemberId() || $comment->getMemberId() === $sf_user->getMemberId()): ?>
[<?php echo link_to(__('Delete'), 'diary_comment_delete_confirm', $comment) ?>]
<?php endif; ?><br>
<?php echo link_to($comment->getMember()->getName(), 'member/profile?id='.$comment->getMemberId()) ?><br>
<?php echo nl2br($comment->getBody()) ?><br>
<?php foreach ($comment->getDiaryCommentImages() as $image): ?>
<?php echo link_to(__('View Image'), sf_image_path($image->getFile(), array('size' => '240x320', 'f' => 'jpg'))) ?><br>
<?php endforeach; ?>
<?php endforeach; ?>

<?php if ($pager->haveToPaginate()): ?>
<hr>
<center>
<?php if ($pager->hasOlderPage()): ?><?php echo link_to(__('Older'), '@diary_show?id='.$diary->getId().'&page='.$pager->getOlderPage().'&order='.$order) ?><?php endif; ?>
<?php if ($pager->hasNewerPage()): ?> <?php echo link_to(__('Newer'), '@diary_show?id='.$diary->getId().'&page='.$pager->getNewerPage().'&order='.$order) ?><?php endif; ?>
<br>
<?php if (Criteria::ASC === $order): ?>
  <?php echo link_to(__('View Latest'), '@diary_show?id='.$diary->getId()) ?>
<?php else: ?>
  <?php echo link_to(__('View Oldest First'), '@diary_show?id='.$diary->getId().'&order='.Criteria::ASC) ?>
<?php endif; ?>
</center>
<?php endif; ?>
<?php endif; ?>
