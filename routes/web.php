<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Categorias\CategoriasController;
use App\Http\Controllers\Productos\ProductosController;
use App\Http\Controllers\Proveedores\ProveedorController;
use App\Http\Controllers\Descuentos\DescuentosController;
use App\Http\Controllers\UsuarioPrincipal\UsuarioController;
use App\Http\Controllers\Mascotas\MascotasController;
use App\Http\Controllers\ProductosVentas\ProductosVentasController;
use App\Http\Controllers\GestionSitioWeb\GestionSitioController;
use App\Http\Controllers\GestionSitioWeb\VistaPrincipalController;
use App\Http\Controllers\Productos\EspecificacionController;
use App\Http\Controllers\Contacto\ContactoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Contacto\ComentarioController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Descuentos\DescuentosInicioController;
use App\Http\Controllers\Ordenes\OrdenController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TestController;
use App\Mail\OrderDetailsMail;
use App\Models\Orden;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

// Ruta de bienvenida, accesible sin autenticación
Route::get('/', [ProductosVentasController::class, 'index'])->name('welcome');

Route::get('/send-mail', function () {
    $order = Orden::find(218); // Asegúrate de tener una orden con ID 1 o ajusta este ID a una orden válida
    Mail::to($order->user->email)->send(new OrderDetailsMail($order));
    return 'Correo enviado!';
});

Route::post('/payment/notification', [PaymentController::class, 'handlePaymentNotification'])->name('payment.notification');
Route::get('/payment/result', [PaymentController::class, 'handlePaymentResult'])->name('payment.result');
Route::get('/order/confirmation/{orderId}', [PaymentController::class, 'orderConfirmation'])->name('order.confirmation');
Route::get('/order/failed/{orderId}', [PaymentController::class, 'orderFailed'])->name('order.failed');
Route::get('/order/pending/{orderId}', [PaymentController::class, 'orderPending'])->name('order.pending');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/recalculate', [CheckoutController::class, 'recalculate'])->name('checkout.recalculate');
Route::post('/checkout/applyDiscount', [CheckoutController::class, 'applyDiscount'])->name('checkout.applyDiscount');
Route::post('/checkout/applyBirthdayDiscount', [CheckoutController::class, 'applyBirthdayDiscount'])->name('checkout.applyBirthdayDiscount');
Route::post('/checkout/create', [PaymentController::class, 'createTransaction'])->name('payment.create');

Route::get('/cargar-carrito', [CarritoController::class, 'cargarCarrito'])->name('cargar-carrito');
Route::post('/guardar-carrito', [CarritoController::class, 'guardarCarrito']);
Route::get('/checkout', [CarritoController::class, 'index']);
Route::post('/carrito/aplicar-descuento', [CarritoController::class, 'aplicarDescuento'])->name('carrito.aplicar-descuento');


Route::get('/descuentosProductos', [ProductosVentasController::class, 'index'])->name('descuentosProductos');
Route::get('/buscar-productos-por-categoria/{categoriaId}', [ProductosVentasController::class, 'buscarProductosPorCategoria'])->name('buscar.productos.categoria');

//Codigo Promocional

Route::post('/aplicar-codigo-promocional', [DescuentosController::class, 'aplicarCodigoPromocional'])->name('aplicar-codigo-promocional');
Route::post('/eliminar-codigo-promocional', [DescuentosController::class, 'eliminarCodigoPromocional'])->name('eliminar-codigo-promocional');

// Ruta para acceder a la vista de productos
Route::get('/productosVentas', function () {
    return view('productosprincipal.productos');
});
Route::get('/productosVentas/{categoria}', [ProductosVentasController::class, 'showProductsByCategory'])->name('productosVentas.categoria');
Route::get('/descuentos/buscar', [DescuentosInicioController::class, 'buscarProductos'])->name('descuentos.buscarProductos');


// Ruta para acceder a la vista de productos con datos proporcionados por ProductosVentasController
Route::get('/productosVentas', [ProductosVentasController::class, 'index'])->name('productosVentas.index');
Route::get('/productodetalle/{id}', [ProductosVentasController::class, 'show'])->name('productosVentas.show');
Route::get('/buscar-productos', [ProductosVentasController::class, 'buscarProductos'])->name('productos.buscar');
Route::get('/buscarProductosPorCategoria/{categoriaId}', [ProductosVentasController::class, 'buscarProductosPorCategoria'])->name('productos.buscarPorCategoria');
Route::get('/servicios/{id}', [GestionSitioController::class, 'verServicio'])->name('servicios.ver');
Route::get('/servicios', [GestionSitioController::class, 'mostrarServicios'])->name('servicios.index');

//Ver los comentarios de los usuarios
Route::post('productos/{producto}/comentarios', [ComentarioController::class, 'store'])->name('comentarios.store');

Route::get('/productodetalle', function () {
    return view('productosprincipal.productodetalle');
});
Route::get('/contacto', [ContactoController::class, 'showForm'])->name('contacto.show');
Route::post('/contacto', [ContactoController::class, 'sendContactForm'])->name('contacto.send');
// Rutas que requieren autenticación
Route::middleware('auth')->group(function () {
    Route::get('/perfiluser', [UsuarioController::class, 'perfilUsuarioComun'])->name('perfiluser');
    Route::put('/perfil/update', [UsuarioController::class, 'updatePerfil'])->name('perfil.update');
    Route::put('/perfil/change-password', [UsuarioController::class, 'changePassword'])->name('perfil.changePassword');
    Route::get('/mascotas', [MascotasController::class, 'index'])->name('mascotas.index');
    Route::get('/mascotas/crear', [MascotasController::class, 'create'])->name('mascotas.create');
    Route::post('/mascotas', [MascotasController::class, 'store'])->name('mascotas.store');
    Route::get('/mascotas/{id}/editar', [MascotasController::class, 'edit'])->name('mascotas.edit');
    Route::put('/mascotas/{id}', [MascotasController::class, 'update'])->name('mascotas.update');
    Route::delete('/mascotas/{id}', [MascotasController::class, 'destroy'])->name('mascotas.destroy');
});

// Rutas que requieren autenticación
Route::middleware('auth')->group(function () {
    Route::get('/inicio', [AuthController::class, 'inicio'])->name('inicio');
    Route::post('/logout', [AuthController::class, 'logout'])->name('inicio.logout');
    Route::put('/usuario/actualizar/{id}', [AuthController::class, 'actualizarUsuario'])->name('usuario.actualizar');

    // Rutas que requieren acceso común para múltiples roles
    Route::middleware('can:access-common-areas')->group(function () {
        Route::get('/perfil-usuario', [AuthController::class, 'perfilUsuario'])->name('inicio.perfilUsuario');
    });

    // Rutas que siguen siendo exclusivas para el administrador
    Route::middleware('can:admin-access')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // Rutas que solo son accesibles para usuarios con rol específico, como 'admin'
    Route::middleware(['verified', 'can:access-common-areas'])->group(function () {
        Route::get('/inicio', [DashboardController::class, 'index'])->name('dashboard.index');

        Route::post('/crear-usuario', [AuthController::class, 'crearUsuario'])->name('inicio.crearUsuario');
        Route::post('/inicio/actualizar-preferencias', [AuthController::class, 'actualizarPreferencias'])->name('inicio.actualizarPreferencias');
        Route::get('/inicio/cargar-preferencias-usuario/{userId}', [AuthController::class, 'cargarPreferenciasUsuario'])->name('inicio.cargarPreferenciasUsuario');
        Route::get('/inicio/obtener-preferencias/{user}', [AuthController::class, 'obtenerPreferencias'])->name('inicio.obtenerPreferencias');
        Route::delete('/usuario/eliminar/{id}', [AuthController::class, 'eliminar'])->name('usuario.eliminar');


        // Sección para los proveedores
// Sección para los proveedores
Route::resource('proveedores', ProveedorController::class);
Route::get('/proveedores', [ProveedorController::class, 'index'])->name('proveedores.indexProveedores');
        // Sección para los descuentos
        Route::resource('descuentos', DescuentosController::class);
        Route::get('/descuentos', [DescuentosController::class, 'index'])->name('descuentos.indexDescuentos');
        Route::get('/descuentos/detalles/{id}', [DescuentosController::class, 'detalles'])->name('descuentos.detalleDescuentos');
        Route::post('/descuentos/aplicar/{id}', [DescuentosController::class, 'aplicar'])->name('descuentos.aplicar');
        Route::get('/calcular-descuentos', [CheckoutController::class, 'calcularDescuentos'])->name('calcular-descuentos');
    
        // Sección para los productos
        Route::resource('productos', ProductosController::class);
        Route::post('productos/{id}/updateImage', [ProductosController::class, 'updateImage'])->name('productos.updateImage');

        Route::post('productos/{id}/especificaciones', [EspecificacionController::class, 'store'])->name('especificaciones.store');
        Route::delete('especificaciones/{id}', [EspecificacionController::class, 'destroy'])->name('especificaciones.destroy');
        
        // Rutas para detalles del producto
        Route::post('productos/{producto}/detalles', [EspecificacionController::class, 'storeDetalle'])->name('productos.detalles.store');
        Route::delete('productos/detalles/{id}', [EspecificacionController::class, 'destroyDetalle'])->name('productos.detalles.destroy');
        
        //Seccion para las categorias
        Route::resource('categorias', CategoriasController::class);
        Route::get('/categorias', [CategoriasController::class, 'index'])->name('categorias.indexCategorias');
        Route::get('/categorias/{categoria}/contenido', [CategoriasController::class, 'contenidoCategoria'])->name('categorias.contenido');
        // Ruta para filtrar productos por categoría

        // Ruta API para obtener productos por categoría
        Route::get('/api/categorias/{categoria}/productos', [CategoriasController::class, 'getProductosPorCategoria']);
        Route::get('/get-categorias', [CategoriasController::class, 'getCategorias'])->name('categorias.getCategorias');


        // Sección para las categorías
        Route::resource('categorias', CategoriasController::class);
        Route::get('/categorias', [CategoriasController::class, 'index'])->name('categorias.indexCategorias');
        Route::get('/categorias/{categoria}/contenido', [CategoriasController::class, 'contenidoCategoria'])->name('categorias.contenido');
        Route::put('categorias/{categoria}/update-image', [App\Http\Controllers\Categorias\CategoriasController::class, 'updateImage'])->name('categorias.updateImage');
        // Ruta API para obtener productos por categoría
        Route::get('/api/categorias/{categoria}/productos', [CategoriasController::class, 'getProductosPorCategoria']);
        Route::get('/get-categorias', [CategoriasController::class, 'getCategorias'])->name('categorias.getCategorias');

        // Ruta para la gestión del sitio web
        Route::get('/gestion-sitio', [GestionSitioController::class, 'index'])->name('inicio.gestionSitioWeb');
        Route::post('/gestion-sitio/agregar', [GestionSitioController::class, 'agregarContenido'])->name('gestionSitio.agregarContenido');
        Route::delete('/eliminar-contenido/{id}', [GestionSitioController::class, 'eliminarContenido'])->name('gestionSitio.eliminarContenido');
        Route::post('/update-header/{id}', [GestionSitioController::class, 'updateHeader'])->name('gestionSitio.updateHeader');
        Route::post('/gestionSitio/updateHeader/{id}', [GestionSitioController::class, 'updateHeader'])->name('gestionSitio.updateHeader');
Route::delete('/gestionSitio/eliminarHeader/{id}', [GestionSitioController::class, 'eliminarHeader'])->name('gestionSitio.eliminarHeader');

Route::get('/api/search-products', [GestionSitioController::class, 'searchProducts']);

Route::post('/gestion/actualizar-productos-destacados', [GestionSitioController::class, 'actualizarProductosDestacados'])->name('gestion.actualizarProductosDestacados');

        Route::get('/gestion/productos-destacados', [GestionSitioController::class, 'index'])->name('gestion.productosDestacados');
        Route::post('/gestion/productos-destacados/{id}', [GestionSitioController::class, 'actualizarProductoDestacado'])->name('gestion.actualizarProductoDestacado');
        Route::post('/gestion/actualizarProductosDestacados', [GestionSitioController::class, 'actualizarProductosDestacados'])->name('gestion.actualizarProductosDestacados');
        Route::get('/informacion/agregar-detallada/{id}', [GestionSitioController::class, 'crearInformacionDetallada'])->name('informacion.crearDetallada');
        Route::post('/informacion/guardar-detallada', [GestionSitioController::class, 'guardarInformacionDetallada'])->name('informacion.guardarDetallada');
        Route::post('/gestion-sitio/editar-contenido/{id}', [GestionSitioController::class, 'editarContenido'])->name('gestionSitio.editarContenido');

        Route::get('/informacion/agregar-detallada/{id}', [GestionSitioController::class, 'crearInformacionDetallada'])->name('informacion.crearDetallada');
        Route::post('/informacion/guardar-detallada', [GestionSitioController::class, 'guardarInformacionDetallada'])->name('informacion.guardarDetallada');
        Route::delete('/informacion/eliminar/{id}', [GestionSitioController::class, 'eliminarInformacion'])->name('informacion.eliminar');


        //Ruta para el contacto para admin
        Route::get('/admin/contactos', [ContactoController::class, 'index'])->name('admin.contactos');
        Route::delete('/admin/contactos/{id}', [ContactoController::class, 'destroy'])->name('contactos.destroy');
        Route::delete('/gestion/comentarios/{id}', [GestionSitioController::class, 'eliminarComentario'])->name('gestionSitio.eliminarComentario');
    
//Ruta para las ordenes vista por admin
Route::prefix('ventas')->group(function () {
    Route::resource('ordenes', OrdenController::class);
    Route::patch('ordenes/{id}/ready-for-pickup', [OrdenController::class, 'updateReadyForPickup'])->name('ordenes.readyForPickup');
    Route::patch('/ventas/ordenes/{orden}/update-tracking', [OrdenController::class, 'updateTracking'])->name('ordenes.updateTracking');
    Route::post('ordenes/{orden}/report-problem', [OrdenController::class, 'reportProblem'])->name('ordenes.reportProblem');
    Route::get('ordenes/{id}/problemas', [OrdenController::class, 'getProblemas'])->name('ordenes.getProblemas');
    Route::delete('problemas/{id}', [OrdenController::class, 'deleteProblema'])->name('problemas.delete');
    Route::patch('ordenes/{id}/retirado', [OrdenController::class, 'markAsRetirado'])->name('ordenes.markAsRetirado');
});

    });



    Route::patch('/user/password/update', [NewPasswordController::class, 'update'])->name('user.password.update')->middleware('auth');
});

Route::post('/carrito/aplicar-descuento-cumpleanos', [DescuentosController::class, 'aplicarDescuentoCumpleanos'])->name('carrito.aplicar-descuento-cumpleanos');
Route::get('/calcular-descuentos', [DescuentosController::class, 'calcularTotalConDescuentos'])->name('calcular-descuentos');


require __DIR__ . '/auth.php';
