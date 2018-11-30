<?php
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'image', 'middleware' => [config()->get('media.middleware')]], function (){
    Route::get('create', '\ThaiLe\Media\Controllers\MediaController@create')->name('image.create');
    Route::post('store', '\ThaiLe\Media\Controllers\MediaController@store')->name('image.store');
    Route::post('delete/{id?}', '\ThaiLe\Media\Controllers\MediaController@destroy')->name('image.destroy');
    Route::get('show', '\ThaiLe\Media\Controllers\MediaController@show')->name('image.show');
    Route::get('index', '\ThaiLe\Media\Controllers\MediaController@index')->name('image.index');
});
