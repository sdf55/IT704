<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Title of the document</title>
</head>
<body>
    <h1>Suggestion System</h1>
    <h2>Manage Suggestions</h2>
    <?php foreach ($users as $user): ?>
        <table id="list">
            <thead>
                <tr>
                    <th class="left"><?php htmlout($user['firstname'] . ' '. $user['lastname']); ?></th><td class="right">
                    <form action="" method="post">
                        <div>
                            <input type="hidden" name="recipient" value="<?php
                                    echo $user['recipient']; ?>" />
                            <input type="submit" name="add" value="Add Suggestion" />
                        </div>
                    </form></td>
                </tr>
            </thead>
            <tbody>
                <?php 
                    if (count($user['suggestions']) > 0) {
                        foreach ($user['suggestions'] as $suggestion) {
                            echo '<tr><td>' . htmlspecialchars($suggestion['content']) . "</td><td class='right'>\n";
                            echo "<form action='' method='post'><div>\n";
                            echo "   <input type='hidden' name='id' value='" . htmlspecialchars($suggestion['id']) . "' />\n";
                            echo "   <input type='submit' name='edit' value='Edit Suggestion' />\n";
                            echo "</div></form></td></tr>\n";
                        }
                    } else {
                        echo "<tr><td colspan=\"2\">None</td></tr>\n";
                    }
                ?>
            </tbody>
       </table>
    <?php endforeach; ?>
    <p><a href="../index.html">Return to home</a></p>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/logininfo/include/logout.inc.html.php'; ?>
</body>
</html>