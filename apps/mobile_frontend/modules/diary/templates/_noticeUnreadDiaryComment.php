<?php if ($count): ?>
<font color="red"><?php echo format_number_choice('[1]1 diary has new comments|(1,Inf]%1% diaries have new comments', array('%1%' => $count), $count) ?>
&nbsp;
<?php echo link_to(__('Read comment'), '@diary_show?id='.$diary->id) ?><br>
</font>
<?php endif; ?>
