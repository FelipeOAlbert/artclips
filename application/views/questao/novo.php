<div id='nova_transicao' style='display: none;'>
		<input type='button' name='active_question' id='active_question' value='Cadastrar Questão normal' >
	<form  enctype="multipart/form-data" name="nova_questao_transicao" method="post" id="nova_questao" class="nova_questao" id_questionario="<?=$id_questionario;?>" action="<?=site_url('/questao/adicionar');?>">
	<input type='hidden' name='is_transition' value='1'>
	<input type="hidden" name="id_questionnaire" value="<?=$id_questionario;?>" />
	
		<div>
			<label>Palavra chave:</label>
			<input type="text" name="palavra_chave" value="" >
		</div>
		<div>
			<label style="width: 70px;">Categoria:</label>
			<?=form_dropdown('id_categoria', $categorias, NULL, 'id="id_categoria"'); ?>
		</div>
		
		<textarea id="elm1" name="elm1" rows="15" cols="80" style="width: 80%" class="tinymce">
		</textarea>
		<br />
		<div>
			<label>Quantidade de questões para esta transição:</label>
			<input type="text" name="num_questions_transition" value="" >
		</div>
		<br />
		<input type="submit" class="criar" id="criar_transi" value="Criar" />
		<input type="button" class="cancelar" id="cancelar_transi" value="Cancelar" />
		
	</form>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$("#active_transicao").click(function(event){
			event.preventDefault();
			$("#nova_questao_normal").hide();
			$("#nova_transicao").show();
		});
		$("#active_question").click(function(event){
			event.preventDefault();
			$("#nova_transicao").hide();
			$("#nova_questao_normal").show();
		});

		$('textarea.tinymce').tinymce({
			// Location of TinyMCE script
			script_url : '<?=base_url()?>js/tiny_mce/tiny_mce.js',

			// General options
			theme : "advanced",
			plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			// Theme options
			theme_advanced_buttons1 : "fontsizeselect,bold,italic,underline,forecolor,|,link,unlink,|,image,media,|,bullist,numlist,|,undo,redo",
	        theme_advanced_buttons2 : "",
	        theme_advanced_buttons3 : "",
	        theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,

			// Example content CSS (should be your site CSS)
			content_css : "css/content.css",

			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js",

			template_replace_values : {
				renato : "Renato(siroma)"
			}
		});
		
	});
</script>
<div id='nova_questao_normal' style='display: block;'> 
	<form enctype="multipart/form-data" name="nova_questao" method="post" id="nova_questao" class="nova_questao" id_questionario="<?=$id_questionario;?>" action="<?=site_url('/questao/adicionar');?>">
	<input type='hidden' name='is_transition' value='0'>
			<input type='button' name='active_transicao' id='active_transicao' value='Cadastrar Transição' ><hr>
		<input type="hidden" name="id_questionnaire" value="<?=$id_questionario;?>" />
	
		<div>
			<label>Nova quest&atilde;o:</label>
			<textarea id="descricao" name="description" value=""></textarea>
		</div>
		
		<div>
			<label>Imagem da questão:</label>
			<input type="file" name="img_questao" >
		</div>
		
		<div>
			<label>Palavra chave:</label>
			<input type="text" name="palavra_chave" value="" >
		</div>
		<div>
			<label style="width: 70px;">Tipo:</label>
			<?=form_dropdown('id_type', $tipos, NULL, 'id="id_tipo"'); ?>
		</div>
		
		<div>
			<label style="width: 70px;">Categoria:</label>
			<?=form_dropdown('id_categoria', $categorias, NULL, 'id="id_categoria"'); ?>
		</div>
		<br/>
		<div style='display: none'>
		Questão irá bifurcar suas respostas?
		<br/> Sim:<input type="radio" name="bifurcar" value="sim" ><br>
		 nao:<input type="radio" name="bifurcar" value="nao" ><br>
		 </div>
		
		<script type="text/javascript">
			$(document).ready(function(){
				
				var seleciona_pizza = function(){
					$("#grafico_barra").attr('checked',false);
	
					var src = $("#img_barra").attr("src");
					$("#img_barra").attr("src",src.replace("_sel",""));
					
					$("#grafico_pizza").attr('checked','checked');
				}
				var seleciona_barra = function(){
					$("#grafico_pizza").attr('checked',false);
	
					var src = $("#img_pizza").attr("src");
					$("#img_pizza").attr("src",src.replace("_sel",""));
					
					$("#grafico_barra").attr('checked','checked');
				}
				
				$("#img_pizza").click(function(){
					var src = $(this).attr("src");
					if(end(src.split("/")).replace("chart_pie","") == ".png"){
						$(this).attr("src",src.replace("chart_pie","chart_pie_sel") );
						seleciona_pizza();
					}else{
						$("#img_barra").trigger("click");
					}
				});
	
				$("#img_barra").click(function(){
					var src = $(this).attr("src");
					if(end(src.split("/")).replace("chart_column","") == ".png"){
						$(this).attr("src",src.replace("chart_column","chart_column_sel") );
						seleciona_barra();
					}else{
						$("#img_pizza").trigger("click");
					}
				});
	
				$("#img_barra, #img_pizza").hover(function(){
					$(this).css("cursor","pointer");
				});
				var i = setTimeout('$("#img_barra").trigger("click");',1000);
			});
		</script>
		
		<p style="border: 0px solid black; width: 242px;">
			<b>Tipo de Gráfico para esta questão</b> <br />
			<img src="<?=base_url();?>images/charts/chart_pie.png" id='img_pizza' width='32px' /> &nbsp; <img src="<?=base_url();?>images/charts/chart_column.png" id='img_barra' width='32px' /> <br /> 
			<input style='display:none;' type='radio' name='grafico' value='pizza' id='grafico_pizza' />
			<input style='display:none;' type='radio' name='grafico' value='barra' id='grafico_barra' />
		</p>
		
		<div>
			<input type="submit" class="criar" id="criar" value="Criar" />
			<input type="button" class="cancelar" id="cancelar" value="Cancelar" />
		</div>
	</form>
</div>
<script type="text/javascript">

	$(document).ready(function(){
		// ADICIONAR QUESTÃO 
		$(".nova_questao[id_questionario='<?=$id_questionario;?>'] input[type=button]#criar").click(function(e) {
			e.preventDefault();

			$(".nova_questao[id_questionario='<?=$id_questionario;?>'] textarea").removeClass("erro");

			if( is_empty( $(".nova_questao[id_questionario='<?=$id_questionario;?>'] textarea").val() ) ){
				$(".nova_questao[id_questionario='<?=$id_questionario;?>'] textarea").addClass("erro").focus();
				return false;
			}
		
			show_loading();
		return true;
			$.post("<?=site_url('/questao/adicionar');?>",
				$("#nova_questao[id_questionario='<?=$id_questionario;?>']").serialize(),
				function(r){
					$(".fundo, .loading_content").hide();
					if(r.ok){
						classe="sucesso";
						
						$("#nova_questao[id_questionario='<?=$id_questionario;?>']").each(function(){
							this.reset();
						});
						
						// recarrega a lista de questoes
						//$("div#container_questao_lista[id_questionario='<?=$id_questionario?>']").trigger('questao_adicionada');
					} else {
						classe="erro";
					}
				
					if(r.msg)
						show_msg(r.msg, classe, 800);
				
			}, "json");
		});
	});

</script>
