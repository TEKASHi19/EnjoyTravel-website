<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enjoy Travel - Agencia de Bodas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="font-sans text-slate-600 antialiased selection:bg-rose-200 selection:text-rose-900 bg-slate-50">

<nav class="bg-white/90 backdrop-blur-md sticky top-0 z-50 border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-24 items-center">
            <a href="index.php" class="flex items-center gap-3 cursor-pointer group">
                <img src="assets/logo.jpeg" alt="Enjoy Travel Logo" class="h-14 w-14 object-cover rounded-2xl shadow-md border-2 border-white group-hover:scale-105 transition-transform">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900 leading-none tracking-tight">ENJOY TRAVEL</h1>
                    <span class="text-xs text-rose-600 tracking-widest font-semibold">WEDDING PLANNER</span>
                </div>
            </a>
            
            <div class="hidden md:flex space-x-10 items-center">
                <a href="index.php" class="text-sm font-bold <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'text-rose-600' : 'text-slate-600 hover:text-slate-900'; ?> transition-colors">Inicio</a>
                <a href="paquetes.php" class="text-sm font-bold <?php echo basename($_SERVER['PHP_SELF']) == 'paquetes.php' ? 'text-rose-600' : 'text-slate-600 hover:text-slate-900'; ?> transition-colors">Paquetes</a>
                <a href="galeria.php" class="text-sm font-bold <?php echo basename($_SERVER['PHP_SELF']) == 'galeria.php' ? 'text-rose-600' : 'text-slate-600 hover:text-slate-900'; ?> transition-colors">Galería Real</a>
            </div>

            <div class="flex items-center gap-4">
                <a href="reservar.php" class="bg-rose-600 text-white hover:bg-rose-700 px-6 py-3 rounded-full font-bold shadow-lg shadow-rose-200/50 transition-all duration-300 hover:-translate-y-1 flex items-center gap-2">
                    <i data-lucide="calendar-heart" class="w-5 h-5"></i>
                    Cotizar Boda
                </a>
            </div>
        </div>
    </div>
</nav>