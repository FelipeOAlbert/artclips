<script>
	$(function() {

		$( "div[id*='dialog_respostas_']" ).dialog({
			autoOpen: false
		});


		$("a[id*='open_respostas_']").click(function(event){
			event.preventDefault();
			var id= $(this).attr("id").replace("open_respostas_","");
			$( "#dialog_respostas_"+id ).dialog("open");
		});
		

		
	});
	</script>
<div class="questao" id_questionario="<?=$id_questionario;?>">
	<? if(count($questoes) > 0) : ?>
		<table class="lista" border="1">
			<thead>
				<tr>
					<th>Quest&atilde;o</th>
					<th>bifurcadora</th>
					<th>Respostas</th>
					<th>Tipo</th>
					<th>A&ccedil;&otilde;es</ht>
				</tr>
			</thead>
			<tbody>
				<? foreach($questoes as $q) : ?>
			
					<tr id_questao="<?=$q->id_questao;?>">
						<td><a href="<?=site_url('resposta/index/'.$q->id_questao);?>"><?=limita_texto($q->descricao, 80);?></a></td>
						<td class="bifurca">&nbsp;
							<?php if($q->bifurca>0): ?>
								<a href="#" id="open_respostas_<?=$q->id_questao;?>">Expande respotas</a>
								<div id="dialog_respostas_<?=$q->id_questao;?>" title="<?=limita_texto($q->descricao, 80);?>">
									<ul>
									<?php foreach($respostas[$q->id_questao] as $resp):?>
										<li><?=$resp['description'];?></li>
									<?php endforeach;?>
									</ul>
								</div>
							<?php endif;?>
						</td>
						<td class="respostas">&nbsp;<?=count($respostas[$q->id_questao]);?></td>
						<td class="tipo">&nbsp;<?=$q->tipo;?></td>
						<td class="acao">
							<? if ( !$questionario_bloqueado): ?>
								<img class="listar_imagens" src="<?=img_url('listar_imagens.gif')?>" title="Imagens" />
								<img class="editar" src="<?=img_url('editar.gif')?>" title="Editar" />
								<img class="excluir" src="<?=img_url('delete.gif')?>" title="Excluir" />
							<? endif; ?>
						</td>
					</tr>
			
				<? endforeach; ?>
			</tbody>
		</table>
	<? else : ?>
		<span class="info">Ainda n&atilde;o h&aacute; quest&otilde;es para este question&aacute;rio!</span>
	<? endif; ?>
</div>

<script type="text/javascript">
	function mostrar_respostas(obj)
	{
		var id_questao = $(obj).parent().attr('id_questao');
		
		$.get('<?=site_url("resposta/index")?>/' + id_questao, function(respostas){
			var respostas = "<tr class='expandir'><td colspan='100%'>" + respostas + "</td></tr>";
			$(obj).parent().after(respostas);
			$(obj).html('-');
		});
	}
	
	function ocultar_respostas(obj)
	{
		var id_questao = $(obj).parent().attr('id_questao');
		
		$(".questao .lista tr[id_questao='" + id_questao + "']").next().remove();
		$(obj).html('+');
	}
	
	$(document).ready(function() {
		
		// Mudar Posição
		<? if ( ! $questionario_bloqueado): ?>
		
			// Permite ordenar das questões
			$(".questao[id_questionario='<?=$id_questionario;?>'] .lista tbody").sortable({ opacity: 0.6, cursor: 'move', revert: false,
			start: function()
			{
				// Correção de bug: Como a sublista de respostas é uma linha individual da tabela questões,
				// ela não é movida junto com a questão, tendo portanto que removê-la para não ficar errado.
				// Procurar uma solução melhor
				$(".questao[id_questionario='<?=$id_questionario;?>'] .lista tr td[colspan='100%']").parent().hide();
				$(".questao[id_questionario='<?=$id_questionario;?>'] .lista tr[id_questao] > td.expandir,"
				+ ".questao[id_questionario='<?=$id_questionario;?>'] .lista tr[id_questao] > td.encolher ").removeClass('encolher').addClass('expandir');
			},
			stop: function()
			{
				// Correção de bug: Como a sublista de respostas é uma linha individual da tabela questões,
				// ela não é movida junto com a questão, tendo portanto que removê-la para não ficar errado.
				// Procurar uma solução melhor
				$(".questao[id_questionario='<?=$id_questionario;?>'] .lista tr td[colspan='100%']").parent().remove();
				$(".questao[id_questionario='<?=$id_questionario;?>'] .lista tr[id_questao] > td.expandir,"
				+ ".questao[id_questionario='<?=$id_questionario;?>'] .lista tr[id_questao] > td.encolher ").removeClass('encolher').addClass('expandir');
			},
			update: function()
			{
				var ordem = new Array();
				var obj = this;
				var i = 1;
			
				$(".questao[id_questionario='<?=$id_questionario;?>'] .lista tr[id_questao]").each(function()
				{
					ordem[i++] = $(this).attr('id_questao');
				});
			
				$.post("<?=site_url('questao/ordenar')?>", {'ordem' : ordem}, function(r)
				{
					if (!r.ok && r.msg) {
						show_msg(r.msg, 'erro', 2000);
						$(obj).sortable('cancel');
					}
				
					// CSS
					$(".questao[id_questionario='<?=$id_questionario;?>'] .lista tr:even").removeClass("linha_impar").addClass("linha_par");
					$(".questao[id_questionario='<?=$id_questionario;?>'] .lista tr:odd").removeClass("linha_par").addClass("linha_impar");
			
				}, 'json' );
			}});
		
		<? endif; ?>
		
		// Expande e encolhe a lista de respostas dentro da questão
		$(".questao[id_questionario='<?=$id_questionario;?>'] .lista tr[id_questao] > td.expandir,"
		+ ".questao[id_questionario='<?=$id_questionario;?>'] .lista tr[id_questao] > td.encolher ").click(function()
		{
			if ( $(this).is('.encolher') )
			{
				$(this).collapse( true );
				
				$(this).removeClass('encolher').addClass('expandir');
			}
			else
			{
				$(this).expand( '<?=site_url("resposta/index")?>' + '/' + $(this).parent().attr('id_questao') );
				
				$(this).removeClass('expandir').addClass('encolher');
			}
		});
		
		// Listar imagens
		$('.questao[id_questionario="<?=$id_questionario;?>"] .lista tr[id_questao] .listar_imagens').click(function(){
			var id_questao = $(this).parent().parent().attr('id_questao');
			
			$.get('<?=site_url("questao_imagem/index")?>/' + id_questao, function(r) {
				if (r) show_msg(r, 'light_box_listar_imagens', 0);
			});
		});
		
		// Excluir questão
		$('.questao[id_questionario="<?=$id_questionario;?>"] .lista tr[id_questao] .excluir').click(function(){
			var id_questao = $(this).parent().parent().attr('id_questao');
			
			if (confirm('Esta questão será APAGADA. Deseja continuar?')) {
				$.get('<?=site_url("questao/excluir")?>/' + id_questao, function(r) {
					if (r.ok)
						$('.questao[id_questionario="<?=$id_questionario;?>"]').parent().loading('<?=site_url("questao/lista/$id_questionario");?>', 'Carregando lista...');
					else if (r.msg)
						show_msg(r.msg, 'erro', 2500);
				}, "json");
			}
		});
		
		// Editar questão
		$('.questao[id_questionario="<?=$id_questionario;?>"] .lista tr[id_questao] .editar').click(function(){
			var id_questao = $(this).parent().parent().attr('id_questao');
			
			$(".nova_questao[id_questionario='<?=$id_questionario?>']").hide();
			$(":button#ver_nova_questao[id_questionario='<?=$id_questionario?>']").hide();
			$("div#container_questao_editar[id_questionario='<?=$id_questionario?>']").loading('<?=site_url("questao/edicao");?>' + '/' + id_questao, 'Carregando formul&aacute;rio...');
		});
		
		// CSS
		$(".questao[id_questionario='<?=$id_questionario;?>'] .lista tr:even").addClass("linha_par");
		$(".questao[id_questionario='<?=$id_questionario;?>'] .lista tr:odd").addClass("linha_impar");
		$(".questao[id_questionario='<?=$id_questionario;?>'] .lista").ajustInParent( { 'width': -40 } );
		$(".questao[id_questionario='<?=$id_questionario;?>'] .lista").css( 'marginLeft', 20 );
	});
</script>



