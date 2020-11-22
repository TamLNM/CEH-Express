-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2020 at 06:09 AM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vk`
--

-- --------------------------------------------------------

--
-- Table structure for table `budget_invoices`
--

CREATE TABLE `budget_invoices` (
  `bin_id` int(10) UNSIGNED NOT NULL,
  `item_id` int(10) UNSIGNED NOT NULL,
  `created_date` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `bin_code` varchar(10) NOT NULL,
  `amount` int(11) NOT NULL,
  `bin_type` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `cus_id` int(10) UNSIGNED DEFAULT NULL,
  `sup_id` int(10) UNSIGNED DEFAULT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `emp_id` int(10) UNSIGNED DEFAULT NULL,
  `inv_id` int(10) UNSIGNED DEFAULT NULL,
  `created_user` int(10) UNSIGNED NOT NULL,
  `oinv_id` int(10) UNSIGNED DEFAULT NULL,
  `fund_id` int(10) UNSIGNED NOT NULL,
  `mriinv_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `budget_invoices`
--

INSERT INTO `budget_invoices` (`bin_id`, `item_id`, `created_date`, `user_id`, `bin_code`, `amount`, `bin_type`, `cus_id`, `sup_id`, `user_name`, `comment`, `emp_id`, `inv_id`, `created_user`, `oinv_id`, `fund_id`, `mriinv_id`) VALUES
(1, 7, 1575347310, 1, 'PC00000001', 20000, 1, NULL, 1, NULL, 'Trả tiền nhập hàng phiếu NK00000001', NULL, 1, 1, NULL, 1, NULL),
(2, 7, 1577156466, 1, 'PC00000002', 10000000, 1, NULL, 1, NULL, 'Trả tiền nhập hàng phiếu NK00000003', NULL, 3, 1, NULL, 1, NULL),
(3, 7, 1577261472, 1, 'PC00000003', 200000000, 1, NULL, 2, NULL, 'Trả tiền nhập hàng phiếu NK00000004', NULL, 4, 1, NULL, 1, NULL),
(4, 7, 1577261472, 1, 'PC00000004', 200000000, 1, NULL, 2, NULL, 'Trả tiền nhập hàng phiếu NK00000005', NULL, 5, 1, NULL, 1, NULL),
(5, 7, 1577262142, 1, 'PC00000005', 250000000, 1, NULL, 2, NULL, 'Trả tiền nhập hàng phiếu NK00000006', NULL, 6, 1, NULL, 1, NULL),
(7, 7, 1578020949, 1, 'PC00000006', 2147483647, 1, NULL, 2, NULL, 'Trả tiền nhập hàng phiếu NK00000007', NULL, 7, 1, NULL, 1, NULL),
(8, 4, 1578021195, 1, 'PT00000008', 12000000, 0, 1, NULL, NULL, '', NULL, NULL, 1, NULL, 5, NULL),
(9, 7, 1578378020, 1, 'PC00000009', 50000000, 1, NULL, 1, NULL, 'Trả tiền nhập hàng phiếu NK00000008', NULL, 8, 1, NULL, 1, NULL),
(10, 5, 1578392728, 1, 'PT00000010', 11000000, 0, 1, NULL, NULL, 'Nộp tiền bán hàng phiếu XK00000009', NULL, NULL, 1, 9, 5, NULL),
(11, 43, 1578393091, 1, 'PC00000011', 1000000, 1, NULL, NULL, NULL, '', NULL, NULL, 1, 9, 5, NULL),
(12, 7, 1578555889, 1, 'PC00000012', 11220000, 1, NULL, 2, NULL, 'Trả tiền nhập hàng phiếu NK00000009', NULL, 9, 1, NULL, 1, NULL),
(13, 7, 1578637541, 1, 'PC00000013', 200000, 1, NULL, 2, NULL, 'Trả tiền nhập hàng phiếu NK00000010', NULL, 10, 1, NULL, 1, NULL),
(14, 7, 1578644605, 1, 'PC00000014', 1531110, 1, NULL, 3, NULL, 'Trả tiền nhập hàng phiếu NK00000011', NULL, 11, 1, NULL, 1, NULL),
(15, 7, 1578895323, 1, 'PC00000015', 200000000, 1, NULL, 1, NULL, 'Trả tiền nhập hàng phiếu NK00000014', NULL, 14, 1, NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(10) UNSIGNED NOT NULL,
  `cat_name` varchar(200) NOT NULL DEFAULT '',
  `cat_order` tinyint(3) UNSIGNED DEFAULT NULL,
  `cat_type` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_name`, `cat_order`, `cat_type`) VALUES
(1, 'RUỘT GẮN MÁY', NULL, NULL),
(2, 'VỎ GẮN MÁY', NULL, NULL),
(3, 'VỎ MÔ TÔ', NULL, NULL),
(4, 'VỎ TAY GA', NULL, NULL),
(5, 'VỎ DU LỊCH', NULL, NULL),
(6, 'VỎ TẢI', NULL, NULL),
(7, 'RUỘT VỎ TẢI', NULL, NULL),
(8, 'YẾM VỎ TẢI', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `congno`
--

CREATE TABLE `congno` (
  `cn_id` int(11) NOT NULL,
  `target_id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 1,
  `content` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `price` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `inv_id` int(11) NOT NULL DEFAULT 0,
  `i_inv_id` int(11) NOT NULL DEFAULT 0,
  `tg` int(11) DEFAULT 0,
  `type_of` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `congno`
--

INSERT INTO `congno` (`cn_id`, `target_id`, `user_id`, `content`, `price`, `status`, `inv_id`, `i_inv_id`, `tg`, `type_of`) VALUES
(1, 0, 1, 'Phí nao do (Đơn nhập hàng NK00000009)', 220000, 0, 0, 9, 1578556199, 1),
(2, 0, 1, 'Phí ... (Đơn nhập hàng NK00000011)', 611110, 0, 0, 11, 1578644735, 1);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `cus_id` int(10) UNSIGNED NOT NULL,
  `cus_name` varchar(200) NOT NULL,
  `address` varchar(200) DEFAULT NULL,
  `tel` varchar(100) DEFAULT NULL,
  `cus_code` varchar(20) CHARACTER SET latin1 NOT NULL,
  `comment` varchar(200) DEFAULT NULL,
  `tax_no` varchar(20) DEFAULT NULL,
  `reg_no` varchar(20) DEFAULT NULL,
  `fax` varchar(200) DEFAULT '',
  `bank_acc` varchar(30) DEFAULT NULL,
  `bank_name` varchar(200) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `website` varchar(100) DEFAULT NULL,
  `cus_type` varchar(20) DEFAULT NULL,
  `debt` int(11) DEFAULT 0,
  `daidien` varchar(200) NOT NULL DEFAULT '',
  `tel_dd` varchar(200) NOT NULL DEFAULT '',
  `chucvu` varchar(200) NOT NULL DEFAULT '',
  `max_debt` bigint(20) NOT NULL DEFAULT 0,
  `taikhoan` varchar(50) NOT NULL DEFAULT '',
  `duno` bigint(20) NOT NULL DEFAULT 0,
  `duco` bigint(20) NOT NULL DEFAULT 0,
  `duno_nt` bigint(20) NOT NULL DEFAULT 0,
  `duco_nt` bigint(20) NOT NULL DEFAULT 0,
  `duno_dn` bigint(20) NOT NULL DEFAULT 0,
  `duco_dn` bigint(20) NOT NULL DEFAULT 0,
  `duno_ntdn` bigint(20) NOT NULL DEFAULT 0,
  `duco_ntdn` bigint(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`cus_id`, `cus_name`, `address`, `tel`, `cus_code`, `comment`, `tax_no`, `reg_no`, `fax`, `bank_acc`, `bank_name`, `email`, `website`, `cus_type`, `debt`, `daidien`, `tel_dd`, `chucvu`, `max_debt`, `taikhoan`, `duno`, `duco`, `duno_nt`, `duco_nt`, `duno_dn`, `duco_dn`, `duno_ntdn`, `duco_ntdn`) VALUES
(1, 'Khách lẻ', '', '', 'KH00000001', '', '', '', '', '', '', '', '', 'DN', 0, '', '', '', 0, '1111', 0, 0, 0, 0, 0, 0, 0, 0),
(2, 'sao bác dau ', '', '', 'KH00000002', '', 'cds', '', '', '', '', 'jfkdj', '', 'LE', 0, '1a', '2b', '3c', 4, '1111', 1, 2, 3, 4, 5, 6, 7, 8);

-- --------------------------------------------------------

--
-- Table structure for table `dept`
--

CREATE TABLE `dept` (
  `dept_id` int(10) UNSIGNED NOT NULL,
  `dept_name` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dept`
--

INSERT INTO `dept` (`dept_id`, `dept_name`) VALUES
(1, 'Phòng Kinh Doanh'),
(2, 'Phòng Giám Đốc'),
(3, 'Phòng Kế Toán'),
(4, 'Phòng Kỹ Thuật'),
(5, 'Phòng chăm sóc KH'),
(6, 'Phòng hành chính'),
(7, 'Phòng Bảo hành'),
(8, 'Phòng hội đồng quản trị');

-- --------------------------------------------------------

--
-- Table structure for table `domains`
--

CREATE TABLE `domains` (
  `sdo_id` int(10) UNSIGNED NOT NULL,
  `domain_name` varchar(255) NOT NULL,
  `sdo_active` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `sdo_default` tinyint(3) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `function_menu`
--

CREATE TABLE `function_menu` (
  `fmenu_id` int(10) UNSIGNED NOT NULL,
  `fmenu_name` varchar(200) NOT NULL,
  `fmenu_act` varchar(50) DEFAULT NULL,
  `fmenu_parid` int(10) UNSIGNED DEFAULT NULL,
  `fmenu_img` varchar(100) DEFAULT NULL,
  `order_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(18, 'Thiết lập phần mềm', 'head_title', 4, 'setting.png', 22),
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
(43, 'Quyền truy cập khác', 'other', NULL, NULL, 6),
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
(58, 'Sửa phiếu xuất kho bán hàng', 'edit_output', 80, NULL, 5),
(59, 'Xóa phiếu xuất kho bán hàng', 'del_output', 80, NULL, 6),
(60, 'Sửa phiếu nhập kho', 'edit_input', 80, NULL, 7),
(61, 'Xóa phiếu nhập kho', 'del_input', 80, NULL, 8),
(62, 'Sửa phiếu xuất kho nhân viên', 'edit_movestock', 80, NULL, 9),
(63, 'Xóa phiếu xuất kho nhân viên', 'del_movestock', 80, NULL, 10),
(64, 'Sửa phiếu nhập trả lại', 'edit_return', 80, NULL, 11),
(65, 'Xóa phiếu nhập trả lại', 'del_return', 80, NULL, 12),
(66, 'Sửa phiếu bảo hành', 'edit_waranty', 80, NULL, 13),
(67, 'Xóa phiếu bảo hành', 'del_waranty', 80, NULL, 14),
(68, 'Sửa phiếu thu', 'edit_budget_input', 80, NULL, 15),
(69, 'Xóa phiếu thu', 'del_budget_input', 80, NULL, 16),
(70, 'Sửa phiếu chi', 'edit_budget_output', 80, NULL, 17),
(71, 'Xóa phiếu chi', 'del_budget_output', 80, NULL, 18),
(72, 'Sửa phiếu chuyển quỹ ', 'edit_movefund', 80, NULL, 19),
(73, 'Xóa phiếu chuyển quỹ', 'del_movefund', 80, NULL, 20),
(74, 'Xuất kho nội bộ', 'mat_move', 1, 'homenext.png', 12),
(75, 'Thống kê xuất kho nội bộ', 'mat_move_report', 1, 'documents.png', 13),
(76, 'Sửa phiếu xuất kho nội bộ', 'edit_mat_move', 80, NULL, 21),
(77, 'Xóa phiếu xuất kho nội bộ', 'del_mat_move', 80, NULL, 22),
(78, 'Xem tất cả giá nhập hàng', 'view_input_price', 43, NULL, 23),
(79, 'Xem tất cả giá bán hàng', 'view_output_price', 43, NULL, 24),
(80, 'Quyền cập nhật', 'update', NULL, NULL, 5),
(81, 'QL toàn bộ phiếu bán hàng', 'view_output_all', 43, NULL, 5),
(82, 'QL toàn bộ phiếu nhập hàng', 'view_input_all', 43, NULL, 6),
(83, 'QL toàn bộ phiếu xuất kho NV', 'view_move_stock_all', 43, NULL, 7),
(84, 'QL toàn bộ phiếu trả lại', 'view_mat_return_all', 43, NULL, 8),
(85, 'QL toàn bộ phiếu XK nội bộ', 'view_mat_move_all', 43, NULL, 9),
(86, 'QL toàn bộ phiếu bảo hành', 'view_waranty_all', 43, NULL, 10),
(87, 'QL toàn bộ phiếu thu', 'view_budget_input_all', 43, NULL, 11),
(88, 'QL toàn bộ phiếu chi', 'view_budget_output_all', 43, NULL, 12),
(89, 'QL toàn bộ phiếu chuyển quỹ', 'view_move_fund_all', 43, NULL, 13),
(90, 'QL toàn bộ công nợ khách hàng', 'view_cusdebpt_all', 43, NULL, 14),
(91, 'QL toàn bộ công nợ nhà cung cấp', 'view_supdebt_all', 43, NULL, 15),
(92, 'Sửa lùi/vượt tháng phiếu nhập', 'edit_all_input', 43, NULL, 16),
(93, 'Sửa lùi/vượt tháng phiếu xuất', 'edit_all_output', 43, NULL, 17),
(94, 'Thống kê hàng Khuyến mãi', 'mat_adv_report', 1, 'documents.png', 14),
(95, 'Quản lý tên miền', 'domain_assign', 4, 'regdomain.png', 19),
(96, 'Dòng tiền', 'baocao', 2, 'wallet_icon.png', 22),
(97, 'Báo cáo VAT', 'bc_vat', 2, 'wallet_icon.png', 99),
(98, 'Quản lý loại quỹ tài khoản', 'fund_type', 4, 'wallet_icon.png', 99),
(99, 'Chi tiết quỹ, tài khoản', 'fund_list', 4, 'wallet_icon.png', 99),
(100, 'Công nợ tất cả nhà cung cấp', 'debt_sup_all', 2, 'documents.png', 999),
(101, 'Nhập xuất tồn theo tháng', 'rp_nxt', 1, 'documents.png', 999),
(102, 'Doanh số theo tháng', 'rp_doanhso', 1, 'documents.png', 1999),
(103, 'Báo cáo doanh số theo khách hàng', 'rp_dskh', 1, 'documents.png', 2999);

-- --------------------------------------------------------

--
-- Table structure for table `fund`
--

CREATE TABLE `fund` (
  `fund_id` int(10) UNSIGNED NOT NULL,
  `fund_name` varchar(200) NOT NULL,
  `fund_type` int(11) NOT NULL DEFAULT 2,
  `acc_no` varchar(20) DEFAULT NULL,
  `bank_name` varchar(200) DEFAULT NULL,
  `amount` int(11) DEFAULT 0,
  `sum` int(11) DEFAULT 0,
  `user_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fund`
--

INSERT INTO `fund` (`fund_id`, `fund_name`, `fund_type`, `acc_no`, `bank_name`, `amount`, `sum`, `user_id`) VALUES
(1, 'Tiền mặt tại chỗ', 2, '', '', 0, -2147483648, NULL),
(2, 'CỬA HÀNG LINH KIỆN MÁY TÍNH T.H.A ', 2, '194.597', '-ACB', 0, 0, NULL),
(3, 'HỒ THỊ NHƯ Ý', 2, '227580359', '-ACB', 0, -1500000, NULL),
(4, 'HỒ THỊ NHƯ Ý', 2, '0071001304789', 'Vietcombank', 0, 0, NULL),
(5, 'CÔNG TY CỔ PHẦN GIẢI PHÁP MÁY CHỦ VIỆT', 2, '6460201006026', 'Agribank', 0, 22000000, NULL),
(6, 'CÔNG TY CỔ PHẦN GIẢI PHÁP MÁY CHỦ VIỆT', 2, '210014851017351', 'Eximbank', 0, 0, NULL),
(7, 'CÔNG TY CỔ PHẦN GIẢI PHÁP MÁY CHỦ VIỆT', 2, '9798868', '-ACB', 0, 0, NULL),
(8, 'Nguyễn Thị Phương Trâm', 2, '0441004014644', 'Vietcombank', 0, 0, NULL),
(9, 'Tiền mặt Hà Nội', 2, '', '', 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fund_invoices`
--

CREATE TABLE `fund_invoices` (
  `inv_id` int(10) UNSIGNED NOT NULL,
  `fund_from` int(10) UNSIGNED NOT NULL,
  `created_date` int(10) UNSIGNED NOT NULL,
  `inv_code` varchar(10) NOT NULL,
  `amount` int(10) UNSIGNED NOT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `fund_to` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fund_type`
--

CREATE TABLE `fund_type` (
  `fund_type_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `fund_type_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fund_type_code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `ft_currency` varchar(4) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'VND',
  `ft_level` int(11) NOT NULL DEFAULT 1,
  `view_debt` int(11) NOT NULL DEFAULT 1,
  `query_list` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `created_by` int(11) NOT NULL DEFAULT 0,
  `updated_by` int(11) NOT NULL DEFAULT 0,
  `created_time` int(11) NOT NULL DEFAULT 0,
  `updated_time` int(11) NOT NULL DEFAULT 0,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `orderby` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fund_type`
--

INSERT INTO `fund_type` (`fund_type_id`, `parent_id`, `fund_type_name`, `fund_type_code`, `ft_currency`, `ft_level`, `view_debt`, `query_list`, `created_by`, `updated_by`, `created_time`, `updated_time`, `description`, `orderby`) VALUES
(1, 4, 'Tiền mặt', '111', 'VND', 1, 1, '1,4', 0, 0, 0, 0, '', 0),
(2, 1, 'Tiền việt nam', '1111', 'VND', 2, 0, '2,1,4', 0, 0, 0, 0, '', 0),
(3, 1, 'Ngoại tệ', '1112', 'VND', 2, 1, '3,1,4', 0, 0, 0, 0, '', 0),
(4, 0, 'LOẠI TÀI KHOẢN TÀI SẢN', '1', 'VND', 0, 1, '4', 0, 0, 0, 0, '', 0),
(6, 5, 'Tiền aa', '1112', 'VND', 4, 1, '5,3,1,4', 1, 1, 1578382545, 1578383032, '0', 0),
(15, 11, 'L2', '222', 'VND', 1, 1, '11', 1, 0, 1578456789, 0, '', 0),
(16, 0, 'Loai 2', '2', 'USD', 0, 1, '', 1, 0, 1578456820, 0, '', 1),
(17, 16, 'Loai 222', '222', 'USD', 1, 1, '16', 1, 0, 1578456829, 0, '', 1),
(18, 16, 'Loai 221', '221', 'USD', 1, 1, '16', 1, 0, 1578456839, 0, '', 1),
(19, 18, 'Loai 221a', '221a', 'USD', 2, 1, '18,16', 1, 0, 1578456861, 0, '', 1),
(21, 4, 'Hàng hóa', '156', 'VND', 1, 1, '4', 1, 0, 1578476103, 0, '', 0),
(22, 21, 'Giá mua hàng hóa', '1561', 'VND', 2, 1, '21,4', 1, 0, 1578476122, 0, '', 0),
(23, 21, 'Chi phí thu mua hàng hóa', '1562', 'VND', 2, 1, '21,4', 1, 0, 1578476140, 0, '', 0),
(24, 0, 'LOẠI TÀI KHOẢN CHI PHÍ SẢN XUẤT, KINH DOANH', '6', 'VND', 0, 1, '', 1, 0, 1578476184, 0, '', 0),
(25, 24, 'Giá vốn hàng bán', '632', 'VND', 1, 1, '24', 1, 0, 1578476213, 0, '', 0),
(26, 0, 'LOẠI TÀI KHOẢN DOANH THU', '5', 'VND', 0, 1, '', 1, 0, 1578476249, 0, '', 0),
(27, 26, 'Doanh thu bán hàng và cung cấp dịch vụ', '511', 'VND', 1, 1, '26', 1, 0, 1578476349, 0, '', 0),
(28, 27, 'Doanh thu bán hàng hóa', '5111', 'VND', 2, 1, '27,26', 1, 0, 1578476377, 0, '', 0),
(29, 26, 'Các khoản giảm trừ doanh thu', '521', 'VND', 1, 1, '26', 1, 0, 1578476472, 0, '', 0),
(30, 29, 'Chiết khấu thương mại', '5211', 'VND', 2, 1, '29,26', 1, 0, 1578476496, 0, '', 0),
(31, 29, 'Hàng bán bị trả lại', '5212', 'VND', 2, 1, '29,26', 1, 0, 1578476513, 0, '', 0),
(32, 4, 'Chi phí sản xuất, kinh doanh dở dang', '154', 'VND', 1, 1, '4', 1, 0, 1578476618, 0, '', 0),
(33, 1, 'Vàng tiền tệ', '1113', 'VND', 2, 1, '1,4', 1, 0, 1578479970, 0, '', 0),
(34, 4, 'Tiền gửi Ngân hàng', '112', 'VND', 1, 1, '4', 1, 0, 1578480022, 0, '', 0),
(35, 34, 'Tiền Việt Nam', '1121', 'VND', 2, 1, '34,4', 1, 0, 1578480032, 0, '', 0),
(36, 34, 'Ngoại tệ', '1122', 'USD', 2, 1, '34,4', 1, 0, 1578480057, 0, '', 0),
(37, 34, 'Vàng tiền tệ', '1123', 'VND', 2, 1, '34,4', 1, 0, 1578480071, 0, '', 0),
(38, 4, 'Tiền đang chuyển', '113', 'VND', 1, 1, '4', 1, 0, 1578480125, 0, '', 0),
(39, 38, 'Tiền Việt Nam', '1131', 'VND', 2, 1, '38,4', 1, 0, 1578480133, 0, '', 0),
(40, 38, 'Ngoại tệ', '1132', 'VND', 2, 1, '38,4', 1, 0, 1578480147, 0, '', 0),
(41, 4, 'Chứng khoán kinh doanh', '121', 'VND', 1, 1, '4', 1, 0, 1578480173, 0, '', 0),
(42, 41, 'Cổ phiếu', '1211', 'VND', 2, 1, '41,4', 1, 0, 1578480211, 0, '', 0),
(43, 41, 'Trái phiếu', '1212', 'VND', 2, 1, '41,4', 1, 0, 1578480224, 0, '', 0),
(44, 41, 'Chứng khoán và công cụ tài chính khác', '1218', 'VND', 2, 1, '41,4', 1, 0, 1578480236, 0, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `group_id` int(10) UNSIGNED NOT NULL,
  `group_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
-- Table structure for table `hoadon`
--

CREATE TABLE `hoadon` (
  `id_hd` int(11) NOT NULL,
  `inv_id` int(11) NOT NULL DEFAULT 0,
  `i_inv_id` int(11) NOT NULL DEFAULT 0,
  `kyhieu` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sohoadon` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ngaylap` int(11) NOT NULL DEFAULT 0,
  `tkvathd` int(11) NOT NULL DEFAULT 0,
  `nhomhd` int(11) NOT NULL DEFAULT 0,
  `tg` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `imo_details`
--

CREATE TABLE `imo_details` (
  `imd_id` int(10) UNSIGNED NOT NULL,
  `imo_id` int(10) UNSIGNED NOT NULL,
  `smm_id` int(10) UNSIGNED DEFAULT NULL,
  `msp_id` int(10) UNSIGNED DEFAULT NULL,
  `back_quantity` int(10) NOT NULL DEFAULT 0,
  `quantity` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `instock_modify`
--

CREATE TABLE `instock_modify` (
  `imo_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `trade_user` varchar(100) NOT NULL,
  `created_date` int(10) UNSIGNED NOT NULL,
  `imo_code` varchar(20) NOT NULL,
  `comment` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `inv_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_date` int(10) UNSIGNED NOT NULL,
  `inv_code` varchar(10) NOT NULL,
  `total` int(10) UNSIGNED NOT NULL,
  `payment` int(10) UNSIGNED NOT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `vat` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `inv_type` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `sup_id` int(10) UNSIGNED DEFAULT NULL,
  `created_user` int(10) UNSIGNED NOT NULL,
  `stock_id` int(10) UNSIGNED DEFAULT NULL,
  `draft` tinyint(1) DEFAULT NULL,
  `max_time` int(11) DEFAULT 0,
  `tkc` varchar(50) NOT NULL DEFAULT '',
  `kyhieu` varchar(50) NOT NULL DEFAULT '',
  `id_truy` varchar(50) NOT NULL DEFAULT '',
  `tkvat` varchar(50) NOT NULL DEFAULT '',
  `nhomhd` int(11) NOT NULL DEFAULT 0,
  `sohd` varchar(50) NOT NULL DEFAULT '',
  `kyhieuhd` varchar(50) NOT NULL DEFAULT '',
  `ngaylaphd` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`inv_id`, `user_id`, `created_date`, `inv_code`, `total`, `payment`, `comment`, `vat`, `inv_type`, `sup_id`, `created_user`, `stock_id`, `draft`, `max_time`, `tkc`, `kyhieu`, `id_truy`, `tkvat`, `nhomhd`, `sohd`, `kyhieuhd`, `ngaylaphd`) VALUES
(1, 1, 1575347310, 'NK00000001', 20000, 20000, '', 0, 1, 1, 1, 1, NULL, 1575347310, '', '', '', '', 0, '', '', 0),
(2, 1, 1575364640, 'NK00000002', 0, 0, '', 0, 1, 2, 1, 15, NULL, 1575364640, '', '', '', '', 0, '', '', 0),
(3, 1, 1577156466, 'NK00000003', 10000000, 10000000, '', 0, 1, 1, 1, 1, NULL, 1577156466, '', '', '', '', 0, '', '', 0),
(4, 1, 1577261472, 'NK00000004', 200000000, 200000000, '', 0, 1, 2, 1, 1, NULL, 1577261472, '', '', '', '', 0, '', '', 0),
(5, 1, 1577261472, 'NK00000005', 200000000, 200000000, '', 0, 1, 2, 1, 1, NULL, 1577261472, '', '', '', '', 0, '', '', 0),
(6, 1, 1577262142, 'NK00000006', 250000000, 250000000, '', 0, 1, 2, 1, 1, NULL, 1577262142, '', '', '', '', 0, '', '', 0),
(7, 1, 1578020949, 'NK00000007', 4294967295, 4294967295, '', 0, 1, 2, 1, 15, NULL, 1578020949, '', '', '', '', 0, '', '', 0),
(8, 1, 1578378020, 'NK00000008', 50000000, 50000000, '', 0, 1, 1, 1, 15, NULL, 1578378020, '', '', '', '', 0, '', '', 0),
(9, 1, 1578555889, 'NK00000009', 11220000, 11220000, '', 0, 1, 2, 1, 15, NULL, 1578555889, '331', '', '', '', 0, '', '', 0),
(10, 1, 1578637541, 'NK00000010', 200000, 200000, '', 0, 1, 2, 1, 15, NULL, 1578637541, '111', '', '', '1111', 1, '7777777', 'KH77', 1580403600),
(11, 1, 1578644605, 'NK00000011', 1531110, 1531110, '', 0, 1, 3, 1, 15, NULL, 1578644605, '111', '', '', '1111', 1, '7777777', '2222', 1579712400),
(12, 1, 1578715933, 'NK00000012', 5800000, 0, '', 0, 1, 2, 1, 15, NULL, 1578715933, '1111', '', '', '1111', 1, '7777777', '211', 1577811600),
(13, 1, 1578890745, 'NK00000013', 0, 0, '', 0, 1, 2, 1, 15, NULL, 1578890745, '', '', '', '', 0, '', '', 0),
(14, 1, 1578895323, 'NK00000014', 200000000, 200000000, '', 0, 1, 1, 1, 15, NULL, 1578895323, '', '', '', '', 0, '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_details`
--

CREATE TABLE `invoice_details` (
  `invd_id` int(10) UNSIGNED NOT NULL,
  `inv_id` int(10) UNSIGNED NOT NULL,
  `mat_quantity` float UNSIGNED NOT NULL,
  `amount` int(10) UNSIGNED DEFAULT NULL,
  `mms_id` int(10) UNSIGNED DEFAULT NULL,
  `smm_id` int(10) UNSIGNED DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `vat` tinyint(2) NOT NULL DEFAULT 0,
  `stock_id` int(11) NOT NULL DEFAULT 1,
  `old_price` int(11) NOT NULL DEFAULT 0,
  `old_quantity` int(11) NOT NULL DEFAULT 0,
  `instock_time` int(11) NOT NULL DEFAULT 0,
  `tkvt` varchar(100) NOT NULL DEFAULT '',
  `chiphi` int(11) NOT NULL DEFAULT 0,
  `inprice` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='InnoDB free: 10240 kB; (`smm_id`) REFER `bms/stock_mat_msu`(';

--
-- Dumping data for table `invoice_details`
--

INSERT INTO `invoice_details` (`invd_id`, `inv_id`, `mat_quantity`, `amount`, `mms_id`, `smm_id`, `price`, `vat`, `stock_id`, `old_price`, `old_quantity`, `instock_time`, `tkvt`, `chiphi`, `inprice`) VALUES
(1, 1, 1, 20000, 173, NULL, 20000, 0, 3, 0, 0, 0, '', 0, 0),
(2, 2, 1, 0, 173, NULL, 0, 0, 3, 0, 0, 0, '', 0, 0),
(3, 3, 50, 10000000, 20, NULL, 200000, 0, 3, 0, 0, 0, '', 0, 0),
(4, 4, 100, 200000000, 191, NULL, 2000000, 0, 3, 0, 0, 0, '', 0, 0),
(5, 5, 100, 200000000, 191, NULL, 2000000, 0, 3, 0, 0, 0, '', 0, 0),
(6, 6, 50, 250000000, 145, NULL, 5000000, 0, 3, 0, 0, 0, '', 0, 0),
(7, 7, 8888, 4294967295, 191, NULL, 1000000, 0, 15, 0, 0, 0, '', 0, 0),
(8, 8, 1000, 50000000, 191, NULL, 50000, 0, 15, 0, 0, 0, '', 0, 0),
(9, 9, 100, 11000000, 145, NULL, 100000, 10, 15, 0, 0, 0, '1561', 0, 0),
(10, 10, 1, 200000, 191, NULL, 200000, 0, 15, 0, 0, 0, '111', 0, 0),
(11, 11, 1, 20000, 173, NULL, 20000, 0, 15, 0, 0, 0, '1561', 13285, 33285),
(12, 11, 1, 300000, 21, NULL, 300000, 0, 15, 0, 0, 0, '1561', 199275, 499275),
(13, 11, 1, 600000, 147, NULL, 600000, 0, 15, 0, 0, 0, '1561', 398550, 998550),
(14, 12, 2, 5800000, 191, NULL, 2900000, 0, 15, 0, 0, 0, '111', 0, 0),
(15, 13, 1, 0, 172, NULL, 0, 0, 15, 0, 0, 0, '', 0, 0),
(16, 14, 100, 200000000, 145, NULL, 2000000, 0, 15, 0, 0, 0, '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `item_type`
--

CREATE TABLE `item_type` (
  `item_id` int(10) UNSIGNED NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `item_type` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `budget_type` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(42, 'Thưởng', 1, NULL),
(43, 'Đóng VAT', 1, 'VAT'),
(44, 'Thu Phụ Phí Đơn Hàng', 0, NULL),
(45, 'Chi Phụ Phí Đơn Hàng', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `login_history`
--

CREATE TABLE `login_history` (
  `lhi_id` int(10) UNSIGNED NOT NULL,
  `start_time` int(11) NOT NULL DEFAULT 0,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `ip` varchar(15) NOT NULL DEFAULT '',
  `agent` varchar(255) DEFAULT NULL,
  `end_time` int(10) UNSIGNED DEFAULT NULL,
  `session_id` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `login_history`
--

INSERT INTO `login_history` (`lhi_id`, `start_time`, `user_id`, `ip`, `agent`, `end_time`, `session_id`) VALUES
(1, 1486368690, 1, '116.104.55.8', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:51.0) Gecko/20100101 Firefox/51.0', 1486368842, NULL),
(2, 1486368889, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', NULL, NULL),
(3, 1486370700, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:51.0) Gecko/20100101 Firefox/51.0', NULL, NULL),
(4, 1486374997, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:51.0) Gecko/20100101 Firefox/51.0', NULL, NULL),
(5, 1486438592, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:51.0) Gecko/20100101 Firefox/51.0', NULL, NULL),
(6, 1486439642, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:51.0) Gecko/20100101 Firefox/51.0', NULL, NULL),
(7, 1486439768, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:51.0) Gecko/20100101 Firefox/51.0', NULL, NULL),
(8, 1486448738, 1, '27.74.248.90', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', NULL, NULL),
(9, 1486458591, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:51.0) Gecko/20100101 Firefox/51.0', NULL, NULL),
(10, 1487998566, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:51.0) Gecko/20100101 Firefox/51.0', 1487998592, NULL),
(11, 1566818552, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:68.0) Gecko/20100101 Firefox/68.0', NULL, NULL),
(12, 1566876881, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:68.0) Gecko/20100101 Firefox/68.0', NULL, NULL),
(13, 1566876904, 1, '14.161.6.234', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36', NULL, NULL),
(14, 1566877514, 1, '14.161.6.234', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36', NULL, NULL),
(15, 1566877524, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:68.0) Gecko/20100101 Firefox/68.0', NULL, NULL),
(16, 1566877533, 1, '14.161.6.234', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36', NULL, NULL),
(17, 1566877536, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:68.0) Gecko/20100101 Firefox/68.0', NULL, NULL),
(18, 1566877552, 1, '14.161.6.234', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36', NULL, NULL),
(19, 1566877568, 1, '14.161.6.234', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36', NULL, NULL),
(20, 1566878054, 1, '14.161.6.234', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)', NULL, NULL),
(21, 1566878349, 1, '14.161.6.234', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36', NULL, NULL),
(22, 1566879958, 1, '14.161.6.234', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36', NULL, NULL),
(23, 1566880010, 1, '14.187.157.249', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36', NULL, NULL),
(24, 1566880019, 1, '14.161.6.234', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36', NULL, NULL),
(25, 1566880045, 1, '14.187.157.249', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36', NULL, NULL),
(26, 1566880202, 1, '14.161.6.234', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36', NULL, NULL),
(27, 1566880984, 1, '14.187.157.249', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36', NULL, NULL),
(28, 1566881049, 1, '14.161.6.234', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36', NULL, NULL),
(29, 1566881546, 1, '14.187.157.249', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36', NULL, NULL),
(30, 1566893878, 1, '14.161.6.234', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36', NULL, NULL),
(31, 1566894501, 1, '103.199.32.130', 'Mozilla/5.0 (iPhone; CPU iPhone OS 12_0_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/12.0 Mobile/15E148 Safari/604.1', NULL, NULL),
(32, 1566894883, 1, '14.161.6.234', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36', NULL, NULL),
(33, 1566895339, 1, '14.161.6.234', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36', NULL, NULL),
(34, 1566956526, 1, '103.199.32.130', 'Mozilla/5.0 (iPhone; CPU iPhone OS 12_0_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/12.0 Mobile/15E148 Safari/604.1', NULL, NULL),
(35, 1566982374, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:68.0) Gecko/20100101 Firefox/68.0', NULL, NULL),
(36, 1566986064, 1, '14.161.6.234', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36', NULL, NULL),
(37, 1567052356, 1, '14.187.157.249', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36', NULL, NULL),
(38, 1567063158, 1, '14.161.6.234', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36', NULL, NULL),
(39, 1567067885, 1, '14.187.157.249', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(40, 1567070544, 1, '14.161.6.234', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36', NULL, NULL),
(41, 1567071358, 1, '14.187.157.249', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(42, 1567569974, 1, '14.161.6.234', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', 1567573302, NULL),
(43, 1567573305, 1, '14.161.6.234', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', 1567573481, NULL),
(44, 1567573483, 1, '14.161.6.234', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(45, 1567579627, 1, '14.161.6.234', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', 1567583657, NULL),
(46, 1567583659, 1, '14.161.6.234', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', 1567583719, NULL),
(47, 1567583722, 1, '14.161.6.234', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(48, 1567584118, 1, '14.187.157.249', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(49, 1567584178, 1, '14.161.6.234', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(50, 1567594224, 1, '14.187.157.249', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(51, 1567649102, 1, '14.187.157.249', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(52, 1567656709, 1, '14.161.6.234', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(53, 1567751800, 1, '14.161.6.234', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', 1567753184, NULL),
(54, 1567753187, 1, '14.161.6.234', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(55, 1567820899, 1, '14.161.6.234', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(56, 1567854070, 1, '116.102.150.40', 'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36', NULL, NULL),
(57, 1567858241, 1, '14.161.6.234', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(58, 1567993312, 1, '14.161.6.234', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', 1567995264, NULL),
(59, 1567995350, 1, '14.161.6.234', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', 1567995356, NULL),
(60, 1568018477, 1, '14.161.6.234', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(61, 1568082235, 1, '14.161.6.234', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(62, 1568087289, 1, '14.161.6.234', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(63, 1568098123, 1, '118.69.70.98', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Safari/537.36', NULL, NULL),
(64, 1568102614, 1, '118.69.70.98', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Safari/537.36', NULL, NULL),
(65, 1568192597, 1, '14.161.6.234', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(66, 1568251525, 1, '14.161.6.234', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', 1568251933, NULL),
(67, 1568252612, 1, '113.161.113.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(68, 1568253596, 1, '14.161.6.234', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(69, 1568273868, 1, '14.161.6.234', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(70, 1568279337, 1, '113.161.113.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(71, 1568429746, 1, '14.161.6.234', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', 1568430119, NULL),
(72, 1568430127, 1, '14.161.6.234', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(73, 1568430329, 3, '115.73.235.7', 'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(74, 1568602740, 1, '14.161.6.234', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(75, 1568608507, 3, '113.161.113.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(76, 1568614893, 3, '113.161.113.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(77, 1568684278, 1, '171.244.106.74', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) coc_coc_browser/81.0.158 Chrome/75.0.3770.158 Safari/537.36', NULL, NULL),
(78, 1568686518, 3, '113.161.113.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(79, 1568700608, 3, '113.161.113.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(80, 1568703472, 1, '14.161.6.234', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(81, 1568703684, 1, '113.161.113.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(82, 1568706950, 1, '14.161.6.234', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(83, 1568708348, 3, '113.161.113.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(84, 1568799962, 3, '113.161.113.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(85, 1568803451, 3, '113.161.113.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(86, 1568859707, 1, '14.161.6.234', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', 1568859983, NULL),
(87, 1568859986, 1, '14.161.6.234', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(88, 1568861653, 3, '113.161.113.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(89, 1568869105, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:69.0) Gecko/20100101 Firefox/69.0', 1568869116, NULL),
(90, 1568873214, 3, '113.161.113.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(91, 1568876122, 1, '14.161.6.234', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', 1568876191, NULL),
(92, 1568944684, 3, '113.161.113.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(93, 1568949425, 3, '113.161.113.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(94, 1568958106, 3, '113.161.113.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(95, 1568962865, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(96, 1568970045, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(97, 1569203370, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(98, 1569289055, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(99, 1569304054, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(100, 1569386349, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(101, 1569391829, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(102, 1569553107, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(103, 1569564511, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', 1569575547, NULL),
(104, 1569575554, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(105, 1569579290, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, NULL),
(106, 1569808582, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', NULL, NULL),
(107, 1569834364, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', NULL, NULL),
(108, 1569896229, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', NULL, NULL),
(109, 1570003885, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', NULL, NULL),
(110, 1570068164, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', NULL, NULL),
(111, 1570153570, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', NULL, NULL),
(112, 1573437395, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', NULL, NULL),
(113, 1573441244, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', NULL, NULL),
(114, 1573444644, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', NULL, NULL),
(115, 1573460755, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', NULL, NULL),
(116, 1573465408, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', NULL, NULL),
(117, 1573469787, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', NULL, NULL),
(118, 1573528189, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', NULL, NULL),
(119, 1574215396, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', NULL, NULL),
(120, 1574649434, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, NULL),
(121, 1574666133, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, NULL),
(122, 1574742637, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, NULL),
(123, 1574843140, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, NULL),
(124, 1575263951, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, NULL),
(125, 1575264216, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, NULL),
(126, 1575270706, 1, '192.168.100.21', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, NULL),
(127, 1575270731, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, NULL),
(128, 1575277559, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, NULL),
(129, 1575278970, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64; rv:70.0) Gecko/20100101 Firefox/70.0', NULL, NULL),
(130, 1575346528, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64; rv:70.0) Gecko/20100101 Firefox/70.0', NULL, NULL),
(131, 1575346971, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, NULL),
(132, 1575347740, 1, '192.168.100.21', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, NULL),
(133, 1575363658, 1, '42.115.192.179', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, NULL),
(134, 1575887798, 1, '192.168.100.21', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, NULL),
(135, 1576201859, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0', NULL, NULL),
(136, 1577113814, 1, '27.75.35.168', 'Mozilla/5.0 (iPhone; CPU iPhone OS 12_4_4 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 [FBAN/MessengerForiOS;FBDV/iPhone7,1;FBMD/iPhone;FBSN/iOS;FBSV/12.4.4;FBSS/3;FBID/phone;FBLC/vi_VN;FBOP/5]', NULL, NULL),
(137, 1577120428, 1, '27.75.35.168', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, NULL),
(138, 1577153819, 1, '183.80.60.141', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0', NULL, NULL),
(139, 1577153948, 1, '103.199.32.235', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0', NULL, NULL),
(140, 1577155345, 1, '115.78.9.184', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', 1577155390, NULL),
(141, 1577155403, 5, '115.78.9.184', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, NULL),
(142, 1577155567, 5, '115.78.9.184', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', 1577155582, NULL),
(143, 1577155587, 1, '115.78.9.184', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', 1577155639, NULL),
(144, 1577155663, 1, '115.78.9.184', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', 1577156163, NULL),
(145, 1577156173, 5, '115.78.9.184', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', 1577156188, NULL),
(146, 1577156194, 1, '115.78.9.184', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', 1577156379, NULL),
(147, 1577156386, 5, '115.78.9.184', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', 1577156480, NULL),
(148, 1577156484, 1, '115.78.9.184', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, NULL),
(149, 1577162084, 1, '115.78.9.184', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0', NULL, NULL),
(150, 1577162344, 1, '115.78.9.184', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, NULL),
(151, 1577244324, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, NULL),
(152, 1577247911, 1, '14.161.35.90', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, NULL),
(153, 1577261375, 1, '192.168.100.21', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, NULL),
(154, 1577415904, 1, '103.199.57.225', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, NULL),
(155, 1577430328, 1, '14.187.239.30', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, NULL),
(156, 1577443456, 1, '14.187.239.30', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, NULL),
(157, 1577671694, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, NULL),
(158, 1577672597, 1, '192.168.100.21', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, NULL),
(159, 1577672786, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, NULL),
(160, 1578020659, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, NULL),
(161, 1578029461, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, NULL),
(162, 1578281931, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, NULL),
(163, 1578286358, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, NULL),
(164, 1578290872, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, NULL),
(165, 1578362078, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, NULL),
(166, 1578376770, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, NULL),
(167, 1578380404, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, NULL),
(168, 1578448863, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, NULL),
(169, 1578449153, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, NULL),
(170, 1578449342, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, NULL),
(171, 1578463564, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, NULL),
(172, 1578473120, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, NULL),
(173, 1578475996, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, NULL),
(174, 1578479838, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, NULL),
(175, 1578535829, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, NULL),
(176, 1578554988, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, NULL),
(177, 1578561316, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, NULL),
(178, 1578621943, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, NULL),
(179, 1578635964, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, NULL),
(180, 1578714805, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36', NULL, NULL),
(181, 1578719099, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36', NULL, NULL),
(182, 1578728185, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36', NULL, NULL),
(183, 1578881163, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36', NULL, NULL),
(184, 1578888841, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36', NULL, NULL),
(185, 1578889070, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36', NULL, NULL),
(186, 1578895034, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36', NULL, NULL),
(187, 1578966819, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36', NULL, NULL),
(188, 1578981588, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36', NULL, NULL),
(189, 1578992710, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36', NULL, NULL),
(190, 1579053622, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36', NULL, NULL),
(191, 1579061317, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36', NULL, NULL),
(192, 1579069070, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36', NULL, NULL),
(193, 1579075713, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36', NULL, NULL),
(194, 1579486997, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36', NULL, NULL),
(195, 1579491518, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36', NULL, NULL),
(196, 1579499656, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36', NULL, NULL),
(197, 1579571692, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `log_id` int(10) UNSIGNED NOT NULL,
  `start_time` int(11) NOT NULL DEFAULT 0,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `ip` varchar(15) NOT NULL DEFAULT '',
  `agent` varchar(255) DEFAULT NULL,
  `end_time` int(10) UNSIGNED DEFAULT NULL,
  `action` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`log_id`, `start_time`, `user_id`, `ip`, `agent`, `end_time`, `action`) VALUES
(1, 1569221607, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Xóa lịch sử truy cập'),
(2, 1569221652, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Sửa thông tin kho hàng'),
(3, 1569230076, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu nhập hàng NK00000017'),
(4, 1569230102, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Sửa phiếu nhập hàng NK00000017'),
(5, 1569232877, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Điều chỉnh hàng tồn DCT00000001'),
(6, 1569232934, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Điều chỉnh hàng tồn DCT00000002'),
(7, 1569233026, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Điều chỉnh hàng tồn DCT00000003'),
(8, 1569233061, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Điều chỉnh hàng tồn DCT00000004'),
(9, 1569233080, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Điều chỉnh hàng tồn DCT00000005'),
(10, 1569235390, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Xóa nhà cung cấp'),
(11, 1569235394, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Xóa nhà cung cấp'),
(12, 1569235585, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu bán hàng XK00000021'),
(13, 1569235686, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu thu PT00000019'),
(14, 1569290795, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Sửa phiếu bán hàng XK00000021'),
(15, 1569290844, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Sửa phiếu bán hàng XK00000020'),
(16, 1569290875, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Sửa phiếu bán hàng XK00000019'),
(17, 1569290895, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Sửa phiếu bán hàng XK00000020'),
(18, 1569290984, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Sửa phiếu bán hàng XK00000020'),
(19, 1569291590, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Sửa phiếu bán hàng XK00000020'),
(20, 1569292205, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Xóa dữ liệu hệ thống'),
(21, 1569292404, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu nhập hàng NK00000001'),
(22, 1569292505, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu bán hàng XK00000001'),
(23, 1569292578, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu chi PC00000002'),
(24, 1569293472, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu nhập hàng NK00000002'),
(25, 1569296865, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu bán hàng XK00000002'),
(26, 1569297083, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu thu PT00000004'),
(27, 1569297381, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu thu PT00000005'),
(28, 1569297434, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Sửa phiếu bán hàng XK00000002'),
(29, 1569298955, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Xóa dữ liệu hệ thống'),
(30, 1569299004, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu nhập hàng NK00000001'),
(31, 1569299122, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu bán hàng XK00000001'),
(32, 1569299161, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu thu PT00000002'),
(33, 1569299302, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Xóa dữ liệu hệ thống'),
(34, 1569299327, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu nhập hàng NK00000001'),
(35, 1569299421, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu bán hàng XK00000001'),
(36, 1569299443, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu thu PT00000002'),
(37, 1569300139, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Thêm khoản thu/chi mới'),
(38, 1569300201, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu chi PC00000003'),
(39, 1569304436, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu bán hàng XK00000002'),
(40, 1569304702, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Sửa phiếu bán hàng XK00000001'),
(41, 1569304826, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Xóa dữ liệu hệ thống'),
(42, 1569304856, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu nhập hàng NK00000001'),
(43, 1569304954, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu bán hàng XK00000001'),
(44, 1569305356, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu chi PC00000002'),
(45, 1569305807, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu thu PT00000003'),
(46, 1569307364, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu nhập hàng NK00000002'),
(47, 1569307454, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu bán hàng XK00000002'),
(48, 1569307811, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Xóa dữ liệu hệ thống'),
(49, 1569308175, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu nhập hàng NK00000001'),
(50, 1569308423, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu bán hàng XK00000001'),
(51, 1569308630, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Sửa phiếu bán hàng XK00000001'),
(52, 1569308827, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu chi PC00000002'),
(53, 1569308977, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu thu PT00000003'),
(54, 1569310623, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu bán hàng XK00000002'),
(55, 1569311651, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu nhập hàng NK00000002'),
(56, 1569312459, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu nhập hàng NK00000003'),
(57, 1569312600, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Thêm sản phẩm mới Máy ram 4g'),
(58, 1569312704, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu nhập hàng NK00000004'),
(59, 1569312833, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Thêm sản phẩm mới Ram 4G Adata R3'),
(60, 1569313227, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Thêm sản phẩm mới Máy bộ PC( Case Jetek A20, Main H81-DS2, Intel Core i3-4130+Fan zin 1155, Ram Adata R3 8G/1600, 2x SSD 240G andisk, Nguồn Jetek Y600T, Màn hình L20 AOC 12080SW, Chuột Genius 110X, Bàn phím Genius, DVD Rom)'),
(61, 1569313318, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Thêm sản phẩm mới Ram 8G'),
(62, 1569313355, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu nhập hàng NK00000005'),
(63, 1569313364, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Sửa phiếu nhập hàng NK00000005'),
(64, 1569386552, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Thêm sản phẩm mới HDD12321321321'),
(65, 1569386901, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Thêm sản phẩm mới 3saaaaa'),
(66, 1569387043, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Thêm sản phẩm mới nhap nhanh sp'),
(67, 1569387091, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu nhập hàng NK00000006'),
(68, 1569387203, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Xóa dữ liệu hệ thống'),
(69, 1569392311, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu nhập hàng NK00000001'),
(70, 1569392501, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu bán hàng XK00000001'),
(71, 1569393484, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Xóa dữ liệu hệ thống'),
(72, 1569394201, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu nhập hàng NK00000001'),
(73, 1569394325, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu bán hàng XK00000001'),
(74, 1569394459, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu thu PT00000003'),
(75, 1569394599, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu bán hàng XK00000002'),
(76, 1569394673, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu bán hàng XK00000003'),
(77, 1569394710, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Sửa phiếu bán hàng XK00000003'),
(78, 1569397395, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Thêm sản phẩm mới G4'),
(79, 1569397407, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu nhập hàng NK00000002'),
(80, 1569397757, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Thêm sản phẩm mới G8'),
(81, 1569397851, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Thêm sản phẩm mới Server G4'),
(82, 1569564619, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu thu PT00000005'),
(83, 1569564790, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Thêm khoản thu/chi mới'),
(84, 1569564817, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Thêm khoản thu/chi mới'),
(85, 1569564845, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Sửa khoản thu/chi'),
(86, 1569565600, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu thu PT00000006'),
(87, 1569566165, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu thu PT00000008'),
(88, 1569568107, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu bán hàng XK00000004'),
(89, 1569570765, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu nhập hàng NK00000003'),
(90, 1569574211, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Xóa dữ liệu hệ thống'),
(91, 1569574375, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu nhập hàng NK00000001'),
(92, 1569576014, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu bán hàng XK00000003'),
(93, 1569576994, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu nhập hàng NK00000004'),
(94, 1569577143, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu bán hàng XK00000005'),
(95, 1569577235, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu bảo hành BH00000001'),
(96, 1569577307, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Xử lý phiếu bảo hành BH00000001'),
(97, 1569577349, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Xử lý phiếu bảo hành BH00000001'),
(98, 1569577402, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu thu PT00000003'),
(99, 1569579955, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', NULL, 'Lập phiếu nhập hàng NK00000006'),
(100, 1569836340, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', NULL, 'Lập phiếu thu PT00000004'),
(101, 1569836989, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', NULL, 'Lập phiếu bán hàng XK00000006'),
(102, 1570003919, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', NULL, 'Lập phiếu nhập hàng NK00000007'),
(103, 1570004132, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', NULL, 'Lập phiếu bán hàng XK00000007'),
(104, 1570006183, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', NULL, 'Lập phiếu bán hàng XK00000008'),
(105, 1575270721, 1, '192.168.100.21', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Xóa dữ liệu hệ thống'),
(106, 1575271031, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Xóa dữ liệu hệ thống'),
(107, 1575271158, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Xóa dữ liệu hệ thống'),
(108, 1575271662, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(109, 1575271712, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(110, 1575271741, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(111, 1575271801, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(112, 1575271815, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(113, 1575271902, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(114, 1575272064, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(115, 1575272146, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(116, 1575272232, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(117, 1575272316, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(118, 1575272417, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(119, 1575272433, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(120, 1575272461, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(121, 1575272478, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(122, 1575272487, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(123, 1575272498, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(124, 1575272507, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(125, 1575272514, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(126, 1575272526, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(127, 1575272532, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(128, 1575272539, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(129, 1575272547, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(130, 1575272554, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(131, 1575272560, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(132, 1575272567, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(133, 1575272573, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(134, 1575272579, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(135, 1575272586, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(136, 1575272594, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(137, 1575272603, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(138, 1575272613, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(139, 1575272619, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(140, 1575272627, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(141, 1575272633, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(142, 1575272644, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(143, 1575272652, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(144, 1575272656, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(145, 1575272665, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(146, 1575272686, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(147, 1575272693, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(148, 1575272700, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(149, 1575272707, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(150, 1575272721, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(151, 1575272727, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(152, 1575272733, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(153, 1575272740, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(154, 1575272744, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(155, 1575272752, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(156, 1575272757, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(157, 1575272763, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(158, 1575272772, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(159, 1575272785, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(160, 1575272796, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(161, 1575272804, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(162, 1575272811, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(163, 1575272818, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(164, 1575272824, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(165, 1575272832, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(166, 1575272841, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(167, 1575272846, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(168, 1575272854, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(169, 1575272863, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(170, 1575272868, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(171, 1575272875, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(172, 1575272968, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(173, 1575273036, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(174, 1575273147, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(175, 1575273166, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(176, 1575273174, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(177, 1575273194, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(178, 1575273208, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(179, 1575273213, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(180, 1575273235, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(181, 1575273262, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(182, 1575273284, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(183, 1575273299, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(184, 1575273316, 1, '192.168.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Khai báo tồn kho đầu kỳ'),
(185, 1575279008, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64; rv:70.0) Gecko/20100101 Firefox/70.0', NULL, 'Sửa tiêu đề phần mềm'),
(186, 1575346616, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64; rv:70.0) Gecko/20100101 Firefox/70.0', NULL, 'Lập phiếu bán hàng XK00000001'),
(187, 1575347003, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Sửa tiêu đề phần mềm'),
(188, 1575347020, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Lập phiếu bán hàng XK00000002'),
(189, 1575347232, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Sửa tiêu đề phần mềm'),
(190, 1575347259, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Lập phiếu bán hàng XK00000003'),
(191, 1575347314, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Sửa tiêu đề phần mềm'),
(192, 1575347400, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Lập phiếu nhập hàng NK00000001'),
(193, 1575347565, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Thêm nhà cung cấp mới'),
(194, 1575364008, 1, '42.115.192.179', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Thêm khách hàng mới'),
(195, 1575364101, 1, '42.115.192.179', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Thêm nhà sản xuất mới'),
(196, 1575364195, 1, '42.115.192.179', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Thêm nhân viên mới'),
(197, 1575364234, 1, '42.115.192.179', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Thực hiện phân quyền quản trị'),
(198, 1575364262, 1, '42.115.192.179', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Thêm phòng/ban mới'),
(199, 1575364303, 1, '42.115.192.179', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Tạo kho hàng mới'),
(200, 1575364519, 1, '42.115.192.179', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Lập phiếu bán hàng XK00000004'),
(201, 1575364839, 1, '42.115.192.179', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Lập phiếu nhập hàng NK00000002'),
(202, 1575364958, 1, '42.115.192.179', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', NULL, 'Tạo kho hàng mới'),
(203, 1577154153, 1, '103.199.32.235', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0', NULL, 'Thêm nhân viên mới'),
(204, 1577154242, 1, '103.199.32.235', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0', NULL, 'Thêm nhân viên mới'),
(205, 1577154285, 1, '103.199.32.235', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0', NULL, 'Thêm nhân viên mới'),
(206, 1577155615, 1, '115.78.9.184', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Thực hiện phân quyền quản trị'),
(207, 1577155630, 1, '115.78.9.184', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Thực hiện phân quyền quản trị'),
(208, 1577155700, 1, '115.78.9.184', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Thực hiện phân quyền quản trị'),
(209, 1577156800, 1, '115.78.9.184', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Lập phiếu nhập hàng NK00000003'),
(210, 1577261521, 1, '192.168.100.21', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Lập phiếu nhập hàng NK00000004'),
(211, 1577261521, 1, '192.168.100.21', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Lập phiếu nhập hàng NK00000005'),
(212, 1577262112, 1, '192.168.100.21', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Lập phiếu bán hàng XK00000005'),
(213, 1577262178, 1, '192.168.100.21', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Lập phiếu nhập hàng NK00000006'),
(214, 1577262253, 1, '192.168.100.21', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Lập phiếu bán hàng XK00000006'),
(215, 1577671710, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Xóa kho hàng'),
(216, 1577671800, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Xóa kho hàng'),
(217, 1577671837, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Xóa kho hàng'),
(218, 1577671842, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Xóa kho hàng'),
(219, 1577671846, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Xóa kho hàng'),
(220, 1577671850, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Xóa kho hàng'),
(221, 1577671854, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Xóa kho hàng'),
(222, 1577671858, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Xóa kho hàng'),
(223, 1577671869, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Xóa kho hàng'),
(224, 1577671872, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Xóa kho hàng'),
(225, 1577671876, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Xóa kho hàng'),
(226, 1577671880, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Xóa kho hàng'),
(227, 1577671884, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Xóa kho hàng'),
(228, 1577671910, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Sửa thông tin kho hàng'),
(229, 1577672427, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Tạo kho hàng mới'),
(230, 1577672441, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Sửa thông tin kho hàng'),
(231, 1577672487, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Tạo kho hàng mới'),
(232, 1577672799, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Xóa nhân viên'),
(233, 1577672805, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Xóa nhân viên'),
(234, 1577672820, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Thay đổi thông tin nhân viên'),
(235, 1577672896, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Thực hiện phân quyền quản trị'),
(236, 1577672952, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Thực hiện phân quyền quản trị'),
(237, 1577672990, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Sửa thông tin kho hàng'),
(238, 1577673007, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Sửa thông tin kho hàng'),
(239, 1577673022, 1, '14.161.28.68', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Tạo kho hàng mới'),
(240, 1578020997, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Lập phiếu nhập hàng NK00000007'),
(241, 1578021037, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Lập phiếu bán hàng XK00000001'),
(242, 1578021356, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Lập phiếu thu PT00000008'),
(243, 1578022344, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Sửa thông tin sản phẩm  8.25-20'),
(244, 1578022355, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Sửa thông tin sản phẩm  8.25-20'),
(245, 1578378024, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Lập phiếu nhập hàng NK00000008'),
(246, 1578378183, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Lập phiếu bán hàng XK0008'),
(247, 1578392899, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Lập phiếu bán hàng XK00000009'),
(248, 1578467004, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Sửa thông tin sản phẩm  8.25-20'),
(249, 1578467011, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Sửa thông tin sản phẩm  8.25-20'),
(250, 1578555877, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Sửa thông tin sản phẩm  8.25-20'),
(251, 1578556199, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Lập phiếu nhập hàng NK00000009'),
(252, 1578638488, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Lập phiếu nhập hàng NK00000010'),
(253, 1578643116, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Sửa thông tin nhà sản xuất'),
(254, 1578643123, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Sửa thông tin nhà sản xuất'),
(255, 1578643146, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Sửa thông tin nhà sản xuất'),
(256, 1578643363, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Thêm nhà cung cấp mới'),
(257, 1578643857, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Sửa thông tin khách hàng'),
(258, 1578643868, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Sửa thông tin khách hàng'),
(259, 1578644735, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Lập phiếu nhập hàng NK00000011'),
(260, 1578645096, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Sửa thông tin nhà sản xuất'),
(261, 1578645194, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', NULL, 'Sửa thông tin nhà sản xuất'),
(262, 1578715998, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36', NULL, 'Lập phiếu nhập hàng NK00000012'),
(263, 1578889784, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36', NULL, 'Sửa thông tin sản phẩm  8.25-20'),
(264, 1578890746, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36', NULL, 'Lập phiếu nhập hàng NK00000013'),
(265, 1578895345, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36', NULL, 'Sửa thông tin nhà sản xuất'),
(266, 1578895361, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36', NULL, 'Sửa thông tin nhà sản xuất'),
(267, 1578895402, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36', NULL, 'Lập phiếu nhập hàng NK00000014'),
(268, 1578896756, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36', NULL, 'Lập phiếu bán hàng XK00000010'),
(269, 1578896804, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36', NULL, 'Lập phiếu bán hàng XK00000011');
INSERT INTO `logs` (`log_id`, `start_time`, `user_id`, `ip`, `agent`, `end_time`, `action`) VALUES
(270, 1578977611, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36', NULL, 'Lập phiếu bán hàng XK00000012'),
(271, 1579489833, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36', NULL, 'Thay đổi thông tin nhân viên'),
(272, 1579491911, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36', NULL, 'Sửa thông tin khách hàng'),
(273, 1579491970, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36', NULL, 'Sửa thông tin khách hàng'),
(274, 1579492632, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36', NULL, 'Sửa thông tin sản phẩm  8.25-20');

-- --------------------------------------------------------

--
-- Table structure for table `manufactures`
--

CREATE TABLE `manufactures` (
  `mfa_id` int(10) UNSIGNED NOT NULL,
  `mfa_name` varchar(100) NOT NULL,
  `website` varchar(45) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `tel` varchar(30) DEFAULT NULL,
  `cat_list` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `manufactures`
--

INSERT INTO `manufactures` (`mfa_id`, `mfa_name`, `website`, `description`, `address`, `email`, `tel`, `cat_list`) VALUES
(1, 'Hãng khác', '', '', '', '', '', ''),
(2, 'HP ', '', '', '', '', '', ''),
(3, 'Maxxxis', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `mat_id` int(10) UNSIGNED NOT NULL,
  `mat_name` varchar(500) DEFAULT NULL,
  `mat_desc` text DEFAULT NULL,
  `mat_quantity` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `mat_price` double UNSIGNED NOT NULL DEFAULT 0,
  `mat_waranty` tinyint(3) UNSIGNED DEFAULT 0,
  `cat_id` int(10) UNSIGNED DEFAULT NULL,
  `mat_model` varchar(20) DEFAULT NULL,
  `saleoff` text DEFAULT NULL,
  `tax` float UNSIGNED DEFAULT NULL,
  `mat_type` int(10) UNSIGNED DEFAULT NULL,
  `barcode` varchar(20) DEFAULT NULL,
  `vat` tinyint(2) NOT NULL DEFAULT 0,
  `mat_imei1` varchar(50) NOT NULL,
  `mat_imei2` varchar(50) NOT NULL,
  `pr` varchar(250) NOT NULL DEFAULT '',
  `gai` varchar(250) NOT NULL DEFAULT '',
  `alert_qty` int(11) NOT NULL DEFAULT 0,
  `tkvt` varchar(100) NOT NULL DEFAULT '1561',
  `edit_tkvt` int(11) NOT NULL DEFAULT 0,
  `tkgv` varchar(100) NOT NULL DEFAULT '632',
  `tkdt` varchar(100) NOT NULL DEFAULT '5111',
  `tktl` varchar(100) NOT NULL DEFAULT '5212',
  `tkdd` varchar(100) NOT NULL DEFAULT '154',
  `tkcl` varchar(100) NOT NULL DEFAULT '632',
  `tkck` varchar(100) NOT NULL DEFAULT '5211'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`mat_id`, `mat_name`, `mat_desc`, `mat_quantity`, `mat_price`, `mat_waranty`, `cat_id`, `mat_model`, `saleoff`, `tax`, `mat_type`, `barcode`, `vat`, `mat_imei1`, `mat_imei2`, `pr`, `gai`, `alert_qty`, `tkvt`, `edit_tkvt`, `tkgv`, `tkdt`, `tktl`, `tkdd`, `tkcl`, `tkck`) VALUES
(1, '225/17_TTR4', '', 0, 0, 0, 1, '225/17_TTR4', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(2, '250/17_TTR4', '', 0, 0, 0, 1, '250/17_TTR4', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(3, '275/17_TR4', '', 0, 0, 0, 1, '275/17_TR4', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(4, '80/90-14_TR4', '', 0, 0, 0, 1, '80/90-14_TR4', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(5, '80/90-16_TR4', '', 0, 0, 0, 1, '80/90-16_TR4', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(6, '90/90-14_TR4', '', 0, 0, 0, 1, '90/90-14_TR4', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(7, '225-17_C102', '', 0, 0, 0, 2, '225-17_C102', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(8, '225-17_C6139', '', 0, 0, 0, 2, '225-17_C6139', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(9, '225-17_C6235', '', 0, 0, 0, 2, '225-17_C6235', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(10, '225-17_MA3D', '', 0, 0, 0, 2, '225-17_MA3D', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(11, '250-17_C107', '', 0, 0, 0, 2, '250-17_C107', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(12, '250-17_C6139', '', 0, 0, 0, 2, '250-17_C6139', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(13, '250-17_C6235', '', 0, 0, 0, 2, '250-17_C6235', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(14, '250-17_MA3D', '', 0, 0, 0, 2, '250-17_MA3D', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(15, '275-17_C6139', '', 0, 0, 0, 2, '275-17_C6139', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(16, '275-17_C6235', '', 0, 0, 0, 2, '275-17_C6235', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(17, '275-17_MA3D', '', 0, 0, 0, 2, '275-17_MA3D', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(18, '180/55 ZR17 MA-PS_MA-PS', '', 0, 0, 0, 3, '180/55 ZR17 MA-PS_MA', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(19, '100/70-17_MA3D', '', 0, 0, 0, 4, '100/70-17_MA3D', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(20, '100/80-14_M6127', '', 0, 0, 0, 4, '100/80-14_M6127', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(21, '100/80-16 _CS-WING', '', 0, 0, 0, 4, '100/80-16 _CS-WING', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(22, '100/90-10_C6105', '', 0, 0, 0, 4, '100/90-10_C6105', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(23, '100/90-10_C922', '', 0, 0, 0, 4, '100/90-10_C922', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(24, '100/90-10_MA3D', '', 0, 0, 0, 4, '100/90-10_MA3D', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(25, '100/90-14_C6167', '', 0, 0, 0, 4, '100/90-14_C6167', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(26, '100/90-14_C922', '', 0, 0, 0, 4, '100/90-14_C922', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(27, '100/90-14_MA3D', '', 0, 0, 0, 4, '100/90-14_MA3D', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(28, '110/70-11_M6017', '', 0, 0, 0, 4, '110/70-11_M6017', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(29, '110/70-11 _ CS-W1', '', 0, 0, 0, 4, '110/70-11 _ CS-W1', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(30, '110/70-12_CS-W1', '', 0, 0, 0, 4, '110/70-12_CS-W1', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(31, '110/70-14 _MA-V6', '', 0, 0, 0, 4, '110/70-14 _MA-V6', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(32, '110/70-17_MA3D', '', 0, 0, 0, 4, '110/70-17_MA3D', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(33, '110/80-12_M6029', '', 0, 0, 0, 4, '110/80-12_M6029', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(34, '110/80-14 _ CS-W1', '', 0, 0, 0, 4, '110/80-14 _ CS-W1', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(35, '110/90-10_M6108', '', 0, 0, 0, 4, '110/90-10_M6108', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(36, '110/90-13_M6029', '', 0, 0, 0, 4, '110/90-13_M6029', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(37, '120/70-10_M6017', '', 0, 0, 0, 4, '120/70-10_M6017', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(38, '120/70-11 _CS-W1', '', 0, 0, 0, 4, '120/70-11 _CS-W1', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(39, '120/70-11 _M6017', '', 0, 0, 0, 4, '120/70-11 _M6017', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(40, '120/70-12 _CS-W1', '', 0, 0, 0, 4, '120/70-12 _CS-W1', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(41, '120/70-17 _CS-WING', '', 0, 0, 0, 4, '120/70-17 _CS-WING', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(42, '120/70-17 _M6234', '', 0, 0, 0, 4, '120/70-17 _M6234', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(43, '120/80-16_M6029', '', 0, 0, 0, 4, '120/80-16_M6029', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(44, '120/80-16 _CS-WING', '', 0, 0, 0, 4, '120/80-16 _CS-WING', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(45, '130/70-12 _CS-W1', '', 0, 0, 0, 4, '130/70-12 _CS-W1', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(46, '130/70-13_M6029', '', 0, 0, 0, 4, '130/70-13_M6029', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(47, '130/70-17 _M6234', '', 0, 0, 0, 4, '130/70-17 _M6234', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(48, '140/70-14 _CS-W1', '', 0, 0, 0, 4, '140/70-14 _CS-W1', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(49, '140/70-17 _M6234', '', 0, 0, 0, 4, '140/70-17 _M6234', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(50, '70/90-14_C921', '', 0, 0, 0, 4, '70/90-14_C921', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(51, '70/90-16_C6167', '', 0, 0, 0, 4, '70/90-16_C6167', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(52, '70/90-16_C921', '', 0, 0, 0, 4, '70/90-16_C921', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(53, '70/90-16_MA3D', '', 0, 0, 0, 4, '70/90-16_MA3D', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(54, '70/90-16_M6211', '', 0, 0, 0, 4, '70/90-16_M6211', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(55, '70/90-17_C6016', '', 0, 0, 0, 4, '70/90-17_C6016', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(56, '70/90-17_C921', '', 0, 0, 0, 4, '70/90-17_C921', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(57, '70/90-17 _C6230S', '', 0, 0, 0, 4, '70/90-17 _C6230S', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(58, '70/90-17 _MA3D', '', 0, 0, 0, 4, '70/90-17 _MA3D', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(59, '70/90-17 _M6002', '', 0, 0, 0, 4, '70/90-17 _M6002', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(60, '70/90-17 _M6230', '', 0, 0, 0, 4, '70/90-17 _M6230', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(61, '70/90-17 _MA-V6', '', 0, 0, 0, 4, '70/90-17 _MA-V6', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(62, '80/90-14_C6167', '', 0, 0, 0, 4, '80/90-14_C6167', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(63, '80/90-14_C921', '', 0, 0, 0, 4, '80/90-14_C921', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(64, '80/90-14 _C922', '', 0, 0, 0, 4, '80/90-14 _C922', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(65, '80/90-14 _MA3D', '', 0, 0, 0, 4, '80/90-14 _MA3D', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(66, '80/90-14 _MA-V6', '', 0, 0, 0, 4, '80/90-14 _MA-V6', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(67, '80/90-15_M6127', '', 0, 0, 0, 4, '80/90-15_M6127', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(68, '80/90-16_C6167', '', 0, 0, 0, 4, '80/90-16_C6167', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(69, '80/90-16_C921', '', 0, 0, 0, 4, '80/90-16_C921', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(70, '80/90-16_C922', '', 0, 0, 0, 4, '80/90-16_C922', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(71, '80/90-16_MA3D', '', 0, 0, 0, 4, '80/90-16_MA3D', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(72, '80/90-16 _M6212', '', 0, 0, 0, 4, '80/90-16 _M6212', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(73, '80/90-17_C6230S', '', 0, 0, 0, 4, '80/90-17_C6230S', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(74, '80/90-17_C6016', '', 0, 0, 0, 4, '80/90-17_C6016', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(75, '80/90-17_C921', '', 0, 0, 0, 4, '80/90-17_C921', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(76, '80/90-17_MA3D', '', 0, 0, 0, 4, '80/90-17_MA3D', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(77, '80/90-17 _M6002', '', 0, 0, 0, 4, '80/90-17 _M6002', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(78, '80/90-17 _M6230', '', 0, 0, 0, 4, '80/90-17 _M6230', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(79, '80/90-17_MA-V6', '', 0, 0, 0, 4, '80/90-17_MA-V6', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(80, '90/80-17_CS-WING', '', 0, 0, 0, 4, '90/80-17_CS-WING', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(81, '90/80-17 _M6233', '', 0, 0, 0, 4, '90/80-17 _M6233', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(82, '90/90-12_C922', '', 0, 0, 0, 4, '90/90-12_C922', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(83, '90/90-12_MA3D', '', 0, 0, 0, 4, '90/90-12_MA3D', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(84, '90/90-14_C6167', '', 0, 0, 0, 4, '90/90-14_C6167', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(85, '90/90-14_C921', '', 0, 0, 0, 4, '90/90-14_C921', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(86, '90/90-14 _C922', '', 0, 0, 0, 4, '90/90-14 _C922', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(87, '90/90-14 _MA3D', '', 0, 0, 0, 4, '90/90-14 _MA3D', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(88, '90/90-14 _MA-V6', '', 0, 0, 0, 4, '90/90-14 _MA-V6', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(89, '90/90-16_C6167', '', 0, 0, 0, 4, '90/90-16_C6167', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(90, '90/90-16_MA3D', '', 0, 0, 0, 4, '90/90-16_MA3D', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(91, '145/70-R13_MA701', '', 0, 0, 0, 5, '145/70-R13_MA701', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(92, '155/65 R13_MAP3', '', 0, 0, 0, 5, '155/65 R13_MAP3', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(93, '155-R12_UN999', '', 0, 0, 0, 5, '155-R12_UN999', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(94, '155-R13_UE168', '', 0, 0, 0, 5, '155-R13_UE168', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(95, '165/60 R14_MAP1', '', 0, 0, 0, 5, '165/60 R14_MAP1', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(96, '165/65_MAP1', '', 0, 0, 0, 5, '165/65_MAP1', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(97, '165/65-R13_MAP3', '', 0, 0, 0, 5, '165/65-R13_MAP3', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(98, '165/70-R13_MA703', '', 0, 0, 0, 5, '165/70-R13_MA703', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(99, '175/50 R15_MA918', '', 0, 0, 0, 5, '175/50 R15_MA918', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(100, '175/65-R14 _MA307A', '', 0, 0, 0, 5, '175/65-R14 _MA307A', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(101, '175-R13_UE168', '', 0, 0, 0, 5, '175-R13_UE168', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(102, '185/55-R15_MAP3', '', 0, 0, 0, 5, '185/55-R15_MAP3', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(103, '185/60 R15_MAP3', '', 0, 0, 0, 5, '185/60 R15_MAP3', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(104, '185/65-R14_MAP3', '', 0, 0, 0, 5, '185/65-R14_MAP3', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(105, '185/65-R15_MAP3', '', 0, 0, 0, 5, '185/65-R15_MAP3', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(106, '185-R14_UE168', '', 0, 0, 0, 5, '185-R14_UE168', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(107, '195/55 R16 _HP-M3', '', 0, 0, 0, 5, '195/55 R16 _HP-M3', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(108, '195/60-R15 _ME3', '', 0, 0, 0, 5, '195/60-R15 _ME3', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(109, '195/65 R15_MAP3', '', 0, 0, 0, 5, '195/65 R15_MAP3', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(110, '195/70-R15_UE103', '', 0, 0, 0, 5, '195/70-R15_UE103', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(111, '195/75-R16_MA589', '', 0, 0, 0, 5, '195/75-R16_MA589', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(112, '195-R14C_UE168', '', 0, 0, 0, 5, '195-R14C_UE168', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(113, '195-R15_UE168', '', 0, 0, 0, 5, '195-R15_UE168', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(114, '205/60 R16 _HP-M3', '', 0, 0, 0, 5, '205/60 R16 _HP-M3', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(115, '205/65_ MA202', '', 0, 0, 0, 5, '205/65_ MA202', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(116, '205/65 R16 _HP-M3', '', 0, 0, 0, 5, '205/65 R16 _HP-M3', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(117, '205/65-R16_MAP3', '', 0, 0, 0, 5, '205/65-R16_MAP3', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(118, '215/45-R17_HP5', '', 0, 0, 0, 5, '215/45-R17_HP5', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(119, '215/55 R17_HP-M3', '', 0, 0, 0, 5, '215/55 R17_HP-M3', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(120, '215/60 R16_HP-M3', '', 0, 0, 0, 5, '215/60 R16_HP-M3', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(121, '215/70 R16_MA707', '', 0, 0, 0, 5, '215/70 R16_MA707', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(122, '215/70-R15_UE168N', '', 0, 0, 0, 5, '215/70-R15_UE168N', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(123, '215/75-R16_UE168', '', 0, 0, 0, 5, '215/75-R16_UE168', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(124, '225/45 R17 _HP-M3', '', 0, 0, 0, 5, '225/45 R17 _HP-M3', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(125, '225/65_HT770', '', 0, 0, 0, 5, '225/65_HT770', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(126, '225/70 -R15_UE168N', '', 0, 0, 0, 5, '225/70 -R15_UE168N', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(127, '225/70-R16 _HP5', '', 0, 0, 0, 5, '225/70-R16 _HP5', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(128, '235/55 R19 _HP-M3', '', 0, 0, 0, 5, '235/55 R19 _HP-M3', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(129, '235/60 R18_HP-M3', '', 0, 0, 0, 5, '235/60 R18_HP-M3', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(130, '235/60-R17_MA707', '', 0, 0, 0, 5, '235/60-R17_MA707', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(131, '235/65 R17_AT771', '', 0, 0, 0, 5, '235/65 R17_AT771', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(132, '245/70-R16_HP-M3', '', 0, 0, 0, 5, '245/70-R16_HP-M3', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(133, '255/60_HT770', '', 0, 0, 0, 5, '255/60_HT770', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(134, '265/60 R18_AT771', '', 0, 0, 0, 5, '265/60 R18_AT771', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(135, '265/70-R15_HP-M3', '', 0, 0, 0, 5, '265/70-R15_HP-M3', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(136, '700-16TL_UE102', '', 0, 0, 0, 5, '700-16TL_UE102', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(137, 'LT235/75 R15_AT700', '', 0, 0, 0, 5, 'LT235/75 R15_AT700', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(138, 'LT235/75-R15_MT764', '', 0, 0, 0, 5, 'LT235/75-R15_MT764', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(139, 'LT265/60-R18_AT980', '', 0, 0, 0, 5, 'LT265/60-R18_AT980', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(140, 'P235/70-R15_HT760', '', 0, 0, 0, 5, 'P235/70-R15_HT760', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(141, '175/70 R13_MAP3', '', 0, 0, 0, 5, '175/70 R13_MAP3', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(142, '195/70 R14_MAP3', '', 0, 0, 0, 5, '195/70 R14_MAP3', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(143, '255/70 R16_AT771', '', 0, 0, 0, 5, '255/70 R16_AT771', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(144, '195/70 R15C_MA589', '', 0, 0, 0, 5, '195/70 R15C_MA589', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(145, '10.00-20 _C688', '', 0, 0, 0, 6, '10.00-20 _C688', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(146, '10.00-20 _C886', '', 0, 0, 0, 6, '10.00-20 _C886', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(147, '11.00-20 _C276', '', 0, 0, 0, 6, '11.00-20 _C276', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(148, '11.00-20 _C688', '', 0, 0, 0, 6, '11.00-20 _C688', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(149, '11.00-20/20_C688', '', 0, 0, 0, 6, '11.00-20/20_C688', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(150, '12.00-20 _C699', '', 0, 0, 0, 6, '12.00-20 _C699', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(151, '5.00-12 _C688', '', 0, 0, 0, 6, '5.00-12 _C688', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(152, '5.00-12 _C688L', '', 0, 0, 0, 6, '5.00-12 _C688L', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(153, '5.50-13 _C688', '', 0, 0, 0, 6, '5.50-13 _C688', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(154, '5.50-13 _C688L', '', 0, 0, 0, 6, '5.50-13 _C688L', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(155, '6.00-14 _C688', '', 0, 0, 0, 6, '6.00-14 _C688', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(156, '6.00-14 _C846', '', 0, 0, 0, 6, '6.00-14 _C846', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(157, '6.50-15 _C846', '', 0, 0, 0, 6, '6.50-15 _C846', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(158, '6.50-16_C886', '', 0, 0, 0, 6, '6.50-16_C886', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(159, '6.50-16 _C688', '', 0, 0, 0, 6, '6.50-16 _C688', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(160, '7.00-15 _C846', '', 0, 0, 0, 6, '7.00-15 _C846', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(161, '7.00-16_C886', '', 0, 0, 0, 6, '7.00-16_C886', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(162, '7.00-16 _C688', '', 0, 0, 0, 6, '7.00-16 _C688', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(163, '7.00-16 _NR066', '', 0, 0, 0, 6, '7.00-16 _NR066', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(164, '7.50-16_C886', '', 0, 0, 0, 6, '7.50-16_C886', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(165, '7.50-16 _C688', '', 0, 0, 0, 6, '7.50-16 _C688', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(166, '7.50-16 _HA858', '', 0, 0, 0, 6, '7.50-16 _HA858', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(167, '8.25-16_C886', '', 0, 0, 0, 6, '8.25-16_C886', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(168, '8.25-16_C688', '', 0, 0, 0, 6, '8.25-16_C688', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(169, '8.25-20 _C688', '', 0, 0, 0, 6, '8.25-20 _C688', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(170, '9.00-20 _C688', '', 0, 0, 0, 6, '9.00-20 _C688', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(171, '9.00-20 C886_C886', '', 0, 0, 0, 6, '9.00-20 C886_C886', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(172, '10.00-20_TR78', '', 0, 0, 0, 7, '10.00-20_TR78', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(173, '10.00R20M_TR78', '', 0, 0, 0, 7, '10.00R20M_TR78', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(174, '11.00-20_TR78', '', 0, 0, 0, 7, '11.00-20_TR78', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(175, '12.00-20_TR78A', '', 0, 0, 0, 7, '12.00-20_TR78A', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(176, '5.00-12_TR13', '', 0, 0, 0, 7, '5.00-12_TR13', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(177, '5.50-13_TR13', '', 0, 0, 0, 7, '5.50-13_TR13', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(178, '6.00-14_TR13', '', 0, 0, 0, 7, '6.00-14_TR13', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(179, '7.00-15_TR75', '', 0, 0, 0, 7, '7.00-15_TR75', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(180, '7.00-16_TR177', '', 0, 0, 0, 7, '7.00-16_TR177', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(181, '7.50-16_TR177', '', 0, 0, 0, 7, '7.50-16_TR177', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(182, '8.25 -20_TR177', '', 0, 0, 0, 7, '8.25 -20_TR177', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(183, '8.25-16_TR177', '', 0, 0, 0, 7, '8.25-16_TR177', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(184, '9.00-20_TR78', '', 0, 0, 0, 7, '9.00-20_TR78', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(185, '9.00-20 Superstone_TR78A ', '', 0, 0, 0, 7, '9.00-20 Superstone_T', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(186, '11.00/12.00-20', '', 0, 0, 0, 8, '11.00/12.00-20', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(187, 'Y5.00-8', '', 0, 0, 0, 8, 'Y5.00-8', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(188, '6.50/7.00-15', '', 0, 0, 0, 8, '6.50/7.00-15', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(189, '6.50/7.00-16', '', 0, 0, 0, 8, '6.50/7.00-16', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(190, '7.50/8.25-16', '', 0, 0, 0, 8, '7.50/8.25-16', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211'),
(191, ' 8.25-20', '', 0, 0, 0, 8, ' 8.25-20', NULL, NULL, NULL, '', 0, '1', '', 'PR01', 'GAI01', 1, '156', 0, '632', '5111', '5212', '154', '632', '5211'),
(192, '9.00/10.00-20', '', 0, 0, 0, 8, '9.00/10.00-20', NULL, NULL, NULL, '', 0, '', '', '', '', 0, '1561', 0, '632', '5111', '5212', '154', '632', '5211');

-- --------------------------------------------------------

--
-- Table structure for table `mat_move_invoices`
--

CREATE TABLE `mat_move_invoices` (
  `inv_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_date` int(10) UNSIGNED NOT NULL,
  `inv_code` varchar(20) NOT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `created_user` int(10) UNSIGNED NOT NULL,
  `stock_id` int(10) UNSIGNED DEFAULT NULL,
  `stock_id_to` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mat_move_invoice_details`
--

CREATE TABLE `mat_move_invoice_details` (
  `invd_id` int(10) UNSIGNED NOT NULL,
  `inv_id` int(10) UNSIGNED NOT NULL,
  `mat_quantity` float UNSIGNED NOT NULL,
  `smm_id` int(10) UNSIGNED DEFAULT NULL,
  `serials` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mat_msu`
--

CREATE TABLE `mat_msu` (
  `mms_id` int(10) UNSIGNED NOT NULL,
  `mat_id` int(10) UNSIGNED NOT NULL,
  `msu_id` int(10) UNSIGNED NOT NULL,
  `price` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `price_dealer` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `price_input` int(10) UNSIGNED DEFAULT NULL,
  `discount_input` int(10) UNSIGNED DEFAULT NULL,
  `price_dealer2` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mat_msu`
--

INSERT INTO `mat_msu` (`mms_id`, `mat_id`, `msu_id`, `price`, `price_dealer`, `price_input`, `discount_input`, `price_dealer2`) VALUES
(1, 1, 3, 0, 0, 0, 0, 0),
(2, 2, 3, 0, 0, 0, 0, 0),
(3, 3, 3, 0, 0, 0, 0, 0),
(4, 4, 3, 0, 0, 0, 0, 0),
(5, 5, 3, 0, 0, 0, 0, 0),
(6, 6, 3, 0, 0, 0, 0, 0),
(7, 7, 3, 0, 0, 0, 0, 0),
(8, 8, 3, 0, 0, 0, 0, 0),
(9, 9, 3, 0, 0, 0, 0, 0),
(10, 10, 3, 0, 0, 0, 0, 0),
(11, 11, 3, 0, 0, 0, 0, 0),
(12, 12, 3, 0, 0, 0, 0, 0),
(13, 13, 3, 0, 0, 0, 0, 0),
(14, 14, 3, 0, 0, 0, 0, 0),
(15, 15, 3, 0, 0, 0, 0, 0),
(16, 16, 3, 0, 0, 0, 0, 0),
(17, 17, 3, 0, 0, 0, 0, 0),
(18, 18, 3, 0, 0, 0, 0, 0),
(19, 19, 3, 0, 0, 0, 0, 0),
(20, 20, 3, 0, 0, 0, 0, 0),
(21, 21, 3, 0, 0, 0, 0, 0),
(22, 22, 3, 0, 0, 0, 0, 0),
(23, 23, 3, 0, 0, 0, 0, 0),
(24, 24, 3, 0, 0, 0, 0, 0),
(25, 25, 3, 0, 0, 0, 0, 0),
(26, 26, 3, 0, 0, 0, 0, 0),
(27, 27, 3, 0, 0, 0, 0, 0),
(28, 28, 3, 0, 0, 0, 0, 0),
(29, 29, 3, 0, 0, 0, 0, 0),
(30, 30, 3, 0, 0, 0, 0, 0),
(31, 31, 3, 0, 0, 0, 0, 0),
(32, 32, 3, 0, 0, 0, 0, 0),
(33, 33, 3, 0, 0, 0, 0, 0),
(34, 34, 3, 0, 0, 0, 0, 0),
(35, 35, 3, 0, 0, 0, 0, 0),
(36, 36, 3, 0, 0, 0, 0, 0),
(37, 37, 3, 0, 0, 0, 0, 0),
(38, 38, 3, 0, 0, 0, 0, 0),
(39, 39, 3, 0, 0, 0, 0, 0),
(40, 40, 3, 0, 0, 0, 0, 0),
(41, 41, 3, 0, 0, 0, 0, 0),
(42, 42, 3, 0, 0, 0, 0, 0),
(43, 43, 3, 0, 0, 0, 0, 0),
(44, 44, 3, 0, 0, 0, 0, 0),
(45, 45, 3, 0, 0, 0, 0, 0),
(46, 46, 3, 0, 0, 0, 0, 0),
(47, 47, 3, 0, 0, 0, 0, 0),
(48, 48, 3, 0, 0, 0, 0, 0),
(49, 49, 3, 0, 0, 0, 0, 0),
(50, 50, 3, 0, 0, 0, 0, 0),
(51, 51, 3, 0, 0, 0, 0, 0),
(52, 52, 3, 0, 0, 0, 0, 0),
(53, 53, 3, 0, 0, 0, 0, 0),
(54, 54, 3, 0, 0, 0, 0, 0),
(55, 55, 3, 0, 0, 0, 0, 0),
(56, 56, 3, 0, 0, 0, 0, 0),
(57, 57, 3, 0, 0, 0, 0, 0),
(58, 58, 3, 0, 0, 0, 0, 0),
(59, 59, 3, 0, 0, 0, 0, 0),
(60, 60, 3, 0, 0, 0, 0, 0),
(61, 61, 3, 0, 0, 0, 0, 0),
(62, 62, 3, 0, 0, 0, 0, 0),
(63, 63, 3, 0, 0, 0, 0, 0),
(64, 64, 3, 0, 0, 0, 0, 0),
(65, 65, 3, 0, 0, 0, 0, 0),
(66, 66, 3, 0, 0, 0, 0, 0),
(67, 67, 3, 0, 0, 0, 0, 0),
(68, 68, 3, 0, 0, 0, 0, 0),
(69, 69, 3, 0, 0, 0, 0, 0),
(70, 70, 3, 0, 0, 0, 0, 0),
(71, 71, 3, 0, 0, 0, 0, 0),
(72, 72, 3, 0, 0, 0, 0, 0),
(73, 73, 3, 0, 0, 0, 0, 0),
(74, 74, 3, 0, 0, 0, 0, 0),
(75, 75, 3, 0, 0, 0, 0, 0),
(76, 76, 3, 0, 0, 0, 0, 0),
(77, 77, 3, 0, 0, 0, 0, 0),
(78, 78, 3, 0, 0, 0, 0, 0),
(79, 79, 3, 0, 0, 0, 0, 0),
(80, 80, 3, 0, 0, 0, 0, 0),
(81, 81, 3, 0, 0, 0, 0, 0),
(82, 82, 3, 0, 0, 0, 0, 0),
(83, 83, 3, 0, 0, 0, 0, 0),
(84, 84, 3, 0, 0, 0, 0, 0),
(85, 85, 3, 0, 0, 0, 0, 0),
(86, 86, 3, 0, 0, 0, 0, 0),
(87, 87, 3, 0, 0, 0, 0, 0),
(88, 88, 3, 0, 0, 0, 0, 0),
(89, 89, 3, 0, 0, 0, 0, 0),
(90, 90, 3, 0, 0, 0, 0, 0),
(91, 91, 3, 0, 0, 0, 0, 0),
(92, 92, 3, 0, 0, 0, 0, 0),
(93, 93, 3, 0, 0, 0, 0, 0),
(94, 94, 3, 0, 0, 0, 0, 0),
(95, 95, 3, 0, 0, 0, 0, 0),
(96, 96, 3, 0, 0, 0, 0, 0),
(97, 97, 3, 0, 0, 0, 0, 0),
(98, 98, 3, 0, 0, 0, 0, 0),
(99, 99, 3, 0, 0, 0, 0, 0),
(100, 100, 3, 0, 0, 0, 0, 0),
(101, 101, 3, 0, 0, 0, 0, 0),
(102, 102, 3, 0, 0, 0, 0, 0),
(103, 103, 3, 0, 0, 0, 0, 0),
(104, 104, 3, 0, 0, 0, 0, 0),
(105, 105, 3, 0, 0, 0, 0, 0),
(106, 106, 3, 0, 0, 0, 0, 0),
(107, 107, 3, 0, 0, 0, 0, 0),
(108, 108, 3, 0, 0, 0, 0, 0),
(109, 109, 3, 0, 0, 0, 0, 0),
(110, 110, 3, 0, 0, 0, 0, 0),
(111, 111, 3, 0, 0, 0, 0, 0),
(112, 112, 3, 0, 0, 0, 0, 0),
(113, 113, 3, 0, 0, 0, 0, 0),
(114, 114, 3, 0, 0, 0, 0, 0),
(115, 115, 3, 0, 0, 0, 0, 0),
(116, 116, 3, 0, 0, 0, 0, 0),
(117, 117, 3, 0, 0, 0, 0, 0),
(118, 118, 3, 0, 0, 0, 0, 0),
(119, 119, 3, 0, 0, 0, 0, 0),
(120, 120, 3, 0, 0, 0, 0, 0),
(121, 121, 3, 0, 0, 0, 0, 0),
(122, 122, 3, 0, 0, 0, 0, 0),
(123, 123, 3, 0, 0, 0, 0, 0),
(124, 124, 3, 0, 0, 0, 0, 0),
(125, 125, 3, 0, 0, 0, 0, 0),
(126, 126, 3, 0, 0, 0, 0, 0),
(127, 127, 3, 0, 0, 0, 0, 0),
(128, 128, 3, 0, 0, 0, 0, 0),
(129, 129, 3, 0, 0, 0, 0, 0),
(130, 130, 3, 0, 0, 0, 0, 0),
(131, 131, 3, 0, 0, 0, 0, 0),
(132, 132, 3, 0, 0, 0, 0, 0),
(133, 133, 3, 0, 0, 0, 0, 0),
(134, 134, 3, 0, 0, 0, 0, 0),
(135, 135, 3, 0, 0, 0, 0, 0),
(136, 136, 3, 0, 0, 0, 0, 0),
(137, 137, 3, 0, 0, 0, 0, 0),
(138, 138, 3, 0, 0, 0, 0, 0),
(139, 139, 3, 0, 0, 0, 0, 0),
(140, 140, 3, 0, 0, 0, 0, 0),
(141, 141, 3, 0, 0, 0, 0, 0),
(142, 142, 3, 0, 0, 0, 0, 0),
(143, 143, 3, 0, 0, 0, 0, 0),
(144, 144, 3, 0, 0, 0, 0, 0),
(145, 145, 3, 0, 0, 0, 0, 0),
(146, 146, 3, 0, 0, 0, 0, 0),
(147, 147, 3, 0, 0, 0, 0, 0),
(148, 148, 3, 0, 0, 0, 0, 0),
(149, 149, 3, 0, 0, 0, 0, 0),
(150, 150, 3, 0, 0, 0, 0, 0),
(151, 151, 3, 0, 0, 0, 0, 0),
(152, 152, 3, 0, 0, 0, 0, 0),
(153, 153, 3, 0, 0, 0, 0, 0),
(154, 154, 3, 0, 0, 0, 0, 0),
(155, 155, 3, 0, 0, 0, 0, 0),
(156, 156, 3, 0, 0, 0, 0, 0),
(157, 157, 3, 0, 0, 0, 0, 0),
(158, 158, 3, 0, 0, 0, 0, 0),
(159, 159, 3, 0, 0, 0, 0, 0),
(160, 160, 3, 0, 0, 0, 0, 0),
(161, 161, 3, 0, 0, 0, 0, 0),
(162, 162, 3, 0, 0, 0, 0, 0),
(163, 163, 3, 0, 0, 0, 0, 0),
(164, 164, 3, 0, 0, 0, 0, 0),
(165, 165, 3, 0, 0, 0, 0, 0),
(166, 166, 3, 0, 0, 0, 0, 0),
(167, 167, 3, 0, 0, 0, 0, 0),
(168, 168, 3, 0, 0, 0, 0, 0),
(169, 169, 3, 0, 0, 0, 0, 0),
(170, 170, 3, 0, 0, 0, 0, 0),
(171, 171, 3, 0, 0, 0, 0, 0),
(172, 172, 3, 0, 0, 0, 0, 0),
(173, 173, 3, 0, 0, 0, 0, 0),
(174, 174, 3, 0, 0, 0, 0, 0),
(175, 175, 3, 0, 0, 0, 0, 0),
(176, 176, 3, 0, 0, 0, 0, 0),
(177, 177, 3, 0, 0, 0, 0, 0),
(178, 178, 3, 0, 0, 0, 0, 0),
(179, 179, 3, 0, 0, 0, 0, 0),
(180, 180, 3, 0, 0, 0, 0, 0),
(181, 181, 3, 0, 0, 0, 0, 0),
(182, 182, 3, 0, 0, 0, 0, 0),
(183, 183, 3, 0, 0, 0, 0, 0),
(184, 184, 3, 0, 0, 0, 0, 0),
(185, 185, 3, 0, 0, 0, 0, 0),
(186, 186, 3, 0, 0, 0, 0, 0),
(187, 187, 3, 0, 0, 0, 0, 0),
(188, 188, 3, 0, 0, 0, 0, 0),
(189, 189, 3, 0, 0, 0, 0, 0),
(190, 190, 3, 0, 0, 0, 0, 0),
(191, 191, 3, 0, 0, 0, 0, 0),
(192, 192, 3, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `mat_return_invoices`
--

CREATE TABLE `mat_return_invoices` (
  `inv_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_date` int(10) UNSIGNED NOT NULL,
  `inv_code` varchar(10) NOT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `sup_id` int(10) UNSIGNED DEFAULT NULL,
  `created_user` int(10) UNSIGNED NOT NULL,
  `stock_id` int(10) UNSIGNED DEFAULT NULL,
  `cus_id` int(10) UNSIGNED DEFAULT NULL,
  `emp_stock_id` int(10) UNSIGNED DEFAULT NULL,
  `total` int(10) UNSIGNED DEFAULT NULL,
  `paid_type` tinyint(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mat_return_invoice_details`
--

CREATE TABLE `mat_return_invoice_details` (
  `invd_id` int(10) UNSIGNED NOT NULL,
  `inv_id` int(10) UNSIGNED NOT NULL,
  `mat_quantity` float UNSIGNED NOT NULL,
  `amount` int(10) UNSIGNED DEFAULT NULL,
  `smm_id` int(10) UNSIGNED DEFAULT NULL,
  `serials` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='InnoDB free: 10240 kB; (`smm_id`) REFER `bms/stock_mat_msu`(';

-- --------------------------------------------------------

--
-- Table structure for table `mat_split`
--

CREATE TABLE `mat_split` (
  `msp_id` int(10) UNSIGNED NOT NULL,
  `smm_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `msu_list` varchar(255) DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_date` int(10) UNSIGNED NOT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `inv_code` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `mat_split_history`
--

CREATE TABLE `mat_split_history` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `inv_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `created_date` int(10) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `mat_id` int(11) NOT NULL,
  `mfa_id` int(11) NOT NULL,
  `smm_id` int(11) NOT NULL,
  `serial` int(11) NOT NULL DEFAULT 0,
  `comment` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mat_split_history_details`
--

CREATE TABLE `mat_split_history_details` (
  `id` int(11) NOT NULL,
  `msh_id` int(11) NOT NULL,
  `mat_id` int(10) NOT NULL,
  `mms_id` int(11) NOT NULL DEFAULT 0,
  `stock_id` int(10) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `meansure`
--

CREATE TABLE `meansure` (
  `msu_id` int(10) UNSIGNED NOT NULL,
  `msu_name` varchar(45) NOT NULL,
  `msu_parid` int(10) UNSIGNED DEFAULT NULL,
  `msu_multiple` double NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(84, 'viên', NULL, 1),
(85, 'Sợi', NULL, 1),
(86, 'Bản', NULL, 1),
(87, 'Chiếc', NULL, 1),
(88, 'Thanh', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `mfa_mat`
--

CREATE TABLE `mfa_mat` (
  `mma_id` int(10) UNSIGNED NOT NULL,
  `mfa_id` int(10) UNSIGNED NOT NULL,
  `mat_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `nhomhopdong`
--

CREATE TABLE `nhomhopdong` (
  `id_nhd` int(11) NOT NULL,
  `nhd_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `nhd_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `nhomhopdong`
--

INSERT INTO `nhomhopdong` (`id_nhd`, `nhd_code`, `nhd_name`) VALUES
(1, '1', 'Hàng hóa dịch vụ dùng riêng cho SXKD chịu thuế GTGT đủ điều kiện khấu trừ thuế'),
(2, '2', 'Hàng hóa dịch vụ không đủ điều kiện khấu trừ'),
(3, '3', 'Hàng hoá, dịch vụ dùng chung cho SXKD chịu thuế và không chịu thuế đủ điều kiện khấu trừ thuế'),
(4, '4', 'Hàng hóa, dịch vụ dùng cho dự án đầu tư đủ điều kiện được khấu trừ thuế'),
(5, '5', 'Hàng hóa, dịch vụ không phải tổng hợp trên tờ khai 01/GTGT');

-- --------------------------------------------------------

--
-- Table structure for table `out_invoices`
--

CREATE TABLE `out_invoices` (
  `inv_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_date` int(10) UNSIGNED NOT NULL,
  `inv_code` varchar(10) NOT NULL,
  `cus_id` int(10) UNSIGNED DEFAULT NULL,
  `total` int(10) UNSIGNED NOT NULL,
  `payment` int(10) UNSIGNED NOT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `vat` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `inv_type` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `created_user` int(10) UNSIGNED NOT NULL,
  `price_type` varchar(10) DEFAULT 'enduser',
  `stock_id` int(10) UNSIGNED DEFAULT NULL,
  `draft` tinyint(1) DEFAULT NULL,
  `max_time` int(11) DEFAULT 0,
  `vat_per` float NOT NULL DEFAULT 0,
  `vat_price` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `out_invoices`
--

INSERT INTO `out_invoices` (`inv_id`, `user_id`, `created_date`, `inv_code`, `cus_id`, `total`, `payment`, `comment`, `vat`, `inv_type`, `created_user`, `price_type`, `stock_id`, `draft`, `max_time`, `vat_per`, `vat_price`) VALUES
(7, 1, 1578021010, 'XK00000001', 1, 12000000, 0, '', 0, 0, 1, 'enduser', 15, 0, 1578021010, 0, 0),
(8, 1, 1578378023, 'XK0008', 1, 55000, 0, '', 1, 0, 1, 'enduser', 15, 0, 1578378023, 10, 5000),
(9, 1, 1578392728, 'XK00000009', 1, 11000000, 11000000, '', 0, 0, 1, 'enduser', 15, 0, 1578392728, 10, 1000000),
(10, 1, 1578896725, 'XK00000010', 1, 100000, 0, '', 0, 0, 1, 'enduser', 15, 0, 1578896725, 0, 0),
(11, 1, 1578896726, 'XK00000011', 2, 290000, 0, '', 0, 0, 1, 'enduser', 15, 0, 1578896726, 0, 0),
(12, 1, 1578977633, 'XK00000012', 1, 990000, 0, '', 0, 0, 1, 'enduser', 15, 0, 1578977633, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `out_invoice_details`
--

CREATE TABLE `out_invoice_details` (
  `invd_id` int(10) UNSIGNED NOT NULL,
  `inv_id` int(10) UNSIGNED NOT NULL,
  `mat_quantity` float UNSIGNED NOT NULL,
  `amount` int(10) UNSIGNED DEFAULT NULL,
  `smm_id` int(10) UNSIGNED NOT NULL,
  `price` int(11) DEFAULT NULL,
  `vat` tinyint(2) NOT NULL DEFAULT 0,
  `inprice` int(11) NOT NULL DEFAULT 0,
  `inv` int(11) NOT NULL,
  `inamount` int(11) NOT NULL DEFAULT 0,
  `ck_price` int(11) NOT NULL DEFAULT 0,
  `v_price` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `out_invoice_details`
--

INSERT INTO `out_invoice_details` (`invd_id`, `inv_id`, `mat_quantity`, `amount`, `smm_id`, `price`, `vat`, `inprice`, `inv`, `inamount`, `ck_price`, `v_price`) VALUES
(7, 7, 10, 12000000, 194, 1200000, 0, 1000000, 7, 10000000, 0, 0),
(8, 8, 1, 50000, 194, 50000, 0, 50000, 8, 50000, 0, 0),
(9, 9, 10, 10000000, 194, 1000000, 0, 1000000, 7, 10000000, 0, 0),
(10, 10, 1, 100000, 199, 100000, 0, 0, 15, 0, 0, 0),
(11, 11, 1, 290000, 194, 290000, 0, 200000, 10, 200000, 0, 0),
(12, 12, 1, 990000, 194, 1000000, 10, 1000000, 7, 1000000, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `out_serials`
--

CREATE TABLE `out_serials` (
  `serial_id` int(10) UNSIGNED NOT NULL,
  `serial_start` varchar(20) DEFAULT NULL,
  `serial_end` varchar(20) DEFAULT NULL,
  `invd_id` int(10) UNSIGNED DEFAULT NULL,
  `in_price` int(11) NOT NULL DEFAULT 0,
  `out_price` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `phuphi`
--

CREATE TABLE `phuphi` (
  `pp_id` int(11) NOT NULL,
  `pp_code` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `inv_id` int(11) NOT NULL DEFAULT 0,
  `i_inv_id` int(11) NOT NULL DEFAULT 0,
  `pp_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pp_type` int(11) NOT NULL DEFAULT 0,
  `pp_pay` int(11) NOT NULL DEFAULT 0,
  `pp_vat` float NOT NULL DEFAULT 0,
  `pp_price` int(11) NOT NULL DEFAULT 0,
  `pp_show` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `phuphi`
--

INSERT INTO `phuphi` (`pp_id`, `pp_code`, `inv_id`, `i_inv_id`, `pp_name`, `pp_type`, `pp_pay`, `pp_vat`, `pp_price`, `pp_show`) VALUES
(1, '3378', 0, 9, 'Phí nao do', 0, 200000, 10, 220000, 0),
(2, '111', 0, 11, 'Phí ...', 0, 555, 10, 611110, 0);

-- --------------------------------------------------------

--
-- Table structure for table `serials`
--

CREATE TABLE `serials` (
  `serial_id` int(10) UNSIGNED NOT NULL,
  `serial_start` varchar(20) DEFAULT NULL,
  `serial_end` varchar(20) DEFAULT NULL,
  `invd_id` int(10) UNSIGNED DEFAULT NULL,
  `mms_id` int(10) UNSIGNED DEFAULT NULL,
  `smm_id` int(10) UNSIGNED DEFAULT NULL,
  `s_price` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `session_id` varchar(32) NOT NULL DEFAULT '',
  `start_time` int(11) NOT NULL DEFAULT 0,
  `user_id` int(10) UNSIGNED DEFAULT 0,
  `ip` varchar(15) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`session_id`, `start_time`, `user_id`, `ip`) VALUES
('b0gfikgthknlpdj6ofu71e4egi', 1579573209, 1, '::1');

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `stock_id` int(10) UNSIGNED NOT NULL,
  `stock_name` varchar(200) NOT NULL,
  `address` varchar(300) NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `user_list` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`stock_id`, `stock_name`, `address`, `user_id`, `user_list`) VALUES
(1, 'Kho Quận 10', 'Quận 10 - HCM', NULL, NULL),
(15, 'Kho Bình Dương', '854 Quốc Lộ 1K', NULL, NULL),
(17, 'Kho Vĩnh Long', 'Thành Phố Vĩnh Long', NULL, NULL),
(18, 'Kho Phú Yên', 'Tỉnh Phú Yên', NULL, NULL),
(19, 'Kho Quận 8', 'Quận 8 -TPHCM', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stock_mat_msu`
--

CREATE TABLE `stock_mat_msu` (
  `smm_id` int(10) UNSIGNED NOT NULL,
  `stock_id` int(10) UNSIGNED NOT NULL,
  `mms_id` int(10) UNSIGNED NOT NULL,
  `quantity` float DEFAULT 0,
  `instock` float NOT NULL DEFAULT 0,
  `price` float DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stock_mat_msu`
--

INSERT INTO `stock_mat_msu` (`smm_id`, `stock_id`, `mms_id`, `quantity`, `instock`, `price`) VALUES
(194, 15, 191, 9868, 0, 0),
(195, 15, 145, 200, 0, 0),
(196, 15, 173, 1, 0, 0),
(197, 15, 21, 1, 0, 0),
(198, 15, 147, 1, 0, 0),
(199, 15, 172, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `supliers`
--

CREATE TABLE `supliers` (
  `sup_id` int(10) UNSIGNED NOT NULL,
  `sup_name` varchar(200) NOT NULL,
  `address` varchar(200) DEFAULT NULL,
  `tel` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `website` varchar(100) DEFAULT NULL,
  `tax_no` varchar(20) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `reg_no` varchar(20) DEFAULT NULL,
  `bank_acc` varchar(30) DEFAULT NULL,
  `bank_name` varchar(200) DEFAULT NULL,
  `debt` int(11) DEFAULT 0,
  `sup_code` varchar(15) DEFAULT NULL,
  `taikhoan` varchar(50) NOT NULL DEFAULT '',
  `duno` bigint(20) NOT NULL DEFAULT 0,
  `duco` bigint(20) NOT NULL DEFAULT 0,
  `duno_nt` bigint(20) NOT NULL DEFAULT 0,
  `duco_nt` bigint(20) NOT NULL DEFAULT 0,
  `duno_dn` bigint(20) NOT NULL DEFAULT 0,
  `duco_dn` bigint(20) NOT NULL DEFAULT 0,
  `duno_ntdn` bigint(20) NOT NULL DEFAULT 0,
  `duco_ntdn` bigint(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `supliers`
--

INSERT INTO `supliers` (`sup_id`, `sup_name`, `address`, `tel`, `email`, `website`, `tax_no`, `description`, `reg_no`, `bank_acc`, `bank_name`, `debt`, `sup_code`, `taikhoan`, `duno`, `duco`, `duno_nt`, `duco_nt`, `duno_dn`, `duco_dn`, `duno_ntdn`, `duco_ntdn`) VALUES
(1, 'Công ty aCM', '', '', '', '', '', '', '', '', '', 0, 'NCC00000001', '', 0, 0, 0, 0, 0, 0, 0, 0),
(2, 'Maxxis Ching Shen', '', '', 'vangtm@sp-itc.com.vn', '', '12345677', '', '', '5456577676767', 'VCB', 200000, 'NCC00000002', '1111', 100000, 0, 0, 0, 0, 0, 0, 0),
(3, 'Nhà cung cấp 1', '', '', '', '', '', '', '', '', '', 0, 'NCC00000003', '221a', 1, 2, 3, 4, 5, 6, 7, 8);

-- --------------------------------------------------------

--
-- Table structure for table `sup_mat`
--

CREATE TABLE `sup_mat` (
  `sma_id` int(10) UNSIGNED NOT NULL,
  `sup_id` int(10) UNSIGNED NOT NULL,
  `mat_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sup_mat`
--

INSERT INTO `sup_mat` (`sma_id`, `sup_id`, `mat_id`) VALUES
(1, 1, 2),
(2, 3, 3),
(3, 1447, 1445),
(4, 80, 656),
(5, 80, 1612),
(6, 886, 936),
(7, 1447, 656),
(8, 1447, 31),
(9, 1447, 243),
(10, 886, 12),
(11, 392, 616),
(12, 1447, 832),
(13, 1447, 1819),
(14, 886, 243),
(15, 886, 2109),
(16, 392, 656),
(17, 1447, 12),
(18, 1447, 1906),
(19, 1447, 1478),
(20, 1447, 2642),
(21, 80, 2645),
(22, 80, 243),
(23, 886, 1722),
(24, 80, 2646),
(25, 80, 1722),
(26, 392, 1819),
(27, 392, 243),
(28, 392, 5),
(29, 80, 2109),
(30, 80, 2644),
(31, 1, 173),
(32, 2, 173),
(33, 1, 20),
(34, 2, 191),
(35, 2, 145),
(36, 1, 191),
(37, 3, 173),
(38, 3, 21),
(39, 3, 147),
(40, 2, 172),
(41, 1, 145);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `password` varchar(32) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `sex` tinyint(3) UNSIGNED DEFAULT NULL,
  `created_date` int(10) UNSIGNED DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `tel` varchar(15) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  `group_id` int(10) UNSIGNED DEFAULT NULL,
  `dept_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `password`, `user_name`, `email`, `full_name`, `sex`, `created_date`, `address`, `tel`, `description`, `group_id`, `dept_id`) VALUES
(1, '21232f297a57a5a743894a0e4a801fc3', 'admin', '', 'Administrator', 1, 0, '', '', NULL, 1, 1),
(3, 'e10adc3949ba59abbe56e057f20f883e', 'test', 'test@gmail.com', 'test', 0, 1568279392, '', '', '', 1, 2),
(4, 'e10adc3949ba59abbe56e057f20f883e', 'anhnam', '', 'Nguyễn văn Nam', 0, 1575364195, 'Vĩnh Khánh', '2233444', '', 1, 2),
(5, 'e10adc3949ba59abbe56e057f20f883e', 'kythuat', '', 'Phòng Kỹ Thuật', 0, 1577154153, '', '', '', 9, 7),
(6, 'e10adc3949ba59abbe56e057f20f883e', 'ketoan', '', 'Kế Toán', 0, 1577154242, '', '', '', 11, 3);

-- --------------------------------------------------------

--
-- Table structure for table `user_group_permission`
--

CREATE TABLE `user_group_permission` (
  `ugp_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `group_id` int(10) UNSIGNED DEFAULT NULL,
  `fmenu_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(2535, NULL, 1, 31),
(2536, NULL, 1, 32),
(2537, NULL, 1, 33),
(2538, NULL, 1, 34),
(2539, NULL, 1, 35),
(2540, NULL, 1, 36),
(2541, NULL, 1, 37),
(2542, NULL, 1, 38),
(2543, NULL, 1, 39),
(2544, NULL, 1, 40),
(2545, NULL, 1, 41),
(2546, NULL, 1, 46),
(2547, NULL, 1, 74),
(2548, NULL, 1, 75),
(2549, NULL, 1, 94),
(2550, NULL, 1, 24),
(2551, NULL, 1, 25),
(2552, NULL, 1, 26),
(2553, NULL, 1, 27),
(2554, NULL, 1, 28),
(2555, NULL, 1, 29),
(2556, NULL, 1, 30),
(2557, NULL, 1, 47),
(2558, NULL, 1, 48),
(2559, NULL, 1, 49),
(2560, NULL, 1, 96),
(2561, NULL, 1, 97),
(2562, NULL, 1, 21),
(2563, NULL, 1, 22),
(2564, NULL, 1, 54),
(2565, NULL, 1, 23),
(2566, NULL, 1, 53),
(2567, NULL, 1, 5),
(2568, NULL, 1, 6),
(2569, NULL, 1, 7),
(2570, NULL, 1, 8),
(2571, NULL, 1, 9),
(2572, NULL, 1, 10),
(2573, NULL, 1, 11),
(2574, NULL, 1, 12),
(2575, NULL, 1, 13),
(2576, NULL, 1, 14),
(2577, NULL, 1, 15),
(2578, NULL, 1, 16),
(2579, NULL, 1, 17),
(2580, NULL, 1, 50),
(2581, NULL, 1, 19),
(2582, NULL, 1, 20),
(2583, NULL, 1, 57),
(2584, NULL, 1, 55),
(2585, NULL, 1, 56),
(2586, NULL, 1, 95),
(2587, NULL, 1, 18),
(2588, NULL, 1, 58),
(2589, NULL, 1, 59),
(2590, NULL, 1, 60),
(2591, NULL, 1, 61),
(2592, NULL, 1, 62),
(2593, NULL, 1, 63),
(2594, NULL, 1, 64),
(2595, NULL, 1, 65),
(2596, NULL, 1, 66),
(2597, NULL, 1, 67),
(2598, NULL, 1, 68),
(2599, NULL, 1, 69),
(2600, NULL, 1, 70),
(2601, NULL, 1, 71),
(2602, NULL, 1, 72),
(2603, NULL, 1, 73),
(2604, NULL, 1, 76),
(2605, NULL, 1, 77),
(2606, NULL, 1, 44),
(2607, NULL, 1, 45),
(2608, NULL, 1, 52),
(2609, NULL, 1, 51),
(2610, NULL, 1, 81),
(2611, NULL, 1, 82),
(2612, NULL, 1, 83),
(2613, NULL, 1, 84),
(2614, NULL, 1, 85),
(2615, NULL, 1, 86),
(2616, NULL, 1, 87),
(2617, NULL, 1, 88),
(2618, NULL, 1, 89),
(2619, NULL, 1, 90),
(2620, NULL, 1, 91),
(2621, NULL, 1, 92),
(2622, NULL, 1, 93),
(2623, NULL, 1, 78),
(2624, NULL, 1, 79),
(2628, NULL, 5, 21),
(2629, NULL, 5, 22),
(2630, NULL, 5, 54),
(2631, NULL, 5, 23),
(2632, NULL, 5, 53),
(2633, NULL, 11, 31),
(2634, NULL, 11, 32),
(2635, NULL, 11, 33),
(2636, NULL, 11, 34),
(2637, NULL, 11, 35),
(2638, NULL, 11, 36),
(2639, NULL, 11, 37),
(2640, NULL, 11, 38),
(2641, NULL, 11, 39),
(2642, NULL, 11, 40),
(2643, NULL, 11, 41),
(2644, NULL, 11, 46),
(2645, NULL, 11, 74),
(2646, NULL, 11, 75),
(2647, NULL, 11, 21),
(2648, NULL, 11, 22),
(2649, NULL, 11, 54),
(2650, NULL, 11, 23),
(2651, NULL, 11, 5),
(2652, NULL, 11, 6),
(2653, NULL, 11, 7),
(2654, NULL, 11, 8),
(2655, NULL, 11, 9),
(2656, NULL, 11, 13),
(2657, NULL, 11, 16),
(2658, NULL, 11, 50),
(2659, NULL, 11, 20),
(2660, NULL, 11, 44),
(2661, NULL, 11, 45),
(2662, NULL, 11, 52),
(2663, NULL, 11, 51),
(2754, 3, NULL, 31),
(2755, 3, NULL, 32),
(2756, 3, NULL, 33),
(2757, 3, NULL, 34),
(2758, 3, NULL, 35),
(2759, 3, NULL, 36),
(2760, 3, NULL, 37),
(2761, 3, NULL, 38),
(2762, 3, NULL, 39),
(2763, 3, NULL, 40),
(2764, 3, NULL, 41),
(2765, 3, NULL, 46),
(2766, 3, NULL, 74),
(2767, 3, NULL, 75),
(2768, 3, NULL, 94),
(2769, 3, NULL, 24),
(2770, 3, NULL, 25),
(2771, 3, NULL, 26),
(2772, 3, NULL, 27),
(2773, 3, NULL, 28),
(2774, 3, NULL, 29),
(2775, 3, NULL, 30),
(2776, 3, NULL, 47),
(2777, 3, NULL, 48),
(2778, 3, NULL, 49),
(2779, 3, NULL, 96),
(2780, 3, NULL, 97),
(2781, 3, NULL, 21),
(2782, 3, NULL, 22),
(2783, 3, NULL, 54),
(2784, 3, NULL, 23),
(2785, 3, NULL, 53),
(2786, 3, NULL, 5),
(2787, 3, NULL, 6),
(2788, 3, NULL, 7),
(2789, 3, NULL, 8),
(2790, 3, NULL, 9),
(2791, 3, NULL, 10),
(2792, 3, NULL, 11),
(2793, 3, NULL, 12),
(2794, 3, NULL, 13),
(2795, 3, NULL, 14),
(2796, 3, NULL, 15),
(2797, 3, NULL, 16),
(2798, 3, NULL, 17),
(2799, 3, NULL, 50),
(2800, 3, NULL, 19),
(2801, 3, NULL, 20),
(2802, 3, NULL, 57),
(2803, 3, NULL, 55),
(2804, 3, NULL, 56),
(2805, 3, NULL, 95),
(2806, 3, NULL, 18),
(2807, 3, NULL, 58),
(2808, 3, NULL, 59),
(2809, 3, NULL, 60),
(2810, 3, NULL, 61),
(2811, 3, NULL, 62),
(2812, 3, NULL, 63),
(2813, 3, NULL, 64),
(2814, 3, NULL, 65),
(2815, 3, NULL, 66),
(2816, 3, NULL, 67),
(2817, 3, NULL, 68),
(2818, 3, NULL, 69),
(2819, 3, NULL, 70),
(2820, 3, NULL, 71),
(2821, 3, NULL, 72),
(2822, 3, NULL, 73),
(2823, 3, NULL, 76),
(2824, 3, NULL, 77),
(2825, 3, NULL, 44),
(2826, 3, NULL, 45),
(2827, 3, NULL, 52),
(2828, 3, NULL, 51),
(2829, 3, NULL, 81),
(2830, 3, NULL, 82),
(2831, 3, NULL, 83),
(2832, 3, NULL, 84),
(2833, 3, NULL, 85),
(2834, 3, NULL, 86),
(2835, 3, NULL, 87),
(2836, 3, NULL, 88),
(2837, 3, NULL, 89),
(2838, 3, NULL, 90),
(2839, 3, NULL, 91),
(2840, 3, NULL, 92),
(2841, 3, NULL, 93),
(2842, 3, NULL, 78),
(2843, 3, NULL, 79);

-- --------------------------------------------------------

--
-- Table structure for table `waranty_dept`
--

CREATE TABLE `waranty_dept` (
  `dept_id` int(10) UNSIGNED NOT NULL,
  `dept_name` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `waranty_dept`
--

INSERT INTO `waranty_dept` (`dept_id`, `dept_name`) VALUES
(1, 'Bảo hành'),
(2, 'Bảo hành Server'),
(3, 'Dich Vu'),
(4, 'Ram');

-- --------------------------------------------------------

--
-- Table structure for table `waranty_invoices`
--

CREATE TABLE `waranty_invoices` (
  `inv_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_date` int(10) UNSIGNED NOT NULL,
  `inv_code` varchar(10) NOT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `inv_status` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `created_user` int(10) UNSIGNED NOT NULL,
  `cus_id` int(10) UNSIGNED DEFAULT NULL,
  `cus_name` varchar(300) DEFAULT NULL,
  `dept_id` int(10) UNSIGNED DEFAULT NULL,
  `user_accept` int(10) UNSIGNED DEFAULT NULL,
  `user_finish` int(10) UNSIGNED DEFAULT NULL,
  `accept_date` int(10) UNSIGNED DEFAULT NULL,
  `address` varchar(300) DEFAULT NULL,
  `tel` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `waranty_invoice_details`
--

CREATE TABLE `waranty_invoice_details` (
  `invd_id` int(10) UNSIGNED NOT NULL,
  `inv_id` int(10) UNSIGNED NOT NULL,
  `mat_quantity` float UNSIGNED NOT NULL,
  `serial` varchar(200) DEFAULT NULL,
  `oinvd_id` int(10) UNSIGNED DEFAULT NULL,
  `return_date` int(10) UNSIGNED DEFAULT NULL,
  `mat_name` varchar(200) DEFAULT NULL,
  `warn_desc` varchar(300) DEFAULT NULL,
  `warn_status` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `service_fee` float UNSIGNED DEFAULT NULL,
  `service_type` varchar(5) DEFAULT NULL,
  `inv_date` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='InnoDB free: 10240 kB; (`smm_id`) REFER `bms/stock_mat_msu`(';

-- --------------------------------------------------------

--
-- Table structure for table `waranty_materials`
--

CREATE TABLE `waranty_materials` (
  `wma_id` int(10) UNSIGNED NOT NULL,
  `invd_id` int(10) UNSIGNED NOT NULL,
  `mat_id` int(10) UNSIGNED DEFAULT NULL,
  `mat_name` varchar(200) NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `waranty` varchar(50) DEFAULT NULL,
  `price` float UNSIGNED NOT NULL DEFAULT 0,
  `mat_status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `waranty_services`
--

CREATE TABLE `waranty_services` (
  `wsv_id` int(10) UNSIGNED NOT NULL,
  `invd_id` int(10) UNSIGNED NOT NULL,
  `service_name` varchar(200) NOT NULL,
  `service_desc` varchar(300) DEFAULT NULL,
  `service_fee` float DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `budget_invoices`
--
ALTER TABLE `budget_invoices`
  ADD PRIMARY KEY (`bin_id`),
  ADD KEY `fk_bin_usr` (`user_id`),
  ADD KEY `fk_bin_item` (`item_id`),
  ADD KEY `fk_bin_sup` (`sup_id`),
  ADD KEY `fk_bin_inv` (`inv_id`),
  ADD KEY `fk_bin_usr2` (`emp_id`),
  ADD KEY `fk_bin_usr3` (`created_user`),
  ADD KEY `fk_bin_oinv` (`oinv_id`),
  ADD KEY `fk_bin_fund` (`fund_id`),
  ADD KEY `fk_bin_mri` (`mriinv_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `congno`
--
ALTER TABLE `congno`
  ADD PRIMARY KEY (`cn_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`cus_id`);

--
-- Indexes for table `dept`
--
ALTER TABLE `dept`
  ADD PRIMARY KEY (`dept_id`);

--
-- Indexes for table `domains`
--
ALTER TABLE `domains`
  ADD PRIMARY KEY (`sdo_id`);

--
-- Indexes for table `function_menu`
--
ALTER TABLE `function_menu`
  ADD PRIMARY KEY (`fmenu_id`),
  ADD KEY `fk_fmenu_fmenu` (`fmenu_parid`);

--
-- Indexes for table `fund`
--
ALTER TABLE `fund`
  ADD PRIMARY KEY (`fund_id`),
  ADD KEY `fk_fund_user` (`user_id`);

--
-- Indexes for table `fund_invoices`
--
ALTER TABLE `fund_invoices`
  ADD PRIMARY KEY (`inv_id`),
  ADD KEY `fk_inv_usr` (`fund_from`),
  ADD KEY `fk_inv_usr2` (`user_id`),
  ADD KEY `fk_inv_stock` (`fund_to`);

--
-- Indexes for table `fund_type`
--
ALTER TABLE `fund_type`
  ADD PRIMARY KEY (`fund_type_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `hoadon`
--
ALTER TABLE `hoadon`
  ADD PRIMARY KEY (`id_hd`);

--
-- Indexes for table `imo_details`
--
ALTER TABLE `imo_details`
  ADD PRIMARY KEY (`imd_id`),
  ADD KEY `fk_imo_imd` (`imo_id`),
  ADD KEY `fk_imd_mms` (`smm_id`),
  ADD KEY `fk_imd_msp` (`msp_id`);

--
-- Indexes for table `instock_modify`
--
ALTER TABLE `instock_modify`
  ADD PRIMARY KEY (`imo_id`),
  ADD KEY `fk_imo_user` (`user_id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`inv_id`),
  ADD KEY `fk_inv_usr` (`user_id`),
  ADD KEY `fk_inv_sup` (`sup_id`),
  ADD KEY `fk_inv_usr2` (`created_user`),
  ADD KEY `fk_inv_stock` (`stock_id`);

--
-- Indexes for table `invoice_details`
--
ALTER TABLE `invoice_details`
  ADD PRIMARY KEY (`invd_id`),
  ADD KEY `fk_invd_inv` (`inv_id`),
  ADD KEY `fk_invd_mms` (`mms_id`),
  ADD KEY `fk_invd_smm` (`smm_id`);

--
-- Indexes for table `item_type`
--
ALTER TABLE `item_type`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `login_history`
--
ALTER TABLE `login_history`
  ADD PRIMARY KEY (`lhi_id`),
  ADD KEY `FK_session_user` (`user_id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `manufactures`
--
ALTER TABLE `manufactures`
  ADD PRIMARY KEY (`mfa_id`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`mat_id`),
  ADD KEY `FK_mat_cat` (`cat_id`);

--
-- Indexes for table `mat_move_invoices`
--
ALTER TABLE `mat_move_invoices`
  ADD PRIMARY KEY (`inv_id`),
  ADD KEY `fk_inv_usr` (`user_id`),
  ADD KEY `fk_inv_usr2` (`created_user`),
  ADD KEY `fk_inv_stock` (`stock_id`),
  ADD KEY `fk_mri_stock_to` (`stock_id_to`);

--
-- Indexes for table `mat_move_invoice_details`
--
ALTER TABLE `mat_move_invoice_details`
  ADD PRIMARY KEY (`invd_id`),
  ADD KEY `fk_invd_inv` (`inv_id`),
  ADD KEY `fk_invd_smm` (`smm_id`);

--
-- Indexes for table `mat_msu`
--
ALTER TABLE `mat_msu`
  ADD PRIMARY KEY (`mms_id`),
  ADD KEY `fk_mms_msu` (`msu_id`),
  ADD KEY `fk_mms_mat` (`mat_id`);

--
-- Indexes for table `mat_return_invoices`
--
ALTER TABLE `mat_return_invoices`
  ADD PRIMARY KEY (`inv_id`),
  ADD KEY `fk_inv_usr` (`user_id`),
  ADD KEY `fk_inv_sup` (`sup_id`),
  ADD KEY `fk_inv_usr2` (`created_user`),
  ADD KEY `fk_inv_stock` (`stock_id`),
  ADD KEY `fk_mri_cus` (`cus_id`),
  ADD KEY `fk_mri_stockemp` (`emp_stock_id`);

--
-- Indexes for table `mat_return_invoice_details`
--
ALTER TABLE `mat_return_invoice_details`
  ADD PRIMARY KEY (`invd_id`),
  ADD KEY `fk_invd_inv` (`inv_id`),
  ADD KEY `fk_invd_smm` (`smm_id`);

--
-- Indexes for table `mat_split`
--
ALTER TABLE `mat_split`
  ADD PRIMARY KEY (`msp_id`),
  ADD KEY `fk_msp_mms` (`smm_id`);

--
-- Indexes for table `mat_split_history`
--
ALTER TABLE `mat_split_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mat_split_history_details`
--
ALTER TABLE `mat_split_history_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meansure`
--
ALTER TABLE `meansure`
  ADD PRIMARY KEY (`msu_id`),
  ADD KEY `fk_msu_msu` (`msu_parid`);

--
-- Indexes for table `mfa_mat`
--
ALTER TABLE `mfa_mat`
  ADD PRIMARY KEY (`mma_id`),
  ADD KEY `fk_mma_mat` (`mat_id`),
  ADD KEY `fk_mma_mfa` (`mfa_id`);

--
-- Indexes for table `nhomhopdong`
--
ALTER TABLE `nhomhopdong`
  ADD PRIMARY KEY (`id_nhd`);

--
-- Indexes for table `out_invoices`
--
ALTER TABLE `out_invoices`
  ADD PRIMARY KEY (`inv_id`),
  ADD KEY `fk_inv_usr` (`user_id`),
  ADD KEY `fk_inv_cus` (`cus_id`),
  ADD KEY `fk_inv_usr2` (`created_user`),
  ADD KEY `stock_id` (`stock_id`);

--
-- Indexes for table `out_invoice_details`
--
ALTER TABLE `out_invoice_details`
  ADD PRIMARY KEY (`invd_id`),
  ADD KEY `fk_invd_inv` (`inv_id`),
  ADD KEY `fk_invd_mms` (`smm_id`);

--
-- Indexes for table `out_serials`
--
ALTER TABLE `out_serials`
  ADD PRIMARY KEY (`serial_id`),
  ADD KEY `fk_oseri_oinvd` (`invd_id`);

--
-- Indexes for table `phuphi`
--
ALTER TABLE `phuphi`
  ADD PRIMARY KEY (`pp_id`);

--
-- Indexes for table `serials`
--
ALTER TABLE `serials`
  ADD PRIMARY KEY (`serial_id`),
  ADD KEY `fk_seri_invd` (`invd_id`),
  ADD KEY `fk_seri_mms` (`mms_id`),
  ADD KEY `fk_seri_smm` (`smm_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `FK_session_user` (`user_id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`stock_id`),
  ADD KEY `fk_stock_usr` (`user_id`);

--
-- Indexes for table `stock_mat_msu`
--
ALTER TABLE `stock_mat_msu`
  ADD PRIMARY KEY (`smm_id`),
  ADD UNIQUE KEY `unique_smm` (`stock_id`,`mms_id`),
  ADD KEY `fk_smm_stock` (`stock_id`),
  ADD KEY `fk_smm_mms` (`mms_id`);

--
-- Indexes for table `supliers`
--
ALTER TABLE `supliers`
  ADD PRIMARY KEY (`sup_id`);

--
-- Indexes for table `sup_mat`
--
ALTER TABLE `sup_mat`
  ADD PRIMARY KEY (`sma_id`),
  ADD KEY `fk_sma_mat` (`mat_id`),
  ADD KEY `fk_sma_sup` (`sup_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `fk_usr_grp` (`group_id`),
  ADD KEY `fk_usr_dept` (`dept_id`);

--
-- Indexes for table `user_group_permission`
--
ALTER TABLE `user_group_permission`
  ADD PRIMARY KEY (`ugp_id`),
  ADD KEY `fk_ugp_usr` (`user_id`),
  ADD KEY `fk_ugp_grp` (`group_id`),
  ADD KEY `fk_ugp_fmenu` (`fmenu_id`);

--
-- Indexes for table `waranty_dept`
--
ALTER TABLE `waranty_dept`
  ADD PRIMARY KEY (`dept_id`);

--
-- Indexes for table `waranty_invoices`
--
ALTER TABLE `waranty_invoices`
  ADD PRIMARY KEY (`inv_id`),
  ADD KEY `fk_inv_usr` (`user_id`),
  ADD KEY `fk_inv_usr2` (`created_user`),
  ADD KEY `fk_inv_cus` (`cus_id`);

--
-- Indexes for table `waranty_invoice_details`
--
ALTER TABLE `waranty_invoice_details`
  ADD PRIMARY KEY (`invd_id`),
  ADD KEY `fk_winvd_winv` (`inv_id`),
  ADD KEY `fk_winvd_oinvd` (`oinvd_id`);

--
-- Indexes for table `waranty_materials`
--
ALTER TABLE `waranty_materials`
  ADD PRIMARY KEY (`wma_id`),
  ADD KEY `invd_id` (`invd_id`),
  ADD KEY `mat_id` (`mat_id`);

--
-- Indexes for table `waranty_services`
--
ALTER TABLE `waranty_services`
  ADD PRIMARY KEY (`wsv_id`),
  ADD KEY `invd_id` (`invd_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `budget_invoices`
--
ALTER TABLE `budget_invoices`
  MODIFY `bin_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `congno`
--
ALTER TABLE `congno`
  MODIFY `cn_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `cus_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dept`
--
ALTER TABLE `dept`
  MODIFY `dept_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `domains`
--
ALTER TABLE `domains`
  MODIFY `sdo_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `function_menu`
--
ALTER TABLE `function_menu`
  MODIFY `fmenu_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `fund`
--
ALTER TABLE `fund`
  MODIFY `fund_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `fund_invoices`
--
ALTER TABLE `fund_invoices`
  MODIFY `inv_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fund_type`
--
ALTER TABLE `fund_type`
  MODIFY `fund_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `group_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `hoadon`
--
ALTER TABLE `hoadon`
  MODIFY `id_hd` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `imo_details`
--
ALTER TABLE `imo_details`
  MODIFY `imd_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `instock_modify`
--
ALTER TABLE `instock_modify`
  MODIFY `imo_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `inv_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `invoice_details`
--
ALTER TABLE `invoice_details`
  MODIFY `invd_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `item_type`
--
ALTER TABLE `item_type`
  MODIFY `item_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `login_history`
--
ALTER TABLE `login_history`
  MODIFY `lhi_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=198;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `log_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=275;

--
-- AUTO_INCREMENT for table `manufactures`
--
ALTER TABLE `manufactures`
  MODIFY `mfa_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `mat_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=193;

--
-- AUTO_INCREMENT for table `mat_move_invoices`
--
ALTER TABLE `mat_move_invoices`
  MODIFY `inv_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mat_move_invoice_details`
--
ALTER TABLE `mat_move_invoice_details`
  MODIFY `invd_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mat_msu`
--
ALTER TABLE `mat_msu`
  MODIFY `mms_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=193;

--
-- AUTO_INCREMENT for table `mat_return_invoices`
--
ALTER TABLE `mat_return_invoices`
  MODIFY `inv_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mat_return_invoice_details`
--
ALTER TABLE `mat_return_invoice_details`
  MODIFY `invd_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mat_split`
--
ALTER TABLE `mat_split`
  MODIFY `msp_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mat_split_history`
--
ALTER TABLE `mat_split_history`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mat_split_history_details`
--
ALTER TABLE `mat_split_history_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meansure`
--
ALTER TABLE `meansure`
  MODIFY `msu_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `mfa_mat`
--
ALTER TABLE `mfa_mat`
  MODIFY `mma_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nhomhopdong`
--
ALTER TABLE `nhomhopdong`
  MODIFY `id_nhd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `out_invoices`
--
ALTER TABLE `out_invoices`
  MODIFY `inv_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `out_invoice_details`
--
ALTER TABLE `out_invoice_details`
  MODIFY `invd_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `out_serials`
--
ALTER TABLE `out_serials`
  MODIFY `serial_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phuphi`
--
ALTER TABLE `phuphi`
  MODIFY `pp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `serials`
--
ALTER TABLE `serials`
  MODIFY `serial_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `stock_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `stock_mat_msu`
--
ALTER TABLE `stock_mat_msu`
  MODIFY `smm_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200;

--
-- AUTO_INCREMENT for table `supliers`
--
ALTER TABLE `supliers`
  MODIFY `sup_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sup_mat`
--
ALTER TABLE `sup_mat`
  MODIFY `sma_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_group_permission`
--
ALTER TABLE `user_group_permission`
  MODIFY `ugp_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2844;

--
-- AUTO_INCREMENT for table `waranty_dept`
--
ALTER TABLE `waranty_dept`
  MODIFY `dept_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `waranty_invoices`
--
ALTER TABLE `waranty_invoices`
  MODIFY `inv_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `waranty_invoice_details`
--
ALTER TABLE `waranty_invoice_details`
  MODIFY `invd_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `waranty_materials`
--
ALTER TABLE `waranty_materials`
  MODIFY `wma_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `waranty_services`
--
ALTER TABLE `waranty_services`
  MODIFY `wsv_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

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
-- Constraints for table `mat_move_invoices`
--
ALTER TABLE `mat_move_invoices`
  ADD CONSTRAINT `mat_move_invoices_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mat_move_invoices_ibfk_2` FOREIGN KEY (`created_user`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mat_move_invoices_ibfk_3` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`stock_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mat_move_invoices_ibfk_4` FOREIGN KEY (`stock_id_to`) REFERENCES `stocks` (`stock_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mat_move_invoice_details`
--
ALTER TABLE `mat_move_invoice_details`
  ADD CONSTRAINT `mat_move_invoice_details_ibfk_1` FOREIGN KEY (`inv_id`) REFERENCES `mat_move_invoices` (`inv_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mat_move_invoice_details_ibfk_2` FOREIGN KEY (`smm_id`) REFERENCES `stock_mat_msu` (`smm_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
