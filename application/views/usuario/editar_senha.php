<?= js('form.js');?>
<style>
.editar_senha div {
	display: block !important;
}
</style>

<form id='editar_senha' class='editar_senha' method='POST' action="<?=site_url('cliente/editar_senha')?>" onsubmit="return false">
	<div>
		<label>Senha atual:</label>
		<input type="password" id="senha_atual" name="senha_atual" value="" maxlength="32" />
	</div>
	
	<div>
		<label>Senha nova:</label>
		<input type="password" id="senha_nova" name="senha_nova" value="" maxlength="32" />
		<span class="exemplo">(Entre 1 e 32 carateres)</span>
	</div>

	<div>
		<label>Repita a senha:</label>
		<input type="password" id="senha_nova-repita" name="repita_senha_nova" value="" maxlength="32" />
	</div>

	<div>
		<input type="submit" id="button_submit" value="Salvar senha" />
	</div>
</form>

<script type="text/javascript">

	function enviar(e)
	{
			$("#editar_senha input[type=text], .editar_senha input[type=password]").removeClass("erro");
			
			show_loading();
		
			$.post("<?=site_url('usuario/editar_senha');?>",
				{
					 'senha_atual':$("#editar_senha #senha_atual").val()
					,'senha_nova':$("#editar_senha #senha_nova").val()
				},
				function(r){
					hide_loading();
					if(r.ok){
					
						if (r.msg)
							show_msg(r.msg, 'sucess', 2000, function(){
								window.location="<?=site_url();?>";
							});
						else
							window.location="<?=site_url();?>";
					}
					else if (r.msg)
						show_msg(r.msg, 'erro', 4000);
					
			}, "json");
			
			return false;
	}
	
	$(document).ready(function() {
		
		$("#editar_senha").validate({
			submitHandler: enviar,
			errorClass: "erro",
			rules: {
				'senha_atual':{required: true, minlength: 1, maxlength: 32}
				,'senha_nova':{required: true, minlength: 1, maxlength: 32, repita: true}
				,'repita_senha_nova':{required: true, minlength: 1, maxlength: 32, repita: true}
			},
			errorPlacement: function(error, element) {
				// Sem mensagem de erro, somente marcando os campos
				//element.after('<span>'+error+'</span>');
			}
		});
	});
	
</script>
