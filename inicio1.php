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
    <title>Inicio Dinámico  y Menús</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
        .news-container { max-width: 900px; margin: 30px auto; }
        .news-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 30px;
            background: #f9f9f9;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
        }
        .news-image {
            flex: 0 0 200px;
            max-width: 200px;
            height: 150px;
            object-fit: cover;
        }
        .news-text {
            padding: 20px;
            flex: 1;
        }
        .logo { margin: 10px 0; }
        .logo-center { text-align: center; font-size: 2em; margin: 30px 0; }
        nav ul.dropdown { list-style: none; padding: 0; margin: 0; display: flex; }
        nav ul.dropdown > li { position: relative; margin-right: 20px; }
        nav ul.dropdown li ul { display: none; position: absolute; left: 0; top: 100%; background: #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.07); }
        nav ul.dropdown li:hover ul { display: block; }
        nav ul.dropdown li a { text-decoration: none; color: #333; padding: 8px 12px; display: block; }
        nav ul.dropdown li ul li { margin: 0; }
        footer { text-align: center; padding: 20px; background: #eee; margin-top: 40px; }
        @media (max-width: 600px) {
            .news-item { flex-direction: column; }
            .news-image { width: 100%; max-width: 100%; height: 180px; }
            nav ul.dropdown { flex-direction: column; }
            nav ul.dropdown > li { margin-bottom: 10px; }
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
        <p>&copy; 2025 JJ. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
