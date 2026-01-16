<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Обработка предварительного запроса CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Проверяем метод запроса
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем данные из POST запроса
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    
    if ($data) {
        // Проверяем существование папки data
        if (!file_exists('data')) {
            mkdir('data', 0755, true);
        }
        
        // Сохраняем в файл offers.json
        $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $result = file_put_contents('data/offers.json', $json);
        
        if ($result !== false) {
            echo json_encode([
                'success' => true, 
                'message' => 'Данные успешно сохранены',
                'file_size' => $result,
                'offers_count' => count($data['offers'] ?? [])
            ]);
        } else {
            echo json_encode([
                'success' => false, 
                'error' => 'Не удалось записать файл',
                'file_path' => realpath('data/') . '/offers.json'
            ]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Некорректные данные JSON']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Метод не разрешен. Используйте POST']);
}
?>
