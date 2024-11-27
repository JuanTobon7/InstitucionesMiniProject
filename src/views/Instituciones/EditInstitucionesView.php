<?php 
    include '../../components/Header.php'; 
    require_once '../../controllers/Instituciones.php';
    require_once '../../controllers/Academico.php';
    require_once '../../controllers/Sectores.php';
     
    // Crear instancias de los controladores
    $entidadesEducativas = new Instituciones();
    $caracterAcademico = new Academico();
    $sector = new Sectores();
    
    // Obtener los datos de sectores y caracteres académicos
    $sectores = $sector->getAll();
    $caracteres = $caracterAcademico->getAll();
?>
<body class="bg-gray-100">

    <?php include '../../components/navBar.php'; ?>
    <?php include '../../components/Menu.php'; ?>
    <!-- Contenedor principal de la sección -->
    <section class="h-screen ml-[25vh] px-4 py-24">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h1 class="text-2xl font-bold mb-6">Editar Entidad</h1>
            <form  action="../../controllers/EntidadesEducativas.php?action=update" method="POST"  class="flex flex-col gap-6">
                <input type="hidden" name="cod_inst" id="cod_inst" value="<?php echo htmlspecialchars($institucion['cod_inst'] ?? ''); ?>">

                <label for="nomb_inst" class="flex flex-col">
                    <span class="font-medium">Nombre de la Institución:</span>
                    <input type="text" id="nomb_inst" name="nomb_inst" class="w-full border px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        value="<?php echo htmlspecialchars($institucion['nomb_inst'] ?? ''); ?>" required>
                </label>

                <div class="block px-2"> 
                    <label for="cod_academ" class="text-gray-800 mb-2">
                        Tipo de Sector
                    </label>
                    <select id="cod_academ" class="w-full p-2 border border-gray-200 rounded-md bg-gray-50 hover:bg-gray-100" name="cod_academ" required>
                        <option value="" disabled selected>Selecciona un tipo de sector</option>
                        <?php foreach ($caracteres as $caracter): ?>
                            <option value="<?php echo htmlspecialchars($caracter['cod_academ']); ?>">
                                <?php echo htmlspecialchars($caracter['nomb_academ']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="block px-2"> 
                    <label for="cod_sector" class="text-gray-800 mb-2">
                        Tipo de Caracter Académico
                    </label>
                    <select id="cod_sector" class="w-full p-2 border border-gray-200 rounded-md bg-gray-50 hover:bg-gray-100" name="cod_sector" required>
                        <option value="" disabled selected>Selecciona un tipo de sector</option>
                        <?php foreach ($sectores as $sector): ?>
                            <option value="<?php echo htmlspecialchars($sector['cod_sector']); ?>">
                                <?php echo htmlspecialchars($sector['nomb_sector']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="flex justify-between mt-6">
                    <button type="reset" class="px-6 py-2 rounded-md bg-gray-500 hover:bg-gray-600 text-white font-semibold">Cancelar</button>
                    <button type="submit" class="px-6 py-2 rounded-md bg-green-500 hover:bg-green-600 text-white font-semibold">Actualizar</button>
                </div>
            </form>
        </div>
    </section>
    
</body>
<script src="https://cdn.tailwindcss.com"></script>
<script>
    // Recuperar la entidad desde sessionStorage
    const institucion = JSON.parse(sessionStorage.getItem('institucion'));

    if (institucion) {
        // Asignar los valores al formulario
        document.getElementById('cod_inst').value = institucion.cod_inst;
        document.getElementById('nomb_inst').value = institucion.nomb_inst;
        document.getElementById('cod_sector').value = institucion.cod_sector;
        document.getElementById('cod_academ').value = institucion.cod_academ;
    } else {
        alert('No se encontraron datos de la entidad.');
    }
</script>
