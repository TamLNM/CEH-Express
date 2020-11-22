<?php

require_once 'bms/excel_classes/PHPExcel.php';
require_once 'bms/excel_classes/PHPExcel/IOFactory.php';

class excel_export {

    function export() {
        global $action;
        if (method_exists($this, $action->eda_module)) {
            $method = $action->eda_module;
            $this->$method();
        }
    }

    function output_inv() {
        global $return_val, $sessions, $head,$action;
        $inv = get_data("select inv.*, usr.full_name, cus.address, cus.cus_name, cus.tel from out_invoices inv, users usr, customers cus where inv.inv_id='" . $action->eda_id . "' and inv.user_id=usr.user_id and inv.cus_id=cus.cus_id");
        if (count($inv) > 0) {
            $inv = $inv[0];
            $mat = get_data("select invd.*, mat.mat_name, mat.mat_model, mat.mat_waranty,  mms.price mms_price, mms.price_dealer, msu.msu_name from out_invoice_details invd, stock_mat_msu smm, mat_msu mms, materials mat, meansure msu where invd.inv_id='" . $action->eda_id . "' and invd.smm_id=smm.smm_id and smm.mms_id=mms.mms_id and mms.mat_id=mat.mat_id and mms.msu_id=msu.msu_id");
        } else {
            echo 'Khong tim thay du lieu';
            exit;
        }
        $objPHPExcel = new PHPExcel();

        $objPHPExcel->getProperties()->setCreator("EDA")
                ->setLastModifiedBy("EDA")
                ->setTitle("Biên bản giao nhật hàng")
                ->setSubject("Biên bản giao nhật hàng")
                ->setDescription("Biên bản giao nhật hàng")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("EDA");

        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setName('Arial');
        $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(12);

        $objPHPExcel->getActiveSheet()->getStyle('A8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->mergeCells('A8:I8');
        $objPHPExcel->getActiveSheet()->getStyle('A8')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A8')->getFont()->setSize(18);
        $objPHPExcel->getActiveSheet()->setCellValue('A8', "BIÊN BẢN GIAO NHẬN HÀNG");
        if (!empty($head['logo']) && @empty($head['nologo'])) {
            $objDrawing = new PHPExcel_Worksheet_Drawing();
            $objDrawing->setName('Logo');
            $objDrawing->setDescription('Logo');
            $objDrawing->setPath(substr($head['logo'], 0, 1) == '/' ? substr($head['logo'], 1) : $head['logo']);
            $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
            $objPHPExcel->getActiveSheet()->mergeCells('C1:I6');
            $objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
            if (empty($head['nologoresize'])) {
                $objDrawing->setHeight(120);
                $title = html_entity_decode($head['head_title'], ENT_QUOTES, 'UTF-8');
                $title = str_replace("</p>", "</p>\n", $title);
                $title = str_replace("\n\n", "\n", $title);
                $title = strip_tags($title);
                $objPHPExcel->getActiveSheet()->setCellValue('C1', $title);
            } else {
                $objDrawing->setWidth(800);
            }
        } else {
            $objPHPExcel->getActiveSheet()->mergeCells('A1:I6');
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
            if (empty($head['nologoresize'])) {
                $title = html_entity_decode($head['head_title'], ENT_QUOTES, 'UTF-8');
                $title = strip_tags($title);
                $objPHPExcel->getActiveSheet()->setCellValue('A1', $title);
            }
        }

        $objPHPExcel->getActiveSheet()->setCellValue('A10', "Hôm nay, ngày ".date('d')." tháng ".date('m')." năm ".date('Y')." tại ".$inv['cus_name']);
        $objPHPExcel->getActiveSheet()->getStyle('A10')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('A11', "Chúng tôi gồm:");
        $objPHPExcel->getActiveSheet()->setCellValue('A13', "I- Bên nhận: ".$inv['cus_name']);
        $objPHPExcel->getActiveSheet()->getStyle('A13')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('A14', "Địa chỉ: ".$inv['address']);
        $objPHPExcel->getActiveSheet()->setCellValue('A15', "1. Đại diện:");
        $objPHPExcel->getActiveSheet()->setCellValue('E15', "Chức vụ:");
        $objPHPExcel->getActiveSheet()->setCellValue('G15', "Điện thoại:");
        $objPHPExcel->getActiveSheet()->setCellValue('A16', "2. Đại diện:");
        $objPHPExcel->getActiveSheet()->setCellValue('E16', "Chức vụ:");
        $objPHPExcel->getActiveSheet()->setCellValue('G16', "Điện thoại:");   
        $head_title = preg_replace('#<p(.*?)>(.*?)</p>#is', '$2[eda]', $head['head_title']);
        $head_title=  strip_tags($head_title);
        $head_title= str_replace(array("\r\n","\r","\n"),"",$head_title);
        $company=explode("[eda]", html_entity_decode($head_title,ENT_COMPAT,'UTF-8'));
        $objPHPExcel->getActiveSheet()->setCellValue('A18', "II- Bên giao: ".$company[0]);
        $objPHPExcel->getActiveSheet()->getStyle('A18')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('A19', "Địa chỉ: ".(empty($company[1])?"":$company[1]));
        $objPHPExcel->getActiveSheet()->setCellValue('A20', "1. Đại diện:");
        $objPHPExcel->getActiveSheet()->setCellValue('E20', "Chức vụ:");
        $objPHPExcel->getActiveSheet()->setCellValue('G20', "Điện thoại:");        
        $objPHPExcel->getActiveSheet()->setCellValue('A21', "2. Đại diện:");
        $objPHPExcel->getActiveSheet()->setCellValue('E21', "Chức vụ:");
        $objPHPExcel->getActiveSheet()->setCellValue('G21', "Điện thoại:");        
        $objPHPExcel->getActiveSheet()->setCellValue('A23', "III- Nội dung giao nhận");
        $objPHPExcel->getActiveSheet()->getStyle('A23')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->getStyle('A27:I27')->applyFromArray(
                array(
                    'font' => array(
                        'bold' => true
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    ),
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'AFD7FF')
                    )
                )
        );
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(13);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(18);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(9);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(9);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(13);

        $objPHPExcel->getActiveSheet()->getStyle('A27:A' . (27 + count($mat)))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A27:I' . (27 + count($mat)))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A27:I' . (27 + count($mat)))->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('D28:D' . (28 + count($mat)))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('H28:H' . (28 + count($mat)))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->setCellValue('A27', 'STT');
        $objPHPExcel->getActiveSheet()->setCellValue('B27', 'Số đơn hàng');
        $objPHPExcel->getActiveSheet()->setCellValue('C27', 'Sản phẩm');
        $objPHPExcel->getActiveSheet()->setCellValue('D27', 'Đơn vị');
        $objPHPExcel->getActiveSheet()->setCellValue('E27', 'Số lượng');
        $objPHPExcel->getActiveSheet()->setCellValue('F27', 'Ghi chú');
        if(empty($_GET['chkprice'])) {
            $objPHPExcel->getActiveSheet()->setCellValue('G27', 'Đơn giá');
            $objPHPExcel->getActiveSheet()->setCellValue('H27', 'VAT (%)');
            $objPHPExcel->getActiveSheet()->setCellValue('I27', 'Thành tiền');
        } else {
            $objPHPExcel->getActiveSheet()->mergeCells('F27:I27');
        }

        $objPHPExcel->getActiveSheet()->getStyle('A27:I' . ((empty($_GET['chkprice'])?28:27) + count($mat)))->applyFromArray(
                array(
                    'font' => array(
                        'size' => 12
                    ),
                    'borders' => array(
                        'outline' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        ),
                        'inside' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                )
        );
        $total = 0;
        for ($i = 0; $i < count($mat); $i++) {         
            $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i + 28), $i + 1);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 28), '');
            $objPHPExcel->getActiveSheet()->setCellValue('C' . ($i + 28), $mat[$i]['mat_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . ($i + 28), $mat[$i]['msu_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . ($i + 28), $mat[$i]['mat_quantity']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . ($i + 28), '');
            if(empty($_GET['chkprice'])) {
                $price = intval(100 * $mat[$i]['amount'] / $mat[$i]['mat_quantity'] / (100 + $mat[$i]['vat']));
                $objPHPExcel->getActiveSheet()->setCellValue('G' . ($i + 28), $price);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . ($i + 28), $mat[$i]['vat']);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . ($i + 28), $mat[$i]['amount']);
                $objPHPExcel->getActiveSheet()->getStyle('G' . ($i + 28))->getNumberFormat()->setFormatCode('#,##0');
                $objPHPExcel->getActiveSheet()->getStyle('H' . ($i + 28))->getNumberFormat()->setFormatCode('#,##0.##');
                $objPHPExcel->getActiveSheet()->getStyle('I' . ($i + 28))->getNumberFormat()->setFormatCode('#,##0');
                $total+=$mat[$i]['amount'];                
            } else {
                $objPHPExcel->getActiveSheet()->mergeCells('F' . ($i + 28) . ':I' . ($i + 28));
            }

            $objPHPExcel->getActiveSheet()->getStyle('E' . ($i + 28))->getNumberFormat()->setFormatCode('#,##0');
        }
        if(empty($_GET['chkprice'])) {
            $objPHPExcel->getActiveSheet()->mergeCells('A' . (28 + count($mat)) . ':H' . ($i + 28));
            $objPHPExcel->getActiveSheet()->setCellValue('A' . (28 + count($mat)), "Tổng cộng");
            $objPHPExcel->getActiveSheet()->setCellValue('I' . (28 + count($mat)), $total);
            $objPHPExcel->getActiveSheet()->getStyle('I' . (28 + count($mat)))->getNumberFormat()->setFormatCode('#,##0');
            $objPHPExcel->getActiveSheet()->getStyle('A' . (28 + count($mat)))->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('I' . (28 + count($mat)))->getFont()->setBold(true);
        }
        
        $objPHPExcel->getActiveSheet()->setCellValue('A' . ((empty($_GET['chkprice'])?30:29) + count($mat)), " - Hàng mới 100%.");
        $objPHPExcel->getActiveSheet()->getStyle('A' . ((empty($_GET['chkprice'])?30:29) + count($mat)))->getFont()->setBold(true);
        
        $objPHPExcel->getActiveSheet()->setCellValue('B' . (32 + count($mat)), "Đại Diện Bên Nhận Hàng");
        $objPHPExcel->getActiveSheet()->getStyle('B' . (32 + count($mat)))->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('G' . (32 + count($mat)), "Đại Diện Bên Giao Hàng");
        $objPHPExcel->getActiveSheet()->getStyle('G' . (32 + count($mat)))->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&BBiên bản giao nhận hàng&R ');
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RTrang &P / &N');

        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
        $pageMargins = $objPHPExcel->getActiveSheet()->getPageMargins();
        // margin is set in inches (0.5cm)
        $margin = 0.5 / 2.54;

        $pageMargins->setTop($margin);
        $pageMargins->setBottom($margin);
        $pageMargins->setLeft($margin);
        $pageMargins->setRight($margin);
        
        $objPHPExcel->getActiveSheet()->setTitle('BanHang');
        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="BienBanGiaoNhan.xls"');
        $objWriter->save('php://output');
    }
    
    function output() {
        global $return_val, $sessions, $head;
        if (isset($return_val["datefrom"])) {
            $sdate = explode("/", $return_val["datefrom"]);
            if ($sdate[0] > 0 && $sdate[0] <= 31 && $sdate[1] > 0 && $sdate[1] <= 12 && $sdate[2] <= date('Y')) {
                $sdate = mktime(0, 0, 0, $sdate[1], $sdate[0], $sdate[2]);
            }
        }
        if (!isset($sdate)) {
            $sdate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
            $return_val["datefrom"] = date('d/m/Y', $sdate);
        }
        if (isset($return_val["dateto"])) {
            $edate = explode("/", $return_val["dateto"]);
            if ($edate[0] > 0 && $edate[0] <= 31 && $edate[1] > 0 && $edate[1] <= 12 && $edate[2] <= date('Y')) {
                $edate = mktime(23, 59, 59, $edate[1], $edate[0], $edate[2]);
            }
        }
        if (!isset($edate)) {
            $edate = mktime(23, 59, 59, date('m'), date('d'), date('Y'));
        }
        if (!isset($return_val['cus_chk'])) {
            $return_val['cus_chk'] = 0;
        }

        $chk_mainstock = get_data("select ugp.ugp_id from user_group_permission ugp, function_menu fmenu where (ugp.user_id='" . $sessions->get_session("user_id") . "' or ugp.group_id='" . $sessions->get_session("group_id") . "') and ugp.fmenu_id=fmenu.fmenu_id and fmenu_act='mainstock'");
        $chk_empstock = get_data("select ugp.ugp_id from user_group_permission ugp, function_menu fmenu where (ugp.user_id='" . $sessions->get_session("user_id") . "' or ugp.group_id='" . $sessions->get_session("group_id") . "') and ugp.fmenu_id=fmenu.fmenu_id and fmenu_act='empstock'");
        if (count($chk_mainstock) > 0 && count($chk_empstock) > 0) {
            $stock_where = "";
        } else if (count($chk_mainstock) > 0) {
            $stock_where = " and smm.stock_id in (select stock_id from stocks where user_id is null or user_id='" . $sessions->get_session('user_id') . "')";
        } else {
            $stock_where = " and smm.stock_id in (select stock_id from stocks where user_id='" . $sessions->get_session('user_id') . "')";
        }
        $inv = get_data("select cat.cat_name, inv.inv_id,inv.max_time, msu.msu_name, inv.inv_code, inv.created_date, inv.cus_id, usr.full_name, mat.mat_name, cus.cus_name, invd.vat,  invd.amount, invd.mat_quantity 
                                    from out_invoices inv, users usr, customers cus, out_invoice_details invd, stock_mat_msu smm, mat_msu mms, materials mat, categories cat, meansure msu  
                                    where inv.inv_type=0 and  inv.inv_id=invd.inv_id and  invd.smm_id=smm.smm_id " . (!empty($return_val['stock_id']) ? "  
                                    and smm.stock_id=" . $return_val['stock_id'] : $stock_where) . " and smm.mms_id=mms.mms_id and mms.mat_id=mat.mat_id " . (!empty($return_val['cat_id']) ? "  
                                    and mat.cat_id=" . $return_val['cat_id'] : "") . (!empty($return_val['user_id']) ? " and inv.user_id='" . $return_val['user_id'] . "' " : "") . " 
                                    and inv.cus_id=cus.cus_id and inv.user_id=usr.user_id and inv.created_date between " . $sdate . " and " . $edate . " 
                                    " . ($return_val['cus_chk'] == 1 ? " and cus.cus_name like '%Khách lẻ%'" : '') . " and mat.cat_id=cat.cat_id and mms.msu_id=msu.msu_id
                                    order by inv.created_date desc");
        $objPHPExcel = new PHPExcel();

        $objPHPExcel->getProperties()->setCreator("EDA")
                ->setLastModifiedBy("EDA")
                ->setTitle("Báo cáo bán hàng từ " . date('d/m/Y', $sdate) . " đến" . date('d/m/Y', $edate))
                ->setSubject("Báo cáo bán hàng từ " . date('d/m/Y', $sdate) . " đến" . date('d/m/Y', $edate))
                ->setDescription("Báo cáo bán hàng từ " . date('d/m/Y', $sdate) . " đến" . date('d/m/Y', $edate))
                ->setKeywords("office 2007 openxml php")
                ->setCategory("EDA");

        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setName('Arial');
        $objPHPExcel->getActiveSheet()->getStyle('A9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->mergeCells('A9:M9');
        $objPHPExcel->getActiveSheet()->getStyle('A9')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('A9', "BÁO CÁO BÁN HÀNG TỪ " . date('d/m/Y', $sdate) . " ĐẾN " . date('d/m/Y', $edate));

        if (!empty($head['logo']) && @empty($head['nologo'])) {
            $objDrawing = new PHPExcel_Worksheet_Drawing();
            $objDrawing->setName('Logo');
            $objDrawing->setDescription('Logo');
            $objDrawing->setPath(substr($head['logo'], 0, 1) == '/' ? substr($head['logo'], 1) : $head['logo']);
            $objDrawing->setHeight(120);
            $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
            $objPHPExcel->getActiveSheet()->mergeCells('C1:L5');
            $objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
            if (empty($head['nologoresize'])) {
                $title = html_entity_decode($head['head_title'], ENT_QUOTES, 'UTF-8');
                $title = str_replace("</p>", "</p>\n", $title);
                $title = str_replace("\n\n", "\n", $title);
                $title = strip_tags($title);
                $objPHPExcel->getActiveSheet()->setCellValue('C1', $title);
            }
        } else {
            $objPHPExcel->getActiveSheet()->mergeCells('A1:M5');
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
            if (empty($head['nologoresize'])) {
                $title = html_entity_decode($head['head_title'], ENT_QUOTES, 'UTF-8');
                $title = strip_tags($title);
                $objPHPExcel->getActiveSheet()->setCellValue('A1', $title);
            }
        }

        $stock = get_data("select stock_name from stocks where  stock_id='" . $return_val['stock_id'] . "'");
        if (count($stock) > 0) {
            $objPHPExcel->getActiveSheet()->setCellValue('A10', "Kho hàng: " . $stock[0]['stock_name']);
        }
        $objPHPExcel->getActiveSheet()->getStyle('A12:M12')->applyFromArray(
                array(
                    'font' => array(
                        'bold' => true
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    ),
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,                    
                        'color' => array('rgb' => 'AFD7FF')
                    )
                )
        );
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(22);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getStyle('A12:A' . (12 + count($inv)))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A12:M' . (12 + count($inv)))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A12:M' . (12 + count($inv)))->getAlignment()->setWrapText(true);

        $objPHPExcel->getActiveSheet()->setCellValue('A12', 'STT');
        $objPHPExcel->getActiveSheet()->setCellValue('B12', 'Mã phiếu');
        $objPHPExcel->getActiveSheet()->setCellValue('C12', 'Thời gian');
        $objPHPExcel->getActiveSheet()->setCellValue('D12', 'Hạn thanh toán');
        $objPHPExcel->getActiveSheet()->setCellValue('E12', 'Người bán');
        $objPHPExcel->getActiveSheet()->setCellValue('F12', 'Khách hàng');
        $objPHPExcel->getActiveSheet()->setCellValue('G12', 'Sản phẩm');
        $objPHPExcel->getActiveSheet()->setCellValue('H12', 'Danh mục hàng hóa');
        $objPHPExcel->getActiveSheet()->setCellValue('I12', 'SL');
        $objPHPExcel->getActiveSheet()->setCellValue('J12', 'Đơn vị');
        $objPHPExcel->getActiveSheet()->setCellValue('K12', 'Đơn giá');
        $objPHPExcel->getActiveSheet()->setCellValue('L12', 'VAT (%)');
        $objPHPExcel->getActiveSheet()->setCellValue('M12', 'Thành tiền');        


        $objPHPExcel->getActiveSheet()->getStyle('A12:M' . (13 + count($inv)))->applyFromArray(
                array(
                    'font' => array(
                        'size' => 10
                    ),
                    'borders' => array(
                        'outline' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        ),
                        'inside' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                )
        );
        $total = 0;
        for ($i = 0; $i < count($inv); $i++) {
            $price = intval(100 * $inv[$i]['amount'] / $inv[$i]['mat_quantity'] / (100 + $inv[$i]['vat']));
            $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i + 13), $i + 1);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 13), $inv[$i]['inv_code']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . ($i + 13), PHPExcel_Shared_Date::PHPToExcel($inv[$i]['created_date'] + 7 * 3600));
            $objPHPExcel->getActiveSheet()->setCellValue('D' . ($i + 13), PHPExcel_Shared_Date::PHPToExcel($inv[$i]['max_time'] + 7 * 3600));
            $objPHPExcel->getActiveSheet()->setCellValue('E' . ($i + 13), $inv[$i]['full_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . ($i + 13), $inv[$i]['cus_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . ($i + 13), $inv[$i]['mat_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . ($i + 13), $inv[$i]['cat_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . ($i + 13), $inv[$i]['mat_quantity']);
            $objPHPExcel->getActiveSheet()->setCellValue('J' . ($i + 13), $inv[$i]['msu_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('K' . ($i + 13), $price);
            $objPHPExcel->getActiveSheet()->setCellValue('L' . ($i + 13), $inv[$i]['vat']);
            $objPHPExcel->getActiveSheet()->setCellValue('M' . ($i + 13), $inv[$i]['amount']);
            $objPHPExcel->getActiveSheet()->getStyle('I' . ($i + 13))->getNumberFormat()->setFormatCode('#,##0');
            $objPHPExcel->getActiveSheet()->getStyle('K' . ($i + 13))->getNumberFormat()->setFormatCode('#,##0');
            $objPHPExcel->getActiveSheet()->getStyle('M' . ($i + 13))->getNumberFormat()->setFormatCode('#,##0');
            $objPHPExcel->getActiveSheet()->getStyle('L' . ($i + 13))->getNumberFormat()->setFormatCode('#,##0.##');
            $objPHPExcel->getActiveSheet()->getStyle('C' . ($i + 13))->getNumberFormat()->setFormatCode('DD/MM/YY HH:MM');
            $objPHPExcel->getActiveSheet()->getStyle('D' . ($i + 13))->getNumberFormat()->setFormatCode('DD/MM/YY HH:MM');
            $total+=$inv[$i]['amount'];
        }
        $objPHPExcel->getActiveSheet()->mergeCells('A' . (13 + count($inv)) . ':L' . ($i + 13));
        $objPHPExcel->getActiveSheet()->setCellValue('A' . (13 + count($inv)), "Tổng cộng");
        $objPHPExcel->getActiveSheet()->setCellValue('M' . (13 + count($inv)), $total);
        $objPHPExcel->getActiveSheet()->getStyle('M' . (13 + count($inv)))->getNumberFormat()->setFormatCode('#,##0');
        $objPHPExcel->getActiveSheet()->getStyle('A' . (13 + count($inv)))->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('M' . (13 + count($inv)))->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&BBáo cáo bán hàng&RTừ ' . date('d/m/Y', $sdate) . " đến " . date('d/m/Y', $edate));
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');

        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

        $objPHPExcel->getActiveSheet()->setTitle('BanHang');
        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="ThongKeBanHang.xls"');
        $objWriter->save('php://output');
    }

    function input() {
        global $return_val, $sessions, $head;
        if (isset($return_val["datefrom"])) {
            $sdate = explode("/", $return_val["datefrom"]);
            if ($sdate[0] > 0 && $sdate[0] <= 31 && $sdate[1] > 0 && $sdate[1] <= 12 && $sdate[2] <= date('Y')) {
                $sdate = mktime(0, 0, 0, $sdate[1], $sdate[0], $sdate[2]);
            }
        }
        if (!isset($sdate)) {
            $sdate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
            $return_val["datefrom"] = date('d/m/Y', $sdate);
        }
        if (isset($return_val["dateto"])) {
            $edate = explode("/", $return_val["dateto"]);
            if ($edate[0] > 0 && $edate[0] <= 31 && $edate[1] > 0 && $edate[1] <= 12 && $edate[2] <= date('Y')) {
                $edate = mktime(23, 59, 59, $edate[1], $edate[0], $edate[2]);
            }
        }
        if (!isset($edate)) {
            $edate = mktime(23, 59, 59, date('m'), date('d'), date('Y'));
        }
        $where = '';
        if (!check_func('view_input_all')) {
            $where.=" and inv.created_user='" . $sessions->get_session('user_id') . "'";
        }
        if (!empty($return_val['keyword']) && $return_val['keyword'] != 'Mã phiếu hoặc mã nhà CC') {
            $where.=" and (inv.inv_code='" . $return_val['keyword'] . "' or sup.sup_code='" . $return_val['keyword'] . "')";
            $inv = get_data("select mat.mat_name, cat.cat_name, msu.msu_name, invd.mat_quantity, inv.inv_id, inv.inv_code, inv.comment, inv.created_date, usr.full_name, sup.sup_name,  invd.amount from invoices inv, supliers sup, invoice_details invd, users usr, categories cat, meansure msu  where inv.inv_type=1 and  inv.inv_id=invd.inv_id  and inv.sup_id=sup.sup_id and inv.user_id=usr.user_id " . $where . " and mat.cat_id=cat.cat_id and mms.msu_id=msu.msu_id order by inv.created_date desc");
        } else {
            $inv = get_data("select mat.mat_name, cat.cat_name, msu.msu_name, invd.mat_quantity, inv.inv_id, inv.inv_code, inv.comment, inv.created_date, usr.full_name, sup.sup_name,  invd.amount from invoices inv, users usr, supliers sup, invoice_details invd, mat_msu mms, materials mat, categories cat, meansure msu  where inv.inv_type=1 " . (!empty($return_val['stock_id']) ? "  and invd.stock_id=" . $return_val['stock_id'] : "") . $where . " and  inv.inv_id=invd.inv_id and invd.mms_id=mms.mms_id and mms.mat_id=mat.mat_id " . (!empty($return_val['cat_id']) ? "  and mat.cat_id=" . $return_val['cat_id'] : "") . (!empty($return_val['sup_id']) ? " and inv.sup_id='" . $return_val['sup_id'] . "' " : "") . " and inv.sup_id=sup.sup_id and inv.user_id=usr.user_id and inv.created_date between " . $sdate . " and " . $edate . " and mat.cat_id=cat.cat_id and mms.msu_id=msu.msu_id order by inv.created_date desc");
        }

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("EDA")
                ->setLastModifiedBy("EDA")
                ->setTitle("Báo cáo nhập hàng từ " . date('d/m/Y', $sdate) . " đến" . date('d/m/Y', $edate))
                ->setSubject("Báo cáo nhập hàng từ " . date('d/m/Y', $sdate) . " đến" . date('d/m/Y', $edate))
                ->setDescription("Báo cáo nhập hàng từ " . date('d/m/Y', $sdate) . " đến" . date('d/m/Y', $edate))
                ->setKeywords("office 2007 openxml php")
                ->setCategory("EDA");

        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setName('Arial');
        $objPHPExcel->getActiveSheet()->getStyle('A9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->mergeCells('A9:K9');
        $objPHPExcel->getActiveSheet()->getStyle('A9')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('A9', "BÁO CÁO NHẬP HÀNG TỪ " . date('d/m/Y', $sdate) . " ĐẾN " . date('d/m/Y', $edate));
        if (!empty($head['logo']) && @empty($head['nologo'])) {
            $objDrawing = new PHPExcel_Worksheet_Drawing();
            $objDrawing->setName('Logo');
            $objDrawing->setDescription('Logo');
            $objDrawing->setPath(substr($head['logo'], 0, 1) == '/' ? substr($head['logo'], 1) : $head['logo']);
            $objDrawing->setHeight(120);
            $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
            $objPHPExcel->getActiveSheet()->mergeCells('C1:K5');
            $objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
            if (empty($head['nologoresize'])) {
                $title = html_entity_decode($head['head_title'], ENT_QUOTES, 'UTF-8');
                $title = str_replace("</p>", "</p>\n", $title);
                $title = str_replace("\n\n", "\n", $title);
                $title = strip_tags($title);
                $objPHPExcel->getActiveSheet()->setCellValue('C1', $title);
            }
        } else {
            $objPHPExcel->getActiveSheet()->mergeCells('A1:K5');
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
            if (empty($head['nologoresize'])) {
                $title = html_entity_decode($head['head_title'], ENT_QUOTES, 'UTF-8');
                $title = strip_tags($title);
                $objPHPExcel->getActiveSheet()->setCellValue('A1', $title);
            }
        }
        $stock = get_data("select stock_name from stocks where  stock_id='" . $return_val['stock_id'] . "'");
        if (count($stock) > 0) {
            $objPHPExcel->getActiveSheet()->setCellValue('A10', "Kho hàng: " . $stock[0]['stock_name']);
        }
        $objPHPExcel->getActiveSheet()->getStyle('A12:K12')->applyFromArray(
                array(
                    'font' => array(
                        'bold' => true
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    ),
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'AFD7FF')
                    )
                )
        );

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(22);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);

        $objPHPExcel->getActiveSheet()->getStyle('A12:A' . (12 + count($inv)))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A12:K' . (12 + count($inv)))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A12:K' . (12 + count($inv)))->getAlignment()->setWrapText(true);

        $objPHPExcel->getActiveSheet()->setCellValue('A12', 'STT');
        $objPHPExcel->getActiveSheet()->setCellValue('B12', 'Mã phiếu');
        $objPHPExcel->getActiveSheet()->setCellValue('C12', 'Thời gian');
        $objPHPExcel->getActiveSheet()->setCellValue('D12', 'Người nhập');
        $objPHPExcel->getActiveSheet()->setCellValue('E12', 'Nhà cung cấp');
        $objPHPExcel->getActiveSheet()->setCellValue('F12', 'Sản phẩm');
        $objPHPExcel->getActiveSheet()->setCellValue('G12', 'Danh mục hàng hóa');
        $objPHPExcel->getActiveSheet()->setCellValue('H12', 'SL');
        $objPHPExcel->getActiveSheet()->setCellValue('I12', 'Đơn vị');
        $objPHPExcel->getActiveSheet()->setCellValue('J12', 'Đơn giá');
        $objPHPExcel->getActiveSheet()->setCellValue('K12', 'Thành tiền');

        $objPHPExcel->getActiveSheet()->getStyle('A12:K' . (13 + count($inv)))->applyFromArray(
                array(
                    'font' => array(
                        'size' => 10
                    ),
                    'borders' => array(
                        'outline' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        ),
                        'inside' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                )
        );
        $total = 0;
        for ($i = 0; $i < count($inv); $i++) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i + 13), $i + 1);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 13), $inv[$i]['inv_code']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . ($i + 13), PHPExcel_Shared_Date::PHPToExcel($inv[$i]['created_date'] + 7 * 3600));
            $objPHPExcel->getActiveSheet()->setCellValue('D' . ($i + 13), $inv[$i]['full_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . ($i + 13), $inv[$i]['sup_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . ($i + 13), $inv[$i]['mat_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . ($i + 13), $inv[$i]['cat_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . ($i + 13), $inv[$i]['mat_quantity']);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . ($i + 13), $inv[$i]['msu_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('J' . ($i + 13), $inv[$i]['amount'] / $inv[$i]['mat_quantity']);
            $objPHPExcel->getActiveSheet()->setCellValue('K' . ($i + 13), $inv[$i]['amount']);
            $objPHPExcel->getActiveSheet()->getStyle('H' . ($i + 13))->getNumberFormat()->setFormatCode('#,##0');
            $objPHPExcel->getActiveSheet()->getStyle('J' . ($i + 13))->getNumberFormat()->setFormatCode('#,##0');
            $objPHPExcel->getActiveSheet()->getStyle('K' . ($i + 13))->getNumberFormat()->setFormatCode('#,##0');
            $objPHPExcel->getActiveSheet()->getStyle('C' . ($i + 13))->getNumberFormat()->setFormatCode('DD/MM/YY HH:MM');
            $total+=$inv[$i]['amount'];
        }
        $objPHPExcel->getActiveSheet()->mergeCells('A' . (13 + count($inv)) . ':J' . ($i + 13));
        $objPHPExcel->getActiveSheet()->setCellValue('A' . (13 + count($inv)), "Tổng cộng");
        $objPHPExcel->getActiveSheet()->setCellValue('K' . (13 + count($inv)), $total);
        $objPHPExcel->getActiveSheet()->getStyle('K' . (13 + count($inv)))->getNumberFormat()->setFormatCode('#,##0');
        $objPHPExcel->getActiveSheet()->getStyle('A' . (13 + count($inv)))->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('K' . (13 + count($inv)))->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&BBáo cáo nhập hàng&RTừ ' . date('d/m/Y', $sdate) . " đến " . date('d/m/Y', $edate));
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');

        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $objPHPExcel->getActiveSheet()->setTitle('NhapHang');
        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="ThongKeNhapHang.xls"');
        $objWriter->save('php://output');
    }

    function instock() {
        global $return_val, $sessions, $head;
        if (isset($return_val["dateto"])) {
            $edate = explode("/", $return_val["dateto"]);
            if ($edate[0] > 0 && $edate[0] <= 31 && $edate[1] > 0 && $edate[1] <= 12 && $edate[2] <= date('Y')) {
                $edate = mktime(23, 59, 59, $edate[1], $edate[0], $edate[2]);
            }
        }
        if (!isset($edate)) {
            $edate = mktime(23, 59, 59, date('m'), date('d'), date('Y'));
        }
        $chk_mainstock = get_data("select ugp.ugp_id from user_group_permission ugp, function_menu fmenu where (ugp.user_id='" . $sessions->get_session("user_id") . "' or ugp.group_id='" . $sessions->get_session("group_id") . "') and ugp.fmenu_id=fmenu.fmenu_id and fmenu_act='mainstock'");
        $chk_empstock = get_data("select ugp.ugp_id from user_group_permission ugp, function_menu fmenu where (ugp.user_id='" . $sessions->get_session("user_id") . "' or ugp.group_id='" . $sessions->get_session("group_id") . "') and ugp.fmenu_id=fmenu.fmenu_id and fmenu_act='empstock'");
        if (count($chk_mainstock) > 0 && count($chk_empstock) > 0) {
            $stock_where = "";
        } else if (count($chk_mainstock) > 0) {
            $stock_where = " and smm.stock_id in (select stock_id from stocks where user_id is null or user_id='" . $sessions->get_session('user_id') . "')";
        } else {
            $stock_where = " and smm.stock_id in (select stock_id from stocks where user_id='" . $sessions->get_session('user_id') . "')";
        }
        $has="";
        if(@$return_val['mat_status']=="con")
            $has =" HAVING sum(smm.quantity) > 0";
        if(@$return_val['mat_status']=="het")
            $has =" HAVING sum(smm.quantity) <= 0";
        $mat = get_data("select stock.stock_id, stock.stock_name, mat.mat_name, cat.cat_name, msu.msu_name, mms.mms_id, mat.mat_id, msu.msu_id, mat.mat_model, sum(smm.quantity) quantity from stocks stock,materials mat, categories cat, stock_mat_msu smm, mat_msu mms, meansure msu  where stock.stock_id=smm.stock_id and cat.cat_id=mat.cat_id " . (!empty($_GET['mat_name']) ? " and mat.mat_name like '%" . $_GET['mat_name'] . "%'" : "") . " " . (!empty($_GET['cat_id']) ? " and mat.cat_id = '" . $_GET['cat_id'] . "'" : "") . (!empty($_GET['stock_id']) ? " and smm.stock_id = '" . $_GET['stock_id'] . "'" : $stock_where) . " and mat.mat_id=mms.mat_id and mms.msu_id=msu.msu_id and mms.mms_id=smm.mms_id group by mms.mms_id,stock.stock_id {$has} order by mat.mat_name");
//print_r($mat);die();
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("EDA")
                ->setLastModifiedBy("EDA")
                ->setTitle("Báo cáo hàng tồn đến" . date('d/m/Y', $edate))
                ->setSubject("Báo cáo hàng tồn đến" . date('d/m/Y', $edate))
                ->setDescription("Báo cáo hàng tồn đến" . date('d/m/Y', $edate))
                ->setKeywords("office 2007 openxml php")
                ->setCategory("EDA");

        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setName('Arial');
        $objPHPExcel->getActiveSheet()->getStyle('A9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->mergeCells('A9:K9');
        $objPHPExcel->getActiveSheet()->getStyle('A9')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('A9', "BÁO CÁO HÀNG TỒN ĐẾN " . date('d/m/Y', $edate));
        if (!empty($head['logo']) && @empty($head['nologo'])) {
            $objDrawing = new PHPExcel_Worksheet_Drawing();
            $objDrawing->setName('Logo');
            $objDrawing->setDescription('Logo');
            $objDrawing->setPath(substr($head['logo'], 0, 1) == '/' ? substr($head['logo'], 1) : $head['logo']);
            $objDrawing->setHeight(120);
            $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
            $objPHPExcel->getActiveSheet()->mergeCells('C1:K5');
            $objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
            if (empty($head['nologoresize'])) {
                $title = html_entity_decode($head['head_title'], ENT_QUOTES, 'UTF-8');
                $title = str_replace("</p>", "</p>\n", $title);
                $title = str_replace("\n\n", "\n", $title);
                $title = strip_tags($title);
                $objPHPExcel->getActiveSheet()->setCellValue('C1', $title);
            }
        } else {
            $objPHPExcel->getActiveSheet()->mergeCells('A1:K5');
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
            if (empty($head['nologoresize'])) {
                $title = html_entity_decode($head['head_title'], ENT_QUOTES, 'UTF-8');
                $title = strip_tags($title);
                $objPHPExcel->getActiveSheet()->setCellValue('A1', $title);
            }
        }
        $stock = get_data("select stock_name from stocks where  stock_id='" . $return_val['stock_id'] . "'");
        if (count($stock) > 0) {
            $objPHPExcel->getActiveSheet()->setCellValue('A10', "Kho hàng: " . $stock[0]['stock_name']);
        }
        $objPHPExcel->getActiveSheet()->getStyle('A12:L13')->applyFromArray(
                array(
                    'font' => array(
                        'bold' => true
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    ),
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'AFD7FF')
                    )
                )
        );

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(12);

        $objPHPExcel->getActiveSheet()->getStyle('A12:A' . (13 + count($mat)))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A12:L' . (13 + count($mat)))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A12:L' . (13 + count($mat)))->getAlignment()->setWrapText(true);

        $objPHPExcel->getActiveSheet()->setCellValue('A12', 'STT');
        $objPHPExcel->getActiveSheet()->mergeCells('A12:A13');
        $objPHPExcel->getActiveSheet()->setCellValue('B12', 'Tên sản phẩm');
        $objPHPExcel->getActiveSheet()->mergeCells('B12:B13');
        $objPHPExcel->getActiveSheet()->setCellValue('C12', 'Mã sản phẩm');
        $objPHPExcel->getActiveSheet()->mergeCells('C12:C13');
        $objPHPExcel->getActiveSheet()->setCellValue('D12', 'Danh mục hàng hóa');
        $objPHPExcel->getActiveSheet()->mergeCells('D12:D13');
        $objPHPExcel->getActiveSheet()->setCellValue('E12', 'Tồn đầu kỳ');
        $objPHPExcel->getActiveSheet()->mergeCells('E12:E13');
        $objPHPExcel->getActiveSheet()->setCellValue('F12', 'Tồn trong kỳ');
        $objPHPExcel->getActiveSheet()->mergeCells('F12:H12');
        $objPHPExcel->getActiveSheet()->setCellValue('I12', 'Tồn cuối kỳ');
        $objPHPExcel->getActiveSheet()->mergeCells('I12:I13');
        $objPHPExcel->getActiveSheet()->setCellValue('J12', 'Đơn vị');
        $objPHPExcel->getActiveSheet()->mergeCells('J12:J13');
        $objPHPExcel->getActiveSheet()->setCellValue('K12', 'Thành tiền');
        $objPHPExcel->getActiveSheet()->mergeCells('K12:K13');
        $objPHPExcel->getActiveSheet()->setCellValue('L12', 'Kho chứa');
        $objPHPExcel->getActiveSheet()->mergeCells('L12:L13');

        $objPHPExcel->getActiveSheet()->setCellValue('F13', 'Nhập');
        $objPHPExcel->getActiveSheet()->setCellValue('G13', 'Xuất');
        $objPHPExcel->getActiveSheet()->setCellValue('H13', 'Tồn');


        $objPHPExcel->getActiveSheet()->getStyle('A12:L' . (14 + count($mat)))->applyFromArray(
                array(
                    'font' => array(
                        'size' => 10
                    ),
                    'borders' => array(
                        'outline' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        ),
                        'inside' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                )
        );
        $total = 0;
        $i = 0;
        $chk_priv = check_func('view_input_price');
        include("bms/modules/sell.php");
        $sell = new sell();
        for ($j = 0; $j < count($mat); $j++) {
            $q = $sell->get_instock($mat[$i], $edate, $mat[$i]['stock_id']);
            $mat_instock = $q['sum'];
            $mat_quantity = $mat[$i]['quantity'];
            if ($edate == mktime(23, 59, 59, date('m'), date('d'), date('Y'))) {
                $mat_quantity = $mat_instock;
            }
            if (isset($count_msp[0][0])) {
                $count_msp = $count_msp[0][0];
            } else {
                $count_msp = 0;
            }
            //print_r($return_val);die($mat_instock."");
            if ((intval($mat_quantity) > 0 && @$return_val['mat_status'] == 'con') || ($return_val['mat_status'] == 'het' && intval($mat_quantity) <= 0) || $return_val['mat_status'] == '') {
                //print_r($mat[$i]);die($mat_instock."");
                $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i + 14), $i + 1);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 14), $mat[$i]['mat_name']);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . ($i + 14), $mat[$i]['mat_model']);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . ($i + 14), $mat[$i]['cat_name']);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . ($i + 14), $q['instock']);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . ($i + 14), $q['mat_in']);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . ($i + 14), $q['mat_out']);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . ($i + 14), $mat_instock);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . ($i + 14), $mat_quantity);
                $objPHPExcel->getActiveSheet()->setCellValue('J' . ($i + 14), $mat[$i]['msu_name']);
                if ($chk_priv) {
                    $mat_in = get_data("select invd.mat_quantity, invd.amount from invoices inv, invoice_details invd  where inv.inv_id=invd.inv_id  and inv.created_date<=" . $edate . " and invd.mms_id ='" . $mat[$i]['mms_id'] . "' and inv.inv_type=1   order by inv.created_date desc");
                    $sum_amount = 0;
                    $sum_quantity = 0;
                    for ($t = 0; $t < count($mat_in) && $sum_quantity + $mat_in[$t]['mat_quantity'] <= $mat_instock; $t++) {
                        $sum_amount+=$mat_in[$t]['amount'];
                        $sum_quantity+=$mat_in[$t]['mat_quantity'];
                    }
                    if ($sum_quantity < $mat_instock) {
                        $instk = get_data("select instock, price from stock_mat_msu where mms_id='" . $mat[$i]['mms_id'] . "' and price>0 " . (!empty($_GET['stock_id']) ? " and stock_id = '" . $_GET['stock_id'] . "'" : "") . " order by smm_id desc limit 0,1");
                        if (count($instk) > 0) {
                            $sum_amount+=($mat_instock - $sum_quantity) * $instk[0]['price'];
                        } else {
                            $msp = get_data("select msp.smm_id, smm.mms_id, mms.msu_id from mat_split msp, stock_mat_msu smm, mat_msu mms where msp.smm_id in (select smm.smm_id from stock_mat_msu smm, mat_msu mms where mms.mat_id='" . $mat[$i] ["mat_id"] . "' and smm.mms_id=mms.mms_id" . (!empty($_GET['stock_id']) ? " and smm.stock_id = '" . $_GET['stock_id'] . "'" : "") . ")   and " . $mat [$i] ["msu_id"] . " in(msp.msu_list)  and msp.smm_id=smm.smm_id and smm.mms_id=mms.mms_id order by msp.msp_id desc limit 0,1");
                            if (count($msp) > 0) {
                                $m_in = get_data("select invd.amount/invd.mat_quantity amount  from invoices inv, invoice_details invd  where inv.inv_id=invd.inv_id  and inv.created_date<=" . $edate . " and invd.mms_id ='" . $msp[0]['mms_id'] . "' and inv.inv_type=1   order by inv.created_date desc");
                                if (count($m_in) > 0) {
                                    $msu = get_data("select msu_multiple from meansure where msu_parid='" . $mat [$i] ["msu_id"] . "' and msu_id='" . $msp[0]['msu_id'] . "'");
                                    if (count($msu) > 0) {
                                        $sum_amount+=($mat_instock - $sum_quantity) * $m_in[0][0] / $msu[0][0];
                                    } else {
                                        $sum_amount+=($mat_instock - $sum_quantity) * (isset($mat_in[$t]) ? $mat_in[$t]['amount'] / $mat_in[$t]['mat_quantity'] : (isset($mat_in[$t - 1]) ? $mat_in[$t - 1]['amount'] / $mat_in[$t - 1]['mat_quantity'] : 0));
                                    }
                                } else {
                                    $sum_amount+=($mat_instock - $sum_quantity) * (isset($mat_in[$t]) ? $mat_in[$t]['amount'] / $mat_in[$t]['mat_quantity'] : (isset($mat_in[$t - 1]) ? $mat_in[$t - 1]['amount'] / $mat_in[$t - 1]['mat_quantity'] : 0));
                                }
                            } else {
                                $sum_amount+=($mat_instock - $sum_quantity) * (isset($mat_in[$t]) ? $mat_in[$t]['amount'] / $mat_in[$t]['mat_quantity'] : (isset($mat_in[$t - 1]) ? $mat_in[$t - 1]['amount'] / $mat_in[$t - 1]['mat_quantity'] : 0));
                            }
                        }
                        $sum_quantity+=$mat_instock - $sum_quantity;
                    }
                    $objPHPExcel->getActiveSheet()->setCellValue('K' . ($i + 14), $sum_amount);
                    $total+=$sum_amount;
                }
                $objPHPExcel->getActiveSheet()->setCellValue('L' . ($i + 14), $mat[$i]['stock_name']);
                $objPHPExcel->getActiveSheet()->getStyle('E' . ($i + 14))->getNumberFormat()->setFormatCode('#,##0');
                $objPHPExcel->getActiveSheet()->getStyle('F' . ($i + 14))->getNumberFormat()->setFormatCode('#,##0');
                $objPHPExcel->getActiveSheet()->getStyle('G' . ($i + 14))->getNumberFormat()->setFormatCode('#,##0');
                $objPHPExcel->getActiveSheet()->getStyle('H' . ($i + 14))->getNumberFormat()->setFormatCode('#,##0');
                $objPHPExcel->getActiveSheet()->getStyle('I' . ($i + 14))->getNumberFormat()->setFormatCode('#,##0');
                $objPHPExcel->getActiveSheet()->getStyle('K' . ($i + 14))->getNumberFormat()->setFormatCode('#,##0');
                $i++;
            }
        }
        $objPHPExcel->getActiveSheet()->mergeCells('A' . (14 + count($mat)) . ':J' . (14 + count($mat)));
        $objPHPExcel->getActiveSheet()->setCellValue('A' . (14 + count($mat)), "Tổng cộng");
        $objPHPExcel->getActiveSheet()->setCellValue('K' . (14 + count($mat)), $total);
        $objPHPExcel->getActiveSheet()->getStyle('K' . (14 + count($mat)))->getNumberFormat()->setFormatCode('#,##0');
        $objPHPExcel->getActiveSheet()->getStyle('A' . (14 + count($mat)))->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('K' . (14 + count($mat)))->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&BBáo cáo hàng tồn&RĐến ' . date('d/m/Y', $edate));
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');

        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $objPHPExcel->getActiveSheet()->setTitle('HangTon');
        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="ThongKeHangTon.xls"');
        $objWriter->save('php://output');
    }

    function move_stock() {
        global $return_val, $sessions, $head;
        if (isset($return_val["datefrom"])) {
            $sdate = explode("/", $return_val["datefrom"]);
            if ($sdate[0] > 0 && $sdate[0] <= 31 && $sdate[1] > 0 && $sdate[1] <= 12 && $sdate[2] <= date('Y')) {
                $sdate = mktime(0, 0, 0, $sdate[1], $sdate[0], $sdate[2]);
            }
        }
        if (!isset($sdate)) {
            if (date('d') > 7)
                $sdate = mktime(0, 0, 0, date('m'), date('d') - 7, date('Y'));
            else
                $sdate = mktime(0, 0, 0, (date('m') > 1 ? (date('m') - 1) : 12), date('d'), (date('m') > 1 ? date('Y') : (date('Y') - 1)));
            $return_val["datefrom"] = date('d/m/Y', $sdate);
        }
        if (isset($return_val["dateto"])) {
            $edate = explode("/", $return_val["dateto"]);
            if ($edate[0] > 0 && $edate[0] <= 31 && $edate[1] > 0 && $edate[1] <= 12 && $edate[2] <= date('Y')) {
                $edate = mktime(23, 59, 59, $edate[1], $edate[0], $edate[2]);
            }
        }
        if (!isset($edate)) {
            $edate = mktime(23, 59, 59, date('m'), date('d'), date('Y'));
        }

        $inv = get_data("select cat.cat_name, mat.mat_name, inv.inv_id, msu.msu_name, inv.inv_id, inv.comment, inv.inv_code, inv.created_date, stock.stock_name, usr.full_name, invd.amount, invd.mat_quantity from invoices inv, users usr, stocks stock, invoice_details invd, stock_mat_msu smm, mat_msu mms, materials mat, categories cat, meansure msu  where inv.inv_type=2 and  inv.inv_id=invd.inv_id  " . (!empty($return_val['stock_id']) ? " and inv.stock_id=" . $return_val['stock_id'] : "") . " and invd.smm_id=smm.smm_id and smm.mms_id=mms.mms_id and mms.mat_id=mat.mat_id " . (!empty($return_val['cat_id']) ? "  and mat.cat_id=" . $return_val['cat_id'] : "") . (!empty($return_val['user_id']) ? " and inv.user_id='" . $return_val['user_id'] . "' " : "") . " and inv.stock_id=stock.stock_id and inv.user_id=usr.user_id and inv.created_date between " . $sdate . " and " . $edate . "  and mat.cat_id=cat.cat_id and mms.msu_id=msu.msu_id order by inv.created_date desc");

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("EDA")
                ->setLastModifiedBy("EDA")
                ->setTitle("Báo cáo xuất kho nhân viên từ " . date('d/m/Y', $sdate) . " đến" . date('d/m/Y', $edate))
                ->setSubject("Báo cáo xuất kho nhân viên từ " . date('d/m/Y', $sdate) . " đến" . date('d/m/Y', $edate))
                ->setDescription("Báo cáo xuất kho nhân viên từ " . date('d/m/Y', $sdate) . " đến" . date('d/m/Y', $edate))
                ->setKeywords("office 2007 openxml php")
                ->setCategory("EDA");

        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setName('Arial');
        $objPHPExcel->getActiveSheet()->getStyle('A9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->mergeCells('A9:K9');
        $objPHPExcel->getActiveSheet()->getStyle('A9')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('A9', "BÁO CÁO XUẤT KHO NHÂN VIÊN TỪ " . date('d/m/Y', $sdate) . " ĐẾN " . date('d/m/Y', $edate));

        if (!empty($head['logo']) && @empty($head['nologo'])) {
            $objDrawing = new PHPExcel_Worksheet_Drawing();
            $objDrawing->setName('Logo');
            $objDrawing->setDescription('Logo');
            $objDrawing->setPath(substr($head['logo'], 0, 1) == '/' ? substr($head['logo'], 1) : $head['logo']);
            $objDrawing->setHeight(120);
            $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
            $objPHPExcel->getActiveSheet()->mergeCells('C1:K5');
            $objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
            if (empty($head['nologoresize'])) {
                $title = html_entity_decode($head['head_title'], ENT_QUOTES, 'UTF-8');
                $title = str_replace("</p>", "</p>\n", $title);
                $title = str_replace("\n\n", "\n", $title);
                $title = strip_tags($title);
                $objPHPExcel->getActiveSheet()->setCellValue('C1', $title);
            }
        } else {
            $objPHPExcel->getActiveSheet()->mergeCells('A1:K5');
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
            if (empty($head['nologoresize'])) {
                $title = html_entity_decode($head['head_title'], ENT_QUOTES, 'UTF-8');
                $title = strip_tags($title);
                $objPHPExcel->getActiveSheet()->setCellValue('A1', $title);
            }
        }

        $stock = get_data("select stock_name from stocks where  stock_id='" . $return_val['stock_id'] . "'");
        if (count($stock) > 0) {
            $objPHPExcel->getActiveSheet()->setCellValue('A10', "Kho hàng: " . $stock[0]['stock_name']);
        }
        $objPHPExcel->getActiveSheet()->getStyle('A12:K12')->applyFromArray(
                array(
                    'font' => array(
                        'bold' => true
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    ),
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'AFD7FF')
                    )
                )
        );
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(22);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);

        $objPHPExcel->getActiveSheet()->getStyle('A12:A' . (12 + count($inv)))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A12:K' . (12 + count($inv)))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A12:K' . (12 + count($inv)))->getAlignment()->setWrapText(true);

        $objPHPExcel->getActiveSheet()->setCellValue('A12', 'STT');
        $objPHPExcel->getActiveSheet()->setCellValue('B12', 'Mã phiếu');
        $objPHPExcel->getActiveSheet()->setCellValue('C12', 'Thời gian');
        $objPHPExcel->getActiveSheet()->setCellValue('D12', 'Người xuất');
        $objPHPExcel->getActiveSheet()->setCellValue('E12', 'Kho nhận');
        $objPHPExcel->getActiveSheet()->setCellValue('F12', 'Sản phẩm');
        $objPHPExcel->getActiveSheet()->setCellValue('G12', 'Danh mục hàng hóa');
        $objPHPExcel->getActiveSheet()->setCellValue('H12', 'SL');
        $objPHPExcel->getActiveSheet()->setCellValue('I12', 'Đơn vị');
        $objPHPExcel->getActiveSheet()->setCellValue('J12', 'Đơn giá');
        $objPHPExcel->getActiveSheet()->setCellValue('K12', 'Thành tiền');

        $objPHPExcel->getActiveSheet()->getStyle('A12:K' . (13 + count($inv)))->applyFromArray(
                array(
                    'font' => array(
                        'size' => 10
                    ),
                    'borders' => array(
                        'outline' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        ),
                        'inside' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                )
        );
        $total = 0;
        for ($i = 0; $i < count($inv); $i++) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i + 13), $i + 1);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 13), $inv[$i]['inv_code']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . ($i + 13), PHPExcel_Shared_Date::PHPToExcel($inv[$i]['created_date'] + 7 * 3600));
            $objPHPExcel->getActiveSheet()->setCellValue('D' . ($i + 13), $inv[$i]['full_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . ($i + 13), $inv[$i]['stock_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . ($i + 13), $inv[$i]['mat_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . ($i + 13), $inv[$i]['cat_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . ($i + 13), $inv[$i]['mat_quantity']);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . ($i + 13), $inv[$i]['msu_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('J' . ($i + 13), $inv[$i]['amount'] / $inv[$i]['mat_quantity']);
            $objPHPExcel->getActiveSheet()->setCellValue('K' . ($i + 13), $inv[$i]['amount']);
            $objPHPExcel->getActiveSheet()->getStyle('H' . ($i + 13))->getNumberFormat()->setFormatCode('#,##0');
            $objPHPExcel->getActiveSheet()->getStyle('J' . ($i + 13))->getNumberFormat()->setFormatCode('#,##0');
            $objPHPExcel->getActiveSheet()->getStyle('K' . ($i + 13))->getNumberFormat()->setFormatCode('#,##0');
            $objPHPExcel->getActiveSheet()->getStyle('C' . ($i + 13))->getNumberFormat()->setFormatCode('DD/MM/YY HH:MM');
            $total+=$inv[$i]['amount'];
        }
        $objPHPExcel->getActiveSheet()->mergeCells('A' . (13 + count($inv)) . ':J' . ($i + 13));
        $objPHPExcel->getActiveSheet()->setCellValue('A' . (13 + count($inv)), "Tổng cộng");
        $objPHPExcel->getActiveSheet()->setCellValue('K' . (13 + count($inv)), $total);
        $objPHPExcel->getActiveSheet()->getStyle('K' . (13 + count($inv)))->getNumberFormat()->setFormatCode('#,##0');
        $objPHPExcel->getActiveSheet()->getStyle('A' . (13 + count($inv)))->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('K' . (13 + count($inv)))->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&BBáo cáo xuất kho nhân viên&RTừ ' . date('d/m/Y', $sdate) . " đến " . date('d/m/Y', $edate));
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');

        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

        $objPHPExcel->getActiveSheet()->setTitle('XuatKho');
        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="ThongKeXuatKhoNhanVien.xls"');
        $objWriter->save('php://output');
    }

    function mat_move() {
        global $return_val, $sessions, $head;
        if (isset($return_val["datefrom"])) {
            $sdate = explode("/", $return_val["datefrom"]);
            if ($sdate[0] > 0 && $sdate[0] <= 31 && $sdate[1] > 0 && $sdate[1] <= 12 && $sdate[2] <= date('Y')) {
                $sdate = mktime(0, 0, 0, $sdate[1], $sdate[0], $sdate[2]);
            }
        }
        if (!isset($sdate)) {
            $sdate = mktime(0, 0, 0, date('m'), date('d'), date('Y')) - 7 * 24 * 3600;
            $return_val["datefrom"] = date('d/m/Y', $sdate);
        }
        if (isset($return_val["dateto"])) {
            $edate = explode("/", $return_val["dateto"]);
            if ($edate[0] > 0 && $edate[0] <= 31 && $edate[1] > 0 && $edate[1] <= 12 && $edate[2] <= date('Y')) {
                $edate = mktime(23, 59, 59, $edate[1], $edate[0], $edate[2]);
            }
        }
        if (!isset($edate)) {
            $edate = mktime(23, 59, 59, date('m'), date('d'), date('Y'));
        }
        $where = '';
        if (@!empty($return_val['stock_id'])) {
            $where = " and inv.stock_id ='" . $return_val['stock_id'] . "'";
        }
        if (@!empty($return_val['stock_id_to'])) {
            $where = " and inv.stock_id_to ='" . $return_val['stock_id_to'] . "'";
        }

        $inv = get_data("select cat.cat_name, mat.mat_name, inv.stock_id, inv.stock_id_to, inv.inv_code, inv.created_date, usr.full_name, mms.mms_id, msu.msu_name, invd.mat_quantity from mat_move_invoices inv, mat_move_invoice_details invd, mat_msu mms, materials mat, stock_mat_msu smm, categories cat, meansure msu, users usr  where inv.inv_id=invd.inv_id and invd.smm_id=smm.smm_id and smm.mms_id=mms.mms_id and mms.mat_id=mat.mat_id and mat.cat_id=cat.cat_id " . (!empty($return_val['cat_id']) ? "  and cat.cat_id=" . $return_val['cat_id'] : "") . $where . " and inv.created_date between " . $sdate . " and " . $edate . "  and mms.msu_id=msu.msu_id and inv.user_id=usr.user_id");

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("EDA")
                ->setLastModifiedBy("EDA")
                ->setTitle("Báo cáo xuất kho nội bộ từ " . date('d/m/Y', $sdate) . " đến" . date('d/m/Y', $edate))
                ->setSubject("Báo cáo xuất kho nội bộ từ " . date('d/m/Y', $sdate) . " đến" . date('d/m/Y', $edate))
                ->setDescription("Báo cáo xuất kho nội bộ từ " . date('d/m/Y', $sdate) . " đến" . date('d/m/Y', $edate))
                ->setKeywords("office 2007 openxml php")
                ->setCategory("EDA");

        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setName('Arial');
        $objPHPExcel->getActiveSheet()->getStyle('A9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->mergeCells('A9:J9');
        $objPHPExcel->getActiveSheet()->getStyle('A9')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('A9', "BÁO CÁO XUẤT KHO NỘI BỘ TỪ " . date('d/m/Y', $sdate) . " ĐẾN " . date('d/m/Y', $edate));
        if (!empty($head['logo']) && @empty($head['nologo'])) {
            $objDrawing = new PHPExcel_Worksheet_Drawing();
            $objDrawing->setName('Logo');
            $objDrawing->setDescription('Logo');
            $objDrawing->setPath(substr($head['logo'], 0, 1) == '/' ? substr($head['logo'], 1) : $head['logo']);
            $objDrawing->setHeight(120);
            $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
            $objPHPExcel->getActiveSheet()->mergeCells('C1:J5');
            $objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
            if (empty($head['nologoresize'])) {
                $title = html_entity_decode($head['head_title'], ENT_QUOTES, 'UTF-8');
                $title = str_replace("</p>", "</p>\n", $title);
                $title = str_replace("\n\n", "\n", $title);
                $title = strip_tags($title);
                $objPHPExcel->getActiveSheet()->setCellValue('C1', $title);
            }
        } else {
            $objPHPExcel->getActiveSheet()->mergeCells('A1:J5');
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
            if (empty($head['nologoresize'])) {
                $title = html_entity_decode($head['head_title'], ENT_QUOTES, 'UTF-8');
                $title = strip_tags($title);
                $objPHPExcel->getActiveSheet()->setCellValue('A1', $title);
            }
        }
        $stock = get_data("select stock_name from stocks where  stock_id='" . $return_val['stock_id'] . "'");
        if (count($stock) > 0) {
            $objPHPExcel->getActiveSheet()->setCellValue('A10', "Kho hàng: " . $stock[0]['stock_name']);
        }
        $objPHPExcel->getActiveSheet()->getStyle('A12:J12')->applyFromArray(
                array(
                    'font' => array(
                        'bold' => true
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    ),
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'AFD7FF')
                    )
                )
        );

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(13);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);

        $objPHPExcel->getActiveSheet()->getStyle('A12:A' . (12 + count($inv)))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A12:J' . (12 + count($inv)))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A12:J' . (12 + count($inv)))->getAlignment()->setWrapText(true);

        $objPHPExcel->getActiveSheet()->setCellValue('A12', 'STT');
        $objPHPExcel->getActiveSheet()->setCellValue('B12', 'Mã phiếu');
        $objPHPExcel->getActiveSheet()->setCellValue('C12', 'Thời gian');
        $objPHPExcel->getActiveSheet()->setCellValue('D12', 'Người lập');
        $objPHPExcel->getActiveSheet()->setCellValue('E12', 'Kho chuyển');
        $objPHPExcel->getActiveSheet()->setCellValue('F12', 'Kho nhận');
        $objPHPExcel->getActiveSheet()->setCellValue('G12', 'Sản phẩm');
        $objPHPExcel->getActiveSheet()->setCellValue('H12', 'Danh mục hàng hóa');
        $objPHPExcel->getActiveSheet()->setCellValue('I12', 'SL');
        $objPHPExcel->getActiveSheet()->setCellValue('J12', 'Đơn vị');

        $objPHPExcel->getActiveSheet()->getStyle('A12:J' . (12 + count($inv)))->applyFromArray(
                array(
                    'font' => array(
                        'size' => 10
                    ),
                    'borders' => array(
                        'outline' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        ),
                        'inside' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                )
        );
        for ($i = 0; $i < count($inv); $i++) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i + 13), $i + 1);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 13), $inv[$i]['inv_code']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . ($i + 13), PHPExcel_Shared_Date::PHPToExcel($inv[$i]['created_date'] + 7 * 3600));
            $objPHPExcel->getActiveSheet()->setCellValue('D' . ($i + 13), $inv[$i]['full_name']);
            $stock = get_data("select stock_name from stocks where  stock_id='" . $inv[$i]['stock_id'] . "'");
            if (count($stock) > 0) {
                $stock = $stock = $stock[0]['stock_name'];
            } else {
                $stock = '';
            }
            $objPHPExcel->getActiveSheet()->setCellValue('E' . ($i + 13), $stock);
            $stock = get_data("select stock_name from stocks where  stock_id='" . $inv[$i]['stock_id_to'] . "'");
            if (count($stock) > 0) {
                $stock = $stock = $stock[0]['stock_name'];
            } else {
                $stock = '';
            }
            $objPHPExcel->getActiveSheet()->setCellValue('F' . ($i + 13), $stock);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . ($i + 13), $inv[$i]['mat_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . ($i + 13), $inv[$i]['cat_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . ($i + 13), $inv[$i]['mat_quantity']);
            $objPHPExcel->getActiveSheet()->setCellValue('J' . ($i + 13), $inv[$i]['msu_name']);
            $objPHPExcel->getActiveSheet()->getStyle('I' . ($i + 13))->getNumberFormat()->setFormatCode('#,##0');
            $objPHPExcel->getActiveSheet()->getStyle('C' . ($i + 13))->getNumberFormat()->setFormatCode('DD/MM/YY HH:MM');
        }

        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&BBáo cáo xuất kho nội bộ&RTừ ' . date('d/m/Y', $sdate) . " đến " . date('d/m/Y', $edate));
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');

        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $objPHPExcel->getActiveSheet()->setTitle('XuatKho');
        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="XuatKhoNoiBo.xls"');
        $objWriter->save('php://output');
    }

    function mat_return() {
        global $return_val, $sessions, $head;
        if (isset($return_val["datefrom"])) {
            $sdate = explode("/", $return_val["datefrom"]);
            if ($sdate[0] > 0 && $sdate[0] <= 31 && $sdate[1] > 0 && $sdate[1] <= 12 && $sdate[2] <= date('Y')) {
                $sdate = mktime(0, 0, 0, $sdate[1], $sdate[0], $sdate[2]);
            }
        }
        if (!isset($sdate)) {
            $sdate = mktime(0, 0, 0, date('m'), date('d'), date('Y')) - 7 * 24 * 3600;
            $return_val["datefrom"] = date('d/m/Y', $sdate);
        }
        if (isset($return_val["dateto"])) {
            $edate = explode("/", $return_val["dateto"]);
            if ($edate[0] > 0 && $edate[0] <= 31 && $edate[1] > 0 && $edate[1] <= 12 && $edate[2] <= date('Y')) {
                $edate = mktime(23, 59, 59, $edate[1], $edate[0], $edate[2]);
            }
        }
        if (!isset($edate)) {
            $edate = mktime(23, 59, 59, date('m'), date('d'), date('Y'));
        }

        $where = '';
        if (@$return_val['return_type'] == 1) {
            $where = ' and inv.cus_id is not null';
        }
        if (@$return_val['return_type'] == 2) {
            $where = ' and inv.emp_stock_id is not null';
        }
        if (@$return_val['return_type'] == 3) {
            $where = ' and inv.sup_id is not null';
        }
        $inv = get_data("select cat.cat_name, mat.mat_name, mms.mms_id, inv.*, msu.msu_name, usr.full_name, invd.mat_quantity, invd.amount from mat_return_invoices inv, mat_return_invoice_details invd, mat_msu mms, materials mat, stock_mat_msu smm, categories cat, meansure msu, users usr  where inv.inv_id=invd.inv_id and invd.smm_id=smm.smm_id and smm.mms_id=mms.mms_id and mms.mat_id=mat.mat_id and mat.cat_id=cat.cat_id " . (!empty($return_val['cat_id']) ? "  and cat.cat_id=" . $return_val['cat_id'] : "") . (!empty($return_val['user_id']) ? " and inv.user_id='" . $return_val['user_id'] . "' " : "") . $where . " and inv.created_date between " . $sdate . " and " . $edate . "  and mms.msu_id=msu.msu_id and inv.user_id=usr.user_id");
        $objPHPExcel = new PHPExcel();

        $objPHPExcel->getProperties()->setCreator("EDA")
                ->setLastModifiedBy("EDA")
                ->setTitle("Báo cáo nhập hàng trả lại từ " . date('d/m/Y', $sdate) . " đến" . date('d/m/Y', $edate))
                ->setSubject("Báo cáo nhập hàng trả lại từ " . date('d/m/Y', $sdate) . " đến" . date('d/m/Y', $edate))
                ->setDescription("Báo cáo nhập hàng trả lại từ " . date('d/m/Y', $sdate) . " đến" . date('d/m/Y', $edate))
                ->setKeywords("office 2007 openxml php")
                ->setCategory("EDA");

        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setName('Arial');
        $objPHPExcel->getActiveSheet()->getStyle('A9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->mergeCells('A9:L9');
        $objPHPExcel->getActiveSheet()->getStyle('A9')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('A9', "BÁO CÁO NHẬP HÀNG TRẢ LẠI TỪ " . date('d/m/Y', $sdate) . " ĐẾN " . date('d/m/Y', $edate));

        if (!empty($head['logo']) && @empty($head['nologo'])) {
            $objDrawing = new PHPExcel_Worksheet_Drawing();
            $objDrawing->setName('Logo');
            $objDrawing->setDescription('Logo');
            $objDrawing->setPath(substr($head['logo'], 0, 1) == '/' ? substr($head['logo'], 1) : $head['logo']);
            $objDrawing->setHeight(120);
            $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
            $objPHPExcel->getActiveSheet()->mergeCells('C1:L5');
            $objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
            if (empty($head['nologoresize'])) {
                $title = html_entity_decode($head['head_title'], ENT_QUOTES, 'UTF-8');
                $title = str_replace("</p>", "</p>\n", $title);
                $title = str_replace("\n\n", "\n", $title);
                $title = strip_tags($title);
                $objPHPExcel->getActiveSheet()->setCellValue('C1', $title);
            }
        } else {
            $objPHPExcel->getActiveSheet()->mergeCells('A1:L5');
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
            if (empty($head['nologoresize'])) {
                $title = html_entity_decode($head['head_title'], ENT_QUOTES, 'UTF-8');
                $title = strip_tags($title);
                $objPHPExcel->getActiveSheet()->setCellValue('A1', $title);
            }
        }
        if (@$return_val['return_type'] == 1) {
            $objPHPExcel->getActiveSheet()->setCellValue('A10', "Hình thức: Khách trả lại");
        }
        if (@$return_val['return_type'] == 2) {
            $objPHPExcel->getActiveSheet()->setCellValue('A10', "Hình thức: Nhân viên trả lại");
        }
        if (@$return_val['return_type'] == 3) {
            $objPHPExcel->getActiveSheet()->setCellValue('A10', "Hình thức: Trả lại nhà cung cấp");
        }

        $objPHPExcel->getActiveSheet()->getStyle('A12:L12')->applyFromArray(
                array(
                    'font' => array(
                        'bold' => true
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    ),
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'AFD7FF')
                    )
                )
        );
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(22);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(22);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);

        $objPHPExcel->getActiveSheet()->getStyle('A12:A' . (12 + count($inv)))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A12:L' . (12 + count($inv)))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A12:L' . (12 + count($inv)))->getAlignment()->setWrapText(true);

        $objPHPExcel->getActiveSheet()->setCellValue('A12', 'STT');
        $objPHPExcel->getActiveSheet()->setCellValue('B12', 'Mã phiếu');
        $objPHPExcel->getActiveSheet()->setCellValue('C12', 'Thời gian');
        $objPHPExcel->getActiveSheet()->setCellValue('D12', 'Hình thức trả');
        $objPHPExcel->getActiveSheet()->setCellValue('E12', 'Người nhập');
        $objPHPExcel->getActiveSheet()->setCellValue('F12', 'Người trả/nhận');
        $objPHPExcel->getActiveSheet()->setCellValue('G12', 'Sản phẩm');
        $objPHPExcel->getActiveSheet()->setCellValue('H12', 'Danh mục hàng hóa');
        $objPHPExcel->getActiveSheet()->setCellValue('I12', 'SL');
        $objPHPExcel->getActiveSheet()->setCellValue('J12', 'Đơn vị');
        $objPHPExcel->getActiveSheet()->setCellValue('K12', 'Đơn giá');
        $objPHPExcel->getActiveSheet()->setCellValue('L12', 'Thành tiền');

        $objPHPExcel->getActiveSheet()->getStyle('A12:L' . (13 + count($inv)))->applyFromArray(
                array(
                    'font' => array(
                        'size' => 10
                    ),
                    'borders' => array(
                        'outline' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        ),
                        'inside' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                )
        );
        $total = 0;
        for ($i = 0; $i < count($inv); $i++) {
            $type = '';
            if (!empty($inv[$i]['cus_id'])) {
                $type = 'Khách trả lại';
            }
            if (!empty($inv[$i]['sup_id'])) {
                $type = 'Trả lại nhà cung cấp';
            }
            if (!empty($inv[$i]['emp_stock_id'])) {
                $type = 'Nhân viên trả lại';
            }
            $sup = '';
            if (!empty($inv[$i]['sup_id'])) {
                $sup = get_data("select sup_name from supliers where sup_id='" . $inv[$i]['sup_id'] . "'");
                $sup = $sup[0][0];
            } else if (!empty($inv[$i]['cus_id'])) {
                $sup = get_data("select cus_name from customers where cus_id='" . $inv[$i]['cus_id'] . "'");
                $sup = $sup[0][0];
            } else if (!empty($inv[$i]['emp_stock_id'])) {
                $sup = get_data("select stock_name from stocks where stock_id='" . $inv[$i]['emp_stock_id'] . "'");
                $sup = $sup[0][0];
            }
            $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i + 13), $i + 1);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 13), $inv[$i]['inv_code']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . ($i + 13), PHPExcel_Shared_Date::PHPToExcel($inv[$i]['created_date'] + 7 * 3600));
            $objPHPExcel->getActiveSheet()->setCellValue('D' . ($i + 13), $type);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . ($i + 13), $inv[$i]['full_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . ($i + 13), $sup);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . ($i + 13), $inv[$i]['mat_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . ($i + 13), $inv[$i]['cat_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . ($i + 13), $inv[$i]['mat_quantity']);
            $objPHPExcel->getActiveSheet()->setCellValue('J' . ($i + 13), $inv[$i]['msu_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('K' . ($i + 13), $inv[$i]['amount'] / $inv[$i]['mat_quantity']);
            $objPHPExcel->getActiveSheet()->setCellValue('L' . ($i + 13), $inv[$i]['amount']);
            $objPHPExcel->getActiveSheet()->getStyle('I' . ($i + 13))->getNumberFormat()->setFormatCode('#,##0');
            $objPHPExcel->getActiveSheet()->getStyle('K' . ($i + 13))->getNumberFormat()->setFormatCode('#,##0');
            $objPHPExcel->getActiveSheet()->getStyle('L' . ($i + 13))->getNumberFormat()->setFormatCode('#,##0');
            $objPHPExcel->getActiveSheet()->getStyle('C' . ($i + 13))->getNumberFormat()->setFormatCode('DD/MM/YY HH:MM');
            $total+=$inv[$i]['amount'];
        }
        $objPHPExcel->getActiveSheet()->mergeCells('A' . (13 + count($inv)) . ':K' . ($i + 13));
        $objPHPExcel->getActiveSheet()->setCellValue('A' . (13 + count($inv)), "Tổng cộng");
        $objPHPExcel->getActiveSheet()->setCellValue('L' . (13 + count($inv)), $total);
        $objPHPExcel->getActiveSheet()->getStyle('L' . (13 + count($inv)))->getNumberFormat()->setFormatCode('#,##0');
        $objPHPExcel->getActiveSheet()->getStyle('A' . (13 + count($inv)))->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('L' . (13 + count($inv)))->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&BBáo cáo nhập hàng trả lại&RTừ ' . date('d/m/Y', $sdate) . " đến " . date('d/m/Y', $edate));
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');

        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

        $objPHPExcel->getActiveSheet()->setTitle('NhapTraLai');
        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="NhapTraLai.xls"');
        $objWriter->save('php://output');
    }

    function budget() {
        global $return_val, $sessions, $head;
        if (isset($return_val["datefrom"])) {
            $sdate = explode("/", $return_val["datefrom"]);
            if ($sdate[0] > 0 && $sdate[0] <= 31 && $sdate[1] > 0 && $sdate[1] <= 12 && $sdate[2] <= date('Y')) {
                $sdate = mktime(0, 0, 0, $sdate[1], $sdate[0], $sdate[2]);
            }
        }
        if (!isset($sdate)) {
            $sdate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
            $return_val["datefrom"] = date('d/m/Y', $sdate);
        }
        if (isset($return_val["dateto"])) {
            $edate = explode("/", $return_val["dateto"]);
            if ($edate[0] > 0 && $edate[0] <= 31 && $edate[1] > 0 && $edate[1] <= 12 && $edate[2] <= date('Y')) {
                $edate = mktime(23, 59, 59, $edate[1], $edate[0], $edate[2]);
            }
        }
        if (!isset($edate)) {
            $edate = mktime(23, 59, 59, date('m'), date('d'), date('Y'));
        }

        $inv = get_data("select bin.*, f.fund_name, usr.full_name, itt.item_name from budget_invoices bin, item_type itt, users usr, fund f where " . (!empty($return_val['fund_id']) ? " bin.fund_id='" . $return_val['fund_id'] . "' and " : "") . (!empty($return_val['user_id']) ? " bin.user_id='" . $return_val['user_id'] . "' and " : "") . (isset($return_val['bin_type']) ? ($return_val['bin_type'] != -1 ? " bin.bin_type='" . $return_val['bin_type'] . "' and " : "") : "") . (isset($return_val['item_id']) ? ($return_val['item_id'] != -1 ? " itt.item_id='" . $return_val['item_id'] . "' and " : "") : "") . " bin.created_date between " . $sdate . " and " . $edate . " and bin.user_id=usr.user_id and bin.item_id=itt.item_id and bin.fund_id=f.fund_id  order by bin.created_date desc");
        $objPHPExcel = new PHPExcel();

        $objPHPExcel->getProperties()->setCreator("EDA")
                ->setLastModifiedBy("EDA")
                ->setTitle("Báo cáo thu chi từ " . date('d/m/Y', $sdate) . " đến" . date('d/m/Y', $edate))
                ->setSubject("Báo cáo thu chi từ " . date('d/m/Y', $sdate) . " đến" . date('d/m/Y', $edate))
                ->setDescription("Báo cáo thu chi từ " . date('d/m/Y', $sdate) . " đến" . date('d/m/Y', $edate))
                ->setKeywords("office 2007 openxml php")
                ->setCategory("EDA");

        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setName('Arial');
        $objPHPExcel->getActiveSheet()->getStyle('A9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->mergeCells('A9:J9');
        $objPHPExcel->getActiveSheet()->getStyle('A9')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('A9', "BÁO CÁO THU CHI TỪ " . date('d/m/Y', $sdate) . " ĐẾN " . date('d/m/Y', $edate));

        if (!empty($head['logo']) && @empty($head['nologo'])) {
            $objDrawing = new PHPExcel_Worksheet_Drawing();
            $objDrawing->setName('Logo');
            $objDrawing->setDescription('Logo');
            $objDrawing->setPath(substr($head['logo'], 0, 1) == '/' ? substr($head['logo'], 1) : $head['logo']);
            $objDrawing->setHeight(120);
            $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
            $objPHPExcel->getActiveSheet()->mergeCells('C1:J5');
            $objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
            if (empty($head['nologoresize'])) {
                $title = html_entity_decode($head['head_title'], ENT_QUOTES, 'UTF-8');
                $title = str_replace("</p>", "</p>\n", $title);
                $title = str_replace("\n\n", "\n", $title);
                $title = strip_tags($title);
                $objPHPExcel->getActiveSheet()->setCellValue('C1', $title);
            }
        } else {
            $objPHPExcel->getActiveSheet()->mergeCells('A1:J5');
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
            if (empty($head['nologoresize'])) {
                $title = html_entity_decode($head['head_title'], ENT_QUOTES, 'UTF-8');
                $title = strip_tags($title);
                $objPHPExcel->getActiveSheet()->setCellValue('A1', $title);
            }
        }

        $fund = get_data("select fund_name from fund where  fund_id='" . $return_val['fund_id'] . "'");
        if (count($fund) > 0) {
            $objPHPExcel->getActiveSheet()->setCellValue('A10', "Quỹ/Tài khoản: " . $fund[0]['fund_name']);
        }
        $objPHPExcel->getActiveSheet()->getStyle('A12:J12')->applyFromArray(
                array(
                    'font' => array(
                        'bold' => true
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    ),
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'AFD7FF')
                    )
                )
        );
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);

        $objPHPExcel->getActiveSheet()->getStyle('A12:A' . (12 + count($inv)))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A12:J' . (12 + count($inv)))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A12:J' . (12 + count($inv)))->getAlignment()->setWrapText(true);

        $objPHPExcel->getActiveSheet()->setCellValue('A12', 'STT');
        $objPHPExcel->getActiveSheet()->setCellValue('B12', 'Mã phiếu');
        $objPHPExcel->getActiveSheet()->setCellValue('C12', 'Thời gian');
        $objPHPExcel->getActiveSheet()->setCellValue('D12', 'Người thu/chi');
        $objPHPExcel->getActiveSheet()->setCellValue('E12', 'Người nộp/nhận');
        $objPHPExcel->getActiveSheet()->setCellValue('F12', 'Thu/chi');
        $objPHPExcel->getActiveSheet()->setCellValue('G12', 'Tên khoản');
        $objPHPExcel->getActiveSheet()->setCellValue('H12', 'Quỹ/Tài khoản');
        $objPHPExcel->getActiveSheet()->setCellValue('I12', 'Nội dung');
        $objPHPExcel->getActiveSheet()->setCellValue('J12', 'Số tiền');

        $objPHPExcel->getActiveSheet()->getStyle('A12:J' . (12 + count($inv)))->applyFromArray(
                array(
                    'font' => array(
                        'size' => 10
                    ),
                    'borders' => array(
                        'outline' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        ),
                        'inside' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                )
        );
        $total = 0;
        for ($i = 0; $i < count($inv); $i++) {
            if (!empty($inv[$i]['cus_id'])) {
                $c=get_data("select cus_name from customers where cus_id='".$inv[$i]['cus_id']."'");
                if(count($c)>0) {
                    $cus=$c[0]['cus_name'];
                } else {
                    $cus = 'Không xác định';
                }
            }
            if (!empty($inv[$i]['sup_id'])) {
                $c=get_data("select sup_name from supliers where sup_id='".$inv[$i]['sup_id']."'");
                if(count($c)>0) {
                    $cus=$c[0]['sup_name'];
                } else {
                    $cus = 'Không xác định';
                }
            }
            if (!empty($inv[$i]['emp_stock_id'])) {
                $c=get_data("select full_name from users where user_id='".$inv[$i]['emp_stock_id']."'");
                if(count($c)>0) {
                    $cus=$c[0]['full_name'];
                } else {
                    $cus = 'Không xác định';
                }
            }            
            $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i + 13), $i + 1);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 13), $inv[$i]['bin_code']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . ($i + 13), PHPExcel_Shared_Date::PHPToExcel($inv[$i]['created_date'] + 7 * 3600));
            $objPHPExcel->getActiveSheet()->setCellValue('D' . ($i + 13), $inv[$i]['full_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . ($i + 13), $cus);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . ($i + 13), ($inv[$i]['bin_type'] == 0 ? 'Thu' : 'Chi'));
            $objPHPExcel->getActiveSheet()->setCellValue('G' . ($i + 13), $inv[$i]['item_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . ($i + 13), $inv[$i]['fund_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . ($i + 13), $inv[$i]['comment']);
            $objPHPExcel->getActiveSheet()->setCellValue('J' . ($i + 13), $inv[$i]['amount']);
            $objPHPExcel->getActiveSheet()->getStyle('J' . ($i + 13))->getNumberFormat()->setFormatCode('#,##0');
            $objPHPExcel->getActiveSheet()->getStyle('C' . ($i + 13))->getNumberFormat()->setFormatCode('DD/MM/YY HH:MM');
        }

        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&BBáo cáo thu chi&RTừ ' . date('d/m/Y', $sdate) . " đến " . date('d/m/Y', $edate));
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');

        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

        $objPHPExcel->getActiveSheet()->setTitle('ThuChi');
        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="ThongKeThuChi.xls"');
        $objWriter->save('php://output');
    }

}

$excel_export = new excel_export();
$excel_export->export();
?>
