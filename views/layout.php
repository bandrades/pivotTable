	<html lang ="pt-br">
		<head>
			<meta charset = utf-8>
			<meta name = "description" content = "Pagina de Geração de Relatórios">
			<meta name = "keywords" content = "relatórios, LigFlat">
			<meta name = "author" content = "Bruna Andrade Silva">
			<link rel="stylesheet" type="text/css" href="Pagina_Relatorio_css.css">

			<!-- js files -->
			<script src="pivot_trial/codebase/webix.js" type="text/javascript"></script>
			<script src="pivot_trial/codebase/pivot/pivot.js" type="text/javascript"></script>

			<!-- css files -->
			<link rel="stylesheet" href="pivot_trial/codebase/webix.css" type="text/css" charset="utf-8">
			<link rel="stylesheet" href="pivot_trial/codebase/pivot/pivot.css" type="text/css" charset="utf-8">

			<script type="text/javascript">
				webix.ready(function() {
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
								"data1" : "Tipo",
								"data2" : "Rota",
								"data3" : "Operadora",
								"data4" : "Trafego"
							},
							structure: { 
								columns: ['data0'],
								rows: ["data2", "data3"],
								values: [
									{ name:"data4", operation:"soma"}
								],
								filters:[
									{name:"data1",type:"select"},
									{name:"data2",type:"select"},
									{name:"data3",type:"select"},
									{name:"data0",type:"select"}
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
					var radios = document.getElementsByName('type');
					for (var i = 0, length = radios.length; i < length; i++) {
   						if (radios[i].checked) {
					        var type = radios[i].value;
				        	break;
					    }
					}
					$$("pivot").data.clearAll();
					$$("pivot").load("/dw/data?start="+ document.getElementById("inicio").value +"&end=" + document.getElementById("fim").value +"&type=" + type,"csv");
					document.getElementById("relatorioMensal").checked = true;
					document.getElementById("inicio").value = '';
					document.getElementById("fim").value = '';
				}
				
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
					<input type="radio" id="relatorioMensal" name="type" value="relatorioMensal" checked >Mensal
					<input type="radio" id="relatorioDiario" name="type" value="relatorioDiario">Diario <br>

					Inicio: <input type="text" id="inicio" name = "inicio" value="" required="true"> 
					Fim: <input type="text"  id="fim" name = "fim" value="" required="true"> 

					<input type="submit" value="Gerar" onClick = "carregaTabela()"/>

				</div>
				
				<div id = "testA"></div> 

			</div>

		</body>

	</html>



