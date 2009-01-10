<?php if ($count): ?>
<?php echo link_to(__('%1%件の日記に新着コメントがあります。', array('%1%' => $count)), 'diary_show', $diary) ?>
<?php endif; ?>
