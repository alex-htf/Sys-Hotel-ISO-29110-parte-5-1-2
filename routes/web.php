<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\TarifaController;
use App\Http\Controllers\HabitacionController;
use App\Http\Controllers\TarifaHabitacionController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RecepcionController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\UbicacionController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\ReportesController;

use App\Http\Controllers\PaisesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('login',[LoginController::class, 'getLogin'])->name('login');
Route::post('login', [LoginController::class, 'postLogin'])->name('login');
Route::get('logout', [LoginController::class, 'getLogout'])->name('logout');

Route::get('/', [HomeController::class, 'getDashboard'])->name('dashboard');
Route::resource('categorias', CategoriaController::class);
Route::post('categorias/activar/{id}', [CategoriaController::class, 'activar']);
Route::post('categorias/desactivar/{id}',  [CategoriaController::class, 'desactivar']);

Route::resource('ubicaciones', UbicacionController::class);
Route::post('ubicaciones/activar/{id}', [UbicacionController::class, 'activar']);
Route::post('ubicaciones/desactivar/{id}',  [UbicacionController::class, 'desactivar']);

Route::resource('habitaciones', HabitacionController::class);
Route::post('habitaciones/ocupado/{id}', [HabitacionController::class, 'ocupado']);
Route::post('habitaciones/disponible/{id}',  [HabitacionController::class, 'disponible']);
Route::get('habitacionInfo/{id}', [HabitacionController::class, 'habitacionInfo']);

Route::get('habitaciondetails/{id}', [HabitacionController::class, 'habitaciondetails']);

Route::resource('usuarios', UsuarioController::class);
Route::post('usuarios/activar/{id}', [UsuarioController::class, 'activar']);
Route::post('usuarios/desactivar/{id}',  [UsuarioController::class, 'desactivar']);

Route::get('recepcion',[RecepcionController::class, 'getRecepcion'])->name('recepciones');
Route::post('recepcion',[RecepcionController::class, 'store'])->name('store');
Route::get('recepcion_proceso/{id}',[RecepcionController::class, 'getRecepcionProceso'])->name('recepcion_proceso');
Route::get('proceso_salida/{id}',[RecepcionController::class, 'getProcesoSalida'])->name('proceso_salida');
Route::post('recepcion/generar_comprobante',[RecepcionController::class, 'generarComprobante'])->name('generar_comprobante');
Route::get('recepcion/comprobante/{proceso_id}',[RecepcionController::class, 'postComprobante'])->name('comprobante');

Route::get('recepcion/comprobantepdf/{proceso_id}', [PDFController::class, 'getComprobantePDF'])->name('comprobante_pdf');

Route::get('recepcion/historial',[RecepcionController::class, 'getListHistorial'])->name('historial_recepcion');

Route::get('search_cliente/', [ClienteController::class, 'getClienteInfo']);
Route::get('clientes/', [ClienteController::class, 'lisClient']);
Route::get('clientes/{id}', [ClienteController::class, 'getClientefind']);

Route::post('updatecliente/{id}', [ClienteController::class, 'udpateClient']);

Route::get('configuraciones', [ConfiguracionController::class, 'getDataConfiguracion']);
Route::post('configuraciones', [ConfiguracionController::class, 'storeconfiguraciones']);

Route::get('reportes', [ReportesController::class, 'getReporte']);
Route::get('reportes/vista_previa', [ReportesController::class, 'getReportVistaPrevia']);
Route::get('reportes/reportePDF', [ReportesController::class, 'getReportPDF'])->name('reportePDF');

Route::any('{catchall}', [HomeController::class, 'get404NotFound'])->where('catchall', '.*');



