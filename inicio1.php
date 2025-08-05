<?php
// --- Noticias dinámicas ---
$dir = 'inicio1/';
$news = [];
if (is_dir($dir)) {
    $files = scandir($dir);
    // Asociar imágenes y textos por nombre
    foreach ($files as $file) {
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        $name = pathinfo($file, PATHINFO_FILENAME);
        if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif'])) {
            $textFile = $name . '.txt';
            if (in_array($textFile, $files)) {
                $news[] = [
                    'image' => $dir . $file,
                    'text' => file_get_contents($dir . $textFile)
                ];
            }
        }
    }
}

// --- Menú dinámico ---
$menuFile = 'menu.lst';
$menuItems = [];
if (file_exists($menuFile)) {
    $menuItems = file($menuFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}

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
    <title>Menu Inicio1</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
	<div class="logo-menu">
           <p>I</p>
           <p>n</p>
	   <p>i</p>
           <p>c</p>
	   <p>i</p>
           <p>o</p>
    </div>
        <div class="news-container">
            <?php foreach ($news as $item): ?>
                <div class="news-item">
                    <img class="news-image" src="<?= htmlspecialchars($item['image']) ?>" alt="Imagen noticia">
                    <div class="news-text"><?= nl2br(htmlspecialchars($item['text'])) ?></div>
                </div>
            <?php endforeach; ?>
            <?php if (empty($news)): ?>
                <p>No se han encontrado noticias en el directorio.</p>
            <?php endif; ?>
        </div>
    </div>
    <footer>
       <div class="footer-class">
	<p>&copy; 2025 JJ. Todos los derechos reservados.</p>
     </div>
    </footer>
</body>
</html>
