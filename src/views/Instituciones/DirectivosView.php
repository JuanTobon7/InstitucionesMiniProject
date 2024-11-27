<?php
require_once '../../controllers/Directivos.php';

// Crear una instancia del controlador
$directivo = new Directivos();
$rectores = $directivo->getAll();
?>

<?php include '../../components/Header.php'; ?>
<body class="bg-gray-100">

    <?php include '../../components/navBar.php'; ?>
    <?php include '../../components/Menu.php'; ?>

    <section class="h-screen ml-[25vh]">
        <div class="bg-white shadow-md rounded-lg px-4 pb-4">
            <div class="flex items-center justify-between px-4 pt-20 mb-2">
                <h1 class="text-3xl font-bold">Directivos</h1>
            </div>
            <table class="w-full bg-white border border-gray-200">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b text-left bg-gray-200">ID Institucion</th>
                        <th class="py-2 px-4 border-b text-left bg-gray-200">Nombre Institucion</th>
                        <th class="py-2 px-4 border-b text-left bg-gray-200">Nombre Directivo</th>
                        <th class="py-2 px-4 border-b text-left bg-gray-200">Cargo</th>
                    </tr>
                </thead>
                <tbody>                    
                    <?php foreach ($rectores as $rectores): ?>
                        <tr class="hover:bg-gray-100">
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($rectores['cod_inst']); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($rectores['nomb_inst']); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($rectores['nomb_directivo']); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($rectores['nomb_cargo']); ?></td>
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

