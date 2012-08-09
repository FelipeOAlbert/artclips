<form name="novo_questionario" id="novo_questionario" class="novo_questionario" id_evento="<?=$id_evento;?>" action="<?=site_url('/questionario/adicionar');?>" method="POST">
	<input type="hidden" name="id_evento" value="<?=$id_evento;?>" />
	<div>
		<label>Novo question&aacute;rio:</label>
		<input type="text" id="nome" name="name" value="" />
	</div>
	<!-- div>
		<input type="checkbox" name="available" checked="checked"/><label style="width: auto;">Dispon&iacute;vel</label>
	</div -->
	<div>
		<input type="submit" id="criar" class="criar" value="Criar" />
		<input type="button" id="cancelar" class="cancelar" value="Cancelar" />
	</div>
</form>

<script type="text/javascript">

	function criar_questionario(e){
		e.preventDefault();

		$(".novo_questionario[id_evento='<?=$id_evento;?>'] input[type=text]").removeClass("erro");

		if($(".novo_questionario[id_evento='<?=$id_evento;?>'] input[name=name]").val()==""){
			$(".novo_questionario[id_evento='<?=$id_evento;?>'] input[name=name]").addClass("erro").focus();
			return false;
		}
		return true;
		
		show_loading();
		
		$.post("<?=site_url('/questionario/adicionar');?>",
			$("#novo_questionario[id_evento='<?=$id_evento;?>']").serialize(),
			function(r){
				$(".fundo, .loading_content").hide();
				if(r.ok){
					classe="sucesso";
					$("#novo_questionario[id_evento='<?=$id_evento;?>']").each(function(){
						this.reset();
						$("div#container_questionario_lista[id_evento='<?=$id_evento?>']").trigger('questionario_adicionado');
					});
				} else {
					classe="erro";
				}
				
				if(r.msg)
					show_msg(r.msg, classe, 2500);
				
		}, "json");
	}
	$(document).ready(function(){
		$(".novo_questionario[id_evento='<?=$id_evento;?>'] input[type=button]#criar").click(criar_questionario);
		$(".novo_questionario[id_evento='<?=$id_evento;?>'] input[type=text]").keypress(function(e){
			var code = (e.keyCode ? e.keyCode : e.which);
			if(code == 13) {
				criar_questionario(e);
			}
		});
	});

</script>
