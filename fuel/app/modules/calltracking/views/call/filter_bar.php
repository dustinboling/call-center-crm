    <div class="clear"></div>

    <div id="call_filter" class="filter_bar clearfix">
        <?php if(uri::segment(3) == 'by_filter'):?>
            <button id="export_calls" class="btn fr">Export</button>
        <?php endif;?>
        
        <form action="/calltracking/call/by_filter/" method="GET" style="margin: 0; padding: 0;">
        Find Calls: 
        <select name="campaign_id">
            <option value="">Any Campaign</option>
            <?php foreach($campaigns as $campaign):?>
            <option value="<?php echo $campaign['id'];?>"><?php echo $campaign['name'];?></option>
            <?php endforeach;?>
        </select>
        
        from 
        <input type="text" name="start_date" class="datepicker small">
        to
        <input type="text" name="end_date" class="datepicker small">
        
        <button id="filter_calls" class="btn" type="submit">Find</button>
        </form>
    </div>