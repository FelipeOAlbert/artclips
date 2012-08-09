<form name="editar_resposta" id="editar_resposta" class="editar_resposta" id_resposta="<?=$id_resposta;?>">
	<input type="hidden" name="id_answer" value="<?=$resposta->id_resposta;?>" />
	<div>
		<label>Editar resposta:</label>
		<textarea id="descricao" class="descricao" name="description" value=""><?=$resposta->descricao;?></textarea>
	</div>
	
	<? if ( $tipo_questao == QUEST_QUANTITATIVA ) : ?>
		<div>
			<label style="width: 50px;">Peso:</label>
			<input type="text" class="peso" name="weight" value="<?=$resposta->peso;?>" maxlength="5" />
		</div>
	<? endif; ?>
	
	<div>
		<input type="button" class="salvar" value="Editar" />
		<input type="button" class="cancelar" value="Cancelar" />
	</div>
</form>

<script type="text/javascript">
	$(document).ready(function(){
	
		$(".editar_resposta[id_resposta='<?=$id_resposta;?>'] .peso").numeric();
		
		// *** SALVAR EDIÇÃO ***
		$(".editar_resposta[id_resposta='<?=$id_resposta;?>'] .salvar").click(function() {
			$(".editar_resposta[id_resposta='<?=$id_resposta;?>'] input[type=text]").removeClass("erro");

			if($(".editar_resposta[id_resposta='<?=$id_resposta;?>'] input[name=description]").val()==""){
				$(".editar_resposta[id_resposta='<?=$id_resposta;?>'] input[name=description]").addClass("erro").focus();
				return false;
			}
		
			show_loading();
		
			$.post("<?=site_url('/resposta/editar');?>",
				$("#editar_resposta[id_resposta='<?=$id_resposta;?>']").serialize(),
				function(r){
					$(".fundo, .loading_content").hide();
					if(r.ok){
						classe="sucesso";
						$("#editar_resposta[id_resposta='<?=$id_resposta;?>']").each(function(){
							this.reset();
						});
						
						$("div#container_resposta_lista[id_questao='<?=$resposta->id_questao;?>']").trigger('resposta_editada');
					} else {
						classe="erro";
					}
				
					if(r.msg)
						show_msg(r.msg, classe, 2500);
				
			}, "json");
		});
		
		// CANCELAR EDIÇÃO
		$("#editar_resposta[id_resposta='<?=$id_resposta;?>'] .cancelar").click(function() {
			$("div#container_resposta_editar[id_questao='<?=$resposta->id_questao?>']").trigger('resposta_cancelada');
		});
	});
</script>
