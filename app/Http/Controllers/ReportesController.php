<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Proceso;
use PDF;

class ReportesController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Método para mostrar la vista del formulario de reportes
    public function getReporte()
    {
        // Ruta para la vista
        $ruta = 'reportes';
        return view('modules.reportes', compact('ruta'));
    }

    // Método para obtener y mostrar la vista previa del reporte
    public function getReportVistaPrevia(Request $request)
    {
        // Validación de la petición Ajax
        if (!$request->ajax()) {
            return redirect('/reportes');
        }
        // Reglas de validación
        $rules = [
            'fdesde' => 'required|date|before_or_equal:today',
            'fhasta' => 'required|date|before_or_equal:today',
        ];
        // Mensajes de error personalizados
        $messages = [
            'fdesde.required' => 'La fecha Desde es requerida',
            'fdesde.date' => 'La fecha Desde debe ser en formato fecha',
            'fhasta.required' => 'La fecha Hasta es requerida',
            'fhasta.date' => 'La fecha Hasta debe ser en formato fecha',
        ];
        // Validación de la solicitud
        $validator = Validator::make($request->all(), $rules, $messages);
        // Manejo de errores de validación
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'code' => '422']);
        } else {
            // Validación de rango de fechas
            if ($request->fdesde > $request->fhasta) {
                return response()->json(['errors' => $validator->errors(), 'code' => '423']);
            } else {
                // Obtener datos del reporte según las fechas proporcionadas
                $reporteData = Proceso::getReporteData($request->fdesde, $request->fhasta);
                // Retornar vista previa del reporte
                return view('data.load_reportes_data', compact('reporteData'));
            }
        }
    }

    // Método para generar y mostrar el reporte en formato PDF
    public function getReportPDF(Request $request)
    {
        // Ajustes de tiempo de ejecución para la generación de PDF
        ini_set('max_execution_time', 3600); // 3600 seconds = 60 minutes
        set_time_limit(3600);

        // Obtener datos del reporte según las fechas proporcionadas
        $reporteData = Proceso::getReporteData($request->fdesde, $request->fhasta);
        // Cargar la vista del reporte en formato PDF
        $pdf = PDF::loadView('pdf/reporte_recepcion_pdf', array('reporteData' => $reporteData))
            ->setPaper('a4', 'landscape');

        // Mostrar el PDF en el navegador
        return $pdf->stream('reporte_recepcion_pdf.pdf');
    }
}
