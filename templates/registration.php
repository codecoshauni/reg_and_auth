<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <a href="/auth">Sign In</a>
    <h1>Registration</h1>
    <div class="form-container">
        <form class="form-reg" name="registration" method="post" action="" autocomplete="off">
            <input type="hidden" name="xsrfToken" value="<?= htmlspecialchars($xsrfToken) ?>">
            <label>login:
                <input type="text" name="login" autofocus required>
            </label>
            <label>password:
                <input type="password" name="password" required>
            </label>
            <label>confirm password:
                <input type="password" name="confirm_password" required>
            </label>
            <label>email:
                <input type="email" name="email" required>
            </label>
            <label>name:
                <input type="text" name="name" required>
            </label>
            <button id="btn" type="submit">Sign Up</button>
        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script ser="js/send.js"></script>
</body>
</html>
