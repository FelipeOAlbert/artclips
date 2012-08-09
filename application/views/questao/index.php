<h2>Quest&otilde;es</h2>

<? if (!$questionario_bloqueado): ?>
	<input type="button" id="ver_nova_questao" class="ver_nova_questao" value="Nova quest&atilde;o" id_questionario="<?=$id_questionario;?>" />
	
	<? $this->load->view( 'questao/novo', array('id_questionario' => $id_questionario, 'tipos' => $tipos) ); ?>
<? endif; ?>

<div id="container_questao_editar" class="container_questao_editar" id_questionario="<?=$id_questionario?>"></div>
<div id="container_questao_lista" class="container_questao_lista" id_questionario="<?=$id_questionario?>"></div>

<script type="text/javascript">
	$(document).ready(function()
	{


		
		$(".nova_questao[id_questionario='<?=$id_questionario?>']").hide();

		
		$(".nova_questao[id_questionario='<?=$id_questionario?>'] input[type='button'].cancelar").click(function()
		{
			$(".nova_questao[id_questionario='<?=$id_questionario?>']").hide();
			if($("#container_questao_lista").length > 0 ){
				$("#container_questao_lista").css("opacity","1");
			}
			$("div#container_questao_editar[id_questionario='<?=$id_questionario?>'] .editar_questao").hide();
			$(":button.ver_nova_questao[id_questionario='<?=$id_questionario?>']").show();
		});
		
		
		$(":button.ver_nova_questao[id_questionario='<?=$id_questionario?>']").click(function()
		{
			$(".nova_questao[id_questionario='<?=$id_questionario?>']").show();
			if($("#container_questao_lista").length > 0 ){
				$("#container_questao_lista").css("opacity","0.2");
			}
			$(":button.ver_nova_questao[id_questionario='<?=$id_questionario?>']").hide();
			$("div#container_questao_editar[id_questionario='<?=$id_questionario?>'] .editar_questao").hide();
		});
		
		
		$("div#container_questao_lista[id_questionario='<?=$id_questionario?>']").loading('<?=site_url("questao/lista") . "/" . $id_questionario?>', 'Carregando lista...');
		
		$("div#container_questao_lista[id_questionario='<?=$id_questionario?>']").bind('questao_adicionada', function(e)
		{ 
			$("div#container_questao_lista[id_questionario='<?=$id_questionario?>']").loading('<?=site_url("questao/lista") . "/" . $id_questionario?>', 'Carregando lista...');
		});
		
		$("div#container_questao_lista[id_questionario='<?=$id_questionario?>']").bind('questao_editada', function(e)
		{
			$("div#container_questao_lista[id_questionario='<?=$id_questionario?>']").loading('<?=site_url("questao/lista") . "/" . $id_questionario?>', 'Carregando lista...');
			
			$("div#container_questao_editar[id_questionario='<?=$id_questionario?>'] .editar_questao").hide();
			
			<? if (!$questionario_bloqueado): ?>
				$(".nova_questao[id_questionario='<?=$id_questionario?>']").hide();
				$(":button.ver_nova_questao[id_questionario='<?=$id_questionario?>']").show();
			<? endif; ?>
		});
		
		<? if (!$questionario_bloqueado): ?>
			$("div#container_questao_editar[id_questionario='<?=$id_questionario?>']").bind('questao_cancelada', function(e)
			{
				$(".nova_questao[id_questionario='<?=$id_questionario?>']").hide();
				$("div#container_questao_editar[id_questionario='<?=$id_questionario?>'] .editar_questao").hide();
				$(":button.ver_nova_questao[id_questionario='<?=$id_questionario?>']").show();
			});
		<? endif; ?>
		
	});
</script>

