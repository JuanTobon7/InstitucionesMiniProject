<?php
    require_once './src/controllers/Estadisticas.php';
    require_once './src/controllers/EntidadesEducativas.php';
    require_once './src/controllers/Departamentos.php';
    require_once './src/controllers/Sectores.php';
    require_once './src/controllers/Academico.php';
    require_once './src/controllers/Acto.php';
    
   
           
    
    $tipoEstadistica = $_POST['tipo_estadistica'] ?? null;
    $departamentoSeleccionado = $_POST['departamento'] ?? null;
    $caracterSeleccionado = $_POST['academico']?? null;
    $sectorSeleccionado = $_POST['sector'] ?? null;
    $actoSeleccionado = $_POST['acto'] ?? null;

    // Crear una instancia del controlador
    $entidadesEducativas = new EntidadesEducativas(new Database());
    $estadistica = new Estadisticas(new Database);
    $departamentosCtrl = new Departamentos();
    $sectoresCtrl = new Sectores();
    $academicoCtrl = new Academico();
    $actoCtrl = new Acto();

    $departamentosNoRepeat = $departamentosCtrl->getAll();
    $sectoresNoRepeat = $sectoresCtrl->getAll();
    $academicoNoRepeat = $academicoCtrl->getAll();
    $actoNoRepeat = $actoCtrl->getAll();

    $instituciones = [];
    $institucionesPorCaracterAcademico = $estadistica->getStatisticsByAcademicCharacter();
    $institucionesPorSectorDepartamento = [];
    $institucionesPorActoAdmon = [];
    $institucionesPorNormaCreacion = $estadistica->getStatisticsByCreationNorm();
    $sectores = [];

    $tiposActo = $entidadesEducativas->actoAdmin();

    #por reporte
    $institucionesReporteAcadem = [];
    $institucionesCaracter = [];
    $institucionesSector = [];

    if($departamentoSeleccionado != null){
        $instituciones = $estadistica->getInstitutionsByDepartmentById($departamentoSeleccionado);
        $institucionesReporteAcadem = $estadistica->getInstByAcademic($caracterSeleccionado);
        $institucionesPorSectorDepartamento = $estadistica->getStatisticsBySectorAndDepartmentById($departamentoSeleccionado,$sectorSeleccionado);
        $institucionesPorActoAdmon = $estadistica->getStatisticsByAdministrativeActById($actoSeleccionado);
    }else{
        $instituciones = $estadistica->getInstitutionsByDepartment();
        $institucionesPorSectorDepartamento = $estadistica->getStatisticsBySectorAndDepartment();
        $institucionesCaracter = $entidadesEducativas->getByAcademicCHaracter($caracterSeleccionado);
        $institucionesSector = $entidadesEducativas->instBySector($sectorSeleccionado);
    }
    // Inicializar valores
   /*
    // Formatear los datos para JavaScript
    $departamentos = [];
    $institucionesActivas = [];
    $institucionesInactivas = [];
    $tiposCaracterAcademico = [];
    $totalInstitucionesPorCaracter = [];
    $actosAdministrativos = [];
    $totalInstitucionesPorActo = [];
    $institucionesPrivadas = [];
    $institucionesPublicas = [];
    $normasCreacion = [];
    $totalInstitucionesPorNorma = [];

    foreach ($instituciones as $institucion) {
        $departamentos[] = $institucion['nomb_depto'];
        if ($institucion['nomb_estado'] === 'Activa') {
            $institucionesActivas[] = $institucion['total_instituciones'];
            $institucionesInactivas[] = 0; // Para mantener el índice alineado
        } else {
            $institucionesInactivas[] = $institucion['total_instituciones'];
            $institucionesActivas[] = 0; // Para mantener el índice alineado
        }
    }

    foreach ($institucionesPorCaracterAcademico as $caracter) {
        $tiposCaracterAcademico[] = $caracter['nomb_academ'];
        $totalInstitucionesPorCaracter[] = $caracter['total_inst'];
    }

    foreach ($institucionesPorSectorDepartamento as $sector) {
        $sectores[] = $sector['nomb_depto'];
        if ($sector['nomb_sector'] == 'privado') {
            $institucionesPrivadas[] = $sector['total_inst'];
            $institucionesPublicas[] = 0;
        } else {
            $institucionesPublicas[] = $sector['total_inst'];
            $institucionesPrivadas[] = 0;
        }
    }

    foreach ($institucionesPorActoAdmon as $acto) {
        $actosAdministrativos[] = $acto['nomb_admon'];
        $totalInstitucionesPorActo[] = $acto['total_inst'];
    }

    foreach ($institucionesPorNormaCreacion as $norma) {
        $normasCreacion[] = $norma['nomb_norma'];
        $totalInstitucionesPorNorma[] = $norma['total_inst'];
    }*/
?>

<?php include './src/components/Header.php'; ?>
<body class="bg-gray-100">

        <?php include './src/components/navBar.php'; ?>
        <?php include './src/components/Menu.php'; ?>

        <section class="h-screen ml-[25vh] px-4 py-16">
                <h1 class="text-3xl font-bold px-4 mb-4">Reportes y Estadísticas de Instituciones</h1>

                <form method="POST" action="" class="flex flex-col gap-4 px-4 py-4 bg-white shadow-md rounded-md">
                <h2 class="text-xl font-semibold mb-2">Selecciona la Estadística a Consultar</h2>

                <div>
                    <!-- Selección de Tipo de Estadística -->
                    <label for="tipo_estadistica" class="block text-black font-medium mb-1">Tipo de Estadística:</label>
                    <select id="tipo_estadistica" name="tipo_estadistica" class="w-full p-2 border border-gray-300 rounded-md mb-2" onchange="toggleEleccion()">
                        <option value="0" <?= $tipoEstadistica == "0" ? 'selected' : '' ?>>Seleccione una consulta</option>
                        <option value="1" <?= $tipoEstadistica == "1" ? 'selected' : '' ?>>Instituciones Activas e Inactivas por Departamento</option>
                        <option value="2" <?= $tipoEstadistica == "2" ? 'selected' : '' ?>>Instituciones por Tipo de Carácter Académico</option>
                        <option value="3" <?= $tipoEstadistica == "3" ? 'selected' : '' ?>>Instituciones por Sector en Cada Departamento</option>
                        <option value="4" <?= $tipoEstadistica == "4" ? 'selected' : '' ?>>Instituciones por Acto Administrativo</option>
                        <option value="5" <?= $tipoEstadistica == "5" ? 'selected' : '' ?>>Cantidad de Instituciones por Norma de Creación</option>
                    </select>

                    <!-- Selección de Departamento -->
                    <div id="departamento_container" style="display: none;">
                        <label for="departamento" class="block text-black font-medium mb-1">Departamento</label>
                        <select id="departamento" name="departamento" class="w-full p-2 border border-gray-300 rounded-md">
                            <option value="">Todos</option>
                            <?php foreach ($departamentosNoRepeat as $depto): ?>
                                <option 
                                    value="<?php echo htmlspecialchars($depto["cod_depto"]); ?>" 
                                    <?= $departamentoSeleccionado == $depto["cod_depto"] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($depto["nomb_depto"]); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Selección de academico -->
                    <div id="academico_container" style="display: none;">
                        <label for="academico" class="block text-black font-medium mb-1">Carácter académico</label>
                            <select id="academico" name="academico" class="w-full p-2 border border-gray-300 rounded-md">
                                <option value="">Todos</option>
                                <?php foreach ($academicoNoRepeat as $academico): ?>
                                    <option 
                                        value="<?php echo htmlspecialchars($academico["cod_academ"]); ?>" 
                                        <?= $caracterSeleccionado == $academico["cod_academ"] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($academico["nomb_academ"]); ?>
                                    </option>
                                <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Selección de Sector -->
                    <div id="sector_container" style="display: none;">
                        <label for="sector" class="block text-black font-medium mb-1">Sector</label>
                            <select id="sector" name="sector" class="w-full p-2 border border-gray-300 rounded-md">
                                <option value="">Todos</option>
                                <?php foreach ($sectoresNoRepeat as $sector): ?>
                                    <option 
                                        value="<?php echo htmlspecialchars($sector["cod_sector"]); ?>" 
                                        <?= $sectorSeleccionado == $sector["cod_sector"] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($sector["nomb_sector"]); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                    </div>

                    <!-- Selección de Acto Administrativo -->
                    <div id="acto_container" style="display: none;">
                    <label for="acto" class="block text-black font-medium mb-1">Tipo Acto Administrativo</label>
                            <select id="acto" name="acto" class="w-full p-2 border border-gray-300 rounded-md">
                                <option value="">Todos</option>
                                <?php foreach ($actoNoRepeat as $acto): ?>
                                    <option 
                                        value="<?php echo htmlspecialchars($acto["cod_admon"]); ?>" 
                                        <?= $actoSeleccionado == $acto["cod_admon"] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($acto["nomb_admon"]); ?>
                                    </option>
                                <?php endforeach; ?>
                        </select>
                    
                    </div>

                </div>

                <!-- Botones -->
                <div class="flex justify-between">
                    <button type="reset" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Cancelar</button>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Confirmar</button>
                </div>
            </form>


        <?php if ($tipoEstadistica == "1"): ?>
            <div class="bg-white shadow-md rounded-lg px-4 pb-4">
                <div class="flex items-center justify-between px-4 pt-20 mb-2">
                    <h1 class="text-3xl font-bold">Tabla Instituciones</h1>
                </div>
                <table class="w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b text-left bg-gray-200">Nombre Institución</th>
                            <th class="py-2 px-4 border-b text-left bg-gray-200">ID Institución</th>
                            <th class="py-2 px-4 border-b text-left bg-gray-200">Sector</th>
                            <th class="py-2 px-4 border-b text-left bg-gray-200">Carácter Académico</th>
                            <th class="py-2 px-4 border-b text-left bg-gray-200">Municipio</th>
                            <th class="py-2 px-4 border-b text-left bg-gray-200">Departamento</th>
                            <th class="py-2 px-4 border-b text-left bg-gray-200">Estado</th>
                            <th class="py-2 px-4 border-b text-left bg-gray-200">Programas Vigentes</th>
                            <th class="py-2 px-4 border-b text-left bg-gray-200">Acreditada</th>
                        </tr>
                    </thead>
                    <tbody>                    
                        <?php foreach ($instituciones as $fila): ?>
                            <tr class="hover:bg-gray-100">
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($fila['nomb_inst']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($fila['cod_inst']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($fila['nomb_sector']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($fila['nomb_academ']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($fila['nomb_munic']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($fila['nomb_depto']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($fila['nomb_estado']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($fila['programas_vigente']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($fila['acreditada']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php elseif ($tipoEstadistica == "2"): ?>
            <div class="bg-white shadow-md rounded-lg px-4 pb-4">
                <div class="flex items-center justify-between px-4 pt-20 mb-2">
                    <h1 class="text-3xl font-bold">Tabla Instituciones</h1>
                </div>
                <table class="w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b text-left bg-gray-200">Nombre Institución</th>
                            <th class="py-2 px-4 border-b text-left bg-gray-200">ID Institución</th>
                            <th class="py-2 px-4 border-b text-left bg-gray-200">Sector</th>
                            <th class="py-2 px-4 border-b text-left bg-gray-200">Carácter Académico</th>
                            <th class="py-2 px-4 border-b text-left bg-gray-200">Municipio</th>
                            <th class="py-2 px-4 border-b text-left bg-gray-200">Departamento</th>
                            <th class="py-2 px-4 border-b text-left bg-gray-200">Estado</th>
                            <th class="py-2 px-4 border-b text-left bg-gray-200">Programas Vigentes</th>
                            <th class="py-2 px-4 border-b text-left bg-gray-200">Acreditada</th>
                        </tr>
                    </thead>
                    <tbody>                    
                        <?php foreach ($institucionesReporteAcadem as $fila): ?>
                            <tr class="hover:bg-gray-100">
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($fila['nomb_inst']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($fila['cod_inst']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($fila['nomb_sector']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($fila['nomb_academ']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($fila['nomb_munic']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($fila['nomb_depto']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($fila['nomb_estado']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($fila['programas_vigente']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($fila['acreditada']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php elseif ($tipoEstadistica == "3"): ?>
            <div class="bg-white shadow-md rounded-lg px-4 pb-4">
                <div class="flex items-center justify-between px-4 pt-20 mb-2">
                    <h1 class="text-3xl font-bold">Tabla Instituciones</h1>
                </div>
                <table class="w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b text-left bg-gray-200">Nombre Institución</th>
                            <th class="py-2 px-4 border-b text-left bg-gray-200">ID Institución</th>
                            <th class="py-2 px-4 border-b text-left bg-gray-200">Sector</th>
                            <th class="py-2 px-4 border-b text-left bg-gray-200">Carácter Académico</th>
                            <th class="py-2 px-4 border-b text-left bg-gray-200">Municipio</th>
                            <th class="py-2 px-4 border-b text-left bg-gray-200">Departamento</th>
                            <th class="py-2 px-4 border-b text-left bg-gray-200">Estado</th>
                            <th class="py-2 px-4 border-b text-left bg-gray-200">Programas Vigentes</th>
                            <th class="py-2 px-4 border-b text-left bg-gray-200">Acreditada</th>
                        </tr>
                    </thead>
                    <tbody>                    
                        <?php foreach ($institucionesPorSectorDepartamento as $fila): ?>
                            <tr class="hover:bg-gray-100">
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($fila['nomb_inst']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($fila['cod_inst']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($fila['nomb_sector']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($fila['nomb_academ']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($fila['nomb_munic']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($fila['nomb_depto']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($fila['nomb_estado']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($fila['programas_vigente']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($fila['acreditada']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            </section>
        <?php elseif ($tipoEstadistica == "4"): ?>
            <div class="bg-white shadow-md rounded-lg px-4 pb-4">
                <div class="flex items-center justify-between px-4 pt-20 mb-2">
                    <h1 class="text-3xl font-bold">Tabla Instituciones</h1>
                </div>
                <table class="w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b text-left bg-gray-200">Nombre Institución</th>
                            <th class="py-2 px-4 border-b text-left bg-gray-200">ID Institución</th>
                            <th class="py-2 px-4 border-b text-left bg-gray-200">Sector</th>
                            <th class="py-2 px-4 border-b text-left bg-gray-200">Acto Administrativo</th>
                            <th class="py-2 px-4 border-b text-left bg-gray-200">Municipio</th>
                            <th class="py-2 px-4 border-b text-left bg-gray-200">Departamento</th>
                            <th class="py-2 px-4 border-b text-left bg-gray-200">Estado</th>
                            <th class="py-2 px-4 border-b text-left bg-gray-200">Programas Vigentes</th>
                            <th class="py-2 px-4 border-b text-left bg-gray-200">Acreditada</th>
                        </tr>
                    </thead>
                    <tbody>                    
                        <?php foreach ($institucionesPorActoAdmon as $fila): ?>
                            <tr class="hover:bg-gray-100">
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($fila['nomb_inst']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($fila['cod_inst']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($fila['nomb_sector']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($fila['nomb_admon']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($fila['nomb_munic']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($fila['nomb_depto']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($fila['nomb_estado']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($fila['programas_vigente']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($fila['acreditada']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        </section>


        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            // Pasar los datos de PHP a JavaScript
            const departamentos = <?php echo json_encode($departamentos); ?>;
            const institucionesActivas = <?php echo json_encode($institucionesActivas); ?>;
            const institucionesInactivas = <?php echo json_encode($institucionesInactivas); ?>;
            const tiposCaracterAcademico = <?php echo json_encode($tiposCaracterAcademico); ?>;
            const totalInstitucionesPorCaracter = <?php echo json_encode($totalInstitucionesPorCaracter); ?>;
            const actosAdministrativos = <?php echo json_encode($actosAdministrativos); ?>;
            const totalInstitucionesPorActo = <?php echo json_encode($totalInstitucionesPorActo); ?>;
            const sectores = <?php echo json_encode($sectores); ?>;
            const institucionesPrivadas = <?php echo json_encode($institucionesPrivadas); ?>;
            const institucionesPublicas = <?php echo json_encode($institucionesPublicas); ?>;
            const normasCreacion = <?php echo json_encode($normasCreacion); ?>;
            const totalInstitucionesPorNorma = <?php echo json_encode($totalInstitucionesPorNorma); ?>;
            const tipoEstadistica = <?php echo json_encode($tipoEstadistica); ?>;
        
        function toggleEleccion() {
            const seleccion = document.getElementById('tipo_estadistica').value;
            const departamentoContainer = document.getElementById('departamento_container');
            const academicoContainer = document.getElementById('academico_container');
            const sectorContainer = document.getElementById('sector_container');
            const actoContainer = document.getElementById('acto_container');
            
            departamentoContainer.style.display = 'none';
            sectorContainer.style.display = 'none';
            actoContainer.style.display = 'none';
            academicoContainer.style.display = 'none'; 
            
            // Mostrar el contenedor correspondiente según la selección
            if (seleccion ==='3') {
                sectorContainer.style.display = 'block';
            } 
            if (seleccion === '1' || seleccion === '3') {
                departamentoContainer.style.display = 'block';
            } else if (seleccion === '4') {
                actoContainer.style.display = 'block';
            } else if (seleccion === '2') {
                academicoContainer.style.display = 'block';
            }
            
        }
        document.addEventListener('DOMContentLoaded', () => {
            toggleEleccion();
        });
        
            if(tipoEstadistica == '1'){            

                const ctxDepartamentos = document.getElementById('institucionesPorDepartamento').getContext('2d');
                const chartDepartamentos = new Chart(ctxDepartamentos, {
                    type: 'bar',
                    data: {
                        labels: departamentos,
                        datasets: [
                            {
                                label: 'Instituciones Activas',
                                data: institucionesActivas,
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Instituciones Inactivas',
                                data: institucionesInactivas,
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
            else if(tipoEstadistica == '2'){

                // Configuración del gráfico de instituciones por carácter académico
                const ctxCaracterAcademico = document.getElementById('institucionesPorCaracterAcademico').getContext('2d');
                const chartCaracterAcademico = new Chart(ctxCaracterAcademico, {
                    type: 'pie',
                    data: {
                        labels: tiposCaracterAcademico,
                        datasets: [
                            {
                                label: 'Total de Instituciones',
                                data: totalInstitucionesPorCaracter,
                                backgroundColor: [
                                    'rgba(54, 162, 235, 0.5)', // Azul
                                    'rgba(255, 99, 132, 0.5)', // Rojo
                                    'rgba(75, 192, 192, 0.5)', // Verde
                                    'rgba(255, 206, 86, 0.5)', // Amarillo
                                    'rgba(153, 102, 255, 0.5)', // Morado
                                    'rgba(255, 159, 64, 0.5)', // Naranja
                                    'rgba(201, 203, 207, 0.5)' // Gris
                                ],
                                borderColor: [
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)',
                                    'rgba(201, 203, 207, 1)'
                                ],
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                                labels: {
                                    font: {
                                        size: 14
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return `${tooltipItem.label}: ${tooltipItem.raw} instituciones`;
                                    }
                                }
                            }
                        }
                    }
                });
            }
            else if(tipoEstadistica == '3'){            
                // Configuración del gráfico de instituciones por sector en cada departamento
                const ctxSector = document.getElementById('institucionesPorSector').getContext('2d');
                const chartSector = new Chart(ctxSector, {
                    type: 'bar',
                    data: {
                        labels: sectores,
                        datasets: [
                            {
                                label: 'Total de Privadas',
                                data: institucionesPrivadas,
                                backgroundColor: 'rgba(153, 102, 255, 0.5)', // Color morado
                                borderColor: 'rgba(153, 102, 255, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Total de Públicas',
                                data: institucionesPublicas,
                                backgroundColor: 'rgba(255, 159, 64, 0.5)', // Color naranja
                                borderColor: 'rgba(255, 159, 64, 1)',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
            else if(tipoEstadistica == '4'){
                // Configuración del gráfico de instituciones por acto administrativo
                const ctxActoAdmon = document.getElementById('institucionesPorActoAdmon').getContext('2d');
                const chartActoAdmon = new Chart(ctxActoAdmon, {
                    type: 'pie',
                    data: {
                        labels: actosAdministrativos,
                        datasets: [
                            {
                                label: 'Total de Instituciones',
                                data: totalInstitucionesPorActo,
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.5)', // Rojo
                                    'rgba(54, 162, 235, 0.5)', // Azul
                                    'rgba(255, 206, 86, 0.5)', // Amarillo
                                    'rgba(75, 192, 192, 0.5)' // Verde
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)'
                                ],
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                                labels: {
                                    font: {
                                        size: 14
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return `${tooltipItem.label}: ${tooltipItem.raw} instituciones`;
                                    }
                                }
                            }
                        }
                    }
                });
            }else if(tipoEstadistica == '5'){
                // Configuración del gráfico de instituciones por norma de creación
                const ctxNormaCreacion = document.getElementById('institucionesPorNormaCreacion').getContext('2d');
                const chartNormaCreacion = new Chart(ctxNormaCreacion, {
                    type: 'pie',
                    data: {
                        labels: normasCreacion,
                        datasets: [
                            {
                                label: 'Total de Instituciones',
                                data: totalInstitucionesPorNorma,
                                backgroundColor: [
                                    'rgba(54, 162, 235, 0.5)', // Azul
                                    'rgba(255, 99, 132, 0.5)', // Rojo
                                    'rgba(75, 192, 192, 0.5)', // Verde
                                    'rgba(255, 206, 86, 0.5)', // Amarillo
                                    'rgba(153, 102, 255, 0.5)', // Morado
                                    'rgba(255, 159, 64, 0.5)', // Naranja
                                    'rgba(201, 203, 207, 0.5)' // Gris
                                ],
                                borderColor: [
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)',
                                    'rgba(201, 203, 207, 1)'
                                ],
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                                labels: {
                                    font: {
                                        size: 14
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return `${tooltipItem.label}: ${tooltipItem.raw} instituciones`;
                                    }
                                }
                            }
                        }
                    }
                });
            }
        
        </script>
</body>
</html>
