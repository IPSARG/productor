<?php
//    Route::any('logout', function () {
//     Auth::logout();
//     return redirect()->action('HomeController@index');
// });

// Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => ['CheckInUser']], function () {
    Route::get('/', 'NumericController@index')->name('index');
    Route::any('/TESTING', 'NumericController@TESTING')->name('TESTING');


    Route::group(['prefix' => 'aplicativos'], function () {

        Route::group(['prefix' => 'categorias_aplicativos'], function () {

            Route::post('/create', 'AplicativosController@create')->name('categorias_aplicativos.create');
            Route::post('/update/{id}', 'AplicativosController@update')->name('categorias_aplicativos.update');

        });

    Route::get('/', 'AplicativosController@index')->name('aplicativos');
    Route::delete('/delete/{id}', 'AplicativosController@delete')->name('aplicativos.delete');
    Route::get('/updatev/{id}', 'AplicativosController@editar')->name('aplicativos.updatev');
    Route::post('/update', 'AplicativosController@actualizar')->name('aplicativos.update');
    Route::post('/nuevo', 'AplicativosController@nuevo_index')->name('aplicativos.save');
    });
    Route::group(['prefix' => 'indice-numerico'], function () {
        // NORMS
        Route::post('/post-norm', 'NumericController@postNorm')->name('post.norm');
        Route::get('/editar-norma/{id_norma}/{id_tipo_norma}', 'NumericController@getPutNorm')->where('id_norma', '.*')->name('get.put.norm');
        Route::put('/put-norm/{id_norma}/{id_tipo_norma}', 'NumericController@putNorm')->where('id_norma', '.*')->name('put.norm');
        Route::delete('/delete-norm/{id_norma}/{id_tipo_norma}', 'NumericController@deleteNorm')->where('id_norma', '.*')->name('delete.norm');
        Route::get('/buscar-normas/{id_norma?}/{id_tipo_norma?/{fec_carga?}/{fec_norma?}', 'NumericController@searchNorms')->where('id_norma', '.*')->name('search.norms');
        Route::put('/deactive-norm/{id_norma}/{id_tipo_norma}', 'NumericController@deactiveNorm')->where('id_norma', '.*')->name('deactive.norm');
        // ARCHIVE
        Route::any('delete-norm-archive/{texto_norma}', 'NumericController@deleteNormArchive')->name('delete.norm.archive');
        // NORM TYPE
        Route::post('/post-norm-type', 'NormTypeController@postNormType')->name('post.norm.type');
        Route::get('/buscar-tipo-norma/{desc_tipo_norma?}/{id_tipo_norma?}/{idjurisdiccion?}/{idtipodocumento?}', 'NormTypeController@searchNormType')->name('search.norm.type');
        Route::get('/editar-tipo-norma/{id_tipo_norma}', 'NormTypeController@getPutNormType')->name('get.put.norm.type');
        Route::put('/put-norm-type/{id_tipo_norma}', 'NormTypeController@putNormType')->name('put.norm.type');
        Route::delete('/delete-norm-type/{id_tipo_norma}', 'NormTypeController@deleteNormType')->name('delete.norm.type');
    });

    Route::group(['prefix' => 'materias-coes'], function () {
        Route::get('/', 'ThematicController@index')->name('tem');
        Route::get('/filtrar', 'ThematicController@getTemChild')->name('get.tem.child');
        Route::get('/filtrar/legis', 'ThematicController@getTemChild')->name('get.tem.child.legis');
        Route::get('/filtrar/coefi', 'ThematicController@getTemChildCoefi')->name('get.tem.child.coe');
        // RESULTADOS
        Route::get('/filtrar/final/n_clas', 'DispatchController@resultNCl')->name('get.disp.NCl');
        Route::get('/filtrar/final/clas', 'DispatchController@resultCl')->name('get.disp.Cl');
        Route::get('/filtrar/final/coefi', 'DispatchController@resultCoe')->name('get.disp.Coe');
        Route::get('/filtrar/final/capitulado', 'DispatchController@resultCap')->name('get.disp.cap');
        Route::get('/filtrar/final/conferencias','DispatchController@getTopicsCovered')->name('get.topics.covered');
        Route::get('enlazar-norma/{cod_nodo}/{desc_nodo}', 'ThematicController@getLinkNorm')->where('id_norma', '.*')->where('desc_nodo', '.*')->name('get.link.norm');
        Route::get('agregar-coe/{cod_padre}/{desc_nodo}', 'ThematicController@getAddCoe')->where('desc_nodo', '.*')->name('get.post.coe');
        // POST/PUT/DELETE
        Route::post('post-node', 'ThematicController@postNode')->name('post.node');
        Route::put('put-node/{cod_nodo}', 'ThematicController@putNode')->name('put.node');
        Route::delete('delete-node/{cod_nodo}', 'ThematicController@deleteNode')->name('delete.node');
        Route::post('updatecodoFinales/', 'ThematicController@updatecodoFinales')->name('post.updatecodoFinales');




        Route::delete('unlink-node/{id_norma}/{id_tipo_norma}', 'ThematicController@unlinkNode')->where('id_norma', '.*')->name('unlink.node');
        Route::delete('delete-norm/{id_norma}/{id_tipo_norma}', 'ThematicController@deleteNorm')->where('id_norma', '.*')->name('delete.norm');
        Route::post('link-norm', 'ThematicController@linkNorm')->name('link.norm');
        Route::put('put-norm/{id_norma}/{id_tipo_norma}', 'ThematicController@putTemNorm')->where('id_norma', '.*')->name('put.tem.norm');
        Route::post('/post-coe', 'ThematicController@postCoe')->name('post.coe');
    });

    Route::get('/coeficients', 'CoeController@index')->name('coes');
});

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
