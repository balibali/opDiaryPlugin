<?php use_helper('opDiary') ?>

<div class="parts item calendar">
<div class="partsHeading"><h3>
<?php if ($_m = $calendar->prevMonth('array')): ?>
  <?php echo link_to('&lt;&lt;', '@diary_list_member_year_month?id='.$member->getId().'&year='.$_m['year'].'&month='.$_m['month']) ?>
<?php endif; ?>
  <?php $_m = $calendar->thisMonth('array'); echo op_diary_format_date(sprintf('%04d-%02d-01', $_m['year'], $_m['month']), 'XCalendarMonth') ?>
<?php if ($_m = $calendar->nextMonth('array')): ?>
  <?php echo link_to('&gt;&gt;', '@diary_list_member_year_month?id='.$member->getId().'&year='.$_m['year'].'&month='.$_m['month']) ?>
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
      echo link_to($day->thisDay(), '@diary_list_member_year_month_day?id='.$member->getId().'&year='.$year.'&month='.$month.'&day='.$day->thisDay());
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
