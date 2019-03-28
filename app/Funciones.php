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
use Illuminate\Database\QueryException;

class Funciones
{
    public static function GenerarArchivoExcel(Request $request)
    {
        $data = $request->input('table_data');
        $nombre_archivo = $request->input('NombreArchivo');
        $archivo = "";
        try {
            $styleArray = [
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ];
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $header = array_keys($data[0]);
            $columns = ['B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
            $ultima_fila = "";
            $sheet->setTitle($nombre_archivo);
            for ($i = 0; $i < count($header); $i++) {
                $sheet->setCellValue($columns[$i] . '3', ucwords($header[$i]))->getColumnDimension($columns[$i])->setAutoSize(true);
                $valor = $columns[$i] . '3';
                $sheet->getStyle($valor)->applyFromArray($styleArray);
                $sheet->getStyle($valor)->getAlignment()->setHorizontal('center');
                $sheet->getStyle($valor)->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('7F7F7F');
                $ultima_fila = $columns[$i];
            }
            $fila = 4;
            for ($x = 0; $x < count($data); $x++) {
                for ($i = 0; $i < count($header); $i++) {
                    $sheet->setCellValue($columns[$i] . $fila, $data[$x][$header[$i]]);
                    $valor = $columns[$i] . $fila;
                    $sheet->getStyle($valor)->applyFromArray($styleArray);
                    $sheet->getStyle($valor)->getAlignment()->setHorizontal('center');
                }
                $fila++;
            }
            $sheet->mergeCells('B2:' . $ultima_fila . '2')->setCellValue('B2', $nombre_archivo);//->getColumnDimension('B1')->setAutoSize(true);
            $sheet->getStyle('B2:' . $ultima_fila . '2')->applyFromArray($styleArray);
            $sheet->getStyle('B2')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('B2')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('BFBFBF');
            $archivo = "Reportes/" . $nombre_archivo . '_' . time() . '.xlsx';
            $writer = new Xlsx($spreadsheet);
            $writer->save($archivo);
        } catch (QueryException $ex) {
            $ex->errorInfo();
        }

        return $archivo;
    }
}

