<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

/* ADMIN ROUTE */

Route::get('/', function () {
    return view('User_List_Page');
});

Route::get('/contactdetails', function () {
    return view('Contact_Details');
});

// Route::get('/dashboard', function () {
//     return view('Dashboard');
// });


/*  */
