<div class="questao_imagem">
	<? if(count($imagens) > 0) : ?>
		<table class="lista">
			<tbody>
				<? foreach($imagens as $i) : ?>
			
					<tr id_imagem_questao="<?=$i->id_imagem_questao;?>">
						<td class="thumbs">
							<? $style = ($i->largura > $i->altura) ? 'width:100px;' : 'height:100px;' ?>
							<a target="_blank" href="<?=base_url('uploads/' . $i->nome . '.' . $i->extensao);?>">
								<img style="<?=$style;?>" src="<?=base_url('uploads/' . $i->nome . '.' . $i->extensao);?>">
							</a>
						</td>
						<td><?=$i->largura . ' x ' . $i->altura;?> px<br /><?=str_replace( '.', ',', number_format($i->tamanho / 1024, 1) );?> KB</td>
						<td class="acao">
							<img class="excluir" src="<?=img_url('delete.gif')?>" title="Excluir" />
						</td>
					</tr>
			
				<? endforeach; ?>
			</tbody>
		</table>
	<? else : ?>
		<span class="info">Ainda n&atilde;o h&aacute; imagens para esta quest&atilde;o!</span>
	<? endif; ?>
</div>

<script type="text/javascript">

	$(document).ready(function() {
		
		// Excluir imagem
		$('.questao_imagem .lista tr[id_imagem_questao] .excluir').click(function(){
			var id_imagem_questao = $(this).parent().parent().attr('id_imagem_questao');
			
			$('#load').html('Apagando imagem!').removeClass('erro').removeClass('sucesso').addClass('erro');
			
			if (confirm('Esta imagem será APAGADA. Deseja continuar?')) {
				$.get('<?=site_url("questao_imagem/excluir/")?>' + '/' + id_imagem_questao, function(r) {
					if (r.ok) {
						$('#load').html('Imagem apagada!').removeClass('erro').removeClass('sucesso').addClass('sucesso');
						$("div#container_questao_imagem_lista").load('<?=site_url("questao_imagem/lista") . "/" . $id_questao?>');
					}
					else if (r.msg)
						$('#load').html(r.msg).removeClass('erro').removeClass('sucesso').addClass('sucesso');
				}, "json");
			}
		});
		
		center_msg();
	});
	
</script>
