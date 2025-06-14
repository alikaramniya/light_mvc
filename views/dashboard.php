<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <form action="/logout" method="post">
        <?= $csrf['fields'] ?>
        <button>logout</button>
    </form>
   <h3>Dashboard page</h3> 
</body>
</html>