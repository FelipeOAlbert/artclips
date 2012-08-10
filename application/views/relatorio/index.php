<? //printr($users);
//echo current_url();
?>

<div>
    <h1>Relat&oacuterios</h1>
    
    <div id="abas">
        <ul>
            <li><a href="#informacoes-1">Visitantes</a></li>
            <li><a href="#informacoes-2">Contato</a></li>
            <li><a href="#informacoes-3">Sobre</a></li>
        </ul>
        
        <div id="informacoes-1">
            
            <?if(isset($users)){?>
            
            <script type="text/javascript">
                google.load("visualization", "1", {packages:["corechart"]});
                google.setOnLoadCallback(drawChart);
                function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                        ['Visitantes', 'Total'],
                        ['Homens',      <?=$users['quant_man']?>],
                        ['Mulheres',    <?=$users['quant_woman']?>]
                    ]);
            
                var options = {
                  title: 'Quantidade de visitantes'
                };
            
                var chart = new google.visualization.PieChart(document.getElementById('chart_man_woman'));
                chart.draw(data, options);
                }
            </script>
            
            <h1>Quantidade de visitantes</h1>
            
            <table border="2px" width="800px">
                <tr>
                    <td width="25%">Homens</td>
                    <td width="25%"><?=$users['quant_man']?></td>
                    <td width="25%">
                        <div class="bar_mortice">
                            <div class="progress blue" style="width: <?=$users['perc_man']?>%;"></div>
                        </div>                    
                    </td>
                    <td width="25%"><?=$users['perc_man']?>%</td>
                </tr>
                <tr>
                    <td width="25%">Mulheres</td>
                    <td width="25%"><?=$users['quant_woman']?></td>
                    <td width="25%">
                        <div class="bar_mortice">
                            <div class="progress pink" style="width: <?=$users['perc_woman']?>%;"></div>
                        </div>                    
                    </td>
                    <td width="25%"><?=$users['perc_woman']?>%</td>
                </tr>
            </table>
            
            <div id="chart_man_woman" style="width: 400px; height: 200px;"></div>
            
            <h1>Faixa etária</h1>
            
            <table border="2px" width="800px">
                
            </table>
            
            <?}else{?>
            <p>Não há dados para aprensentar!</p>
            <?}?>
        </div>
        
        <div id="informacoes-2">
            <p>Esta é a segunda aba!</p>
        </div>
        
        <div id="informacoes-3">
            <p>Esta é a terceira aba!</p>
        </div>
    </div>
    
    
</div>