<?= js('jquery-1.6.2.min.js');?>
<?= js('funcoes.js');?>
<label>Bairro:</label>
<?=form_dropdown('endereco_bairro', $bairros, $default_bairro, 'id="endereco_bairro" class="endereco_bairro"');?>

<script type="text/javascript">
	$(document).ready(function() {
		$('.endereco_bairro').change(function() {
	
			// remove a opção padrão "selecione"
			$('.endereco_bairro option[value="0"]').remove();
		});
	});
</script>


