$(document).ready(function(){
    
    //Código de configuração dos Datepickers do jQueryUI
	$.datepicker.setDefaults({dateFormat: 'dd/mm/yy',
		dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'],
		dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
		dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
		monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro', 'Outubro','Novembro','Dezembro'],
		monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set', 'Out','Nov','Dez'],
		nextText: 'Próximo',
		prevText: 'Anterior'
	});
	
	//Código de ativação dos Datepickers do jQueryUI
	$(".datepicker").datepicker({dateFormat: "dd/mm/yy"});
    
	$('#limpaBusca').live('click', function(){
		
		url_domain = 'http://'+document.domain+'/';
		
		window.location = url_domain + 'index.php/relatorio/filter/';
		
	});
	
});