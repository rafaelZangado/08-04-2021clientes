<?
	// clientes/views/maps.php
    $flag = 0;
	$Clientes->listar('', '', '', '', 50, true);
	$maps = $Clientes->fieldsarr['Clientes'];
	if ( count($maps) > 0 ){ $flag = 1; }
?>
<style type="text/css">
  html { height: 100% }
  body { height: 100%; margin: 0px; padding: 0px }
  #map_canvas { height: 100% }
</style>
<!-- Faz uma listagem de pontos cadastrados -->

<!--[BLOCO 01-inicio]-->
	<script>
		
		//[BLOCO 02-inicio]
			function loadScript() {
			var script = document.createElement("script");
			script.type = "text/javascript";
			script.src = "http://maps.google.com/maps/api/js?sensor=false&callback=initialize";
			document.body.appendChild(script);
			}
		//[BLOCO 02-fim]

		var markersArray = new Object;
			
		var indexMarker = 0;
		//[BLOCO 03-inicio]
			function initialize() {
				var mapOptions = {
				zoom: 10,
				center: new google.maps.LatLng(-2.536,-44.234),
				mapTypeId: google.maps.MapTypeId.ROADMAP
				};
				var map = new google.maps.Map(document.getElementById('map_canvas'),mapOptions);
				
				google.maps.event.addListener(map, 'click', function(e) {
				placeMarker(e.latLng, map, indexMarker);
				});	
			
				<?
					if ($flag == 1) {
						foreach ($maps as $pontos) {
							extract($pontos);
					?>
							var aux = new google.maps.LatLng<?=$dsPosition; ?>;
							placeMarker(aux, map, indexMarker);
					<?       
						}
					}
				?>
			
			} // Final de initialize()
		//[BLOCO 03-fim]	
		

		//[BLOCO 04-inicio]

			// Função para criar a mensagem
			function criarMessage(position, index) {
				var message = '<button onclick="navegarAssistente(\'clientes/definirPosicao&position='+position+'\')">Salvar Ponto</button>';
				return 	message;
			}
		//[BLOCO 04-fim]

		//[BLOCO 05-inicio]
			// Função para criar marcação
			function placeMarker(position, map, index) {
				markersArray[indexMarker] = [];
				var marker = new google.maps.Marker({
				position: position,
				map: map,
				draggable:true,
				indexMarker: index
				});

				markersArray[indexMarker] = marker;
				indexMarker++;
				map.panTo(position);
				console.log(position);
				var infowindow = new google.maps.InfoWindow({
					content: criarMessage(marker.position, marker.indexMarker)
				});

				google.maps.event.addListener(marker, 'click', function() {
					infowindow.open(marker.get('map'), marker);
				});

				google.maps.event.addListener(marker, 'dragend', function() {
					infowindow.setContent(criarMessage(marker.position, marker.indexMarker));	
				});

				google.maps.event.addListener(marker, 'rightclick', function() {
					deleteMarker(marker.indexMarker);	
				});
				
			}
		//[BLOCO 05-fim]

		//[BLOCO 06-inicio]
			// Função para deletar marcação
			function deleteMarker(i) {
				if (markersArray[i]) {
					markersArray[i].setMap(null);
				}
				return false;
			}
		//[BLOCO 06-fim]

		//[BLOCO 07-inicio]
			// Função para colocar descrição
			function attachSecretMessage(marker, number) {
			
				var infowindow = new google.maps.InfoWindow({ 
					content: message[number],
					size: new google.maps.Size(50,50)
				});

				google.maps.event.addListener(marker, 'click', function() {
					infowindow.open(map,marker);
				});
			}
		//[BLOCO 07-fim]
		
		//google.maps.event.addDomListener(window, 'load', initialize);
		loadScript();
	</script>
<!--[BLOCO 01-fim]-->
<div id="map_canvas"></div>

