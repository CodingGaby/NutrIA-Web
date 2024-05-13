<?php
session_start(); // Inicia la sesión PHP

// Verificar si el usuario está autenticado (es decir, si hay un ID de usuario en la sesión)
if (isset($_SESSION['user_id'])) {
    // Obtener el ID del usuario de la sesión
    $usuario_id = $_SESSION['user_id'];

    // Verificar si se ha enviado un formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Conexión a la base de datos (debes completar con tus propias credenciales)
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "nutriia";
        
        // Crea la conexión
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verifica la conexión
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Iterar sobre las enfermedades seleccionadas
        foreach ($_POST['diseases'] as $nombre_enfermedad) {
            // Preparar la consulta para verificar si la enfermedad existe
            $sql_verificar_enfermedad = "SELECT diseaseId FROM diseases WHERE diseaseName = ?";
            $stmt = $conn->prepare($sql_verificar_enfermedad);
            $stmt->bind_param("s", $nombre_enfermedad);
            $stmt->execute();
            $resultado_verificar = $stmt->get_result();

            if ($resultado_verificar->num_rows > 0) {
                // Obtener el ID de la enfermedad existente
                $row = $resultado_verificar->fetch_assoc();
                $enfermedad_id = $row['diseaseId'];

                // Insertar la relación entre el usuario y la enfermedad en la tabla de usuarios_enfermedades
                $sql_insert_enfermedad = "INSERT INTO diseasesdetail (userId, diseaseId) VALUES (?, ?)";
                $stmt = $conn->prepare($sql_insert_enfermedad);
                $stmt->bind_param("ii", $usuario_id, $enfermedad_id);
                if ($stmt->execute() !== TRUE) {
                    echo "Error al insertar enfermedad: " . $stmt->error;
                }
            } else {
                echo "La enfermedad '$nombre_enfermedad' seleccionada no existe en la base de datos.";
            }
        }

        // Cierra la conexión
        $conn->close();
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Diseases</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .checkbox:checked + .check-icon {
            display: flex;
        }
        body{
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }   
        body {
            background-image: url('https://firebasestorage.googleapis.com/v0/b/apipa-101ce.appspot.com/o/docBack.webp?alt=media&token=bdaa4960-d6d8-4247-8335-1527e10fb7ed');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }
    </style>
</head>
<nav class="backdrop-blur-sm text-black sticky top-0 relative select-none lg:flex lg:items-stretch w-full p-4">
    <div class="flex flex-no-shrink items-stretch h-12">
      <a href="#" class="flex-no-grow flex-no-shrink relative leading-normal no-underline flex items-center hover:bg-grey-dark text-3xl font-bold">NutrIA</a> 
      <button class="block lg:hidden cursor-pointer ml-auto relative w-12 h-12 p-4">
        <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg>
        <svg class="fill-current text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 8.586L2.929 1.515 1.515 2.929 8.586 10l-7.071 7.071 1.414 1.414L10 11.414l7.071 7.071 1.414-1.414L11.414 10l7.071-7.071-1.414-1.414L10 8.586z"/></svg>
      </button>
    </div>
    <div class="lg:flex lg:items-stretch lg:flex-no-shrink lg:flex-grow">
      <div class="lg:flex lg:items-stretch lg:justify-end ml-auto">
        <a href="index.php" class="flex-no-grow flex-no-shrink hover:underline hover:decoration-2 relative py-2 px-4 leading-normal no-underline flex items-center hover:bg-grey-dark">Home</a>
        <a href="Recipes.php" class="flex-no-grow flex-no-shrink hover:underline hover:decoration-2 relative py-2 px-4 leading-normal no-underline flex items-center hover:bg-grey-dark">Recipes</a>
      </div>
    </div>
</nav>
<body class="flex justify-center align-items flex-col">    
    <div class="flex justify-center items-center flex-col ">
        <div class="bg-white p-6 rounded-lg mt-16">
            <div class="mb-4 text-center">
                <h1 class="text-center text-4xl font-bold mb-2" >Diseases</h1> 
                <p class="mt-5">Select those diseases that you have</p>
            </div> 
            <hr>
            <fieldset class="p-6 flex justify-center items-center flex-col w-[400px]">
                <form action="Disease.php" method="post">
                <div class="my-5 grid grid-cols-2">
                    <div class="flex items-start items-center mb-4">
                        <input id="checkbox-1" aria-describedby="checkbox-1" name="diseases[]" type="checkbox" value="Anemia" class="bg-gray-50 border-gray-300 focus:ring-3 focus:ring-blue-300 h-4 w-4 rounded">
                        <label for="checkbox-1" class="text-sm ml-3 font-medium text-gray-900">Anemia</label>
                    </div>
                   
                    <div class="flex items-start items-center mb-4">
                        <input id="Diabetes" aria-describedby="checkbox-2" name="diseases[]" type="checkbox" value="Diabetes" class="bg-gray-50 border-gray-300 focus:ring-3 focus:ring-blue-300 h-4 w-4 rounded">
                        <label for="checkbox-2" class="text-sm ml-3 font-medium text-gray-900">Diabetes</label>
                    </div>
                   
                    <div class="flex items-start items-center mb-4">
                        <input id="checkbox-3" aria-describedby="checkbox-3" name="diseases[]" type="checkbox" value="Hypertension" class="bg-gray-50 border-gray-300 focus:ring-3 focus:ring-blue-300 h-4 w-4 rounded">
                        <label for="checkbox-3" class="text-sm ml-3 font-medium text-gray-900">Hypertension</label>
                    </div>

                    <div class="flex items-start items-center mb-4">
                        <input id="checkbox-4" aria-describedby="checkbox-4" name="diseases[]" type="checkbox" value="Hypercholesterolemia" class="bg-gray-50 border-gray-300 focus:ring-3 focus:ring-blue-300 h-4 w-4 rounded">
                        <label for="checkbox-4" class="text-sm ml-3 font-medium text-gray-900">Hypercholesterolemia</label>
                    </div>

                    <div class="flex items-start items-center mb-4">
                        <input id="checkbox-5" aria-describedby="checkbox-5" name="diseases[]" type="checkbox" value="Leukemia" class="bg-gray-50 border-gray-300 focus:ring-3 focus:ring-blue-300 h-4 w-4 rounded">
                        <label for="checkbox-5" class="text-sm ml-3 font-medium text-gray-900">Leukemia</label>
                    </div>

                    <div class="flex items-start items-center mb-4">
                        <input id="checkbox-6" aria-describedby="checkbox-6" name="diseases[]" type="checkbox" value="Malnutrition" class="bg-gray-50 border-gray-300 focus:ring-3 focus:ring-blue-300 h-4 w-4 rounded">
                        <label for="checkbox-6" class="text-sm ml-3 font-medium text-gray-900">Malnutrition</label>
                    </div>

                    <div class="flex items-start items-center mb-4">
                        <input id="checkbox-7" aria-describedby="checkbox-7" name="diseases[]" type="checkbox" value="Overweight" class="bg-gray-50 border-gray-300 focus:ring-3 focus:ring-blue-300 h-4 w-4 rounded">
                        <label for="checkbox-7" class="text-sm ml-3 font-medium text-gray-900">Overweight</label>
                    </div>

                    <div class="flex items-start items-center mb-4">
                        <input id="checkbox-8" aria-describedby="checkbox-8" name="diseases[]" type="checkbox" value="Obesity" class="bg-gray-50 border-gray-300 focus:ring-3 focus:ring-blue-300 h-4 w-4 rounded">
                        <label for="checkbox-8" class="text-sm ml-3 font-medium text-gray-900">Obesity</label>
                    </div>
                </div>
                <div class="flex items-start items-center">
                    <input id="CheckboxNoDisease" type="checkbox" class="bg-gray-50 border-gray-300 focus:ring-3 focus:ring-blue-300 h-4 w-4 rounded">
                    <label for="CheckboxNoDisease" class="text-sm ml-3 font-medium text-gray-900">I have no diseases</label>
                </div>

                <input type="submit" value="Accept" class="flex justify-center align-items my-6 w-full block bg-lime-700 hover:bg-lime-600 focus:bg-lime-600 text-white font-semibold rounded-full px-4 py-3 my-6">

                </form>
                

                
            </fieldset>
            <hr>
            <a href="DailyActivities.php" class="flex justify-center align-items my-6 w-full block bg-lime-700 hover:bg-lime-600 focus:bg-lime-600 text-white font-semibold rounded-full px-4 py-3 my-6">Continue</a>
            <!--
                <button class="w-full block bg-green-700 hover:bg-green-600 focus:bg-lime-600 text-white font-semibold rounded-lg px-4 py-3 mt|-6">
                    Accept
                </button>
            -->
            </div>
        </div>
    </div>
</body>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const checkboxNoDisease = document.getElementById("CheckboxNoDisease");
        const checkboxes = document.querySelectorAll('input[type="checkbox"]:not(#CheckboxNoDisease)');

        checkboxNoDisease.addEventListener("change", function () {
            if (this.checked) {
                checkboxes.forEach(function (checkbox) {
                    checkbox.disabled = true;
                });
            } else {
                checkboxes.forEach(function (checkbox) {
                    checkbox.disabled = false;
                });
            }
        });
    });
</script>
</html>
