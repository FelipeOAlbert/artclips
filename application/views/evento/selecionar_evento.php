<form id="form_evento_duplicar_questionario" class="form_evento_duplicar_questionario">
	<div>
		<p>Selecione o evento que receber&aacute;<br />a c&oacute;pia do question&aacute;rio.</p>
	</div>

	<div>
		<?=form_dropdown('selecionar_evento', $eventos, $default_evento, 'id="selecionar_evento"');?>
	</div>

	<div>
		<input type="button" id="evento_cancelado" value="Cancelar" />
		<input type="button" id="evento_selecionado" value="OK" />
	</div>
</form>

<script type="text/javascript">
	$(document).ready(function(){
		$('#form_evento_duplicar_questionario #selecionar_evento').change(function(){
			// remove a opção padrão "selecione"
			$('#evento_duplicar_questionario #selecionar_evento option[value="0"]').remove();
		});
		
		$('#form_evento_duplicar_questionario #evento_selecionado').click(function(){
			var id_evento = $('#form_evento_duplicar_questionario #selecionar_evento').val();
			
			if ( is_empty(id_evento) ) {
				alert('Opção inválida!');
				return false;
			}
			
			$.get('<?=site_url("questionario/duplicar/" . $id_questionario)?>' + '/' + id_evento, function(r) {
				if (r.ok) {
					show_msg(r.msg, 'sucesso', 2500);
					$(".questionario[id_evento='" + id_evento + "']").parent().load('<?=site_url("questionario/lista/");?>' + '/' + id_evento);
				}
				else if (r.msg)
					show_msg(r.msg, 'erro', 2500);
			}, "json");
		});
		
		$('#form_evento_duplicar_questionario #evento_cancelado').click(function(){
			hide_msg(true);
		});
	});
</script>
