<?php

use App\Livewire\Auth\Login;
use App\Livewire\Admin\Roles;
use App\Livewire\Pages\Staff;
use App\Livewire\Auth\Register;
use App\Livewire\Layouts\Index;
use App\Livewire\Pages\Reports;
use App\Livewire\Pages\Invoices;
use App\Livewire\Admin\Permissions;
use App\Livewire\Admin\UserRole;
use App\Livewire\Pages\Clas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Livewire\InvoiceSystem\Installment;
use App\Livewire\InvoiceSystem\FeeStructure;
use App\Livewire\InvoiceSystem\AdminInstallments;
use App\Livewire\Pages\Sectiones;
use App\Livewire\Pages\Semesters;
use App\Livewire\Pages\Sessiones;
use App\Livewire\Pages\Students;
use App\Livewire\Pages\Voucheres;

use App\Livewire\ClassMembers;
use App\Models\Student;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::group(['middleware' => 'auth'], function () {
  Route::get('/', Index::class);
  Route::get('/Sessions', Sessiones::class)->name('sessions');
  Route::get('/Semesters', Semesters::class)->name('semesters');
  Route::get('/Class', Clas::class)->name('class');
  Route::get('/Section', Sectiones::class)->name('section');
  Route::get('/Students', Students::class)->name('students');
  Route::get('/feestructure', FeeStructure::class)->name('feestructure');
  Route::get('/installments/{feeStructureId}', Installment::class)->name('installments.show');
  Route::get('/installments', AdminInstallments::class)->name('installments');
  Route::get('/invoices', Invoices::class)->name('invoices');
  Route::get('/reports', Reports::class)->name('reports');
  Route::get('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();

    return redirect('/login');
  })->name('logout');

  Route::get('/class-members/{semester}/{section}', ClassMembers::class)->name('class-members');

  Route::get('/roles', Roles::class)->name('roles.index');
  Route::get('/permissions', Permissions::class)->name('permissions.index');
  Route::get('/assign', UserRole::class)->name('assignRole');
  Route::get('/voucher', Voucheres::class)->name('voucher');
});
// auth 

// Route::get('/login', function () {
//   return view('livewire.auth.login');
// });
Route::get('/login', Login::class)->name('login');
Route::get('/register', Register::class)->name('register');
