<?php use_helper('opDiary') ?>

<?php if ($pager->getNbResults()): ?>
<hr>
<center>
<?php echo __('Comments') ?><br>
<?php echo __('%1%番～%2%番を表示', array('%1%' => $pager->getFirstItem()->getNumber(), '%2%' => $pager->getLastItem()->getNumber())) ?><br>
</center>

<?php foreach ($pager->getResults() as $comment): ?>
<hr>
▼[<?php printf('%03d', $comment->getNumber()) ?>]<?php echo op_diary_format_date($comment->getCreatedAt(), 'XDateTime') ?>
<?php if ($diary->getMemberId() === $sf_user->getMemberId() || $comment->getMemberId() === $sf_user->getMemberId()): ?>
[<?php echo link_to(__('Delete'), 'diary_comment_delete_confirm', $comment) ?>]
<?php endif; ?><br>
<?php echo link_to($comment->getMember()->getName(), 'member/show?id='.$comment->getMemberId()) ?><br>
<?php echo nl2br($comment->getBody()) ?><br>
<?php foreach ($comment->getDiaryCommentImages() as $image): ?>
<?php echo link_to(__('View Image'), sf_image_path($image->getFile(), array('size' => '240x320', 'f' => 'jpg'))) ?><br>
<?php endforeach; ?>
<?php endforeach; ?>

<?php if ($pager->haveToPaginate()): ?>
<hr>
<center>
<?php if ($pager->hasEarlierPage()): ?><?php echo link_to('前を表示', '@diary_show?id='.$diary->getId().'&page='.$pager->getEarlierPage()) ?><?php endif; ?>
<?php if ($pager->hasLaterPage()): ?> <?php echo link_to('次を表示', '@diary_show?id='.$diary->getId().'&page='.$pager->getLaterPage()) ?><?php endif; ?>
</center>
<?php endif; ?>
<?php endif; ?>
