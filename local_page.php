<?php

use Parser\Filesystem\Filesystem;
use Parser\Site\HtmlTools;
use Parser\Exceptions\CantResolveContentException;

require __DIR__ . '/src/bootstrap/app.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['filename'])) {
    $filename = $_POST['filename'];

    if (empty($errors)) {
        $tools = new HtmlTools(
            Filesystem::disk('pages')
        );

        try {
            $statistics = $tools->getTagStatistics($filename);
        } catch (CantResolveContentException $e) {
            $errors[] = sprintf(
                'Unable to get tag statistics from "%s" (%s), try another file',
                $e->getPath(),
                $e->getMessage()
            );
        }
    }
}

$filename ??= '';
$filename = htmlspecialchars($filename);

$form = <<<HTML
<a href="/">By URL</a> | <a href="/local_page.php" class="active">By Local Filename</a>

<form action="$_SERVER[REQUEST_URI]" method="post">
    <label for="url">Filename in local "pages" directory:</label>
    <input type="text" name="filename" placeholder="test.html" value="$filename">
    <input type="submit" value="Submit">
</form>
HTML;

require 'template.php';