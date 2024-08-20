<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MpesaController;
use App\Http\Controllers\applicationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [BookController::class, 'welcome'])->name('welcome');


Route::get('/add-book', [BookController::class, 'create'])->name('book.create');
Route::post('/add-book', [BookController::class, 'store'])->name('book.store')->middleware('auth');

Route::get('/books/{id}', [BookController::class, 'book'])->name('book');

Route::get('/cart', [BookController::class, 'cart'])->name('cart');

//Route::get('/cart/add/{id}', [BookController::class, 'addToCart'])->name('cart.add')->middleware('auth');
// routes/web.php

Route::get('/cart/modal', [BookController::class, 'showCart'])->name('cart.modal');

Route::post('/cart/add', [BookController::class, 'addTo'])->name('add.cart');

Route::post('/remove-cart-item', [BookController::class, 'removeCartItem'])->name('remove.cart.item');

Route::get('/cart/add/{id}', [BookController::class, 'addToCart'])->name('cart.add');

//Route::post('/transaction/new/{cart_total}/{user_id}', [MpesaController::class, 'stkSimulation'])->name('book.pay')->middleware('auth');
Route::post('/transaction/new/{bookId}/{bookPrice}', [MpesaController::class, 'stkSimulation'])->name('book.pay');

Route::post('/check-payment', [MpesaController::class, 'checkPayment'])->name('check-payment');
Route::post('/process-payment', [MpesaController::class, 'processPayment'])->name('process.payment');


Route::get('/getItems/{category}', [applicationController::class, 'getItemsCategory'])->name('itemCategory');


Route::get('/transactions', [BookController::class, 'transactions'])->name('transactions')->middleware('auth');
Route::get('/payments', [BookController::class, 'payments'])->name('payments');
Route::get('/downloads', [BookController::class, 'download'])->name('download')->middleware(['auth','download']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/admin', function () {
    return view('dashboard');
})->middleware('auth');


Route::get('/confirmation', function () {
    return view('books.confirmation');
});


Route::get('/download', function () {
    return view('books.download');
});


Route::get('/admin/{any?}', function () {
    return view('dashboard');
});

//->where('any', '.*')->middleware('auth');
