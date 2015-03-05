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

		webix.ready(function(){
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
				windowMessage: "[Mova os campos para o setor desejado]"

			};

			var pivot = webix.ui({
				view: "pivot",
				url: "/dw/data.csv",
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
					rows: ["data1", "data3", "data2"],
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
		});

		</script>

	<title>Relatórios</title>
	</head>

	<body>

		<div class="topo">

			<h1>Geração de Relatórios</h1>

		</div>

		<div id="conteudo">

			<h2>Filtro</h2>

			<form method="post" action="">

				Inicio: <input type="text" id="inicio" name = "inicio" value="" required> 
				Fim: <input type="text"  id="fim" name = "fim" value="" required> 

				<input type="submit" value="Gerar"/>
			</form>

			<div id = "testA"></div> 

		</div>

	</body>

</html>



