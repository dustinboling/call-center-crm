<div style="text-align: center; margin-top: 100px;">

    <script type="text/javascript">  
        AudioPlayer.setup("/swf/player.swf", {  
            width: 290  
        });  
    </script>
    
    <p id="audioplayer_1">Loading Call Recording</p>  
    <script type="text/javascript">  
        AudioPlayer.embed("audioplayer_1", {soundFile: "<?php echo str_replace('http://api.twilio.com','http://recordings.pinnacletaxadvisors.com', $call['recording_url']);?>.mp3", autostart: 'yes', animation: 'no'});  
    </script>  
    
</div>