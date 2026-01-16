<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Обработка предварительного запроса CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$file = 'data/offers.json';

if (file_exists($file)) {
    $json = file_get_contents($file);
    
    // Проверяем, что файл не пустой
    if (empty($json)) {
        // Возвращаем структуру с пустыми офферами
        echo json_encode([
            'offers' => [],
            'last_updated' => null,
            'landing1_count' => 0,
            'landing2_count' => 0,
            'total_count' => 0,
            'message' => 'Файл пуст'
        ]);
    } else {
        // Возвращаем содержимое файла
        echo $json;
    }
} else {
    // Возвращаем структуру с пустыми офферами
    echo json_encode([
        'offers' => [],
        'last_updated' => null,
        'landing1_count' => 0,
        'landing2_count' => 0,
        'total_count' => 0,
        'message' => 'Файл не найден. Создайте файл через админку.'
    ]);
}
?>
