<?php

namespace App\Http\Controllers;

use DB, Validator;
use Illuminate\Http\Request;
use App\Models\Proceso;
use PDF;

class ReportesController extends Controller
{
    //
    public function __construct()  
    {
        $this->middleware('auth');
    }

    public function getReporte()
    {
        $ruta = 'reportes';
        return view('modules.reportes',compact('ruta'));
    }

    public function getReportVistaPrevia(Request $request)
    {
        if (!$request->ajax()):
            return redirect('/reportes');
        endif;

        $rules = [
            'fdesde'=>'required|date',
            'fhasta' => 'required|date',
        ];

        $messages = [
            'fdesde.required' => 'La fecha Desde es requerida',
            'fdesde.date' => 'La fecha Desde debe ser en formato fecha',
            'fhasta.required' => 'La fecha Hasta es requerida',
            'fhasta.date' => 'La fecha Hasta debe ser en formato fecha',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):
            return response()->json(['errors'=>$validator->errors(), 'code' => '422']);
        else:
            if($request->fdesde > $request->fhasta):
                return response()->json(['errors'=>$validator->errors(), 'code' => '423']);
            else:

                $reporteData = Proceso::getReporteData($request->fdesde, $request->fhasta);
                return view('data.load_reportes_data', compact('reporteData'));

            endif;
        endif;
    }

   
    public function getReportPDF(Request $request)
    {
        ini_set('max_execution_time', 3600); // 3600 seconds = 60 minutes
        set_time_limit(3600);

        $reporteData = Proceso::getReporteData($request->fdesde, $request->fhasta);
        $pdf = PDF::loadView('pdf/reporte_recepcion_pdf', array('reporteData' =>  $reporteData))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('reporte_recepcion_pdf.pdf');
    }

}
