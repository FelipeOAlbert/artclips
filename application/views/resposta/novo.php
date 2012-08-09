---- Pergunta ---- <br />
<form method="post" style="border:1px solid red">
Descrição: <input type="text" value="<?=$questao?>" size="30" disabled="disabled" /><br>
Tipo da questão: <?=$tipo?><br>
<br>
<?php if(isset($img['file_name']) && trim($img['file_name'])!=""):?>
	<a href="<?=base_url()."uploads/".$img['file_name'];?>">Imagem</a>
<?php endif;?>

<input type="hidden" name="id_questao" value="<?=$id_questao;?>" />
</form> 
<hr>
<h3>respostas</h3>
<?php if($total_resp>0):?>
<div style="border:1px solid green">
	<h3>Existentes</h3>
	<?php foreach($respostas as $resposta):?>
		<?=$resposta->descricao?><br>
	<?php endforeach;?>
</div>
<?php endif;?>

<script type="text/javascript">
$(document).ready(function(){
	$("input[name*='tipo_resp']").click(function(){
		var tipo = $(this).attr("value");
		$("div[id*='resp_']").hide();
		$("div[id='resp_"+tipo+"']").fadeIn();
	});
		

	var idNovo=0;

	/*Clona texto*/
	$("#clona_texto").click(function(){
		var clonado = false;	
		$("p[id*='resposta_texto_']").each(function(){
			if(clonado==false)
				clonado = $(this);
		});

		
		if(clonado!=false){
			idNovo = ( parseInt(idNovo) + 1 );
			
			var html = clonado.html();
			html = html.replace("caminho_resp_0","caminho_resp_"+idNovo+"").replace("caminho_resp_0","caminho_resp_"+idNovo+"");
			$("#resp_texto").append("<p style='border-top: 1px solid red; margin: 10px; padding: 10px;'>"+html+"</p>");
		}
		
	});

	$("input[id='tipo_texto']").trigger('click');
});
</script>

<form id="frmResposta" method="post" action="<?=site_url("resposta/adicionar");?>">
	<input type="hidden" name="id_question" value="<?=$id_questao;?>">
	<input type="hidden" name="bifurca" value="<?=$bifurca;?>">
	<p id="tipo_resp">Tipo de respostas: </p>
	Texto: <input type="radio" id="tipo_texto" name="tipo_resp" value="texto" /><br>
	<!-- Imagem: <input type="radio" name="tipo_resp" value="imagem" /> -->
	<br>
	<br>
	<div id="resp_texto" style="display: none;">
		<h2>RESPOSTAS EM TEXTO <input type='button' id='clona_texto' value='Adicionar alternativa'></h2>
		<p id='resposta_texto_1'>
			Resposta: <input type="text" name="resposta_texto[]" >
			<?php if($bifurca==1):?>
			<br />
				Caminho 1: <input type='radio' name='caminho_resp_0' value='1' /> | Caminho 2: <input type='radio' name='caminho_resp_0' value='2' />
			<?php endif;?>
		</p>
		
		
	</div>
	
	<div id="resp_imagem" style="display: none;">
		<h2>RESPOSTAS em IMAGENS</h2>
		
	</div>
	<br>
	<br>
	<input type="submit" value="Cadastrar respostas" name="enviado" />
</form>
