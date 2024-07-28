<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebpayController;
use App\Http\Controllers\WebpayRespuestaController;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\PaypalCaptureController;
use App\Http\Controllers\PaypalCanceladoController;
use App\Http\Controllers\MercadoPagoController;
use App\Http\Controllers\MercadoPagoRespuestaController;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\CategoriasSlugController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\Productos2Controller;
use App\Http\Controllers\ProductosBuscarController;
use App\Http\Controllers\ProductosFotosController;
use App\Http\Controllers\AccesoController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\AnotacionesController;
use App\Http\Controllers\ClasificadosCategoriaController;
use App\Http\Controllers\ClasificadosAvisosController;
use App\Http\Controllers\ClasificadosAvisosPorCategoriaController;
use App\Http\Controllers\ClasificadosContactoController;
use App\Http\Controllers\ClasificadosAvisosSearchController;
use App\Http\Controllers\ClasificadosAvisosUpdateController;
use App\Http\Controllers\ClasificadosAvisosComentariosController;
use App\Http\Controllers\ProveedoresController;
use App\Http\Controllers\GastosPorDiaController;
use App\Http\Middleware\Verificacion;


Route::resource('proveedores', ProveedoresController::class)->middleware(Verificacion::class);
Route::resource('gastos-por-dia', GastosPorDiaController::class);


Route::resource('webpay', WebpayController::class);
Route::resource('webpay-respuesta', WebpayRespuestaController::class);
Route::resource('paypal', PaypalController::class);
Route::resource('paypal-capture', PaypalCaptureController::class);
Route::resource('paypal-cancelar', PaypalCanceladoController::class);
Route::resource('mercado-pago', MercadoPagoController::class);
Route::resource('mercado-pago-respuesta', MercadoPagoRespuestaController::class);

Route::resource('categorias', CategoriasController::class)->middleware(Verificacion::class);
Route::resource('categorias-slug', CategoriasSlugController::class)->middleware(Verificacion::class);

Route::resource('productos', ProductosController::class)->middleware(Verificacion::class);
Route::resource('productos-loadmore', Productos2Controller::class)->middleware(Verificacion::class);
Route::resource('productos-buscar', ProductosBuscarController::class)->middleware(Verificacion::class);

Route::resource('productos-fotos', ProductosFotosController::class)->middleware(Verificacion::class);
Route::resource('login', AccesoController::class);
Route::resource('registro', RegistroController::class);


Route::resource('anotaciones', AnotacionesController::class);

Route::resource('clasificados-categorias', ClasificadosCategoriaController::class);
Route::resource('clasificados-avisos', ClasificadosAvisosController::class);
Route::resource('clasificados-avisos-categoria', ClasificadosAvisosPorCategoriaController::class);
Route::resource('clasificados-contacto', ClasificadosContactoController::class);
Route::resource('clasificados-avisos-search', ClasificadosAvisosSearchController::class);
Route::resource('clasificados-avisos-update', ClasificadosAvisosUpdateController::class);
Route::resource('mis-datos', MisDatosController::class);
Route::resource('clasificados-avisos-comentarios', ClasificadosAvisosComentariosController::class);




Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
