<?php

namespace lib;

class Pdf
{
    public static function getPdfTemplate($vars = [])
    {
        extract($vars);
        ob_start();
        require_once(ROOT . '/views/pdf/result.php');
        $content = ob_get_clean();

        return $content;
    }

    public static function createPdf($vars)
    {
        try {
            $mpdf = new \Mpdf\Mpdf();
            $mpdf->charset_in = 'utf-8';

            $stylesheet = 'table {font: 14px Verdana; text-align: center;}';

            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->list_indent_first_level = 0;

            //$mpdf->WriteHTML($html, 2);
            $mpdf->WriteHTML($vars);
            $mpdf->Output(ROOT . '/public/pdf_results/result_' . $_SESSION['auth_username'] . '.pdf', '');
        } catch (\Mpdf\MpdfException $e) {
            echo $e->getMessage();
        }
    }
}
