<?php echo View::factory('application/notes', $notes)->render();?>

<h1 class="span16">Application Task</h1>
<div class="span16"><?php echo View::factory('application/app_edit_tabs', $tabs)->render(); ?></div>
<div class="clear"></div>

<div class="span16" style="margin-bottom:10px;">
    <a href="/application/calendar/<?php echo URI::segment(3); ?>" class="btn small">Month Calendar</a>
    <a href="/application/calendar_week/<?php echo URI::segment(3); ?>" class="btn small">Week Calendar</a>
    <a href="/application/calendar_day/<?php echo URI::segment(3); ?>" class="btn small">Day Calendar</a>
</div>
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

<form action="/application/task_update/<?php echo Uri::segment(3); ?>/<?php echo Uri::segment(4); ?>" method="post" class="form-stacked">
    <fieldset>
        <table class="zebra-striped" cellpadding="0" cellspacing="0">
            <tr class="tablecollapse">
                <td colspan="2">
                    <h2>File Tasks</h2>
                </td>
            </tr>
            <tr>
                <td style="width:50%">
                    <div class="clearfix">
                        <label>Task Type:</label>
                        <div class="input">
                            <select id="task_type" name="type" class="span4">
                                <option value="todo"<?php if ($task['type'] == 'todo') { echo ' selected="selected"'; } ?>>Task</option>
                                <option value="appointment"<?php if ($task['type'] == 'appointment') { echo ' selected="selected"'; } ?>>Appointment</option>
                            </select>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="clearfix">
                        <label>Task Title:</label>
                        <div class="input">
                            <input type="text" class="span7" name="title" value="<?php echo $task['title']; ?>">
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="clearfix">
                        <label>Task Description:</label>
                        <div class="input">
                            <textarea name="description" class="span7" style="height:100px;"><?php echo $task['description']; ?></textarea>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="clearfix">
                        <label>Task Status:</label>
                        <div class="input">
                            <select name="status" class="span4">
                                <option value="working"<?php if ($task['status'] == 'working') { echo ' selected="selected"'; } ?>>Working</option>
                                <option value="suspended"<?php if ($task['status'] == 'suspended') { echo ' selected="selected"'; } ?>>Suspended</option>
                                <option value="completed"<?php if ($task['status'] == 'completed') { echo ' selected="selected"'; } ?>>Completed</option>
                            </select>
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Assign To:</label>
                        <div class="input">
                            <select name="assignee" class="span4">
                                <option value=""></option>
                                <?php
                                foreach($users as $u) {
                                    if ($u['role_id']) {
                                        echo '<option value="'.$u['id'].'"';
                                        if ($task['assignee'] == $u['id']) {
                                            echo ' selected="selected"';
                                        }
                                        echo '>'.$u['first_name'].' '.$u['last_name'].'</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="clearfix">
                        <label id="deadline_label">
                            <?php if ($task['type'] == 'todo') { ?>
                            Deadline Date and Time
                            <?php } else { ?>
                            Appointment Date and Time
                            <?php } ?>
                        </label>
                        <div class="input">
                            <input type="text" class="span5 datepicker" name="due_date" value="<?php echo $due_date; ?>">
                            <input id="due_time" type="text" class="span2" name="due_time" value="<?php echo $due_time; ?>">
                        </div>
                    </div>
                </td>
            </tr>
            <tr id="appointment_row"<?php if ($task['type'] == 'todo') { echo ' style="display:none;"'; } ?>>
                <td>
                    <div class="clearfix">
                        <label>Appointment Priority:</label>
                        <div class="input">
                            <select name="priority_status" class="span4">
                                <option value=""<?php if (!strlen($task['priority_status'])) { echo ' selected="selected"'; } ?>></option>
                                <option value="first_reschedule"<?php if ($task['priority_status'] == 'first_reschedule') { echo ' selected="selected"'; } ?>>First Reschedule</option>
                                <option value="second_reschedule"<?php if ($task['priority_status'] == 'second_reschedule') { echo ' selected="selected"'; } ?>>Second Reschedule</option>
                            </select>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="clearfix">
                        <label id="">Appointment Duration</label>
                        <div class="input">
                            <select name="appointment_duration" class="span4">
                                <option value="15 Minutes"<?php if ($task['appointment_duration'] == '15 Minutes') { echo ' selected="selected"'; } ?>>15 Minutes</option>
                                <option value="30 Minutes"<?php if ($task['appointment_duration'] == '30 Minutes') { echo ' selected="selected"'; } ?>>30 Minutes</option>
                                <option value="45 Minutes"<?php if ($task['appointment_duration'] == '45 Minutes') { echo ' selected="selected"'; } ?>>45 Minutes</option>
                                <option value="1 Hour"<?php if ($task['appointment_duration'] == '1 Hour') { echo ' selected="selected"'; } ?>>1 Hour</option>
                                <option value="1 Hour, 30 Minutes"<?php if ($task['appointment_duration'] == '1 Hour, 30 Minutes') { echo ' selected="selected"'; } ?>>1 Hour, 30 Minutes</option>
                                <option value="2 Hours"<?php if ($task['appointment_duration'] == '2 Hours') { echo ' selected="selected"'; } ?>>2 Hours</option>
                                <option value="3 Hours"<?php if ($task['appointment_duration'] == '3 Hours') { echo ' selected="selected"'; } ?>>3 Hours</option>
                                <option value="4 Hours"<?php if ($task['appointment_duration'] == '4 Hours') { echo ' selected="selected"'; } ?>>4 Hours</option>
                                <option value="5 Hours"<?php if ($task['appointment_duration'] == '5 Hours') { echo ' selected="selected"'; } ?>>5 Hours</option>
                                <option value="6 Hours"<?php if ($task['appointment_duration'] == '6 Hours') { echo ' selected="selected"'; } ?>>6 Hours</option>
                                <option value="7 Hours"<?php if ($task['appointment_duration'] == '7 Hours') { echo ' selected="selected"'; } ?>>7 Hours</option>
                                <option value="8 Hours"<?php if ($task['appointment_duration'] == '8 Hours') { echo ' selected="selected"'; } ?>>8 Hours</option>
                            </select>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="clearfix">
                        <label>Share Task with Users:</label>
                        <div class="input" style="height:125px;overflow-y:scroll;border:1px solid #ccc;background-color:#fff;padding:5px;">
                            <?php
                            foreach($users as $u) {
                                if ($u['role_id']) {
                                    echo '<input type="checkbox" name="user_visibility[]" value="'.$u['id'].'"';
                                    if (in_array($u['id'], $task['visibility']['users'])) {
                                        echo ' checked="checked"';
                                    }
                                    echo ' /> '.$u['first_name'].' '.$u['last_name'].'<br/>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="clearfix">
                        <label id="deadline_label">Share with Departments</label>
                        <div class="input" style="height:125px;overflow-y:scroll;border:1px solid #ccc;background-color:#fff;padding:5px;">
                            <?php
                            foreach($roles as $r) {
                                echo '<input type="checkbox" name="role_visibility[]" value="'.$r['id'].'"';
                                if (in_array($r['id'], $task['visibility']['roles'])) {
                                    echo ' checked="checked"';
                                }
                                echo ' /> '.ucwords($r['label']).'<br/>';
                            }
                            ?>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <input type="submit" value="Save Changes" class="btn primary" style="margin-top:10px;" />
    </fieldset>
</form>

<script type="text/javascript">
    $(document).ready(function(){
        $("#due_time").focus(function(){
            if ($("#due_time").val() == 'Time') {
                $("#due_time").val('');
            }
        });
        $("#due_time").blur(function(){
            if ($("#due_time").val() == '') {
                $("#due_time").val('Time');
            }
        });
        $('#task_type').change(function(){
            if ($('#task_type').val() == 'appointment') {
                $('#appointment_row').show();
                $('#deadline_label').html('Appointment Date and Time');
            } else {
                $('#appointment_row').hide();
                $('#deadline_label').html('Deadline Date and Time');
            }
        });
    });
</script>