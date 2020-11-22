<?php
global $info;
if (isset($return_val["datefrom"])) {
    $sdate = explode("/", $return_val["datefrom"]);
    if ($sdate[0] > 0 && $sdate[0] <= 31 && $sdate[1] > 0 && $sdate[1] <= 12 && $sdate[2] <= date('Y')) {
        $sdate = mktime(0, 0, 0, $sdate[1], $sdate[0], $sdate[2]);
    } else {
        $sdate = 0;
    }
}
if (!isset($sdate)) {
    $sdate = 0;
}
if (isset($return_val["dateto"])) {
    $edate = explode("/", $return_val["dateto"]);
    if ($edate[0] > 0 && $edate[0] <= 31 && $edate[1] > 0 && $edate[1] <= 12 && $edate[2] <= date('Y')) {
        $edate = mktime(23, 59, 59, $edate[1], $edate[0], $edate[2]);
    } else {
        $edate = mktime(23, 59, 59, date('m'), date('d'), date('Y'));
    }
}
if (!isset($edate)) {
    $edate = mktime(23, 59, 59, date('m'), date('d'), date('Y'));
}
?>
<Script type="text/javascript" src="bms/common/CalendarPopup.js"></Script>
<script language="javaScript" id="jscal1x">
    var cal = new CalendarPopup("calendarpopup");
    cal.setTodayText("Hôm nay");
    cal.showNavigationDropdowns();
    cal.setYearSelectStartOffset(20);
    cal.setMonthNames("Tháng 1","Tháng 2","Tháng 3","Tháng 4","Tháng 5","Tháng 6","Tháng 7","Tháng 8","Tháng 9","Tháng 10","Tháng 11","Tháng 12");
    cal.setDayHeaders("CN","T2","T3","T4","T5","T6","T7");
</script>
<SCRIPT LANGUAGE="JavaScript">document.write(getCalendarStyles());</SCRIPT>
<DIV ID="calendarpopup" STYLE="position:absolute;visibility:hidden;background-color:white;layer-background-color:white;"></DIV>
<table width="100%" class="catbg" border="0" cellpadding="0" cellspacing="0" style="border-bottom:0px;border-left:0px;border-right:0px;">
    <tr>
        <td width="30" align="center">
            <img style="cursor:pointer;" src="bms/images/icon/documents.png" width="18" height="18"/>        
        </td>
        <td  height="25"><b>LỊCH SỬ TƯƠNG TÁC HỆ THỐNG</b></td>
        <td align="right" style="padding-right:5px;"><img onclick="window.location='?';" style="cursor:pointer;" src="bms/images/icon/back.gif" height="18"/></td>
    </tr>
</table>
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td height=5><img src="bms/images/spacer.gif" height=10></td>
    </tr>
</table>
<table align="center" width="98%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="60"><b>Từ ngày</b></td>
        <td width="70">
            <input readonly style="width:70px;" class="textbox"  onclick="cal.select(document.getElementById('datefrom'),'anchor1','dd/MM/yyyy');if(document.getElementById('datefrom').value==''){d = new Date(); CP_refreshCalendar(0,1+d.getMonth(),d.getFullYear())}; return false;" class="textbox" value="<?= isset($return_val['datefrom']) ? $return_val['datefrom'] : '' ?>" onBlur="check_date(this);" name="datefrom" id="datefrom" type="text" />
        </td><td width="20">
            <A href="javascript:void()" onclick="cal.select(document.getElementById('datefrom'),'anchor1','dd/MM/yyyy'); if(document.getElementById('datefrom').value==''){d = new Date(); CP_refreshCalendar(0,1+d.getMonth(),d.getFullYear())}; return false;"><img  NAME="anchor1" ID="anchor1" src="bms/images/icon/calendar.gif" height="18" border="0"></A>
        </td>
        <td width="70" style="padding-right:15px;" align="right"><b>Đến ngày</b></td>
        <td width="70">
            <input readonly style="width:70px;" class="textbox"  onclick="cal.select(document.getElementById('dateto'),'anchor2','dd/MM/yyyy');if(document.getElementById('dateto').value==''){d = new Date(); CP_refreshCalendar(0,1+d.getMonth(),d.getFullYear())}; return false;" class="textbox" value="<?= isset($return_val['dateto']) ? $return_val['dateto'] : date('d/m/Y') ?>" onBlur="check_date(this);" name="dateto" id="dateto" type="text" />
        </td> <td width="30">
            <A href="javascript:void()" onclick="cal.select(document.getElementById('dateto'),'anchor2','dd/MM/yyyy'); if(document.getElementById('dateto').value==''){d = new Date(); CP_refreshCalendar(0,1+d.getMonth(),d.getFullYear())}; return false;"><img  NAME="anchor2" ID="anchor2" src="bms/images/icon/calendar.gif" height="18" border="0"></A>
        </td>       
        <td style="padding-left:10px;"><input onclick="updatehsvp(1);" type="button" value="Xem" class="button"></td>
    </tr>
</table>    
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td height=5><img src="bms/images/spacer.gif" height=10></td>
    </tr>
</table>
<?php
$login_history = get_data("select l.*, u.user_name from logs l, users u  where l.start_time between $sdate and $edate and l.user_id=u.user_id  order by l.log_id desc limit " . (30 * ($action->eda_page - 1)) . ",30");
$count_dt = get_data("select count(*) c from logs  where start_time between $sdate and $edate");
$count_dt = $count_dt[0]['c'];
?>	
<table width="100%"  border="0" cellpadding="0" cellspacing="0"style="border-collapse: collapse; ">
    <tr><td  style="padding:10px;">
            <table align="center" bgcolor="#f0f0f0" width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#ffffff"  style="border-collapse:collapse;border:1px #dedede solid;">
                <tr>
                    <td width="8%" height="25" align="center" bgcolor="#afd7ff"><b>STT</b></td>
                    <td align="center" bgcolor="#afd7ff"><b>Hành động</b></td>		
                    <td width="50%" align="center" bgcolor="#afd7ff"><b>Thông tin người dùng</b></td>
                </tr>
                <?php
                for ($i = 0; $i < count($login_history); $i++) {
                    ?>	
                    <tr onmouseover="this.style.backgroundColor='yellow';" onmouseout="this.style.backgroundColor='';">
                        <td align="center" height="25" style="color:#333333;"><?= 50*($action->eda_page-1)+$i + 1 ?></td>
                        <td style="padding-left:5px;color:#333333;"><?= $login_history[$i]['action'] ?></td>	
                        <td height="22" title="<?= $login_history[$i]['agent'] ?>" style="padding-left:5px;color:#333333;line-height:18px;"><b><?= $login_history[$i]['user_name'] ?></b> (ip: <?= $login_history[$i]['ip'] ?> - <?=date('d/m/Y H:i',$login_history[$i]['start_time'])?>)<br/><?= $login_history[$i]['agent'] ?></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </td></tr>
</table>
<?php
if ($action->eda_type != 'ajax') {
    $pro_page = ($count_dt > 30 * $action->eda_page ? 30 * $action->eda_page : $count_dt);
    $rows = ceil($count_dt / 30);
    if ($count_dt > 0) {
        echo '<table  width="98%"  cellSpacing=0 cellPadding=0 border="0"  style="border-collapse:collapse">
		<tr><td height="40" align="left" style="white-space:nowrap;"><b>Hiển thị ' . number_format(1 + 30 * ($action->eda_page - 1)) . '-' . number_format($pro_page) . '/' . number_format($count_dt) . ' hành động (' . $action->eda_page . '/' . $rows . ' trang)</b></td><td align="right" style="padding-right:10px;white-space:nowrap;font-size:13px;">';
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
        window.location='?eda_act=<?=md5('general')?>&eda_code=<?=md5('log_history')?>&datefrom='+document.getElementById('datefrom').value+'&dateto='+document.getElementById('dateto').value+'&eda_page='+p;
    }
</script>  
<table width="100%" class="catbg" border="0" cellpadding="0" cellspacing="0" style="border-bottom:0px;border-left:0px;border-right:0px;">
    <tr>
        <?php
            if($sessions->get_session('user_name')=='admin') {
        ?>
        <td><input type="button" value="Xóa lịch sử tương tác" onclick="if(confirm('Bạn có chắc chắn muốn xóa lịch sử tương tác hệ thống không?')) window.location='?eda_act=<?=md5('general')?>&eda_code=<?=md5('log_history')?>&d=1';"/></td>
        <?php
            }
        ?>
        <td height="30" align="right" style="padding-right:5px;"><img onclick="window.location='?';" style="cursor:pointer;" src="bms/images/icon/back.gif" height="18"/></td>
    </tr>
</table>