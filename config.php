<?php
session_start();
// Verificar si el usuario está logueado, si no, redirigir al login
if (!isset($_SESSION['admin_logged_in']) && basename($_SERVER['PHP_SELF']) != 'index.php') {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin - Enjoy Travel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-100 font-sans text-slate-600">

<?php if (isset($_SESSION['admin_logged_in'])): ?>
<div class="flex min-h-screen">
    <aside class="w-64 bg-slate-900 text-white flex flex-col p-4 fixed h-full">
        <div class="mb-8 p-2">
            <h2 class="text-xl font-bold">Panel Admin</h2>
            <p class="text-xs text-slate-400">Sistema v1.0</p>
        </div>
        <nav class="space-y-2 flex-1">
            <a href="dashboard.php" class="block px-4 py-3 rounded-lg hover:bg-slate-800 <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'bg-rose-600' : ''; ?>">
                <div class="flex items-center gap-3"><i data-lucide="layout-dashboard" size="18"></i> Dashboard</div>
            </a>
            
            <a href="paquetes.php" class="block px-4 py-3 rounded-lg hover:bg-slate-800 <?php echo basename($_SERVER['PHP_SELF']) == 'paquetes.php' ? 'bg-rose-600' : ''; ?>">
                <div class="flex items-center gap-3"><i data-lucide="package" size="18"></i> Paquetes</div>
            </a>

            <a href="galeria.php" class="block px-4 py-3 rounded-lg hover:bg-slate-800 <?php echo basename($_SERVER['PHP_SELF']) == 'galeria.php' ? 'bg-rose-600' : ''; ?>">
                <div class="flex items-center gap-3"><i data-lucide="image" size="18"></i> Galería</div>
            </a>

            <a href="reservas.php" class="block px-4 py-3 rounded-lg hover:bg-slate-800 <?php echo basename($_SERVER['PHP_SELF']) == 'reservas.php' ? 'bg-rose-600' : ''; ?>">
                <div class="flex items-center gap-3"><i data-lucide="list-todo" size="18"></i> Solicitudes</div>
            </a>
        </nav>
        <a href="logout.php" class="mt-auto px-4 py-2 text-slate-400 hover:text-white flex items-center gap-2">
            <i data-lucide="log-out" size="18"></i> Cerrar Sesión
        </a>
    </aside>

    <main class="flex-1 ml-64 p-8">
<?php endif; ?>