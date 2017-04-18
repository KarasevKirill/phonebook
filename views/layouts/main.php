<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <?php $this->getStyles()?>
    <title><?= htmlspecialchars($this->title)?></title>
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
    <?php $this->getScripts()?>
</body>
</html>