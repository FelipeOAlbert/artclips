<form name="nova_resposta" id="nova_resposta" class="nova_resposta" id_questao="<?=$id_questao;?>">
	<input type="hidden" name="id_question" value="<?=$id_questao;?>" />
	<div>
		<label>Nova resposta:</label>
		<textarea id="descricao" class="descricao" name="description" value=""></textarea>
	</div>
	
	<? if ( $tipo_questao == QUEST_QUANTITATIVA ) : ?>
		<div>
			<label style="width: 50px;">Peso:</label>
			<input type="text" class="peso" name="weight" value="" maxlength="5" />
		</div>
	<? endif; ?>
	
	<div>
		<input type="button" class="criar" id="criar" value="Criar" />
		<input type="button" class="cancelar" id="cancelar" value="Cancelar" />
	</div>
</form>

<script type="text/javascript">

	$(document).ready(function(){
	
		$(".nova_resposta[id_questao='<?=$id_questao;?>'] .peso").numeric();
	
		
		// *** ADICIONAR QUESTÃO ****
		$(".nova_resposta[id_questao='<?=$id_questao;?>'] input[type=button]#criar").click(function(e) {
			e.preventDefault();

			$(".nova_resposta[id_questao='<?=$id_questao;?>'] textarea").removeClass("erro");

			if( is_empty( $(".nova_resposta[id_questao='<?=$id_questao;?>'] textarea").val() ) ){
				$(".nova_resposta[id_questao='<?=$id_questao;?>'] textarea").addClass("erro").focus();
				return false;
			}
		
			show_loading();
		
			$.post("<?=site_url('/resposta/adicionar');?>",
				$("#nova_resposta[id_questao='<?=$id_questao;?>']").serialize(),
				function(r){
					$(".fundo, .loading_content").hide();
					if(r.ok){
						classe="sucesso";
						$("#nova_resposta[id_questao='<?=$id_questao;?>']").each(function(){
							this.reset();
						});
						
						// recarrega a lista de respostas
						$("div#container_resposta_lista[id_questao='<?=$id_questao?>']").trigger('resposta_adicionada');
					} else {
						classe="erro";
					}
				
					if(r.msg)
						show_msg(r.msg, classe, 800);
				
			}, "json");
		});
	});
</script>
