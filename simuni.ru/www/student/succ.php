<?session_start();
if (isset($_GET['exit'])) unset($_SESSION['user_id']);
isset($_SESSION['user_id']) or die("Вы не авторизованы. Пожалуйста, авторизуйтесь <a href=\"index.php\">здесь</a>");
mysql_connect("localhost", "root", "Phoenix");
mysql_select_db("simuni");
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
<form action="succ.php" method="POST">
    <p><select size="1" name="taskid">
        <option value="-1">Для всех задач</option>
        <?
        $tasks = mysql_query("SELECT TaskID,HometaskID,TaskForHometask FROM Task
        WHERE HometaskID <= ALL (SELECT Value FROM GeneralInfo WHERE `Name`='CurrentHometaskID')");
        $q = mysql_num_rows($tasks);
        for ($i = 0; $i < $q; $i++) {
            $row = mysql_fetch_array($tasks);
            if (strcmp($_POST['taskid'], $row['TaskID']) == 0) {
                echo "<option selected value=" . $row['TaskID'] . ">" . $row['HometaskID'] . " - " . $row['TaskForHometask'] . "</option>";
            } else {
                echo "<option value=" . $row['TaskID'] . ">" . $row['HometaskID'] . " - " . $row['TaskForHometask'] . "</option>";
            }
        }
        ?>
    </select>
     <input type="submit" value="фильтровать">
</form>
<table border="1">
    <caption>
        <h2>Загруженные решения:</h2>
    </caption>
    <tr>
        <td>
            <b>Номер д.з.</b>
        </td>
        <td>
            <b>Номер задачи в д.з.</b>
        </td>
        <td>
            <b>Время загрузки</b>
        </td>
        <td>
            <b>Результат</b>
        </td>
        <td>
            <b>Подробнее</b>
        </td>
        <td>
            <b>Результат тестирования</b>
        </td>
    </tr>
    <?
    $query = "SELECT DISTINCT * FROM Solution JOIN Task USING (TaskID) JOIN Result USING (ResultID)
     JOIN `User` USING (UserID) WHERE UserID='".$_SESSION['user_id']."'";
    //обрабатываем фильтр
    if (isset($_POST['taskid']) && $_POST['taskid']!=-1) $query=$query." AND Task.TaskID=".$_POST['taskid'];
    $query=$query." ORDER BY LoadTimestamp DESC";
   // echo $_SESSION['user_id'];
   // echo $query;
    $solutions = mysql_query($query);
    $q = mysql_num_rows($solutions);
    for ($i = 0; $i < $q; $i++) {
        $row = mysql_fetch_array($solutions);
        echo "<tr><td>" . $row[HometaskID] . "</td><td>" . $row[TaskForHometask] . "</td>
        <td>".$row[LoadTimestamp]."</td><td>" . $row[Text] . "</td>
        <td>" .
            "<form action=\"watch_solution.php\" method=\"POST\"><input type=\"hidden\" name=\"solutionid\" value=\"$row[SolutionID]\">
        <input type=\"submit\" value=\"подробнее\"></form></td><td>" . $row[TestResult] . "</td></tr>";
    }
    ?>
    <br/>

</table>
<a href="../index.php">На главную</a>
</body>
</html>