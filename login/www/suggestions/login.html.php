<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Title of the document</title>
</head>
<body>
    <h1>Suggestion System</h1>
    <h2>Log In</h2>
    <p>Please log in before proceeding:</p>
    <?php if (isset($loginError)): ?>
        <p><?php echo htmlout($loginError); ?></p>
    <?php endif; ?>
    <form action="" method="post">
        <div>
            <label for="username">Username: <input type="text" name="username"
                    id="username"/></label>
        </div>
        <div>
            <label for="password">Password: <input type="password"
                    name="password" id="password"/></label>
        </div>
        <div>
            <input type="hidden" name="action" value="login"/>
            <input type="submit" value="Log in"/>
        </div>
    </form>
    <p><a href="/../index.html/">Return to main page</a></p>
</body>
</html>