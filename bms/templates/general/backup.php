  <table class="catbg" width="100%" border="0" cellpadding="0" cellspacing="0" style="border-bottom:0px;border-left:0px;border-right:0px;">
    <tr>
    <td width="30" align="center">
      <img style="cursor:pointer;" src="bms/images/icon/databaseup.png" width="18" height="18"/>        
      </td>
      <td  height="25"><b>Sao lưu/Khôi phục dữ liệu</b></td>
    <td align="right" style="padding-right:5px;"><img onclick="window.location='?';" style="cursor:pointer;" src="bms/images/icon/back.gif" height="18"/></td>
    </tr>
    </table>      
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td width="160" style="padding-left:10px;padding-top:10px;padding-bottom:10px;line-height:20px;">
            <?php
            if(!empty($err_msg)) {
                echo '<div style="padding:5px;color:red;font-size:14px;font-weight:bold;">'.$err_msg.'</div>';
            }
            ?>
            <h2>Khôi phục dữ liệu</h2>
            <?php
            $path = explode('/', $action->script);
            $user=$path[2];            
            if(!file_exists(ROOT_DIR."bms/tmp/restorelist/".$user)) {
                echo '<form action="?eda_act='.md5('general').'&eda_code='.md5('backup').'&sm=2" method="post" enctype="multipart/form-data"><input type="file" name="restore_file" size="25"><br>Khôi phục dữ liệu từ file đã lưu về máy tính để khôi phục lại dữ liệu cho hệ thống<br><input type="submit" value="Thực hiện khôi phục"  class="button"></form>';
            } else {
                echo '<span style="color:green;">File dữ liệu khôi phục đang chờ hoàn tất, vui lòng quay lại sau ít phút!</span>';
            }
            ?>                
            <h2>Sao lưu dữ liệu</h2>
            <input type="button" value="Sao lưu dữ liệu" onclick="window.location='?eda_act=<?=md5('general')?>&eda_code=<?=md5('backup')?>&sm=1';" name="search" class="button">
            <?php         
            if(!file_exists(ROOT_DIR."bms/tmp/backuplist/".$user)) {
                echo '<br>Tạo file dữ liệu backup để tải về lưu trữ trên máy của bạn';
            } else {
                echo '<br><span style="color:green;">File dữ liệu backup đang chờ hoàn tất, vui lòng quay lại sau ít phút!</span>';
            }
            if(file_exists(ROOT_DIR."bms/tmp/backupdata/".$user.".sql.gz")) {
                echo '<br><a href="?eda_act='.md5('general').'&eda_code='.md5('backup').'&eda_type=ajax&sm=3" target="_blank" class="cart_payment" style="font-size:13px;">Click vào đây để tải về file sao lưu (Tạo lúc '.date ("H:i d/m/Y", filemtime(ROOT_DIR."bms/tmp/backupdata/".$user.".sql.gz")).')</a>';
            }
            ?>            
	</td>
  </tr>
</table>         
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
      <tr>
	<td height=5><img src="bms/images/spacer.gif" height=5></td>
      </tr>
</table>
    <table class="catbg" width="100%" border="0" cellpadding="0" cellspacing="0" style="border-top:0px;border-left:0px;border-right:0px;">
    <tr>  
    <td height="30" style="padding-left:10px;"></td>
    <td align="right" style="padding-right:5px;"><img  onclick="window.location='?';" style="cursor:pointer;" src="bms/images/icon/back.gif" height="18"/></td>
    </tr>
 </table>       

