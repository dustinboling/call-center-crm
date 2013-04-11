<h1><?php echo $case['first_name'] . ' ' . $case['last_name'];?></h1>

<?php echo $header;?>

<ul class="nav nav-tabs">
    <li class="active"><a href="#overview" data-toggle="tab">Overview</a></li>
    <li><a href="/case/update/<?php echo uri::segment(3);?>">Case Info</a></li>
    <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown">Payments <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li><a href="/payment/process/<?php echo uri::segment(3);?>">Process Next Payment</a>
            <li><a href="/payment/manage/<?php echo uri::segment(3);?>">Payment Plan</a>
            <li><a href="/sfpayment/case/<?php echo uri::segment(3);?>">Payments Received</a></li>   
        </ul>
    </li>
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown">Documents <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li><a href="/esign/document/listing/<?php echo uri::segment(3);?>">ESign Documents</a>
            <li><a data-toggle="tab" href="#forms">Forms</a>
            <li><a data-toggle="tab" href="#documents">Uploaded Documents</a>
        </ul>
    </li>    
    <li><a href="#activity" data-toggle="tab">Activity</a></li>
</ul>

<?php /*<form action="/case/update/<?php echo uri::segment(3);?>" method="post" class="form" id="form">*/?>
<div class="tab-content">
    <div class="tab-pane active" id="overview">
        
    <form action="/case/update/<?php echo uri::segment(3);?>" method="post" class="form" id="form">
        
        <div class="row-fluid">
           
            <div class="span4">
                        
                <h2>Contact Information</h2>
                
                    
                <table class="table table-striped table-bordered">
                    <tr>
                        <td width="125">Name</td>
                        <td>
                            <input type="text" name="first_name" placeholder="First" class="input-medium" value="<?php echo $case['first_name'];?>" style="margin-bottom: 0;">
                            <input type="text" name="last_name" placeholder="Last" class="input-medium" value="<?php echo $case['last_name'];?>" style="margin-bottom: 0;">
                        </td>
                    </tr>
                    <tr>
                        <td>Primary Phone</td>
                        <td><input type="text" name="primary_phone" value="<?php echo format::phone($case['primary_phone']);?>"></td>
                    </tr>
                    <tr>
                        <td>Secondary Phone</td>
                        <td><input type="text" name="secondary_phone" value="<?php echo format::phone($case['secondary_phone']);?>"></td>
                    </tr>
                    <tr>
                        <td>Mobile</td>
                        <td><input type="text" name="mobile_phone" value="<?php echo format::phone($case['mobile_phone']);?>"></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><input type="text" name="email" value="<?php echo $case['email'];?>"></td>
                    </tr>
                </table>
                

            </div>
            
            <div class="span4">
                        
                <h2>Agent Assignments</h2>
                <table class="table table-striped table-bordered">
                    <tr>
                        <td width="125">2848 Agent 1</td>
                        <td>
                            <select name="f2848_agent_1">
                                <option value=""></option>
                                <?php foreach($agents as $a):?>
                                <option value="<?php echo $a['id'];?>"><?php echo $a['first_name'].' '.$a['last_name'];?></option>
                                <?php endforeach;?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="125">2848 Agent 2</td>
                        <td>
                            <select name="f2848_agent_2">
                                <option value=""></option>
                                <?php foreach($agents as $a):?>
                                <option value="<?php echo $a['id'];?>"><?php echo $a['first_name'].' '.$a['last_name'];?></option>
                                <?php endforeach;?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="125">2848 Agent 3</td>
                        <td>
                            <select name="f2848_agent_3">
                                <option value=""></option>
                                <?php foreach($agents as $a):?>
                                <option value="<?php echo $a['id'];?>"><?php echo $a['first_name'].' '.$a['last_name'];?></option>
                                <?php endforeach;?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="125">8821 Agent</td>
                        <td>
                            <select name="f8821_agent">
                                <option value=""></option>
                                <?php foreach($agents as $a):?>
                                <option value="<?php echo $a['id'];?>"><?php echo $a['first_name'].' '.$a['last_name'];?></option>
                                <?php endforeach;?>
                            </select>
                        </td>
                    </tr>
                </table>    
            </div>
                
        </div>    
        
        <div class="row-fluid">
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>    
        </div>
                
            </form>    
            
<?php /*                        
            <div class="span4">
                <h2>Tax Information</h2>
                
                <table class="table table-striped table-bordered">
                    <tr>
                        <td width="125">Tax Type</td>
                        <td><?php echo $case['tax_type'];?></td>
                    </tr>
                    <tr>
                        <td width="125">Federal Tax Liability</td>
                        <td>$<?php echo number_format((float)$case['federal_tax_liability'],2);?></td>
                    </tr>
                    <tr>
                        <td>State Tax Liability</td>
                        <td>$<?php echo number_format((float)$case['state_tax_liability'],2);?></td>
                    </tr>
                    <tr>
                        <td>Total Tax Liability</td>
                        <td>$<?php echo number_format((float)$case['federal_tax_liability']+(float)$case['state_tax_liability'],2);?></td>
                    </tr>
                </table>
                
                                
                <h2>Income &amp; Expenses</h2>
                <table class="table table-striped table-bordered">
                    <tr>
                        <td width="125">Income</td>
                        <td>$0.00</td>
                    </tr>
                    <tr>
                        <td>Assets</td>
                        <td>$0.00</td>
                    </tr>
                    <tr>
                        <td>Expenses</td>
                        <td>$0.00</td>
                    </tr>
                </table>
                
            </div> 
*/?>            
        
    </div><!-- end overview -->
    
    <div class="tab-pane" id="activity">
        
        <h2>Activity</h2>
        
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Date</th>
                <th>Message</th>
                <th>Note</th>
                <th>By</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($activity as $a):?>
            <tr>
                <td width="150"><?php echo format::relative_date($a['ts']);?></td>
                <td width="300"><?php echo $a['message'];?></td>
                <td><?php echo $a['note'];?></td>
                <td><?php (empty($a['name'])? print 'System Action':print $a['name']);?></td>
            </tr>
            <?php endforeach;?>
            </tbody>
        </table>
                
        
    </div>
<?php /*    
    <div class="tab-pane" id="profile"></div>
        
        
        
            
            <?php /*
            <?php $l = 1; $fl = 1; $section_id = 0; $container_id = 0; ?>
            <?php foreach($fields as $f):?>
            
            <?php if($section_id != $f['section_id']):?>
            <?php if($l != 1):?><div class="clear"></div></div></div></div><?php $fl = 1; endif;?>
            <div class="fields-section">
            <?php endif;?>

            <?php if($container_id != $f['container_id']):?>
            <?php if($l != 1 && $section_id == $f['section_id']):?><div class="clear"></div></div></div><?php $fl = 1; endif;?>    
            <div class="fields-container">
            <?php endif;?>    
            
            <?php if($l == 1 || (($fl % 3) == 1)):?>
                <?php if($l != 1):?></div><?php endif;?>
                <div class="row-fluid">
            <?php endif;?>
                    
            <div class="span4">    
                <div class="control-group">
                    <label class="control-label" for="<?php echo $f['clean_name'];?>"><?php echo $f['name'];?></label>
                    <div class="controls">
                        <input type="text" name="<?php echo $f['clean_name'];?>">
                    </div>
                </div>
            </div>    
                    
            <?php $l++; $fl++; $section_id = $f['section_id']; $container_id = $f['container_id'];?>
        <?php endforeach;?>
            </div>
            </div>
            </div>
            */?>
   <?php /*            
            <?php foreach($fields as $section_id => $cfs):?>
                <div class="fields-section tab-pane" id="section<?php echo $section_id;?>">
                <h2><?php (isset($fgroups[$section_id]['name'])? print $fgroups[$section_id]['name']:'');?></h2>
                
                <?php foreach($cfs as $container_id => $fs):?>

                    <div class="fields-container">

                    <h3><?php (isset($fgroups[$container_id]['name'])? print $fgroups[$container_id]['name']:'');?></h3>
                    <?php $cf_split = ceil(count($fs)/3); $cl = 1; ?>

                    <div class="span3">    
                    <?php foreach($fs as $f):?>
                        <?php if($f['editable']):?>
                            <?php if($cf_split < $cl):?>    
                            <?php if($cl != 1):?><div class="clear"></div></div><?php endif;?>    
                            <div class="span4">
                            <?php $cl = 1; ?>    
                            <?php endif;?>

                            <div class="control-group">
                                <label class="control-label" for="<?php echo $f['clean_name'];?>"><?php echo $f['name'];?></label>
                                <div class="controls">
                                    <?php if($f['field_type_id'] == 7):?>
                                    <input type="text" name="<?php echo $f['clean_name'];?>" class="datepicker" placeholder="mm/dd/yyyy">
                                    <?php elseif($f['field_type_id'] == 16):?>
                                    <select name="<?php echo $f['clean_name'];?>">
                                        <option value=""></option>
                                        <?php if(isset($options[$f['id']])):?>
                                            <?php foreach($options[$f['id']] as $k => $v):?>
                                                <option value="<?php echo $v;?>"><?php echo $v;?></option>
                                            <?php endforeach;?>
                                        <?php endif;?>
                                    </select>
                                    <?php else:?>
                                    <input type="text" name="<?php echo $f['clean_name'];?>">
                                    <?php endif;?>
                                </div>
                            </div>

                            <?php $cl++; ?>   
                        <?php endif;?>
                    <?php endforeach;?>

                    <div class="clear"></div>  

                    </div>  

                    <div class="clear"></div>

                    </div>
                <?php endforeach;?>

                <div class="clear"></div>    
                
               <div class="form-actions">
                    <button class="btn btn-primary">Save</button>
                </div>
                
                </div>
    
            <?php endforeach;?>
*/?>            
        <div class="tab-pane" id="documents">
            <h2>Documents</h2>

            <p><span class="label notice">Note</span> <strong>Drag &amp; drop files in this window to upload</strong> <span id="message" class="label"></span></p>

            <table class="table table-striped" id="file_list">
                <thead>
                    <tr>
                        <th>File</th>
                        <th>Added</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($documents as $d):?>
                <tr>
                    <td><a href="/document/view/<?php echo $d['id'];?>" target="_blank"><?php echo $d['name'];?></a></td>
                    <td><?php echo format::relative_date($d['created_date']);?></td>
                    <?php /*<td width="20" class="c"><a href="/application/document_update/<?php echo $d['id'];?>"><img src="/img/icons/update.png"></a></td>*/?>
                    <td width="20" class="c"><a href="/document/delete/<?php echo $d['id'];?>" class="confirm_delete"><img src="/img/icons/delete.png"></a></td>
                </tr>    
                <?php endforeach;?>
                </tbody>
            </table>   

        </div>


        <div class="tab-pane" id="forms">
            <h2>Forms</h2>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Name</th>

                    <th colspan="3"></th>
                </tr>
                </thead>
                <?php foreach($forms as $f):?>
                <tr>
                    <td><?php echo $f['name'];?></td>
                    <td width="50">eSign</td>
                    <td width="50">Fax</td>
                    <td width="50"><a href="/form/download/<?php echo $f['id'];?>/<?php echo uri::segment(3);?>" target="_blank">Download</a></td>
                </tr>
                <?php endforeach;?>
            </table>  

        </div>  
    
    </div><!-- end tabs -->

    </div>    
 
    <div class="clear"></div>
           
</div>
<?php /*</form>*/?>

<input id="fileupload" type="file" name="files[]" multiple style="display: none;">
<script type="text/javascript" src="/js/jquery.ui.widget.js"></script>
<script type="text/javascript" src="/js/jquery.iframe-transport.js"></script>
<script type="text/javascript" src="/js/jquery.fileupload.js"></script>

<?php foreach(array('federal_owed','federal_not_filed','state_owed','state_not_filed') as $field){ if(isset($case[$field])){ unset($case[$field]); } } ?>

<script type="text/javascript">
    $(function () {
        
        var hash = window.location.hash;
        if(hash != ''){
            $('.nav-tabs a[href="'+hash+'"]').tab('show');
        }else{    
            $('.nav-tabs a:first').tab('show');
        } 

        $('.nav-pills a:first').tab('show');
        $('.dropdown-toggle').dropdown();

        $("#form").populate(<?php echo (!empty($_POST)?json_encode($_POST):(isset($case)?json_encode($case):'')); ?>);
        
        $('#fileupload').fileupload({
            dataType: 'json',
            url: '/case/upload_document/<?php echo uri::segment(3);?>',
            done: function (e, data) {
                $.each(data.result, function (index, file) {
                    $("#file_list tbody").prepend('<tr><td><a href="/document/view/'+file.id+'">'+file.name+'</a></td><td>'+file.created_date+'</td><td width="20" class="c"><a href="/document/delete/'+file.id+'" class="confirm_delete"><img src="/img/icons/delete.png"></a></td></tr>');
                });
            },
            acceptFileTypes : /\.txt$/i
        }).bind('fileuploadsend', function(e, data){ $("#message").html('Uploading file...').addClass('notice')})
        .bind('fileuploaddone', function (e, data) {$("#message").html('File uploaded!').removeClass('notice').addClass('success')});
        
        $(".confirm_delete").live('click', function(e){
            answer = confirm('Are you sure you want to delete this document?');
            var t = $(this);
            if(answer){
                $.get(t.attr('href'), function(data){
                    t.parents('tr').remove();
                });
            }
            
            e.preventDefault();
        });
        
    });

    function double_check(){
        answer = confirm('Are you sure you want to delete this document?');
        if(answer){
            $.get($(this))
        }
    }
    
</script>