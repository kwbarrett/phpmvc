<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <h1>Welcome</h1>
    <p>Hello <?= htmlspecialchars( $name ) ?>!</p>

    <ul>
        <?php foreach( $colours as $colour ){ ?>
            <li><?= htmlspecialchars( $colour ) ?> </li>
        <?php }; ?>
    </ul>
</body>
</html>