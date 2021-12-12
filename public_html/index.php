<?php
    session_start();

    if(!isset($_SESSION["user"]))
    {
        header("Location: /login.php");
        exit;
    }

    $dbconn = pg_connect("host=postgres dbname=testdb user=user password=user")
    OR die('Не удалось соединиться: ' . pg_last_error());

    $query = 'SELECT city, country, continent, population_count FROM public."Population"';
    $result = pg_query($dbconn, $query) 
    OR die('Ошибка запроса: ' . pg_last_error());

    echo "<table border=\"1\"> \n";
    echo <<<END
        \t<tr>\n
        <th>Город</th>
        <th>Страна</th>
        <th>Материк</th>
        <th>Население</th>
        \t</tr>\n
    END;
    while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) 
    {
        echo "\t<tr>\n";
            foreach ($line as $col_value) 
            {
                echo "\t\t<td>$col_value</td>\n";
            }
    echo "\t</tr>\n";
    }
    echo "</table>\n";
    
    pg_free_result($result);
    pg_close($dbconn);

?>

<html lang="ru">
    <head>
        <meta charset="utf-8">
        <title>Главная страница</title>
    </head>
</html>


