<?= js('form.js');?>
<style>
.editar_email div {
	display: block !important;
}
</style>

<form id='editar_email' class='editar_email' method='POST' action="<?=site_url('cliente/editar_email')?>" onsubmit="return false">
	<div>
		<label>E-mail atual:</label>
		<input type="text" id="email_atual" name="email_atual" value="" maxlength="32" />
	</div>
	
	<div>
		<label>E-mail novo:</label>
		<input type="text" id="email_novo" name="email_novo" value="" maxlength="32" />
		<span class="exemplo">(Entre 1 e 32 carateres)</span>
	</div>

	<div>
		<label>Repita o email:</label>
		<input type="text" id="email_novo-repita" name="repita_email_novo" value="" maxlength="32" />
	</div>

	<div>
		<input type="submit" id="button_submit" value="Salvar email" />
	</div>
</form>

<script type="text/javascript">

	function enviar(e)
	{
			$("#editar_email input[type=text], .editar_email input[type=password]").removeClass("erro");
			
			show_loading();
		
			$.post("<?=site_url('usuario/editar_email');?>",
				{
					 'email_atual':$("#editar_email #email_atual").val()
					,'email_novo':$("#editar_email #email_novo").val()
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
		
		$("#editar_email").validate({
			submitHandler: enviar,
			errorClass: "erro",
			rules: {
				'email_atual':{required: true, minlength: 1, maxlength: 255, email: true}
				,'email_novo':{required: true, minlength: 1, maxlength: 255, email: true, repita: true}
				,'repita_email_novo':{required: true, minlength: 1, maxlength: 255, email: true, repita: true}
			},
			errorPlacement: function(error, element) {
				// Sem mensagem de erro, somente marcando os campos
				//element.after('<span>'+error+'</span>');
			}
		});
	});
	
</script>
