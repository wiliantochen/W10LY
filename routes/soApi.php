<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return "www - ".$router->app->version();
});

$router->get('user/{id}/{name}', function ($id, $name) {
    return 'User '.$id." - ".$name;
});


$router->group(['middleware'=> 'so'], function($router) {
	$router->post('login', 'Forms\cAUTH@Login');
	// Below is testing...
	$router->get('ListMenuXXX', 'AuthController@LoadListUserMenuXXX');
});

$router->group(['middleware'=> ['auth']], function($router) {	
	$router->group(['middleware'=> 'so'], function($router) {
		$router->get('getData', 'cSORouter@Panggil');
		$router->post('postData', 'cSORouter@Kirim');
		$router->get('printData', 'cSORouter@Cetak');
		// Below is testing...
		$router->get('testToken', 'Forms\cAUTH@test');
		$router->get('userLogin', 'AuthController@getUserLogin');
		$router->get('testGrid', 'AuthController@grid');
	});
});

$router->get('exporttoexcel', 'Forms\cETE@getData');


// $router->get('/coba', 'ExampleController@cobacoba');

/*
================================================================================================================
Route Yang Di Bawah Untuk Testing...
================================================================================================================
*/
$router->get('getABC', function () {
    return response()->json([
                        'success'=>false,
                        'message'=>'',
                        'dateInfo'=>'dateInfo',
                        'token'=>'token'
                    ]);
});
$router->post('postABC', function () {
    return response()->json([
                        'success'=>false,
                        'message'=>'',
                        'dateInfo'=>'dateInfo',
                        'token'=>'token'
                    ]);
});

$router->get('ete', 'Forms\cTES123@ETExxx');


$router->get('DataDummy', 'Forms\cDUMMYDATA@Coba');
// $router->get('PrintForm', 'Forms\cPHHEAD@PrintForm');
$router->get('PrintFormPO', 'Reports\crPHHEAD@PrintForm');
$router->get('PrintFormSO', 'Reports\crSHHEAD@PrintForm');

$router->get('PrintFormPO1', 'Reports\crPHHEAD@PrintABC');

$router->get('TestControllerAwal', 'Forms\cTES123@Awal');
$router->get('TestControllerAkhir', 'Forms\cTBLDSC@LoadGrid');
$router->get('TestControllerCoba', 'Forms\cTES123@Coba');
// $router->get('TestControllerAkhir', 'Forms\cTBLDSC@FormObject');
// $router->get('TestControllerAkhir', 'Forms\cTBLDSC@FillForm');
$router->get('testing', function () {
	$a = Test123("abc");
	$SqlStm = "
			Select 
			  P3PERD, P3EIIY, P3EMID, P3EMNM, P3EMNN, P3EMSX, P3BRPL, KOTADsc, P3BRDT, P3RACE, RACEDsc, P3RLGN, AGAMADsc
			, P3EDUC, EDUCDsc, P3STAT, STATUSDsc, P3RESP, P3IDNO, P3IDNM, P3TELP, P3EADD, P3NTNL, P3BLOD
			, P3NOSK, P3INDT, P3WRST, P3COIY, P3WRIY, P3DIIY, P3SDIY, P3DEIY, P3SEIY, P3SSIY, P3PAIY, P3TIIY, P3LEIY, P3PSIY
			, M1CONO, M1NAME, M1SKTN, M1IDCD
			, M7WRLO, M7NAME, M7SKTN, M7IDCD, M7ADD1, M7ADD2
			, M2DIVI, M2NAME, M2SKTN, M2IDCD
			, M3DEPT, M3NAME, M3SKTN, M3IDCD
			, M4SECT, M4NAME, M4SKTN, M4IDCD
			, M5TITL, M5NAME, M5SKTN, M5IDCD
			, M6LEVL, M6NAME, M6SKTN, M6IDCD
			, M8SUBS, M8NAME, M8SKTN, M8IDCD
			, M9PART, M9NAME, M9SKTN, M9IDCD
			, M0SUBD, M0NAME, M0SKTN, M0IDCD
			, MPPSCD, MPNAME, MPSKTN, MPIDCD
			, P3REMK, P3DPFG, P3QUIT, P3BPJS, BPJSDsc
			, P3NPWP, P3NPNM, P3NPAD, P3PTKP, PPVALU PTKPDsc, P3HARI, P3JSTK, P3JSNO, P3JSLK, LOKJMSDsc, P3GPDT, GPDTDsc, P3KLGJ, KLGJDsc
			, P3GRUP, GRUPDsc, P3ACCT, ACCTDsc, P3LINE, LINEDsc 
			, P3GROS, GROSDsc, P3BANK, BANKDsc, P3BNAC, P3BNNM
			, P1P1IY, P1PERD, Cast(P1BSSL As Dec(20,0)) P1BSSL, Cast(P1RPSL As Dec(20,0)) P1RPSL, Cast(P1TLSL As Dec(20,0)) P1TLSL                                            
			, Cast(P1FNSL As Dec(20,0)) P1FNSL, Cast(P1CSSL As Dec(20,0)) P1CSSL, Cast(P1TRSL As Dec(20,0)) P1TRSL, Cast(P1LAIN As Dec(20,0)) P1LAIN
			, P1BSSL+P1RPSL+P1TLSL+P1FNSL+P1CSSL+P1TRSL+P1LAIN P1GAJI
			, Cast(P1PPH1 As Dec(20,0)) P1PPH1, Cast(P1JMS1 As Dec(20,0)) P1JMS1, Cast(P1BPJ1 As Dec(20,0)) P1BPJ1, Cast(P1BJAB As Dec(20,0)) P1BJAB, Cast(P1PTKP As Dec(20,0)) P1PTKP
			, Cast(P1TG01 As Dec(20,0)) P1TG01, Cast(P1TG21 As Dec(20,0)) P1TG21, Cast(P1TG22 As Dec(20,0)) P1TG22, Cast(P1TG23 As Dec(20,0)) P1TG23, Cast(P1TG24 As Dec(20,0)) P1TG24
			, Cast(P1BRUT As Dec(20,0)) P1BRUT, Cast(P1PPH2 As Dec(20,0)) P1PPH2, Cast(P1TSPP As Dec(20,0)) P1TSPP 
			, Cast(P1TPT1 As Dec(20,0)) P1TPT1, Cast(P1TPT2 As Dec(20,0)) P1TPT2, Cast(P1TPJ1 As Dec(20,0)) P1TPJ1, Cast(P1TPJ2 As Dec(20,0)) P1TPJ2, Cast(P1TPB1 As Dec(20,0)) P1TPB1, Cast(P1TPB2 As Dec(20,0)) P1TPB2, Cast(P1TPOT As Dec(20,0)) P1TPOT
			, Cast(P1TOTL As Dec(20,0)) P1TOTL, Cast(P1THPY As Dec(20,0)) P1THPY, Cast(P1GUMK As Dec(20,0)) P1GUMK, Cast(P1THRT As Dec(20,0)) P1THRT, Cast(P1THRP As Dec(20,0)) P1THRP
			, Cast(P1JST1 As Dec(20,0)) P1JST1
			--, Cast(P1JST2 As Dec(20,0)) P1JST2
			, Cast(P1JST2 As Dec(20,0)) + Cast(P1JMS1 As Dec(20,0)) - (Cast(P1JST1 As Dec(20,0)) + Cast(P1JST2 As Dec(20,0)) + Cast(P1JST3 As Dec(20,0))) [P1JST2]
			, Cast(P1JST3 As Dec(20,0)) P1JST3
			, P1REMK, P1DPFG
			, P1RGDT, P1RGID, P1CHDT, P1CHID, P1CHNO, P1DLFG
			, P3RGDT, P3RGID, P3CHDT, P3CHID, P3CHNO
			, P3REIY, MRCOIY, MRBANK,  MRREKN, MRTRAN
			, Cast(THTHRB As Dec(20,0)) THTHRB, Cast(THTHRK As Dec(20,0)) THTHRK, Cast(THTHRT As Dec(20,0)) THTHRT
			, Cast(P1PNS1 As Dec(20,0)) P1PNS1, Cast(P1TPP1 As Dec(20,0)) P1TPP1, Cast(P1TPP2 As Dec(20,0)) P1TPP2
			, Cast(IsNull(P1INST,0) As Dec(20,0)) P1INST
			--, Cast(Case When P3GROS = '1' Then P1BRUT-IsNull(P1INST,0)-P1THRP Else P1BRUT-IsNull(P1INST,0) End  As Dec(20,0)) [P1BRUT_1]
			--, Cast(Case When P3GROS = '1' Then IsNull(P1INST,0)+IsNull(P1THRT,0)+P1THRP Else IsNull(P1INST,0)+IsNull(P1THRT,2) End  As Dec(20,0)) [P1BRUT_2]
			, Cast(Case When P3GROS = '1' Then Cast(P1BRUT As Dec(20,0))-Cast(IsNull(P1INST,0) As Dec(20,0))-Cast(P1THRP As Dec(20,0)) 
			                              Else Cast(P1BRUT As Dec(20,0))-Cast(IsNull(P1INST,0) As Dec(20,0)) End  As Dec(20,0)) [P1BRUT_1]
			, Cast(Case When P3GROS = '1' Then Cast(IsNull(P1INST,0) As Dec(20,0))+Cast(IsNull(P1THRT,0) As Dec(20,0))+Cast(P1THRP As Dec(20,0)) 
			                              Else Cast(IsNull(P1INST,0) As Dec(20,0))+Cast(IsNull(P1THRT,2) As Dec(20,0)) End  As Dec(20,0)) [P1BRUT_2]
			--, Cast(Case When P3GROS = '1' Then P1PPH1-IsNull(P1THRP,0) Else P1PPH1 End  As Dec(20,0)) P1PPH1_1
			, Cast(Case When P3GROS = '1' Then Cast(P1PPH1 As Dec(20,0))-Cast(IsNull(P1THRP,0) As Dec(20,0)) Else Cast(P1PPH1 As Dec(20,0)) End  As Dec(20,0)) P1PPH1_1

			, Cast(Case When P3GROS = '1' Then IsNull(P1THRP,0) Else 0 End  As Dec(20,0)) P1PPH1_2
			--, Cast(Case When P3GROS = '1' Then P1PPH2+IsNull(P1THRP,0)  Else (P1PPH2+IsNull(P1THRP,0))  End  As Dec(20,0)) P1PPH2_2
			, Cast(Case When P3GROS = '1' Then Cast(P1PPH2 As Dec(20,0))+Cast(IsNull(P1THRP,0) As Dec(20,0))  Else (Cast(P1PPH2 As Dec(20,0))+Cast(IsNull(P1THRP,0) As Dec(20,0)))  End  As Dec(20,0)) P1PPH2_2

			--, Cast(P1BRUT+IsNull(P1THRT,0)  As Dec(20,0)) P1BRUT_3
			, Cast(Cast(P1BRUT As Dec(20,0))+Cast(IsNull(P1THRT,0) As Dec(20,0))  As Dec(20,0)) P1BRUT_3

			--, Cast(P1TSPP+IsNull(P1THRT,0)  As Dec(20,0)) P1TSPP_2
			, ( Cast(Cast(P1BRUT As Dec(20,0))+Cast(IsNull(P1THRT,0) As Dec(20,0))  As Dec(20,0)) )
			  + ( Cast(Case When P3GROS = '1' Then Cast(P1PPH2 As Dec(20,0))+Cast(IsNull(P1THRP,0) As Dec(20,0))  Else (Cast(P1PPH2 As Dec(20,0))+Cast(IsNull(P1THRP,0) As Dec(20,0)))  End  As Dec(20,0)) )
			  - Cast(P1THRP As Dec(20,0)) [P1TSPP_2]

			, Cast(-1*IsNull(THTHRT,0)  As Dec(20,0)) THTHRT_2

			From GJPAY3
			Left Join MMCONO On M1COIY = P3COIY
			Left Join MMWRLO On M7WRIY = P3WRIY
			Left Join MMDIVI On M2DIIY = P3DIIY
			Left Join MMSUBD On M0SDIY = P3SDIY
			Left Join MMDEPT On M3DEIY = P3DEIY
			Left Join MMSECT On M4SEIY = P3SEIY
			Left Join MMSUBS On M8SSIY = P3SSIY
			Left Join MMTITL On M5TIIY = P3TIIY
			Left Join MMLEVL On M6LEIY = P3LEIY
			Left Join MMPART On M9PAIY = P3PAIY
			Left Join MMPOST On MPPSIY = P3PSIY
			Left Join (Select Cod KOTACod, Dsc KOTADsc From TBLSYS Where TAB = 'KOTA') KOTA On KOTACod = P3BRPL
			Left Join (Select Cod AGAMACod, Dsc AGAMADsc From TBLSYS Where TAB = 'AGAMA') AGAMA On AGAMACod = P3RLGN
			Left Join (Select Cod RACECod, Dsc RACEDsc From TBLSYS Where TAB = 'RACE') RACE On RACECod = P3RACE
			Left Join (Select Cod STATUSCod, Dsc STATUSDsc From TBLSYS Where TAB = 'STATUS') STATUS On STATUSCod = P3STAT
			Left Join (Select Cod EDUCCod, Dsc EDUCDsc From TBLSYS Where TAB = 'EDUC') EDUC On EDUCCod = P3EDUC
			Left Join (Select Cod LOKJMSCod, Dsc LOKJMSDsc From TBLSYS Where TAB = 'LOKJMS') LOKJMS On LOKJMSCod = P3JSLK
			Left Join (Select Cod ACCTCod, Dsc ACCTDsc From TBLSYS Where TAB = 'BIAYA') ACCT On ACCTCod = P3ACCT
			Left Join (Select Cod LINECod, Dsc LINEDsc From TBLSYS Where TAB = 'LINE') LINE On LINECod = P3LINE
			Left Join (Select Cod GPDTCod, Dsc GPDTDsc From TBLSYS Where TAB = 'GPDT') GPDT On GPDTCod = P3GPDT
			Left Join (Select Cod KLGJCod, Dsc KLGJDsc From TBLSYS Where TAB = 'KLGJ') KLGJ On KLGJCod = P3KLGJ
			Left Join (Select Cod GRUPCod, Dsc GRUPDsc From TBLSYS Where TAB = 'GRUP') GRUP On GRUPCod = P3GRUP
			Left Join (Select Cod BANKCod, Dsc BANKDsc From TBLSYS Where TAB = 'BANK') BANK On BANKCod = P3BANK
			Left Join (Select Cod GROSCod, Dsc GROSDsc From TBLSYS Where TAB = 'YESNO') GROS On GROSCod = P3GROS
			Left Join (Select Cod BPJSCod, Dsc BPJSDsc From TBLSYS Where TAB = 'BPJS') BPJS On BPJSCod = P3BPJS
			Left Join PPHPRM On PPCATG = 'PTKP' And PPCODE = P3PTKP
			Left Join GJPAY1 On P1P1IY = P3P1IY
			Left Join MMREKN On MRREIY = P3REIY
			Left Join GJTHR1 On THEIIY = P1EIIY And THPERD = P1PERD

	";
	$SqlStm = "Select * From MitMas";
	$a = fnEnCrypt($SqlStm);
	// echo "<br>".base64_encode($a)."<br>";

	$b = fnDeCrypt($a);
    return 'Hallo Wili <br>'.$a."<br>".$b;
});
