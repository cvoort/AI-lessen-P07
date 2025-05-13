<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css"
          rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    <title>AI recept generator</title>
    <link rel="stylesheet" href=css/style.css>
</head>
<body>
<div class="container">
    <h1>AI Recept Generator</h1>
    <p>Voer hieronder je ingrediënten in en ontvang een recept!</p>

    <form action="process.php" method="POST">
        <div class="form-group">
            <label for="ingredients">Ingrediënten (gescheiden door komma's):</label>
            <textarea name="ingredients" id="ingredients" rows="4" required
                      placeholder="bijv. ui, knoflook, tomaat, pasta"></textarea>
        </div>
        <button type="submit">Genereer Recept</button>
    </form>

    <?php if (isset($_GET['message'])): ?>
        <div class="message">
            <?php echo htmlspecialchars($_GET['message']); ?>
        </div>
    <?php endif; ?>
</div>
</body>
</html>