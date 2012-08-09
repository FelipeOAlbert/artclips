//
// win_05.js
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
	height: 532, // 532
	top: 130,
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
			text: 'Tem prefer\352ncia por n\372meros de dormit\363rios?',
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
			top: 150,
			left: 40
		});
		questionView.add(question_sub);
		
		//-- aCheck
		var aCheck = Ti.UI.createView({
			width: 35,
			height: 35,
			top: 50+question_text.height+question_sub.height+30,
			left: 40,
			backgroundImage: '../images/normal_Slt.png',
			selected: false,
			label: '2'
		});
		questionView.add(aCheck);
		
		//-- aLabel
		var aLabel = Ti.UI.createLabel({
			text: '2',
			font: {
				fontSize: item,
				fontFamily: 'Georgia'
			},
			color: darkGray,
			width: 'auto',
			height: 'auto',
			top: 50+question_text.height+question_sub.height+30,
			left: 40+aCheck.width+20
		});
		questionView.add(aLabel);
		
		//-- bCheck
		var bCheck = Ti.UI.createView({
			width: 35,
			height: 35,
			top: 50+question_text.height+question_sub.height+30+aLabel.height+15,
			left: 40,
			backgroundImage: '../images/normal_Slt.png',
			selected: false,
			label: '3'
		});
		questionView.add(bCheck);
		
		//-- bLabel
		var bLabel = Ti.UI.createLabel({
			text: '3',
			font: {
				fontSize: item,
				fontFamily: 'Georgia'
			},
			color: darkGray,
			width: 'auto',
			height: 'auto',
			top: 50+question_text.height+question_sub.height+30+aLabel.height+15,
			left: 40+bCheck.width+20,
			bottom: 60
		});
		questionView.add(bLabel);
				
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
			text: '6',
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
		
		aCheck.backgroundImage = '../images/normal_Slt.png';
		
		if(!bCheck.selected)
		{
			avancar_btn.backgroundImage = '../images/avancarDesat_Btn.png';
			avancar_btn.enabled = false;	
		}
		
		else
		{
			avancar_btn.backgroundImage = '../images/avancar_Btn.png';
			avancar_btn.enabled = true;
		}
	}
	else
	{
		aCheck.selected = true;
		
		aCheck.backgroundImage = '../images/selected_Slt.png';
		
		avancar_btn.backgroundImage = '../images/avancar_Btn.png';
		avancar_btn.enabled = true;
	}
});

//-- bCheck Event
bCheck.addEventListener('singletap', function() {
	if(bCheck.selected)
	{
		bCheck.selected = false;
		
		bCheck.backgroundImage = '../images/normal_Slt.png';
		
		if(!aCheck.selected)
		{
			avancar_btn.backgroundImage = '../images/avancarDesat_Btn.png';
			avancar_btn.enabled = false;	
		}
		
		else
		{
			avancar_btn.backgroundImage = '../images/avancar_Btn.png';
			avancar_btn.enabled = true;
		}
	}
	else
	{
		bCheck.selected = true;
		
		bCheck.backgroundImage = '../images/selected_Slt.png';
		
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
	
	Ti.App.fireEvent('win_04',{rg:win.rg, esc:win.esc, prof:win.prof, tempProcura:win.tempProcura});
	
});

//-- Avancar Event Listener
avancar_btn.addEventListener('click', function(e) {

	if (aCheck.selected == true && bCheck.selected == false)
	{
		topView.animate({
			opacity: 0,
			duration: 500
		});
		
		bottomView.animate({
			opacity: 0,
			duration: 500
		});
		
		Ti.App.fireEvent('win_06',{rg:win.rg, esc:win.esc, prof:win.prof, tempProcura:win.tempProcura, tipoImovel:win.tipoImovel, qntDorm:aLabel.text});
	}
	
	else if (aCheck.selected == false && bCheck.selected == true)
	{
		topView.animate({
			opacity: 0,
			duration: 500
		});
		
		bottomView.animate({
			opacity: 0,
			duration: 500
		});
		
		Ti.App.fireEvent('win_06',{rg:win.rg, esc:win.esc, prof:win.prof, tempProcura:win.tempProcura, tipoImovel:win.tipoImovel, qntDorm:bLabel.text});
	}
	
	else if (aCheck.selected == true && bCheck.selected == true)
	{
		topView.animate({
			opacity: 0,
			duration: 500
		});
		
		bottomView.animate({
			opacity: 0,
			duration: 500
		});
		
		Ti.App.fireEvent('win_06',{rg:win.rg, esc:win.esc, prof:win.prof, tempProcura:win.tempProcura, tipoImovel:win.tipoImovel, qntDorm:aLabel.text+' ou '+bLabel.text});
	}
	

});