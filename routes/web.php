<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('/api/customers', 'CustomerController@search');
Route::get('/api/products', 'ProductController@search');

Route::resource('/api/invoices', 'InvoiceController');
