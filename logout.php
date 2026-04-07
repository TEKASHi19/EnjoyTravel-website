<?php
include '../includes/db.php';
include '../includes/admin_header.php';

// 1. Contar Pendientes
$pendientes = 0;
$res_pend = $conn->query("SELECT count(*) as total FROM reservaciones WHERE estado='pendiente'");
if($res_pend) $pendientes = $res_pend->fetch_assoc()['total'];

// 2. Contar Confirmadas
$confirmadas = 0;
$res_conf = $conn->query("SELECT count(*) as total FROM reservaciones WHERE estado='confirmada'");
if($res_conf) $confirmadas = $res_conf->fetch_assoc()['total'];

// 3. Calcular Ingresos (CORREGIDO: Ahora une con la tabla 'paquetes')
$ingresos = 0;
$sql_ingresos = "SELECT SUM(p.precio) as total 
                 FROM reservaciones r 
                 JOIN paquetes p ON r.habitacion_id = p.id 
                 WHERE r.estado = 'confirmada'";
                 
$res_ingresos = $conn->query($sql_ingresos);

if ($res_ingresos) {
    $row = $res_ingresos->fetch_assoc();
    $ingresos = $row['total'];
}
?>

<h1 class="text-2xl font-bold text-slate-800 mb-6">Resumen General</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-rose-500 flex justify-between items-start">
        <div>
            <p class="text-sm text-slate-500 mb-1">Ingresos Estimados</p>
            <h3 class="text-2xl font-bold text-slate-900">$<?php echo number_format($ingresos ?? 0); ?> MXN</h3>
        </div>
        <div class="p-2 bg-rose-100 rounded-lg text-rose-600"><i data-lucide="dollar-sign"></i></div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-yellow-500 flex justify-between items-start">
        <div>
            <p class="text-sm text-slate-500 mb-1">Solicitudes Pendientes</p>
            <h3 class="text-2xl font-bold text-slate-900"><?php echo $pendientes; ?></h3>
        </div>
        <div class="p-2 bg-yellow-100 rounded-lg text-yellow-600"><i data-lucide="calendar"></i></div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-green-500 flex justify-between items-start">
        <div>
            <p class="text-sm text-slate-500 mb-1">Reservas Activas</p>
            <h3 class="text-2xl font-bold text-slate-900"><?php echo $confirmadas; ?></h3>
        </div>
        <div class="p-2 bg-green-100 rounded-lg text-green-600"><i data-lucide="check-circle"></i></div>
    </div>
</div>

<?php include '../includes/admin_footer.php'; ?>