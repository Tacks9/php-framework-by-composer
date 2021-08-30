<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?php echo $page_title ?></title>
</head>

<body>
    <div class="article">
        <h1><?php echo $page_title; ?></h1>
        <hr>

        <ul>
            <li>
                <a href="<?php echo  $article['link']; ?>" target="_blank">
                    <?php echo "文章标题：" . $article['title']; ?>
                </a>
            </li>
        </ul>
    </div>



</body>

</html>