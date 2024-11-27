<?php
    require_once '../../controllers/Academico.php';
    require_once '../../controllers/Sectores.php';
    require_once '../../components/Header.php';

    session_start();
    $caracterAcademico = new Academico();
    $caracteresAcademicos = $caracterAcademico->getAll();

    $sectores = new Sectores();
    $sectores = $sectores->getAll();
?>

<body class="bg-gray-100">    
    <?php
    require_once '../../components/navBar.php';
    require_once '../../components/Menu.php';
    
    ?>
    <section class="h-screen ml-[25vh]">
        <div class="bg-white pt-20 px-4">
            <div class="shadow-md shadow-gray-400 rounded-md p-2">
                <h2 class="text-3xl font-bold">Crear Institución</h2>
                <form action="../../controllers/EntidadesEducativas.php?action=create" method="POST" class="w-full flex flex-col gap-3 py-2 mb-2">
                    <div class="block px-2"> 
                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                <strong class="font-bold">¡Error!</strong>
                                <span class="block sm:inline"><?php echo $_SESSION['error']; ?></span>
                            </div>
                            <?php unset($_SESSION['error']); // Limpia el mensaje de error después de mostrarlo ?>
                        <?php endif; ?>

                        <label for="name" class="text-gray-800 mb-2">
                            Nombre de la institución
                        </label>
                        <input type="text" name="name" id="name" class="w-full p-2 border border-gray-200 rounded-md" placeholder="Nombre de la institución">
                    </div>
                    
                    <div class="block px-2"> 
                        <label for="name" class="text-gray-800 mb-2">
                            Tipo de Sector
                        </label>
                        <select class="w-full p-2 border border-gray-200 rounded-md bg-gray-50 hover:bg-gray-100" name="cod_academ">
                            <option value="" disabled selected>Selecciona un tipo de sector</option>
                            <?php  foreach ($caracteresAcademicos as $caracterAcademico):?>
                                <option value="<?php echo $caracterAcademico['cod_academ']; ?>"><?php echo $caracterAcademico['nomb_academ']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="block px-2"> 
                        <label for="name" class="text-gray-800 mb-2">
                            Tipo de Caracter Academico
                        </label>
                        <select class="w-full p-2 border border-gray-200 rounded-md bg-gray-50 hover:bg-gray-100" name="cod_sector">
                            <option value="" disabled selected>Selecciona un tipo de sector</option>
                            <?php  foreach ($sectores as $sector):?>
                                <option  value="<?php echo $sector['cod_sector']; ?>"><?php echo $sector['nomb_sector']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="flex items-center justify-between p-2">
                        <button type="reset" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">Cancelar</button>
                        <button type="sumbit" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">Guardar</button>
                    </div>
                </form> 
            </div>
        </div>
    </section>
    <script src="https://cdn.tailwindcss.com"></script>
</body>
</html>