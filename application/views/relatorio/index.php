<? //printr($users);
//echo current_url();

//$data_chart = array();

?>

<div>
    <h1>Relat&oacuterios - <?=$event[0]['name']?></h1>
    <br>
    <br>
    <div id="abas">
        <ul>
            <li><a href="#informacoes-visitantes">Visitantes</a></li>
            <?if($questionnaire){ foreach($questionnaire as $k => $v){ ?>
            <li><a href="#informacoes-<?=$k?>"><?=$v['name']?></a></li>
            <?}}?>
        </ul>
        
        <div id="informacoes-visitantes">
            
            <? if($users){ ?>
            
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
            <br>
            <br>
            <table class="table" width="800px">
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
            <br>
            <br>
            <div id="chart_man_woman" class="charts"></div>
            <br>
            <br>
            <h1>Faixa etária</h1>        
            <br>
            <br>
            
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
            
            <table class="table">
                
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
            <br>
            <br>
            <div id="chart_years" class="charts"></div>
            
            <?}else{?>
            <p>Não há dados para aprensentar!</p>
            <?}?>
        </div>
        
        <?
            if($questionnaire){
                foreach($questionnaire as $k => $v){
        ?>
        <div id="informacoes-<?=$k?>">
            <!--<p>Esta é a segunda aba!</p>-->
            <?
                foreach ($questionnaire[$k]['question'] as $qk => $qv){
                    $data_chart = array();
            ?>
            
            <p>Questão:</p>
            <br>
            <strong><?=$qv['description']?></strong>
            <br>
            <br>
            <p>Respostas:</p>
            <br>
            <ul>
                <?  $count = 0;
                    foreach ($questionnaire[$k]['question'][$qk]['answer'] as $qak => $qav){
                ?>
            
                <li class="respostas"><?=$qav['description']?> - <?=$qav['quant']?></li>
                <?
                        $data_chart[$qak]['description'] = $qav['description'];
                        $data_chart[$qak]['quant'] = $qav['quant'];
                    }
                    
                    $count2 = 1;
                    $array_total = count($data_chart);
                    
                    if($array_total > 0){
                        if($qv['grafico'] == 'pizza'){
                ?>
                
                <li class="respostas">
                    <!--     grafico de pizza               -->
                    <script type="text/javascript">
                        google.load("visualization", "1", {packages:["corechart"]});
                        google.setOnLoadCallback(drawChart);
                        function drawChart() {
                            var data = google.visualization.arrayToDataTable([
                                ['Respostas', 'Total'],
                                <? foreach($data_chart as $ck => $cv){ ?>
                                ['<?=$cv['description']?>',      <?=$cv['quant']?>]<? if($count2 < $array_total) { ?> , <?php } $count2++;?>
                                <? } ?>
                            ]);
                        
                        var options = {
                          title: '<?=$qv['palavra_chave']?>'
                        };
                        
                        var chart = new google.visualization.PieChart(document.getElementById('question_<?=$qv['id_question']?>'));
                        chart.draw(data, options);
                        }
                    </script>
                   <div class="charts" id="question_<?=$qv['id_question']?>"></div>
                </li>
                
                <?
                    // else tipo de grafico
                    }else{
                ?>
                <li class="respostas">
                    <!--     grafico de barra               -->
                    <img style="margin: auto !important;" src="http://chart.apis.google.com/chart?chxr=0,0,<?=$array_total+20?>&chxt=x&chbh=a&chs=400x200&cht=bhg&chco=FF9900,FF0000,0000FF&chds=0,<?=$array_total+20?>,0,<?=$array_total+20?>,0,<?=$array_total+20?>&chd=t:<? foreach($data_chart as $ck => $cv){ echo  str_replace(' ', '', $cv['quant']); if($count2 < $array_total) { ?>|<?php } $count2++; } ?>&chdl=<? $count3 = 1; foreach($data_chart as $ck => $cv){ echo  str_replace(' ', '', $cv['description']); if($count3 < $array_total) { ?>|<?php } $count3++; } ?>" alt="Gráficos"/>
                    
                </li>
                <?
                    //else quantidade no array
                    }}else{
                ?>
                <li class="respostas"><div class="charts" id="teste"><p>Não Há dados para apresentar gráfico</p></div></li>
                <? } ?>
            </ul>
            
            
            <br>
            
            <? } ?>
        </div>
        <? } } ?>
    </div>
    
    
</div>

<?//printr($data_chart);?>