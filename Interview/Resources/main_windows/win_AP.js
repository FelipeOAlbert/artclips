//
// win_AP.js
//

// !------- IMPLEMENTATION

//-- Window Local Variable
var win = Ti.UI.currentWindow;

//-- Includes
Ti.include('includes/globals.js');

//-- Response Window
Ti.API.info('Window: '+win.url);


//-- Top View
var topView = Ti.UI.createView({
	width: 800,
	height: 'auto',
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
			text: 'Tela de Apresenta\347\343o da Lopes',
			font: {
				fontSize: 40,
				fontFamily: 'Georgia'
			},
			color: darkGray,
			width: 'auto',
			height: 'auto',
			top: 50,
			left: 40,
			bottom: 60
		});
		questionView.add(question_text);
		
	
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


//-- Avancar Event Listener
avancar_btn.addEventListener('click', function(e) {
	
	topView.animate({
		opacity: 0,
		duration: 500
	});
	
	Ti.App.fireEvent('win_01',{rg:win.rg});

});