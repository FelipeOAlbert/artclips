//
// win_00.js
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
	height: 354,
	top: 180,
	left: 112,
	opacity: 0
});
win.add(topView);

	//-- Question View
	var questionView = Ti.UI.createView({
		width: 800,
		height: 'auto', // mudar para AUTO
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
			text: 'Voc\352 conhece a Lopes?',
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
		
		//-- Sim Check
		var simCheck = Ti.UI.createView({
			width: 35,
			height: 35,
			top: 50+question_text.height+25,
			left: 40,
			backgroundImage: '../images/radio_Btn.png',
			selected: false,
			label: 'sim'
		});
		questionView.add(simCheck);
		
		//-- Sim Text
		var simLabel = Ti.UI.createLabel({
			text: 'Sim',
			font: {
				fontSize: 38,
				fontFamily: 'Georgia'
			},
			color: darkGray,
			width: 'auto',
			height: 'auto',
			top: 50+question_text.height+20,
			left: 40+simCheck.width+20
		});
		questionView.add(simLabel);
		
		//-- Nao Check
		var naoCheck = Ti.UI.createView({
			width: 35,
			height: 35,
			top: 50+question_text.height+20+simLabel.height+5,
			left: 40,
			backgroundImage: '../images/radio_Btn.png',
			selected: false,
			label: 'nao'
		});
		questionView.add(naoCheck);
		
		//-- Nao Text
		var naoLabel = Ti.UI.createLabel({
			text: 'Nao',
			font: {
				fontSize: 38,
				fontFamily: 'Georgia'
			},
			color: darkGray,
			width: 'auto',
			height: 'auto',
			top: 50+question_text.height+20+simLabel.height,
			left: 40+naoCheck.width+20,
			bottom: 60
		});
		questionView.add(naoLabel);
		
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
			text: '1',
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

//-- Sim Event
simCheck.addEventListener('singletap', function() {
	if(simCheck.selected)
	{
		return false;
	}
	else
	{
		simCheck.selected = true;
		naoCheck.selected = false;
		simCheck.backgroundImage = '../images/radioActive_Btn.png';
		naoCheck.backgroundImage = '../images/radio_Btn.png';
		
		avancar_btn.backgroundImage = '../images/avancar_Btn.png';
		avancar_btn.enabled = true;
	}
});

//-- Nao Event
naoCheck.addEventListener('singletap', function() {
	if(naoCheck.selected)
	{
		return false;
	}
	else
	{
		naoCheck.selected = true;
		simCheck.selected = false;
		naoCheck.backgroundImage = '../images/radioActive_Btn.png';
		simCheck.backgroundImage = '../images/radio_Btn.png';
		
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
	
	Ti.App.fireEvent('win_RG');
	
});

//-- Avancar Event Listener
avancar_btn.addEventListener('click', function(e) {

	if (simCheck.selected)
	{
		topView.animate({
			opacity: 0,
			duration: 500
		});
		
		bottomView.animate({
			opacity: 0,
			duration: 500
		});
		
		Ti.App.fireEvent('win_01',{rg:win.rg});
	}
	
	else
	{
		topView.animate({
			opacity: 0,
			duration: 500
		});
		
		bottomView.animate({
			opacity: 0,
			duration: 500
		});
		
		Ti.App.fireEvent('win_AP',{rg:win.rg});
	}

});