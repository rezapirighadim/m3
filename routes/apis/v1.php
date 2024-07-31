<?php

Route::prefix('v1')->namespace('Api\v1')->middleware(['ConvertArabic2Persian'])->group(function() {

    Route::get('forbidden_api' , function() {

        return responseStructure('fail', [ ] , 'invalid request . forbidden request');

    });

    Route::post('login' , 'UserController@new_login');
    Route::post('resend_login' , 'UserController@new_login');
    Route::post('check_login' , 'UserController@check_login');

    Route::post('/get_categories' , 'HomeController@get_categories');

    Route::post('/like_content' , 'HomeController@like_content');

    Route::post('/get_home' , 'HomeController@get_home');
    Route::post('/get_site_info' , 'HomeController@get_site_info');
    Route::post('/get_shop' , 'HomeController@get_shop');
    Route::post('/get_packages' , 'HomeController@get_packages');
    Route::post('/get_packages_by_category' , 'HomeController@get_packages_by_category');
    Route::post('/get_packages' , 'HomeController@get_packages');
    Route::post('/free_content_by_category' , 'HomeController@free_content_by_category');
    Route::get('/pay/{transaction_id}' , 'PaymentController@send_to_bank');
    Route::get('/verify_payment' , 'PaymentController@verify_payment');


    Route::post('/get_masters' , 'OtherController@get_masters');
    Route::post('/get_team' , 'OtherController@get_team');
    Route::post('/about_nahi' , 'OtherController@about_nahi');



    Route::middleware('auth:api')->group(function() {
        Route::post('/edit_profile' , 'UserController@edit_profile');
        Route::post('/get_user_info' , 'UserController@getUserInformation');

        Route::post('/logout' , 'UserController@logout');

        Route::post('/get_user_orders' , 'BookController@get_user_orders');

        Route::post('/get_order_details' , 'BookController@get_order_details');

        Route::post('/submit_comment' , 'OtherController@submit_comment');

        Route::post('/submit_favorite' , 'OtherController@submit_favorite');
        Route::post('/get_my_favorite' , 'OtherController@get_my_favorite');

        Route::post('/submit_rate' , 'OtherController@submit_rate');

        Route::post('/add_to_basket' , 'BasketController@add_to_basket');
        Route::post('/remove_basket_item' , 'BasketController@remove_basket_item');
        Route::post('/get_user_basket_details' , 'BasketController@get_user_basket_details');

        Route::post('/pay' , 'PaymentController@pay');
        Route::post('/get_user_accessed_categories' , 'UserController@get_user_accessed_categories');
        Route::post('/get_content_by_category_id_login' , 'OtherController@get_content_by_category_id_login');
        Route::post('/calculate_off_code' , 'PaymentController@calculate_off_code');
        Route::post('/get_user_transactions' , 'UserController@get_user_transactions');

//        Route::post('/check_book_favorite' , 'BookController@check_book_favorite');
//        Route::post('/get_favorite_books' , 'BookController@get_favorite_books');
//        Route::post('/add_favorite_book' , 'BookController@add_favorite_book');
//        Route::post('/remove_favorites_book' , 'BookController@remove_favorites_book');
//        Route::post('/increase_credit' , 'TransactionController@increase_credit');
//        Route::post('/get_user_credit' , 'TransactionController@get_user_credit');


        Route::post('/check_off_code' , 'OtherController@check_off_code');


    });

});
