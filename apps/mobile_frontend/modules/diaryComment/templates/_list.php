<?php use_helper('opDiary') ?>

<?php if ($pager->getNbResults()): ?>
<hr>
<center>
<?php echo __('Comments') ?><br>
<?php echo __('No. %1% - %2%', array('%1%' => $pager->getFirstItem()->getNumber(), '%2%' => $pager->getLastItem()->getNumber())) ?><br>
</center>

<?php foreach ($pager->getResults() as $comment): ?>
<hr>
<?php echo op_within_page_link() ?>
[<?php printf('%03d', $comment->number) ?>]<?php echo op_format_date($comment->created_at, 'XDateTime') ?>
<?php if ($diary->member_id === $sf_user->getMemberId() || $comment->member_id === $sf_user->getMemberId()): ?>
[<?php echo link_to(__('Delete'), 'diary_comment_delete_confirm', $comment) ?>]
<?php endif; ?><br>
<?php echo link_to($comment->Member->name, 'member/profile?id='.$comment->member_id) ?><br>
<?php echo nl2br($comment->body) ?><br>
<?php if ($comment->has_images): ?>
<?php foreach ($comment->getDiaryCommentImagesJoinFile() as $image): ?>
<?php echo link_to(__('View Image'), sf_image_path($image->File, array('size' => '240x320', 'f' => 'jpg'))) ?><br>
<?php endforeach; ?>
<?php endif; ?>
<?php endforeach; ?>

<?php if ($pager->haveToPaginate()): ?>
<hr>
<center>
<?php if ($pager->hasOlderPage()): ?><?php echo link_to(__('Older'), '@diary_show?id='.$diary->id.'&page='.$pager->getOlderPage().'&order='.$order) ?><?php endif; ?>
<?php if ($pager->hasNewerPage()): ?> <?php echo link_to(__('Newer'), '@diary_show?id='.$diary->id.'&page='.$pager->getNewerPage().'&order='.$order) ?><?php endif; ?>
<br>
<?php if (sfReversibleDoctrinePager::ASC === $order): ?>
  <?php echo link_to(__('View Latest'), '@diary_show?id='.$diary->id) ?>
<?php else: ?>
  <?php echo link_to(__('View Oldest First'), '@diary_show?id='.$diary->id.'&order='.sfReversibleDoctrinePager::ASC) ?>
<?php endif; ?>
</center>
<?php endif; ?>
<?php endif; ?>
