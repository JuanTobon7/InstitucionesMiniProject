<?php
require_once '../../controllers/Instituciones.php';

// Crear una instancia del controlador
$entidadesEducativas = new Instituciones();
$instituciones = $entidadesEducativas->getAll();
?>

<?php include '../../components/Header.php'; ?>
<body class="bg-gray-100">

    <?php include '../../components/navBar.php'; ?>
    <?php include '../../components/Menu.php'; ?>

    <section class="h-screen ml-[25vh]">
        <div class="bg-white shadow-md rounded-lg px-4 pb-4">
            <div class="flex items-center justify-between px-4 pt-20 mb-2">
                <h1 class="text-3xl font-bold">Instituciones</h1>
                <a href="./CreateInstitucion.php" class=" cursor-pointer flex items-center gap-4">
                    <span class="font-bold">Añadir Institucion</span>                
                    <i class="material-icons text-white px-1 rounded-md bg-green-500 hover:bg-green-600">add</i>
                </a>
            </div>
            <table class="w-full bg-white border border-gray-200">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b text-left bg-gray-200">ID</th>
                        <th class="py-2 px-4 border-b text-left bg-gray-200">Nombre</th>
                        <th class="py-2 px-4 border-b text-left bg-gray-200">Dirección</th>
                        <th class="py-2 px-4 border-b text-left bg-gray-200">Teléfono</th>
                        <th class="py-2 px-4 border-b text-left bg-gray-200">Acciones</th>
                    </tr>
                </thead>
                <tbody>                    
                    <?php foreach ($instituciones as $institucion): ?>
                        <tr class="hover:bg-gray-100">
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($institucion['cod_inst']); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($institucion['nomb_inst']); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($institucion['cod_sector']); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($institucion['cod_academ']); ?></td>
                            <td class="py-2 px-4 border-b flex items-center gap-2">
                               
                                <form action="../../controllers/EntidadesEducativas.php?action=delete" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta institución?');">
                                    <input type="hidden" name="cod_inst" value="<?php echo htmlspecialchars($institucion['cod_inst']); ?>">
                                    <button type="submit" class="px-1 rounded-md bg-red-500 flex items-center cursor-pointer hover:bg-red-600">
                                        <i class="material-icons text-white">delete</i>
                                    </button>
                                </form>

                                <button onclick="auxiliarInstitucion(<?php echo htmlspecialchars(json_encode($institucion))?>,'/src/views/Instituciones/EditInstitucionesView.php')" class="px-1 rounded-md bg-orange-500 flex items-center cursor-pointer hover:bg-orange-600">
                                    <i class="material-icons text-white">edit</i>
                                </button>
                            </td>
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
