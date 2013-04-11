<!DOCTYPE html>
<html>
    <head>
        <title>Pinnacle Tax Advisors</title>
        <link href='http://fonts.googleapis.com/css?family=Rokkitt' rel='stylesheet' type='text/css'>
        <link href="/css/styles.css" rel="stylesheet" type="text/css">
        <link href="/css/calltracking.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="/js/jquery.js"></script>
        <script type="text/javascript" src="/js/jquery-ui.js"></script>
        <script type="text/javascript" src="/js/jquery.colorbox.js"></script>
        <script type="text/javascript" src="/js/jquery.populate.js"></script>
        <script type="text/javascript" src="/js/audio-player.js"></script>
        <script type="text/javascript" src="/js/global.js"></script>
    </head>
    <body>
                
        <div class="container">
            
            <div class="row">
                
                <div id="user_bar">
                    <div id="section_menu" class="span12">
                        <ul class="unstyled">
                            <li><a href="/dashboard">CRM</a></li>
                            <li><a href="/calltracking/dashboard">Call Tracking</a></li>
                        </ul>
                    </div>
                    <div id="login_status" class="span4">
                        <?php echo $_SESSION['user']['first_name'] . ' ' . $_SESSION['user']['last_name'];?>, <a href="/account/signout">sign out</a>
                    </div>                
                </div>
                
            </div>
            
            <div id="header">
                <a href="/"><img src="/img/layout/logo.png"></a>
            </div>    
                  
            <div id="navigation">
                <ul class="unstyled">
                    <li><a href="/calltracking/dashboard">Dashboard</a></li>
                    <li><a href="/calltracking/campaign/listing">Campaigns</a></li>
                    <li><a href="/calltracking/number/listing">Numbers</a></li>
                    <li><a href="/calltracking/subaccount/listing">Sub Accounts</a></li>
                    <li><a href="/calltracking/disposition/listing">Dispositions</a></li>
                    <li><a href="/calltracking/extension/listing">Extensions</a></li>
                </ul>
                <div class="clear"></div>
            </div>
            
        </div>    
            
        <div id="page">
            <div class="container">
                <div class="row">
                    <div class="span16"><?php Notify::showFlash(); ?></div>
                    <?php echo View::factory($l, $c)->render(); ?>
                    <div class="clear"></div>
                </div>
            </div>
        </div>

        <div class="clear"></div>
    </body>
</html>