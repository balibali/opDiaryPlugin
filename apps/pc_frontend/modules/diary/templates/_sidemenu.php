<?php use_helper('opDiary') ?>

<div class="parts memberImageBox">
<p class="photo"><?php echo link_to(image_tag_sf_image($member->getImageFileName(), array('size' => '120x120')), '@obj_member_profile?id='.$member->id) ?></p>
<p class="text"><?php echo $member->name ?></p>
</div>

<div class="parts calendar">
<div class="partsHeading"><h3>
<?php if ($_m = $calendar->prevMonth('array')): ?>
  <?php echo link_to('&lt;&lt;', '@diary_list_member_year_month?id='.$member->id.'&year='.$_m['year'].'&month='.$_m['month']) ?>
<?php endif; ?>
  <?php $_m = $calendar->thisMonth('array'); echo op_format_date(sprintf('%04d-%02d-01', $_m['year'], $_m['month']), 'XCalendarMonth') ?>
<?php if ($_m = $calendar->nextMonth('array')): ?>
  <?php echo link_to('&gt;&gt;', '@diary_list_member_year_month?id='.$member->id.'&year='.$_m['year'].'&month='.$_m['month']) ?>
<?php endif; ?>
</h3></div>
<table class="calendar"><tbody>
<tr>
<th class="sun"><?php echo format_date('Sun', 'EE') ?></th>
<th class="mon"><?php echo format_date('Mon', 'EE') ?></th>
<th class="tue"><?php echo format_date('Tue', 'EE') ?></th>
<th class="wed"><?php echo format_date('Wed', 'EE') ?></th>
<th class="thu"><?php echo format_date('Thu', 'EE') ?></th>
<th class="fri"><?php echo format_date('Fri', 'EE') ?></th>
<th class="sat"><?php echo format_date('Sat', 'EE') ?></th>
</tr>
<?php
while ($day = $calendar->fetch())
{
  if ($day->isFirst())
  {
    echo '<tr>';
  }

  echo '<td>';
  if (!$day->isEmpty())
  {
    if (!empty($calendarDiaryDays[$day->thisDay()]))
    {
      echo link_to($day->thisDay(), '@diary_list_member_year_month_day?id='.$member->id.'&year='.$year.'&month='.$month.'&day='.$day->thisDay());
    }
    else
    {
      echo $day->thisDay();
    }
  }
  echo '</td>';

  if ($day->isLast())
  {
    echo '</tr>';
  }
}
?>
</tbody></table>
</div>

<?php if (count($recentDiaryList)): ?>
<div class="parts pageNav">
<div class="partsHeading"><h3><?php echo __('Recently Posted Diaries') ?></h3></div>
<ul>
<?php foreach ($recentDiaryList as $_diary): ?>
<li><?php echo link_to(op_diary_get_title_and_count($_diary), 'diary_show', $_diary) ?></li>
<?php endforeach; ?>
</ul>
</div>
<?php endif; ?>
