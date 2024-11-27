<?php
require_once '../../controllers/EntidadesEducativas.php'; // Asegúrate de tener este controlador configurado para manejar la consulta.

// Crear una instancia del controlador
$instituciones = new EntidadesEducativas();
$datosInstituciones = $instituciones->getAll(); // Este método debe ejecutar la consulta proporcionada.
?>

<?php include '../../components/Header.php'; ?>
<body class="bg-gray-100">

    <?php include '../../components/navBar.php'; ?>
    <?php include '../../components/Menu.php'; ?>

    <section class="h-screen ml-[25vh]">
        <div class="bg-white shadow-md rounded-lg px-4 pb-4">
            <div class="flex items-center justify-between px-4 pt-20 mb-2">
                <h1 class="text-3xl font-bold">Instituciones</h1>
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
                    <?php foreach ($datosInstituciones as $fila): ?>
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

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="/src/js/helpers.js"></script>

</body>
</html>
