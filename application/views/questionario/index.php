<h2>Question&aacute;rios</h2>

<input type="button" id="ver_novo_questionario" class="ver_novo_questionario" value="Novo question&aacute;rio" id_evento="<?=$id_evento;?>" />

<? $this->load->view('questionario/novo', array('id_evento' => $id_evento)); ?>

<div id="container_questionario_editar" class="container_questionario_editar" id_evento="<?=$id_evento;?>"></div>
<div id="container_questionario_lista" class="container_questionario_lista" id_evento="<?=$id_evento;?>"></div>

<script type="text/javascript">
	$(document).ready(function()
	{
		$(".novo_questionario[id_evento='<?=$id_evento?>']").hide();
		
		$(".novo_questionario[id_evento='<?=$id_evento?>'] input[type='button'].cancelar").click(function()
		{
			$(".novo_questionario[id_evento='<?=$id_evento?>']").hide();
			$("div#container_questionario_editar[id_evento='<?=$id_evento?>'] .editar_questionario").hide();
			$(":button.ver_novo_questionario[id_evento='<?=$id_evento?>']").show();
		});
		
		$(":button.ver_novo_questionario[id_evento='<?=$id_evento?>']").click(function()
		{
			$(".novo_questionario[id_evento='<?=$id_evento?>']").show();
			$(":button.ver_novo_questionario[id_evento='<?=$id_evento?>']").hide();
			$("div#container_questionario_editar[id_evento='<?=$id_evento?>'] .editar_questionario").hide();
		});
		
		$("div#container_questionario_lista[id_evento='<?=$id_evento?>']").loading('<?=site_url("questionario/lista") . "/" . $id_evento?>', 'Carregando lista...');
		
		$("div#container_questionario_lista[id_evento='<?=$id_evento?>']").bind('questionario_adicionado', function(e)
		{ 
			$("div#container_questionario_lista[id_evento='<?=$id_evento?>']").loading('<?=site_url("questionario/lista") . "/" . $id_evento?>', 'Carregando lista...');
		});
		
		$("div#container_questionario_lista[id_evento='<?=$id_evento?>']").bind('questionario_editado', function(e)
		{
			$("div#container_questionario_lista[id_evento='<?=$id_evento?>']").loading('<?=site_url("questionario/lista") . "/" . $id_evento?>', 'Carregando lista...');
			
			
			$("div#container_questionario_editar[id_evento='<?=$id_evento?>'] .editar_questionario").hide();
			
			$(".novo_questionario[id_evento='<?=$id_evento?>']").hide();
			$(":button.ver_novo_questionario[id_evento='<?=$id_evento?>']").show();
		});
		
		$("div#container_questionario_editar[id_evento='<?=$id_evento?>']").bind('questionario_cancelado', function(e)
		{
			$("div#container_questionario_editar[id_evento='<?=$id_evento?>'] .editar_questionario").hide();
			$(".novo_questionario[id_evento='<?=$id_evento?>']").hide();
			$(":button.ver_novo_questionario[id_evento='<?=$id_evento?>']").show();
		});
	});
</script>
