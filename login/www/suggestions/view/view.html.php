<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Title of the document</title>
</head>
<body>
    <h1>Suggestion System</h1>
    <h2>View Suggestions</h2>
    <h3>Suggestions you have received</h3>
    <ul class="view">
    <?php 
        foreach ($suggestions as $suggestion) {
            echo "<li>{$suggestion}</li>\n";
        }
    ?>
    </ul>
    <p><a href="../index.html">Return to home</a></p>
    <?php include $_SERVER['DOCUMENT_ROOT'] .   
                                               '/logininfo/include/logout.inc.html.php'; ?>
</body>
</html>