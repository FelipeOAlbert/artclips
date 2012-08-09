<form name="editar_questionario" id="editar_questionario" class="editar_questionario" id_questionario="<?=$id_questionario;?>">
	<input type="hidden" name="id_questionnaire" value="<?=$id_questionario;?>" />
	<div>
		<label>Editar question&aacute;rio:</label>
		<input type="text" id="nome" name="name" value="<?=$questionario->nome;?>" />
	</div>
	<!-- div>
		<input type="checkbox" name="available" <?=(!empty($questionario->disponivel)) ? 'checked="checked"' : '';?> /><label style="width: auto;">Dispon&iacute;vel</label>
	</div -->
	<div>
		<input type="button" class="salvar" value="Editar" />
		<input type="button" class="cancelar" value="Cancelar" />
	</div>
</form>

<script type="text/javascript">
	$(document).ready(function(){
		//EDITAR QUESTIONÁRIO
		$(".editar_questionario[id_questionario='<?=$id_questionario;?>'] .salvar").click(function() {
			$(".editar_questionario[id_questionario='<?=$id_questionario;?>'] input[type=text]").removeClass("erro");

			if($(".editar_questionario[id_questionario='<?=$id_questionario;?>'] input[name=name]").val()==""){
				$(".editar_questionario[id_questionario='<?=$id_questionario;?>'] input[name=name]").addClass("erro").focus();
				return false;
			}
		
			show_loading();
		
			$.post("<?=site_url('/questionario/editar');?>",
				$("#editar_questionario[id_questionario='<?=$id_questionario;?>']").serialize(),
				function(r){
					$(".fundo, .loading_content").hide();
					if(r.ok){
						classe="sucesso";
						$("#editar_questionario[id_questionario='<?=$id_questionario;?>']").each(function(){
							this.reset();
						});
						
						$("div#container_questionario_lista[id_evento='<?=$questionario->id_evento;?>']").trigger('questionario_editado');
					} else {
						classe="erro";
					}
				
					if(r.msg)
						show_msg(r.msg, classe, 2500);
				
			}, "json");
		});
		
		// CANCELAR EDIÇÃO
		$("#editar_questionario[id_questionario='<?=$id_questionario;?>'] .cancelar").click(function() {
			$("div#container_questionario_editar[id_evento='<?=$questionario->id_evento?>']").trigger('questionario_cancelado');
		});
		
		// Rolar o scroll até o formulário e dá foco;
		//$("#editar_questionario[id_questionario='<?=$id_questionario;?>']").scrollIntoView();
		$("#editar_questionario[id_questionario='<?=$id_questionario;?>'] #nome").focus().select();
	});
</script>
