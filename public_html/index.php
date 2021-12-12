<?php
    session_start();

    if(!isset($_SESSION["user"]))
    {
        header("Location: /login.php");
        exit;
    }

    $dbconn = pg_connect("host=postgres dbname=testdb user=user password=user")
    OR die('Не удалось соединиться: ' . pg_last_error());

    if(!isset($_GET['sort_by']) AND !isset($_GET['sort_grad']))
    {
        $_GET['sort_by'] = "id";
        $_GET['sort_grad'] = "ASC";
    }
    $order_column = $_GET['sort_by'];
    $order_type = $_GET['sort_grad'];
    
    $query = "SELECT city, country, continent, population_count FROM public.\"Population\" ORDER BY $order_column $order_type";
    $result = pg_query($dbconn, $query) 
    OR die('Ошибка запроса: ' . pg_last_error());

    if(isset($_GET['clean']))
    {
        header("Location: /index.php");
        exit;
    }

    echo <<<END
        <form method="get">
            <p>
                Сортировать по столбцу: 
                <select size="1" name="sort_by" >
                <option value="city"> Город </option>
                <option value="country"> Страна </option>
                <option value="continent"> Материк </option>
                <option value="population_count"> Население </option>
                </select>
                в порядке:
                <select size="1" name="sort_grad">
                <option value="ASC"> Возрастания </option>
                <option value="DESC"> Убывания</option>
                </select>
            </p>
            <p>
                <input type="submit">
                <input type="submit" name="clean" value="Очистить">
            </p>
        </form>
    END;

    
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
            foreach ($line as $col_key => $col_value) 
            {
                if ($col_key == $_GET["sort_by"])
                {
                    echo "\t\t<td style=\"background:#8FBC8F\">$col_value</td>\n";
                }
                else
                {
                    echo "\t\t<td>$col_value</td>\n";
                }
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


