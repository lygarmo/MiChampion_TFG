<!DOCTYPE html>
<html lang="es" class="h-full">
    <head>
        <meta charset="UTF-8">
        <title>Iniciar sesión</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="/git/TFG/public/js/index.js"></script>
    </head>
    
    <body class="flex flex-col min-h-full bg-neutral-800">
        <!-- Incluir el header -->
        <?php include('components/header.php'); ?>

        <hr class="border-white border-opacity-10 border-t w-full mt-[5vh]">
        
        <main class="flex-grow text-white pt-20 pb-10 px-4">
           <div class="max-w-md mx-auto bg-neutral-800 rounded-xl shadow-2xl overflow-hidden p-8 border border-neutral-700">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-amber-400 mb-2">Iniciar Sesión</h1>
                    <p class="text-neutral-400">Accede a tu cuenta para continuar</p>
                </div>
                
                <form action="procesar_login.php" method="POST" class="space-y-6">
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-medium text-neutral-300">Email</label>
                        <input type="email" id="email" name="email" class="w-full px-4 py-3 bg-neutral-700 border border-neutral-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent text-white placeholder-neutral-400 transition duration-200"
                            placeholder="tucorreo@ejemplo.com" required >
                    </div>
                    
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-medium text-neutral-300">Contraseña</label>
                        <input type="password" id="password" name="password" class="w-full px-4 py-3 bg-neutral-700 border border-neutral-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent text-white placeholder-neutral-400 transition duration-200"
                            placeholder="••••••••" required>
                    </div>
                    
                    <div class="pt-2">
                        <button type="submit" class="w-full bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white font-bold py-3 px-4 rounded-lg shadow-lg hover:shadow-amber-500/20 transition duration-300 transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:ring-opacity-50">
                            Iniciar sesión
                        </button>
                    </div>
                </form>
                
                <div class="mt-6 text-center">
                    <p class="text-neutral-400">¿Todavía no tienes cuenta? 
                        <a href="registro.php" class="text-amber-400 hover:text-amber-300 cursor-pointer font-medium transition duration-200">Registrase</a>
                    </p>
                </div>
            </div> 
        </main>
        
        <!-- Incluir el footer -->
        <?php include('components/footer.php'); ?>
    </body>
</html>