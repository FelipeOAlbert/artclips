<form name="nova_questao_imagem" id="nova_questao_imagem" class="nova_questao_imagem" method="post" action="<?= site_url('questao_imagem/carregar/' . $id_questao);?>" enctype="multipart/form-data">
	<input id="questao_imagem" name="questao_imagem" type="file">
	<input type="submit" class="carregar" id="carregar" value="Carregar" />
	<input type="button" class="cancelar" id="cancelar" value="Cancelar" />
	<div id="load"></div>
</form>

<script type="text/javascript">
	$(document).ready(function(){
	
		$('#nova_questao_imagem .cancelar').click(function(){
			hide_msg(true);
		});
		
		$('form').ajaxForm({
			beforeSubmit: function() {
				if ( is_empty( $('#nova_questao_imagem #questao_imagem').val() ) ) {
					//alert('Selecione uma imagem!');
					//return false;
				}
				
				$('#load').html('Carregando...').removeClass('erro sucesso neutro').addClass('neutro');
			},
			success: function(r) {
				if (r)
					r = $.parseJSON(r);
				
				if (r.ok) {
					$('#load').html('Arquivo carregado!').removeClass('erro sucesso neutro').addClass('sucesso');
					$("div#container_questao_imagem_lista").load('<?=site_url("questao_imagem/lista") . "/" . $id_questao?>');
				} else if (r.msg)
					$('#load').html(r.msg).removeClass('erro sucesso neutro').addClass('erro');
			}
		});
		
		center_msg();
	});

</script>
