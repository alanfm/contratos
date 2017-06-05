<nav aria-label="page navigation" class="text-center">
    <ul class="pagination pagination-sm">
        <?php if ($current != 1):?>
            <li>
                <a href="<?=self::link($pagina.'/pagina/1')?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
        <?php endif;?>

        <li<?=$current == 1? ' class="active"': ''?>>
            <a href="<?=self::link($pagina.'/pagina/1')?>">1</a>
            </a>
        </li>

        <?php
        
        if ($current <= 4){
            $i = 2;
        } else {
            $i = $current - 3;
            if ($current > 5) {
                echo '<li class="disabled"><a href="javascript:void()">...</a></li>';
            }
        }

        if ($count >= 8 && ($current + 3) < $count) {
            $end = $current + 3;
        } else {
            $end = $count - 1;
        }

        for (; $i <= $end; $i++):?>
            <li <?=$current == $i? 'class="active"': ''?>><a href="<?=self::link($pagina.'/pagina/'.$i);?>"><?=$i?></a></li>
        <?php
        endfor;
        if ($count > ($end + 1)) {
            echo '<li class="disabled"><a href="javascript:void()">...</a></li>';
        }
        ?>

        
        <?php if ($count > 1): ?>
            <li<?=$current == $count? ' class="active"': ''?>>
                <a href="<?=self::link($pagina.'/pagina/'.$count)?>"><?=$count?></a>
                </a>
            </li>
        <?php endif;?>
        <?php if ($count != $current):?>
            <li>
                <a href="<?=self::link($pagina.'/pagina/'.$count)?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        <?php endif;?>
    </ul>
</nav>