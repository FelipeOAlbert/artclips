<div id="container_licenca_form" class="container_licenca_form"></div>
<div id="container_licenca_lista" class="container_licenca_lista"></div>

<script type="text/javascript">

	$(document).ready(function(){
		$("div#container_licenca_form").loading('<?=site_url("licenca/ativacao");?>', 'Carregando formul&aacute;rio');
		$("div#container_licenca_lista").loading('<?=site_url("licenca/lista");?>', 'Carregando lista');
	});

</script>


