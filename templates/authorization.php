<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <a href="/">Sign Up</a>
    <h1>Authorization</h1>
    <div class="form-container">
        <form class="form-auth" name="authorization" method="post" action="" autocomplete="off">
            <input type="hidden" name="xsrfToken" value="<?= htmlspecialchars($xsrfToken) ?>">
            <label>login:
                <input type="text" name="login" autofocus required>
            </label>
            <label>password:
                <input type="password" name="password" required>
            </label>
            <button id="btn" type="submit">Sign In</button>
        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script ser="js/send.js"></script>
</body>
</html>
