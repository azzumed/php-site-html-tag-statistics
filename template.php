<!DOCTYPE html>
<html lang="en">
<body>

<h2>Website tag statistics</h2>

<ul style="color: #fd4d4d">
    <?php foreach ($errors as $error): ?>
        <li><?php echo $error ?></li>
    <?php endforeach; ?>
</ul>

<?php echo $form ?>

<?php if (isset($statistics) && is_array($statistics)): ?>
    <ul style="color: #1b5cff">
        <?php foreach ($statistics as $item): ?>
            <li>
                <strong><?php echo $item['tag'] ?>: </strong>
                <span><?php echo $item['count'] ?></span>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<style>
    body {
        margin-left: 300px;
        margin-top: 100px;
    }

    form {
        margin-top: 25px;
    }
    a, a:visited, a:hover, a:active {
        color: inherit;
    }
    a.active {
        color: limegreen;
    }
</style>

</body>
</html>