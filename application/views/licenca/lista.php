<div class="licenca">
	<? if( !empty($questionario_licenca) ) : ?>
		<table class="lista">
			<tbody>
				<? foreach($questionario_licenca as $q) : ?>
			
					<tr>
						<td class="descricao">
							<div>
								Question&aacute;rio: <b><?=limita_texto($q->questionario, 80);?></b>
							</div>
							<div>
								Evento: <b><?=limita_texto($q->evento, 80);?></b>
							</div>
							<div>
								Endereço:
								<b>
									<?=( !empty($q->logradouro) ) ? $q->logradouro : ''?>
									<?=( !empty($q->numero	) ) ? ', ' . $q->numero : ''?>
									<?=( !empty($q->cep		) ) ? ' - CEP: ' . $q->cep : ''?>
									<?=( !empty($q->cidade	) ) ? ' - ' . $q->cidade : ''?>
									<?=( !empty($q->uf		) ) ? ' - ' . $q->uf : ''?>
									<?=( !empty($q->bairro	) ) ? ', ' . $q->bairro : ''?>
								</b>
							</div>
							<div>
							
							</div>
						</td>
						
						<td class="validade">
							<div>Licenciado em: <b><?=$q->data_licencimento_formatada;?></b></div>
							
							<? if ($q->id_tipo_licenca == LICENSE_TYPE_TIME ): ?>
								
								<div>
									Validade: <b><?=$q->data_expiracao_formatada;?></b> (<b><?=$q->validade;?></b> dias)
								</div>
								
								<? if ( empty($q->expirado)  ): ?>
									<div>
										Tempo restante: <b><?=$q->tempo_restante;?></b> <?=( $q->tempo_restante > 1 ) ? 'dias' : 'dia' ;?>
									</div>
								<? endif; ?>
								
							<? elseif ($q->id_tipo_licenca == LICENSE_TYPE_QUANT): ?>
								<div>
									Validade: <b><?=$q->validade;?></b> entrevistas
								</div>
							<? endif; ?>
							<div>
								Valor da licen&ccedil;a: <b>R$ <?=money_EUA_to_BR($q->valor);?></b>
							</div>
							<div>
								Estado: <?= ( !empty($q->expirado) ) ? '<span class="expirado">Expirado</span>' :  '<span class="ativo">Ativo</span>' ?>
							</div>
						</td>
					</tr>
			
				<? endforeach; ?>
			</tbody>
		</table>
	<? else : ?>
		<span class="info">Ainda n&atilde;o h&aacute; question&aacute;rio licenciado!</span>
	<? endif; ?>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		// CSS
		$(".licenca .lista tr:even").addClass("linha_par");
		$(".licenca .lista tr:odd").addClass("linha_impar");
		
	});
</script>
