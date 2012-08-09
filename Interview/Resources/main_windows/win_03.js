//
// win_03.js
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
	height: 480,
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
			text: 'H\341 quanto tempo est\341 procurando im\363vel?',
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
			label: 'Iniciei no feir\343o'
		});
		questionView.add(aCheck);
		
		//-- aLabel
		var aLabel = Ti.UI.createLabel({
			text: 'Iniciei no feir\343o',
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
			label: '1 m\352s'
		});
		questionView.add(bCheck);
		
		//-- bLabel
		var bLabel = Ti.UI.createLabel({
			text: '1 m\352s',
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
			label: '2 a 6 meses'
		});
		questionView.add(cCheck);
		
		//-- cLabel
		var cLabel = Ti.UI.createLabel({
			text: '2 a 6 meses',
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
			label: '7 a 11 meses'
		});
		questionView.add(dCheck);
		
		//-- dLabel
		var dLabel = Ti.UI.createLabel({
			text: '7 a 11 meses',
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
			label: '1 ano'
		});
		questionView.add(eCheck);
		
		//-- eLabel
		var eLabel = Ti.UI.createLabel({
			text: '1 ano',
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
			label: '2 anos'
		});
		questionView.add(fCheck);
		
		//-- fLabel
		var fLabel = Ti.UI.createLabel({
			text: '2 anos',
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
			label: 'Mais de 2 anos'
		});
		questionView.add(gCheck);
		
		//-- gLabel
		var gLabel = Ti.UI.createLabel({
			text: 'Mais de 2 anos',
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
			label: 'Sempre'
		});
		questionView.add(hCheck);
		
		//-- hLabel
		var hLabel = Ti.UI.createLabel({
			text: 'Sempre',
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
			text: '4',
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
	
	Ti.App.fireEvent('win_02',{rg:win.rg, esc: win.esc});
	
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
		
		Ti.App.fireEvent('win_04',{rg:win.rg, esc:win.esc, prof:win.prof, tempProcura:aLabel.text});
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
		
		Ti.App.fireEvent('win_04',{rg:win.rg, esc:win.esc, prof:win.prof, tempProcura:bLabel.text});
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
		
		Ti.App.fireEvent('win_04',{rg:win.rg, esc:win.esc, prof:win.prof, tempProcura:cLabel.text});
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
		
		Ti.App.fireEvent('win_04',{rg:win.rg, esc:win.esc, prof:win.prof, tempProcura:dLabel.text});
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
		
		Ti.App.fireEvent('win_04',{rg:win.rg, esc:win.esc, prof:win.prof, tempProcura:eLabel.text});
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
		
		Ti.App.fireEvent('win_04',{rg:win.rg, esc:win.esc, prof:win.prof, tempProcura:fLabel.text});
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
		
		Ti.App.fireEvent('win_04',{rg:win.rg, esc:win.esc, prof:win.prof, tempProcura:gLabel.text});
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
		
		Ti.App.fireEvent('win_04',{rg:win.rg, esc:win.esc, prof:win.prof, tempProcura:hLabel.text});
	}
	

});