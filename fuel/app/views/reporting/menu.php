<div class="span2" style="padding: 15px 0 500px 0;">

<ul class="nav nav-list">
    
    <li class="nav-header">Commissions</li>
    
    <li><a href="/reporting/commissions/summary">Commissions</a></li>
    <?php if(Model_Account::getType() == 'Admin'):?>
    <li class="nav-header">Transfers</li>
    
    <li><a href="/reporting/transfers/user">By User</a></li>
    <li><a href="/reporting/transfers/campaign">By Campaign</a></li>
    
    <li class="nav-header">Docs</li>
    
    <li><a href="/reporting/docs/out">Docs Out</a></li>
    <li><a href="/reporting/docs/in">Docs In</a></li>
    <?php endif;?>
</ul>

</div>    