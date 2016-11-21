<html>
{!like.js}
{$data},{$person}

<ul>
    {loop $b}<li>V</li>
</ul>
<?php
        echo $pai*2;
        ?>
<?php if($data=='abc'){?>
我是abc
<?php }else if($data=='def'){?>
我是def
<?php }else{?>
我就是我，{$data}
<?php }?>
{#注释不会出现}
1234660---------------------

</html>