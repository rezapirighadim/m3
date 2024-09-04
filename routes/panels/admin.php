<?php
Route::namespace('Admin')->prefix('admin')->middleware([ 'ConvertArabic2Persian' , 'auth:web' ])->group(function () {


//  index
    Route::get('/', 'AdminController@index');
    Route::get('', 'AdminController@index');
    Route::get('/index', 'AdminController@index');


    //devices
    Route::get('/devices', 'DeviceController@index');


//    masters
    Route::get('/masters', 'MastersController@index');
    Route::get('/masters/{master}', 'MastersController@edit');
    Route::post('/masters', 'MastersController@store');
    Route::get('/remove_master/{id}' , 'MastersController@destroy');


//    site info
    Route::get('/site_info', 'SiteInfoController@index');
    Route::post('/site_info', 'SiteInfoController@store');


//    sensors
    Route::get('/sensors', 'SensorController@index');
    Route::get('/sensors/{sensor}', 'SensorController@edit');
    Route::post('/sensors', 'SensorController@store');
    Route::get('/remove_sensor/{id}' , 'SensorController@destroy');

//    send data
    Route::get('/send_data', 'SendDataController@index');
    Route::post('/send_data', 'SendDataController@publish');


//    sensors
    Route::get('/mqtt_connection', 'MqttController@index');
    Route::get('/mqtt_connection/{mqtt_connection}', 'MqttController@edit');
    Route::post('/mqtt_connection', 'MqttController@store');

    Route::get('/mqtt_messages', 'MqttMessageController@index');
    Route::get('/mqtt_alerts', 'MqttMessageController@alerts');

//    Route::post('/mqtt/publish', 'MqttController@publish');
//    Route::get('/mqtt/subscribe', 'MqttController@subscribe');
    Route::get('/mqtt/check-connection', 'MqttController@checkConnection');

//    sensor_vaiables
    Route::get('/sensor_variables', 'SensorVariablesController@index');
    Route::get('/sensor_variables/{variable}', 'SensorVariablesController@edit');
    Route::post('/sensor_variables', 'SensorVariablesController@store');
    Route::get('/remove_sensor_variables/{id}' , 'SensorVariablesController@destroy');

//    sensor_datas
//    Route::get('/sensor_datas', 'SensorDataController@index');
//    Route::get('/sensor_datas/{sensor_data}', 'SensorDataController@edit');
//    Route::post('/sensor_datas', 'SensorDataController@store');
//    Route::get('/sensor_datas/{id}' , 'SensorDataController@destroy');

//    categories
    Route::get('/categories', 'CategoryController@index');
    Route::get('/categories/{category}', 'CategoryController@edit');
    Route::post('/categories', 'CategoryController@store');
    Route::get('/remove_category/{id}' , 'CategoryController@destroy');



//    packages
    Route::get('/packages', 'PackageController@index');
    Route::get('/package/{package}', 'PackageController@edit');
    Route::post('/package', 'PackageController@store');
    Route::get('/remove_package/{id}' , 'PackageController@destroy');

//    banners
    Route::get('/banners', 'BannerController@index');
    Route::get('/banners/{banner}', 'BannerController@edit');
    Route::post('/banners', 'BannerController@store');
    Route::get('/remove_banner/{id}' , 'BannerController@destroy');

//    off codes
    Route::get('/off_codes/', 'OffCodeController@index');
    Route::get('/off_codes/{off_code}', 'OffCodeController@edit');
    Route::post('/off_codes/', 'OffCodeController@store');
    Route::get('/remove_off_codes/{id}', 'OffCodeController@destroy');
    Route::get('/remove_pdf_file/{book}', 'BookController@remove_pdf_file');


//    contents
    Route::get('/contents/', 'ContentController@index');
    Route::post('/content/', 'ContentController@store');
    Route::post('/upload_content/{type}/{content_id}/', 'ContentController@upload');
    Route::post('/upload_large_file/{content_id}', 'ContentController@uploadLargeFiles');
    Route::post('/upload_files/{type}/{content_id}', 'ContentController@upload_files');
    Route::any('/remove_file/{file}', 'ContentController@remove_file');
    Route::get('/content/{content}', 'ContentController@edit');
    Route::get('/remove_content/{id}', 'ContentController@destroy');
    Route::get('/remove_content_file/{id}', 'ContentController@remove_content_file');


//     orders
    Route::get('/orders/', 'OrderController@index');
    Route::get('/orders/{type}', 'OrderController@get_orders');
    Route::get('/order_details/{transaction}', 'OrderController@order_details');


//      users
    Route::get('/mobile_users', 'MobileUsersController@index');
    Route::get('/mobile_users/get_excel', 'MobileUsersController@get_excel');
    Route::get('/mobile_users/{user}', 'MobileUsersController@info');


//    price controller
    Route::get('/price_setting', 'PriceController@index');
    Route::post('/price_setting', 'PriceController@store');

//    news

    Route::get('/news', 'NewsController@index');
    Route::get('/news/{news}', 'NewsController@edit');
    Route::post('/news', 'NewsController@store');
    Route::get('/remove_news/{id}' , 'NewsController@destroy');




//    comments
    Route::get('/comments', 'CommentsController@all');
    Route::get('/comments/{types}', 'CommentsController@all');
    Route::post('/confirm_comments', 'CommentsController@confirm');
    Route::get('/confirm_comment/{id}' , 'CommentsController@confirm_comment');
    Route::get('/remove_comment/{id}' , 'CommentsController@remove_comment');


// categorise

    Route::get('/user_info/{id}', 'AdminController@user_info');
    Route::get('/message_list', 'AdminController@message_list');
    Route::get('/messageList', 'AdminController@message_list');


    Route::get('/books', 'BookController@index'); // just admin can create new book's
    Route::get('/books/{book}', 'BookController@edit');
    Route::post('/books', 'BookController@store');
    Route::get('/books_list', 'BookController@list');

    Route::get('/toggleSelect/{book}' , 'BookController@toggleSelect');



    Route::get('/content_preview/{content_id}', 'BookContentController@preview');
    Route::get('/book_contents', 'BookContentController@index');
    Route::get('/book_contents/{id}', 'BookContentController@book_content');
//    Route::get('/book_contents/{id}', 'BookContentController@edit');
//    Route::get('/book_contents/{id}/{content_id}', 'BookContentController@edit');
//    Route::post('/book_contents', 'BookContentController@store');
    Route::post('/upload_book_content', 'BookContentController@upload_zip');
    Route::get('/remove_book_contents/{id}' , 'BookContentController@destroy');

    Route::get('/seller_transactions/{type}', 'TransactionContorller@seller_list');


    Route::get('/change_password' , 'UserController@change_password');
    Route::post('/change_password' , 'UserController@change_password_store');

    Route::get('/logout' , 'AdminController@logout');

    Route::get('/transactions/{type}', 'TransactionContorller@list');

    Route::get('/setting_bank/', 'SettingController@bank_show');
    Route::get('/setting_account/', 'SettingController@account_show');
    Route::post('/setting/', 'SettingController@setting_store');



    Route::get('/assign_book/', 'AssignBookController@index');
    Route::get('/assign_book_list/', 'AssignBookController@book_list');
    Route::post('/assign_book/', 'AssignBookController@store');
    Route::get('/assign_book/{book}', 'AssignBookController@assign_book');
    Route::get('/toggleSelect_assigned_book/{id}' , 'AssignBookController@toggleSelect');
    Route::get('/remove_assigned_book/{id}' , 'AssignBookController@destroy');
    Route::post('/search_book', 'BookController@search_book');

    Route::get('/import_shop_excel' , 'AssignBookController@import_view');
    Route::post('/import_upload' , 'AssignBookController@import_upload');
    Route::post('/import_excels_column' , 'AssignBookController@import_excels_column');

    Route::get('/manifest', 'ManifestController@index');
    Route::post('/manifest', 'ManifestController@store');


    Route::post('/change_order_status', 'StatusController@change_order_status');



    Route::get('/buy_modules', 'AdminController@buy_modules');

    Route::get('/toggle_delete_request/{id}', 'BookController@toggle_delete_request');

    Route::middleware('IsAdmin')->group(function() {

        Route::get('/book_delete_request_waiting', 'BookController@book_delete_request_waiting');
        Route::get('/remove_book/{id}' , 'BookController@destroy');


        Route::get('/admin_setting', 'SystemSettingController@index');
        Route::post('/admin_setting', 'SystemSettingController@store');
        Route::get('/admin_setting/{id}', 'SystemSettingController@edit');

        Route::get('/crawler', 'CrawlerController@index');
        Route::post('/crawler', 'CrawlerController@store');

//        Route::get('/books', 'BookController@index');

        Route::get('/status', 'StatusController@index');
        Route::post('/status', 'StatusController@store');
        Route::get('/status/{orderStatusList}', 'StatusController@edit');

        Route::get('/creators', 'CreatorController@index');
        Route::get('/creators/{creator}', 'CreatorController@edit');
        Route::post('/creators', 'CreatorController@store');
        Route::get('/remove_creator/{id}' , 'CreatorController@destroy');



        Route::get('/publishers', 'PublisherController@index');
        Route::get('/publishers/{publisher}', 'PublisherController@edit');
        Route::post('/publishers', 'PublisherController@store');
        Route::get('/remove_publisher/{id}' , 'PublisherController@destroy');


        Route::get('/app_update', 'AppUpdateController@index');
        Route::get('/app_update/{app_update}', 'AppUpdateController@edit');
        Route::post('/app_update', 'AppUpdateController@store');
        Route::get('/remove_app_update/{id}' , 'AppUpdateController@destroy');

        Route::get('/submit_seller', 'SellerController@index');
        Route::get('/submit_seller/{id}', 'SellerController@edit');
        Route::post('/submit_seller', 'SellerController@store');


        Route::get('/tariff', 'TariffController@index');
        Route::get('/tariff/{id}', 'TariffController@edit');
        Route::post('/tariff', 'TariffController@store');

        Route::resource('roles' , 'RoleController');
        Route::resource('permissions' , 'PermissionController');



    });




});
