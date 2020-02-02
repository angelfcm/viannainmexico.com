<?=$head?>
<?=$header?>

<?php 
require_once('modulos/varios/mensajes.php');
require_once('modulos/'.$seccion.'/'.$subseccion.'.php'); 
?>

<?=$jquery?>

<script src="../js/form-password.js"></script>

<script>
	$('.eliminar').click(function(){
		var id=$(this).attr('data-id');
		var statusConfirm = confirm("¿Realmente desea eliminar este administrador?"); 
		if (statusConfirm == true) 
		{ 
			window.location = ("index.php?seccion=usuarios&borrarUser=1&id="+id)
		} 
	});

	$('.save').click(function(){
		$(this).text('Espere...');
		setTimeout(function(){ 
			$('.save').text("Guardar");
		}, 3000);
	})

	$(".nivel").click(function(){
		var id = $(this).attr("data-id");
		var nivel = $(this).attr("data-nivel");
		if (nivel==1) {
			nivel=2;
			$(this).attr('data-nivel',nivel);
			$(this).html('Administración');
			$(this).addClass("uk-button-primary");
		}else{
			nivel=1;
			$(this).attr('data-nivel',nivel);
			$(this).html('Ventas');
			$(this).removeClass("uk-button-primary");
		}
		$.post("modulos/usuarios/acciones.php", {
			editanivel: 1,
			nivel: (nivel),
			id: id
		})
	});

	$('.password').click(function(){
		var id=$(this).attr('data-id');
		var user=$(this).attr('data-user');
		console.log(id);
		$('#password').val(id);
		$('#user1').val(user);
	});

	$("#passc").keyup(function() {
		var pass  = $("#pass").val();
		var passc = $(this).val();
		var len  = (pass).length;
		if(len<6){
			$("#mensaje").css("display","block");
		}else{
			$("#mensaje").css("display","none");
			if(pass!=passc){
				$("#mensajec").css("display","block");
			}else{
				$("#save").prop("disabled",false);
				$("#mensajec").css("display","none");
			}
		}
	});

	$("#passc1").keyup(function() {
		var pass  = $("#pass1").val();
		var passc = $(this).val();
		var len  = (pass).length;
		if(len<6){
			$("#mensaje1").css("display","block");
		}else{
			$("#mensaje1").css("display","none");
			if(pass!=passc){
				$("#mensajec1").css("display","block");
			}else{
				$("#save1").prop("disabled",false);
				$("#mensajec1").css("display","none");
			}
		}
	});

</script>

<?=$footer?>