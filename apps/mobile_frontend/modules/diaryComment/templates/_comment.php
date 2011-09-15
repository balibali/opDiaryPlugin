<?php echo op_within_page_link() ?>
[<?php printf('%03d', $comment->number) ?>]<?php echo op_format_date($comment->created_at, 'XDateTime') ?>
<?php if ($diary->member_id === $sf_user->getMemberId() || $comment->member_id === $sf_user->getMemberId()): ?>
[<?php echo link_to(__('Delete'), 'diary_comment_delete_confirm', $comment) ?>]
<?php endif; ?><br>
<?php echo op_link_to_member($comment->Member); ?><br>
<?php echo op_auto_link_text_for_mobile(nl2br($comment->body)) ?><br>
<?php if ($comment->has_images): ?>
<?php foreach ($comment->getDiaryCommentImagesJoinFile() as $image): ?>
<?php echo link_to(__('View Image'), sf_image_path($image->File, array('size' => '240x320', 'f' => 'jpg'))) ?><br>
<?php endforeach; ?>
<?php endif; ?>
