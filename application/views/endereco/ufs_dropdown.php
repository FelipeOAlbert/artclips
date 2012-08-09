<?= js('jquery-1.6.2.min.js');?>
<?= js('funcoes.js');?>
<label>UF:</label>
<?=form_dropdown('endereco_uf', $ufs, strtoupper( (string) $default_uf ), 'id="endereco_uf" class="endereco_uf"');?>

<div id="cidades" class="cidades"></div>

<script type="text/javascript">
	function carrega_dropdown_cidades( id_uf, id_cidade, id_bairro)
	{
		// Imagem de loading
		$('.cidades').html('<img class="loading" src="<?=img_url('loading.gif');?>" /> Carregando cidades...').show();
		
		if ( is_empty( id_uf ) ) {
			$('.cidades').html('');
		} else if ( is_empty( id_cidade ) ) {
			$('.cidades').load("<?=site_url('endereco/dropdown_cidades_por_uf');?>/" + id_uf);
		} else if ( is_empty( id_bairro ) ) {
			$('.cidades').load("<?=site_url('endereco/dropdown_cidades_por_uf');?>/" + id_uf + "/" + id_cidade);
		} else {
			$('.cidades').load("<?=site_url('endereco/dropdown_cidades_por_uf');?>/" + id_uf + "/" + id_cidade + "/" + id_bairro);
		}
	}
	$(document).ready(function() {
	
		carrega_dropdown_cidades( '<?=$default_uf;?>', <?=$default_cidade;?>, <?=$default_bairro;?> );
	
		$('.endereco_uf').change(function() {
		
			// remove a opção padrão "selecione"
			$('.endereco_uf option[value="0"]').remove();
		
			carrega_dropdown_cidades( $('.endereco_uf').val() );
		});
	});
</script>
