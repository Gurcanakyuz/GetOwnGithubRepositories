<?php
/**
 * Project: GetOwnGithubRepositories
 * Author: Gurcan
 * Date: 12.06.2018
 * Time: 22:13
 * File: index.oho.php
 */

use IGA\Controller\Github;
use IGA\Dotenv\Dotenv;

function autoload($className)
{
    $dir 		= __DIR__.'/src/';
    $classPath 	= $dir.$className.'.php';

    include($classPath);
}

spl_autoload_register('autoload');

if (!isset($_SERVER['APP_ENV'])) {
    if (!class_exists(Dotenv::class)) {
        throw new \RuntimeException('.env dosyası bulunamadı.');
    }
    (new Dotenv(__DIR__))->load();
}

$github = new Github();
$repositoryList = $github->getRepositoryList();
?>
<!doctype html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Repository List</title>
</head>
<body>
    <h1>Repository List</h1>
    <table cellpadding="5" cellspacing="0" border="1" width="100%" style="border: 1px solid #ddd">
        <thead>
            <tr>
                <th align="left" width="8%">ID</th>
                <th align="left">Name</th>
                <th align="left" width="8%">Language</th>
                <th align="left" width="8%">Star</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($repositoryList as $index => $repository) { ?>
            <tr>
                <td><?php echo $repository->id; ?></td>
                <td><a href="<?php echo $repository->html_url; ?>" target="_blank"><?php echo $repository->name; ?></a></td>
                <td><?php echo $repository->language; ?></td>
                <td><?php echo $repository->stargazers_count; ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</body>
</html>
