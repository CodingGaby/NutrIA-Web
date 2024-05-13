<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Register | New User</title>
</head>
<body>
    <div class="pageCont min-h-screen bg-gray-100 flex justify-center items-center">
        <div class="bg-white p-8 rounded-lg shadow-md w-auto">
            <h2 class="text-center text-4xl font-bold">Register</h2>
            <hr class="m-6">
            <form class="grid grid-cols-2 gap-5 w-[600px]" action="register.php" method="post">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Name :</label>
                        <input class=" border rounded w-full py-2 px-3 text-gray-700" type="text"
                            name="Name" id="Name" value="" placeholder="Enter your Name" maxlength="50">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Last Name</label>
                        <input class=" border rounded w-full py-2 px-3 text-gray-700" type="text"
                            name="LastName" id="LastName" value="" placeholder="Enter Your Last Name" maxlength="150">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Phone Number:</label>
                        <input class=" border rounded w-full py-2 px-3 text-gray-700" type="tel"
                            name="PhoneNumber" id="PhoneNumber" value="" placeholder="Enter Your Phone Number" maxlength="10">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2"> Weight(Kg):</label>
                        <input class=" border rounded w-full py-2 px-3 text-gray-700" type="number"
                            name="Weight" id="Weight" value="" placeholder="Enter Your Weight" min="40" max="200">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Birth Date:</label>
                        <input class=" border rounded w-full py-2 px-3 text-gray-700" type="date"
                            name="BirthDate" id="BirthDate" value="">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2"> Height (cm):</label>
                        <input class=" border rounded w-full py-2 px-3 text-gray-700" type="number"
                            name="Height" id="Height" value="" placeholder="Enter Your Height" min="120" max="280">                            
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2"> Email:</label>
                        <input class=" border rounded w-full py-2 px-3 text-gray-700" type="email"
                            name="Email" id="Email" value="" placeholder="Enter Your Email"  max="150" required>                            
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2"> Password:</label>
                        <input class=" border rounded w-full py-2 px-3 text-gray-700" type="text"
                            name="Password" id="Password" value="" placeholder="Enter Your Password" minlength="6" max="50" required>                            
                    </div>
                <hr>
                    <input type="submit" value="Accept" class="flex justify-center align-items w-full block bg-lime-700 hover:bg-lime-600 focus:bg-lime-600 text-white font-semibold rounded-full px-4 py-3 mt-6">
            </form>
        </div>
    </div>
    <?php
    // Iniciar sesión si no está iniciada
    session_start();

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $name = $_POST['Name'];
        $lastName = $_POST['LastName'];
        $phoneNumber = $_POST['PhoneNumber'];
        $weight = $_POST['Weight'];
        $birthDate = $_POST['BirthDate'];
        $height = $_POST['Height'];
        $email = $_POST['Email'];
        $passw = $_POST['Password'];

        #Conectar la base de datos
        $link = mysqli_connect("localhost", "root", "", "nutriia") or die("Error al conectar con la base de datos");

        #Consulta de Insert
        $sqlinsert = "INSERT INTO users(name, lastName, phoneNumber, weight, birthDate, height, email, password) VALUES('$name', '$lastName', '$phoneNumber', '$weight', '$birthDate', '$height', '$email', '$passw')";

        #Ejecutamos la consulta
        if (mysqli_query($link, $sqlinsert)) {
            # Obtener el ID del usuario recién insertado
            $userId = mysqli_insert_id($link);

            # Almacenar el ID del usuario en la sesión
            $_SESSION['user_id'] = $userId;

            # Crear el nombre de la alacena (pantry)
            $pantryName = "Pantry of $name";

            # Crear consulta
            $createPantry = "INSERT INTO pantries(PantryName, userId) VALUES('$pantryName', '$userId')";

            # Ejecutar la consulta de creación de alacena
            if (mysqli_query($link, $createPantry)) {
                // Redirigir después de guardar el usuario y la alacena
                header("Location: Disease.php");
                exit();
            } else {
                echo "Error al crear la alacena: " . mysqli_error($link);
            }
        } else {
            echo "Error al guardar el usuario: " . mysqli_error($link);
        }
    }
?>

</body>
<style>
    body{
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    }    
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
        -webkit-appearance: none; 
        margin: 0; 
    }
    .pageCont {
        background-image: url('https://firebasestorage.googleapis.com/v0/b/apipa-101ce.appspot.com/o/pexels-lumn-1028599.webp?alt=media&token=f3e63444-9666-4232-b161-ac45e9f9d646');
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
    }
</style>
</html>