<?php
$login_history = get_data("select l.*, u.user_name from login_history l, users u  where l.user_id=u.user_id  and l.user_id='" . $sessions->get_session('user_id') . "' order by l.lhi_id desc  limit " . (30 * ($action->eda_page - 1)) . ",30");
$count_dt = get_data("select count(*) c from login_history l, users u  where l.user_id=u.user_id  and l.user_id='" . $sessions->get_session('user_id') . "'");
$count_dt = $count_dt[0]['c'];
?>	
<table width="100%" class="catbg" border="0" cellpadding="0" cellspacing="0" style="border-bottom:0px;border-left:0px;border-right:0px;">
    <tr>
        <td width="30" align="center">
            <img style="cursor:pointer;" src="bms/images/icon/documents.png" width="18" height="18"/>        
        </td>
        <td  height="25"><b>LỊCH SỬ ĐĂNG NHẬP</b></td>
        <td align="right" style="padding-right:5px;"><img onclick="window.location='?';" style="cursor:pointer;" src="bms/images/icon/back.gif" height="18"/></td>
    </tr>
</table>
<table width="100%"  border="0" cellpadding="0" cellspacing="0" style="margin-top:10px;border-collapse: collapse;">
    <tr><td style="padding:10px;">
<table align="center" bgcolor="#f0f0f0" width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#ffffff"  style="border-collapse:collapse; border:1px #dedede solid;">
    <tr>
        <td width="5%" align="center" bgcolor="#afd7ff"><b>STT</b></td>
        <td width="20%" align="center" bgcolor="#afd7ff"><b>Từ địa chỉ IP</b></td>
        <td width="20%" align="center" bgcolor="#afd7ff"><b>Đăng nhập/đăng xuất</b></td>		
        <td  align="center" bgcolor="#afd7ff" height="22"><b>Thông tin máy tính truy cập</b></td>		
    </tr>
    <?php
    for ($i = 0; $i < count($login_history); $i++) {
        ?>	
        <tr>
            <td align="center" height="22" style="color:#333333;"><?= $i + 1 ?></td>
            <td height="22" style="padding-left:5px;color:#333333;">User: <?= $login_history[$i]['user_name'] ?><br/>IP: <?= $login_history[$i]['ip'] ?></td>
            <td style="padding-left:5px;color:#333333;">từ <?= date('d/m/Y H:i:s', $login_history[$i]['start_time']) ?><br/>đến <?= !empty($login_history[$i]['end_time']) ? date('d/m/Y H:i:s', $login_history[$i]['end_time']) : '(chưa đăng xuất)' ?></td>	
            <td style="padding-left:5px;line-height:22px;color:#333333;"><?= $login_history[$i]['agent'] ?></td>
        </tr>
        <?php
    }
    ?>
</table>

<?php
if ($action->eda_type != 'ajax') {
    $pro_page = ($count_dt > 30 * $action->eda_page ? 30 * $action->eda_page : $count_dt);
    $rows = ceil($count_dt / 30);
    if ($count_dt > 0) {
        echo '<table  width="98%"  cellSpacing=0 cellPadding=0 border="0"  style="border-collapse:collapse">
		<tr><td height="40" align="left" style="white-space:nowrap;"><b>Hiển thị ' . number_format(1 + 30 * ($action->eda_page - 1)) . '-' . number_format($pro_page) . '/' . number_format($count_dt) . ' truy cập (' . $action->eda_page . '/' . $rows . ' trang)</b></td><td align="right" style="padding-right:10px;white-space:nowrap;font-size:13px;">';
        if ($rows > 0) {
            echo '<b>Trang: </b>';
            $page = $rows;
            $start_page = $action->eda_page - 5;
            echo ' <a class="cart_payment" href="javascript:updatehsvp(1);">';
            if ($action->eda_page == 1)
                echo "<font color='blue' face='arial' style='font-size:13px;'><b>";
            echo "1";
            if ($action->eda_page == 1)
                echo "</b></font>";
            echo '</a> ';
            if ($start_page < 2)
                $start_page = 1;
            else
                echo " ... ";
            $end_page = $action->eda_page + 4;
            if ($end_page >= $page)
                $end_page = $page - 1;
            for ($i = $start_page; $i < $end_page; $i++) {
                echo ' <a style="font-size:13px;" class="cart_payment" href="javascript:updatehsvp(' . ($i + 1) . ');">';
                if ($action->eda_page == $i + 1)
                    echo "<font color='blue' face='arial' style='font-size:13px;'><b>";
                echo ($i + 1);
                if ($action->eda_page == $i + 1)
                    echo "</b></font>";
                echo '</a> ';
            }
            if ($action->eda_page + 5 < $page)
                echo " ... ";
            if ($page > 1) {
                echo ' <a style="font-size:13px;" class="cart_payment" href="javascript:updatehsvp(' . ($page) . ');">';
                if ($action->eda_page == $page)
                    echo "<font color='blue' face='arial' style='font-size:13px;'><b>";
                echo ($page);
                if ($action->eda_page == $page)
                    echo "</b></font>";
                echo '</a> ';
            }
        }

        echo '</td></tr></table>';
    }
}
?>
                    </td></tr>
</table>
<script language="javascript">
    function updatehsvp(p) {
        window.location='?eda_act=<?=md5('general')?>&eda_code=<?=md5('login_history')?>&eda_page='+p;
    }
</script>
<table width="100%" class="catbg" border="0" cellpadding="0" cellspacing="0" style="border-bottom:0px;border-left:0px;border-right:0px;">
    <tr>
        <td><input type="button" value="Xóa lịch sử truy cập" onclick="if(confirm('Bạn có chắc chắn muốn xóa lịch sử truy cập hệ thống không?')) window.location='?eda_act=<?=md5('general')?>&eda_code=<?=md5('login_history')?>&d=1';"/></td>
        <td height="30" align="right" style="padding-right:5px;"><img onclick="window.location='?';" style="cursor:pointer;" src="bms/images/icon/back.gif" height="18"/></td>
    </tr>
</table>