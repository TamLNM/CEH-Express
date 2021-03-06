<?php
if (!defined('IN_CB')) { die('You are not allowed to access to this page.'); }

define('VERSION', '5.0.1');

if (version_compare(phpversion(), '5.0.0', '>=') !== true) {
    exit('Sorry, but you have to run this script with PHP5... You currently have the version <b>' . phpversion() . '</b>.');
}

if (!function_exists('imagecreate')) {
    exit('Sorry, make sure you have the GD extension installed before running this script.');
}

include_once('function.php');

// FileName & Extension
$system_temp_array = explode('/', $_SERVER['PHP_SELF']);
$system_temp_array2 = explode('.', $system_temp_array[count($system_temp_array) - 1]);
$filename = $system_temp_array2[0];
$types = array('codabar' => 'Codabar', 'code11' => 'Code 11', 'code39' => 'Code 39', 'code39extended' => 'Code 39 Extended', 'code93' => 'Code 93', 'code128' => 'Code 128', 'ean8' => 'EAN-8', 'ean13' => 'EAN-13', 'gs1128' => 'GS1-128 (EAN-128)', 'isbn' => 'ISBN-10 / ISBN-13', 'i25' => 'Interleaved 2 of 5', 's25' => 'Standard 2 of 5', 'msi' => 'MSI Plessey', 'upca' => 'UPC-A', 'upce' => 'UPC-E', 'upcext2' => 'UPC Extension 2 Digits', 'upcext5' => 'UPC Extension 5 Digits', 'postnet' => 'PostNet', 'intelligentmail' => 'Intelligent Mail', 'othercode' => 'Other Barcode');

?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $types[$filename]; ?> - Barcode Generator</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link type="text/css" rel="stylesheet" href="style.css" />
        <link rel="shortcut icon" href="favicon.ico" />
        <script src="jquery-1.7.2.min.js"></script>
        <script src="barcode.js"></script>
        <link href="<?=base_url('assets/vendors/dataTables/datatables.min.css');?>" rel="stylesheet" />
        <link href="<?=base_url('assets/vendors/dataTables/jquery.dataTables.min.css');?>" rel="stylesheet" />
        <link href="<?=base_url('assets/vendors/dataTables/scroller.dataTables.min.css');?>" rel="stylesheet" />
        <link href="<?=base_url('assets/css/custom.datatables.css');?>" rel="stylesheet" />
        <script src="<?=base_url('assets/js/datatables.ext.js');?>"></script>
        <script src="<?=base_url('assets/vendors/dataTables/dataTables.scroller.min.js');?>"></script>

        <!--    TABLES SCROLL-->
        <script src="<?=base_url('assets/vendors/dataTables/dataTables.scroller.min.js');?>"></script>
        <script type="text/javascript" src="<?=base_url('assets/vendors/dataTables/extensions/key_table.min.js');?>"></script>
        <script type="text/javascript" src="<?=base_url('assets/vendors/dataTables/extensions/mindmup-editabletable.js');?>"></script>
        <script type="text/javascript" src="<?=base_url('assets/vendors/dataTables/extensions/numeric-input-example.js');?>"></script>
        <script type="text/javascript" src="<?=base_url('assets/vendors/dataTables/extensions/autofill.min.js');?>"></script>
        <script type="text/javascript" src="<?=base_url('assets/vendors/dataTables/extensions/scroller.min.js');?>"></script>
        <script type="text/javascript" src="<?=base_url('assets/vendors/dataTables/extensions/select.min.js');?>"></script>
        <script type="text/javascript" src="<?=base_url('assets/vendors/dataTables/extensions/buttons.min.js');?>"></script>

        <!-- Ro2.js -->
        <script src="<?=base_url('assets/js/ro2.js');?>"></script>
    </head>
    <body class="<?php echo $filename; ?>">

<?php
$default_value = array();
$default_value['filetype'] = 'PNG';
$default_value['dpi'] = 72;
$default_value['thickness'] = 30;
$default_value['scale'] = 1;
$default_value['rotation'] = 0;
$default_value['font_family'] = 'Arial.ttf';
$default_value['font_size'] = 8;
$default_value['text'] = '';
$default_value['a1'] = '';
$default_value['a2'] = '';
$default_value['a3'] = '';

$filetype = isset($_POST['filetype']) ? $_POST['filetype'] : $default_value['filetype'];
$dpi = isset($_POST['dpi']) ? $_POST['dpi'] : $default_value['dpi'];
$thickness = intval(isset($_POST['thickness']) ? $_POST['thickness'] : $default_value['thickness']);
$scale = intval(isset($_POST['scale']) ? $_POST['scale'] : $default_value['scale']);
$rotation = intval(isset($_POST['rotation']) ? $_POST['rotation'] : $default_value['rotation']);
$font_family = isset($_POST['font_family']) ? $_POST['font_family'] : $default_value['font_family'];
$font_size = intval(isset($_POST['font_size']) ? $_POST['font_size'] : $default_value['font_size']);
$text = isset($_POST['text']) ? $_POST['text'] : $default_value['text'];

registerImageKey('filetype', $filetype);
registerImageKey('dpi', $dpi);
registerImageKey('thickness', $thickness);
registerImageKey('scale', $scale);
registerImageKey('rotation', $rotation);
registerImageKey('font_family', $font_family);
registerImageKey('font_size', $font_size);
registerImageKey('text', $text);
?>

<div class="header">
    <header>
        <img class="logo" src="logo.png" alt="Barcode Generator" />
        <nav>
            <label for="type">Symbology</label>
            <?php echo getSelectHtml('type', $filename, $types); ?>
            <a class="info explanation" href="javascript:void()"><img src="info.gif" alt="Explanation" /></a>
        </nav>
    </header>
</div>

<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
    <h1>Barcode Generator</h1>
    <h2><?php echo $types[$filename]; ?></h2>
    <div class="configurations">
        <section class="configurations">
            <h3>Configurations</h3>
            <table>
                <colgroup>
                    <col class="col1" />
                    <col class="col2" />
                </colgroup>
                <tbody>
                    <tr>
                        <td><label for="filetype">File type</label></td>
                        <td><?php echo getSelectHtml('filetype', $filetype, array('PNG' => 'PNG - Portable Network Graphics', 'JPEG' => 'JPEG - Joint Photographic Experts Group', 'GIF' => 'GIF - Graphics Interchange Format')); ?></td>
                    </tr>
                    <tr>
                        <td><label for="dpi">DPI</label></td>
                        <td><?php echo getInputTextHtml('dpi', $dpi, array('type' => 'number', 'min' => 72, 'required' => 'required')); ?> <span id="dpiUnavailable">DPI is available only for PNG and JPEG.</span></td>
                    </tr>
                    <tr>
                        <td><label for="thickness">Thickness</label></td>
                        <td><?php echo getInputTextHtml('thickness', $thickness, array('type' => 'number', 'min' => 20, 'max' => 90, 'step' => 5, 'required' => 'required')); ?></td>
                    </tr>
                    <tr>
                        <td><label for="scale">Scale</label></td>
                        <td><?php echo getInputTextHtml('scale', $scale, array('type' => 'number', 'min' => 1, 'max' => 3, 'required' => 'required')); ?></td>
                    </tr>
                    <tr>
                        <td><label for="rotation">Rotation</label></td>
                        <td><?php echo getSelectHtml('rotation', $rotation, array(0 => 'No rotation', 90 => '90&deg; clockwise', 180 => '180&deg; clockwise', 270 => '270&deg; clockwise')); ?></td>
                    </tr>
                    <tr>
                        <td><label for="font_family">Font</label></td>
                        <td><?php echo getSelectHtml('font_family', $font_family, listfonts('../class')); ?> <?php echo getInputTextHtml('font_size', $font_size, array('type' => 'number', 'min' => 1, 'max' => 30)); ?></td>
                    </tr>
                    <tr>
                        <td><label for="text">Data</label></td>
                        <td>
                            <div class="generate" style="float: left"><?php echo getInputTextHtml('text', $text, array('type' => 'text', 'required' => 'required')); ?> <input type="submit" value="Generate" /></div>
                            <div class="possiblechars" style="float: right; position: relative;"><a href="javascript:void()" class="info characters"><img src="info.gif" alt="Help" /></a></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>
    </div>