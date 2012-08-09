

<input class="ver_novo_evento" type="button" value="Novo evento" />

<? $this->load->view('evento/novo'); ?>

<div id="container_evento_editar" class="container_evento_editar"></div>
<div id="container_evento_lista" class="container_evento_lista"></div>

<script type="text/javascript">

	$(document).ready(function()
	{
		$('.novo_evento').hide();
	
		$('.ver_novo_evento').click(function()
		{
			// Melhorar depois:
			// Adaptação, devido a um problema quando há mais de um formulário utilizando os combos de endereço.
			// É necessário matar os combos e recarregar.
			$('.novo_evento #uf').html('<img class="loading" src="<?=img_url('loading.gif');?>" /> Carregando UFs...');
			$('.novo_evento #uf').load("<?=site_url('endereco/dropdown_ufs');?>");
			
			$('.novo_evento .bairros').hide();
			
			$('.novo_evento').reset().show();
			$('.editar_evento').hide();
			$('.ver_novo_evento').hide();
		});
	
		//$("div#container_evento_editar").loading('<?=site_url("evento/novo");?>', 'Carregando formul&aacute;rio...');
		$("div#container_evento_lista").loading('<?=site_url("evento/lista");?>', 'Carregando lista...');
		
		$("div#container_evento_lista").bind('evento_adicionado', function(e)
		{ 
			$("div#container_evento_lista").loading('<?=site_url("evento/lista");?>', 'Carregando lista...');
		});
		
		$("div#container_evento_lista").bind('evento_editado', function(e)
		{ 
			$("div#container_evento_lista").loading('<?=site_url("evento/lista");?>', 'Carregando lista...');
			//$("div#container_evento_editar").loading('<?=site_url("evento/novo");?>', 'Carregando formul&aacute;rio...');
		});
	});
</script>
