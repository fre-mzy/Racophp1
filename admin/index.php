
<?php
declare(strict_types=1);

http_response_code(503);
header('Content-Type: text/html; charset=UTF-8');
header('Cache-Control: no-store, no-cache, must-revalidate');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RACO Management Portal</title>
    <style>
        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            background: #f4f6f5;
            color: #173b2d;
            font-family: Arial, sans-serif;
        }
        main {
            width: min(90%, 440px);
            padding: 40px;
            text-align: center;
            background: white;
            border-radius: 16px;
        }
        h1 { font-size: 24px; }
        p { color: #53665b; line-height: 1.6; }
    </style>
</head>
<body>
    <main>
        <h1>RACO Management Portal</h1>
        <p>The management portal is being prepared. Please check back later.</p>
    </main>
</body>
</html>
