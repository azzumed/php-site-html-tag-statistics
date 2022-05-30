<?php

use Parser\Website\Website;

require __DIR__ . '/vendor/autoload.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['url'])) {
    $url = $_POST['url'];
    $parseUrl = parse_url($url);

    if (!isset($parseUrl['scheme'])) {
        $errors[] = 'Please enter URL with valid scheme (https://, http://)';
    }

    if (empty($errors)) {
        $website = new Website($url);

        $statistics = $website->getTagStatistics($parseUrl['path'] ?? '/');

        if ($statistics === false) {
            $errors[] = 'Unable to get statistics from url, try later or use another site';
        }
    }
}

?>

<!DOCTYPE html>
<html>
<body>

<h2>Website tag statistics</h2>

<ul style="color: #fd4d4d">
    <?php foreach($errors AS $error): ?>
        <li><?php echo $error ?></li>
    <?php endforeach; ?>
</ul>

<form action="/" method="post">
    <label for="url">URL:</label>
    <input type="text" name="url" placeholder="https://github.com" value="<?php echo htmlspecialchars($url ?? '') ?>">
    <input type="submit" value="Submit">
</form>

<?php if(isset($statistics) && is_array($statistics)): ?>
    <ul style="color: #1b5cff">
        <?php foreach($statistics AS $item): ?>
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
</style>

</body>
</html>
