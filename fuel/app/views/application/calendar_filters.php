

<a href="/application/task_add/<?php echo URI::segment(3); ?>" class="btn primary small" style="display:block;text-align:center;margin-bottom:10px;">Add Task</a>
<strong>Assignments:</strong>
<ul style="list-style: none;margin-left:0;">
    <li><input type="checkbox" id="all_tasks" checked="checked" /> All Tasks</li>
    <li><input type="checkbox" id="assignee_tasks" checked="checked" /> My Tasks</li>
    <li><input type="checkbox" id="shared_tasks" checked="checked" /> Shared Tasks</li>
</ul>
<strong>Types:</strong>
<ul style="list-style: none;margin-left:0;">
    <li><input type="checkbox" id="task_events" checked="checked" /> Appointments</li>
    <li><input type="checkbox" id="task_todo" checked="checked" /> Tasks</li>
</ul>
<strong>Status:</strong>
<ul style="list-style: none;margin-left:0;">
    <li><input type="checkbox" id="task_working" checked="checked" /> Working</li>
    <li><input type="checkbox" id="task_suspended" checked="checked" /> Suspended</li>
    <li><input type="checkbox" id="task_completed" checked="checked" /> Completed</li>
    <li><input type="checkbox" id="task_overdue" checked="checked" /> Overdue</li>
</ul>
<strong>Key:</strong>
<ul style="list-style: none;margin-left:0;">
    <li class="working">Working</li>
    <li class="completed">Completed</li>
    <li class="overdue">Overdue</li>
    <li class="suspended">Suspended</li>
    <li class="first_reschedule">Rescheduled</li>
</ul>

<script type="text/javascript">
    $(document).ready(function(){
        $("#all_tasks").click(function(){
            if($("#all_tasks").is(':checked')) {
                $(".assignee").show();
                $(".shared").show();
                $("#assignee_tasks").prop("checked", true);
                $("#shared_tasks").prop("checked", true);
            } else {
                $(".assignee").hide();
                $(".shared").hide();
                $("#assignee_tasks").prop("checked", false);
                $("#shared_tasks").prop("checked", false);
            }
        });
        $("#assignee_tasks").click(function(){
            if($("#assignee_tasks").is(':checked')) {
                $(".assignee").show();
                if($("#shared_tasks").is(':checked')) {
                    $("#all_tasks").prop("checked", true);
                }
            } else {
                $(".assignee").hide();
                if($("#shared_tasks").is(':checked')) {
                    $("#all_tasks").prop("checked", false);
                }
            }
        });
        $("#shared_tasks").click(function(){
            if($("#shared_tasks").is(':checked')) {
                $(".shared").show();
                if($("#assignee_tasks").is(':checked')) {
                    $("#all_tasks").prop("checked", true);
                }
            } else {
                $(".shared").hide();
                if($("#assignee_tasks").is(':checked')) {
                    $("#all_tasks").prop("checked", false);
                }
            }
        });
        $("#task_events").click(function(){
            if($("#task_events").is(':checked')) {
                $(".calendar .appointments .event").show();
            } else {
                $(".calendar .appointments .event").hide();
            }
        });
        $("#task_todo").click(function(){
            if($("#task_todo").is(':checked')) {
                $(".calendar .appointments .task").show();
            } else {
                $(".calendar .appointments .task").hide();
            }
        });
        $("#task_working").click(function(){
            if($("#task_working").is(':checked')) {
                $(".calendar .appointments .working").show();
            } else {
                $(".calendar .appointments .working").hide();
            }
        });
        $("#task_suspended").click(function(){
            if($("#task_suspended").is(':checked')) {
                $(".calendar .appointments .suspended").show();
            } else {
                $(".calendar .appointments .suspended").hide();
            }
        });
        $("#task_completed").click(function(){
            if($("#task_completed").is(':checked')) {
                $(".calendar .appointments .completed").show();
            } else {
                $(".calendar .appointments .completed").hide();
            }
        });
        $("#task_overdue").click(function(){
            if($("#task_overdue").is(':checked')) {
                $(".calendar .appointments .overdue").show();
            } else {
                $(".calendar .appointments .overdue").hide();
            }
        });
    });
</script>