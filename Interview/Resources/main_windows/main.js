//
// main.js
//

// !------- IMPLEMENTATION

//-- Window Local Variable
var win = Ti.UI.currentWindow;

//-- Includes
Ti.include('includes/globals.js');

//-- Create the sub windows
var win_RG = Ti.UI.createWindow();
var win_00 = Ti.UI.createWindow();
var win_AP = Ti.UI.createWindow();
var win_01 = Ti.UI.createWindow();
var win_02 = Ti.UI.createWindow();
var win_03 = Ti.UI.createWindow();
var win_04 = Ti.UI.createWindow();
var win_05 = Ti.UI.createWindow();
var win_06 = Ti.UI.createWindow();
var win_07 = Ti.UI.createWindow();
var win_08 = Ti.UI.createWindow();
var win_09 = Ti.UI.createWindow();
var win_10 = Ti.UI.createWindow();
var win_11 = Ti.UI.createWindow();
var win_12 = Ti.UI.createWindow();
var win_13 = Ti.UI.createWindow();
var win_14 = Ti.UI.createWindow();
var win_FIM = Ti.UI.createWindow();

// !------- METHODS

//-- Open win_RG
function openWin_RG(e)
{
	win_RG.url = 'win_RG.js';
	
	win_00.close();
	win_RG.open();
}

//-- Open win_00
function openWin_00(e)
{
	win_RG.close();
	win_01.close();
	
	win_00.url = 'win_00.js';
	win_00.rg = e.rg;
	
	win_00.open();
}

//-- Open win_AP
function openWin_AP(e)
{
	win_00.close();
	
	win_AP.url = 'win_AP.js';
	win_AP.rg = e.rg;
	
	win_AP.open();
}

//-- Open win_01
function openWin_01(e)
{
	win_00.close();
	win_AP.close();
	win_02.close();
	
	win_01.url = 'win_01.js';
	win_01.rg = e.rg;
	
	win_01.open();
}

//-- Open win_02
function openWin_02(e)
{
	win_01.close();
	win_03.close();
	
	win_02.url = 'win_02.js';
	win_02.rg = e.rg;
	win_02.esc = e.esc;
	
	win_02.open();
}

//-- Open win_03
function openWin_03(e)
{
	win_02.close();
	win_04.close();
	
	win_03.url = 'win_03.js';
	win_03.rg = e.rg;
	win_03.esc = e.esc;
	win_03.prof = e.prof;
	
	win_03.open();
}

//-- Open win_04
function openWin_04(e)
{
	win_03.close();
	win_05.close();
	
	win_04.url = 'win_04.js';
	win_04.rg = e.rg;
	win_04.esc = e.esc;
	win_04.prof = e.prof;
	win_04.tempProcura = e.tempProcura;
	
	win_04.open();
}

//-- Open win_05
function openWin_05(e)
{
	win_04.close();
	win_06.close();
	
	win_05.url = 'win_05.js';
	win_05.rg = e.rg;
	win_05.esc = e.esc;
	win_05.prof = e.prof;
	win_05.tempProcura = e.tempProcura;
	win_05.tipoImovel = e.tipoImovel;
	
	win_05.open();
}

//-- Open win_06
function openWin_06(e)
{
	win_05.close();
	win_07.close();
	
	win_06.url = 'win_06.js';
/*
	win_06.rg = e.rg;
	win_06.esc = e.esc;
	win_06.prof = e.prof;
	win_06.tempProcura = e.tempProcura;
	win_06.tipoImovel = e.tipoImovel;
	win_06.qntDorm = e.qntDorm;
*/
	
	win_06.open();
}

//-- Open win_07
function openWin_07(e)
{
	win_06.close();
	win_08.close();
	
	win_07.url = 'win_07.js';
	win_07.rg = e.rg;
	win_07.esc = e.esc;
	win_07.prof = e.prof;
	win_07.tempProcura = e.tempProcura;
	win_07.tipoImovel = e.tipoImovel;
	win_07.qntDorm = e.qntDorm;
	win_07.regProcura = e.regProcura;
	
	win_07.open();
}

//-- Open win_08
function openWin_08(e)
{
	win_07.close();
	win_09.close();
	
	win_08.url = 'win_08.js';
	win_08.rg = e.rg;
	win_08.esc = e.esc;
	win_08.prof = e.prof;
	win_08.tempProcura = e.tempProcura;
	win_08.tipoImovel = e.tipoImovel;
	win_08.qntDorm = e.qntDorm;
	win_08.regProcura = e.regProcura;
	win_08.rendaInd = e.rendaInd;
	
	win_08.open();
}

//-- Open win_09
function openWin_09(e)
{
	win_08.close();
	win_10.close();
	
	win_09.url = 'win_09.js';
	win_09.rg = e.rg;
	win_09.esc = e.esc;
	win_09.prof = e.prof;
	win_09.tempProcura = e.tempProcura;
	win_09.tipoImovel = e.tipoImovel;
	win_09.qntDorm = e.qntDorm;
	win_09.regProcura = e.regProcura;
	win_09.rendaInd = e.rendaInd;
	win_09.rendaFam = e.rendaFam;
	
	win_09.open();
}

//-- Open win_10
function openWin_10(e)
{
	win_09.close();
	win_11.close();
	win_12.close();
	
	win_10.url = 'win_10.js';
	win_10.rg = e.rg;
	win_10.esc = e.esc;
	win_10.prof = e.prof;
	win_10.tempProcura = e.tempProcura;
	win_10.tipoImovel = e.tipoImovel;
	win_10.qntDorm = e.qntDorm;
	win_10.regProcura = e.regProcura;
	win_10.rendaInd = e.rendaInd;
	win_10.rendaFam = e.rendaFam;
	win_10.fgts = e.fgts;
	
	win_10.open();
}

//-- Open win_11
function openWin_11(e)
{
	win_10.close();
	
	win_11.url = 'win_11.js';
	win_11.rg = e.rg;
	win_11.esc = e.esc;
	win_11.prof = e.prof;
	win_11.tempProcura = e.tempProcura;
	win_11.tipoImovel = e.tipoImovel;
	win_11.qntDorm = e.qntDorm;
	win_11.regProcura = e.regProcura;
	win_11.rendaInd = e.rendaInd;
	win_11.rendaFam = e.rendaFam;
	win_11.fgts = e.fgts;
	win_11.financ = e.financ;
	
	win_11.open();
}

//-- Open win_12
function openWin_12(e)
{
	win_10.close();
	win_11.close();
	win_13.close();

	if(e.tempFinanc)
	{
		win_12.tempFinanc = e.tempFinanc;
	}
	
	else
	{
		win_12.tempFinanc = '';
	}

	win_12.url = 'win_12.js';
	win_12.rg = e.rg;
	win_12.esc = e.esc;
	win_12.prof = e.prof;
	win_12.tempProcura = e.tempProcura;
	win_12.tipoImovel = e.tipoImovel;
	win_12.qntDorm = e.qntDorm;
	win_12.regProcura = e.regProcura;
	win_12.rendaInd = e.rendaInd;
	win_12.rendaFam = e.rendaFam;
	win_12.fgts = e.fgts;
	win_12.financ = e.financ;
	
	win_12.open();
}

//-- Open win_13
function openWin_13(e)
{
	win_12.close();
	win_14.close();
	
	win_13.url = 'win_13.js';
	win_13.rg = e.rg;
	win_13.esc = e.esc;
	win_13.prof = e.prof;
	win_13.tempProcura = e.tempProcura;
	win_13.tipoImovel = e.tipoImovel;
	win_13.qntDorm = e.qntDorm;
	win_13.regProcura = e.regProcura;
	win_13.rendaInd = e.rendaInd;
	win_13.rendaFam = e.rendaFam;
	win_13.fgts = e.fgts;
	win_13.financ = e.financ;
	win_13.tempFinanc = e.tempFinanc;
	win_13.pagarImovel = e.pagarImovel;
	
	win_13.open();
}

//-- Open win_14
function openWin_14(e)
{
	win_13.close();
	
	win_14.url = 'win_14.js';
	win_14.rg = e.rg;
	win_14.esc = e.esc;
	win_14.prof = e.prof;
	win_14.tempProcura = e.tempProcura;
	win_14.tipoImovel = e.tipoImovel;
	win_14.qntDorm = e.qntDorm;
	win_14.regProcura = e.regProcura;
	win_14.rendaInd = e.rendaInd;
	win_14.rendaFam = e.rendaFam;
	win_14.fgts = e.fgts;
	win_14.financ = e.financ;
	win_14.tempFinanc = e.tempFinanc;
	win_14.pagarImovel = e.pagarImovel;
	win_14.pagarPrestacao = e.pagarPrestacao;
	
	win_14.open();
}

//-- Open win_FIM
function openWin_FIM(e)
{
	win_14.close();
	
	win_FIM.url = 'win_FIM.js';
	win_FIM.rg = e.rg;
	win_FIM.esc = e.esc;
	win_FIM.prof = e.prof;
	win_FIM.tempProcura = e.tempProcura;
	win_FIM.tipoImovel = e.tipoImovel;
	win_FIM.qntDorm = e.qntDorm;
	win_FIM.regProcura = e.regProcura;
	win_FIM.rendaInd = e.rendaInd;
	win_FIM.rendaFam = e.rendaFam;
	win_FIM.fgts = e.fgts;
	win_FIM.financ = e.financ;
	win_FIM.tempFinanc = e.tempFinanc;
	win_FIM.pagarImovel = e.pagarImovel;
	win_FIM.pagarPrestacao = e.pagarPrestacao;
	win_FIM.sitImovel = e.sitImovel;
	
	win_FIM.open();
}


// -- Reset App after finish the interview
function resetApp()
{
	win_FIM.close();
	openWin_RG();
}


//-- Custom Events
Ti.App.addEventListener('win_RG',openWin_RG);
Ti.App.addEventListener('win_00',openWin_00);
Ti.App.addEventListener('win_AP',openWin_AP);
Ti.App.addEventListener('win_01',openWin_01);
Ti.App.addEventListener('win_02',openWin_02);
Ti.App.addEventListener('win_03',openWin_03);
Ti.App.addEventListener('win_04',openWin_04);
Ti.App.addEventListener('win_05',openWin_05);
Ti.App.addEventListener('win_06',openWin_06);
Ti.App.addEventListener('win_07',openWin_07);
Ti.App.addEventListener('win_08',openWin_08);
Ti.App.addEventListener('win_09',openWin_09);
Ti.App.addEventListener('win_10',openWin_10);
Ti.App.addEventListener('win_11',openWin_11);
Ti.App.addEventListener('win_12',openWin_12);
Ti.App.addEventListener('win_13',openWin_13);
Ti.App.addEventListener('win_14',openWin_14);
Ti.App.addEventListener('win_FIM',openWin_FIM);
Ti.App.addEventListener('resetApp',resetApp);


openWin_RG();