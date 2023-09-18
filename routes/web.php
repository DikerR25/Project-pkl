<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ManageController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardsController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PageController;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Http\Request;
use PDFMake\Pdf;


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
Route::get('/login', function () {
    return view('login',[
        "title" => "Login"
    ]);
});

Route::get('/about', function () {
    return view('about',[
        "title" => "About"
    ]);
});

Route::get('/support', function () {
    return view('support',[
        "title" => "Support"
    ]);
});

//login
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::get('/login-proses', [LoginController::class, 'login_proses'])->name('login-proses');

//logout
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

//register
Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::get('/register-proses', [LoginController::class, 'register_proses'])->name('register-proses');



//forgot Password
Route::get('/forgot-password', function () {
    return view('auth.password.forgot-password');
})->middleware('guest')->name('password.request');

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.password.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:6|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        }
    );



    return $status === Password::PASSWORD_RESET
        ? redirect()->route('login')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');
// Route::get('/forgot-password',[ForgotPasswordManager::class, 'forgotPassword'])->name('forgot.password');
// Route::get('/reset-password/{token}',[ForgotPasswordManager::class, 'resetPassword'])->name('reset.password');
// Route::post('/forgot-password',[ForgotPasswordManager::class, 'forgotPasswordPost'])->name('forgot.password.post');
// Route::post('/reset-password', [ForgotPasswordManager::class,'resetPasswordPost'])->name("reset.password.post");

Route::get('/profile', function () {
    return view('profile', [
        "title" => "Profile"
    ]);
})->middleware('isLogin');
// Route::get('edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::get('update{id}', [ProfileController::class, 'update'])->name('profile.update');

//dashboard
Route::get('/', [DashboardsController::class, 'index'])->middleware('isLogin')->name('dashboard');
Route::get('/dashboard', [DashboardsController::class, 'index'])->middleware('isLogin')->name('dashboard');


Route::group(['middleware' => ['isLogin', 'ceklevel:admin,user']], function () {
    //pages get
    Route::get('/pages/stock-barang', [PageController::class, 'stockB'])->name('stockB');
    Route::get('/pages/penjualan', [PageController::class, 'penjualanM'])->name('penjualanM');
    Route::get('/pages/{id}/edit-data-menu', [PageController::class, 'edit'])->name('editdatamenu');
    Route::get('/pages/stock-barang/{id}', [PageController::class, 'delete'])->name('deletedatamenu');
    Route::get('/pages/laba_rugi', [PageController::class, 'labarugi']);
    Route::get('/pages/laba_rugi/view/{tanggal}', [PageController::class, 'viewlabarugi'])->name('viewlabarugi');
    Route::get('/pages/pembelian-bahan', [PageController::class, 'pengeluaran'])->name('PengeluaranB');
    Route::get('/account/{name}/', [PageController::class, 'show'])->name('showprofileM');
    Route::post('/atur-target', [PageController::class, 'aturtarget'])->name('aturtarget');
    Route::get('/pages/users', [PageController::class, 'users'])->name('usersM');
    Route::get('pages/manage', [PageController::class, 'settings'])->name('settingsM');
    Route::get('/account/myprofile', [PageController::class, 'showMy']);

    //pages post
    Route::post('/save_changes', [PageController::class, 'saveChanges'])->name('saveChanges');
    // Route::post('/save_changes', [ProductController::class,'saveChanges'])->name('saveChanges');
    Route::post('/simpan/pengeluaran', [PageController::class, 'pengeluaranT'])->name('pengeluaranT');
    Route::post('/pages/{id}/edit-data-menu', [PageController::class, 'update'])->name('updatedatamenu');
    Route::post('/pages/insert-data-menu', [PageController::class, 'simpandatamenu'])->name('simpandatamenu');
});