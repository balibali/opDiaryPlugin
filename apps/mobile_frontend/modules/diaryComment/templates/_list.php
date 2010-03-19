<?php use_helper('opDiary') ?>

<?php if ($pager->getNbResults()): ?>
<hr color="<?php echo $op_color["core_color_11"] ?>">
<center>
<?php echo __('Comments') ?><br>
<?php echo __('No. %1% - %2%', array('%1%' => $pager->getFirstItem()->getNumber(), '%2%' => $pager->getLastItem()->getNumber())) ?><br>
</center>

<?php
foreach ($pager->getResults() as $comment)
{
  $list[] = get_partial('diaryComment/comment', array('comment' => $comment, 'diary' => $diary));
}

op_include_list('commentList', $list, array('border' => true));
?>

<?php if ($pager->haveToPaginate()): ?>
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
