<?php 
include 'includes/db.php'; 
include 'includes/mailer.php'; // Asegúrate de que mailer.php tenga los datos de tu correo
include 'includes/header.php'; 

$mensaje = "";
$tipo_mensaje = "";

// PROCESAR EL FORMULARIO
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $conn->real_escape_string($_POST['clientName']);
    $email = $conn->real_escape_string($_POST['email']);
    $checkIn = $_POST['checkIn'];
    
    // Si no ponen fecha fin, usamos la misma de inicio
    $checkOut = !empty($_POST['checkOut']) ? $_POST['checkOut'] : $checkIn; 
    
    $paquete_id = $_POST['paqueteId'];
    $huespedes = $_POST['guests'];
    $notas = $conn->real_escape_string($_POST['notes']);

    // 1. INSERTAR EN BASE DE DATOS
    $sql = "INSERT INTO reservaciones (cliente_nombre, email, fecha_entrada, fecha_salida, huespedes, habitacion_id, notas) 
            VALUES ('$nombre', '$email', '$checkIn', '$checkOut', '$huespedes', '$paquete_id', '$notas')";

    if ($conn->query($sql) === TRUE) {
        
        // 2. ENVIAR CORREOS (ADMIN Y CLIENTE)
        $detalles = [
            'fecha' => $checkIn,
            'paquete' => $paquete_id,
            'invitados' => $huespedes,
            'notas' => $notas
        ];
        
        // Llamada a la función del mailer
        enviarNotificaciones($nombre, $email, $detalles);

        $mensaje = "¡Solicitud enviada con éxito! Hemos enviado una confirmación a tu correo.";
        $tipo_mensaje = "bg-green-100 text-green-700 border-green-200";
    } else {
        $mensaje = "Error al guardar: " . $conn->error;
        $tipo_mensaje = "bg-red-100 text-red-700 border-red-200";
    }
}

// OBTENER PAQUETES PARA EL SELECT
$paquetes = $conn->query("SELECT * FROM paquetes ORDER BY nombre ASC");
$paquete_seleccionado = isset($_GET['paquete']) ? $_GET['paquete'] : '';
?>

<div class="py-16 bg-rose-50 min-h-screen">
    <div class="max-w-3xl mx-auto px-4">
        
        <?php if($mensaje): ?>
            <div class="p-4 mb-6 rounded-lg border <?php echo $tipo_mensaje; ?> text-center font-bold shadow-sm">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-xl shadow-xl border border-rose-100 p-8">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-slate-900">Cotiza tu Boda</h2>
                <p class="text-slate-500">Cuéntanos tus planes y verifiquemos disponibilidad.</p>
            </div>
            
            <form method="POST" action="reservar.php" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nombre de los Novios / Contacto</label>
                        <input type="text" name="clientName" required class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-rose-500 outline-none transition-all" placeholder="Ej. Ana y Carlos">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Correo Electrónico</label>
                        <input type="email" name="email" required class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-rose-500 outline-none transition-all" placeholder="contacto@email.com">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Fecha del Evento</label>
                        <input type="date" name="checkIn" required class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-rose-500 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Fecha Fin (Opcional)</label>
                        <input type="date" name="checkOut" class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-rose-500 outline-none transition-all">
                        <p class="text-xs text-slate-400 mt-1">Solo si requieres hospedaje por varios días.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Paquete de Interés</label>
                        <select name="paqueteId" required class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-rose-500 outline-none transition-all">
                            <option value="">Selecciona un paquete...</option>
                            <?php 
                            // Reiniciamos el puntero si se usó arriba, aunque aquí es directo
                            if($paquetes->num_rows > 0){
                                $paquetes->data_seek(0); 
                                while($row = $paquetes->fetch_assoc()): 
                            ?>
                                <option value="<?php echo $row['id']; ?>" <?php echo ($paquete_seleccionado == $row['id']) ? 'selected' : ''; ?>>
                                    <?php echo $row['nombre']; ?> - $<?php echo number_format($row['precio']); ?>
                                </option>
                            <?php 
                                endwhile; 
                            }
                            ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Invitados Aproximados</label>
                        <input type="number" name="guests" min="10" max="500" value="100" class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-rose-500 outline-none transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Detalles Adicionales</label>
                    <textarea name="notes" class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-rose-500 outline-none h-32 resize-none transition-all" placeholder="Cuéntanos más sobre tu idea (Colores, temática, requerimientos especiales...)"></textarea>
                </div>

                <button type="submit" class="w-full bg-slate-900 text-white hover:bg-slate-800 px-4 py-3 rounded-lg font-bold transition-all duration-200 transform hover:scale-[1.01] shadow-lg">
                    Enviar Solicitud
                </button>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>