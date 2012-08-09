//
// win_06.js
//

// !------- IMPLEMENTATION

//-- Window Local Variable
var win = Ti.UI.currentWindow;

// Sets the main Background Image
Ti.UI.setBackgroundImage('images/main_bg.png');

//-- Includes
Ti.include('includes/globals.js');

//-- Info of regions
var regInfo = [];

//-- Response Window
Ti.API.info('Window: '+win.url);


//-- Top View
var topView = Ti.UI.createView({
	width: 800,
	height: 481,
	top: 150,
	left: 112,
	opacity: 0
});
win.add(topView);

	//-- Question View
	var questionView = Ti.UI.createView({
		width: 800,
		height: 'auto',
		top: 0
	});
	topView.add(questionView);

		//--Top Border
		var topBorder = Ti.UI.createView({
			width: 800,
			height: 1,
			top: 0,
			backgroundImage: '../images/question_border.png'
		});
		questionView.add(topBorder);
		
		//--Bottom Border
		var bottomBorder = Ti.UI.createView({
			width: 800,
			height: 1,
			bottom: 0,
			backgroundImage: '../images/question_border.png'
		});
		questionView.add(bottomBorder);
		
		//-- Question Text
		var question_text = Ti.UI.createLabel({
			text: 'Em qual regi\343o voc\352 procura?',
			font: {
				fontSize: 40,
				fontFamily: 'Georgia'
			},
			color: darkGray,
			width: 'auto',
			height: 'auto',
			top: 50,
			left: 40
		});
		questionView.add(question_text);
		
		//-- Question Sub
		var question_sub = Ti.UI.createLabel({
			text: '(Voc\352 pode escolher mais de uma op\347\343o)',
			font: {
				fontSize: 20,
				fontFamily: 'Georgia',
				fontStyle: 'italic'
			},
			color: blue,
			width: 'auto',
			height: 'auto',
			top: 100,
			left: 40
		});
		questionView.add(question_sub);
		
		//-- aCheck
		var aCheck = Ti.UI.createView({
			width: 35,
			height: 35,
			top: 30+question_text.height+20,
			left: 40,
			backgroundImage: '../images/normal_Slt.png',
			selected: false,
			label: 'Norte - SP'
		});
		questionView.add(aCheck);
		
		//-- aLabel
		var aLabel = Ti.UI.createLabel({
			text: 'Norte - SP',
			font: {
				fontSize: item,
				fontFamily: 'Georgia'
			},
			color: darkGray,
			width: 'auto',
			height: 'auto',
			top: 30+question_text.height+20,
			left: 40+aCheck.width+20
		});
		questionView.add(aLabel);
		
		//-- bCheck
		var bCheck = Ti.UI.createView({
			width: 35,
			height: 35,
			top: 30+question_text.height+20+aLabel.height+15,
			left: 40,
			backgroundImage: '../images/normal_Slt.png',
			selected: false,
			label: 'Sul - SP'
		});
		questionView.add(bCheck);
		
		//-- bLabel
		var bLabel = Ti.UI.createLabel({
			text: 'Sul - SP',
			font: {
				fontSize: item,
				fontFamily: 'Georgia'
			},
			color: darkGray,
			width: 'auto',
			height: 'auto',
			top: 30+question_text.height+20+aLabel.height+15,
			left: 40+bCheck.width+20
		});
		questionView.add(bLabel);
		
		//-- cCheck
		var cCheck = Ti.UI.createView({
			width: 35,
			height: 35,
			top: 30+question_text.height+20+aLabel.height+15+bLabel.height+15,
			left: 40,
			backgroundImage: '../images/normal_Slt.png',
			selected: false,
			label: 'Leste - SP'
		});
		questionView.add(cCheck);
		
		//-- cLabel
		var cLabel = Ti.UI.createLabel({
			text: 'Leste - SP',
			font: {
				fontSize: item,
				fontFamily: 'Georgia'
			},
			color: darkGray,
			width: 'auto',
			height: 'auto',
			top: 30+question_text.height+20+aLabel.height+15+bLabel.height+15,
			left: 40+cCheck.width+20
		});
		questionView.add(cLabel);
		
		//-- dCheck
		var dCheck = Ti.UI.createView({
			width: 35,
			height: 35,
			top: 30+question_text.height+20+aLabel.height+15+bLabel.height+15+cLabel.height+15,
			left: 40,
			backgroundImage: '../images/normal_Slt.png',
			selected: false,
			label: 'Oeste - SP'
		});
		questionView.add(dCheck);
		
		//-- dLabel
		var dLabel = Ti.UI.createLabel({
			text: 'Oeste - SP',
			font: {
				fontSize: item,
				fontFamily: 'Georgia'
			},
			color: darkGray,
			width: 'auto',
			height: 'auto',
			top: 30+question_text.height+20+aLabel.height+15+bLabel.height+15+cLabel.height+15,
			left: 40+dCheck.width+20,
			bottom: 60
		});
		questionView.add(dLabel);
		
		//-- eCheck
		var eCheck = Ti.UI.createView({
			width: 35,
			height: 35,
			top: 30+question_text.height+20,
			left: 420,
			backgroundImage: '../images/normal_Slt.png',
			selected: false,
			label: 'S\343o Bernardo'
		});
		questionView.add(eCheck);
		
		//-- eLabel
		var eLabel = Ti.UI.createLabel({
			text: 'S\343o Bernardo',
			font: {
				fontSize: item,
				fontFamily: 'Georgia'
			},
			color: darkGray,
			width: 'auto',
			height: 'auto',
			top: 30+question_text.height+20,
			left: 420+eCheck.width+20
		});
		questionView.add(eLabel);
		
		//-- fCheck
		var fCheck = Ti.UI.createView({
			width: 35,
			height: 35,
			top: 30+question_text.height+20+eLabel.height+15, 
			left: 420,
			backgroundImage: '../images/normal_Slt.png',
			selected: false,
			label: 'S\343o Caetano)'
		});
		questionView.add(fCheck);
		
		//-- fLabel
		var fLabel = Ti.UI.createLabel({
			text: 'S\343o Caetano',
			font: {
				fontSize: item,
				fontFamily: 'Georgia'
			},
			color: darkGray,
			width: 'auto',
			height: 'auto',
			top: 30+question_text.height+20+eLabel.height+15,
			left: 420+fCheck.width+20
		});
		questionView.add(fLabel);
		
		//-- gCheck
		var gCheck = Ti.UI.createView({
			width: 35,
			height: 35,
			top: 30+question_text.height+20+eLabel.height+15+fLabel.height+15,
			left: 420,
			backgroundImage: '../images/normal_Slt.png',
			selected: false,
			label: 'Diadema'
		});
		questionView.add(gCheck);
		
		//-- gLabel
		var gLabel = Ti.UI.createLabel({
			text: 'Diadema',
			font: {
				fontSize: item,
				fontFamily: 'Georgia'
			},
			color: darkGray,
			width: 'auto',
			height: 'auto',
			top: 30+question_text.height+20+aLabel.height+15+fLabel.height+15,
			left: 420+gCheck.width+20
		});
		questionView.add(gLabel);
		
		//-- hCheck
		var hCheck = Ti.UI.createView({
			width: 35,
			height: 35,
			top: 30+question_text.height+20+eLabel.height+15+fLabel.height+15+gLabel.height+15,
			left: 420,
			backgroundImage: '../images/normal_Slt.png',
			selected: false,
			label: 'Todas as regi\365es'
		});
		questionView.add(hCheck);
		
		//-- hLabel
		var hLabel = Ti.UI.createLabel({
			text: 'Todas as regi\365es',
			font: {
				fontSize: item,
				fontFamily: 'Georgia',
				fontStyle: 'italic'
			},
			color: darkGray,
			width: 'auto',
			height: 'auto',
			top: 30+question_text.height+20+eLabel.height+15+fLabel.height+15+gLabel.height+15,
			left: 420+hCheck.width+20,
			bottom: 60
		});
		questionView.add(hLabel);
		
		
		//-- Button View
		var buttonView = Ti.UI.createView({
			width: 310,
			height: 'auto',
			top: questionView.height+30
		});
		topView.add(buttonView);
		
			//-- Voltar Button
			var voltar_btn = Ti.UI.createButton({
				width: 150,
				height: 60,
				top: 0,
				left: 0,
				backgroundImage: '../images/voltar_Btn.png'
			});
			buttonView.add(voltar_btn);
			
			//-- Avancar Button
			var avancar_btn = Ti.UI.createButton({
				width: 150,
				height: 60,
				top: 0,
				right: 0,
				backgroundImage: '../images/avancar_Btn.png',
				backgroundDisabledImage: '../images/avancarDesat_Btn.png',
				enabled: false
			});
			buttonView.add(avancar_btn);
	
//-- Bottom View
var bottomView = Ti.UI.createView({
	width: 964,
	height: 94,
	bottom: 0,
	opacity: 0
});
win.add(bottomView);

	// !-- Icon bar
	var iconBar = Ti.UI.createView({
		width: 794,
		height: 94,
		left: 0,
		backgroundImage: '../images/iconBar/win_CPF-iconBar.png'
	});
	bottomView.add(iconBar);
	
	//-- Progress bar
	var progressBar = Ti.UI.createView({
		width: 170,
		height: 94,
		right: 0
	});
	bottomView.add(progressBar);

		//-- Status Label
		var statusLabel = Ti.UI.createLabel({
			text: '7',
			font: {
				fontSize: 50,
				fontFamily: 'Georgia'
			},
			color: yellow,
			textAlign: 'right',
			shadowColor: black,
			shadowOffset: {x:1,y:1},
			width: 'auto',
			height: 'auto',
			right: statusNumberRight
		});
		progressBar.add(statusLabel);


// !------- METHODS

//-- Intro Animation
topView.animate({
	opacity: 1,
	duration: 500
});

bottomView.animate({
	opacity: 1,
	duration: 1000
});


//-- aCheck Event
aCheck.addEventListener('singletap', function() {
	if(aCheck.selected)
	{
		aCheck.selected = false;
		hCheck.selected = false;
		
		aCheck.backgroundImage = '../images/normal_Slt.png';
		hCheck.backgroundImage = '../images/normal_Slt.png';
		
		if (aCheck.selected && bCheck.selected && cCheck.selected && dCheck.selected && eCheck.selected && fCheck.selected && gCheck.selected)
		{
			hCheck.selected = true;
			hCheck.backgroundImage = '../images/selected_Slt.png';
			
			regInfo.splice(0,1);
			Ti.API.info('REGIAO: '+regInfo);
		}
	
		regInfo.pop(aCheck.label);
		Ti.API.info('REGIAO: '+regInfo);
	}
	else
	{
		aCheck.selected = true;
		aCheck.backgroundImage = '../images/selected_Slt.png';
		
		regInfo.push(aLabel.text);
		Ti.API.info('REGIAO: '+regInfo);
	}
	
	if (aCheck.selected || bCheck.selected || cCheck.selected || dCheck.selected || eCheck.selected || fCheck.selected || gCheck.selected || hCheck.selected)
	{
		avancar_btn.backgroundImage = '../images/avancar_Btn.png';
		avancar_btn.enabled = true;
	}
	
	if (aCheck.selected && bCheck.selected && cCheck.selected && dCheck.selected && eCheck.selected && fCheck.selected && gCheck.selected)
	{
		hCheck.selected = true;
		hCheck.backgroundImage = '../images/selected_Slt.png';
	}
	
	else
	{
		avancar_btn.backgroundImage = '../images/avancarDesat_Btn.png';
		avancar_btn.enabled = false;
	}
});

//-- bCheck Event
bCheck.addEventListener('singletap', function() {
	if(bCheck.selected)
	{
		bCheck.selected = false;
		hCheck.selected = false;
		
		bCheck.backgroundImage = '../images/normal_Slt.png';
		hCheck.backgroundImage = '../images/normal_Slt.png';
		
		if (aCheck.selected && bCheck.selected && cCheck.selected && dCheck.selected && eCheck.selected && fCheck.selected && gCheck.selected)
		{
			hCheck.selected = true;
			hCheck.backgroundImage = '../images/selected_Slt.png';
			
			regInfo.splice(1,1);
			Ti.API.info('REGIAO: '+regInfo);
		}
	
		regInfo.pop(bCheck.label);
		Ti.API.info('REGIAO: '+regInfo);
	}
	else
	{
		bCheck.selected = true;
		bCheck.backgroundImage = '../images/selected_Slt.png';
		
		regInfo.push(bLabel.text);
		Ti.API.info('REGIAO: '+regInfo);
	}
	
	if (aCheck.selected && bCheck.selected && cCheck.selected && dCheck.selected && eCheck.selected && fCheck.selected && gCheck.selected)
	{
		hCheck.selected = true;
		hCheck.backgroundImage = '../images/selected_Slt.png';
	}
	
	if (aCheck.selected || bCheck.selected || cCheck.selected || dCheck.selected || eCheck.selected || fCheck.selected || gCheck.selected || hCheck.selected)
	{
		avancar_btn.backgroundImage = '../images/avancar_Btn.png';
		avancar_btn.enabled = true;
	}
	
	else
	{
		avancar_btn.backgroundImage = '../images/avancarDesat_Btn.png';
		avancar_btn.enabled = false;
	}
});

//-- cCheck Event
cCheck.addEventListener('singletap', function() {
	if(cCheck.selected)
	{
		cCheck.selected = false;
		hCheck.selected = false;
		
		cCheck.backgroundImage = '../images/normal_Slt.png';
		hCheck.backgroundImage = '../images/normal_Slt.png';
		
		if (aCheck.selected && bCheck.selected && cCheck.selected && dCheck.selected && eCheck.selected && fCheck.selected && gCheck.selected)
		{
			hCheck.selected = true;
			hCheck.backgroundImage = '../images/selected_Slt.png';
			
			regInfo.splice(2,1);
			Ti.API.info('REGIAO: '+regInfo);
		}
	
		regInfo.pop(cCheck.label);
		Ti.API.info('REGIAO: '+regInfo);
	}
	else
	{
		cCheck.selected = true;
		cCheck.backgroundImage = '../images/selected_Slt.png';
		
		regInfo.push(cLabel.text);
		Ti.API.info('REGIAO: '+regInfo);
	}
	
	if (aCheck.selected && bCheck.selected && cCheck.selected && dCheck.selected && eCheck.selected && fCheck.selected && gCheck.selected)
	{
		hCheck.selected = true;
		hCheck.backgroundImage = '../images/selected_Slt.png';
	}
	
	if (aCheck.selected || bCheck.selected || cCheck.selected || dCheck.selected || eCheck.selected || fCheck.selected || gCheck.selected || hCheck.selected)
	{
		avancar_btn.backgroundImage = '../images/avancar_Btn.png';
		avancar_btn.enabled = true;
	}
	
	else
	{
		avancar_btn.backgroundImage = '../images/avancarDesat_Btn.png';
		avancar_btn.enabled = false;
	}
});

//-- dCheck Event
dCheck.addEventListener('singletap', function() {
	if(dCheck.selected)
	{
		dCheck.selected = false;
		hCheck.selected = false;
		
		dCheck.backgroundImage = '../images/normal_Slt.png';
		hCheck.backgroundImage = '../images/normal_Slt.png';
		
		if (aCheck.selected && bCheck.selected && cCheck.selected && dCheck.selected && eCheck.selected && fCheck.selected && gCheck.selected)
		{
			hCheck.selected = true;
			hCheck.backgroundImage = '../images/selected_Slt.png';
			
			regInfo.splice(3,1);
			Ti.API.info('REGIAO: '+regInfo);
		}
	
		regInfo.pop(dCheck.label);
		Ti.API.info('REGIAO: '+regInfo);
	}
	else
	{
		dCheck.selected = true;
		dCheck.backgroundImage = '../images/selected_Slt.png';
		
		regInfo.push(dLabel.text);
		Ti.API.info('REGIAO: '+regInfo);
	}
	
	if (aCheck.selected && bCheck.selected && cCheck.selected && dCheck.selected && eCheck.selected && fCheck.selected && gCheck.selected)
	{
		hCheck.selected = true;
		hCheck.backgroundImage = '../images/selected_Slt.png';
	}
	
	if (aCheck.selected || bCheck.selected || cCheck.selected || dCheck.selected || eCheck.selected || fCheck.selected || gCheck.selected || hCheck.selected)
	{
		avancar_btn.backgroundImage = '../images/avancar_Btn.png';
		avancar_btn.enabled = true;
	}
	
	else
	{
		avancar_btn.backgroundImage = '../images/avancarDesat_Btn.png';
		avancar_btn.enabled = false;
	}
});

//-- eCheck Event
eCheck.addEventListener('singletap', function() {
	if(eCheck.selected)
	{
		eCheck.selected = false;
		hCheck.selected = false;
		
		eCheck.backgroundImage = '../images/normal_Slt.png';
		hCheck.backgroundImage = '../images/normal_Slt.png';
		
		if (aCheck.selected && bCheck.selected && cCheck.selected && dCheck.selected && eCheck.selected && fCheck.selected && gCheck.selected)
		{
			hCheck.selected = true;
			hCheck.backgroundImage = '../images/selected_Slt.png';
			
			regInfo.splice(4,1);
			Ti.API.info('REGIAO: '+regInfo);
		}
	
		regInfo.pop(eCheck.label);
		Ti.API.info('REGIAO: '+regInfo);
	}
	else
	{
		eCheck.selected = true;
		eCheck.backgroundImage = '../images/selected_Slt.png';
		
		regInfo.push(eLabel.text);
		Ti.API.info('REGIAO: '+regInfo);
	}
	
	if (aCheck.selected && bCheck.selected && cCheck.selected && dCheck.selected && eCheck.selected && fCheck.selected && gCheck.selected)
	{
		hCheck.selected = true;
		hCheck.backgroundImage = '../images/selected_Slt.png';
	}
	
	if (aCheck.selected || bCheck.selected || cCheck.selected || dCheck.selected || eCheck.selected || fCheck.selected || gCheck.selected || hCheck.selected)
	{
		avancar_btn.backgroundImage = '../images/avancar_Btn.png';
		avancar_btn.enabled = true;
	}
	
	else
	{
		avancar_btn.backgroundImage = '../images/avancarDesat_Btn.png';
		avancar_btn.enabled = false;
	}
});

//-- fCheck Event
fCheck.addEventListener('singletap', function() {
	if(fCheck.selected)
	{
		fCheck.selected = false;
		hCheck.selected = false;
		
		fCheck.backgroundImage = '../images/normal_Slt.png';
		hCheck.backgroundImage = '../images/normal_Slt.png';
		
		if (aCheck.selected && bCheck.selected && cCheck.selected && dCheck.selected && eCheck.selected && fCheck.selected && gCheck.selected)
		{
			hCheck.selected = true;
			hCheck.backgroundImage = '../images/selected_Slt.png';
			
			regInfo.splice(5,1);
			Ti.API.info('REGIAO: '+regInfo);
		}
	
		regInfo.pop(fCheck.label);
		Ti.API.info('REGIAO: '+regInfo);
	}
	else
	{
		fCheck.selected = true;
		fCheck.backgroundImage = '../images/selected_Slt.png';
		
		regInfo.push(fLabel.text);
		Ti.API.info('REGIAO: '+regInfo);
	}
	
	if (aCheck.selected && bCheck.selected && cCheck.selected && dCheck.selected && eCheck.selected && fCheck.selected && gCheck.selected)
	{
		hCheck.selected = true;
		hCheck.backgroundImage = '../images/selected_Slt.png';
	}
	
	if (aCheck.selected || bCheck.selected || cCheck.selected || dCheck.selected || eCheck.selected || fCheck.selected || gCheck.selected || hCheck.selected)
	{
		avancar_btn.backgroundImage = '../images/avancar_Btn.png';
		avancar_btn.enabled = true;
	}
	
	else
	{
		avancar_btn.backgroundImage = '../images/avancarDesat_Btn.png';
		avancar_btn.enabled = false;
	}
});

//-- gCheck Event
gCheck.addEventListener('singletap', function() {
	if(gCheck.selected)
	{
		gCheck.selected = false;
		hCheck.selected = false;
		
		gCheck.backgroundImage = '../images/normal_Slt.png';
		hCheck.backgroundImage = '../images/normal_Slt.png';
		
		if (aCheck.selected && bCheck.selected && cCheck.selected && dCheck.selected && eCheck.selected && fCheck.selected && gCheck.selected)
		{
			hCheck.selected = true;
			hCheck.backgroundImage = '../images/selected_Slt.png';
			
			regInfo.splice(6,1);
			Ti.API.info('REGIAO: '+regInfo);
		}
	
		regInfo.pop(gCheck.label);
		Ti.API.info('REGIAO: '+regInfo);
	}
	else
	{
		gCheck.selected = true;
		gCheck.backgroundImage = '../images/selected_Slt.png';
		
		regInfo.push(gLabel.text);
		Ti.API.info('REGIAO: '+regInfo);
	}
	
	if (aCheck.selected && bCheck.selected && cCheck.selected && dCheck.selected && eCheck.selected && fCheck.selected && gCheck.selected)
	{
		hCheck.selected = true;
		hCheck.backgroundImage = '../images/selected_Slt.png';
	}
	
	if (aCheck.selected || bCheck.selected || cCheck.selected || dCheck.selected || eCheck.selected || fCheck.selected || gCheck.selected || hCheck.selected)
	{
		avancar_btn.backgroundImage = '../images/avancar_Btn.png';
		avancar_btn.enabled = true;
	}
	
	else
	{
		avancar_btn.backgroundImage = '../images/avancarDesat_Btn.png';
		avancar_btn.enabled = false;
	}
});

//-- hCheck Event
hCheck.addEventListener('singletap', function() {
	if(hCheck.selected)
	{
		aCheck.selected = false;
		bCheck.selected = false;
		cCheck.selected = false;
		dCheck.selected = false;
		eCheck.selected = false;
		fCheck.selected = false;
		gCheck.selected = false;
		hCheck.selected = false;
		
		aCheck.backgroundImage = '../images/normal_Slt.png';
		bCheck.backgroundImage = '../images/normal_Slt.png';
		cCheck.backgroundImage = '../images/normal_Slt.png';
		dCheck.backgroundImage = '../images/normal_Slt.png';
		eCheck.backgroundImage = '../images/normal_Slt.png';
		fCheck.backgroundImage = '../images/normal_Slt.png';
		gCheck.backgroundImage = '../images/normal_Slt.png';
		hCheck.backgroundImage = '../images/normal_Slt.png';
		
		regInfo = [];
		Ti.API.info('REGIAO: '+regInfo);
	}
	else
	{
		aCheck.selected = true;
		bCheck.selected = true;
		cCheck.selected = true;
		dCheck.selected = true;
		eCheck.selected = true;
		fCheck.selected = true;
		gCheck.selected = true;
		hCheck.selected = true;
		
		aCheck.backgroundImage = '../images/selected_Slt.png';
		bCheck.backgroundImage = '../images/selected_Slt.png';
		cCheck.backgroundImage = '../images/selected_Slt.png';
		dCheck.backgroundImage = '../images/selected_Slt.png';
		eCheck.backgroundImage = '../images/selected_Slt.png';
		fCheck.backgroundImage = '../images/selected_Slt.png';
		gCheck.backgroundImage = '../images/selected_Slt.png';
		hCheck.backgroundImage = '../images/selected_Slt.png';
		
		regInfo.push(aLabel.text, bLabel.text, cLabel.text, dLabel.text, eLabel.text, fLabel.text, gLabel.text);
		Ti.API.info('REGIAO: '+regInfo);
	}
	
	if (aCheck.selected || bCheck.selected || cCheck.selected || dCheck.selected || eCheck.selected || fCheck.selected || gCheck.selected || hCheck.selected)
	{
		avancar_btn.backgroundImage = '../images/avancar_Btn.png';
		avancar_btn.enabled = true;
	}
	
	else
	{
		avancar_btn.backgroundImage = '../images/avancarDesat_Btn.png';
		avancar_btn.enabled = false;
	}
});



//-- Voltar Event Listener
voltar_btn.addEventListener('click', function(e) {

	topView.animate({
		opacity: 0,
		duration: 500
	});
	
	bottomView.animate({
		opacity: 0,
		duration: 500
	});
	
	Ti.App.fireEvent('win_05',{rg:win.rg, esc:win.esc, prof:win.prof, tempProcura:win.tempProcura, tipoImovel:win.tipoImovel});
	
});

//-- Avancar Event Listener
avancar_btn.addEventListener('click', function(e) {

	topView.animate({
		opacity: 0,
		duration: 500
	});
	
	bottomView.animate({
		opacity: 0,
		duration: 500
	});

	/*
if (aCheck.selected && bCheck.selected && cCheck.selected && dCheck.selected && eCheck.selected && fCheck.selected && gCheck.selected)
	{
	
	regInfo.push(aLabel.text, bLabel.text, cLabel.text, dLabel.text, eLabel.text, fLabel.text, gLabel.text);
	}
*/
	
	Ti.App.fireEvent('win_07',{rg:win.rg, esc:win.esc, prof:win.prof, tempProcura:win.tempProcura, tipoImovel:win.tipoImovel, qntDorm:win.qntDorm, regProcura:regInfo});

	/* Ti.API.info('REGIAO QUE PROCURA: '+regInfo); */
	

});