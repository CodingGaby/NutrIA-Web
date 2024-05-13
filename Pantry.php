<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-image: url('https://firebasestorage.googleapis.com/v0/b/apipa-101ce.appspot.com/o/pexels-lumn-1028599.webp?alt=media&token=f3e63444-9666-4232-b161-ac45e9f9d646');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }
        * {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }
        .info_line {
            padding: 20px 0 0;
        }
        .btt_position {
            padding: 20px;
        }
    </style>
    <title>Pantry</title>
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
        <a href="index.php" class="flex-no-grow flex-no-shrink hover:underline hover:decoration-2 relative py-2 px-4 leading-normal no-underline flex items-center hover:bg-grey-dark">Home</a>
        <a href="Recipes.php" class="flex-no-grow flex-no-shrink hover:underline hover:decoration-2 relative py-2 px-4 leading-normal no-underline flex items-center hover:bg-grey-dark">Recipes</a>
    </div>
</nav>
<body class="flex justify-center align-items flex-col h-[900px]">
    <div class="flex justify-center align-items">
        <div class="bg-white w-[600px] rounded-lg p-6">
            <h2 class="text-center text-4xl font-bold">Food Pantry</h2>
            <p class="text-center py-6">Provide the food you have stored in your pantry and refrigerator.</p>
            <hr>
            <form class="auto_creation" action="Pantry.php" method = "post">
                <div class="row_foods">
                    <div class="info_line">
                        <label for="foods[]" class="block text-gray-700">Foods</label>
                        <input type="text" placeholder="Apple" class="w-full px-4 py-3 rounded-lg bg-gray-200 mt-2 border focus:border-blue-500 focus:bg-white focus:outline-none" name="foods[]">
                    </div>
                    <div class="info_line">
                        <label for="quantity[]" class="block text-gray-700">Quantity (grams)</label>
                        <input type="number" placeholder="29" name="quantity[]" min="0" class="w-full px-4 py-3 rounded-lg bg-gray-200 mt-2 border focus:border-blue-500 focus:bg-white focus:outline-none">
                    </div>
                    <hr class="mt-6">
                </div>
            
                <div class="add-option-container">
                    <button type = "button" class="BttAdd w-full block bg-lime-950 hover:bg-lime-900 focus:bg-lime-900 text-white font-semibold rounded-full px-4 py-3 my-6"> Add </button>
                </div>
                <button type="submit" class="flex justify-center align-items my-6 w-full block bg-lime-700 hover:bg-lime-600 focus:bg-lime-600 text-white font-semibold rounded-full px-4 py-3 my-6">Submit</button>

        </form>
        <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Conectar la base de datos
                    $link = mysqli_connect("localhost", "root", "", "nutriia");
                
                    // Recorrer los arrays de foods y quantity
                    $foods = $_POST['foods'];
                    $quantity = $_POST['quantity'];
                
                    // Verificar si hay al menos uno
                    if (!empty($foods)) {
                        // Combinamos los datos
                        $pair = array_combine($foods, $quantity);
                
                        // Hacer el insert
                        $query = "INSERT INTO foodspantry (Foods, Quantity) VALUES ";
                
                        // Parte del query con los valores combinados
                        $values = [];
                        foreach ($pair as $foods => $quantity) {
                            $values[] = "('$foods', '$quantity')"; // Corregido para agregar al array
                        }
                
                        // Combinamos los valores
                        $query .= implode(", ", $values);
                
                        // Ejecutamos la consulta
                        if (mysqli_query($link, $query)) {
                            // Redirigimos a Recipes
                            header("Location: Recipes.php");
                            exit();
                        } else {
                            echo "Error al insertar datos";
                        }
                    } else {
                        echo "No hay Comida";
                    }
                
                    // Cerramos la conexion
                    mysqli_close($link);
                }                
            ?>
        </div>
    </div>
</body>
<script>
    // Seleccionar el botón de añadir
    var addButton = document.querySelector('.BttAdd');

    function addOption() {
        // Clonar el bloque de alimentos
        var optionBlock = document.querySelector('.row_foods').cloneNode(true);

        // Limpiar los valores de los campos clonados
        var inputs = optionBlock.querySelectorAll('input');
        inputs.forEach(function(input) {
            input.value = ''; // Limpiar el valor del input
        });

        // Agregar el bloque clonado al formulario
        var form = document.querySelector('.auto_creation');
        var addOptionContainer = document.querySelector('.add-option-container');
        form.insertBefore(optionBlock, addOptionContainer);
    }

    // Asociar la función addOption al evento click del botón de añadir
    addButton.addEventListener('click', addOption);
</script>
</html>
