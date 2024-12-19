<?php
// Путь к файлу для хранения сообщений
$filename = 'messages.txt';

// Функция для сохранения сообщений в файл
function saveMessage($message) {
    global $filename;
    // Проверяем, что сообщение не пустое
    if (!empty($message)) {
        $message = htmlspecialchars($message);
        $message = date('Y-m-d H:i:s') . " - " . $message . "\n"; // Добавляем метку времени
        file_put_contents($filename, $message, FILE_APPEND);
    }
}

// Функция для получения всех сообщений из файла
function getMessages() {
    global $filename;
    if (file_exists($filename)) {
        return file_get_contents($filename);
    }
    return '';
}

// Обработка отправки сообщения
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['message'])) {
    $message = $_POST['message'];
    saveMessage($message);
}

// Получаем все сообщения
$messages = getMessages();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Простой чат на PHP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        #messages {
            border: 1px solid #ccc;
            padding: 10px;
            height: 300px;
            overflow-y: scroll;
            margin-bottom: 10px;
            width: 100%;
        }
        #input {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            box-sizing: border-box;
        }
        .message {
            margin-bottom: 10px;
        }
        .timestamp {
            font-size: 0.8em;
            color: #888;
        }
    </style>
</head>
<body>
    <h1>Простой чат</h1>

    <div id="messages">
        <?php echo nl2br($messages); ?>
    </div>

    <form method="POST">
        <input type="text" name="message" id="input" placeholder="Введите сообщение..." required>
        <button type="submit">Отправить</button>
    </form>

    <script>
        // Автоматическая прокрутка сообщений вниз
        const messagesDiv = document.getElementById('messages');
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    </script>
</body>
</html>
