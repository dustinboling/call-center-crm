<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta charset="utf8">
        <link href='http://fonts.googleapis.com/css?family=Rokkitt' rel='stylesheet' type='text/css'>
        <link href="/css/styles.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script type="text/javascript" src="/js/jquery-ui.js"></script>
        <script type="text/javascript" src="/js/jquery.colorbox.js"></script>
        <script type="text/javascript" src="/js/jquery.populate.js"></script>
        <script type="text/javascript" src="/js/global.js"></script>
        <script type="text/javascript" src="/js/bootstrap.min.js"></script>
    </head>
    <body>
                
        <div class="container-fluid">
            
            <div class="row-fluid">
                <div id="user_bar">
                    <div id="section_menu" class="span9">
                        <ul class="unstyled">
                            <li><a href="/dashboard">CRM</a></li> 
                            <?php /*<li><a href="/calltracking/dashboard">Call Tracking</a></li>*/?>
                        </ul>
                    </div>
                    <div id="login_status" class="span2">
                        <?php echo $_SESSION['user']['first_name'] . ' ' . $_SESSION['user']['last_name'];?>, <a href="/account/signout">sign out</a>
                    </div>                
                </div>
            </div>
            
            <div id="header">
               <a href="/"><img src="/img/layout/logo.png"></a>
            </div>    
                  
            <div id="navigation">
                
                <div class="search">
                    <form action="/case/search" method="post" class="form-search">
                        <input type="text" name="query" class="input-large" placeholder="Search">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </form>
                </div>
                
                <ul class="unstyled">
                    <li><a href="/dashboard">Dashboard</a></li>
                    <li><a href="/event/listing">Appointments</a></li>
                    <li><a href="/case/listing">Cases</a></li>
                    <?php /*if($_SESSION['user']['id'] == 1):?>
                    <li><a href="/calendar">Calendar</a></li>
                    <?php endif;*/?>
                    <?php if(Model_Account::getType() == 'Admin'):?>
                    <li><a href="/system/status/listing">System</a></li>
                    <?php endif;?>
                </ul>
                <div class="clear"></div>
            </div>
            
        </div>
        

            <div class="container-fluid">
                
                <?php /*
                <div class="span12"><?php Notify::showFlash(); ?></div>
                <div class="clear"></div>
                 */?>
                <div class="row-fluid"><?php Notify::showFlash(); ?></div>
                <div class="row-fluid"><?php echo View::factory($l, $c)->render(); ?></div>
                <div class="clear"></div>

            </div>

            
        <div class="clear"></div>
        
        <?php echo View::factory('popup');?>
        
    </body>
</html>