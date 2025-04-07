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
