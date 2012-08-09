<h1 style="display:none;">Novo evento</h1>

<form name="novo_evento" id="novo_evento" class="novo_evento" method="post" action="<?=site_url('/evento/adicionar');?>">
	<div>
		<label>Nome do evento:</label>
		<input type="text" id="nome" name="nome" value="" />
	</div>
	
	<div>
		<label>CEP:</label>
		<input type="text" id="cep" name="cep" value="" maxlength="9" />
		<input type="button" id="buscar_cep" value="Buscar" />
	</div>

	<div>
		<label>Logradouro:</label>
		<input type="text" id="logradouro" name="logradouro" value="" maxlength="255" />
	</div>

	<div>
		<label>N&uacute;mero:</label>
		<input type="text" id="numero" name="numero" value="" maxlength="8" />
	</div>

	<div>
		<label>Complemento:</label>
		<input type="text" id="complemento" name="complemento" value="" maxlength="255" />
	</div>

	<div id="uf"></div>
	
	
	<div>
		<b>Responsável</b><br />
		Nome: <input type="text" id="nome_resp" name="nome_resp" value="" /> <br/>
		email: <input type="text" id="email_resp" name="email_resp" value="" /> <br/>
		telefone: <input type="text" id="tel_resp" name="tel_resp" value="" /> <br/>
	</div>
	<div>
		<label>Finalidade da Pesquisa:</label>
		<input type="text" id="finalidade" name="finalidade" value="" />
	</div>
	<div>
		<label>Público Alvo:</label>
		<input type="text" id="publico_alvo" name="publico_alvo" value="" />
	</div>
	<div>
		<label>Tipo de Pesquisa:</label>
		<input type="text" id="tipo_pesq" name="tipo_pesq" value="" />
	</div>
	<div>
		<label>Tamanho da amostra:</label>
		<input type="text" id="tamanho_amostra" name="tamanho_amostra" value="" />
	</div>
	
	<div style="border: 1px solid red;">
		<b>Acesso do responsável</b> <br />
		Login: <input type="text" name="login_resp"> <br />
		Senha: <input type="password" name="senha_resp">
	</div>
	
	<div style="border: 1px solid green;">
		<b>Acesso do iPad</b> <br />
		Login: <input type="text" name="login_ipad"> <br />
		Senha: <input type="password" name="senha_ipad">
	</div>

		<input type="submit" id="criar" value="Criar Evento" />
		<input type="button" id="cancelar" value="Cancelar" />
	</div>
</form>

<script type="text/javascript">	
	function criar_evento(e)
	{
		e.preventDefault();

		$(".novo_evento input[type=text]").removeClass("erro");

		var arr_validar = new Array();
		arr_validar[0] = "nome";
		arr_validar[1] = "nome_resp";
		arr_validar[2] = "email_resp";
		arr_validar[3] = "tel_resp";
		arr_validar[4] = "finalidade";
		arr_validar[5] = "publico_alvo";
		arr_validar[6] = "tipo_pesq";
		arr_validar[7] = "tamanho_amostra";
		arr_validar[8] = "cep";
		arr_validar[9] = "logradouro";
		arr_validar[10] = "numero";

		for (i=0; i<arr_validar.length; i++){
			if($(".novo_evento input[name='"+arr_validar[i]+"']").val()==""){
				$(".novo_evento input[name='"+arr_validar[i]+"']").addClass("erro").focus();
				return false;
			}
		}

		return true;
		show_loading();
		
		$.post("<?=site_url('/evento/adicionar');?>",
			{
				'name' : $("#novo_evento #nome").val(),
				'address' : get_endereco()
			},
			function(r){
				$(".fundo, .loading_content").hide();
				if(r.ok){
					classe="sucesso";
					$("#novo_evento").each(function(){
						this.reset();
						$('#novo_evento #uf').load("<?=site_url('endereco/dropdown_ufs');?>");
						
						$("div#container_evento_lista").trigger('evento_adicionado');
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
			'street':$("#novo_evento #logradouro").val(),
			'number':$("#novo_evento #numero").val(),
			'complement':$("#novo_evento #complemento").val(),
			'zip_code':$("#novo_evento #cep").val(),
			'id_neighborhood':$("#novo_evento #endereco_bairro").val()
		};
		
		return endereco;
	}
	
	function busca_endereco()
	{
		var cep = $('#novo_evento #cep').val().replace('-','');
		
		if ( is_empty(cep) ) {
			alert('Cep inválido');
			return false;
		}
		
		if ( str_pos = cep.search(/_/i) != (-1) )
			return false;
		
		hide_loading();
		show_loading();
		
		$('#novo_evento #uf').html('<img class="loading" src="<?=img_url('loading.gif');?>" /> Carregando UFs...');
		
		$.post("<?=site_url('endereco/buscar_endereco_por_cep');?>/" + cep,
			{
				'nome': cep
			},
			function(r){
				hide_loading();
				if(r.ok){
					$('#novo_evento #logradouro').val(r.logradouro);
					$('#novo_evento #numero').val(r.numero);
					$('#novo_evento #complemento').val(r.complemento);
					$('#novo_evento #estado').val(r.estado);
					$('#novo_evento #pais').val(r.pais);
					$('#novo_evento #uf').load("<?=site_url('endereco/dropdown_ufs');?>" + "/" + r.uf + "/" + r.id_cidade + "/" + r.id_bairro);
					hide_loading();
				}
				else{
					show_msg(r.msg, 'erro', 2000);
				}
				
		}, "json");
	
		return false;
	}
	
	$(document).ready(function(){
		
		$('#novo_evento #numero').numeric();
		$('#novo_evento #cep').mask("99999-999");
		$('#novo_evento #buscar_cep').click(busca_endereco);
		
		// Imagem de loading
		$('#novo_evento #uf').html('<img class="loading" src="<?=img_url('loading.gif');?>" /> Carregando UFs...');
		
		$('#novo_evento #uf').load("<?=site_url('endereco/dropdown_ufs');?>");

		$(".novo_evento input[type=button]#criar").click(criar_evento);
		$(".novo_evento input[type=button]#cancelar").click(function(){
			$('#novo_evento').hide();
			$('.ver_novo_evento').show();
		});
	});

</script>
