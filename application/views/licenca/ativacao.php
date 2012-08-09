<form name="nova_ativacao" id="nova_ativacao" class="nova_ativacao">
	<label>Question&aacute;rio:</label>
	<?=form_dropdown('id_questionario', $questionarios, 0, 'id="id_questionario"');?>
	
	<label>Licen&ccedil;a:</label>
	<?=form_dropdown('id_licenca', $licencas, 0, 'id="id_licenca"');?>

	<input type="button" class="ativar" id="ativar" value="Ativar licen&ccedil;a" />
</form>

<script type="text/javascript">
	function ativar_licenca()
	{
		hide_loading();
		
		id_licenca = $('#nova_ativacao #id_licenca').val();
		id_questionario = $('#nova_ativacao #id_questionario').val();
		
		if ( is_empty(id_licenca) || is_empty(id_questionario) ) {
			alert('Opção inválida!');
			return false;
		}
		
		if ( !confirm('ATENÇÃO: Após a ativação, o questinário\nficará BLOQUEADO até que a licença expire.\n\nDeseja continuar?') )
			return false;
		
		show_loading();
		$.post('<?=site_url("licenca/ativar")?>', { 'id_licenca': id_licenca, 'id_questionario': id_questionario },
			function(r) {
				if(r.ok) {
					$('#nova_ativacao #id_questionario option[value="' + r.id_questionario + '"]').remove();
					
					$('#nova_ativacao #id_questionario').val(0);
					$('#nova_ativacao #id_licenca').val(0);
					
					show_msg(r.msg, 'sucesso', 2000);
					$("div#container_licenca_lista").loading('<?=site_url("licenca/lista");?>', 'Carregando lista');
				} else {
					show_msg(r.msg, 'erro', 5000);
				}
		}, 'json');
	}
	$(document).ready(function(){
		$('#nova_ativacao #ativar').click(ativar_licenca);
	});
</script>
