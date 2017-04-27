<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Title of the document</title>
</head>
<body>
    <h1>Suggestion System</h1>
    <h2><?php htmlout($pagetitle); ?></h2>
    <form action="?<?php htmlout($action); ?>" method="post">
        <div>
            <label for="firstname">First Name: <input type="text" name="firstname"
                    id="firstname" value="<?php htmlout($firstname); ?>"/></label>
            <label for="lastname">Last Name: <input type="text" name="lastname"
                    id="lastname" value="<?php htmlout($lastname); ?>"/></label>
        </div>
        <div>
            <label for="username">Username: <input type="text" name="username"
                    id="username" value="<?php htmlout($username); ?>" 
		<?php if ($username) { echo 'disabled="disabled"'; } ?> /></label>
            <label for="password">Password: <input type="password" name="password"
                    id="password" value="<?php htmlout($password); ?>"/></label>
            <?php echo $action == 
		'editform' ? "Leave blank to retain existing password" : ""; ?>
        </div>
        <div>
            <label for="name">Email: <input type="text" name="email"
                    id="email" value="<?php htmlout($email); ?>"/></label>
        </div>
        <div>
            <input type="submit" value="<?php htmlout($button); ?>"/>
        </div>
    </form>
</body>
</html>