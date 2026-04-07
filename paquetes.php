<?php
include '../includes/db.php';
include '../includes/admin_header.php';

// --- LÓGICA: ELIMINAR EVENTO ---
if (isset($_GET['borrar'])) {
    $id = $_GET['borrar'];
    // Al borrar el evento, la BD borrará las fotos automáticamente si configuraste ON DELETE CASCADE
    // Si no, igual se borra el evento.
    $conn->query("DELETE FROM galeria_eventos WHERE id=$id");
    echo "<script>window.location.href='galeria.php';</script>";
}

// --- LÓGICA: GUARDAR EVENTO Y FOTOS ---
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $fecha = $_POST['fecha'];
    $descripcion = $_POST['descripcion'];
    $estilo = $_POST['estilo']; // grid, mosaico, carrusel
    
    // 1. Insertar el Evento en la tabla padre
    $stmt = $conn->prepare("INSERT INTO galeria_eventos (titulo, descripcion, fecha_evento, estilo_visual) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $titulo, $descripcion, $fecha, $estilo);
    
    if ($stmt->execute()) {
        $evento_id = $conn->insert_id; // ID del evento recién creado

        // 2. Procesar Múltiples Imágenes
        if (isset($_FILES['fotos'])) {
            $cantidad = count($_FILES['fotos']['name']);
            
            for ($i = 0; $i < $cantidad; $i++) {
                // Verificar errores en cada archivo
                if ($_FILES['fotos']['error'][$i] == 0) {
                    $tmp_name = $_FILES['fotos']['tmp_name'][$i];
                    $name = time() . "_" . $i . "_" . basename($_FILES['fotos']['name'][$i]);
                    
                    // Rutas
                    $ruta_servidor = "../assets/uploads/" . $name; // Donde se guarda físicamente (saliendo de admin)
                    $ruta_bd = "assets/uploads/" . $name;          // Ruta pública para guardar en BD
                    
                    if (move_uploaded_file($tmp_name, $ruta_servidor)) {
                        $conn->query("INSERT INTO galeria_fotos (evento_id, ruta_imagen) VALUES ($evento_id, '$ruta_bd')");
                    }
                }
            }
        }
    }
}

// OBTENER EVENTOS PARA EL LISTADO
// Usamos una subconsulta para sacar 1 foto cualquiera como portada
$eventos = $conn->query("
    SELECT e.*, 
    (SELECT ruta_imagen FROM galeria_fotos WHERE evento_id = e.id LIMIT 1) as portada 
    FROM galeria_eventos e 
    ORDER BY e.fecha_evento DESC
");
?>

<div class="max-w-6xl mx-auto">
    <h2 class="text-2xl font-bold text-slate-800 mb-6">Gestión de Galería Dinámica</h2>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 sticky top-4">
                <h3 class="font-bold mb-4 text-rose-600 text-lg">Nuevo Album de Fotos</h3>
                
                <form method="POST" enctype="multipart/form-data" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1 text-slate-700">Título del Evento</label>
                        <input type="text" name="titulo" placeholder="Ej. Boda en la Playa" required class="w-full border border-slate-300 p-2 rounded-lg focus:ring-2 focus:ring-rose-500 outline-none">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-1 text-slate-700">Fecha del Evento</label>
                        <input type="date" name="fecha" required class="w-full border border-slate-300 p-2 rounded-lg focus:ring-2 focus:ring-rose-500 outline-none">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-1 text-slate-700">Estilo de Visualización</label>
                        <select name="estilo" class="w-full border border-slate-300 p-2 rounded-lg bg-slate-50 focus:ring-2 focus:ring-rose-500 outline-none">
                            <option value="grid">Cuadrícula Clásica (Grid)</option>
                            <option value="mosaico">Mosaico Destacado (Grande + Pequeñas)</option>
                            <option value="carrusel">Carrusel Horizontal (Slider)</option>
                        </select>
                        <p class="text-xs text-slate-400 mt-1">Elige cómo verán las fotos los clientes.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1 text-slate-700">Seleccionar Fotos</label>
                        <input type="file" name="fotos[]" multiple accept="image/*" required class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-rose-50 file:text-rose-700 hover:file:bg-rose-100 cursor-pointer">
                        <p class="text-xs text-slate-400 mt-1">Mantén presionado <strong>Ctrl</strong> para seleccionar varias fotos a la vez.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1 text-slate-700">Breve Descripción</label>
                        <textarea name="descripcion" rows="3" class="w-full border border-slate-300 p-2 rounded-lg focus:ring-2 focus:ring-rose-500 outline-none"></textarea>
                    </div>
                    
                    <button type="submit" class="w-full bg-slate-900 text-white py-3 rounded-lg font-bold hover:bg-slate-800 transition-colors shadow-lg">
                        Crear Album
                    </button>
                </form>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-4">
            <?php if($eventos->num_rows > 0): ?>
                <?php while($row = $eventos->fetch_assoc()): ?>
                    <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 flex gap-4 items-start group hover:shadow-md transition-shadow">
                        
                        <div class="w-24 h-24 flex-shrink-0 bg-slate-100 rounded-lg overflow-hidden border border-slate-200">
                            <?php if($row['portada']): ?>
                                <img src="../<?php echo $row['portada']; ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <?php else: ?>
                                <div class="flex items-center justify-center h-full text-slate-300"><i data-lucide="image"></i></div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <h4 class="font-bold text-slate-800 text-lg"><?php echo $row['titulo']; ?></h4>
                                <span class="bg-rose-100 text-rose-800 text-xs px-2 py-1 rounded font-bold uppercase tracking-wider">
                                    <?php echo $row['estilo_visual']; ?>
                                </span>
                            </div>
                            <p class="text-sm text-slate-500 mb-2 flex items-center gap-1">
                                <i data-lucide="calendar" size="14"></i>
                                <?php echo date("d M Y", strtotime($row['fecha_evento'])); ?>
                            </p>
                            <p class="text-sm text-slate-600 line-clamp-2"><?php echo $row['descripcion']; ?></p>
                        </div>
                        
                        <a href="galeria.php?borrar=<?php echo $row['id']; ?>" onclick="return confirm('¿Estás seguro de borrar este album y todas sus fotos?')" class="text-slate-400 hover:text-red-600 hover:bg-red-50 p-2 rounded-lg transition-colors self-center">
                            <i data-lucide="trash-2"></i>
                        </a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="text-center py-12 bg-white rounded-xl border border-dashed border-slate-300">
                    <div class="text-slate-300 mb-2"><i data-lucide="image-plus" size="48" class="mx-auto"></i></div>
                    <p class="text-slate-500">No has creado ningún album todavía.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include '../includes/admin_footer.php'; ?>