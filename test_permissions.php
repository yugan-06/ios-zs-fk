<?php
$filename = 'kammi.txt';
echo "文件路径: " . realpath($filename) . "\n";
echo "文件权限: " . substr(sprintf('%o', fileperms($filename)), -4) . "\n";
echo "当前用户: " . exec('whoami') . "\n";
echo "可读: " . (is_readable($filename) ? '是' : '否') . "\n";
echo "可写: " . (is_writable($filename) ? '是' : '否') . "\n";
?> 