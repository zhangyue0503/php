<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/3/1
 * Time: 下午10:08
 */

require_once "fpdf181/fpdf.php";
$pdf = new FPDF();
$pdf->addPage();

$pdf->setFont("Arial",'B',16);
$pdf->cell(40,10,"Hello Out There!");

$pdf->output();