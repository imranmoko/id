<?php
$dataFile = "links.json";
$data = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $custom = trim($_POST["custom"]);
    $original = trim($_POST["original"]);

    if ($custom && $original) {
        $data[$custom] = $original;
        file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT));
        $baseURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")
                 . "://{$_SERVER['HTTP_HOST']}/{$custom}";
        $message = "<div class='shortlink-box'>
                        <p><strong>Link berhasil dibuat:</strong></p>
                        <input type='text' id='shortlink' value='$baseURL' readonly>
                        <button onclick='copyLink()'>Salin Link</button>
                    </div>";
    } else {
        $message = "<div class='error-msg'>Mohon isi semua kolom!</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>ShortyLink - Shorten Your URLs</title>
    <link rel="stylesheet" href="style.css" />
    <script>
        function copyLink() {
            const copyText = document.getElementById("shortlink");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            document.execCommand("copy");
            alert("Link disalin: " + copyText.value);
        }
    </script>
</head>
<body>

<header class="hero fade-in delay-1">
    <div class="hero-content">
        <h1>🔗 ShortyLink</h1>
        <p>Buat link pendek yang mudah dibagikan dan terlihat profesional</p>
    </div>
</header>

<main class="main-section fade-in delay-2">
    <div class="form-card">
        <h2>Buat Shortlink Gratis</h2>
        <form method="POST" autocomplete="off">
            <input type="url" name="original" placeholder="Masukkan URL asli" required />
            <input type="text" name="custom" placeholder="Custom ID (contoh: diskon88)" required />
            <button type="submit">Buat Sekarang</button>
        </form>
        <?php if (!empty($message)) echo "<div class='fade-in delay-3'>$message</div>"; ?>
    </div>
</main>

<footer class="fade-in delay-3">
    <p>© <?= date('Y') ?> ShortyLink. Dibuat dengan ❤️ untuk kemudahan berbagi tautan.</p>
</footer>

</body>
</html>
