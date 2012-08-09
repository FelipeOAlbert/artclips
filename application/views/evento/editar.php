<!-- h1>Editar evento</h1 -->

<form name="editar_evento" id="editar_evento" class="editar_evento">
	<input type="hidden" id="id_evento" name="id_event" value="<?=$evento->id_evento;?>" />
	<div>
		<label>Nome:</label>
		<input type="text" id="nome" name="name" value="<?=$evento->nome;?>" />
	</div>
	
	<div>
		<label>CEP:</label>
		<input type="text" id="cep" name="cep" value="<?=(!empty($endereco->cep)) ? $endereco->cep : '';?>" maxlength="9" />
		<input type="button" id="buscar_cep" value="Buscar" />
	</div>

	<div>
		<label>Logradouro:</label>
		<input type="text" id="logradouro" name="logradouro" value="<?=(!empty($endereco->logradouro)) ? $endereco->logradouro : '';?>" maxlength="255" />
	</div>

	<div>
		<label>N&uacute;mero:</label>
		<input type="text" id="numero" name="numero" value="<?=(!empty($endereco->numero)) ? $endereco->numero : '';?>" maxlength="8" />
	</div>

	<div>
		<label>Complemento:</label>
		<input type="text" id="complemento" name="complemento" value="<?=(!empty($endereco->complemento)) ? $endereco->complemento : '';?>" maxlength="255" />
	</div>

	<div id="uf"></div>
	
	<br />
	
	<div>
		<input type="button" class="salvar" id="salvar" value="Editar" />
		<input type="button" class="cancelar" id="cancelar" value="Cancelar" />
	</div>
</form>

<script type="text/javascript">
	function editar_evento()
	{
		$(".editar_evento input[type=text]").removeClass("erro");

		if($(".editar_evento input[name=name]").val()==""){
			$(".editar_evento input[name=name]").addClass("erro").focus();
			return false;
		}
	
		show_loading();
	
		$.post("<?=site_url('/evento/editar');?>",
			{
				'id_event' : $("#editar_evento #id_evento").val(),
				'name'     : $("#editar_evento #nome").val(),
				'address'  : get_endereco()
			},
			function(r){
				$(".fundo, .loading_content").hide();
				if(r.ok){
					classe="sucesso";
					$("#editar_evento").each(function(){
						this.reset();
						$("div#container_evento_lista").trigger('evento_editado');
					});
				} else {
					classe="erro";
				}
			
				if(r.msg)
					show_msg(r.msg, classe, 2500);
			
		}, "json");
	}
	
	function get_endereco()
	{
		var endereco =  {
			'street':$("#editar_evento #logradouro").val(),
			'number':$("#editar_evento #numero").val(),
			'complement':$("#editar_evento #complemento").val(),
			'zip_code':$("#editar_evento #cep").val(),
			'id_neighborhood':$("#editar_evento #endereco_bairro").val()
		};
		
		return endereco;
	}
	
	function busca_endereco()
	{
		var cep = $('#editar_evento #cep').val().replace('-','');
		
		if ( is_empty(cep) ) {
			alert('Cep inválido');
			return false;
		}
		
		if ( str_pos = cep.search(/_/i) != (-1) )
			return false;
		
		hide_loading();
		show_loading();
		
		$('#editar_evento #uf').html('<img class="loading" src="<?=img_url('loading.gif');?>" /> Carregando UFs...');
		
		$.post("<?=site_url('endereco/buscar_endereco_por_cep');?>/" + cep,
			{
				'nome': cep
			},
			function(r){
				hide_loading();
				if(r.ok){
					$('#editar_evento #logradouro').val(r.logradouro);
					$('#editar_evento #numero').val(r.numero);
					$('#editar_evento #complemento').val(r.complemento);
					$('#editar_evento #estado').val(r.estado);
					$('#editar_evento #pais').val(r.pais);
					$('#editar_evento #uf').load("<?=site_url('endereco/dropdown_ufs');?>" + "/" + r.uf + "/" + r.id_cidade + "/" + r.id_bairro);
					hide_loading();
				}
				else{
					show_msg(r.msg, 'erro', 2000);
				}
				
		}, "json");
	
		return false;
	}
	
	$(document).ready(function(){
		
		$('#editar_evento #cep').mask("99999-999");
		$('#editar_evento #buscar_cep').click(busca_endereco);
		
		// Imagem de loading
		$('#editar_evento #uf').html('<img class="loading" src="<?=img_url('loading.gif');?>" /> Carregando UFs...');
		
		<? if( empty($endereco) ): ?>
			$('#editar_evento #uf').load("<?=site_url('endereco/dropdown_ufs');?>");
		<? else: ?>
			$('#editar_evento #uf').load("<?=site_url('endereco/dropdown_ufs');?>"
				+ "/" + "<?=$endereco->id_uf;?>"
				+ "/" + "<?=$endereco->id_cidade;?>"
				+ "/" + "<?=$endereco->id_bairro;?>"
			);
		<? endif; ?>
		
		//EDITAR EVENTO
		$(".editar_evento input[type=button].salvar").click(editar_evento);
		
		// CANCELAR EDIÇÃO
		$(".editar_evento input[type=button].cancelar").click(function()
		{
			$('.novo_evento').hide();
			$('.editar_evento').hide();
			$('.ver_novo_evento').show();
			
			//$(".editar_evento").parent().loading('<?=site_url("evento/novo");?>', 'Carregando formul&aacute;rio...');
		});
		
		// Rolar o scroll até o formulário e dá foco;
		//$('#editar_evento').prev().scrollIntoView();
		$('#editar_evento #nome').focus().select();
	});
</script>
