<div class="evento">
	<? if(count($eventos) > 0) : ?>
		<table class="lista">
			<thead>
				<tr>
					<th ></th>
					<th>Nome</th>
					<th>Data de Cria&ccedil;&atilde;o</th>
					<th>A&ccedil;&otilde;es</ht>
				</tr>
			</thead>
			<tbody>
				<? foreach($eventos as $q) : ?>
			
					<tr id_evento="<?=$q->id_evento;?>">
						<td class="expandir"></td>
						<td><a href="<?=site_url("questionario/index/".$q->id_evento);?>" title="ver evento"><?=limita_texto($q->nome, 80);?></a></td>
						<td class="data"><?=$q->data_criacao . ' &agrave;s ' . $q->hora_criacao;?></td>
						<td class="acao">
							<img class="editar" src="<?=img_url('editar.gif')?>" title="Editar" />
							<img class="excluir" src="<?=img_url('delete.gif')?>" title="Excluir" />
						</td>
					</tr>
			
				<? endforeach; ?>
			</tbody>
		</table>
	<? else : ?>
		<span class="info">Nenhum evento encontrado!</span>
	<? endif; ?>
</div>

<script type="text/javascript">

	$(document).ready(function() {
	
		// Expande e encolhe a lista de questionários dentro do evento
		$(".evento tr td.expandir, .evento tr td.encolher").click(function()
		{
			if ( $(this).is('.encolher') )
			{
				$(this).collapse( true );
				
				$(this).removeClass('encolher').addClass('expandir');
			}
			else
			{
				$(this).expand( '<?=site_url("questionario/index")?>' + '/' + $(this).parent().attr('id_evento'), 'Carregando question&aacute;rios...' );
				
				$(this).removeClass('expandir').addClass('encolher');
			}
		});
		
		// Excluir evento
		$(".evento .lista tr .excluir").click(function()
		{
			var id_evento = $(this).parent().parent().attr('id_evento');
			
			if (confirm('Este evento será APAGADO. Deseja continuar?'))
			{
				$.get('<?=site_url("evento/excluir")?>/' + id_evento, function(r)
				{
					if (r.ok)
						$(".evento").parent().load('<?=site_url("evento/lista");?>');
					else if (r.msg)
						show_msg(r.msg, 'erro', 2500);
				}, "json");
			}
		});
		
		// Editar evento
		$(".evento .lista tr .editar").click(function()
		{
			var id_evento = $(this).parent().parent().attr('id_evento');
			
			$('.novo_evento').hide();
			$('.ver_novo_evento').hide();
			
			$("div#container_evento_editar").loading('<?=site_url("evento/edicao");?>' + '/' + id_evento, 'Carregando formul&aacute;rio');
		});
		
		// CSS
		$(".evento .lista tr:even").addClass("linha_par");
		$(".evento .lista tr:odd").addClass("linha_impar");
		
	});
</script>
