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
        <div class="label label-info fr" style="margin-top: 5px;"><?php echo $pagination['total_items'];?> Cases Found</div>
        <?php endif;?>
        
        <select name="filter[status_id]">
            <option value="">Any Status</option>
            <?php foreach($statuses as $s):?>
            <option value="<?php echo $s['id'];?>"><?php echo $s['name'];?></option>
            <?php endforeach;?>
        </select>
        
        <select name="filter[campaign_id]">
            <option value="">Any Campaign</option>
            <?php foreach($campaigns as $c):?>
            <option value="<?php echo $c['id'];?>"><?php echo $c['name'];?></option>
            <?php endforeach;?>
        </select>
        
        <select name="filter[user_id]">
            <option value="">Any User</option>
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
        
        <input type="submit" name="filter[active]" class="btn btn-primary" value="Filter">
        
        <?php if(isset($_SESSION['filter'])):?>
        <a href="/case/clear_filter" class="btn btn-danger"><i class="icon-remove icon-white"></i> Clear Current Filter</a>
        <?php endif;?>
        
    </form>
</div>
<?php else:?>
    <p><?php echo $results;?> Result<?php echo ($results==1?'':'s');?> found</p>
<?php endif;?>

<table class="table table-striped">
    
    <thead>
        <tr>
            <th><a href="?sort=created<?php (isset($_GET['sort']) && $_GET['sort'] == 'created' && !isset($_GET['order'])?print'&order=asc':'');?>">Created</a></th>
            <th>Status</th>
            <th>User</th>
            <th>Campaign</th>
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
            <td><?php echo format::relative_date($c['created']);?></td>
            <td><?php echo $c['status'];?></td>
            <td><?php echo (isset($c['sales_rep_name']) ? $c['sales_rep_name'] : '');?></td>
            <td><?php echo $c['campaign'];?></td>
            <td><?php echo $c['first_name'];?></td>
            <td><?php echo $c['last_name'];?></td>
            <td><?php echo format::phone($c['primary_phone']);?></td>
            <td class="c" width="50"><a href="#" class="actions_popup" data-title="Last 5 Actions" data-id="<?php echo $c['id'];?>"><?php echo $c['action_count'];?></a></td>
            <td><?php echo format::relative_date($c['last_action']);?></td>
            <td><a href="/case/view/<?php echo $c['id'];?>"><i class="icon-pencil"></i></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    
</table> 

<?php echo View::factory('pagination', $pagination)->render();?>

</div>
</div>
<script type="text/javascript">
    $(function(){
        
       $("#filters").populate(<?php echo (isset($_SESSION['filter']) && !empty($_SESSION['filter'])?'{filter:'.json_encode($_SESSION['filter']).'}':''); ?>);  
        
       $(".case").click(function(){
          window.location = '/case/view/'+$(this).data('id'); 
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
        
