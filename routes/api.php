<?php

use App\Http\Controllers\Website\AboutUsController;
use App\Http\Controllers\Website\HeaderController;
use App\Http\Controllers\Website\FormImageController;
use App\Http\Controllers\Website\SliderController;
use App\Http\Controllers\Website\AvailabilityController;
use App\Http\Controllers\Website\BlogController;
use App\Http\Controllers\Website\FAQController;
use App\Http\Controllers\Website\FormController;
use App\Http\Controllers\Website\ListFormController;
use App\Http\Controllers\Website\QuizController;
use App\Http\Controllers\Website\TypeController;
use App\Http\Controllers\Website\CategoryController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\Website\AgentController;
use App\Http\Controllers\Website\AmenitiesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Website\CommunityController;
use App\Http\Controllers\Website\DeveloperController;
use App\Http\Controllers\Website\ProductController;
use App\Http\Controllers\Website\RentalPeriodController;
use App\Http\Controllers\Website\ServiceController;
use App\Http\Controllers\Website\SettingController;
use App\Http\Controllers\Website\StatisticsController;

Route::prefix('media')->group(function () {
    route::post('', [MediaController::class, 'upload']);
    route::post('media', [MediaController::class, 'upload_medias']);
});

Route::prefix('category')->group(function () {
    Route::get('', [CategoryController::class, 'models']);
    Route::get('/{slug}', [CategoryController::class, 'find']);
});

Route::prefix('period')->group(function () {
    Route::get('', [RentalPeriodController::class, 'models']);
    Route::get('/{id}', [RentalPeriodController::class, 'find']);
});

Route::prefix('type')->group(function () {
    Route::get('', [TypeController::class, 'models']);
    Route::get('/{slug}', [TypeController::class, 'find']);
});

Route::prefix('community')->group(function () {
    Route::get('', [CommunityController::class, 'models']);
    Route::get('/{slug}', [CommunityController::class, 'find']);
});

Route::prefix('amenities')->group(function () {
    Route::get('', [AmenitiesController::class, 'models']);
    Route::get('/{id}', [AmenitiesController::class, 'find']);
});

Route::prefix('service')->group(function () {
    Route::get('', [ServiceController::class, 'models']);
    Route::get('/{slug}', [ServiceController::class, 'find']);
});

Route::prefix('agent')->group(function () {
    Route::get('', [AgentController::class, 'models']);
    Route::get('/{slug}', [AgentController::class, 'find']);
    Route::post('addClick/{slug}', [AgentController::class, 'addClick']);
});

Route::prefix('developer')->group(function () {
    Route::get('', [DeveloperController::class, 'models']);
    Route::get('/{slug}', [DeveloperController::class, 'find']);
});

Route::prefix('product')->group(function () {
    Route::get('', [ProductController::class, 'models']);
    Route::get('/{slug}', [ProductController::class, 'find']);
    Route::post('/form', [ProductController::class, 'form']);
});

Route::prefix('setting')->group(function () {
    Route::get('social', [SettingController::class, 'social']);
    Route::get('terms', [SettingController::class, 'terms']);
    Route::get('privacy', [SettingController::class, 'privacy']);
    Route::get('currency', [SettingController::class, 'currency']);
    Route::get('about', [SettingController::class, 'about']);
    Route::get('brochure', [SettingController::class, 'brochure']);
    Route::get('statistics_title', [SettingController::class, 'statistics_title']);
    Route::get('table_title', [SettingController::class, 'table_title']);
});

Route::prefix('statistics')->group(function () {
    Route::get('', [StatisticsController::class, 'models']);
    Route::post('', [StatisticsController::class, 'create']);
    Route::get('header', [StatisticsController::class, 'header']);
    Route::get('card', [StatisticsController::class, 'cards']);
    Route::get('card/{id}', [StatisticsController::class, 'card']);
});

Route::prefix('slider')->group(function () {
    Route::get('', [SliderController::class, 'model']);
});

Route::prefix('faq')->group(function () {
    Route::get('', [FAQController::class, 'models']);
});

Route::prefix('blog')->group(function () {
    Route::get('', [BlogController::class, 'models']);
    Route::get('/{slug}', [BlogController::class, 'find']);
    Route::post('addView/{slug}', [BlogController::class, 'addView']);
    // Route::post('like/{slug}', [BlogController::class, 'like']);
    // Route::post('unlike/{slug}', [BlogController::class, 'unlike']);
});

Route::prefix('form')->group(function () {
    Route::post('contact', [FormController::class, 'contact']);
    Route::post('interest', [FormController::class, 'interest']);
    Route::post('service', [FormController::class, 'service']);
    Route::post('expert', [FormController::class, 'expert']);
    Route::post('brochure', [FormController::class, 'brochure']);
    Route::post('list', [ListFormController::class, 'create']);
});

Route::prefix('quiz')->group(function () {
    Route::post('', [QuizController::class, 'create']);
});

Route::prefix('availability')->group(function () {
    Route::get('', [AvailabilityController::class, 'models']);
});

Route::prefix('header')->group(function () {
    Route::get('', [HeaderController::class, 'models']);
});

Route::prefix('about_us')->group(function () {
    Route::get('about', [AboutUsController::class, 'about']);
    Route::get('why', [AboutUsController::class, 'why']);
    Route::get('benefits', [AboutUsController::class, 'benefits']);
});

Route::prefix('formImage')->group(function () {
    Route::get('expert', [FormImageController::class, 'expert']);
    Route::get('list', [FormImageController::class, 'list']);
});

Route::prefix('whatsapp')->group(function () {
    Route::post('click', [AgentController::class, 'addWhatsappClick']);
});
