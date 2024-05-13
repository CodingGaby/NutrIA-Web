<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body{
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }
    </style>
    <title>Login</title>
</head>
<body>
    <section class="flex flex-col md:flex-row h-screen items-center">

        <div class="bg-indigo-600 hidden lg:block w-full md:w-1/2 xl:w-2/3 h-screen">
          <img src="https://firebasestorage.googleapis.com/v0/b/apipa-101ce.appspot.com/o/pexels-engin-akyurt-1435895.jpg?alt=media&token=873bc025-8fce-4ff0-97f9-a4fea0aaadf2" alt="" class="w-full h-full object-cover">
        </div>
      
        <div class="bg-white w-full md:max-w-md lg:max-w-full md:mx-auto md:mx-0 md:w-1/2 xl:w-1/3 h-screen px-6 lg:px-16 xl:px-12
              flex items-center justify-center">
      
          <div class="w-full h-100">
            <h1 class="text-xl md:text-2xl font-bold leading-tight mt-12">Log in to your account</h1>
      
            <form class="mt-6" action="#" method="POST">
              <div>
              <label class="block text-gray-700">Email Address</label>
                <input type="email" name="Email" id="" placeholder="Enter Email Address" class="w-full px-4 py-3 rounded-lg bg-gray-200 mt-2 border focus:border-blue-500 focus:bg-white focus:outline-none" autofocus autocomplete required>
              </div>
      
              <div class="mt-4">
                <label class="block text-gray-700">Password</label>
                <input type="password" name="Password" id="" placeholder="Enter Password" minlength="6" class="w-full px-4 py-3 rounded-lg bg-gray-200 mt-2 border focus:border-blue-500
                      focus:bg-white focus:outline-none" required>
              </div>
      
              <div class="text-right mt-2">
                <a href="#" class="text-sm font-semibold text-gray-700 hover:text-blue-700 focus:text-blue-700">Forgot Password?</a>
              </div>
              <!--
                <a href="Recipes.php" class="flex justify-center align-items my-6 w-full block bg-lime-700 hover:bg-lime-600 focus:bg-lime-600 text-white font-semibold rounded-full px-4 py-3 my-6">
                  Log In
                </a>
                -->
                <button type="submit" class="w-full block bg-lime-700 hover:bg-lime-600 focus:bg-lime-600 text-white font-semibold rounded-full px-4 py-3 mt-6">
                    Log In
                </button>
                
            </form>
            <?php
              if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $mail = $_POST['Email'];
                $passw = $_POST['Password'];

                $link = mysqli_connect("localhost", "root", "", "nutriia") or die("Error al conectar");

                $query = "SELECT email, password FROM users WHERE email = '$mail' AND password = '$passw'";

                $result = mysqli_query($link, $query);

                if (mysqli_num_rows($result) > 0) {
                  header("Location: Recipes.php");
                  exit();
                } else {
                  //echo "Contra mal";
                }
              }
            ?>
            <hr class="mt-6"/>
            <p class="mt-8">Need an account? <a href="register.php" class="text-lime-500 hover:text-lime-700 font-semibold">Create an account</a></p>
          </div>
        </div>
      </section>
</body>
</html>