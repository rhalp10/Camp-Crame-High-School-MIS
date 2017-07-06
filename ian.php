<?php
$mysqli = new mysqli("localhost", "root", "", "cchsdbnew");
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
/* prepare statement */
if ($stmt = $mysqli->prepare("select gradetxnid,subjectid,gradingperiod,syid from gradetxn where subjectid=3 ")) {
    $stmt->execute();
/* bind variables to prepared statement */
    $stmt->bind_result($col1, $col2);
/* fetch values */
    while ($stmt->fetch()) {
        printf("%s %s\n", $col1, $col2);
    }
/* close statement */
    $stmt->close();
}
/* close connection */
$mysqli->close();

?>