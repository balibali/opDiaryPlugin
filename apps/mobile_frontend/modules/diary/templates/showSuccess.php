<?php include_page_title(__('Diary of %1%', array('%1%' => $diary->getMember()->getName())), $diary->getTitle()) ?>
<?php use_helper('Date') ?>

▼<?php echo format_datetime($diary->getCreatedAt(), 'f') ?>
<?php if ($diary->getMember()->getId() === $sf_user->getMemberId()): ?>
[<?php echo link_to(__('Edit'), 'diary/edit?id='.$diary->getId()) ?>][<?php echo link_to(__('Delete'), 'diary/delete?id='.$diary->getId()) ?>]
<?php endif; ?><br>

<?php echo nl2br($diary->getBody()) ?><br>

<?php foreach ($diary->getDiaryImages() as $image): ?>
View Image<br>
<?php endforeach; ?>

(<?php echo __('Public') ?>)<br>
