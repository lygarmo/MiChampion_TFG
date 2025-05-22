<link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
<style>
    .font-anton {
        font-family: 'Anton', sans-serif;
    }
</style>
<main class="text-white pt-10">
            <section id="fondo" class="mt-[35px]">
                <div class="w-full h-[calc(100vh-160px)] overflow-hidden relative">
                    <img src="public/fondo.jpg" alt="Fondo decorativo" class="w-full h-full object-cover">
                    <!-- Capa gris sobre la imagen -->
                    <div class="absolute top-0 left-0 w-full h-full flex items-center justify-center bg-black bg-opacity-50">
                        <div class="text-center">
                            <h2 class="text-[50px] md:text-[60px] lg:text-[70px] uppercase font-anton text-[#efece3] leading-none hover:text-amber-400 transition-colors duration-200">¡Bienvenido a Mi Champion!</h2>
                            <p class="text-[20px] md:text-[30px] lg:text-[35px] uppercase font-anton text-[#efece3] leading-none hover:text-amber-400 transition-colors duration-200">Descubre las mejores hamburguesas y únete a nuestra comunidad.</p>
                        </div>
                    </div>
                </div>
            </section>
            <hr class="border-white border-t w-[100%] mx-auto">

            <section id="preguntas" class="my-4 py-20 px-6">
                <h2 class="text-[50px] md:text-[60px] lg:text-[70px] uppercase font-anton text-[#efece3] leading-none hover:text-amber-400 transition-colors duration-200 text-center">NUESTRA PLATAFORMA</h2>
                <hr class="my-4 border-white border-t w-[60%] mx-auto">
                <div class="max-w-3xl mx-auto mt-6 space-y-4">
                    <!-- Acordeón 1 -->
                    <div>
                        <button class="accordion-btn w-full flex justify-between items-center p-4 border border-white rounded-lg hover:bg-zinc-700 transition">
                            <span class="text-[10px] md:text-[20px] lg:text-[25px] uppercase font-anton text-[#efece3] leading-none">¿Para qué sirve esta aplicación?</span>
                            <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div class="accordion-content hidden mt-2 p-4 bg-zinc-700 rounded text-gray-200">
                            <p><strong>Mi Champion</strong> te permite descubrir, valorar y disfrutar de las mejores hamburguesas en el campeonato "The Champion Burger".</p>
                        </div>
                    </div>

                    <!-- Acordeón 2 -->
                    <div>
                        <button class="accordion-btn w-full flex justify-between items-center p-4 border border-white rounded-lg hover:bg-zinc-700 transition">
                            <span class="text-[10px] md:text-[20px] lg:text-[25px] uppercase font-anton text-[#efece3] leading-none">¿Cómo se utiliza?</span>
                            <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div class="accordion-content hidden mt-2 p-4 bg-zinc-700 rounded text-gray-200">
                            <p>Solo tienes que registrarte, buscar tu burger favorita y guardarla en tu lista.</p>
                        </div>
                    </div>

                    <!-- Acordeón 3 -->
                    <div>
                        <button class="accordion-btn w-full flex justify-between items-center p-4 border border-white rounded-lg hover:bg-zinc-700 transition">
                            <span class="text-[10px] md:text-[20px] lg:text-[25px] uppercase font-anton text-[#efece3] leading-none">¿Cómo crear una cuenta?</span>
                            <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div class="accordion-content hidden mt-2 p-4 bg-zinc-700 rounded text-gray-200">
                            <p>Haz clic en "Crear cuenta", rellena tus datos (nombre, correo, contraseña) y confirma el registro. ¡Listo para disfrutar!</p>
                        </div>
                    </div>

                    <!-- Acordeón 4 -->
                    <div>
                        <button class="accordion-btn w-full flex justify-between items-center p-4 border border-white rounded-lg hover:bg-zinc-700 transition">
                            <span class="text-[10px] md:text-[20px] lg:text-[25px] uppercase font-anton text-[#efece3] leading-none">¿Puedo crearme una cuenta siendo menor de edad?</span>
                            <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div class="accordion-content hidden mt-2 p-4 bg-zinc-700 rounded text-gray-200">
                            <p>¡Claro que sí! Aquí somo todos bienvenidos</p>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <hr class="border-white border-t w-[100%] mx-auto">