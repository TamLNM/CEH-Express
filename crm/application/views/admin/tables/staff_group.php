<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
    'staff_group_name',
    ];

$sIndexColumn = 'staff_groupid';
$sTable       = db_prefix().'staff_group';

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], [], ['staff_groupid']);
//print_r($result);die();
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    for ($i = 0; $i < count($aColumns); $i++) {
        $_data = $aRow[$aColumns[$i]];
        if ($aColumns[$i] == 'staff_group_name') {
            $_data            = '<a href="' . admin_url('staff_group/staff_group_manager/' . $aRow['staff_groupid']) . '" class="mbot10 display-block">' . $_data . '</a>';
        }
        $row[] = $_data;
    }

    $options = icon_btn('staff_group#staff_groupid=' . $aRow['staff_groupid'], 'pencil-square-o','','staff_groupid='.$aRow['staff_groupid']);
    $row[]   = $options .= icon_btn('staff_group/delete/' . $aRow['staff_groupid'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
