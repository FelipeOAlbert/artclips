//
// win_CPF.js
//

// !------- IMPLEMENTATION

//-- Window Local Variable
var win = Ti.UI.currentWindow;

// Sets the main Background Image
Ti.UI.setBackgroundImage('images/rg_bg.png');

//-- Includes
Ti.include('includes/globals.js');

//-- Response Window
Ti.API.info('Window: '+win.url);


//-- Top View
var topView = Ti.UI.createView({
	width: 800,
	height: 306,
	top: 180,
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
			text: 'Para iniciar insira seu RG',
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
		
		//-- RG Text Field
		var rg_field = Ti.UI.createTextField({
			hintText: 'Clique aqui...',
			font: {
				fontSize: 15
			},
			color: darkGray,
			borderStyle: Ti.UI.INPUT_BORDERSTYLE_ROUNDED,
			keyboardType: Ti.UI.KEYBOARD_NUMBER_PAD,
			returnKeyType: Ti.UI.RETURNKEY_DONE,
			supressReturn: true,
			clearButtonMode: 1,
			top: 50+question_text.height+20,
			left: 40,
			bottom: 70,
			width: 300,
			height: 30
		});
		questionView.add(rg_field);
		
	
	//-- Avancar Button
	var avancar_btn = Ti.UI.createButton({
		width: 150,
		height: 60,
		top: questionView.height+30,
		right: 0,
		backgroundImage: '../images/avancar_Btn.png',
		backgroundDisabledImage: '../images/avancarDesat_Btn.png',
		enabled: true
	});
	topView.add(avancar_btn);	


// !------- METHODS

//-- Intro Animation
topView.animate({
	opacity: 1,
	duration: 500
});

/*
bottomView.animate({
	opacity: 1,
	duration: 1000
});
*/


//-- CPF Text Field Change
rg_field.addEventListener('change',function(e) {
	Ti.API.info('RG_FIELD COUNT:'+rg_field.value.length);
	
	if (rg_field.value.length == 9)
	{
		avancar_btn.backgroundImage = '../images/avancar_Btn.png';
		avancar_btn.enabled = true;
	}
	
	else if (rg_field.value.length > 9)
	{
		var valAlert = Ti.UI.createAlertDialog({
			title: 'RG',
			message: 'Insira somente os n\372meros de seu RG por favor',
			buttonNames:['OK']
		});
		valAlert.show();
		
		avancar_btn.backgroundImage = '../images/avancarDesat_Btn.png';
		avancar_btn.enabled = false;
	}
	
	else
	{
		avancar_btn.backgroundImage = '../images/avancarDesat_Btn.png';
		avancar_btn.enabled = false;
	}
	
});

//-- Avancar Event Listener
avancar_btn.addEventListener('click', function(e) {
	
	topView.animate({
		opacity: 0,
		duration: 500
	});
	
	Ti.App.fireEvent('win_00',{rg:rg_field.value});

});