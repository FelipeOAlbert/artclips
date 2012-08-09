//
// win_02.js
//

// !------- IMPLEMENTATION

//-- Window Local Variable
var win = Ti.UI.currentWindow;

// Sets the main Background Image
Ti.UI.setBackgroundImage('images/main_bg.png');

//-- Includes
Ti.include('includes/globals.js');

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
			text: 'Qual sua atividade profissional?',
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
		
		//-- aCheck
		var aCheck = Ti.UI.createView({
			width: 35,
			height: 35,
			top: 30+question_text.height+20,
			left: 40,
			backgroundImage: '../images/radio_Btn.png',
			selected: false,
			label: 'Aposentado(a)'
		});
		questionView.add(aCheck);
		
		//-- aLabel
		var aLabel = Ti.UI.createLabel({
			text: 'Aposentado(a)',
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
			backgroundImage: '../images/radio_Btn.png',
			selected: false,
			label: 'Auton\364mo(a)'
		});
		questionView.add(bCheck);
		
		//-- bLabel
		var bLabel = Ti.UI.createLabel({
			text: 'Auton\364mo(a)',
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
			backgroundImage: '../images/radio_Btn.png',
			selected: false,
			label: 'Desempregado(a)'
		});
		questionView.add(cCheck);
		
		//-- cLabel
		var cLabel = Ti.UI.createLabel({
			text: 'Desempregado(a)',
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
			backgroundImage: '../images/radio_Btn.png',
			selected: false,
			label: 'Estudante'
		});
		questionView.add(dCheck);
		
		//-- dLabel
		var dLabel = Ti.UI.createLabel({
			text: 'Estudante',
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
			backgroundImage: '../images/radio_Btn.png',
			selected: false,
			label: 'Assalariado'
		});
		questionView.add(eCheck);
		
		//-- eLabel
		var eLabel = Ti.UI.createLabel({
			text: 'Assalariado',
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
			backgroundImage: '../images/radio_Btn.png',
			selected: false,
			label: 'Empres\xE1rio(a)'
		});
		questionView.add(fCheck);
		
		//-- fLabel
		var fLabel = Ti.UI.createLabel({
			text: 'Empres\xE1rio(a)',
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
			backgroundImage: '../images/radio_Btn.png',
			selected: false,
			label: 'Dona de Casa'
		});
		questionView.add(gCheck);
		
		//-- gLabel
		var gLabel = Ti.UI.createLabel({
			text: 'Dona de Casa',
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
			backgroundImage: '../images/radio_Btn.png',
			selected: false,
			label: 'Profissional Liberal'
		});
		questionView.add(hCheck);
		
		//-- hLabel
		var hLabel = Ti.UI.createLabel({
			text: 'Profissional Liberal',
			font: {
				fontSize: item,
				fontFamily: 'Georgia'
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
		backgroundImage: '../images/iconBar/win_00-iconBar.png'
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
			text: '3',
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
		return false;
	}
	else
	{
		aCheck.selected = true;
		bCheck.selected = false;
		cCheck.selected = false;
		dCheck.selected = false;
		eCheck.selected = false;
		fCheck.selected = false;
		gCheck.selected = false;
		hCheck.selected = false;
		
		aCheck.backgroundImage = '../images/radioActive_Btn.png';
		bCheck.backgroundImage = '../images/radio_Btn.png';
		cCheck.backgroundImage = '../images/radio_Btn.png';
		dCheck.backgroundImage = '../images/radio_Btn.png';
		eCheck.backgroundImage = '../images/radio_Btn.png';
		fCheck.backgroundImage = '../images/radio_Btn.png';
		gCheck.backgroundImage = '../images/radio_Btn.png';
		hCheck.backgroundImage = '../images/radio_Btn.png';
		
		avancar_btn.backgroundImage = '../images/avancar_Btn.png';
		avancar_btn.enabled = true;
	}
});

//-- bCheck Event
bCheck.addEventListener('singletap', function() {
	if(bCheck.selected)
	{
		return false;
	}
	else
	{
		aCheck.selected = false;
		bCheck.selected = true;
		cCheck.selected = false;
		dCheck.selected = false;
		eCheck.selected = false;
		fCheck.selected = false;
		gCheck.selected = false;
		hCheck.selected = false;
		
		aCheck.backgroundImage = '../images/radio_Btn.png';
		bCheck.backgroundImage = '../images/radioActive_Btn.png';
		cCheck.backgroundImage = '../images/radio_Btn.png';
		dCheck.backgroundImage = '../images/radio_Btn.png';
		eCheck.backgroundImage = '../images/radio_Btn.png';
		fCheck.backgroundImage = '../images/radio_Btn.png';
		gCheck.backgroundImage = '../images/radio_Btn.png';
		hCheck.backgroundImage = '../images/radio_Btn.png';
		
		avancar_btn.backgroundImage = '../images/avancar_Btn.png';
		avancar_btn.enabled = true;
	}
});

//-- cCheck Event
cCheck.addEventListener('singletap', function() {
	if(cCheck.selected)
	{
		return false;
	}
	else
	{
		aCheck.selected = false;
		bCheck.selected = false;
		cCheck.selected = true;
		dCheck.selected = false;
		eCheck.selected = false;
		fCheck.selected = false;
		gCheck.selected = false;
		hCheck.selected = false;
		
		aCheck.backgroundImage = '../images/radio_Btn.png';
		bCheck.backgroundImage = '../images/radio_Btn.png';
		cCheck.backgroundImage = '../images/radioActive_Btn.png';
		dCheck.backgroundImage = '../images/radio_Btn.png';
		eCheck.backgroundImage = '../images/radio_Btn.png';
		fCheck.backgroundImage = '../images/radio_Btn.png';
		gCheck.backgroundImage = '../images/radio_Btn.png';
		hCheck.backgroundImage = '../images/radio_Btn.png';
		
		avancar_btn.backgroundImage = '../images/avancar_Btn.png';
		avancar_btn.enabled = true;
	}
});

//-- dCheck Event
dCheck.addEventListener('singletap', function() {
	if(dCheck.selected)
	{
		return false;
	}
	else
	{
		aCheck.selected = false;
		bCheck.selected = false;
		cCheck.selected = false;
		dCheck.selected = true;
		eCheck.selected = false;
		fCheck.selected = false;
		gCheck.selected = false;
		hCheck.selected = false;
		
		aCheck.backgroundImage = '../images/radio_Btn.png';
		bCheck.backgroundImage = '../images/radio_Btn.png';
		cCheck.backgroundImage = '../images/radio_Btn.png';
		dCheck.backgroundImage = '../images/radioActive_Btn.png';
		eCheck.backgroundImage = '../images/radio_Btn.png';
		fCheck.backgroundImage = '../images/radio_Btn.png';
		gCheck.backgroundImage = '../images/radio_Btn.png';
		hCheck.backgroundImage = '../images/radio_Btn.png';
		
		avancar_btn.backgroundImage = '../images/avancar_Btn.png';
		avancar_btn.enabled = true;
	}
});

//-- eCheck Event
eCheck.addEventListener('singletap', function() {
	if(eCheck.selected)
	{
		return false;
	}
	else
	{
		aCheck.selected = false;
		bCheck.selected = false;
		cCheck.selected = false;
		dCheck.selected = false;
		eCheck.selected = true;
		fCheck.selected = false;
		gCheck.selected = false;
		hCheck.selected = false;
		
		aCheck.backgroundImage = '../images/radio_Btn.png';
		bCheck.backgroundImage = '../images/radio_Btn.png';
		cCheck.backgroundImage = '../images/radio_Btn.png';
		dCheck.backgroundImage = '../images/radio_Btn.png';
		eCheck.backgroundImage = '../images/radioActive_Btn.png';
		fCheck.backgroundImage = '../images/radio_Btn.png';
		gCheck.backgroundImage = '../images/radio_Btn.png';
		hCheck.backgroundImage = '../images/radio_Btn.png';
		
		avancar_btn.backgroundImage = '../images/avancar_Btn.png';
		avancar_btn.enabled = true;
	}
});

//-- fCheck Event
fCheck.addEventListener('singletap', function() {
	if(fCheck.selected)
	{
		return false;
	}
	else
	{
		aCheck.selected = false;
		bCheck.selected = false;
		cCheck.selected = false;
		dCheck.selected = false;
		eCheck.selected = false;
		fCheck.selected = true;
		gCheck.selected = false;
		hCheck.selected = false;
		
		aCheck.backgroundImage = '../images/radio_Btn.png';
		bCheck.backgroundImage = '../images/radio_Btn.png';
		cCheck.backgroundImage = '../images/radio_Btn.png';
		dCheck.backgroundImage = '../images/radio_Btn.png';
		eCheck.backgroundImage = '../images/radio_Btn.png';
		fCheck.backgroundImage = '../images/radioActive_Btn.png';
		gCheck.backgroundImage = '../images/radio_Btn.png';
		hCheck.backgroundImage = '../images/radio_Btn.png';
		
		avancar_btn.backgroundImage = '../images/avancar_Btn.png';
		avancar_btn.enabled = true;
	}
});

//-- gCheck Event
gCheck.addEventListener('singletap', function() {
	if(gCheck.selected)
	{
		return false;
	}
	else
	{
		aCheck.selected = false;
		bCheck.selected = false;
		cCheck.selected = false;
		dCheck.selected = false;
		eCheck.selected = false;
		fCheck.selected = false;
		gCheck.selected = true;
		hCheck.selected = false;
		
		aCheck.backgroundImage = '../images/radio_Btn.png';
		bCheck.backgroundImage = '../images/radio_Btn.png';
		cCheck.backgroundImage = '../images/radio_Btn.png';
		dCheck.backgroundImage = '../images/radio_Btn.png';
		eCheck.backgroundImage = '../images/radio_Btn.png';
		fCheck.backgroundImage = '../images/radio_Btn.png';
		gCheck.backgroundImage = '../images/radioActive_Btn.png';
		hCheck.backgroundImage = '../images/radio_Btn.png';
		
		avancar_btn.backgroundImage = '../images/avancar_Btn.png';
		avancar_btn.enabled = true;
	}
});

//-- hCheck Event
hCheck.addEventListener('singletap', function() {
	if(hCheck.selected)
	{
		return false;
	}
	else
	{
		aCheck.selected = false;
		bCheck.selected = false;
		cCheck.selected = false;
		dCheck.selected = false;
		eCheck.selected = false;
		fCheck.selected = false;
		gCheck.selected = false;
		hCheck.selected = true;
		
		aCheck.backgroundImage = '../images/radio_Btn.png';
		bCheck.backgroundImage = '../images/radio_Btn.png';
		cCheck.backgroundImage = '../images/radio_Btn.png';
		dCheck.backgroundImage = '../images/radio_Btn.png';
		eCheck.backgroundImage = '../images/radio_Btn.png';
		fCheck.backgroundImage = '../images/radio_Btn.png';
		gCheck.backgroundImage = '../images/radio_Btn.png';
		hCheck.backgroundImage = '../images/radioActive_Btn.png';
		
		avancar_btn.backgroundImage = '../images/avancar_Btn.png';
		avancar_btn.enabled = true;
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
	
	Ti.App.fireEvent('win_01',{rg:win.rg});
	
});

//-- Avancar Event Listener
avancar_btn.addEventListener('click', function(e) {

	if (aCheck.selected)
	{
		topView.animate({
			opacity: 0,
			duration: 500
		});
		
		bottomView.animate({
			opacity: 0,
			duration: 500
		});
		
		Ti.App.fireEvent('win_03',{rg:win.rg, esc:win.esc, prof:aLabel.text});
	}
	
	else if (bCheck.selected)
	{
		topView.animate({
			opacity: 0,
			duration: 500
		});
		
		bottomView.animate({
			opacity: 0,
			duration: 500
		});
		
		Ti.App.fireEvent('win_03',{rg:win.rg, esc:win.esc, prof:bLabel.text});
	}
	
	else if (cCheck.selected)
	{
		topView.animate({
			opacity: 0,
			duration: 500
		});
		
		bottomView.animate({
			opacity: 0,
			duration: 500
		});
		
		Ti.App.fireEvent('win_03',{rg:win.rg, esc:win.esc, prof:cLabel.text});;
	}
	
	else if (dCheck.selected)
	{
		topView.animate({
			opacity: 0,
			duration: 500
		});
		
		bottomView.animate({
			opacity: 0,
			duration: 500
		});
		
		Ti.App.fireEvent('win_03',{rg:win.rg, esc:win.esc, prof:dLabel.text});
	}
	
	else if (eCheck.selected)
	{
		topView.animate({
			opacity: 0,
			duration: 500
		});
		
		bottomView.animate({
			opacity: 0,
			duration: 500
		});
		
		Ti.App.fireEvent('win_03',{rg:win.rg, esc:win.esc, prof:eLabel.text});
	}
	
	else if (fCheck.selected)
	{
		topView.animate({
			opacity: 0,
			duration: 500
		});
		
		bottomView.animate({
			opacity: 0,
			duration: 500
		});
		
		Ti.App.fireEvent('win_03',{rg:win.rg, esc:win.esc, prof:fLabel.text});
	}
	
	else if (gCheck.selected)
	{
		topView.animate({
			opacity: 0,
			duration: 500
		});
		
		bottomView.animate({
			opacity: 0,
			duration: 500
		});
		
		Ti.App.fireEvent('win_03',{rg:win.rg, esc:win.esc, prof:gLabel.text});
	}
	
	else if (hCheck.selected)
	{
		topView.animate({
			opacity: 0,
			duration: 500
		});
		
		bottomView.animate({
			opacity: 0,
			duration: 500
		});
		
		Ti.App.fireEvent('win_03',{rg:win.rg, esc:win.esc, prof:hLabel.text});
	}
	

});