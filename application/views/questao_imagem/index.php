<div id="container_questao_imagem_form" class="container_questao_imagem_form"></div>
<div id="container_questao_imagem_lista" class="container_questao_imagem_lista"></div>

<script type="text/javascript">
	$(document).ready(function(){
			$("div#container_questao_imagem_form").load('<?=site_url("questao_imagem/novo") . "/" . $id_questao?>');
			$("div#container_questao_imagem_lista").load('<?=site_url("questao_imagem/lista") . "/" . $id_questao?>');
	});
</script>


