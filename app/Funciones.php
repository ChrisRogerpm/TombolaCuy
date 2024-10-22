<?php
/**
 * Created by PhpStorm.
 * User: Software3000
 * Date: 22/02/2019
 * Time: 17:40
 */

namespace App;

use App\Mail\NotificarAlerta;
use Illuminate\Http\Request;
use Mail;
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

    public static function GenerarArchivoExcelJackpot(Request $request)
    {

        $data = $request->input('table_data');
        $nombre_archivo = $request->input('NombreArchivo');

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
            $columns = ['B', 'C', 'D', 'E', 'F', 'G', 'H'];

            $ultima_fila = "";

            $sheet->setTitle($nombre_archivo);

            $sheet->mergeCells('B2:H2')->setCellValue('B2', $nombre_archivo);
            $sheet->getStyle('B2:H2')->applyFromArray($styleArray);
            $sheet->getStyle('B2')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('B2')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('BFBFBF');

            $sheet->mergeCells('B3:E3')->setCellValue('B3', 'POZO');
            $sheet->getStyle('B3:E3')->applyFromArray($styleArray);
            $sheet->getStyle('B3')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('B3')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('CDEAF6');

            $sheet->mergeCells('F3:H3')->setCellValue('F3', 'POZO OCULTO');
            $sheet->getStyle('F3:H3')->applyFromArray($styleArray);
            $sheet->getStyle('F3')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('F3')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('B5E0F2');

            $header = ["Tiendas", "Incremento", 'Limite Inferior', 'Limite Superior', 'Incremento Oculto', 'Limite Inferior Oculto', 'Limite Superior Oculto'];
            $fila = 5;

            for ($i = 0; $i < count($header); $i++) {
                $sheet->setCellValue($columns[$i] . '4', ucwords($header[$i]))->getColumnDimension($columns[$i])->setAutoSize(true);
                $valor = $columns[$i] . '4';
                $sheet->getStyle($valor)->applyFromArray($styleArray);
                $sheet->getStyle($valor)->getAlignment()->setHorizontal('center');
                $sheet->getStyle($valor)->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('BFBFBF');
            }

            for ($x = 0; $x < count($data); $x++) {
                for ($i = 0; $i < count($columns); $i++) {
                    $sheet->setCellValue($columns[$i] . $fila, $data[$x][$i]);
                    $valor = $columns[$i] . $fila;
                    $sheet->getStyle($valor)->applyFromArray($styleArray);
                    $sheet->getStyle($valor)->getAlignment()->setHorizontal('center');
                }
                $fila++;
            }


            $archivo = "Reportes/" . $nombre_archivo . '_' . time() . '.xlsx';
            $writer = new Xlsx($spreadsheet);
            $writer->save($archivo);
        } catch (QueryException $ex) {
            $ex->errorInfo();
        }

        return $archivo;
    }

    public static function EnviarEmailAlerta($IdPuntoVenta, $MontoPuntoVenta)
    {
        $resultado = false;
        $PuntoVenta = PuntoVenta::PuntoVentaInfo($IdPuntoVenta);
        $ConfiguracionPuntoVentaTipoAlerta = PuntoVentaTipoAlerta::where('idPuntoVenta', $IdPuntoVenta)->first();
        if ($ConfiguracionPuntoVentaTipoAlerta != null) {
            $HistorialAlerta = HistorialAlerta::HistorialAlertaVerificarEmail($ConfiguracionPuntoVentaTipoAlerta->idPuntoVentaTipoAlerta);
            if ($HistorialAlerta == null) {
                //enviar correo
                $correos_destinatario = DetallePuntoVentaTipoAlerta::DetallePuntoVentaTipoAlertaObtenerId($ConfiguracionPuntoVentaTipoAlerta->idPuntoVentaTipoAlerta);
                if ($correos_destinatario->correoDestino != "") {
                    $correos = explode(",", $correos_destinatario->correoDestino);
                    foreach ($correos as $correo) {
                        $data = array(
                            'PuntoVenta' => $PuntoVenta->nombre,
                            'MontoPuntoVenta' => $MontoPuntoVenta,
                            'MontoConfiguracionAlerta' => $ConfiguracionPuntoVentaTipoAlerta->monto,
                            'body' => $ConfiguracionPuntoVentaTipoAlerta->mensaje,
                        );
                        $asunto = $ConfiguracionPuntoVentaTipoAlerta->asunto;
                        $correo_receptor = $correo;
                        Mail::to($correo_receptor)->send(new NotificarAlerta($data, $asunto));
                    }
                    $resultado = true;
                    if ($resultado){
                        $obj = new \stdClass();
                        $obj->idPuntoVentaTipoAlerta = $ConfiguracionPuntoVentaTipoAlerta->idPuntoVentaTipoAlerta;
                        $obj->fechaAlerta = now();
                        $obj->monto = $MontoPuntoVenta;
                        $obj->correos_envio = $correos_destinatario->correoDestino;
                        $obj->estado_envio = 1;
                        $obj->asunto = $ConfiguracionPuntoVentaTipoAlerta->asunto;
                        $obj->mensaje = $ConfiguracionPuntoVentaTipoAlerta->mensaje;
                        HistorialAlerta::HistorialAlertaRegistrar($obj);
                    }
                }
            }
        }
        return $resultado;
    }
}

