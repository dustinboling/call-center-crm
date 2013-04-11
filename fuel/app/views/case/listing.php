<h1>Cases</h1>

<div class="row-fluid">
<div class="span12">
<?php /*
<div class="fr" style="margin-top: 10px;">
    <a href="/case/add" class="btn btn-success"><i class="icon-white icon-plus-sign"></i> New Case</a>    
</div>    
*/?>


<?php echo View::factory('case/tabs')->render();?>

<?php if(uri::segment(2) != 'search'):?>
<div class="filter_bar">
    <form action="/case/listing" method="post" id="filters">
        
        <?php if(isset($_SESSION['filter'])):?>
        <div class="label label-info fr" style="margin-top: 5px;"><?php echo $pagination['total_items'];?> Cases</div>
        <?php endif;?>
        
        <select name="filter[milestone_id]" class="input-medium">
            <option value="">Any Milestone</option>
            <?php foreach($milestones as $m):?>
            <option value="<?php echo $m['id'];?>"><?php echo $m['name'];?></option>
            <?php endforeach;?>
        </select>
        
        <select name="filter[status_id]" class="input-medium">
            <option value="">Any Status</option>
            <option value="0">(!) Incorrect or No Status</option>
            <?php foreach($statuses as $s):?>
            <option value="<?php echo $s['id'];?>"><?php echo $s['name'];?></option>
            <?php endforeach;?>
        </select>
        
        <select name="filter[campaign_id]" class="input-medium">
            <option value="">Any Campaign</option>
            <?php foreach($campaigns as $c):?>
            <option value="<?php echo $c['id'];?>"><?php echo $c['name'];?></option>
            <?php endforeach;?>
        </select>
        
        <select name="filter[user_id]" class="input-medium">
            <option value="">Any User</option>
            <option value="0">Unassigned</option>
            <?php foreach($users as $u):?>
            <option value="<?php echo $u['id'];?>"><?php echo $u['first_name'] . ' ' . $u['last_name'];?></option>
            <?php endforeach;?>
        </select>
        
        <select name="filter[dates]" id="filter_dates" class="input-medium">
            <option value="today">Today</option>
            <option value="yesterday">Yesterday</option>
            <option value="last7">Last 7 Days</option>
            <option value="last30">Last 30 Days</option>
            <option value="this_month">This Month</option>
            <option value="last_month">Last Month</option>
            <option value="all_time">All Time</option>
            <option value="custom">Specific Dates</option>
        </select>
        
        <span id="specific_dates">
            <input type="text" name="filter[start_date]" class="datepicker input-small"> to
            <input type="text" name="filter[end_date]" class="datepicker input-small">
        </span>
        
        <select name="filter[date_field]" class="input-medium">
            <option value="last_action">using Last Action</option>
            <option value="created">using Created Date</option>
        </select>
        
        <?php if(Model_Account::getType() == 'Admin'):?>  
        <input type="text" name="filter[limit]" class="input-mini" placeholder="Limit">
        <?php endif;?>
        
        <input type="submit" name="filter[active]" class="btn btn-primary" value="Filter">
        
        <?php if(isset($_SESSION['filter'])):?>
        <a href="/case/clear_filter" class="btn btn-danger"><i class="icon-remove icon-white"></i> Clear</a>
        <?php endif;?>
        
    </form>
</div>
<?php else:?>
    <p><?php echo $results;?> Result<?php echo ($results==1?'':'s');?> found</p>
<?php endif;?>
<?php if(Model_Account::getType() == 'Admin'):?>    
    <form action="/case/batch_process" method="post">
        
   <div class="action_bar">
        <select name="action_id">
            <option value="">Actions</option>
            <?php foreach($actions as $a):?>
            <option value="<?php echo $a['id'];?>"><?php echo $a['name'];?></option>
            <?php endforeach;?>
        </select>

        <select name="sales_rep_id">
            <option value="">Assign to User</option>
            <?php foreach($users as $u):?>
            <option value="<?php echo $u['id'];?>"><?php echo $u['first_name'] . ' ' . $u['last_name'];?></option>
            <?php endforeach;?>
        </select>

        <select name="campaign_id">
            <option value="">Assign to Campaign</option>
            <?php foreach($campaigns as $c):?>
            <option value="<?php echo $c['id'];?>"><?php echo $c['name'];?></option>
            <?php endforeach;?>
        </select>

        <select name="distribution_group_id">
            <option value="">Distribute to Group</option>
            <?php foreach($distribution_groups as $dg):?>
            <option value="<?php echo $dg['id'];?>"><?php echo $dg['name'];?></option>
            <?php endforeach;?>
        </select>
       
        <button class="btn btn-danger">Run Batch</button>
    </div>    
        
        <fieldset>
<?php endif;?>            
<table class="table table-striped">
    
    <thead>
        <tr>
            <?php if(Model_Account::getType() == 'Admin'):?>  <th class="c"><input type="checkbox" class="check_all"></th><?php endif;?>
            <th>Docs</th>
            <th><a href="?sort=created<?php (isset($_GET['sort']) && $_GET['sort'] == 'created' && !isset($_GET['order'])?print'&order=asc':'');?>">Created</a></th>
            <th>Milestone</th>
            <th><a href="?sort=status_id<?php (isset($_GET['sort']) && $_GET['sort'] == 'status_id' && !isset($_GET['order'])?print'&order=asc':'');?>">Status</a></th>
            <th><a href="?sort=sales_rep_id<?php (isset($_GET['sort']) && $_GET['sort'] == 'sales_rep_id' && !isset($_GET['order'])?print'&order=asc':'');?>">User</th>
            <th><a href="?sort=campaign_id<?php (isset($_GET['sort']) && $_GET['sort'] == 'campaign_id' && !isset($_GET['order'])?print'&order=asc':'');?>">Campaign</a></th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Primary Phone</th>
            <th><a href="?sort=action_count<?php (isset($_GET['sort']) && $_GET['sort'] == 'action_count' && !isset($_GET['order'])?print'&order=asc':'');?>">Actions</a></th>
            <th><a href="?sort=last_action<?php (isset($_GET['sort']) && $_GET['sort'] == 'last_action' && !isset($_GET['order'])?print'&order=asc':'');?>">Last Action</a></th>
        </tr>    
    </thead>
    
    <tbody>
        <?php foreach($cases as $c):?>
        <tr class="case <?php ($c['status'] == 'New'?print 'new':'');?>" data-id="<?php echo $c['id'];?>" <?php ($c['status'] == 'New'?print 'style="background-color: #cbddf2 !important;"':'');?>>
            <?php if(Model_Account::getType() == 'Admin'):?>  <th width="20" class="c" style="background: none;"><input type="checkbox" name="cases[]" value="<?php echo $c['id'];?>"></th><?php endif;?>
            <td>
                <a class="btn btn-<?php echo $docs_status[$c['docs_status']]['class'];?>" rel="tooltip" title="<?php echo $c['docs_status'];?>" href="/esign/document/listing/<?php echo $c['id'];?>"><i class="<?php echo $docs_status[$c['docs_status']]['icon'];?>"></i></a>
            </td>
            <td><?php echo format::relative_date($c['created']);?></td>
            <td><?php echo $c['milestone'];?></td>
            <td><?php echo $c['status'];?></td>
            <td><?php echo (isset($c['sales_rep_name']) ? $c['sales_rep_name'] : '');?></td>
            <td><?php echo $c['campaign'];?></td>
            <td><?php (isset($c['first_name'])?print $c['first_name']:'');?></td>
            <td><?php (isset($c['last_name'])?print $c['last_name']:'');?></td>
            <td><?php echo format::phone($c['primary_phone']);?></td>
            <td class="c" width="50"><a href="#" class="actions_popup" data-title="Last 5 Actions" data-id="<?php echo $c['id'];?>"><?php echo $c['action_count'];?></a></td>
            <td><?php echo format::relative_date($c['last_action']);?></td>
            <td><a href="/case/update/<?php echo $c['id'];?>"><i class="icon-pencil"></i></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    
</table>

<?php if(Model_Account::getType() == 'Admin'):?>  
        </fieldset>
    </form>
<?php endif;?>
    
<?php echo View::factory('pagination', $pagination)->render();?>

</div>
</div>

<script type="text/javascript">
    $(function(){
        
       $("#filters").populate(<?php echo (isset($_SESSION['filter']) && !empty($_SESSION['filter'])?'{filter:'.json_encode($_SESSION['filter']).'}':''); ?>);  
        
       $(".case td").click(function(){
          window.location = '/case/update/'+$(this).parent().data('id'); 
       });
       
       $("#filter_dates").change(function(){
          if($(this).val() == 'custom'){
              $("#specific_dates").show();
          }else{
              $("#specific_dates").hide();
          }
       });
       
       <?php if(isset($_SESSION['filter']['start_date']) && !empty($_SESSION['filter']['start_date'])):?>
           $("#specific_dates").show();
       <?php endif;?>
           
       $('.actions_popup').popover({placement: 'left', content: function(){ return get_recent_activity($(this)) }});  
       
        $('.check_all').click(function () {
            $(this).parents('fieldset:eq(0)').find(':checkbox').attr('checked', this.checked);
        });
        
        $('a[rel="tooltip"]').tooltip();
           
    });
    
    function get_recent_activity(obj){
        
        var obj = obj;
        id = $(obj).attr('data-id');
        $.get('/case/get_recent_activity/'+id, function(data){
            
           html = '<table class="table table-condensed table-striped small-txt">';
           content = '';
           $.each(data, function(i,e){
              html += '<tr><td>'+e.name+'</td><td>'+e.message+'</td><td>'+e.note+'</td><td>'+e.ts+'</td></tr>';             
           });
           html += '</table>';
            
           $("#activity_hook").html(html);
        },'json');
        
        return '<span id="activity_hook"></span>';
        
    }
</script>    
        
