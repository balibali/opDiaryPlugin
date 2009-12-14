<tr><th><?php echo __('ID') ?></th><td><?php echo $diary->id ?></td></tr>
<tr><th><?php echo __('Title') ?></th><td><?php echo $diary->title ?></td></tr>
<tr><th><?php echo __('Author') ?></th><td><?php echo $diary->Member->name ?></td></tr>
<tr><th><?php echo __('Created at') ?></th><td><?php echo op_format_date($diary->created_at, 'XDateTimeJa') ?></td></tr>
<tr><th><?php echo __('Body') ?></th><td><?php echo nl2br($diary->body) ?></td></tr>
