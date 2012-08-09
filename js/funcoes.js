var timeout_msg_system = 1;
var class_msg_system = '';

function show_msg(msg, classe, timeout, callback){
	if(undefined == msg)
		msg = '';
	if(undefined == classe)
		classe = "sucesso";
	if(undefined == timeout)
		timeout = 1500;
		
	hide_msg(true);
	
	if (classe == 'erro' || classe == 'err' || classe == 'sucesso' || classe == 'sucess')
		$(".sistema_mensagem span").html('').removeClass('erro sucesso err sucess').addClass(classe).html(msg);
	else {
		$(".sistema_mensagem").addClass(classe);
		$(".sistema_mensagem span").html(msg);
		class_msg_system = classe;
	}
	
	$(".sistema_mensagem").centerInClient();
	$(".fundo, .sistema_mensagem").show();
	
	timeout_msg_system = timeout;
	
	if(timeout > 0)
		setTimeout(function(){
			$(".fundo, .sistema_mensagem").fadeOut(500);
			if ( typeof(callback) == 'function' )
				callback();
		}, timeout);
		
}
function erro_help(object, msg){
	object.parent().find('.erro_help').remove();
	object.after(" <span class='erro_help'>" + msg + "</span>");
}
function center_msg(){
	$(".sistema_mensagem").centerInClient();
}
function show_loading(){
	$(".loading_content").centerInClient();
	$(".fundo, .loading_content").show();
	$("input").blur();
}
function hide_loading(force){
	if (timeout_msg_system != 0 || force) {
		$(".fundo, .sistema_mensagem, .loading_content").hide();
		$(".sistema_mensagem").removeClass(class_msg_system);
	}
}
function hide_msg(force){
	hide_loading(force);
}
function is_empty(mixed_var) {
	// !No description available for empty. @php.js developers: Please update the function summary text file.
	// 
	// version: 1107.2516
	// discuss at: http://phpjs.org/functions/empty
	// +   original by: Philippe Baumann
	// +      input by: Onno Marsman
	// +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	// +      input by: LH
	// +   improved by: Onno Marsman
	// +   improved by: Francesco
	// +   improved by: Marc Jansen
	// +   input by: Stoyan Kyosev (http://www.svest.org/)
	// *     example 1: empty(null);
	// *     returns 1: true
	// *     example 2: empty(undefined);
	// *     returns 2: true
	// *     example 3: empty([]);
	// *     returns 3: true
	// *     example 4: empty({});
	// *     returns 4: true
	// *     example 5: empty({'aFunc' : function () { alert('humpty'); } });
	// *     returns 5: false
	var key;

	if (mixed_var === "" || mixed_var === 0 || mixed_var === "0" || mixed_var === null || mixed_var === false || typeof mixed_var === 'undefined') {
		return true;
	}

	if (typeof mixed_var == 'object') {
	for (key in mixed_var) {
		return false;
	}
		return true;
	}

	return false;
}
