<script type='text/javascript'>

	$(".arrows-and-boxes").arrows_and_boxes();

	var limpaFormHiddens = function(){
		$("form[id='nova_questao']").find("#id_alvo").remove();
		$("form[id='nova_questao']").find("#id_questao_pai").remove();
	}
	
	var addCaminho = function(evento, obj){
		evento.preventDefault();

		var splitado = $(obj).attr('id').split("-");
		var id_alvo = splitado[1];
		var id_questao = splitado[0].replace("renato_add_","");

		

		$("#ver_nova_questao").click(function(){
			/* Limpa se ja existir alguma */
				limpaFormHiddens();
				$("#container_questao_lista").css("opacity",'0.1');
		});

		$("input[id='cancelar']").click(function(){
			limpaFormHiddens();
			$("#container_questao_lista").css("opacity",'1');
		});
		
		$("#ver_nova_questao").trigger('click');
		
		$("form[id='nova_questao']").append("<input type='hidden' value='"+id_alvo+"' name='id_alvo' id='id_alvo' />");
		$("form[id='nova_questao']").append("<input type='hidden' value='"+id_questao+"' name='id_questao_pai' id='id_questao_pai' />");
		return false;
	}


	var novaQuestao = function(evento, idPai){
		evento.preventDefault();

		$("#ver_nova_questao").click(function(){
			/* Limpa se ja existir alguma */
				limpaFormHiddens();
				$("#container_questao_lista").css("opacity",'0.1');
		});

		$("input[id='cancelar']").click(function(){
			limpaFormHiddens();
			$("#container_questao_lista").css("opacity",'1');
		});

		$("#ver_nova_questao").trigger('click');
		//$("form[id='nova_questao']").append("<input type='hidden' value='"+idPai+"' name='id_questao_pai' id='id_questao_pai' />");
	}

	
</script>

<pre class="arrows-and-boxes">
<?=$visao;?>
</pre>
