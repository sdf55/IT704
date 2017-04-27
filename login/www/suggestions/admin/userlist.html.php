<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Title of the document</title>
</head>
<body>
    <h1>Suggestion System</h1>
    <h2>User List</h2>
    <table id="userlist">
        <?php foreach ($users as $user): ?>
            <tr class="user">
                <td>
                    <?php echo $user['admin'] ? '<strong>' : ''; 
                          htmlout($user['lastname'] . ', ' . $user['firstname']);
                          echo $user['admin'] ? '</strong>' : '';
                          echo '</td><td>';
                          htmlout($user['username']);
                          echo '</td><td><a href="mailto:';
                          htmlout($user['email']);
                          echo '">';
                          htmlout($user['email']);
                          echo '</a>';
                     ?>
                </td>
                <td>
                <form action="" method="post">
                    <div>
                        <input type="hidden" name="username" value="<?php
                                echo $user['username']; ?>"/>
                        <input type="submit" name="action" value="Edit"/>
                        <input type="submit" name="action" value="Delete"/>
                    </div>
                </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <p><a href="?add">Add new user</a></p>
    <p><a href="/index.html">Return to home</a></p>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/logininfo/include/logout.inc.html.php'; ?>
</body>
</html>