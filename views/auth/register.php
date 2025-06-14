<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        form {
            input {
                font-size: 18px;
                margin: 5px;
                width: 230px;
                height: 20px;
                outline: none;
            }
            .border-red {
                border:2px solid red;
            }
        }
    </style>
</head>

<body>
    <form action="/register" method="post">
        <?= $csrf['fields'] ?>
        <input value="<?= @$old['name'] ?>" autofocus type="text" name="name" class="<?= isset($errors['name'][0]) ? 'border-red' : '' ?>" placeholder="Enter name" id="">
        <?= showError(@$errors['name']) ?>
        <input type="email" value="<?= @$old['email'] ?>" name="email" class="<?= isset($errors['email'][0]) ? 'border-red' : '' ?>" placeholder="Enter email" id="">
        <?= showError(@$errors['email']) ?>
        <input type="password" name="password" class="<?= isset($errors['password'][0]) ? 'border-red' : '' ?>" placeholder="Enter password" id="">
         <?= showError(@$errors['password']) ?>
        <input type="password" name="confirm-password" class="<?= isset($errors['confirm-password'][0]) ? 'border-red' : '' ?>" placeholder="Confirm password" id="">
         <?= showError(@$errors['confirm-password']) ?>
        <button>register</button>
    </form>
</body>

</html>