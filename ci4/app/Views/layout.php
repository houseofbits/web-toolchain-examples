<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CodeIgniter4</title>
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico"/>
    <link rel="stylesheet" href="/assets/main.css">
</head>
<body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <a class="navbar-brand" href="#">CodeIgniter4</a>
        <!--ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="#">Active</a>
            </li>
        </ul-->
    </nav>

    <?= $this->renderSection('content') ?>

    <script src="/assets/main.js"></script>
</body>
</html>
