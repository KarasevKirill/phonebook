<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <?php $this->getLayoutStyles()?>
    <title><?= $this->title ?: htmlspecialchars($this->title)?></title>
</head>
<body>
    <div id="root-div">
        <div class="header-panel">

        </div>

        <div class="container">

            <?= $content?>

        </div>

        <div class="footer">

        </div>
    </div>
    <?php $this->getLayoutScripts()?>
    <?php $this->getViewScripts()?>
</body>
</html>