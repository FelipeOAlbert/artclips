<style type="text/css">
	.relatorio_questionario div.lista {
		text-align: left;
	}
	.relatorio_questionario .lista .posicao {
		width: 80px;
		border-right:1px dashed #ccc;
		color: #333;
	}
	.relatorio_questionario .lista .voto, .relatorio_questionario .lista .percentagem {
		width: 80px;
	}
</style>

<div class="relatorio_questionario">

	<? if ( empty( $questao ) && count( $questionarios ) <= 1 ) : ?>
	<!-- NÃO POSSUI QUESTIONÁRIOS -->
	
		<span class="info">Ainda n&atilde;o h&aacute; question&aacute;rio respondido!</span>

	<? elseif ( empty( $questao ) ) : ?>
	<!-- NÃO SELECIONOU O QUESTIONÁRIO -->
		<h2>
			<form>
				Question&aacute;rio <?= form_dropdown(NULL, $questionarios, 0, 'class="questionarios"');?>
			</form>
		</h2>
	
	<? else: ?>
	<!-- EXIBE O RELATÓRIO -->
	
		<h2>
			<form>
				Question&aacute;rio <?= form_dropdown(NULL, $questionarios, $questao->id_questionario, 'class="questionarios"');?>
	
				-
		
				<? $paginas = range(0, $quantidade_questoes);?>
				<? unset($paginas[0]);?>
		
				Pergunta <?= form_dropdown(NULL, $paginas, $pagina, 'class="questoes"');?> de <?=$quantidade_questoes;?>.
			</form>
		</h2>
		
		<? if ( $questao->id_tipo == QUEST_DISSERTATIVA ) : ?>
		<!-- QUESTÃO DISSERTATIVA -->
		
			<span class="info">Quest&otilde;es dissertativas n&atilde;o possuem relat&oacute;rio.</span>
		
		<? else : ?>
		
			<!-- div class="pagina">
				<input class="anterior" type="button" value="Anterior" <?=( $pagina > 1 )? '' : 'style="visibility:hidden"'?> />
	
				<input class="proxima" type="button" value="Pr&oacute;ximo" style="float:right; <?=( $pagina < $quantidade_questoes )? '' : 'visibility:hidden'?>" />
			</div -->
	
			<div class="conteudo lista">
				<div>
					<?=$evento->nome;?> - criado em <?=$evento->data_criacao;?> &agrave;s <?=$evento->hora_criacao;?>
				</div>
				<div>
					<?=$questionario->nome;?> - criado em <?=$questionario->data_criacao;?> &agrave;s <?=$questionario->hora_criacao;?>
				</div>
			
				<br />
			
				<h4>
					<?=$questao->descricao;?>
				</h4>
	
				<table class="lista">
					<thead>
		
					<thead>
					<tbody>
		
						<? if ( $questao->id_tipo == QUEST_QUANTITATIVA ) : ?>
						
							<?
								$total_respostas = 0;
								$total_peso      = 0;
								
								foreach( $grafico as $posicao => $dado )
								{
									$total_respostas += $dado->respostas;
									$total_peso      += $dado->peso;
								}
							?>
						
							<? foreach ( $respostas as $r ) : ?>
		
								<tr>
									<td class="posicao">Resposta <?=$r->posicao;?></td>
									<td class="percentagem">
										<?=$grafico[$r->posicao]->respostas?> - <?=number_format( $grafico[$r->posicao]->respostas*100/$total_respostas, 2 )?>%
										/
										<?=$grafico[$r->posicao]->peso?> - <?=number_format( $grafico[$r->posicao]->peso*100/$total_peso, 2 )?>%
									</td>
									<td class="descricao"><?=$r->descricao;?></td>
								</tr>
		
							<? endforeach; ?>
						<? else : ?>
						
							<? foreach ( $respostas as $r ) : ?>
		
								<tr>
									<td class="posicao">Resposta <?=$r->posicao;?></td>
									<td class="percentagem"><?=$grafico[$r->posicao]?> - <?=number_format( $grafico[$r->posicao]*100/array_sum($grafico), 2 )?>%</td>
									<td class="descricao"><?=$r->descricao;?></td>
								</tr>
		
							<? endforeach; ?>
						
						<? endif;?>
		
					</tbody>
				</table>
	
				<h4>
					Total de <?= $quantidade_entrevistados; ?> entrevistados.
				</h4>

				<? $grafico_dados = array(); ?>
				<? $config = array(); ?>
				
				<? if ( $questao->id_tipo == QUEST_QUANTITATIVA ) : ?>
					<?
						// Configura as colunas do gráfico
						$config['column']   = array();
						$config['column'][] = array('string' => 'Posição da resposta');
						$config['column'][] = array('number' => 'Respostas');
						$config['column'][] = array('number' => 'Pesos');
						
						// Monta os dados
						foreach ( $grafico as $posicao => $dado )
						{
							$grafico_dados[] = "['" . 'Resposta ' . $posicao . "', " . $dado->respostas . ", " . $dado->peso . "]";
						}
					?>
				<? else : ?>
					<?
						// Configura as colunas do gráfico
						$config['column']   = array();
						$config['column'][] = array('string' => 'Posição da resposta');
						$config['column'][] = array('number' => 'Respostas');
						
						foreach ( $grafico as $posicao => $dado )
						{
							$grafico_dados[] = "['" . 'Resposta ' . $posicao . "', " . $dado . "]";
						}
					?>				
				<? endif; ?>
				
				<!-- GRÁFICO -->
				<?= $this->load->view( 'relatorio/grafico', array( 'grafico_dados' => $grafico_dados, 'config' => $config ), TRUE ); ?>
	
			</div>
		
		<? endif; ?>

	<? endif; ?>

	<script type="text/javascript">

		$(document).ready( function()
		{
			$('select.questoes').change( function()
			{
				show_loading();
			
				window.location = '<?=site_url("relatorio/questionario")?>' + '/' + $('select.questionarios').val() + '/' + $(this).val();
			});
			
			$('select.questionarios').change( function()
			{
				show_loading();
			
				window.location = '<?=site_url("relatorio/questionario")?>' + '/' + $(this).val() + '/' + 1;
			});
			
			/*
			$('.pagina .proxima').click( function()
			{
				show_loading();
			
				window.location = '<?=site_url("relatorio/questionario/$id_questionario/" . ( $pagina + 1 ) )?>';
			});
			$('.pagina .anterior').click( function()
			{
				show_loading();
			
				window.location = '<?=site_url("relatorio/questionario/$id_questionario/" . ( $pagina - 1 ) )?>';
			});
			*/
			
			// CSS
			$(".lista tr:even").addClass("linha_par");
			$(".lista tr:odd").addClass("linha_impar");
		});

	</script>
</div>
