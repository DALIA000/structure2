<?php

use App\Http\Controllers\Dashboard\AboutUsController;
use App\Http\Controllers\Dashboard\AvailabilityController;
use App\Http\Controllers\Dashboard\BlogController;
use App\Http\Controllers\Dashboard\FAQController;
use App\Http\Controllers\Dashboard\FormController;
use App\Http\Controllers\Dashboard\HeaderController;
use App\Http\Controllers\Dashboard\FormImageController;
use App\Http\Controllers\Dashboard\ListFormController;
use App\Http\Controllers\Dashboard\OverviewController;
use App\Http\Controllers\Dashboard\QuizController;
use App\Http\Controllers\Dashboard\RoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\AdminAuthController;
use App\Http\Controllers\Dashboard\AgentController;
use App\Http\Controllers\Dashboard\AmenitiesController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\CommunityController;
use App\Http\Controllers\Dashboard\DeveloperController;
use App\Http\Controllers\Dashboard\PermissionController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\RentalPeriodController;
use App\Http\Controllers\Dashboard\ServiceController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\SliderController;
use App\Http\Controllers\Dashboard\TypeController;
use App\Http\Controllers\Dashboard\StatisticsController;


Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::post('/resetPassword', [AdminAuthController::class, 'resetPassword']);
    Route::post('/confirmPinCode', [AdminAuthController::class, 'confirmPinCode']);
    Route::post('/confirmPassword', [AdminAuthController::class, 'confirmPassword']);
});

Route::group(['middleware' => 'auth:admin'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('logout', [AdminAuthController::class, 'logout']);
        Route::patch('update', [AdminAuthController::class, 'update']);
        Route::get("profile", [AdminAuthController::class, 'profile']);
    });

    Route::prefix('admin')->middleware(['permission:admin'])->group(function () {
        Route::get('', [AdminController::class, 'admins']);
        Route::get('/{id}', [AdminController::class, 'admin']);
        Route::post('', [AdminController::class, 'create'])->middleware(['permission:admin.create']);
        Route::patch('/{id}', [AdminController::class, 'update'])->middleware(['permission:admin.edit']);
        Route::delete('/{id}', [AdminController::class, 'delete'])->middleware(['permission:admin.delete']);
    });

    Route::prefix('role')->middleware(['permission:role'])->group(function () {
        Route::get('', [RoleController::class, 'roles']);
        Route::get('/{id}', [RoleController::class, 'role']);
        Route::post('', [RoleController::class, 'create'])->middleware(['permission:role.create']);
        Route::patch('/{id}', [RoleController::class, 'edit'])->middleware(['permission:role.edit']);
        Route::delete('/{id}', [RoleController::class, 'delete'])->middleware(['permission:role.delete']);
    });

    Route::group(['prefix' => 'permission'], function () {
        Route::get('', [PermissionController::class, 'Permissions']);
        Route::get('/{id}', [PermissionController::class, 'Permission']);
    });

    Route::prefix('category')->middleware(['permission:category'])->group(function () {
        Route::get('', [CategoryController::class, 'models']);
        Route::get('/{id}', [CategoryController::class, 'find']);
        Route::patch('/{id}', [CategoryController::class, 'update'])->middleware(['permission:category.edit']);
    });

    Route::prefix('type')->middleware(['permission:type'])->group(function () {
        Route::get('', [TypeController::class, 'models']);
        Route::get('/{id}', [TypeController::class, 'find']);
        Route::post('', [TypeController::class, 'create'])->middleware(['permission:type.create']);
        Route::patch('/{id}', [TypeController::class, 'update'])->middleware(['permission:type.edit']);
        Route::delete('/{id}', [TypeController::class, 'delete'])->middleware(['permission:type.delete']);
    });

    Route::prefix('community')->middleware(['permission:community'])->group(function () {
        Route::get('', [CommunityController::class, 'models']);
        Route::get('/{id}', [CommunityController::class, 'find']);
        Route::post('', [CommunityController::class, 'create'])->middleware(['permission:community.create']);
        Route::patch('/{id}', [CommunityController::class, 'update'])->middleware(['permission:community.edit']);
        Route::delete('/{id}', [CommunityController::class, 'delete'])->middleware(['permission:community.delete']);
    });

    Route::prefix('amenities')->middleware(['permission:amenities'])->group(function () {
        Route::get('', [AmenitiesController::class, 'models']);
        Route::get('/{id}', [AmenitiesController::class, 'find']);
        Route::post('', [AmenitiesController::class, 'create'])->middleware(['permission:amenities.create']);
        Route::patch('/{id}', [AmenitiesController::class, 'update'])->middleware(['permission:amenities.edit']);
        Route::delete('/{id}', [AmenitiesController::class, 'delete'])->middleware(['permission:amenities.delete']);
    });

    Route::prefix('service')->middleware(['permission:service'])->group(function () {
        Route::get('', [ServiceController::class, 'models']);
        Route::get('/{id}', [ServiceController::class, 'find']);
        Route::post('', [ServiceController::class, 'create'])->middleware(['permission:service.create']);
        Route::patch('/{id}', [ServiceController::class, 'update'])->middleware(['permission:service.edit']);
        Route::delete('/{id}', [ServiceController::class, 'delete'])->middleware(['permission:service.delete']);
    });

    Route::prefix('agent')->middleware(['permission:agent'])->group(function () {
        Route::get('', [AgentController::class, 'models']);
        Route::get('/{id}', [AgentController::class, 'find']);
        Route::post('', [AgentController::class, 'create'])->middleware(['permission:agent.create']);
        Route::patch('/{id}', [AgentController::class, 'update'])->middleware(['permission:agent.edit']);
        Route::delete('/{id}', [AgentController::class, 'delete'])->middleware(['permission:agent.delete']);
    });

    Route::prefix('developer')->middleware(['permission:developer'])->group(function () {
        Route::get('', [DeveloperController::class, 'models']);
        Route::get('/{id}', [DeveloperController::class, 'find']);
        Route::post('', [DeveloperController::class, 'create'])->middleware(['permission:developer.create']);
        Route::patch('/{id}', [DeveloperController::class, 'update'])->middleware(['permission:developer.edit']);
        Route::delete('/{id}', [DeveloperController::class, 'delete'])->middleware(['permission:developer.delete']);
    });

    Route::prefix('product')->middleware(['permission:product'])->group(function () {
        Route::get('', [ProductController::class, 'models']);
        Route::get('/{id}', [ProductController::class, 'find'])->where('id', '[0-9]+');
        Route::post('', [ProductController::class, 'create'])->middleware(['permission:product.create']);
        Route::patch('/{id}', [ProductController::class, 'update'])->where('id', '[0-9]+')->middleware(['permission:product.edit']);
        Route::delete('/{id}', [ProductController::class, 'delete'])->where('id', '[0-9]+')->middleware(['permission:product.delete']);
    });

    Route::prefix('productform')->middleware(['permission:productform'])->group(function () {
    Route::get('/', [ProductController::class, 'forms']); // Use 'index' for getting all records
    Route::get('{id}', [ProductController::class, 'form'])->where('id', '[0-9]+'); // Use 'show' for a single record
    Route::patch('read/{id}', [ProductController::class, 'read'])->where('id', '[0-9]+')->middleware(['permission:productform.edit']);
    Route::patch('unread/{id}', [ProductController::class, 'unread'])->where('id', '[0-9]+')->middleware(['permission:productform.edit']);
    Route::delete('{id}', [ProductController::class, 'deleteform'])->where('id', '[0-9]+')->middleware(['permission:productform.delete']);
});

    Route::prefix('period')->middleware(['permission:rental'])->group(function () {
        Route::get('', [RentalPeriodController::class, 'models']);
        Route::get('/{id}', [RentalPeriodController::class, 'find']);
        Route::post('', [RentalPeriodController::class, 'create'])->middleware(['permission:rental.create']);
        Route::delete('/{id}', [RentalPeriodController::class, 'delete'])->middleware(['permission:rental.edit']);
    });

    Route::prefix('slider')->middleware(['permission:home'])->group(function () {
        Route::get('', [SliderController::class, 'model']);
        Route::patch('', [SliderController::class, 'update'])->middleware(['permission:home.edit']);
    });

    Route::prefix('setting')->middleware(['permission:home'])->group(function () {
        Route::get('social', [SettingController::class, 'social']);
        Route::patch('social', [SettingController::class, 'update_contacts'])->middleware(['permission:home.edit']);
        Route::get('terms', [SettingController::class, 'terms']);
        Route::patch('terms', [SettingController::class, 'update_terms'])->middleware(['permission:home.edit']);
        Route::get('privacy', [SettingController::class, 'privacy']);
        Route::patch('privacy', [SettingController::class, 'update_privacy'])->middleware(['permission:home.edit']);
        Route::get('currency', [SettingController::class, 'currency']);
        Route::patch('currency', [SettingController::class, 'update_currency'])->middleware(['permission:home.edit']);
        Route::get('about', [SettingController::class, 'about']);
        Route::patch('about', [SettingController::class, 'update_about'])->middleware(['permission:home.edit']);
        Route::get('brochure', [SettingController::class, 'brochure']);
        Route::patch('brochure', [SettingController::class, 'update_brochure'])->middleware(['permission:home.edit']);
        Route::get('statistics_title', [SettingController::class, 'statistics_title']);
        Route::patch('statistics_title', [SettingController::class, 'update_statistics_title'])->middleware(['permission:home.edit']);
        Route::get('table_title', [SettingController::class, 'table_title']);
        Route::patch('table_title', [SettingController::class, 'update_table_title'])->middleware(['permission:home.edit']);
    });

    Route::prefix('statistics')->middleware(['permission:statistics'])->group(function () {
        Route::patch('header', [StatisticsController::class, 'update_header'])->middleware(['permission:statistics.edit']);
        Route::get('', [StatisticsController::class, 'models']);
        Route::get('header', [StatisticsController::class, 'header']);
        Route::get('card', [StatisticsController::class, 'cards']);
        Route::post('', [StatisticsController::class, 'create'])->middleware(['permission:statistics.create']);
        Route::get('{id}', [StatisticsController::class, 'find']);
        Route::patch('/{id}', [StatisticsController::class, 'update'])->middleware(['permission:statistics.edit']);
        Route::delete('/{id}', [StatisticsController::class, 'delete'])->middleware(['permission:statistics.delete']);
        Route::get('card/{id}', [StatisticsController::class, 'card']);
        Route::patch('card/{id}', [StatisticsController::class, 'update_card'])->middleware(['permission:statistics.edit']);
    });

    Route::prefix('faq')->middleware(['permission:faq'])->group(function () {
        Route::get('', [FAQController::class, 'models']);
        Route::get('/{id}', [FAQController::class, 'find']);
        Route::post('', [FAQController::class, 'create'])->middleware(['permission:faq.create']);
        Route::post('/{id}', [FAQController::class, 'update'])->middleware(['permission:faq.edit']);
        Route::delete('/{id}', [FAQController::class, 'delete'])->middleware(['permission:faq.delete']);
    });

    Route::prefix('blog')->middleware(['permission:blog'])->group(function () {
        Route::get('', [BlogController::class, 'models']);
        Route::get('/{id}', [BlogController::class, 'find']);
        Route::post('', [BlogController::class, 'create'])->middleware(['permission:blog.create']);
        Route::post('/{id}', [BlogController::class, 'update'])->middleware(['permission:blog.edit']);
        Route::delete('/{id}', [BlogController::class, 'delete'])->middleware(['permission:blog.delete']);
    });

    Route::prefix('availability')->middleware(['permission:availability'])->group(function () {
        Route::get('', [AvailabilityController::class, 'models']);
        Route::get('/{id}', [AvailabilityController::class, 'find']);
        Route::post('', [AvailabilityController::class, 'create'])->middleware(['permission:availability.create']);
        Route::delete('/{id}', [AvailabilityController::class, 'delete'])->middleware(['permission:availability.delete']);
    });

    Route::prefix('form')->middleware(['permission:form'])->group(function () {
        Route::get('', [FormController::class, 'models']);
        // Route::post('changeStatus/{id}', [FormController::class, 'changeStatus']);
        Route::post('read/{id}', [FormController::class, 'read'])->middleware(['permission:form.read']);
        Route::post('unread/{id}', [FormController::class, 'unread'])->middleware(['permission:form.un_read']);
        Route::delete('/{id}', [FormController::class, 'delete'])->middleware(['permission:form.delete']);
    });

    Route::prefix('quiz')->middleware(['permission:quiz'])->group(function () {
        Route::get('', [QuizController::class, 'models']);
        Route::get('/{id}', [QuizController::class, 'find']);
        // Route::post('changeStatus/{id}', [QuizController::class, 'changeStatus']);
        Route::post('read/{id}', [QuizController::class, 'read'])->middleware(['permission:quiz.read']);
        Route::post('unread/{id}', [QuizController::class, 'unread'])->middleware(['permission:quiz.un_read']);
        Route::delete('/{id}', [QuizController::class, 'delete'])->middleware(['permission:quiz.delete']);
    });

    Route::prefix('add_list')->middleware(['permission:add_list'])->group(function () {
        Route::get('', [ListFormController::class, 'models']);
        Route::get('/{id}', [ListFormController::class, 'find']);
        // Route::post('changeStatus/{id}', [ListFormController::class, 'changeStatus']);
        Route::post('read/{id}', [ListFormController::class, 'read'])->middleware(['permission:add_list.read']);
        Route::post('unread/{id}', [ListFormController::class, 'unread'])->middleware(['permission:add_list.un_read']);
        Route::delete('/{id}', [ListFormController::class, 'delete'])->middleware(['permission:add_list.delete']);
    });

    Route::prefix('overview')->group(function () {
        Route::get('', [OverviewController::class, 'overview']);
    });

    Route::prefix('header')->group(function () {
        Route::get('', [HeaderController::class, 'models']);
        Route::get('/{id}', [HeaderController::class, 'find']);
        Route::post('', [HeaderController::class, 'create']);
        Route::post('/{id}', [HeaderController::class, 'update']);
        Route::delete('/{id}', [HeaderController::class, 'delete']);
    });

    Route::prefix('about_us')->group(function () {
        Route::get('about', [AboutUsController::class, 'about']);
        Route::get('why', [AboutUsController::class, 'why']);
        Route::get('benefits', [AboutUsController::class, 'benefits']);
        Route::patch('about', [AboutUsController::class, 'updateAboutUs']);
        Route::patch('why', [AboutUsController::class, 'updateWhyUs']);
        Route::patch('benefits', [AboutUsController::class, 'updateBenefits']);
    });

    Route::prefix('formImage')->group(function () {
        Route::get('expert', [FormImageController::class, 'expert']);
        Route::patch('expert', [FormImageController::class, 'updateExpert']);
        Route::get('list', [FormImageController::class, 'list']);
        Route::patch('list', [FormImageController::class, 'updateList']);
    });
});
