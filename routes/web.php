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

Route::get('/', 'MainController@index')->name('index');



/** ==================== Login Page ====================== **/
Route::get('/login', 'MainController@login')->name('login');
Route::post('/loginPost', 'MainController@loginPost')->name('postLogin');
Route::get('/logout', 'MainController@logout')->name('logout');
Route::get('/resetPass', 'MainController@resetPass')->name('resetPass');
Route::post('/forgotPass', 'MainController@forgotPass')->name('forgotPass');

Route::group(['middleware' => 'usersession'], function () {

    /* ================= Register Dokumen ================== */
    //SPK
    Route::get('/regDocSPK', 'RegDocController@regDocSPK')->name('regDocSPK');
    Route::get('/regDocSPKTrailer', 'RegDocController@regDocSPKTrailer')->name('regDocSPKTrailer');
    Route::post('/searchSPK', 'RegDocController@searchSPK')->name('searchSPK');
    Route::post('/getDatatableSPK', 'RegDocController@getDatatableSPK')->name('getDatatableSPK');
    Route::post('/pairingBarcode', 'RegDocController@pairingBarcode')->name('pairingBarcode');
    Route::get('/insertDocSPK/{id}', 'RegDocController@insertDocSPK')->name('insertDocSPK');
    Route::post('/submitRegDoc', 'RegDocController@submitRegDoc')->name('submitRegDoc');
    Route::post('/getHistory', 'RegDocController@getHistory')->name('getHistory');
    Route::post('/getDataKelengkapan', 'RegDocController@getDataKelengkapan')->name('getDataKelengkapan');
    Route::post('/actionKembalikan', 'RegDocController@actionKembalikan')->name('actionKembalikan');
    Route::post('/actionDeleteDetail', 'RegDocController@actionDeleteDetail')->name('actionDeleteDetail');
    Route::post('/addOpenDoc', 'RegDocController@addOpenDoc')->name('addOpenDoc');
    Route::post('/submitOpenDocument', 'RegDocController@submitOpenDocument')->name('submitOpenDocument');
    Route::post('/getDataAttr','RegDocController@getDataAttr')->name('getDataAttr');
    Route::post('/getSPKNumber','RegDocController@getSPKNumber')->name('getSPKNumber');
    Route::post('/getTerimaDok','RegDocController@getTerimaDok')->name('getTerimaDok');
    

	//SPD
    Route::get('/regDocSPD', 'RegDocController@regDocSPD')->name('regDocSPD');
    Route::post('/searchSPD', 'RegDocController@searchSPD')->name('searchSPD');
    Route::post('/getDatatableSPD', 'RegDocController@getDatatableSPD')->name('getDatatableSPD');
    Route::get('/insertDocSPD/{id}', 'RegDocController@insertDocSPD')->name('insertDocSPD');
    Route::post('/getDataContainer', 'RegDocController@getDataContainer')->name('getDataContainer');
    Route::post('/submitRegDocSPD', 'RegDocController@submitRegDocSPD')->name('submitRegDocSPD');
    
    /* ================= Send To Messengger admin operation================== */
    
    //SPK
    
    Route::get('/sendToMsgSPK', 'SendToMsgController@index');
    Route::post('/sendToMsgSPK/loadDataMsgSPK', 'SendToMsgController@loadDataMsg_SPK')->name('sendToMsgSPK.loadDataMsgSPK');
    Route::get('/sendToMsgSPK/detailArsipSPK/{kode_arsip}', 'SendToMsgController@detailArsip_SPK')->name('sendToMsgSPK.detailArsipSPK');
    Route::post('/sendToMsgSPK/print_arsip', 'SendToMsgController@printArsip')->name('sendToMsgSPK.print_arsip');
    Route::post('/kembaliDataSPK', 'SendToMsgController@kembaliDataSPK')->name('kembaliDataSPK');

    // SPK Trailer

    Route::get('/sendToMsgSPKTrailer', 'SendToMsgController@SPKTrailer');
    Route::post('/loadDataMsgSPKTrailer', 'SendToMsgController@loadDataSPKTrailer')->name('loadDataMsgSPKTrailer');
    Route::get('/detailMsgSPKTrailer/{kode_arsip}', 'SendToMsgController@detailSPKTrailer')->name('detailMsgSPKTrailer');
    Route::post('/printMsgSPKTrailer', 'SendToMsgController@printSPKTrailer')->name('printMsgSPKTrailer');
    Route::post('/kembalikanDocSPKTrailer', 'SendToMsgController@kembalikanDocSPKTrailer')->name('kembalikanDocSPKTrailer');

	//SPD
    Route::get('/sendToMsgSPD', 'SendToMsgController@indexSPD');
    Route::post('/sendToMsgSPD/loadDataMsgSPD', 'SendToMsgController@loadDataMsg_SPD')->name('sendToMsgSPD.loadDataMsgSPD');
    Route::get('/sendToMsgSPD/detailArsipSPD/{kode_arsip}', 'SendToMsgController@detailArsip_SPD')->name('sendToMsgSPD.detailArsipSPD');
    Route::post('/sendToMsgSPD/print_arsip', 'SendToMsgController@printArsip_SPD')->name('sendToMsgSPD.print_arsip');
    Route::post('/kembaliDocumentSPD', 'SendToMsgController@kembaliDocumentSPD')->name('kembaliDocumentSPD');
    
    
    /* ================= Process Dokumen ================== */
    //SPK
    Route::get('/procesDocSPK', 'ProccessDocController@indexSPK')->name('indexSPK');
    Route::get('/procesDocSPKTrailer', 'ProccessDocController@indexSPKTrailer')->name('indexSPKTrailer');
    Route::post('/getDatatableProccessDocSPK','ProccessDocController@getDatatabel')->name('getDatatableProccessDocSPK');
    Route::post('/regDocMasukFinance', 'ProccessDocController@regDocMasukFinance')->name('regDocMasukFinance');
    
    Route::get('/insertProccessDocSPK/{id}','ProccessDocController@insertProccessDocSPK')->name('insertProccessDocSPK');
    Route::post('/getDataAttrProccessDoc','ProccessDocController@getDataAttr')->name('getDataAttrProccessDoc');
    Route::post('/getHistoryProccessDoc', 'ProccessDocController@getHistory')->name('getHistoryProccessDoc');
    Route::post('/getDataKelengkapanProccessDoc', 'ProccessDocController@getDataKelengkapan')->name('getDataKelengkapanProccessDoc');
    Route::post('/submitProcessDoc', 'ProccessDocController@submitProcessDoc')->name('submitProcessDoc');
    
    Route::post('/regDocProcess', 'ProccessDocController@regDocMasuk')->name('regDocProcess');//regDocMasuk
    Route::post('/addOpenDocProcess', 'ProccessDocController@addOpenDoc')->name('addOpenDocProcess');
    Route::post('/submitOpenDocumentFinance', 'ProccessDocController@submitOpenDocument')->name('submitOpenDocumentFinance');
    Route::post('/submitRegDocFinance', 'ProccessDocController@submitDocFinance')->name('submitRegDocFinance');//submitRegDocFinance
    Route::post('/actionKembalikanProcessDoc', 'ProccessDocController@actionKembalikan')->name('actionKembalikanProcessDoc');
    Route::post('/getTerimaDokFinance','ProccessDocController@getTerimaDokFinance')->name('getTerimaDokFinance');
    
    //SPD
    Route::get('/procesDocSPD', 'ProccessDocController@indexSPD')->name('indexSPD');
    Route::post('/getDatatableProccessDocSPD','ProccessDocController@getDatatabelSPD')->name('getDatatableProccessDocSPD');
    Route::post('/searchProccessSPD','ProccessDocController@searchSPD')->name('searchProccessSPD');
    Route::get('/insertProcessDocSPD/{id}','ProccessDocController@insertProcessDocSPD')->name('insertProcessDocSPD');
    Route::post('/getDataContainerSPD', 'ProccessDocController@getDataContainer')->name('getDataContainerSPD');
    Route::post('/submitProcessDocSPD', 'ProccessDocController@submitProcessDocSPD')->name('submitProcessDocSPD');
    Route::post('/regProcessSPD', 'ProccessDocController@regDocMasukSPD')->name('regProcessSPD');//regDocMasuk

    //Status Dokumen
    Route::get('/statusDokumen', 'StatusDokoumenController@index')->name('statusDokumen');


      /* ================= Send To Messengger admin Finance ================== */
    //SPK
    Route::get('/showSPK', 'FinanceController@showSPK')->name('showSPK');
    Route::post('/loadDataSPK', 'FinanceController@loadDataSPK')->name('loadDataSPK');
    Route::get('/detailSPK/{kode_arsip}', 'FinanceController@detailSPK')->name('detailSPK');
    Route::post('/printSPK', 'FinanceController@printSPK')->name('printSPK');


    // SPK Trailer

    Route::get('/showSPKTrailer', 'FinanceController@showSPKTrailer')->name('showSPKTrailer');
    Route::post('/loadDataSPKTrailer', 'FinanceController@loadDataSPKTrailer')->name('loadDataSPKTrailer');
    Route::get('/detailSPKTrailer/{kode_arsip}', 'FinanceController@detailSPKTrailer')->name('detailSPKTrailer');
    Route::post('/printSPKTrailer', 'FinanceController@printSPKTrailer')->name('printSPKTrailer');


    //SPD
    Route::get('/showSPD', 'FinanceController@showSPD')->name('showSPD');
    Route::post('/loadDataSPD', 'FinanceController@loadDataSPD')->name('loadDataSPD');
    Route::get('/detailSPD/{kode_arsip}', 'FinanceController@detailSPD')->name('detailSPD');
    Route::post('/printSPD', 'FinanceController@printSPD')->name('printSPD');


    /* ================Settings ==========================*/

    
    Route::get('/settingGeneral', 'SettingController@validasi')->name('settingGeneral');
    Route::get('/settingAddMsg', 'SettingController@addMsg')->name('settingAddMsg');
    Route::post('/loadDataMsg', 'SettingController@loadDataMsg')->name('loadDataMsg');
    Route::post('/addDataMsg', 'SettingController@addDataMsg')->name('addDataMsg');
    Route::put('/editDataMsg/{id}', 'SettingController@editDataMsg')->name('editDataMsg');
    Route::delete('/deleteDataMsg/{id}', 'SettingController@deleteDataMsg')->name('deleteDataMsg');
    Route::get('/changePsw', 'ChangePswController@changepsw');
    Route::post('/changePassword', 'ChangePswController@changePassword');



    Route::get('/masterReport', 'ReportController@index')->name('masterReport');
    Route::post('/docKembaliData', 'ReportController@docKembaliData')->name('docKembaliData');
    Route::post('/leadTimeData', 'ReportController@leadTimeData')->name('leadTimeData');
    Route::post('/outstandingData', 'ReportController@outstandingData')->name('outstandingData');
    Route::post('/docTerimaData', 'ReportController@docTerimaData')->name('docTerimaData');
    Route::post('/docFinanceData', 'ReportController@docFinanceData')->name('docFinanceData');
    Route::post('/docOperationData', 'ReportController@docOperationData')->name('docOperationData');
    Route::post('/docMessenggerData', 'ReportController@docMessenggerData')->name('docMessenggerData');
    
    //Status Dokumen
    Route::get('/statusDokumen', 'StatusDokumenController@index')->name('statusDokumen');
    //Route::get('/getDataStatusDokumen', 'StatusDokumenController@getDatatableSPKSPD')->name('statusDokumen');
});


