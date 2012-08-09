<form name="editar_questao" id="editar_questao" class="editar_questao" id_questao="<?=$questao->id_questao;?>">
	<input type="hidden" name="id_question" value="<?=$questao->id_questao;?>" />
	<div>
		<label>Quest&atilde;o:</label>
		<textarea id="descricao" name="description" value=""><?=$questao->descricao;?></textarea>
	</div>
	<div>
		<label style="width: 70px;">Tipo:</label>
		<?=form_dropdown('id_type', $tipos, $questao->id_tipo, 'id="id_tipo"'); ?>
	</div>
	<div>
		<input type="button" class="salvar" value="Editar" />
		<input type="button" class="cancelar" value="Cancelar" />
	</div>
</form>

<script type="text/javascript">
	$(document).ready(function(){
		// SALVAR EDIÇÃO
		$(".editar_questao[id_questao='<?=$id_questao;?>'] .salvar").click(function() {
			$(".editar_questao[id_questao='<?=$id_questao;?>'] input[type=text]").removeClass("erro");

			if($(".editar_questao[id_questao='<?=$id_questao;?>'] input[name=description]").val()==""){
				$(".editar_questao[id_questao='<?=$id_questao;?>'] input[name=description]").addClass("erro").focus();
				return false;
			}
		
			show_loading();
		
			$.post("<?=site_url('/questao/editar');?>",
				$("#editar_questao[id_questao='<?=$id_questao;?>']").serialize(),
				function(r){
					$(".fundo, .loading_content").hide();
					if(r.ok){
						classe="sucesso";
						$("#editar_questao[id_questao='<?=$id_questao;?>']").each(function(){
							this.reset();
						});
						
						$("div#container_questao_lista[id_questionario='<?=$questao->id_questionario;?>']").trigger('questao_editada');
					} else {
						classe="erro";
					}
				
					if(r.msg)
						show_msg(r.msg, classe, 2500);
				
			}, "json");
		});
		
		// CANCELAR EDIÇÃO
		$("#editar_questao[id_questao='<?=$id_questao;?>'] .cancelar").click(function() {
			$("div#container_questao_editar[id_questionario='<?=$questao->id_questionario?>']").trigger('questao_cancelada');
		});
	});
</script>
