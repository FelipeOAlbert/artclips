<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?=(isset($dados->title)) ? $dados->title : "Interview";?>	</title>
	<base href="<?=base_url();?>" />
	<!-- CSS -->
	<?= css('style.css');?>
	<?= css('cupertino/jquery-ui-1.8.16.custom.css');?>
	<?= css('jquery_extends/jquery.extends.css');?>
	<?= css('arrowsandboxes.css');?>
	
	<!-- JavaScript -->
	<?= js('jquery-1.6.2.min.js');?>
	<?= js('jquery-ui-1.8.16.custom.min.js');?>
	<?= js('jquery-centerinclient.js');?>
	<?= js('jquery.ui.datepicker-pt-BR.js');?>
	<?//= js('jquery.scrollIntoView.js');?>
	<?= js('jquery.form.js');?>
	<?= js('jquery.extends.js');?>
	<?= js('form.js');?>
	<?= js('funcoes.js');?>
	<?= js('functions.js');?>
	<?= js('jquery.wz_jsgraphics.js');?>
	<?= js('arrowsandboxes.js');?>
	<?= js('tiny_mce/jquery.tinymce.js');?>


		
</head>
<body>
<a href="<?=site_url('principal/logout');?>" class="loading">Sair</a>
<h1><?=(isset($dados->title)) ? $dados->title : "";?>	</h1>
<? $this->load->view($view, $dados); ?>

	<div class="sistema_mensagem"><span></span></div>
	<div class="fundo"></div>
	<p class="loading_content" id="loading_content">
		<br />Carregando...
		<br /><span style="font-size: 9px;">(clique a qualquer momento para fechar este aviso)</span>
		<br/><img src="<?=base_url()?>images/loading.gif" />
	</p>

	<script type="text/javascript">
		function atualiza_resumo(){
			$(".footer .resumo").load('<?=site_url('chamados/carrega_resumo');?>');
		}
		
		$(".loading").click(function(){
			show_loading();
		});
	
		$(document).ready(function(){
			$(".fundo, .sistema_mensagem, .loading_content").click(function(){
				hide_loading();
			});
			$(".loading").click(function(){
				show_loading();
			});
		});
	</script>
</body>
</html>