<? //printr($users);
//echo current_url();
?>

<div>
    <h1>Relat&oacuterios - <?=$event[0]['event_name']?></h1>
    
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
            
            <script type="text/javascript">
                google.load("visualization", "1", {packages:["corechart"]});
                google.setOnLoadCallback(drawChart);
                function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                        ['Faixa Etária', 'Total'],
                        ['Entre 18 à 25 anos',      <?=$users['quant_age_18_25']?>],
                        ['Entre 26 à 32 anos',      <?=$users['quant_age_26_32']?>],
                        ['Entre 33 à 40 anos',      <?=$users['quant_age_33_40']?>],
                        ['Entre 41 à 50 anos',      <?=$users['quant_age_41_50']?>],
                        ['Mais de 51 anos',         <?=$users['quant_age_51_plus']?>],
                    ]);
            
                var options = {
                  title: 'Faixa etária'
                };
            
                var chart = new google.visualization.PieChart(document.getElementById('chart_years'));
                chart.draw(data, options);
                }
            </script>
            
            <table border="2px" width="800px">
                
                <tr>
                    <td width="25%">Entre 18 à 25 anos</td>
                    <td width="25%"><?=$users['quant_age_18_25']?></td>
                    <td width="25%">
                        <div class="bar_mortice">
                            <div class="progress blue" style="width: <?=$users['percent_age_18_25']?>%;"></div>
                        </div>                    
                    </td>
                    <td width="25%"><?=$users['percent_age_18_25']?>%</td>
                </tr>
                
                <tr>
                    <td width="25%">Entre 26 à 32 anos</td>
                    <td width="25%"><?=$users['quant_age_26_32']?></td>
                    <td width="25%">
                        <div class="bar_mortice">
                            <div class="progress blue" style="width: <?=$users['percent_age_26_32']?>%;"></div>
                        </div>                    
                    </td>
                    <td width="25%"><?=$users['percent_age_26_32']?>%</td>
                </tr>
                
                <tr>
                    <td width="25%">Entre 33 à 40 anos</td>
                    <td width="25%"><?=$users['quant_age_33_40']?></td>
                    <td width="25%">
                        <div class="bar_mortice">
                            <div class="progress blue" style="width: <?=$users['percent_age_33_40']?>%;"></div>
                        </div>                    
                    </td>
                    <td width="25%"><?=$users['percent_age_33_40']?>%</td>
                </tr>
                
                <tr>
                    <td width="25%">Entre 41 à 50 anos</td>
                    <td width="25%"><?=$users['quant_age_41_50']?></td>
                    <td width="25%">
                        <div class="bar_mortice">
                            <div class="progress blue" style="width: <?=$users['percent_age_41_50']?>%;"></div>
                        </div>                    
                    </td>
                    <td width="25%"><?=$users['percent_age_41_50']?>%</td>
                </tr>
                
                <tr>
                    <td width="25%">Mais de 51 anos</td>
                    <td width="25%"><?=$users['quant_age_51_plus']?></td>
                    <td width="25%">
                        <div class="bar_mortice">
                            <div class="progress blue" style="width: <?=$users['percent_age_51_plus']?>%;"></div>
                        </div>                    
                    </td>
                    <td width="25%"><?=$users['percent_age_51_plus']?>%</td>
                </tr>
                
            </table>
            
            <div id="chart_years" style="width: 400px; height: 200px;"></div>
            
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