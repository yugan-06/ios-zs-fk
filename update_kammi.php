<?php
header('Content-Type: application/json');

// 开启错误日志
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'error.log');

// 验证请求方法
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => '方法不允许']);
    exit;
}

// 检查文件权限
$filename = 'kammi.txt';
if (!file_exists($filename)) {
    error_log("文件不存在: $filename");
    http_response_code(500);
    echo json_encode(['error' => '卡密文件不存在']);
    exit;
}

if (!is_readable($filename) || !is_writable($filename)) {
    error_log("文件权限错误: $filename");
    http_response_code(500);
    echo json_encode(['error' => '文件权限错误']);
    exit;
}

// 获取POST数据
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!isset($data['kammi'])) {
    http_response_code(400);
    echo json_encode(['error' => '无效的请求数据']);
    exit;
}

// 写入更新后的卡密
$result = file_put_contents($filename, $data['kammi']);

if ($result === false) {
    error_log("写入文件失败: $filename");
    http_response_code(500);
    echo json_encode(['error' => '更新文件失败']);
    exit;
}

// 读取更新后的卡密数量
$current_kammis = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

echo json_encode([
    'success' => true,
    'remaining_count' => count($current_kammis)
]);
?> 