<?=js('google_jsapi.js');?>


<?
	$grafico_dados = implode($grafico_dados, ", ");

// Configurações padrões
$configuracao = array(
	'id' => md5( microtime() ),
	'type' => 'ColumnChart',
	'title' => '',
	'width' => 1200,
	'height' => 400,
	'column' => array(),
);

$configuracao = (object) $configuracao;

?>

<div id="<?=$configuracao->id?>" style="width:100%"></div>

<script type="text/javascript">
	
	$('#<?=$configuracao->id?>').showLoad('Carregando o gr&aacute;fico...');//.scrollIntoView();
	
	google.load("visualization", "1", {packages:["corechart"]});
	
	$(document).ready( function()
	{
		var width  = <?=$configuracao->width; ?>;
		var height = <?=$configuracao->height;?>;
		
		width = $("#<?=$configuracao->id;?>").width();
		
		var dados = new google.visualization.DataTable();

		<? foreach ($config['column'] as $coluna) : ?>
			dados.addColumn('<?= array_shift( array_keys($coluna) ) ;?>', '<?= $coluna[ array_shift( array_keys($coluna) ) ] ;?>');
		<? endforeach; ?>
		
		dados.addRows(
			[
				<?= $grafico_dados; ?>
			]
		);

		var grafico = new google.visualization.<?=$configuracao->type?>( document.getElementById("<?=$configuracao->id?>") );
		
		grafico.draw(
			dados,
			{
				width: width, height: height,
				title: "<?=$configuracao->title?>",
				titleTextStyle:
					{
						fontSize: 24,
						color: '#000066'
					},
				colors:['blue', '#33FF33']
			//hAxis: {title: 'Dias', titleTextStyle: {color: '#0000FF'}}
			}
		);
		
		google.visualization.events.addListener(grafico, 'ready', function()
		{
			//$('#<?=$configuracao->id?>').scrollIntoView();
		});
	});
</script>
