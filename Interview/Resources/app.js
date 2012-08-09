// Sets the main Background Image
Ti.UI.setBackgroundImage('images/rg_bg.png');

// -- Main Window that contain all our subwindows
main = Ti.UI.createWindow({
	url: 'main_windows/main.js',
	height: Ti.Platform.displayCaps.platformHeight,
	width: Ti.Platform.displayCaps.platformWidth,
	fullscreen: true,
	navBarHidden: true
});
main.open();

//-- Define Default Orientation
main.orientationModes = [Ti.UI.LANDSCAPE_RIGHT];