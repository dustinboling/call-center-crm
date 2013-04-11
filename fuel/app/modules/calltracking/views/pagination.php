<?php
    $page = (isset($_GET['page']) ? $_GET['page'] : 1);
    $offset = ($page-1) * $limit;
    $uri = '/'.Uri::string().'?'.$_SERVER['QUERY_STRING'];
    $t_uri = (preg_match("/page=[0-9]+/", $uri) ? preg_replace("/page=[0-9]+/", ":page", $uri) : $uri.(strpos($uri, '?') == strlen($uri) ? ':page': '&:page'));
?>

<?php if($total_items > $limit):?>

    <div class="pagination">
        <div class="pagination_ttl">Showing <?php print ($offset+1) . ' - ';?>
        <?php (($offset + $limit) > $total_items ? print $total_items : print ($offset + $limit)); ?>
        <?php (!empty($total_items) ? print ' of '.$total_items : '');?></div>
        <?php if($total_items > $limit):?>
            <ul>

                <?php if($page == 1):?>
                    <li class="disabled"><a href="#">&laquo; Prev</a></li>
                <?php else:?>
                    <li><a href="<?php echo str_replace(':page', 'page='.($page-1), $t_uri);?>">&laquo; Prev</a></li>
                <?php endif;?>

            <?php $total_pages = ceil($total_items / $limit); $page_loop = 1;?>
            <?php while($total_items > 0):?>
                <?php if(($total_pages > 20 && $page_loop <= 5) || ($total_pages > 20 && $page_loop >= ($total_pages - 4)) || $total_pages <= 20 || ($page >= ($page_loop-2) && $page <= ($page_loop+2))):?>
                <li <?php ($page_loop == $page ? print ' class="active"':'');?>>
                    <a href="<?php echo str_replace(':page', 'page='.$page_loop, $t_uri);?>" class=""><?php echo $page_loop;?></a>
                </li>
                <?php elseif($page == $page_loop-3 || $page == $page_loop+3):?>
                <li><a href="#">...</a></li>
                <?php endif;?>
                <?php $page_loop++; $total_items -= $limit;?>
            <?php endwhile;?>

                <?php if(($page_loop-1) == $page):?>
                    <li class="disabled"><a href="#">Next &raquo;</a></li>
                <?php else:?>
                    <li><a href="<?php echo str_replace(':page', 'page='.($page+1), $t_uri);?>">Next &raquo;</a></li>
                <?php endif;?>

            </ul>
        <?php endif;?>
        <div class="clear"></div>
    </div>

<?php endif;?>