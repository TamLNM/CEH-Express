<?php
    $head['head_title']='<p style="color:red;font-size:16px;font-weight:bold;">'.$head['line1'].'</p><p style="color:#333;font-size:13px;">'.$head['line2'].'</p>';
    unset($head['line1']);
    unset($head['line2']);
    $b=var_export($head,true);
    $tmp = "<?php ";
    $tmp .= '$head=' . $b . ';';
    $tmp .= '?>';              
    $f = fopen("data/head.php", "w");
    fwrite($f, $tmp);
    fclose($f);   
?>
