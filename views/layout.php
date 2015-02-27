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

			webix.i18n.pivot = {
				columns: "Colunas",
				count: "Contar",
				fields: "Campos",
				filters: "Filtros",
				max: "Maximo",
				min: "Minimo",
				operationNotDefined: "Operação não definida",
				pivotMessage: "[Click aqui para configurar]",
				rows: "Linhas",
				select: "Selecionar",
				sum: "Somar",
				text: "Texto",
				values: "Valores",
				windowMessage: "[Mover os campos para o setor desejado]"
			};

			webix.ui({
				view:"pivot",
				url: "/dw/data",
				container:"testA", 
				id:"pivot",
				structure: { 
					rows: ["type", "peer", "carrier"],
					columns: ["dateCreated"],
					values: [{ name:"billmin", operation:"sum"}],
					filters:[{name:"type",type:"select"}, {name:"Rota",type:"select"}, {name:"Operadora",type:"select"}, {name:"dateCreated", type:"text"}],
					fieldMap:{ "type" : "Tipo", "peer" : "Rota", "carrier" : "Operadora", "dateCreated" : "Periodo", "billmin" : "Trafego" },
				}
			});
			$$("pivot").load("../index.php");

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



