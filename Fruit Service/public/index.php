 <!DOCTYPE html>
	<html lang="es">

	<head>
		<meta charset="UTF-8">
		<title>Fruit Service</title>
		<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css'>
		<link rel="stylesheet" href="css/hompage.css">

	</head>

	<body>

		<div class="container" id="container">

			<div class="form-container sign-up-container">
				<form action="conf/Registrado.php" method="post">
					<h1>Crear Usuario</h1>
					<span>Ingresa los datos para registratre:</span>
					<input name="Nombre" type="text" placeholder="Nombre" required />
					<input name="Correo" type="email" placeholder="Correo @" required />
					<input name="telefono" type="number" placeholder="Telefono" required />
					<input name="Contraseña" type="password" placeholder="Contraseña" required />
					<br>
					<button>Crear</button>
					<p>*Si ya tienes un usuario inicia sesion.*</p>
				</form>
			</div>


			<div class="form-container sign-in-container">

				<form action="../Configuracion/loguear.php" method="post">
					<h1>Iniciar Sesión</h1>

					<?php
					  echo isset($_GET{"error"}) ? "<br> <p class='SE envio'>usuario y contraseña incorrecta</p>" : " ";


					?>
					<input name="Usuario" type="text" placeholder="Nombre de usuario" required />
					<input name="Contraseña_in" type="password" placeholder="Contraseña" required />

					<a href="*">Olvidaste tu contraseña?</a>
					<button>Iniciar Sesión</button>
					<p>*Si no cuentas con un usuario registrado, crea uno para comenzar!*</p>
				</form>
			</div>


			<div class="overlay-container">
				<div class="overlay">
					<div class="overlay-panel overlay-left">
						<h1>Nuevo usuario!</h1>
						<br>
						<br><br><br>

						<button class="ghost" id="signIn">Ingresar</button>
					</div>
					<div class="overlay-panel overlay-right">
						<h1>Bienvenido!</h1>
						<br>
						<br>
						<br><br>

						<button class="ghost" id="signUp">Registrarse</button>
					</div>
				</div>
			</div>
		</div>

		<script src="js/loginFRont.js"></script>

	</body>

	</html>