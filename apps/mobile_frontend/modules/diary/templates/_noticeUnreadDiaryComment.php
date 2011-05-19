<?php if ($count): ?>
<font color="#FF0000"><?php echo format_number_choice('[1]1 diary has new comments!|(1,Inf]%1% diaries have new comments!', array('%1%' => $count), $count) ?></font>
<?php echo link_to(__('Read diary'), '@diary_show?id='.$diary->id) ?><br>
<?php endif; ?>
