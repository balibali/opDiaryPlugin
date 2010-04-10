<?php if ($count): ?>
<?php echo link_to(format_number_choice('[1]1 diary has new comments!|(1,Inf]%1% diaries have new comments!', array('%1%' => $count), $count), '@diary_show?id='.$diary->id) ?><br>
<?php endif; ?>
