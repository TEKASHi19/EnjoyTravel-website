<?php include 'includes/db.php'; ?>
<?php include 'includes/header.php'; ?>

<div class="relative h-[600px] flex items-center justify-center text-white overflow-hidden">
    <div class="absolute inset-0 bg-slate-900">
        <img src="assets/inicio.jpeg" alt="Wedding Venue" class="w-full h-full object-cover opacity-60">
    </div>
    
    <div class="relative z-10 text-center px-4 max-w-4xl mx-auto">
        <span class="text-rose-300 font-serif italic text-2xl mb-4 block">El escenario perfecto para tu historia</span>
        
        <h1 class="text-5xl md:text-7xl font-bold mb-6 tracking-tight">Bodas Inolvidables & Eventos Únicos</h1>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="paquetes.php" class="bg-rose-600 text-white hover:bg-rose-700 px-8 py-4 rounded-lg font-medium text-lg transition-colors">
                Ver Paquetes
            </a>
            <a href="galeria.php" class="bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white px-8 py-4 rounded-lg font-medium text-lg text-white transition-colors">
                Ver Galería Real
            </a>
        </div>
    </div>
</div>

<div class="py-16 px-4 max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
    <div class="p-6 group hover:-translate-y-1 transition-transform duration-300">
        <div class="w-12 h-12 bg-rose-100 rounded-full flex items-center justify-center mx-auto mb-4 text-rose-600 group-hover:scale-110 transition-transform">
            <i data-lucide="heart-handshake"></i>
        </div>
        <h3 class="font-bold text-lg mb-2">Planning Completo</h3>
        <p class="text-sm text-slate-500">Nos encargamos de cada detalle, desde el concepto hasta el último baile.</p>
    </div>
    
    <div class="p-6 group hover:-translate-y-1 transition-transform duration-300">
        <div class="w-12 h-12 bg-rose-100 rounded-full flex items-center justify-center mx-auto mb-4 text-rose-600 group-hover:scale-110 transition-transform">
            <i data-lucide="package-check"></i>
        </div>
        <h3 class="font-bold text-lg mb-2">Paquetes Flexibles</h3>
        <p class="text-sm text-slate-500">Opciones todo incluido o personalizadas según tu presupuesto.</p>
    </div>
    
    <div class="p-6 group hover:-translate-y-1 transition-transform duration-300">
        <div class="w-12 h-12 bg-rose-100 rounded-full flex items-center justify-center mx-auto mb-4 text-rose-600 group-hover:scale-110 transition-transform">
            <i data-lucide="map-pin"></i>
        </div>
        <h3 class="font-bold text-lg mb-2">Locaciones Exclusivas</h3>
        <p class="text-sm text-slate-500">Acceso a las mejores haciendas, playas y jardines de la región.</p>
    </div>
</div>

<?php include 'includes/footer.php'; ?>