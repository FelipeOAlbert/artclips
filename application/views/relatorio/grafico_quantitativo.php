<?=js('google_jsapi.js');?>


<?
	$grafico_dados = implode($grafico_dados, ", ");

// Configurações padrões
$config = array(
	'id' => md5( microtime() ),
	'type' => 'ColumnChart',
	'title' => '',
	'width' => 1200,
	'height' => 400,
	'column' => array();
);

$config = (object) $config;

?>

<div id="<?=$config->id?>" style="width:100%"></div>

<script type="text/javascript">
	
	$('#<?=$config->id?>').showLoad('Carregando o gr&aacute;fico...');//.scrollIntoView();
	
	google.load("visualization", "1", {packages:["corechart"]});
	
	$(document).ready( function()
	{
		var width  = <?=$config->width; ?>;
		var height = <?=$config->height;?>;
		
		width = $("#<?=$config->id;?>").width();
		
		var dados = new google.visualization.DataTable();

		dados.addColumn('string', 'Posição da resposta');
		dados.addColumn('number', 'Respostas');
		dados.addRows(
			[
				<?= $grafico_dados; ?>
			]
		);

		var grafico = new google.visualization.<?=$config->type?>( document.getElementById("<?=$config->id?>") );
		
		grafico.draw(
			dados,
			{
				width: width, height: height,
				title: "<?=$config->title?>",
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
			//$('#<?=$config->id?>').scrollIntoView();
		});
	});
</script>
