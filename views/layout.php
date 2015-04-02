	<html lang ="pt-br">
	<head>
		<meta charset = "utf-8">

		<meta name = "description" content = "Pagina de Geração de Relatórios">
		<meta name = "keywords" content = "relatórios, LigFlat">
		<meta name = "author" content = "Bruna Andrade Silva">

		<!-- js files -->
		<script src="pivot_trial/codebase/webix.js" type="text/javascript"></script>
		<script src="pivot_trial/codebase/pivot/pivot.js" type="text/javascript"></script>
		<script src="jquery/jquery-1.11.2.js" type="text/javascript"></script>
		<script src="jquery/jquery-maskedinput.js" type="text/javascript"></script>
		<script src="jquery/jquery-ui-1.11.4/jquery-ui.js" type="text/javascript"></script>

		<!-- css files -->
		<link rel="stylesheet" href="Pagina_Relatorio_css.css" type="text/css" charset="utf-8">
		<link rel="stylesheet" href="jquery/jquery-ui-1.11.4/jquery-ui.css" type="text/css" charset="utf-8">
		<link rel="stylesheet" href="pivot_trial/codebase/webix.css" type="text/css" charset="utf-8">
		<link rel="stylesheet" href="pivot_trial/codebase/pivot/pivot.css" type="text/css" charset="utf-8">

		<script type="text/javascript">
			webix.ready(function() {
				document.getElementById('gif-loading').style.display = 'none';
				document.getElementById('exportaexcel').style.display = 'none';
				webix.i18n.pivot = {
					columns: "Colunas",
					count: "Contar",
					fields: "Campos",
					filters: "Filtros",
					max: "Maximo",
					min: "Minimo",
					operationNotDefined: "Operação não definida",
					pivotMessage: "Configuraçoes",
					rows: "Linhas",
					select: "Selecionar",
					sum: "Somar",
					text: "Texto",
					values: "Valores",
					cancel: "Cancelar",
					apply: "Aplicar", 
					windowMessage: "Mova os campos para o setor desejado"
				};

				var pivot = webix.ui({
					view: "pivot",
					datatype: "csv",
					container: "testA", 
					id: "pivot",
					height:600,
					fieldMap:{
						"data0" : "Periodo",
						"data1" : "Ramal",
						"data2" : "Tipo",
						"data3" : "Rota",
						"data4" : "Operadora",
						"data5" : "Status",
						"data6" : "Trafego",
						"data7" : "Contador"
					},
					structure: { 
						columns: ['data0'],
						rows: ["data3", "data4"],
						values: [
							{ name:"data6", operation:"soma"},
							{ name:"data7", operation:"soma"},
						],
						filters:[
							{name:"data1",type:"text"},
							{name:"data2",type:"select"},
							{name:"data5",type:"select"}					
						],
					},
					ready:function() {
						console.log('data pivot loaded');
					}
				});

				pivot.operations.soma = function(data) {
					var sum = 0;
					for (var i = 0; i < data.length; i++) {
						var num = window.parseFloat(data[i], 10);
						if (!window.isNaN(num))
							sum += Math.abs(num);
					}
					return sum;
				};
			})
			function carregaTabela(evt){
				var dateStart = document.getElementById("inicio").value;
				var dateEnd = document.getElementById("fim").value;

				if(dateStart == "" || dateEnd == ""){
					alert("Selecione uma data!");
				}
				else if(dateStart <= dateEnd){
					var radios = document.getElementsByName('type');
					for (var i = 0, length = radios.length; i < length; i++) {
						if (radios[i].checked) {
							var type = radios[i].value;
							break;
						}
					}

					$$("pivot").data.clearAll();
					$$("pivot").load("/dw/data?start="+ dateStart +"&end=" + dateEnd +"&type=" + type,"csv");

					document.getElementById("relatorioDiario").checked = true;
					document.getElementById("inicio").value = '';
					document.getElementById("fim").value = '';
					document.getElementById('gif-loading').style.display = 'block';

					$$("pivot").attachEvent("onAfterLoad", function(){
						document.getElementById('gif-loading').style.display = 'none';
						document.getElementById('exportaexcel').style.display = 'block';
					});
				}	
				else{
					alert("Selecione uma data Valida!");
				}			

			}
			function exportarExcel(evt){	
				$$("pivot").toExcel();
			}
		</script>

		<script type="text/javascript">
			jQuery(function($){

				$("#inicio").mask("9999-99-99",{placeholder:"yyyy-mm-dd"});
				$("#fim").mask("9999-99-99",{placeholder:"yyyy-mm-dd"});

				$("#inicio").datepicker({
					dateFormat: 'yy-mm-dd',
					changeMonth: true,
					changeYear: true,
					showOn: "button",
					buttonImage: "jquery/imagem/calendario.png",
					buttonImageOnly: true,
				});

				$("#fim").datepicker({
					dateFormat: 'yy-mm-dd',
					changeMonth: true,
					changeYear: true,
					showOn: "button",
					buttonImage: "jquery/imagem/calendario.png",
					buttonImageOnly: true,
				});
			})
		</script>


	<title>Relatórios</title>
</head>

<body>

	<div class="topo">

		<h1>Geração de Relatórios</h1>

	</div>

	<div id="conteudo">

		<div id="formulario">

			Relatorio: 
			<input type="radio" id="relatorioAnual" name="type" value="relatorioAnual">Anual
			<input type="radio" id="relatorioMensal" name="type" value="relatorioMensal">Mensal
			<input type="radio" id="relatorioDiario" name="type" value="relatorioDiario" checked>Diario <br>

			Inicio: <input type="text" id="inicio" name = "inicio" value=""> 
			Fim: <input type="text"  id="fim" name = "fim" value=""> 

			<input type="submit" value="Gerar" onClick = "carregaTabela()"/>

			<br> <img src="jquery/imagem/ajax-loader.gif" id="gif-loading" style.display = 'none'>

			<input type="submit" id = "exportaexcel" value="Exportar Excel" onClick = "exportarExcel()" style.display = 'none'/>

		</div>

		<div id = "testA"></div> 

	</div>

</body>

</html>



