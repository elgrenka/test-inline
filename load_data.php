<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Загрузка данных в базу данных</title>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="/favicon.png">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>

<?php
require_once 'config.php';

$hostname = DB_HOSTNAME;
$username = DB_USERNAME;
$password = DB_PASSWORD;
$dbname   = DB_NAME;

$link = new mysqli($hostname, $username, $password, $dbname);
if ($link->connect_error) {
    die("Ошибка: ".$link->connect_error);
}

$postsUrl  = 'https://jsonplaceholder.typicode.com/posts';
$postsJson = file_get_contents($postsUrl);
$posts     = json_decode($postsJson, true);

$commentsUrl  = 'https://jsonplaceholder.typicode.com/comments';
$commentsJson = file_get_contents($commentsUrl);
$comments     = json_decode($commentsJson, true);

// Posts
foreach ($posts as $post) {
    $postId = $post['id'];
    $userId = $post['userId'];
    $title  = $post['title'];
    $body   = $post['body'];

    $sql = $link->prepare("INSERT IGNORE INTO `posts` (`id`, `userId`, `title`, `body`)
            VALUES (?, ?, ?, ?)");
    $sql->bind_param("iiss", $postId, $userId, $title, $body);
    $sql->execute();
}

//Comments
foreach ($comments as $comment) {
    $commentId = $comment['id'];
    $postId    = $comment['postId'];
    $name      = $comment['name'];
    $email     = $comment['email'];
    $body      = $comment['body'];

    $sql = $link->prepare("INSERT IGNORE INTO `comments` (`id`, `postId`, `name`, `email`, `body`)
            VALUES (?, ?, ?, ?, ?)");
    $sql->bind_param("iisss", $commentId, $postId, $name, $email, $body);
    $sql->execute();
}

$postCount    = count($posts);
$commentCount = count($comments);

echo "<p class='pt-3 ps-3'>Загружено $postCount записей и $commentCount комментариев.</p>";
echo "<script>console.log('Загружено $postCount записей и $commentCount комментариев')</script>";

$link->close();
?>

</body>
</html>









