<div class="resposta" id_questao="<?=$id_questao;?>">
	<? if(count($respostas) > 0) : ?>
		<table class="lista">
			<thead>
				<tr>
					<th>Resposta</th>
					
					<? if ( $tipo_questao == QUEST_QUANTITATIVA ) : ?>
						<th>Peso</th>
					<? endif;?>
					
					<th>A&ccedil;&otilde;es</ht>
				</tr>
			</thead>
			<tbody>
				<? foreach($respostas as $q) : ?>
			
					<tr id_resposta="<?=$q->id_resposta;?>">
						<td><?=limita_texto($q->descricao, 80);?></td>
						
						<? if ( $tipo_questao == QUEST_QUANTITATIVA ) : ?>
							<td class="peso"><?=(!empty($q->peso))?$q->peso:'-';?></td>
						<? endif;?>
						
						<td class="acao">
							<? if ( !$questionario_bloqueado ): ?>
								<img class="editar" src="<?=img_url('editar.gif')?>" title="Editar" />
								<img class="excluir" src="<?=img_url('delete.gif')?>" title="Excluir" />
							<? endif; ?>
						</td>
					</tr>
			
				<? endforeach; ?>
			</tbody>
		</table>
	<? else : ?>
		<span class="info">Ainda n&atilde;o h&aacute; respostas para esta quest&atilde;o!</span>
	<? endif; ?>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		
		// Mudar Posição
		<? if (! $questionario_bloqueado): ?>
			$(".resposta[id_questao='<?=$id_questao;?>'] .lista tbody").sortable({ opacity: 0.6, cursor: 'move', revert: false, update: function() {
			
				var ordem = new Array();
				var obj = this;
				var i = 1;
			
				$(".resposta[id_questao='<?=$id_questao;?>'] .lista tr[id_resposta]").each(function() {
					ordem[i++] = $(this).attr('id_resposta');
				});
			
				$.post("<?=site_url('resposta/ordenar')?>", {'ordem' : ordem}, function(r) {
					if (!r.ok && r.msg) {
						show_msg(r.msg, 'erro', 2000);
						$(obj).sortable('cancel');
					}
				
					// CSS
					$(".resposta[id_questao='<?=$id_questao;?>'] .lista tr:even").removeClass("linha_impar").addClass("linha_par");
					$(".resposta[id_questao='<?=$id_questao;?>'] .lista tr:odd").removeClass("linha_par").addClass("linha_impar");
			
				}, 'json' );
			}});
		<? endif;?>
		
		// Excluir resposta
		$(".resposta[id_questao='<?=$id_questao;?>'] .lista tr[id_resposta] .excluir").click(function(){
			var id_resposta = $(this).parent().parent().attr('id_resposta');
			
			if (confirm('Esta resposta será APAGADA. Deseja continuar?')) {
				$.get('<?=site_url("resposta/excluir")?>/' + id_resposta, function(r) {
					if (r.ok)
						$(".resposta[id_questao='<?=$id_questao;?>']").parent().loading('<?=site_url("resposta/lista/$id_questao");?>', 'Carregando lista...');
					else if (r.msg)
						show_msg(r.msg, 'erro', 2500);
				}, "json");
			}
		});
		
		// Editar resposta
		$(".resposta[id_questao='<?=$id_questao;?>'] .lista tr[id_resposta] .editar").click(function(){
			var id_resposta = $(this).parent().parent().attr('id_resposta');
			
			$(".nova_resposta[id_questao='<?=$id_questao?>']").hide();
			$(":button#ver_nova_resposta[id_questao='<?=$id_questao?>']").hide();
			
			$("div#container_resposta_editar[id_questao='<?=$id_questao?>']").loading('<?=site_url("resposta/edicao");?>' + '/' + id_resposta, 'Carregando formul&aacute;rio...');
		});
		
		
		// CSS
		$(".resposta[id_questao='<?=$id_questao;?>'] .lista tr:even").addClass("linha_par");
		$(".resposta[id_questao='<?=$id_questao;?>'] .lista tr:odd").addClass("linha_impar");
		$(".resposta[id_questao='<?=$id_questao;?>'] .lista").ajustInParent( { 'width': -40 } );
		$(".resposta[id_questao='<?=$id_questao;?>'] .lista").css( 'marginLeft', 20 );
	});
</script>
