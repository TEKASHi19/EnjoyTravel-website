<?php
include '../includes/db.php';
session_start();

// Si ya está logueado, ir al dashboard
if (isset($_SESSION['admin_logged_in'])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = md5($_POST['password']); // Usamos MD5 para coincidir con el insert

    $sql = "SELECT * FROM admin_users WHERE username = '$user' AND password = '$pass'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: dashboard.php");
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold text-center text-slate-900 mb-6">Panel Administrativo</h2>
        <?php if($error): ?>
            <div class="bg-red-100 text-red-600 p-3 rounded mb-4 text-sm text-center"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-1">Usuario</label>
                <input type="text" name="username" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-rose-500 outline-none">
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-700 mb-1">Contraseña</label>
                <input type="password" name="password" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-rose-500 outline-none">
            </div>
            <button type="submit" class="w-full bg-rose-600 text-white py-2 rounded-lg hover:bg-rose-700 transition">Entrar</button>
        </form>
        <div class="mt-4 text-center">
            <a href="../index.php" class="text-sm text-slate-500 hover:text-rose-600">← Volver al sitio web</a>
        </div>
    </div>
</body>
</html>