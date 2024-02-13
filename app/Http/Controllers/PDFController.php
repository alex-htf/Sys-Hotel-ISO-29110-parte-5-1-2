<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proceso;
use App\Models\Configuracion;
use PDF;

class PDFController extends Controller
{
    //
    public function getComprobantePDF(Request $request)
    {
        $valueProceso = $request->proceso_id;

        $dataFactura = Proceso::getDataFactura($valueProceso);

        $fechaIngreso = $dataFactura->fecha_entrada;
        $fechaSalida = $dataFactura->fecha_salida;

        $diaIngreso = date('d', strtotime($fechaIngreso));
        $mesIngreso = date('m', strtotime($fechaIngreso));
        $mesIngresoEspañol = self::mesEspañol($mesIngreso);
        $añoIngreso = date('Y', strtotime($fechaIngreso));
        $diaSalida = date('d', strtotime($fechaSalida));
        $mesSalida = date('m', strtotime($fechaSalida));
        $mesSalidaEspañol = self::mesEspañol($mesSalida);
        $añoSalida = date('Y', strtotime($fechaSalida));

        $nombreHotel =  Configuracion::get_valorxvariable('nombre_hotel');
        $rucHotel =  Configuracion::get_valorxvariable('ruc');
        $direccionHotel =  Configuracion::get_valorxvariable('direccion_hotel');
        $telHotel =  Configuracion::get_valorxvariable('telefono_hotel');
        $emailHotel =  Configuracion::get_valorxvariable('email_hotel');
        $iva =  Configuracion::get_valorxvariable('iva');


        $pdf = PDF::loadView('pdf/comprobante_pdf', array('dataFactura' =>  $dataFactura, 'diaIngreso' => $diaIngreso, 'mesIngresoEspañol' => $mesIngresoEspañol,
                                                        'añoIngreso' => $añoIngreso, 'diaSalida' => $diaSalida, 'mesSalidaEspañol' => $mesSalidaEspañol, 'añoSalida' => $añoSalida,
                                                    'nombreHotel' => $nombreHotel, 'rucHotel' => $rucHotel, 'direccionHotel' => $direccionHotel, 'telHotel' => $telHotel, 'emailHotel' => $emailHotel,
                                                    'iva' => $iva))
        ->setPaper('a4', 'portrait');
     
        return $pdf->stream('Comprobante.pdf');
    }

    public function mesEspañol($mes)
    {
        $mesEspañol = ''; 
        switch($mes)
        {   
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
