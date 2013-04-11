<?php echo View::factory('application/notes', $notes)->render();?>

<h1 class="span16">Application Task</h1>
<div class="span16"><?php echo View::factory('application/app_edit_tabs', $tabs)->render(); ?></div>
<div class="clear"></div>

<?php
if ($task['type'] == 'todo') {
    $due_date = date('m/d/Y', strtotime($task['deadline']));
    $due_time = date('g:i a', strtotime($task['deadline']));
} else {
    $due_date = date('m/d/Y', strtotime($task['appointment']));
    $due_time = date('g:i a', strtotime($task['appointment']));
}
?>

<div class="span16" style="margin-bottom:10px;">
    <a href="/application/calendar/<?php echo URI::segment(3); ?>" class="btn small">Month Calendar</a>
    <a href="/application/calendar_week/<?php echo URI::segment(3); ?>" class="btn small">Week Calendar</a>
    <a href="/application/calendar_day/<?php echo URI::segment(3); ?>" class="btn small">Day Calendar</a>
</div>

<div class="span13">
    <table class="zebra-striped" cellpadding="0" cellspacing="0">
        <tr class="tablecollapse">
            <td colspan="2">
                <h2>File Task: <?php echo $task['title']; ?></h2>
            </td>
        </tr>
        <tr>
            <td style="width:50%">
                <div class="clearfix">Task Type: <?php echo ucwords($task['type']); ?></div>
                <div class="clearfix">Status: <?php echo ucwords($task['status']); ?></div></td>
            <td>
                <div class="clearfix">
                    Assigned To:
                    <?php
                    foreach($users as $u) {
                        if ($task['assignee'] == $u['id']) {
                            echo $u['first_name'].' '.$u['last_name'];
                        }
                    }
                    ?>
                </div>
                <div class="clearfix">
                    <?php if ($task['type'] == 'todo') { ?>
                    Deadline: <?php echo date('n/j/Y g:i a', strtotime($task['deadline'])); ?>
                    <?php } else { ?>
                    Appointment: <?php echo date('n/j/Y g:i a', strtotime($task['appointment'])); ?>
                    <?php } ?>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">Description: <?php echo nl2br($task['description']); ?></td>
        </tr>
        <tr id="appointment_row"<?php if ($task['type'] == 'todo') { echo ' style="display:none;"'; } ?>>
            <td>
                Appointment Priority:
                <?php
                if (!strlen($task['priority_status'])) {
                    echo 'None';
                } else {
                    echo $task['priority_status'];
                }
                ?>
            </td>
            <td>Appointment Duration: <?php echo $task['appointment_duration']; ?></td>
        </tr>
        <tr>
            <td>Shared with:<br/>
                <?php
                if (count($task['visibility']['users'])) {
                    foreach($users as $u) {
                        if (in_array($u['id'], $task['visibility']['users'])) {
                            echo $u['first_name'].' '.$u['last_name'].'<br/>';
                        }
                    }
                } else {
                    echo 'None';
                }
                ?>
            </td>
            <td>Shared Departments:<br/>
                <?php
                if (count($task['visibility']['roles'])) {
                    foreach($roles as $r) {
                        if (in_array($r['id'], $task['visibility']['roles'])) {
                            echo ucwords($r['label']).'<br/>';
                        }
                    }
                } else {
                    echo 'None';
                }
                ?>
            </td>
        </tr>
    </table>
</div>
<div class="span3">
    <a href="/application/task_add/<?php echo URI::segment(3); ?>" class="btn primary small" style="display:block;text-align:center;margin-bottom:10px;">Add Task</a>
    <?php if ($task['status'] != 'completed') { ?>
    <a href="/application/task_update/<?php echo URI::segment(3); ?>/<?php echo URI::segment(4); ?>" class="btn success small" style="display:block;text-align:center;margin-bottom:10px;">Update Task</a>
    <a href="/application/task_delete/<?php echo URI::segment(3); ?>/<?php echo URI::segment(4); ?>" class="btn danger small" style="display:block;text-align:center;margin-bottom:10px;">Delete Task</a>
    <?php } else { ?>
    <div class="alert-message block-message warning">This task has been completed and is available only for reference.</div>
    <?php } ?>
</div>