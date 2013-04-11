<?php echo View::factory('application/notes', $notes)->render();?>

<h1>Application Task</h1>
<?php echo View::factory('application/app_edit_tabs', $tabs)->render(); ?>
<div class="clear"></div>

<div class="span9" style="margin-bottom:10px;">
    <a href="/application/calendar/<?php echo URI::segment(3); ?>" class="btn small">Month Calendar</a>
    <a href="/application/calendar_week/<?php echo URI::segment(3); ?>" class="btn small">Week Calendar</a>
    <a href="/application/calendar_day/<?php echo URI::segment(3); ?>" class="btn small">Day Calendar</a>
</div>
<div class="clear"></div>

<form action="/application/task_add/<?php echo Uri::segment(3); ?>" method="post" class="form-stacked">
    <fieldset>
        <table class="table table-striped" cellpadding="0" cellspacing="0">
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
                                <option value="todo">Task</option>
                                <option value="appointment">Appointment</option>
                            </select>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="clearfix">
                        <label>Task Title:</label>
                        <div class="input">
                            <input type="text" class="span7" name="title" value="">
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="clearfix">
                        <label>Task Description:</label>
                        <div class="input">
                            <textarea name="description" class="span7" style="height:100px;"></textarea>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="clearfix">
                        <label>Assign To:</label>
                        <div class="input">
                            <select name="assignee" class="span4">
                                <option value=""></option>
                                <?php
                                foreach($users as $u) {
                                    if ($u['role_id']) {
                                        echo '<option value="'.$u['id'].'">'.$u['first_name'].' '.$u['last_name'].'</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="clearfix">
                        <label id="deadline_label">Deadline Date and Time</label>
                        <div class="input">
                            <input type="text" class="span5 datepicker" name="due_date" value="">
                            <input id="due_time" type="text" class="span2" name="due_time" value="Time">
                        </div>
                    </div>
                </td>
            </tr>
            <tr id="appointment_row" style="display:none;">
                <td>
                    <div class="clearfix">
                        <label>Appointment Priority:</label>
                        <div class="input">
                            <select name="priority_status" class="span4">
                                <option value=""></option>
                                <option value="first_reschedule">First Reschedule</option>
                                <option value="second_reschedule">Second Reschedule</option>
                            </select>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="clearfix">
                        <label id="">Appointment Duration</label>
                        <div class="input">
                            <select name="appointment_duration" class="span4">
                                <option value="15 Minutes">15 Minutes</option>
                                <option value="30 Minutes">30 Minutes</option>
                                <option value="45 Minutes">45 Minutes</option>
                                <option value="1 Hour">1 Hour</option>
                                <option value="1 Hour, 30 Minutes">1 Hour, 30 Minutes</option>
                                <option value="2 Hours">2 Hours</option>
                                <option value="3 Hours">3 Hours</option>
                                <option value="4 Hours">4 Hours</option>
                                <option value="5 Hours">5 Hours</option>
                                <option value="6 Hours">6 Hours</option>
                                <option value="7 Hours">7 Hours</option>
                                <option value="8 Hours">8 Hours</option>
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
                                    echo '<input type="checkbox" name="user_visibility[]" value="'.$u['id'].'" /> '.$u['first_name'].' '.$u['last_name'].'<br/>';
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
                                echo '<input type="checkbox" name="role_visibility[]" value="'.$r['id'].'" /> '.ucwords($r['label']).'<br/>';
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