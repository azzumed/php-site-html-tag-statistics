<?php

use Parser\Filesystem\Filesystem;
use Parser\Site\HtmlTools;
use Parser\Exceptions\CantResolveContentException;

require __DIR__ . '/src/bootstrap/app.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['url'])) {
    $url = $_POST['url'];
    $parseUrl = parse_url($url);

    if (!isset($parseUrl['scheme'])) {
        $errors[] = 'Please enter URL with valid scheme (https://, http://)';
    }

    if (empty($errors)) {
        $tools = new HtmlTools(
            Filesystem::customDisk('temp_http', [
                'driver' => 'http',
                'root' => $parseUrl['scheme'] . '://' . $parseUrl['host']
            ])
        );

        try {
            $statistics = $tools->getTagStatistics($parseUrl['path'] ?? '/');
        } catch (CantResolveContentException $e) {
            $errors[] = sprintf(
                'Unable to get tag statistics from "%s" (%s), try later or use another site',
                $e->getPath(),
                $e->getMessage()
            );
        }
    }
}

$url ??= '';
$url = htmlspecialchars($url);

$form = <<<HTML
<a href="/" class="active">By URL</a> | <a href="/local_page.php">By Local Filename</a>


<form action="$_SERVER[REQUEST_URI]" method="post">
    <label for="url">URL:</label>
    <input type="text" name="url" placeholder="https://github.com" value="$url">
    <input type="submit" value="Submit">
</form>
HTML;

require 'template.php';