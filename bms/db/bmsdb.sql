-- phpMyAdmin SQL Dump
-- version 3.4.3.1
-- http://www.phpmyadmin.net
--
-- Host: 192.168.10.108
-- Generation Time: Aug 03, 2012 at 11:49 AM
-- Server version: 5.0.95
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bms_dungnga`
--

-- --------------------------------------------------------

--
-- Table structure for table `budget_invoices`
--

CREATE TABLE IF NOT EXISTS `budget_invoices` (
  `bin_id` int(10) unsigned NOT NULL auto_increment,
  `item_id` int(10) unsigned NOT NULL,
  `created_date` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `bin_code` varchar(10) NOT NULL,
  `amount` int(11) NOT NULL,
  `bin_type` tinyint(3) unsigned NOT NULL default '0',
  `cus_id` int(10) unsigned default NULL,
  `sup_id` int(10) unsigned default NULL,
  `user_name` varchar(100) default NULL,
  `comment` varchar(255) default NULL,
  `emp_id` int(10) unsigned default NULL,
  `inv_id` int(10) unsigned default NULL,
  `created_user` int(10) unsigned NOT NULL,
  `oinv_id` int(10) unsigned default NULL,
  `fund_id` int(10) unsigned NOT NULL,
  `mriinv_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`bin_id`),
  KEY `fk_bin_usr` (`user_id`),
  KEY `fk_bin_item` (`item_id`),
  KEY `fk_bin_sup` (`sup_id`),
  KEY `fk_bin_inv` (`inv_id`),
  KEY `fk_bin_usr2` (`emp_id`),
  KEY `fk_bin_usr3` (`created_user`),
  KEY `fk_bin_oinv` (`oinv_id`),
  KEY `fk_bin_fund` (`fund_id`),
  KEY `fk_bin_mri` (`mriinv_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `cat_id` int(10) unsigned NOT NULL auto_increment,
  `cat_name` varchar(200) NOT NULL default '',
  `cat_order` tinyint(3) unsigned default NULL,
  `cat_type` varchar(2) default NULL,
  PRIMARY KEY  (`cat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `cus_id` int(10) unsigned NOT NULL auto_increment,
  `cus_name` varchar(200) NOT NULL,
  `address` varchar(200) default NULL,
  `tel` varchar(100) default NULL,
  `cus_code` varchar(20) character set latin1 NOT NULL,
  `comment` varchar(200) default NULL,
  `tax_no` varchar(20) default NULL,
  `reg_no` varchar(20) default NULL,
  `bank_acc` varchar(30) default NULL,
  `bank_name` varchar(200) default NULL,
  `email` varchar(100) default NULL,
  `website` varchar(100) default NULL,
  `cus_type` varchar(20) default NULL,
  `debt` int(11) default '0',
  PRIMARY KEY  (`cus_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dept`
--

CREATE TABLE IF NOT EXISTS `dept` (
  `dept_id` int(10) unsigned NOT NULL auto_increment,
  `dept_name` varchar(300) NOT NULL,
  PRIMARY KEY  (`dept_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `dept`
--

INSERT INTO `dept` (`dept_id`, `dept_name`) VALUES
(1, 'Phòng Kinh Doanh'),
(2, 'Phòng Giám Đốc'),
(3, 'Phòng Kế Toán'),
(4, 'Phòng Kỹ Thuật'),
(5, 'Phòng chăm sóc KH'),
(6, 'Phòng hành chính');

-- --------------------------------------------------------

--
-- Table structure for table `function_menu`
--

CREATE TABLE IF NOT EXISTS `function_menu` (
  `fmenu_id` int(10) unsigned NOT NULL auto_increment,
  `fmenu_name` varchar(200) NOT NULL,
  `fmenu_act` varchar(50) default NULL,
  `fmenu_parid` int(10) unsigned default NULL,
  `fmenu_img` varchar(100) default NULL,
  `order_by` int(10) unsigned default NULL,
  PRIMARY KEY  (`fmenu_id`),
  KEY `fk_fmenu_fmenu` (`fmenu_parid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=74 ;

--
-- Dumping data for table `function_menu`
--

INSERT INTO `function_menu` (`fmenu_id`, `fmenu_name`, `fmenu_act`, `fmenu_parid`, `fmenu_img`, `order_by`) VALUES
(1, 'Quản lý kho - Bán hàng', 'sell', NULL, NULL, 1),
(2, 'Tài chính - Công nợ', 'finance', NULL, NULL, 2),
(3, 'Quản lý bảo hành', 'waranty', NULL, NULL, 3),
(4, 'Chức năng chung', 'general', NULL, NULL, 4),
(5, 'Quản lý khách hàng', 'cus_manager', 4, 'contacts.png', 1),
(6, 'Quản lý nhà cung cấp', 'sup_manager', 4, 'about.gif', 2),
(7, 'Quản lý hãng sản xuất', 'mfa_manager', 4, 'city.png', 3),
(8, 'Quản lý chủng loại', 'cats', 4, 'category.png', 4),
(9, 'Quản lý sản phẩm', 'mat_manager', 4, 'download.png', 5),
(10, 'Quản lý nhân viên', 'emp_manager', 4, 'emp.png', 6),
(11, 'Quản lý nhóm làm việc', 'group', 4, 'mankey.png', 7),
(12, 'Quản lý phòng ban', 'dept', 4, 'dept.png', 8),
(13, 'Khai báo khoản Thu/Chi', 'item_type', 4, 'additionalmoney.png', 9),
(14, 'Khai báo Quỹ/Tài khoản', 'fund', 4, 'wallet_icon.png', 10),
(15, 'Khai báo kho', 'stock', 4, 'stock.png', 11),
(16, 'Đơn vị tính', 'msu', 4, 'cal.png', 12),
(17, 'Phân quyền sử dụng', 'permission', 4, 'permission.png', 13),
(18, 'Tiêu đề phần mềm', 'head_title', 4, 'logo.png', 14),
(19, 'Xoá dữ liệu', 'clear_db', 4, 'clear_db.png', 16),
(20, 'Đổi mật khẩu', 'changepass', 4, 'password.png', 17),
(21, 'Nhập bảo hành', 'waranty_in', 3, 'waranty_in.png', 1),
(22, 'Trả bào hành', 'waranty_out', 3, 'waranty_out.png', 2),
(23, 'Quản lý phiếu BH', 'waranty_man', 3, 'documents.png', 3),
(24, 'Lập phiếu Thu', 'budget_input', 2, 'payment.png', 1),
(25, 'Lập phiếu Chi', 'budget_output', 2, 'moneycalculator.png', 2),
(26, 'Quản lý Thu/Chi', 'budget_report', 2, 'money.png', 3),
(27, 'Tổng hợp công nợ', 'debtsum', 2, 'piggybank.png', 4),
(28, 'Báo cáo Lãi/Lỗ', 'interest_sum', 2, 'stockmarket.png', 5),
(29, 'Công nợ khách hàng', 'debt_cus', 2, 'documents.png', 6),
(30, 'Công nợ nhà cung cấp', 'debt_sup', 2, 'documents.png', 7),
(31, 'Xuất kho bán hàng', 'output', 1, 'cart.png', 1),
(32, 'Xuất kho Nhân viên', 'move_stock', 1, 'homenext.png', 2),
(33, 'Nhập hàng', 'input_mat', 1, 'databaseup.png', 3),
(34, 'Nhập trả lại', 'mat_return', 1, 'databaseup.png', 4),
(35, 'Tách SP bán lẻ', 'mat_split', 1, 'packageicon.png', 5),
(36, 'Thống kê bán hàng', 'output_report', 1, 'documents.png', 6),
(37, 'Thống kê xuất kho NV', 'move_stock_report', 1, 'documents.png', 7),
(38, 'Thống kê nhập hàng', 'input_mat_report', 1, 'documents.png', 8),
(39, 'Thống kê hàng tồn', 'instock', 1, 'documents.png', 9),
(40, 'Thống kê hàng trả lại', 'mat_return_report', 1, 'documents.png', 10),
(41, 'Tra cứu Serial', 'search_serial', 1, 'search.png', 11),
(42, 'Đăng xuất', 'logout', 4, 'exit.png', 19),
(43, 'Quyền truy cập khác', 'other', NULL, NULL, 5),
(44, 'Truy cập toàn bộ kho nhân viên', 'empstock', 43, NULL, 1),
(45, 'Truy cập toàn bộ kho chính', 'mainstock', 43, NULL, 2),
(46, 'Điều chỉnh hàng tồn', 'mat_modify', 1, 'notesedit.png', 12),
(47, 'Công nợ nhân viên', 'debt_emp', 2, 'documents.png', 8),
(48, 'Chuyển Quỹ/Tài khoản', 'move_fund', 2, 'wallet_icon.png', 9),
(49, 'Quản lý chuyển Quỹ/TK', 'fund_invoices', 2, 'documents.png', 10),
(50, 'Tồn kho đầu kỳ', 'smm_instock', 4, 'documents.png', 15),
(51, 'Truy cập tất cả tài khoản', 'fund_all', 43, NULL, 4),
(52, 'Truy cập tài khoản chung', 'fund_general', 43, NULL, 3),
(53, 'Bộ phận xử lý', 'dept', 3, 'dept.png', 10),
(54, 'Xử lý BH - Dịch vụ', 'waranty_process', 3, 'waranty_out.png', 2),
(55, 'Lịch sử truy cập', 'login_history', 4, 'documents.png', 18),
(56, 'Sao lưu/Phục hồi dữ liệu', 'backup', 4, 'databaseup.png', 18),
(57, 'Lịch sử hệ thống', 'log_history', 4, 'documents.png', 17),
(58, 'Sửa phiếu xuất kho bán hàng', 'edit_output', 43, NULL, 5),
(59, 'Xóa phiếu xuất kho bán hàng', 'del_output', 43, NULL, 6),
(60, 'Sửa phiếu nhập kho', 'edit_input', 43, NULL, 7),
(61, 'Xóa phiếu nhập kho', 'del_input', 43, NULL, 8),
(62, 'Sửa phiếu xuất kho nhân viên', 'edit_movestock', 43, NULL, 9),
(63, 'Xóa phiếu xuất kho nhân viên', 'del_movestock', 43, NULL, 10),
(64, 'Sửa phiếu nhập trả lại', 'edit_return', 43, NULL, 11),
(65, 'Xóa phiếu nhập trả lại', 'del_return', 43, NULL, 12),
(66, 'Sửa phiếu bảo hành', 'edit_waranty', 43, NULL, 13),
(67, 'Xóa phiếu bảo hành', 'del_waranty', 43, NULL, 14),
(68, 'Sửa phiếu thu', 'edit_budget_input', 43, NULL, 15),
(69, 'Xóa phiếu thu', 'del_budget_input', 43, NULL, 16),
(70, 'Sửa phiếu chi', 'edit_budget_output', 43, NULL, 17),
(71, 'Xóa phiếu chi', 'del_budget_output', 43, NULL, 18),
(72, 'Sửa phiếu chuyển quỹ ', 'edit_movefund', 43, NULL, 19),
(73, 'Xóa phiếu chuyển quỹ', 'del_movefund', 43, NULL, 20);

-- --------------------------------------------------------

--
-- Table structure for table `fund`
--

CREATE TABLE IF NOT EXISTS `fund` (
  `fund_id` int(10) unsigned NOT NULL auto_increment,
  `fund_name` varchar(200) NOT NULL,
  `fund_type` varchar(10) NOT NULL,
  `acc_no` varchar(20) default NULL,
  `bank_name` varchar(200) default NULL,
  `amount` int(11) default '0',
  `sum` int(11) default '0',
  `user_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`fund_id`),
  KEY `fk_fund_user` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `fund`
--

INSERT INTO `fund` (`fund_id`, `fund_name`, `fund_type`, `acc_no`, `bank_name`, `amount`, `sum`, `user_id`) VALUES
(1, 'Tiền mặt tại chỗ', 'TIENMAT', '', '', 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fund_invoices`
--

CREATE TABLE IF NOT EXISTS `fund_invoices` (
  `inv_id` int(10) unsigned NOT NULL auto_increment,
  `fund_from` int(10) unsigned NOT NULL,
  `created_date` int(10) unsigned NOT NULL,
  `inv_code` varchar(10) NOT NULL,
  `amount` int(10) unsigned NOT NULL,
  `comment` varchar(255) default NULL,
  `user_id` int(10) unsigned NOT NULL,
  `fund_to` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`inv_id`),
  KEY `fk_inv_usr` (`fund_from`),
  KEY `fk_inv_usr2` (`user_id`),
  KEY `fk_inv_stock` (`fund_to`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `group_id` int(10) unsigned NOT NULL auto_increment,
  `group_name` varchar(200) NOT NULL,
  PRIMARY KEY  (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`group_id`, `group_name`) VALUES
(1, 'Quản trị viên'),
(3, 'Quản lý kho'),
(4, 'Quản lý bán hàng'),
(5, 'Kỹ thuật bảo hành'),
(6, 'Bán hàng đại lý'),
(9, 'Bán hàng tại quầy'),
(10, 'Bán hàng đa năng'),
(11, 'Kế toán bán hàng');

-- --------------------------------------------------------

--
-- Table structure for table `imo_details`
--

CREATE TABLE IF NOT EXISTS `imo_details` (
  `imd_id` int(10) unsigned NOT NULL auto_increment,
  `imo_id` int(10) unsigned NOT NULL,
  `smm_id` int(10) unsigned default NULL,
  `msp_id` int(10) unsigned default NULL,
  `back_quantity` int(10) NOT NULL default '0',
  `quantity` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`imd_id`),
  KEY `fk_imo_imd` (`imo_id`),
  KEY `fk_imd_mms` (`smm_id`),
  KEY `fk_imd_msp` (`msp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `instock_modify`
--

CREATE TABLE IF NOT EXISTS `instock_modify` (
  `imo_id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL,
  `trade_user` varchar(100) NOT NULL,
  `created_date` int(10) unsigned NOT NULL,
  `imo_code` varchar(20) NOT NULL,
  `comment` varchar(255) default NULL,
  PRIMARY KEY  (`imo_id`),
  KEY `fk_imo_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE IF NOT EXISTS `invoices` (
  `inv_id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL,
  `created_date` int(10) unsigned NOT NULL,
  `inv_code` varchar(10) NOT NULL,
  `total` int(10) unsigned NOT NULL,
  `payment` int(10) unsigned NOT NULL,
  `comment` varchar(255) default NULL,
  `vat` tinyint(3) unsigned NOT NULL default '0',
  `inv_type` tinyint(3) unsigned NOT NULL default '0',
  `sup_id` int(10) unsigned default NULL,
  `created_user` int(10) unsigned NOT NULL,
  `stock_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`inv_id`),
  KEY `fk_inv_usr` (`user_id`),
  KEY `fk_inv_sup` (`sup_id`),
  KEY `fk_inv_usr2` (`created_user`),
  KEY `fk_inv_stock` (`stock_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_details`
--

CREATE TABLE IF NOT EXISTS `invoice_details` (
  `invd_id` int(10) unsigned NOT NULL auto_increment,
  `inv_id` int(10) unsigned NOT NULL,
  `mat_quantity` float unsigned NOT NULL,
  `amount` int(10) unsigned default NULL,
  `mms_id` int(10) unsigned default NULL,
  `smm_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`invd_id`),
  KEY `fk_invd_inv` (`inv_id`),
  KEY `fk_invd_mms` (`mms_id`),
  KEY `fk_invd_smm` (`smm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='InnoDB free: 10240 kB; (`smm_id`) REFER `bms/stock_mat_msu`(' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `item_type`
--

CREATE TABLE IF NOT EXISTS `item_type` (
  `item_id` int(10) unsigned NOT NULL auto_increment,
  `item_name` varchar(100) NOT NULL,
  `item_type` tinyint(3) unsigned NOT NULL default '0',
  `budget_type` varchar(5) default NULL,
  PRIMARY KEY  (`item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=43 ;

--
-- Dumping data for table `item_type`
--

INSERT INTO `item_type` (`item_id`, `item_name`, `item_type`, `budget_type`) VALUES
(1, ' Thu khác', 0, NULL),
(2, 'Thu nợ Nhân viên', 0, 'GC'),
(3, 'Vay vốn', 0, 'VAY'),
(4, 'Thu công nợ', 0, 'CN'),
(5, 'Bán hàng', 0, 'BH'),
(7, 'Trả công nợ', 1, 'CN'),
(10, 'Tiền điện', 1, NULL),
(12, 'Văn phòng', 1, NULL),
(13, 'Sinh hoạt', 1, NULL),
(14, ' Chi khác', 1, NULL),
(16, 'Trả lương', 1, NULL),
(19, 'Chi tiếp khách', 1, NULL),
(20, 'Trả vay vốn', 1, 'VAY'),
(21, 'Thuế', 1, NULL),
(22, 'Trả lãi ngân hàng', 1, NULL),
(23, 'Trả xăng dầu', 1, NULL),
(24, 'Trả cước xe + bốc vác', 1, NULL),
(25, 'Trả tiền điện thoại', 1, NULL),
(27, 'Chi phí xe', 1, NULL),
(28, 'Chi phí sản xuất', 1, NULL),
(30, 'Vay vốn cá nhân', 0, NULL),
(31, 'Trả tiền thuê văn phòng', 1, NULL),
(32, 'Ứng lương', 1, NULL),
(35, 'Ứng tiền ăn trưa', 1, NULL),
(36, 'Mua hàng', 1, NULL),
(37, 'Ứng tiền khách đặt hàng', 0, NULL),
(38, 'Đầu tư dài hạn', 1, NULL),
(39, 'Đầu tư ngắn hạn', 0, NULL),
(40, 'Bảng quảng cáo', 0, NULL),
(41, 'Bán hàng 493 Lê Hoàn', 0, NULL),
(42, 'Thưởng', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `login_history`
--

CREATE TABLE IF NOT EXISTS `login_history` (
  `lhi_id` int(10) unsigned NOT NULL auto_increment,
  `start_time` int(11) NOT NULL default '0',
  `user_id` int(10) unsigned default NULL,
  `ip` varchar(15) NOT NULL default '',
  `agent` varchar(255) default NULL,
  `end_time` int(10) unsigned default NULL,
  `session_id` varchar(50) default NULL,
  PRIMARY KEY  (`lhi_id`),
  KEY `FK_session_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `log_id` int(10) unsigned NOT NULL auto_increment,
  `start_time` int(11) NOT NULL default '0',
  `user_id` int(10) unsigned default NULL,
  `ip` varchar(15) NOT NULL default '',
  `agent` varchar(255) default NULL,
  `end_time` int(10) unsigned default NULL,
  `action` varchar(300) default NULL,
  PRIMARY KEY  (`log_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `manufactures`
--

CREATE TABLE IF NOT EXISTS `manufactures` (
  `mfa_id` int(10) unsigned NOT NULL auto_increment,
  `mfa_name` varchar(100) NOT NULL,
  `website` varchar(45) default NULL,
  `description` varchar(255) default NULL,
  `address` varchar(200) default NULL,
  `email` varchar(100) default NULL,
  `tel` varchar(30) default NULL,
  `cat_list` text,
  PRIMARY KEY  (`mfa_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `manufactures`
--

INSERT INTO `manufactures` (`mfa_id`, `mfa_name`, `website`, `description`, `address`, `email`, `tel`, `cat_list`) VALUES
(1, 'Hãng khác', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE IF NOT EXISTS `materials` (
  `mat_id` int(10) unsigned NOT NULL auto_increment,
  `mat_name` varchar(100) NOT NULL,
  `mat_desc` text,
  `mat_quantity` int(10) unsigned NOT NULL default '0',
  `mat_price` double unsigned NOT NULL default '0',
  `mat_waranty` tinyint(3) unsigned default '0',
  `cat_id` int(10) unsigned default NULL,
  `mat_model` varchar(20) default NULL,
  `saleoff` text,
  `tax` float unsigned default NULL,
  `mat_type` int(10) unsigned default NULL,
  `barcode` varchar(20) default NULL,
  PRIMARY KEY  (`mat_id`),
  KEY `FK_mat_cat` (`cat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mat_msu`
--

CREATE TABLE IF NOT EXISTS `mat_msu` (
  `mms_id` int(10) unsigned NOT NULL auto_increment,
  `mat_id` int(10) unsigned NOT NULL,
  `msu_id` int(10) unsigned NOT NULL,
  `price` int(10) unsigned NOT NULL default '0',
  `price_dealer` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`mms_id`),
  KEY `fk_mms_msu` (`msu_id`),
  KEY `fk_mms_mat` (`mat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=552 ;

-- --------------------------------------------------------

--
-- Table structure for table `mat_return_invoices`
--

CREATE TABLE IF NOT EXISTS `mat_return_invoices` (
  `inv_id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL,
  `created_date` int(10) unsigned NOT NULL,
  `inv_code` varchar(10) NOT NULL,
  `comment` varchar(255) default NULL,
  `sup_id` int(10) unsigned default NULL,
  `created_user` int(10) unsigned NOT NULL,
  `stock_id` int(10) unsigned default NULL,
  `cus_id` int(10) unsigned default NULL,
  `emp_stock_id` int(10) unsigned default NULL,
  `total` int(10) unsigned default NULL,
  PRIMARY KEY  (`inv_id`),
  KEY `fk_inv_usr` (`user_id`),
  KEY `fk_inv_sup` (`sup_id`),
  KEY `fk_inv_usr2` (`created_user`),
  KEY `fk_inv_stock` (`stock_id`),
  KEY `fk_mri_cus` (`cus_id`),
  KEY `fk_mri_stockemp` (`emp_stock_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mat_return_invoice_details`
--

CREATE TABLE IF NOT EXISTS `mat_return_invoice_details` (
  `invd_id` int(10) unsigned NOT NULL auto_increment,
  `inv_id` int(10) unsigned NOT NULL,
  `mat_quantity` float unsigned NOT NULL,
  `amount` int(10) unsigned default NULL,
  `smm_id` int(10) unsigned default NULL,
  `serials` text,
  PRIMARY KEY  (`invd_id`),
  KEY `fk_invd_inv` (`inv_id`),
  KEY `fk_invd_smm` (`smm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='InnoDB free: 10240 kB; (`smm_id`) REFER `bms/stock_mat_msu`(' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mat_split`
--

CREATE TABLE IF NOT EXISTS `mat_split` (
  `msp_id` int(10) unsigned NOT NULL auto_increment,
  `smm_id` int(10) unsigned NOT NULL,
  `quantity` int(10) unsigned NOT NULL default '0',
  `msu_list` varchar(255) default NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_date` int(10) unsigned NOT NULL,
  `comment` varchar(255) default NULL,
  `inv_code` varchar(20) NOT NULL,
  PRIMARY KEY  (`msp_id`),
  KEY `fk_msp_mms` (`smm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `meansure`
--

CREATE TABLE IF NOT EXISTS `meansure` (
  `msu_id` int(10) unsigned NOT NULL auto_increment,
  `msu_name` varchar(45) NOT NULL,
  `msu_parid` int(10) unsigned default NULL,
  `msu_multiple` double NOT NULL default '1',
  PRIMARY KEY  (`msu_id`),
  KEY `fk_msu_msu` (`msu_parid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=85 ;

--
-- Dumping data for table `meansure`
--

INSERT INTO `meansure` (`msu_id`, `msu_name`, `msu_parid`, `msu_multiple`) VALUES
(3, 'Cái', NULL, 1),
(6, 'Kg', 7, 1000),
(7, 'Gam', NULL, 1),
(13, 'Hộp', NULL, 1),
(14, 'Chai', NULL, 1),
(15, 'Thùng', NULL, 1),
(20, 'Lọ', NULL, 1),
(21, 'Lon', NULL, 1),
(22, 'Can', NULL, 1),
(28, 'Lạng', 7, 100),
(36, 'Tạ', 7, 100000),
(38, 'Tấn', 7, 1000000),
(39, 'Cuộn', NULL, 1),
(43, 'Yến', 7, 10000),
(44, 'Bịch', NULL, 1),
(47, 'Vĩ', NULL, 1),
(49, 'Gói', NULL, 1),
(52, 'Bao', NULL, 1),
(77, 'm', NULL, 1),
(78, 'cây', NULL, 1),
(79, 'Tấm', 77, 3),
(80, 'Công', NULL, 1),
(81, 'Bảng', NULL, 1),
(82, 'Bộ', NULL, 1),
(83, 'Bông', NULL, 1),
(84, 'viên', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `mfa_mat`
--

CREATE TABLE IF NOT EXISTS `mfa_mat` (
  `mma_id` int(10) unsigned NOT NULL auto_increment,
  `mfa_id` int(10) unsigned NOT NULL,
  `mat_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`mma_id`),
  KEY `fk_mma_mat` (`mat_id`),
  KEY `fk_mma_mfa` (`mfa_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `out_invoices`
--

CREATE TABLE IF NOT EXISTS `out_invoices` (
  `inv_id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL,
  `created_date` int(10) unsigned NOT NULL,
  `inv_code` varchar(10) NOT NULL,
  `cus_id` int(10) unsigned default NULL,
  `total` int(10) unsigned NOT NULL,
  `payment` int(10) unsigned NOT NULL,
  `comment` varchar(255) default NULL,
  `vat` tinyint(3) unsigned NOT NULL default '0',
  `inv_type` tinyint(3) unsigned NOT NULL default '0',
  `created_user` int(10) unsigned NOT NULL,
  `price_type` varchar(10) default 'enduser',
  `stock_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`inv_id`),
  KEY `fk_inv_usr` (`user_id`),
  KEY `fk_inv_cus` (`cus_id`),
  KEY `fk_inv_usr2` (`created_user`),
  KEY `stock_id` (`stock_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `out_invoice_details`
--

CREATE TABLE IF NOT EXISTS `out_invoice_details` (
  `invd_id` int(10) unsigned NOT NULL auto_increment,
  `inv_id` int(10) unsigned NOT NULL,
  `mat_quantity` float unsigned NOT NULL,
  `amount` int(10) unsigned default NULL,
  `smm_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`invd_id`),
  KEY `fk_invd_inv` (`inv_id`),
  KEY `fk_invd_mms` (`smm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `out_serials`
--

CREATE TABLE IF NOT EXISTS `out_serials` (
  `serial_id` int(10) unsigned NOT NULL auto_increment,
  `serial_start` varchar(20) default NULL,
  `serial_end` varchar(20) default NULL,
  `invd_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`serial_id`),
  KEY `fk_oseri_oinvd` (`invd_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `serials`
--

CREATE TABLE IF NOT EXISTS `serials` (
  `serial_id` int(10) unsigned NOT NULL auto_increment,
  `serial_start` varchar(20) default NULL,
  `serial_end` varchar(20) default NULL,
  `invd_id` int(10) unsigned default NULL,
  `mms_id` int(10) unsigned default NULL,
  `smm_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`serial_id`),
  KEY `fk_seri_invd` (`invd_id`),
  KEY `fk_seri_mms` (`mms_id`),
  KEY `fk_seri_smm` (`smm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `session_id` varchar(32) NOT NULL default '',
  `start_time` int(11) NOT NULL default '0',
  `user_id` int(10) unsigned default '0',
  `ip` varchar(15) NOT NULL default '',
  PRIMARY KEY  (`session_id`),
  KEY `FK_session_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`session_id`, `start_time`, `user_id`, `ip`) VALUES
('vstfjtc991uuj6l8hr2nbse1b5', 1343969375, 1, '113.190.234.45');

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE IF NOT EXISTS `stocks` (
  `stock_id` int(10) unsigned NOT NULL auto_increment,
  `stock_name` varchar(200) NOT NULL,
  `address` varchar(300) NOT NULL,
  `user_id` int(10) unsigned default NULL,
  `user_list` text,
  PRIMARY KEY  (`stock_id`),
  KEY `fk_stock_usr` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`stock_id`, `stock_name`, `address`, `user_id`, `user_list`) VALUES
(1, 'Kho chính', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stock_mat_msu`
--

CREATE TABLE IF NOT EXISTS `stock_mat_msu` (
  `smm_id` int(10) unsigned NOT NULL auto_increment,
  `stock_id` int(10) unsigned NOT NULL,
  `mms_id` int(10) unsigned NOT NULL,
  `quantity` float default '0',
  `instock` float NOT NULL default '0',
  `price` float default '0',
  PRIMARY KEY  (`smm_id`),
  UNIQUE KEY `unique_smm` (`stock_id`,`mms_id`),
  KEY `fk_smm_stock` (`stock_id`),
  KEY `fk_smm_mms` (`mms_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `supliers`
--

CREATE TABLE IF NOT EXISTS `supliers` (
  `sup_id` int(10) unsigned NOT NULL auto_increment,
  `sup_name` varchar(200) NOT NULL,
  `address` varchar(200) default NULL,
  `tel` varchar(100) default NULL,
  `email` varchar(100) default NULL,
  `website` varchar(100) default NULL,
  `tax_no` varchar(20) default NULL,
  `description` varchar(255) default NULL,
  `reg_no` varchar(20) default NULL,
  `bank_acc` varchar(30) default NULL,
  `bank_name` varchar(200) default NULL,
  `debt` int(11) default '0',
  PRIMARY KEY  (`sup_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sup_mat`
--

CREATE TABLE IF NOT EXISTS `sup_mat` (
  `sma_id` int(10) unsigned NOT NULL auto_increment,
  `sup_id` int(10) unsigned NOT NULL,
  `mat_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`sma_id`),
  KEY `fk_sma_mat` (`mat_id`),
  KEY `fk_sma_sup` (`sup_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=633 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) unsigned NOT NULL auto_increment,
  `password` varchar(32) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `full_name` varchar(100) default NULL,
  `sex` tinyint(3) unsigned default NULL,
  `created_date` int(10) unsigned default NULL,
  `address` varchar(200) default NULL,
  `tel` varchar(15) default NULL,
  `description` varchar(250) default NULL,
  `group_id` int(10) unsigned default NULL,
  `dept_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`user_id`),
  KEY `fk_usr_grp` (`group_id`),
  KEY `fk_usr_dept` (`dept_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=30 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `password`, `user_name`, `email`, `full_name`, `sex`, `created_date`, `address`, `tel`, `description`, `group_id`, `dept_id`) VALUES
(1, '21232f297a57a5a743894a0e4a801fc3', 'admin', '', 'Administrator', 1, 0, '', '', NULL, 1, 1),
(22, '026150ab2d5f3d07b29c8b5ef240a16b', 'tuyenslt', '', 'Phạm Văn Tuyển', 0, 1306989573, ' Đông Hải', '01656565095', 'Quản lý tổng hợp', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_group_permission`
--

CREATE TABLE IF NOT EXISTS `user_group_permission` (
  `ugp_id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned default NULL,
  `group_id` int(10) unsigned default NULL,
  `fmenu_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`ugp_id`),
  KEY `fk_ugp_usr` (`user_id`),
  KEY `fk_ugp_grp` (`group_id`),
  KEY `fk_ugp_fmenu` (`fmenu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2335 ;

--
-- Dumping data for table `user_group_permission`
--

INSERT INTO `user_group_permission` (`ugp_id`, `user_id`, `group_id`, `fmenu_id`) VALUES
(31, NULL, 10, 20),
(32, NULL, 10, 42),
(33, NULL, 6, 31),
(34, NULL, 6, 34),
(35, NULL, 6, 35),
(36, NULL, 6, 39),
(37, NULL, 6, 40),
(38, NULL, 6, 41),
(39, NULL, 6, 20),
(40, NULL, 6, 42),
(46, NULL, 4, 31),
(47, NULL, 4, 35),
(48, NULL, 4, 36),
(49, NULL, 4, 39),
(50, NULL, 4, 40),
(51, NULL, 4, 41),
(52, NULL, 4, 20),
(53, NULL, 4, 42),
(1986, NULL, 3, 31),
(1987, NULL, 3, 32),
(1988, NULL, 3, 33),
(1989, NULL, 3, 34),
(1990, NULL, 3, 35),
(1991, NULL, 3, 36),
(1992, NULL, 3, 37),
(1993, NULL, 3, 38),
(1994, NULL, 3, 39),
(1995, NULL, 3, 40),
(1996, NULL, 3, 41),
(1997, NULL, 3, 24),
(1998, NULL, 3, 25),
(1999, NULL, 3, 21),
(2000, NULL, 3, 22),
(2001, NULL, 3, 23),
(2002, NULL, 3, 5),
(2003, NULL, 3, 6),
(2004, NULL, 3, 8),
(2005, NULL, 3, 9),
(2006, NULL, 3, 16),
(2007, NULL, 3, 50),
(2008, NULL, 3, 20),
(2009, NULL, 3, 42),
(2010, NULL, 3, 44),
(2011, NULL, 3, 45),
(2012, NULL, 3, 52),
(2013, NULL, 3, 51),
(2049, NULL, 5, 21),
(2050, NULL, 5, 22),
(2051, NULL, 5, 23),
(2052, NULL, 5, 20),
(2053, NULL, 5, 42),
(2195, NULL, 9, 31),
(2196, NULL, 9, 32),
(2197, NULL, 9, 33),
(2198, NULL, 9, 34),
(2199, NULL, 9, 35),
(2200, NULL, 9, 36),
(2201, NULL, 9, 41),
(2202, NULL, 9, 24),
(2203, NULL, 9, 21),
(2204, NULL, 9, 22),
(2205, NULL, 9, 23),
(2206, NULL, 9, 5),
(2207, NULL, 9, 20),
(2208, NULL, 9, 42),
(2209, NULL, 9, 44),
(2210, NULL, 9, 45),
(2211, NULL, 9, 51),
(2212, NULL, 1, 31),
(2213, NULL, 1, 32),
(2214, NULL, 1, 33),
(2215, NULL, 1, 34),
(2216, NULL, 1, 35),
(2217, NULL, 1, 36),
(2218, NULL, 1, 37),
(2219, NULL, 1, 38),
(2220, NULL, 1, 39),
(2221, NULL, 1, 40),
(2222, NULL, 1, 41),
(2223, NULL, 1, 46),
(2224, NULL, 1, 24),
(2225, NULL, 1, 25),
(2226, NULL, 1, 26),
(2227, NULL, 1, 27),
(2228, NULL, 1, 28),
(2229, NULL, 1, 29),
(2230, NULL, 1, 30),
(2231, NULL, 1, 47),
(2232, NULL, 1, 48),
(2233, NULL, 1, 49),
(2234, NULL, 1, 21),
(2235, NULL, 1, 22),
(2236, NULL, 1, 54),
(2237, NULL, 1, 23),
(2238, NULL, 1, 53),
(2239, NULL, 1, 5),
(2240, NULL, 1, 6),
(2241, NULL, 1, 7),
(2242, NULL, 1, 8),
(2243, NULL, 1, 9),
(2244, NULL, 1, 10),
(2245, NULL, 1, 11),
(2246, NULL, 1, 12),
(2247, NULL, 1, 13),
(2248, NULL, 1, 14),
(2249, NULL, 1, 15),
(2250, NULL, 1, 16),
(2251, NULL, 1, 17),
(2252, NULL, 1, 18),
(2253, NULL, 1, 50),
(2254, NULL, 1, 19),
(2255, NULL, 1, 20),
(2256, NULL, 1, 42),
(2257, NULL, 1, 44),
(2258, NULL, 1, 45),
(2259, NULL, 1, 52),
(2260, NULL, 1, 51),
(2296, 22, NULL, 54),
(2299, NULL, 11, 31),
(2300, NULL, 11, 32),
(2301, NULL, 11, 33),
(2302, NULL, 11, 34),
(2303, NULL, 11, 35),
(2304, NULL, 11, 36),
(2305, NULL, 11, 37),
(2306, NULL, 11, 38),
(2307, NULL, 11, 39),
(2308, NULL, 11, 40),
(2309, NULL, 11, 41),
(2310, NULL, 11, 24),
(2311, NULL, 11, 25),
(2312, NULL, 11, 26),
(2313, NULL, 11, 27),
(2314, NULL, 11, 29),
(2315, NULL, 11, 30),
(2316, NULL, 11, 47),
(2317, NULL, 11, 21),
(2318, NULL, 11, 22),
(2319, NULL, 11, 54),
(2320, NULL, 11, 23),
(2321, NULL, 11, 5),
(2322, NULL, 11, 6),
(2323, NULL, 11, 7),
(2324, NULL, 11, 8),
(2325, NULL, 11, 9),
(2326, NULL, 11, 13),
(2327, NULL, 11, 16),
(2328, NULL, 11, 50),
(2329, NULL, 11, 20),
(2330, NULL, 11, 42),
(2331, NULL, 11, 44),
(2332, NULL, 11, 45),
(2333, NULL, 11, 52),
(2334, NULL, 11, 51);

-- --------------------------------------------------------

--
-- Table structure for table `waranty_dept`
--

CREATE TABLE IF NOT EXISTS `waranty_dept` (
  `dept_id` int(10) unsigned NOT NULL auto_increment,
  `dept_name` varchar(300) NOT NULL,
  PRIMARY KEY  (`dept_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `waranty_dept`
--

INSERT INTO `waranty_dept` (`dept_id`, `dept_name`) VALUES
(1, 'Bảo hành'),
(2, 'Bảo hành điện thoại'),
(3, 'Dich Vu');

-- --------------------------------------------------------

--
-- Table structure for table `waranty_invoices`
--

CREATE TABLE IF NOT EXISTS `waranty_invoices` (
  `inv_id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL,
  `created_date` int(10) unsigned NOT NULL,
  `inv_code` varchar(10) NOT NULL,
  `comment` varchar(255) default NULL,
  `inv_status` tinyint(3) unsigned NOT NULL default '0',
  `created_user` int(10) unsigned NOT NULL,
  `cus_id` int(10) unsigned default NULL,
  `cus_name` varchar(300) default NULL,
  `dept_id` int(10) unsigned default NULL,
  `user_accept` int(10) unsigned default NULL,
  `user_finish` int(10) unsigned default NULL,
  `accept_date` int(10) unsigned default NULL,
  `address` varchar(300) default NULL,
  `tel` varchar(50) default NULL,
  PRIMARY KEY  (`inv_id`),
  KEY `fk_inv_usr` (`user_id`),
  KEY `fk_inv_usr2` (`created_user`),
  KEY `fk_inv_cus` (`cus_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `waranty_invoice_details`
--

CREATE TABLE IF NOT EXISTS `waranty_invoice_details` (
  `invd_id` int(10) unsigned NOT NULL auto_increment,
  `inv_id` int(10) unsigned NOT NULL,
  `mat_quantity` float unsigned NOT NULL,
  `serial` varchar(200) default NULL,
  `oinvd_id` int(10) unsigned default NULL,
  `return_date` int(10) unsigned default NULL,
  `mat_name` varchar(200) default NULL,
  `warn_desc` varchar(300) default NULL,
  `warn_status` tinyint(3) unsigned NOT NULL default '0',
  `service_fee` float unsigned default NULL,
  `service_type` varchar(5) default NULL,
  `inv_date` varchar(20) default NULL,
  PRIMARY KEY  (`invd_id`),
  KEY `fk_winvd_winv` (`inv_id`),
  KEY `fk_winvd_oinvd` (`oinvd_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='InnoDB free: 10240 kB; (`smm_id`) REFER `bms/stock_mat_msu`(' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `waranty_materials`
--

CREATE TABLE IF NOT EXISTS `waranty_materials` (
  `wma_id` int(10) unsigned NOT NULL auto_increment,
  `invd_id` int(10) unsigned NOT NULL,
  `mat_id` int(10) unsigned default NULL,
  `mat_name` varchar(200) NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  `waranty` varchar(50) default NULL,
  `price` float unsigned NOT NULL default '0',
  `mat_status` varchar(100) default NULL,
  PRIMARY KEY  (`wma_id`),
  KEY `invd_id` (`invd_id`),
  KEY `mat_id` (`mat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `waranty_services`
--

CREATE TABLE IF NOT EXISTS `waranty_services` (
  `wsv_id` int(10) unsigned NOT NULL auto_increment,
  `invd_id` int(10) unsigned NOT NULL,
  `service_name` varchar(200) NOT NULL,
  `service_desc` varchar(300) default NULL,
  `service_fee` float default '0',
  PRIMARY KEY  (`wsv_id`),
  KEY `invd_id` (`invd_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `budget_invoices`
--
ALTER TABLE `budget_invoices`
  ADD CONSTRAINT `fk_bin_fund` FOREIGN KEY (`fund_id`) REFERENCES `fund` (`fund_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_bin_inv` FOREIGN KEY (`inv_id`) REFERENCES `invoices` (`inv_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_bin_item` FOREIGN KEY (`item_id`) REFERENCES `item_type` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_bin_mri` FOREIGN KEY (`mriinv_id`) REFERENCES `mat_return_invoices` (`inv_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_bin_oinv` FOREIGN KEY (`oinv_id`) REFERENCES `out_invoices` (`inv_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_bin_sup` FOREIGN KEY (`sup_id`) REFERENCES `supliers` (`sup_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_bin_usr` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_bin_usr2` FOREIGN KEY (`emp_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_bin_usr3` FOREIGN KEY (`created_user`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `function_menu`
--
ALTER TABLE `function_menu`
  ADD CONSTRAINT `fk_circle_key` FOREIGN KEY (`fmenu_parid`) REFERENCES `function_menu` (`fmenu_id`) ON UPDATE CASCADE;

--
-- Constraints for table `fund`
--
ALTER TABLE `fund`
  ADD CONSTRAINT `fk_fund_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `fund_invoices`
--
ALTER TABLE `fund_invoices`
  ADD CONSTRAINT `fk_finv_fund1` FOREIGN KEY (`fund_from`) REFERENCES `fund` (`fund_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_finv_fund2` FOREIGN KEY (`fund_to`) REFERENCES `fund` (`fund_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_finv_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `imo_details`
--
ALTER TABLE `imo_details`
  ADD CONSTRAINT `fk_imd_msp` FOREIGN KEY (`msp_id`) REFERENCES `mat_split` (`msp_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_imo_imd` FOREIGN KEY (`imo_id`) REFERENCES `instock_modify` (`imo_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_imo_smm` FOREIGN KEY (`smm_id`) REFERENCES `stock_mat_msu` (`smm_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `instock_modify`
--
ALTER TABLE `instock_modify`
  ADD CONSTRAINT `fk_imo_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `fk_inv_stock` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`stock_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_inv_sup` FOREIGN KEY (`sup_id`) REFERENCES `supliers` (`sup_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_inv_usr` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_inv_usr2` FOREIGN KEY (`created_user`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `invoice_details`
--
ALTER TABLE `invoice_details`
  ADD CONSTRAINT `fk_invd_inv` FOREIGN KEY (`inv_id`) REFERENCES `invoices` (`inv_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_invd_mms` FOREIGN KEY (`mms_id`) REFERENCES `mat_msu` (`mms_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_invd_smm` FOREIGN KEY (`smm_id`) REFERENCES `stock_mat_msu` (`smm_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `materials`
--
ALTER TABLE `materials`
  ADD CONSTRAINT `fk_mat_cat` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`cat_id`) ON UPDATE CASCADE;

--
-- Constraints for table `mat_msu`
--
ALTER TABLE `mat_msu`
  ADD CONSTRAINT `fk_mms_mat` FOREIGN KEY (`mat_id`) REFERENCES `materials` (`mat_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_mms_msu` FOREIGN KEY (`msu_id`) REFERENCES `meansure` (`msu_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mat_return_invoices`
--
ALTER TABLE `mat_return_invoices`
  ADD CONSTRAINT `fk_mri_cus` FOREIGN KEY (`cus_id`) REFERENCES `customers` (`cus_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_mri_stock` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`stock_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_mri_stockemp` FOREIGN KEY (`emp_stock_id`) REFERENCES `stocks` (`stock_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_mri_sup` FOREIGN KEY (`sup_id`) REFERENCES `supliers` (`sup_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_mri_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mat_return_invoice_details`
--
ALTER TABLE `mat_return_invoice_details`
  ADD CONSTRAINT `fk_mrid_mri` FOREIGN KEY (`inv_id`) REFERENCES `mat_return_invoices` (`inv_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mat_split`
--
ALTER TABLE `mat_split`
  ADD CONSTRAINT `fk_msp_smm` FOREIGN KEY (`smm_id`) REFERENCES `stock_mat_msu` (`smm_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `meansure`
--
ALTER TABLE `meansure`
  ADD CONSTRAINT `fk_msu_msu` FOREIGN KEY (`msu_parid`) REFERENCES `meansure` (`msu_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mfa_mat`
--
ALTER TABLE `mfa_mat`
  ADD CONSTRAINT `fk_mma_mat` FOREIGN KEY (`mat_id`) REFERENCES `materials` (`mat_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_mma_mfa` FOREIGN KEY (`mfa_id`) REFERENCES `manufactures` (`mfa_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `out_invoices`
--
ALTER TABLE `out_invoices`
  ADD CONSTRAINT `fk_oinv_cus` FOREIGN KEY (`cus_id`) REFERENCES `customers` (`cus_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_oinv_usr` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_oinv_usr2` FOREIGN KEY (`created_user`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `out_invoices_ibfk_1` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`stock_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `out_invoice_details`
--
ALTER TABLE `out_invoice_details`
  ADD CONSTRAINT `fk_oinvd_oinv` FOREIGN KEY (`inv_id`) REFERENCES `out_invoices` (`inv_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_oinvd_smm` FOREIGN KEY (`smm_id`) REFERENCES `stock_mat_msu` (`smm_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `out_serials`
--
ALTER TABLE `out_serials`
  ADD CONSTRAINT `fk_oseri_oinvd` FOREIGN KEY (`invd_id`) REFERENCES `out_invoice_details` (`invd_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `serials`
--
ALTER TABLE `serials`
  ADD CONSTRAINT `fk_seri_invd` FOREIGN KEY (`invd_id`) REFERENCES `invoice_details` (`invd_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_seri_mms` FOREIGN KEY (`mms_id`) REFERENCES `mat_msu` (`mms_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_seri_smm` FOREIGN KEY (`smm_id`) REFERENCES `stock_mat_msu` (`smm_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `fk_ssi_usr` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stocks`
--
ALTER TABLE `stocks`
  ADD CONSTRAINT `fk_stock_usr` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `stock_mat_msu`
--
ALTER TABLE `stock_mat_msu`
  ADD CONSTRAINT `fk_smm_mms` FOREIGN KEY (`mms_id`) REFERENCES `mat_msu` (`mms_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_smm_stock` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`stock_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sup_mat`
--
ALTER TABLE `sup_mat`
  ADD CONSTRAINT `fk_sma_mat` FOREIGN KEY (`mat_id`) REFERENCES `materials` (`mat_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sma_sup` FOREIGN KEY (`sup_id`) REFERENCES `supliers` (`sup_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_usr_dept` FOREIGN KEY (`dept_id`) REFERENCES `dept` (`dept_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_usr_grp` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON UPDATE CASCADE;

--
-- Constraints for table `user_group_permission`
--
ALTER TABLE `user_group_permission`
  ADD CONSTRAINT `fk_ugp_gr` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ugp_usr` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `waranty_invoice_details`
--
ALTER TABLE `waranty_invoice_details`
  ADD CONSTRAINT `fk_winvd_oinvd` FOREIGN KEY (`oinvd_id`) REFERENCES `out_invoice_details` (`invd_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_winvd_winv` FOREIGN KEY (`inv_id`) REFERENCES `waranty_invoices` (`inv_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `waranty_materials`
--
ALTER TABLE `waranty_materials`
  ADD CONSTRAINT `waranty_materials_ibfk_1` FOREIGN KEY (`invd_id`) REFERENCES `waranty_invoice_details` (`invd_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `waranty_materials_ibfk_2` FOREIGN KEY (`mat_id`) REFERENCES `materials` (`mat_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `waranty_services`
--
ALTER TABLE `waranty_services`
  ADD CONSTRAINT `waranty_services_ibfk_1` FOREIGN KEY (`invd_id`) REFERENCES `waranty_invoice_details` (`invd_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
