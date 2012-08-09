<? if (!$questionario_bloqueado) : ?>
	<? if ( $tipo_questao != QUEST_DISSERTATIVA) : ?>
		<h2>Respostas</h2>
		
		<input type="button" id="ver_nova_resposta" class="ver_nova_resposta" value="Nova resposta" id_questao="<?=$id_questao;?>" />
	
		<? $this->load->view('resposta/novo', array('id_questao' => $id_questao)); ?>
		
		<div id="container_resposta_editar" class="container_resposta_editar" id_questao="<?=$id_questao?>"></div>
		<div id="container_resposta_lista" class="container_resposta_lista" id_questao="<?=$id_questao?>"></div>
		
	<? else : ?>
	
		<span class="info">Quest&otilde;es dissertativas n&atilde;o possuem respostas predefinidas.</span>
		
	<? endif; ?>
<? endif; ?>

<script type="text/javascript">
	$(document).ready(function()
	{
		$(".nova_resposta[id_questao='<?=$id_questao?>']").hide();
		
		$(".nova_resposta[id_questao='<?=$id_questao?>'] input[type='button'].cancelar").click(function()
		{
			$(".nova_resposta[id_questao='<?=$id_questao?>']").hide();
			$("div#container_resposta_editar[id_questao='<?=$id_questao?>'] .editar_resposta").hide();
			$(":button.ver_nova_resposta[id_questao='<?=$id_questao?>']").show();
		});
		
		$(":button.ver_nova_resposta[id_questao='<?=$id_questao?>']").click(function()
		{
			$(".nova_resposta[id_questao='<?=$id_questao?>']").show();
			$(":button.ver_nova_resposta[id_questao='<?=$id_questao?>']").hide();
			$("div#container_resposta_editar[id_questao='<?=$id_questao?>'] .editar_resposta").hide();
		});
		
		$("div#container_resposta_lista[id_questao='<?=$id_questao?>']").loading('<?=site_url("resposta/lista") . "/" . $id_questao?>', 'Carregando lista...');
		
		$("div#container_resposta_lista[id_questao='<?=$id_questao?>']").bind('resposta_adicionada', function(e)
		{
			$("div#container_resposta_lista[id_questao='<?=$id_questao?>']").loading('<?=site_url("resposta/lista") . "/" . $id_questao?>', 'Carregando lista...');
		});
		
		$("div#container_resposta_lista[id_questao='<?=$id_questao?>']").bind('resposta_editada', function(e)
		{
			$("div#container_resposta_lista[id_questao='<?=$id_questao?>']").loading('<?=site_url("resposta/lista") . "/" . $id_questao?>', 'Carregando lista...');
			
			$("div#container_resposta_editar[id_questao='<?=$id_questao?>'] .editar_resposta").hide();
			
			<? if (!$questionario_bloqueado): ?>
				$(".nova_resposta[id_questao='<?=$id_questao?>']").hide();
				$(":button.ver_nova_resposta[id_questao='<?=$id_questao?>']").show();
			<? endif; ?>
		});
		
		<? if (!$questionario_bloqueado): ?>
			$("div#container_resposta_editar[id_questao='<?=$id_questao?>']").bind('resposta_cancelada', function(e)
			{
				$(".nova_resposta[id_questao='<?=$id_questao?>']").hide();
				$("div#container_resposta_editar[id_questao='<?=$id_questao?>'] .editar_resposta").hide();
				$(":button.ver_nova_resposta[id_questao='<?=$id_questao?>']").show();
			});
		<? endif; ?>
	});
</script>


