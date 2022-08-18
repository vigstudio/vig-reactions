<?php

Route::group(['namespace' => 'Botble\VigReactions\Http\Controllers', 'middleware' => 'web'], function () {

    Route::group(['prefix' => config('core.base.general.admin_dir'), 'middleware' => 'auth'], function () {

        Route::group(['prefix' => 'vig-reactions', 'as' => 'vig-reactions.'], function () {
            Route::resource('', 'VigReactionsController')->parameters(['' => 'vig-reactions']);
            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'VigReactionsController@deletes',
                'permission' => 'vig-reactions.destroy',
            ]);
        });
    });

    Route::group(['prefix' => 'reaction'], function () {
        Route::post('get-reaction', 'ActionController@getReaction')->name('vig.reaction.get');
        Route::post('press-reaction', 'ActionController@pressReaction')->name('vig.reaction.press');
    });

});
