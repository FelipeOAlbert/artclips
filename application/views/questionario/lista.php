<div class="questionario" id_evento="<?=$id_evento;?>">
	<? if(count($questionarios) > 0) : ?>
		<table class="lista">
			<thead>
				<tr>
					<th></th>
					<th>Question&aacute;rio</th>
					<th>Data de Cria&ccedil;&atilde;o</th>
					<th>Licenciado</th>
					<th>A&ccedil;&otilde;es</ht>
				</tr>
			</thead>
			<tbody>
				<? foreach($questionarios as $q) : ?>
			
					<tr id_questionario="<?=$q->id_questionario;?>">
						<td class="expandir"></td>
						<td><a href="<?=site_url("questao/index/".$q->id_questionario);?>" title="ver questionario"><?=limita_texto($q->nome, 80);?></a></td>
						<td class="data"><?=$q->data_criacao . ' &agrave;s ' . $q->hora_criacao;?></td>
						<td class="licenciado"><?= ((int) $q->disponivel) ? 'Sim' : 'N&atilde;o';?></td>
						<td class="acao">
							<img class="duplicar" src="<?=img_url('duplicar.png')?>" title="Duplicar" />
							<? if ( !(int) $q->disponivel): ?>
								<img class="editar" src="<?=img_url('editar.gif')?>" title="Editar" />
								<img class="excluir" src="<?=img_url('delete.gif')?>" title="Excluir" />
							<? endif; ?>
						</td>
					</tr>
			
				<? endforeach; ?>
			</tbody>
		</table>
	<? else : ?>
		<span class="info">Ainda n&atilde;o h&aacute; question&aacute;rios para este evento!</span>
	<? endif; ?>
</div>

<script type="text/javascript">
	
	$(document).ready(function()
	{
		// Expande e encolhe a lista de questões dentro do questionário
		$(".questionario[id_evento='<?=$id_evento;?>'] .lista tr[id_questionario] > td.expandir,"
		+ ".questionario[id_evento='<?=$id_evento;?>'] .lista tr[id_questionario] > td.encolher ").click(function()
		{
			if ( $(this).is('.encolher') )
			{
				$(this).collapse( true );
				
				$(this).removeClass('encolher').addClass('expandir');
			}
			else
			{
				$(this).expand( '<?=site_url("questao/index")?>' + '/' + $(this).parent().attr('id_questionario') );
				
				$(this).removeClass('expandir').addClass('encolher');
			}
		});
		
		// Excluir questionario
		$(".questionario[id_evento='<?=$id_evento;?>'] .lista tr[id_questionario] .excluir").click(function()
		{
			var id_questionario = $(this).parent().parent().attr('id_questionario');
			
			if (confirm('Este questionário será APAGADO. Deseja continuar?')) {
				$.get('<?=site_url("questionario/excluir")?>/' + id_questionario, function(r) {
					if (r.ok)
						$(".questionario[id_evento='<?=$id_evento;?>']").parent().loading('<?=site_url("questionario/lista/$id_evento");?>');
					else if (r.msg)
						show_msg(r.msg, 'erro', 2500);
				}, "json");
			}
		});
		
		// Duplicar questionário
		$(".questionario[id_evento='<?=$id_evento;?>'] .lista tr[id_questionario] .duplicar").click(function()
		{
			var id_questionario = $(this).parent().parent().attr('id_questionario');
			
			$.get('<?=site_url("evento/selecionar")?>/' + id_questionario, function(r) {
				// Macete!!!
				if (r) show_msg(r, 'light_box_evento_duplicar_questionario', 0);
			});
		});
		
		// Editar evento
		$(".questionario[id_evento='<?=$id_evento;?>'] .lista tr[id_questionario] .editar").click(function()
		{
			var id_questionario = $(this).parent().parent().attr('id_questionario');
			
			$(".novo_questionario[id_evento='<?=$id_evento?>']").hide();
			$(":button#ver_novo_questionario[id_evento='<?=$id_evento?>']").hide();
			$("div#container_questionario_editar[id_evento='<?=$id_evento?>']").loading('<?=site_url("questionario/edicao");?>' + '/' + id_questionario);
		});
		
		// CSS
		$(".questionario[id_evento='<?=$id_evento;?>'] .lista tr:even").addClass("linha_par");
		$(".questionario[id_evento='<?=$id_evento;?>'] .lista tr:odd").addClass("linha_impar");
		$(".questionario[id_evento='<?=$id_evento;?>'] .lista").ajustInParent( { 'width': -40 } );
		$(".questionario[id_evento='<?=$id_evento;?>'] .lista").css( 'marginLeft', 20 );
	});
</script>
