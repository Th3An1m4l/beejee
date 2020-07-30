<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>APP</title>
    <link rel="stylesheet" href="/resources/css/bootstrap.min.css">
    <link rel="stylesheet" href="/resources/css/base.css">
</head>
<body>

    <?php if (isset($error)):?>
        <div class="alert alert-danger" role="alert">
            <?=$error?>
        </div>
    <?php endif ?>

    <?=$content?>


    <script src="/resources/js/jquery.min.js"></script>
    <script src="/resources/js/bootstrap.min.js"></script>
    <script src="/resources/js/base.js"></script>
    <script src="https://kit.fontawesome.com/1ec293fa5e.js" crossorigin="anonymous"></script>
</body>
</html>