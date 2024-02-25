<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proceso;
use App\Models\Configuracion;
use PDF;

class PDFController extends Controller
{
    // Método para generar el PDF del comprobante
    public function getComprobantePDF(Request $request)
    {
        // Obtener el ID del proceso de la solicitud
        $valueProceso = $request->proceso_id;

        // Obtener los datos de la factura del proceso
        $dataFactura = Proceso::getDataFactura($valueProceso);

        // Obtener fechas de ingreso y salida
        $fechaIngreso = $dataFactura->fecha_entrada;
        $fechaSalida = $dataFactura->fecha_salida;

        // Extraer día, mes y año de la fecha de ingreso
        $diaIngreso = date('d', strtotime($fechaIngreso));
        $mesIngreso = date('m', strtotime($fechaIngreso));
        $mesIngresoEspañol = self::mesEspañol($mesIngreso);
        $añoIngreso = date('Y', strtotime($fechaIngreso));

        // Extraer día, mes y año de la fecha de salida
        $diaSalida = date('d', strtotime($fechaSalida));
        $mesSalida = date('m', strtotime($fechaSalida));
        $mesSalidaEspañol = self::mesEspañol($mesSalida);
        $añoSalida = date('Y', strtotime($fechaSalida));

        // Obtener configuración del hotel
        $nombreHotel = Configuracion::get_valorxvariable('nombre_hotel');
        $rucHotel = Configuracion::get_valorxvariable('ruc');
        $direccionHotel = Configuracion::get_valorxvariable('direccion_hotel');
        $telHotel = Configuracion::get_valorxvariable('telefono_hotel');
        $emailHotel = Configuracion::get_valorxvariable('email_hotel');

        // Generar el PDF utilizando la vista 'pdf/comprobante_pdf'
        $pdf = PDF::loadView('pdf/comprobante_pdf', array(
            'dataFactura' => $dataFactura,
            'diaIngreso' => $diaIngreso,
            'mesIngresoEspañol' => $mesIngresoEspañol,
            'añoIngreso' => $añoIngreso,
            'diaSalida' => $diaSalida,
            'mesSalidaEspañol' => $mesSalidaEspañol,
            'añoSalida' => $añoSalida,
            'nombreHotel' => $nombreHotel,
            'rucHotel' => $rucHotel,
            'direccionHotel' => $direccionHotel,
            'telHotel' => $telHotel,
            'emailHotel' => $emailHotel
        ))->setPaper('a4', 'portrait'); // Establecer tamaño del papel

        // Retornar el PDF para su visualización en el navegador
        return $pdf->stream('Comprobante.pdf');
    }

    // Método auxiliar para convertir el número de mes en español
    public function mesEspañol($mes)
    {
        $mesEspañol = '';
        switch ($mes) {
            case "01":
                $mesEspañol = "Enero";
                break;
            case "02":
                $mesEspañol = "Febrero";
                break;
            case "03":
                $mesEspañol = "Marzo";
                break;
            case "04":
                $mesEspañol = "Abril";
                break;
            case "05":
                $mesEspañol = "Mayo";
                break;
            case "06":
                $mesEspañol = "Junio";
                break;
            case "07":
                $mesEspañol = "Julio";
                break;
            case "08":
                $mesEspañol = "Agosto";
                break;
            case "09":
                $mesEspañol = "Setiembre";
                break;
            case "10":
                $mesEspañol = "Octubre";
                break;
            case "11":
                $mesEspañol = "Noviembre";
                break;
            case "12":
                $mesEspañol = "Diciembre";
                break;
        }
        return $mesEspañol;
    }
}
