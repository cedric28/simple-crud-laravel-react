<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    if (Auth::user()) return redirect()->route('home');

    return view('auth.login');
});

Auth::routes(['register' => false, 'reset' => false, 'confirm' => false]);

Route::middleware('auth')->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('companies', 'Company\CompanyController');
    Route::post('companies/{id}/restore', 'Company\CompanyController@restore');
    Route::delete('companies/{id}/archived', 'Company\CompanyController@destroy');
    Route::get('/companies/fetch/q', 'Company\CompanyFetchController@getCompanies')->name('company.fetch');
    Route::get('findCompany', 'Company\CompanyFetchController@search');


    Route::resource('employees', 'Employee\EmployeeController');
    Route::get('/employees/fetch/q', 'Employee\EmployeeFetchController@getEmployees')->name('employee.fetch');
    Route::get('/employees/inactive/fetch/q', 'Employee\EmployeeFetchController@getInactiveEmployees')->name('employee_inactive.fetch');
    Route::post('employees/{id}/restore', 'Employee\EmployeeController@restore');
    Route::delete('employees/{id}/archived', 'Employee\EmployeeController@destroy');
    Route::get('findEmployee', 'Employee\EmployeeFetchController@search');
});
