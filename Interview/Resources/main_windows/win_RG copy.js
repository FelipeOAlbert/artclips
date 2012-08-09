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

	
/*
//-- Bottom View
var bottomView = Ti.UI.createView({
	width: 964,
	height: 94,
	bottom: 0,
	opacity: 0
});
win.add(bottomView);

	//-- Left bar
	var leftBar = Ti.UI.createView({
		width: 2,
		height: 94,
		top: 0,
		left: 0,
		backgroundColor: black,
		opacity: 0.5
	});
	bottomView.add(leftBar);
	
	//-- Right bar
	var rightBar = Ti.UI.createView({
		width: 2,
		height: 94,
		top: 0,
		right: 0,
		backgroundColor: black,
		opacity: 0.5
	});
	bottomView.add(rightBar);
	
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
	
		//-- Middle bar
		var middleBar = Ti.UI.createView({
			width: 2,
			height: 94,
			top: 0,
			left: 0,
			backgroundColor: black,
			opacity: 0.5
		});
		progressBar.add(middleBar);
		
		//-- Status Label
		var statusLabel = Ti.UI.createLabel({
			text: '1/16',
			font: {
				fontSize: 50,
				fontFamily: 'Georgia'
			},
			color: yellow,
			shadowColor: shadowBlack,
			shadowOffset: {x:1,y:1},
			width: 'auto',
			height: 'auto'
		});
		progressBar.add(statusLabel);
*/
	


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
	
	/*
bottomView.animate({
		opacity: 0,
		duration: 500
	});
*/
	
	Ti.App.fireEvent('win_00',{rg:rg_field.value});

});