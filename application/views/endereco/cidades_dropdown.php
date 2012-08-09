<?= js('jquery-1.6.2.min.js');?>
<?= js('funcoes.js');?>
<label>Cidade:</label>
<?=form_dropdown('endereco_cidade', $cidades, $default_cidade, 'id="endereco_cidade" class="endereco_cidade"');?>

<div id="bairros" class="bairros"></div>

<script type="text/javascript">
	function carrega_dropdown_bairros( id_cidade, id_bairro )
	{
		// Imagem de loading
		$('.bairros').html('<img class="loading" src="<?=img_url('loading.gif');?>" /> Carregando bairros...').show();
		
		if ( is_empty( id_cidade ) ) {
			$('.bairros').html('');
		} else if ( is_empty( id_bairro ) ) {
			$('.bairros').load("<?=site_url('endereco/dropdown_bairros_por_cidade');?>/" + id_cidade);
		} else {
			$('.bairros').load("<?=site_url('endereco/dropdown_bairros_por_cidade');?>/" + id_cidade + "/" + id_bairro);
		}
	}
	$(document).ready(function() {
	
		carrega_dropdown_bairros( <?=$default_cidade;?>, <?=$default_bairro?> );
	
		$('.endereco_cidade').change(function() {
	
			// remove a opção padrão "selecione"
			$('.endereco_cidade option[value="0"]').remove();
			
			carrega_dropdown_bairros( $('.endereco_cidade').val() );
		});
	});
</script>
