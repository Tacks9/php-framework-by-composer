<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?php echo $title ?></title>
</head>

<body>
    <div class="article">
        <h1><?php echo $title; ?></h1>
        <hr>
        <ul class="count">
            <li><?php echo "文章数量" . $count; ?></li>
        </ul>
        <div class="content">
            <table border="1">
                <?php foreach ($list as $item) { ?>
                    <tr>
                        <td><?php echo $item['id']; ?></td>
                        <td><?php echo $item['title']; ?></td>
                    </tr>
                <?php } ?>

            </table>
        </div>
    </div>



</body>

</html>