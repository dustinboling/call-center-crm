<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <link href="/css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="/css/grid.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="span8 offset4" style="margin-top: 200px;">
                    <?php echo Notify::showFlash();?>
                    <form action="/account/signin" method="post">
                        <fieldset>
                            <legend>Sign in</legend>
                            <div class="clearfix">
                                <label for="email">Email Address</label>
                                <div class="input">
                                    <input type="text" name="email">
                                </div>
                            </div>
                            <div class="clearfix">
                                <label for="passwd">Password</label>
                                <div class="input">
                                    <input type="password" name="passwd">
                                </div>
                            </div>
                            <div class="actions">
                                <button class="btn primary" type="submit">Sign In</button>
                            </div>    
                        </fieldset>    
                    </form>
                </div>
            </div>   
        </div>
    </body>
</html>