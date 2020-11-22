<?php

class update {
    var $cur_version=12;
    function run() {
        global $db,$head;      
        if(!isset($head['version'])) {
            $head['version']=1;
        }
        if($head['version']<$this->cur_version) {
            for($i=$head['version']+1;$i<=$this->cur_version;$i++) {
                $sql=file(__DIR__."/versions/$i.sql");
                $sql=implode("",$sql);
                $db->multiquery($sql);
                if(file_exists(__DIR__."/versions/$i.php")) {
                    include(__DIR__."/versions/$i.php");
                }
            }
            $head['version']=$this->cur_version;
            $b=var_export($head,true);
            $tmp = "<?php ";
            $tmp .= '$head=' . $b . ';';
            $tmp .= '?>';              
            $f = fopen("data/head.php", "w");
            fwrite($f, $tmp);
            fclose($f);            
            echo '<div style="position:absolute;top:5px;right:5px;padding:10px;border:1px solid #ccc;background:#eee;color:red;">Đã cập nhật lên phiên bản '.$this->cur_version.'.0</div>';
        }
        
    }
}
$u=new update();
$u->run();
?>
