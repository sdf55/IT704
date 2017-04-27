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
            <textarea id="text" name="text" rows="10" cols="40"><?php
                    htmlout($text); ?></textarea>
        </div>
        <div>
        <label><b>Username</b></label>
    <input type="text" placeholder="Enter Username" value="<?php
                    htmlout($recipient); ?>" name="recipient" required>
    
    <label><b>Password</b></label>
    <input type="password" placeholder="Enter Password" value="<?php
                    htmlout($id); ?>" name="id" required/> 
    
            
            <input type="submit" name="form" value="<?php htmlout($button); ?>"/>
            <input type="checkbox" checked="checked"> Remember me
        </div>
    </form>
</body>
</html>

