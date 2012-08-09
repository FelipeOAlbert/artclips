<br><br><center><h1>Cadastro</h1></center>
<?= js('form.js');?>
<form id='cadastro' class='cadastro' method='POST' action="<?=site_url('usuario/cadastrar');?>">

	<div>
		<label>Nome:</label>
		<input type="text" id="nome" name="nome" value="<?=(!empty($usuario->nome)) ? $usuario->nome : '' ;?>" maxlength="255" />
	</div>

	<div>
		<label>Sobrenome:</label>
		<input type="text" id="sobrenome" name="sobrenome" value="<?=(!empty($detalhes->sobrenome)) ? $detalhes->sobrenome : '' ;?>" maxlength="255" />
	</div>

		<? if ( empty($usuario) ): ?>
		
			<div>
				<label>E-mail:</label>
				<input type="text" id="email" name="email" value="" maxlength="255" />
			</div>
			
			<div>
				<label>Repita o e-mail:</label>
				<input type="text" id="email-repita" name="repita_email" value="" maxlength="255" />
			</div>
	
			<div>
				<label>Senha:</label>
				<input type="password" id="senha" name="senha" value="" maxlength="32" />
				<span class="exemplo">(Entre 1 e 32 carateres)</span>
			</div>
	
			<div>
				<label>Repita a senha:</label>
				<input type="password" id="senha-repita" name="repita_senha" value="" maxlength="32" />
			</div>
				
		<? endif;?>
	
	<div>
		<label>Data de nascimento:</label>
		<input class="data" type="text" id="data_nascimento" name="data_nascimento" value="<?=(!empty($detalhes->data_nascimento)) ? date_EUA_to_BR($detalhes->data_nascimento) : '' ;?>" maxlength="10" readonly="readonly" />
	</div>
	
	<div>
		<label>Pessoa</label>
		<?
			$tipo_pessoa = NULL;
			if (!empty($detalhes->documento)) {
				if ( strlen($detalhes->documento) == 14 ) $tipo_pessoa = 'PJ'; // Pessoa jurídica
				if ( strlen($detalhes->documento) == 11 ) $tipo_pessoa = 'PF'; // Pessoa física
			}
		?>
		<?=form_dropdown('tipo_pessoa', array(0 => '(Selecione...)', 'PF' => 'Física', 'PJ' => 'Jurídica'), $tipo_pessoa, 'id="tipo_pessoa"'); ?>
	</div>
	
	<div>
		<label id="label_documento"></label>
		<input type="text" id="documento" name="documento" value="<?=(!empty($detalhes->documento)) ? $detalhes->documento : '' ;?>" maxlength="18" />
	</div>
	
	<div>
		<label>Telefone:</label>
		<input type="text" size='1' class="ddd" id="ddd" name="ddd" value="<?=(!empty($telefone->ddd)) ? $telefone->ddd : '' ;?>" maxlength="2" />
		<input type="text" class="fone" id="fone" name="fone" value="<?=(!empty($telefone->telefone)) ? $telefone->telefone : '' ;?>" maxlength="9" />
		<span class="exemplo">(xx) 9999-9999</span>
	</div>
	
	<div>
		<label>CEP:</label>
		<input type="text" id="cep" class="cep" name="cep" value="<?=(!empty($endereco->cep)) ? $endereco->cep : '' ;?>" maxlength="9" />
		<input type="button" id="buscar_cep" value="Buscar cep" />
	</div>
	
	<div>
		<label>Logradouro:</label>
		<input type="text" id="logradouro" name="logradouro" value="<?=(!empty($endereco->logradouro)) ? $endereco->logradouro : '' ;?>" maxlength="255" />
	</div>
	
	<div>
		<label>N&uacute;mero:</label>
		<input type="text" id="numero" name="numero" value="<?=(!empty($endereco->numero)) ? $endereco->numero : '' ;?>" maxlength="8" />
	</div>
	
	<div>
		<label>Complemento:</label>
		<input type="text" id="complemento" name="complemento" value="<?=(!empty($endereco->complemento)) ? $endereco->complemento : '' ;?>" maxlength="255" />
	</div>
	
	<div id="uf"></div>
	
	<div>
		<? if (empty($usuario) ): ?>
			<input type="submit" id="button_submit" value="Criar conta" />
		<? else: ?>
			<input type="submit" id="button_submit" value="Salvar conta" />
		<? endif; ?>
	</div>
</form>

<script type="text/javascript">
	function enviar(e)
	{
			$("#cadastro input[type=text], .cadastro input[type=password]").removeClass("erro");
			
			show_loading();
		return true;
			/*$.post("<?=site_url('usuario/cadastrar');?>",
				{
					 'name':$("#cadastro #nome").val()
					,'email':$("#cadastro #email").val()
					,'password':$("#cadastro #senha").val()
					,'phone':get_telefone()
					,'address':get_endereco()
					,'detail':get_detalhes()
				},
				function(r){
					hide_loading();
					if(r.ok){
					
						<? if ( empty($usuario) ): ?>
						
							// Faz o login
							show_loading();
							$.post("<?=site_url('/principal/logar');?>",
								{"login" : $("#cadastro #email").val(), "senha" : $("#cadastro #senha").val()},
								function(r){
									hide_loading();
									if(r.ok){
										window.location="<?=site_url();?>";
									}
									else{
										$("input").blur();
										show_msg(r.msg, 'erro', 9000);
									}
						
							}, "json");
							
						<? else: ?>
						
							show_msg(r.msg, 'sucesso', 2000, function(){
								window.location="<?=site_url();?>";
							});
							
						<? endif; ?>
					}
					else{
						show_msg(r.msg, 'erro', 3000);
					}
					
			}, "json");
			
			return false;*/
	}
	
	function get_endereco()
	{
		var endereco =  {
			'street':$("#cadastro #logradouro").val(),
			'number':$("#cadastro #numero").val(),
			'complement':$("#cadastro #complemento").val(),
			'zip_code':$("#cadastro #cep").val(),
			'id_neighborhood':$("#cadastro #endereco_bairro").val()
		};
		
		return endereco;
	}
	
	function get_detalhes()
	{
		var detalhes =  {
			'document':$("#cadastro #documento").val()
			,'birth_date':$("#cadastro #data_nascimento").val()
			,'last_name':$("#cadastro #sobrenome").val()
		};
		
		return detalhes;
	}
	
	function get_telefone()
	{
		var telefone =  {
			'phone':$("#cadastro #fone").val()
			,'ddd':$("#cadastro #ddd").val()
		};
		
		return telefone;
	}
	
	function blockeia_documento()
	{
		if (is_empty($('#tipo_pessoa').val())) {
			
			$('#cadastro #documento, #cadastro #label_documento, #cadastro #exemplo_documento').attr('disabled','disabled');
			$('#cadastro #label_documento').html('...');
		} else {
			if ($('#cadastro #tipo_pessoa').val() == 'PF') {
				
				$('#cadastro #label_documento').html('CPF');
				$('#cadastro #documento').mask("999.999.999-99");
				
			} else if ($('#cadastro #tipo_pessoa').val() == 'PJ') {
				$('#cadastro #label_documento').html('CNPJ');
				$('#cadastro #documento').mask("99.999.999/9999-99");
				
			} else {
				return false;
			}
			
			$('#cadastro #documento, #cadastro #label_documento, #cadastro #exemplo_documento').removeAttr('disabled');
		}
	}
	
	function busca_endereco()
	{
		var cep = $('#cadastro #cep').val().replace('-','');
		
		if ( is_empty(cep) ) {
			alert('Cep inválido');
			return false;
		}
		
		if ( str_pos = cep.search(/_/i) != (-1) )
			return false;
		
		hide_loading();
		show_loading();
		
		$.post("<?=site_url('endereco/buscar_endereco_por_cep');?>/" + cep,
			{
				'nome': cep
			},
			function(r){
				hide_loading();
				if(r.ok){
					$('#cadastro #logradouro').val(r.logradouro);
					$('#cadastro #numero').val(r.numero);
					$('#cadastro #complemento').val(r.complemento);
					$('#cadastro #estado').val(r.estado);
					$('#cadastro #pais').val(r.pais);
					$('#cadastro #uf').load("<?=site_url('endereco/dropdown_ufs');?>" + "/" + r.uf + "/" + r.id_cidade + "/" + r.id_bairro);
					hide_loading();
				}
				else{
					show_msg(r.msg, 'erro', 2000);
				}
				
		}, "json");
	
		return false;
	}
	
	$(document).ready(function() {
	
		// Imagem de loading
		$('#cadastro #uf').html('<img class="loading" src="<?=img_url('loading.gif');?>" /> Carregando UFs...');
		
		<? if( empty($endereco) ): ?>
			$('#cadastro #uf').load("<?=site_url('endereco/dropdown_ufs');?>");
		<? else: ?>
			$('#cadastro #uf').load("<?=site_url('endereco/dropdown_ufs');?>"
				+ "/" + "<?=$endereco->id_uf;?>"
				+ "/" + "<?=$endereco->id_cidade;?>"
				+ "/" + "<?=$endereco->id_bairro;?>"
			);
		<? endif; ?>
		
		blockeia_documento();
		$('#cadastro #tipo_pessoa').change(blockeia_documento);
		$('#cadastro #buscar_cep').click(busca_endereco);
		
		$('#cadastro #cep').mask("99999-999");
		$('#cadastro #data_nascimento').mask("99/99/9999");
		$('#cadastro input[type="text"].data').datepicker();
		$('#cadastro input[type="text"].ddd').numeric().mask("99").attr('maxlength', 2);
		$('#cadastro input[type="text"].fone').numeric().mask("9999-9999").attr('maxlength', 9);
		$('#cadastro input[type="text"].cpf').numeric().mask("999.999.999-99").attr('maxlength', 14);
		$('#cadastro input[type="text"].cnpj').numeric().mask("99.999.999/9999-99").attr('maxlength', 18);
		
		$("#cadastro").validate({
			/*submitHandler: enviar,*/
			errorClass: "erro",
			rules: {
				 'nome':{required: true, minlength: 1, maxlength: 255}
				/*,'sobrenome':{required: true, minlength: 1, maxlength: 255}
				,'email':{required: true, minlength: 1, maxlength: 255, email: true, repita: true}
				,'repita_email':{required: true, minlength: 1, maxlength: 255, email: true, repita: true}
				,'senha':{required: true, minlength: 1, maxlength: 32, repita: true}
				,'repita_senha':{required: true, minlength: 1, maxlength: 32, repita: true}
				,'sexo':{combo: true}
				,'data_nascimento':{required: true, minlength: 1, maxlength: 10}
				,'tipo_pessoa':{combo: true}
				,'documento':{required: true, minlength: 1, cpf_cnpj: true}
				,'ddd':{required: true, minlength: 2, maxlength: 2}
				,'fone':{required: true, minlength: 8, maxlength: 9}
				,'nome':{required: true, minlength: 1, maxlength: 15}
				,'cep':{required: true, minlength: 8, maxlength: 9}
				,'logradouro':{required: true, minlength: 1, maxlength: 255}
				,'numero':{required: true, minlength: 1, maxlength: 8}
				,'endereco_uf':{combo: true}
				,'endereco_cidade':{combo: true}
				,'endereco_bairro':{combo: true}*/
				//,'complemento':{required: true, minlength: 1, maxlength: 255}
				//,'newsletter':'required'
			},
			errorPlacement: function(error, element) {
				// Sem mensagem de erro, somente marcando os campos
				//element.after('<span>'+error+'</span>');
			}
		});
	});
</script>
