<?php
// Leer el contenido del archivo menu.lst
$menuFile = 'menu.lst';
$menuItems = file($menuFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// Función para generar el HTML del menú
function generateMenu($items) {
    echo '<ul class="dropdown">';
    $parentItems = [];
    $subItems = [];
    $currentParent = null;

    // Separar elementos principales y subelementos
    foreach ($items as $item) {
        if (strpos($item, '-') === 0) {
            $subItems[] = trim($item, '- ');
        } else {
            if ($currentParent !== null) {
                $parentItems[] = ['item' => $currentParent, 'subItems' => $subItems];
                $subItems = [];
            }
            $currentParent = $item;
        }
    }
    if ($currentParent !== null) {
        $parentItems[] = ['item' => $currentParent, 'subItems' => $subItems];
    }

    // Generar HTML
    foreach ($parentItems as $parentItem) {
        $url = strtolower(str_replace(' ', '_', $parentItem['item'])) . '.php';
        echo '<li>';
        echo '<a href="' . htmlspecialchars($url) . '">' . htmlspecialchars($parentItem['item']) . '</a>';
        
        if (!empty($parentItem['subItems'])) {
            echo '<ul>';
            foreach ($parentItem['subItems'] as $subItem) {
                $subUrl = strtolower(str_replace(' ', '_', $subItem)) . '.php';
                echo '<li><a href="' . htmlspecialchars($subUrl) . '">' . htmlspecialchars($subItem) . '</a></li>';
            }
            echo '</ul>';
        }
        
        echo '</li>';
    }
    echo '</ul>';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Web</title>
    <style>
        /* Estilos para el menú desplegable */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom, rgb(192, 186, 185), rgb(19, 18, 18));
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 100px;
            background: linear-gradient(to bottom, rgb(192, 186, 185), rgb(19, 18, 18));
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 0 20px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
        }
        .dropdown {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .dropdown li {
            position: relative;
        }
        .dropdown li a {
            display: block;
            padding: 8px 16px;
            text-decoration: none;
            color: #000;
            border: 1px solid #000;
            border-radius: 4px;
            margin: 4px;
            background: linear-gradient(to bottom, rgb(192, 186, 185), rgb(19, 18, 18));
        }
        .dropdown li a:hover {
            background-color: #d0d0d0;
        }
        .dropdown li:hover > ul {
            display: block;
        }
        .dropdown ul {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            list-style-type: none;
            padding: 0;
            margin: 0;
            background-color: #fff;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        }
        .dropdown ul li a {
            padding: 8px 16px;
        }
        .content {
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 200px); /* Ajustar la altura para incluir el footer */
            background: linear-gradient(to bottom, rgb(192, 186, 185), rgb(19, 18, 18));
        }
        .logo-center {
            font-size: 48px;
            font-weight: bold;
        }
        footer {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100px;
            background: linear-gradient(to bottom, rgb(19, 18, 18), rgb(192, 186, 185));
            color: #fff;
            box-shadow: 0 -2px 4px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <img src="JJ.png" alt="Logo JJ" style="height: 80px;">
        </div>
        <nav>
            <?php generateMenu($menuItems); ?>
        </nav>
    </header>
    <div class="content">
        <div class="logo-center">JJ</div>
    </div>
    <footer>
        <p>&copy; 2025 JJ. Todos los derechos reservados.</p>
    </footer>
</body>
</html>