<?php

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

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'as' => 'admin.'], function () {

    Route::get('/', function (){
        return redirect()->route('admin.auth.login');
    });

    /*authentication*/
    Route::group(['namespace' => 'Auth', 'prefix' => 'auth', 'as' => 'auth.'], function () {
        Route::get('login', 'LoginController@login')->name('login');
        Route::post('login', 'LoginController@submit');
        Route::get('logout', 'LoginController@logout')->name('logout');
    });

    /*authenticated*/
    Route::group(['middleware' => ['admin']], function () {
        Route::get('dashboard', 'SystemController@dashboard')->name('dashboard');
        Route::get('search-function', 'SystemController@search_function')->name('search-function');

        Route::group(['prefix' => 'custom-role', 'as' => 'custom-role.', 'middleware' => ['module:custom_role']], function () {
            Route::get('create', 'CustomRoleController@create')->name('create');
            Route::post('create', 'CustomRoleController@store');
            Route::get('update/{id}', 'CustomRoleController@edit')->name('update');
            Route::post('update/{id}', 'CustomRoleController@update');
        });

        Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
            Route::get('view', 'ProfileController@view')->name('view');
            Route::get('update/{id}', 'ProfileController@edit')->name('update');
            Route::post('update/{id}', 'ProfileController@update');
            Route::post('settings-password', 'ProfileController@settings_password_update')->name('settings-password');
        });

        Route::group(['prefix' => 'withdraw', 'as' => 'withdraw.'], function () {
            Route::post('update/{id}', 'WithdrawController@update')->name('update');
            Route::post('request', 'WithdrawController@w_request')->name('request');
        });

        Route::group(['prefix' => 'deal', 'as' => 'deal.', 'middleware' => ['module:deal']], function () {
            Route::get('flash', 'DealController@flash_index')->name('flash');
            Route::post('flash', 'DealController@flash_submit');

            // feature deal
            Route::get('feature', 'DealController@feature_index')->name('feature');

            Route::get('day', 'DealController@deal_of_day')->name('day');
            Route::post('day', 'DealController@deal_of_day_submit');
            Route::post('day-status-update', 'DealController@day_status_update')->name('day-status-update');

            Route::get('day-update/{id}', 'DealController@day_edit')->name('day-update');
            Route::post('day-update/{id}', 'DealController@day_update');
            Route::get('day-delete/{id}', 'DealController@day_delete')->name('day-delete');

            Route::get('update/{id}', 'DealController@edit')->name('update');
            Route::get('edit/{id}', 'DealController@feature_edit')->name('edit');

            Route::post('update/{id}', 'DealController@update')->name('update');
            Route::post('status-update', 'DealController@status_update')->name('status-update');
            Route::post('feature-status', 'DealController@feature_status')->name('feature-status');

            Route::post('featured-update', 'DealController@featured_update')->name('featured-update');
            Route::get('add-product/{deal_id}', 'DealController@add_product')->name('add-product');
            Route::post('add-product/{deal_id}', 'DealController@add_product_submit');
            Route::get('delete-product/{deal_product_id}', 'DealController@delete_product')->name('delete-product');
        });

        Route::group(['prefix' => 'employee', 'as' => 'employee.', 'middleware' => ['module:employee']], function () {
            Route::get('add-new', 'EmployeeController@add_new')->name('add-new');
            Route::post('add-new', 'EmployeeController@store');
            Route::get('list', 'EmployeeController@list')->name('list');
            Route::get('update/{id}', 'EmployeeController@edit')->name('update');
            Route::post('update/{id}', 'EmployeeController@update');
        });

        Route::group(['prefix' => 'category', 'as' => 'category.', 'middleware' => ['module:category']], function () {
            Route::get('view', 'CategoryController@index')->name('view');
            Route::get('fetch', 'CategoryController@fetch')->name('fetch');
            Route::post('store', 'CategoryController@store')->name('store');
            Route::post('edit', 'CategoryController@edit')->name('edit');
            Route::post('update', 'CategoryController@update')->name('update');
            Route::post('delete', 'CategoryController@delete')->name('delete');
        });

        Route::group(['prefix' => 'sub-category', 'as' => 'sub-category.', 'middleware' => ['module:category']], function () {
            Route::get('view', 'SubCategoryController@index')->name('view');
            Route::get('fetch', 'SubCategoryController@fetch')->name('fetch');
            Route::post('store', 'SubCategoryController@store')->name('store');
            Route::post('edit', 'SubCategoryController@edit')->name('edit');
            Route::post('update', 'SubCategoryController@update')->name('update');
            Route::post('delete', 'SubCategoryController@delete')->name('delete');
        });

        Route::group(['prefix' => 'sub-sub-category', 'as' => 'sub-sub-category.', 'middleware' => ['module:category']], function () {
            Route::get('view', 'SubSubCategoryController@index')->name('view');
            Route::get('fetch', 'SubSubCategoryController@fetch')->name('fetch');
            Route::post('store', 'SubSubCategoryController@store')->name('store');
            Route::post('edit', 'SubSubCategoryController@edit')->name('edit');
            Route::post('update', 'SubSubCategoryController@update')->name('update');
            Route::post('delete', 'SubSubCategoryController@delete')->name('delete');
            Route::post('get-sub-category', 'SubSubCategoryController@getSubCategory')->name('getSubCategory');
            Route::post('get-category-id', 'SubSubCategoryController@getCategoryId')->name('getCategoryId');
        });

        Route::group(['prefix' => 'brand', 'as' => 'brand.', 'middleware' => ['module:brand']], function () {
            Route::get('add-new', 'BrandController@add_new')->name('add-new');
            Route::post('add-new', 'BrandController@store');
            Route::get('list', 'BrandController@list')->name('list');
            Route::get('update/{id}', 'BrandController@edit')->name('update');
            Route::post('update/{id}', 'BrandController@update');
            Route::post('delete', 'BrandController@delete')->name('delete');
        });
        Route::group(['prefix' => 'banner', 'as' => 'banner.', 'middleware' => ['module:banner']], function () {
            Route::post('add-new', 'BannerController@store')->name('store');
            Route::get('list', 'BannerController@list')->name('list');
            Route::post('delete', 'BannerController@delete')->name('delete');
            Route::post('status', 'BannerController@status')->name('status');
            Route::post('edit', 'BannerController@edit')->name('edit');
            Route::post('update', 'BannerController@update')->name('update');
        });

        Route::group(['prefix' => 'attribute', 'as' => 'attribute.', 'middleware' => ['module:attribute']], function () {
            Route::get('view', 'AttributeController@index')->name('view');
            Route::get('fetch', 'AttributeController@fetch')->name('fetch');
            Route::post('store', 'AttributeController@store')->name('store');
            Route::post('edit', 'AttributeController@edit')->name('edit');
            Route::post('update', 'AttributeController@update')->name('update');
            Route::post('delete', 'AttributeController@delete')->name('delete');
        });

        Route::group(['prefix' => 'coupon', 'as' => 'coupon.', 'middleware' => ['module:coupon']], function () {
            Route::get('add-new', 'CouponController@add_new')->name('add-new');
            Route::post('add-new', 'CouponController@store');
            Route::get('update/{id}', 'CouponController@edit')->name('update');
            Route::post('update/{id}', 'CouponController@update');
            Route::post('status', 'CouponController@status')->name('status');

        });

        Route::group(['prefix' => 'currency', 'as' => 'currency.', 'middleware' => ['module:business_settings']], function () {
            Route::get('view', 'CurrencyController@index')->name('view');
            Route::get('fetch', 'CurrencyController@fetch')->name('fetch');
            Route::post('store', 'CurrencyController@store')->name('store');
            Route::post('edit', 'CurrencyController@edit')->name('edit');
            Route::post('update', 'CurrencyController@update')->name('update');
            Route::post('delete', 'CurrencyController@delete')->name('delete');
            Route::post('status', 'CurrencyController@status')->name('status');
            Route::post('system-currency-update', 'CurrencyController@systemCurrencyUpdate')->name('system-currency-update');
        });

        Route::group(['prefix' => 'support-ticket', 'as' => 'support-ticket.'], function () {
            Route::get('view', 'SupportTicketController@index')->name('view');
            Route::post('status', 'SupportTicketController@status')->name('status');
            Route::get('single-ticket/{id}', 'SupportTicketController@single_ticket')->name('singleTicket');
            Route::post('single-ticket/{id}', 'SupportTicketController@replay_submit')->name('replay');
        });
        Route::group(['prefix' => 'notification', 'as' => 'notification.'], function () {
            Route::get('add-new', 'NotificationController@index')->name('add-new');
            Route::post('store', 'NotificationController@store')->name('store');
            Route::get('edit/{id}', 'NotificationController@edit')->name('edit');
            Route::post('update/{id}', 'NotificationController@update')->name('update');
            Route::post('status', 'NotificationController@status')->name('status');
            Route::post('delete', 'NotificationController@delete')->name('delete');
        });
        Route::group(['prefix' => 'reviews', 'as' => 'reviews.'], function () {
            Route::get('list', 'ReviewsController@list')->name('list');
        });

        Route::group(['prefix' => 'customer', 'as' => 'customer.'], function () {
            Route::get('list', 'CustomerController@customer_list')->name('list');
            Route::get('view/{user_id}', 'CustomerController@view')->name('view');
        });
        ///Report
        Route::group(['prefix' => 'report', 'as' => 'report.'], function () {
            Route::get('order', 'ReportController@order_index')->name('order');
            Route::get('earning', 'ReportController@earning_index')->name('earning');
            Route::post('set-date', 'ReportController@set_date')->name('set-date');

        });

        Route::group(['prefix' => 'sellers', 'as' => 'sellers.'], function () {
            Route::get('seller-list', 'SellerController@index')->name('seller-list');
            Route::get('order-list/{seller_id}', 'SellerController@order_list')->name('order-list');
            Route::get('product-list/{seller_id}', 'SellerController@product_list')->name('product-list');

            Route::get('order-details/{order_id}/{seller_id}', 'SellerController@order_details')->name('order-details');
            Route::get('verification/{id}', 'SellerController@view')->name('verification');
            Route::post('update-status', 'SellerController@updateStatus')->name('updateStatus');
            Route::post('withdraw-status', 'SellerController@withdrawStatus')->name('withdraw_status');
            Route::get('withdraw_list', 'SellerController@withdraw')->name('withdraw_list');
            Route::get('withdraw-view/{withdraw_id}/{seller_id}', 'SellerController@withdraw_view')->name('withdraw_view');
        });

        Route::group(['prefix' => 'product', 'as' => 'product.'], function () {
            Route::get('add-new', 'ProductController@add_new')->name('add-new');
            Route::post('store', 'ProductController@store')->name('store');
            Route::get('remove-image', 'ProductController@remove_image')->name('remove-image');
            Route::post('status-update', 'ProductController@status_update')->name('status-update');
            Route::get('list/{type}', 'ProductController@list')->name('list');
            Route::get('edit/{id}', 'ProductController@edit')->name('edit');
            Route::post('update/{id}', 'ProductController@update')->name('update');
            Route::post('featured-status', 'ProductController@featured_status')->name('featured-status');
            Route::post('sku-combination', 'ProductController@sku_combination')->name('sku-combination');
            Route::get('get-categories', 'ProductController@get_categories')->name('get-categories');
            Route::delete('delete/{id}', 'ProductController@delete')->name('delete');

            Route::get('view/{id}', 'ProductController@view')->name('view');
        });

        Route::group(['prefix' => 'flashDeal', 'as' => 'flashDeal.'], function () {
            Route::get('view', 'FlashDealController@index')->name('view');
            Route::post('store', 'FlashDealController@store')->name('store');
            Route::post('status', 'FlashDealController@status')->name('status');
            Route::post('delete', 'FlashDealController@delete')->name('delete');
        });

        Route::group(['prefix' => 'business-settings', 'as' => 'business-settings.'], function () {
            Route::get('general-settings', 'BusinessSettingsController@index')->name('general-settings');
            Route::get('update-language', 'BusinessSettingsController@update_language')->name('update-language');
            Route::get('about-us', 'BusinessSettingsController@about_us')->name('about-us');
            Route::post('about-us', 'BusinessSettingsController@about_usUpdate')->name('about-update');
            //Social Icon
            Route::get('social-media', 'BusinessSettingsController@social_media')->name('social-media');
            Route::get('fetch', 'BusinessSettingsController@fetch')->name('fetch');
            Route::post('social-media-store', 'BusinessSettingsController@social_media_store')->name('social-media-store');
            Route::post('social-media-edit', 'BusinessSettingsController@social_media_edit')->name('social-media-edit');
            Route::post('social-media-update', 'BusinessSettingsController@social_media_update')->name('social-media-update');
            Route::post('social-media-delete', 'BusinessSettingsController@social_media_delete')->name('social-media-delete');
            Route::post('social-media-status-update', 'BusinessSettingsController@social_media_status_update')->name('social-media-status-update');

            Route::get('terms-condition', 'BusinessSettingsController@terms_condition')->name('terms-condition');
            Route::post('terms-condition', 'BusinessSettingsController@updateTermsCondition')->name('update-terms');
            Route::get('fcm-index', 'BusinessSettingsController@fcm_index')->name('fcm-index');
            Route::post('update-fcm', 'BusinessSettingsController@update_fcm')->name('update-fcm');

            Route::post('update-fcm-messages', 'BusinessSettingsController@update_fcm_messages')->name('update-fcm-messages');

            Route::group(['prefix' => 'shipping-method', 'as' => 'shipping-method.'], function () {
                Route::get('add', 'ShippingMethodController@index')->name('add');
                Route::post('add', 'ShippingMethodController@store');
                Route::get('edit/{id}', 'ShippingMethodController@edit')->name('edit');
                Route::put('update/{id}', 'ShippingMethodController@update')->name('update');
                Route::post('delete', 'ShippingMethodController@delete')->name('delete');
                Route::post('status-update', 'ShippingMethodController@status_update')->name('status-update');
            });

            Route::group(['prefix' => 'language', 'as' => 'language.'], function () {
                Route::get('', 'LanguageController@index')->name('index');
                Route::post('add-new', 'LanguageController@store')->name('add-new');
                Route::get('update-status', 'LanguageController@update_status')->name('update-status');
                Route::get('translate/{lang}', 'LanguageController@translate')->name('translate');
                Route::post('translate-submit/{lang}', 'LanguageController@translate_submit')->name('translate-submit');
                Route::get('delete/{lang}', 'LanguageController@delete')->name('delete');
            });

            Route::group(['prefix' => 'mail', 'as' => 'mail.'], function () {
                Route::get('', 'MailController@index')->name('index');
                Route::post('update', 'MailController@update')->name('update');
            });

            Route::group(['prefix' => 'web-config', 'as' => 'web-config.'], function () {
                Route::get('/', 'BusinessSettingsController@companyInfo')->name('index');
                Route::post('update-colors', 'BusinessSettingsController@update_colors')->name('update-colors');
                Route::post('update-company', 'BusinessSettingsController@updateCompany')->name('company-update');
                Route::post('update-company-email', 'BusinessSettingsController@updateCompanyEmail')->name('company-email-update');
                Route::post('update-company-phone', 'BusinessSettingsController@updateCompanyPhone')->name('company-phone-update');
                Route::post('upload-web-logo', 'BusinessSettingsController@uploadWebLogo')->name('company-web-logo-upload');
                Route::post('upload-mobile-logo', 'BusinessSettingsController@uploadMobileLogo')->name('company-mobile-logo-upload');
                Route::post('upload-footer-log', 'BusinessSettingsController@uploadFooterLog')->name('company-footer-logo-upload');
                Route::post('upload-fav-icon', 'BusinessSettingsController@uploadFavIcon')->name('company-fav-icon');
                Route::post('update-company-copyRight-text', 'BusinessSettingsController@updateCompanyCopyRight')->name('company-copy-right-update');
                Route::post('{name}', 'BusinessSettingsController@update')->name('app-store-update');
            });
            Route::group(['prefix' => 'seller-settings', 'as' => 'seller-settings.'], function () {
                Route::get('/', 'BusinessSettingsController@seller_settings')->name('index');
                Route::post('update-seller-settings', 'BusinessSettingsController@sales_commission')->name('update-seller-settings');
                Route::post('update-seller-registration', 'BusinessSettingsController@seller_registration')->name('update-seller-registration');
            });

            Route::group(['prefix' => 'payment-method', 'as' => 'payment-method.'], function () {
                Route::get('/', 'PaymentMethodController@index')->name('index');
                Route::post('{name}', 'PaymentMethodController@update')->name('update');
            });

            Route::group(['prefix' => 'sms-gateway', 'as' => 'sms-gateway.'], function () {
                Route::get('/', 'SmsGatewayController@index')->name('index');
                Route::post('{name}', 'SmsGatewayController@update')->name('update');
            });

        });

        Route::group(['prefix' => 'orders', 'as' => 'orders.'], function () {
            Route::get('list/{status}', 'OrderController@list')->name('list');
            Route::get('details/{id}', 'OrderController@details')->name('details');
            Route::post('status', 'OrderController@status')->name('status');
            Route::post('payment-status', 'OrderController@payment_status')->name('payment-status');
            Route::post('productStatus', 'OrderController@productStatus')->name('productStatus');
            Route::get('generate-invoice/{id}', 'OrderController@generate_invoice')->name('generate-invoice');
        });
        Route::group(['prefix' => 'helpTopic', 'as' => 'helpTopic.'], function () {

            Route::get('list', 'HelpTopicController@list')->name('list');
            Route::post('add-new', 'HelpTopicController@store')->name('add-new');
            Route::get('status/{id}', 'HelpTopicController@status');
            Route::get('edit/{id}', 'HelpTopicController@edit');
            Route::post('update/{id}', 'HelpTopicController@update');
            Route::post('delete', 'HelpTopicController@destroy')->name('delete');

        });
        Route::group(['prefix' => 'contact', 'as' => 'contact.'], function () {
            Route::post('contact-store', 'ContactController@store')->name('store');
            Route::get('list', 'ContactController@list')->name('list');
            Route::post('delete', 'ContactController@destroy')->name('delete');
            Route::get('view/{id}', 'ContactController@view')->name('view');
            Route::post('update/{id}', 'ContactController@update')->name('update');
        });
    });

    //for test

    /*Route::get('login', 'testController@login')->name('login');*/

});
