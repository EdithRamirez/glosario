<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Glosario con flexslider</title>
		<link rel="stylesheet" type="text/css" href="css/foundation.css">
		<link rel="stylesheet" href="css/flexslider.css">
		<link rel="stylesheet" href="css/estilos.css">
	</head>
	<body>
		<div class="row">
			<div class="small-12 nopadding columns" id="glosario"> 
			<?php foreach (range('A','Z') as $letra) : ?>

				<div class="columns small-6 medium-3 large-3 abc-letra" id="letra-<?php echo $letra; ?>">
					<div class="abc-thumb">
						<a class="abc-link" data="<?php echo $letra; ?>">
							<!-- <img src="images/<?php echo $letra; ?>.jpg" /> -->
							<?php echo $letra; ?>
						</a>
						<div class="box hide" id="box-<?php echo $letra;?>">
							<div class="abc-lista columns" id="lista-<?php echo $letra; ?>">
								<ul class="listado" data-id="<?php echo $letra; ?>">
									<li><a class="abclic" data-li="0">0</a></li>
									<li><a class="abclic" data-li="1">1</a></li>
									<li><a class="abclic" data-li="2">2</a></li>
									<li><a class="abclic" data-li="3">3</a></li>
									<li><a class="abclic" data-li="4">4</a></li>
								</ul>
							</div>

							<div class="abc-detalle columns nopadding" id="detalle-<?php echo $letra; ?>"></div>
						</div>
					</div>

				</div>
			<?php endforeach; ?>
			</div>
		</div>
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/foundation.js"></script>
		<script type="text/javascript" src="js/jquery.flexslider.js"></script>
		<script type="text/javascript">
			$( document ).ready(function() {
				calcular();

				$(".abc-link").click(function(e) {
					e.preventDefault();
					var letra = $(this).attr("data");
					//console.log(letra);
					$(".abc-lista").removeClass("hide");
					$(".abc-letra,.box").removeAttr('style');
					$(".box").addClass("hide");
					$(".abc-detalle").addClass("hide");

					var width = parseInt($("#glosario").width());
					//console.log(width);

					$("#box-"+letra).width(width-10);
					$("#box-"+letra).removeClass("hide");

					var targetOffset = $(this).offset().top;
			        $('html,body').animate({scrollTop: targetOffset - 170}, 1000);
					
					ajustarCode(letra);
					
				});

				$(".abclic").click(function(e){
					e.preventDefault();
					var nombre = $(this).attr("data-li");
					//console.log(nombre);
					
					var letra = $(this).parents(".listado").attr("data-id");
					//console.log(letra);

					$(".abc-lista").removeClass("hide");
					$("#lista-"+letra).addClass("hide");
					$("#detalle-"+letra).removeClass("hide");

					$.ajax({
						type: 'GET',
						url: 'glosario-filtros.php',
						success: function(data) {
							$('#detalle-'+letra).html('<div class="columns text-center"><img src="images/loading.gif" width="30"></div>');

							$('#detalle-'+letra).html(data);

							$(".abc-slide").flexslider({
								animation: "slide",
								controlNav: false,
								slideshow: false,
							    customDirectionNav: $("#detalle-"+letra+" .custom-navigation a"),
								start: function(slider) {
									
									// slider.dataset
									for (var x= 0; x <= nombre; x++){
										if (nombre == x) {
											slider.flexAnimate(x, true,true);
											//slider.vars.animation = 'fade';
										}
									}
									//console.log(nombre+ " --- "  +x)
									ajustarCode(letra);
								},
							});

							var width = window.innerWidth || document.documentElement.clientWidth;
			
							if(width < 640) {
								$('body,html').animate({	
									scrollTop: $("#box-"+letra).offset().top-50
								},1000);
							}
						},
						error: function( xhr, ajaxOptions, thrownError) {
							alert(xhr.status);
							alert(thrownError);
						}
					});

				});
			});
			
			function calcular() {
				var num = $("#letra-A").width();
				$(".abc-thumb").height(num);
				$(".abc-thumb").width(num);
			}
			function ajustarCode(letra) {
				var columns = $("#glosario").width()/$("#letra-A").width();
				var num = Math.round(columns);
				//console.log(num);
				var res = letra.charCodeAt(0)%num;
				var posicion = 0;
				if(res != 0){
					posicion = num - (letra.charCodeAt(0)%num);
				}
				//console.log(posicion);

				var height = parseInt($("#box-"+letra).outerHeight());
				//console.log(height);
				
				for(var i = letra.charCodeAt(0); i <= letra.charCodeAt(0)+posicion; i++) {
					var l = String.fromCharCode(i); 
					$("#letra-"+l).css( "margin-bottom", height+10);  
					//console.log("#letra-"+l);
				}
			}

		</script>
	</body>
</html>



