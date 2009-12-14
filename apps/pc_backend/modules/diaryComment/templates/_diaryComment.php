<tr><th><?php echo __('ID') ?></th><td><?php echo $diaryComment->id ?></td></tr>
<tr><th><?php echo __('Diary') ?></th><td><?php echo $diaryComment->Diary->title ?> (<?php echo __('ID') ?>: <?php echo $diaryComment->diary_id ?>)</td></tr>
<tr><th><?php echo __('Author') ?></th><td><?php echo $diaryComment->Member->name ?></td></tr>
<tr><th><?php echo __('Created at') ?></th><td><?php echo op_format_date($diaryComment->created_at, 'XDateTimeJa') ?></td></tr>
<tr><th><?php echo __('Body') ?></th><td><?php echo nl2br($diaryComment->body) ?></td></tr>
