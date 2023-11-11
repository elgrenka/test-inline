<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Найденные записи</title>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="/favicon.png">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>

<?php

if (isset($_GET['search'])) {
    $search = $_GET['search'];
    if (strlen($search) >= 3) {
        $commentsUrl  = 'https://jsonplaceholder.typicode.com/comments';
        $commentsJson = file_get_contents($commentsUrl);
        $comments     = json_decode($commentsJson, true);
        $searchResult = [];

        foreach ($comments as $comment) {
            $commentBody = $comment['body'];
            $postId      = $comment['postId'];

            if (stripos($commentBody, $search) !== false) {
                $searchResult[] = [
                    'postId'  => $postId,
                    'comment' => $commentBody,
                ];
            }
        }

        if ( ! empty($searchResult)) {
            $postsUrl  = 'https://jsonplaceholder.typicode.com/posts';
            $postsJson = file_get_contents($postsUrl);
            $posts     = json_decode($postsJson, true);

            echo '<table class="table table-bordered caption-top">';
            echo '<caption>Результаты поиска</caption>';
            echo '<thead>';
            echo '<tr class="table-primary">
                  <th>Заголовок записи</th>
                  <th>Комментарий</th>
                  </tr>';
            echo '</thead>';
            echo '<tbody>';

            foreach ($searchResult as $result) {
                $postId  = $result['postId'];
                $comment = $result['comment'];

                foreach ($posts as $post) {
                    if ($post['id'] === $postId) {
                        $postTitle = $post['title'];

                        echo "<tr class='table-secondary'>
                              <td>$postTitle</td>
                              <td>$comment</td>
                              </tr>";
                    }
                }
            }
            echo '</tbody>';
            echo '</table>';
        } else {
            echo "<p class='pt-3 ps-3'>По вашему запросу ничего не найдено</p>";
        }
    } else {
        echo "<p class='pt-3 ps-3'>Введите минимум 3 символа для поиска</p>";
    }
}
?>

</body>
</html>








