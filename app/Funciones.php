<?php
/**
 * Created by PhpStorm.
 * User: Software3000
 * Date: 22/02/2019
 * Time: 17:40
 */

namespace App;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Funciones
{
    public static function GenerarArchivoExcel(Request $request)
    {
        $data = $request->input('data_table');
        $nombre_archivo = $request->input('NombreArchivo');
        $archivo = "";
        try {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $header = array_keys($data[0]->toArray());
            $columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
            for ($i = 0; $i < count($header); $i++) {
                $sheet->setCellValue($columns[$i] . '1', $header[$i])->getColumnDimension($columns[$i])->setAutoSize(true);
            }
            $add = 2;
            for ($x = 0; $x < count($data); $x++) {
                for ($i = 0; $i < count($header); $i++) {
                    $sheet->setCellValue($columns[$i] . $add, $data[$x][$header[$i]]);
                }
                $add++;
            }
            $archivo = "assets/" . $nombre_archivo . '_' . time() . '.xlsx';
            $writer = new Xlsx($spreadsheet);
            $writer->save($archivo);
        } catch (\Exception $ex) {
            $ex->getMessage();
        }

        return $archivo;
    }
}