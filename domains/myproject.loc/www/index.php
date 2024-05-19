<head>
    <meta charset="utf-8">
    <title>Основы PHP и MySQL</title>
    <style>
        /* Стилизация таблиц */
        table { border-collapse:separate; border:none; border-spacing:0; margin:8px 12px 18px 6px; line-height:1.2em; margin-left:auto; margin-right:auto; overflow: auto }
        table th { font-weight:bold; background:#666; color:white; border:1px solid #666; border-right:1px solid white }
        table th:last-child { border-right:1px solid #666 }
        table caption { font-style:italic; margin:10px 0 20px 0; text-align:center; color:#666; font-size:1.2em }
        tr{ border:none }
        td { border:1px solid #666; border-width:1px 1px 0 0 }
        td, th { padding:15px }
        tr td:first-child { border-left-width:1px }
        tr:last-child td { border-bottom-width:1px }
        .container {
            column-count: 4;
            column-gap: 20px;
        }
        .card {
            break-inside: avoid;
            page-break-inside: avoid;
            border: 2px solid rgb(79, 185, 227);
            padding: 10px;
            margin: 0 0 1em 0;
        }
    </style>
</head>
<body>
<div class="container">
    <div class = "card">
        <h3>Создание таблицы Departments и столбца departments_id в таблице Table_Podyanov (CREATE и ALTER)</h3>
        <form method="post" name="create_departments">
            <input type="submit" name="create_departments" value="Создать" />
        </form>
        <h3>Удаление таблицы Departments и столбца departments_id в таблице Table_Podyanov (DROP и ALTER)</h3>
        <form  method="post" name="drop_departments">
            <input type="submit" name="drop_departments" value="Удалить" />
        </form>
        <h3>Удаление процедуры create_view_procedure() (DROP)</h3>
        <form  method="post" name="drop_view_procedure">
            <input type="submit" name="drop_view_procedure" value="Удалить" />
        </form>
    </div>
    <div class = "card">
        <h1>DML запросы</h1>
        <h3>Добавление пользователя в Table_Podyanov (INSERT)</h3>
        <form action='insert_podyanov.php' method='post'>
            <input type='submit' value='Добавить'>
        </form>
        <h3>Добавление отделов в Departments (INSERT)</h3>
        <form action='insert_departments.php' method='post'>
            <input type='submit' value='Добавить'>
        </form>
        <h3>Вывод таблицы Table_Podyanov (SELECT)</h3>
        <form method="post" name="select_podyanov">
            <input type="submit" name="select_podyanov" value="Вывести" />
        </form>
        <h3>Вывод таблицы Departments (SELECT)</h3>
        <form method="post" name="select_departments">
            <input type="submit" name="select_departments" value="Вывести" />
        </form>
    </div>
    <div class = "card">
        <h1>Дополнительные запросы</h1>
        <h3>INNER JOIN запрос</h3>
        <form  method="post" name="inner_join">
            <input type="submit" name="inner_join" value="Вывести" />
        </form>
        <h3>Создать таблицу log</h3>
        <form  method="post" name="create_triggers">
            <input type="submit" name="create_triggers" value="Создать" />
        </form>
    </div>
    <div class = "card">
        <h1>VIEW (представления)</h1>
        <h3>Создать и вызвать процедуру create_view_procedure()</h3>
        <form  method="post" name="create_view_procedure">
            <input type="submit" name="create_view_procedure" value="Подтвердить" />
        </form>
        <h3>Вывести представление с ФИО, телефоном и зарплатой из таблицы Table_Podyanov</h3>
        <form  method="post" name="view1_podyanov">
            <input type="submit" name="view1_podyanov" value="Подтвердить" />
        </form>
        <h3>Вывести представление с ФИО и адресом из таблицы Table_Podyanov отсортированных по адресу по возрастанию</h3>
        <form  method="post" name="view2_podyanov">
            <input type="submit" name="view2_podyanov" value="Подтвердить" />
        </form>
        <h3>Вывести представление с ФИО и опытом работы > 4 из таблицы Table_Podyanov</h3>
        <form  method="post" name="view3_podyanov">
            <input type="submit" name="view3_podyanov" value="Подтвердить" />
        </form>
    </div>
</div>
<?php
//CONNECT
$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'Podyanov';

$link = new mysqli($db_host, $db_user, $db_password, $db_name);
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

mysqli_set_charset($link, "utf8");

echo "<p>Вы подключились к MySQL!</p>";

//CREATE
if(isset($_POST['create_departments'])) {
    $sql = "CREATE TABLE Departments (id INTEGER AUTO_INCREMENT PRIMARY KEY, name VARCHAR(50));";
    if ($link->query($sql)) {
        echo "Таблица Departments успешно создана<br>";
    } else {
        echo "Ошибка: " . $link->error . "<br>";
    }
    $sql = "ALTER TABLE Table_Podyanov ADD COLUMN department_id INT(30) AFTER Adress";
    if ($link->query($sql)) {
        echo "Колонка department_id успешно создана<br>";
    } else {
        echo "Ошибка: " . $link->error . "<br>";
    }
}
//DROP
if(isset($_POST['drop_departments'])) {
    $sql = "ALTER TABLE Table_Podyanov DROP COLUMN department_id";
    if ($link->query($sql)) {
        echo "Колонка department_id успешно удалена<br>";
    } else {
        echo "Ошибка: " . $link->error . "<br>";
    }
    $sql = "DROP TABLE IF EXISTS Departments";
    if ($link->query($sql)) {
        echo "Таблица Departments успешно удалена<br>";
    } else {
        echo "Ошибка: " . $link->error . "<br>";
    }
}
if(isset($_POST['drop_view_procedure'])) {
    $sql = "DROP PROCEDURE IF EXISTS create_view_procedure";
    if ($link->query($sql)) {
        echo "Процедура create_view_procedure() успешно удалена<br>";
    } else {
        echo "Ошибка: " . $link->error . "<br>";
    }
}



//SELECT
if(isset($_POST['select_podyanov'])) {
    $sql = "CREATE PROCEDURE SelectAll_Podyanov()
    BEGIN
        SELECT ID, Surname, Name, MidName, Phone, Salary, TIMESTAMPDIFF(Year, Experience, NOW()) AS Experience, Adress, department_id FROM Table_Podyanov;
    END";
    $link->query($sql);
    $sql = "CALL SelectAll_Podyanov()";
    if ($result = $link->query($sql)) {
        $rowsCount = $result->num_rows; // количество полученных строк
        echo "<p>Получено объектов: $rowsCount</p>";
        echo "<table><tr><th>ID</th><th>Surname</th><th>Name</th><th>MidName</th><th>Phone</th><th>Salary</th><th>Experience</th><th>Adress</th><th>Department_ID</th><th></th><th></th></tr>";
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row["ID"] . "</td>";
            echo "<td>" . $row["Surname"] . "</td>";
            echo "<td>" . $row["Name"] . "</td>";
            echo "<td>" . $row["MidName"] . "</td>";
            echo "<td>" . $row["Phone"] . "</td>";
            echo "<td>" . $row["Salary"] . "</td>";
            echo "<td>" . $row["Experience"] . "</td>";
            echo "<td>" . $row["Adress"] . "</td>";
            echo "<td>" . $row["department_id"] . "</td>";
            echo "<td><a href='update.php?id=" . $row["ID"] . "'>UPDATE</a></td>";
            echo "<td><form action='delete.php' method='post'>
                            <input type='hidden' name='id' value='" . $row["ID"] . "' />
                            <input type='submit' value='DELETE'>
                    </form></td>";
            echo "</tr>";
        }
        echo "</table>";
        $result->free();
    } else {
        echo "Ошибка: " . $link->error;
    }
}
//SELECT Departments
if(isset($_POST['select_departments'])) {
    $sql = "SELECT * FROM Departments";
    if ($result = $link->query($sql)) {
        $rowsCount = $result->num_rows; // количество полученных строк
        echo "<p>Получено объектов: $rowsCount</p>";
        echo "<table><tr><th>ID</th><th>Name</th><th></th><th></th></tr>";
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["name"] . "</td>";
            echo "<td><a href='update_departments.php?id=" . $row["id"] . "'>UPDATE</a></td>";
            echo "<td><form action='delete_departments.php' method='post'>
                            <input type='hidden' name='id' value='" . $row["id"] . "' />
                            <input type='submit' value='DELETE'>
                    </form></td>";
            echo "</tr>";
        }
        echo "</table>";
        $result->free();
    } else {
        echo "Ошибка: " . $link->error;
    }
}
//INNER JOIN
if(isset($_POST['inner_join'])) {
    $sql = "SELECT `Table_Podyanov`.`ID` AS `ID`,`Table_Podyanov`.`Surname` AS `Surname`, `Table_Podyanov`.`Name` AS `Name`, `Table_Podyanov`.`MidName` AS `MidName`, `Table_Podyanov`.`Phone` AS `Phone`, `Table_Podyanov`.`Salary` AS `Salary`, TIMESTAMPDIFF(Year, Experience, NOW()) AS Experience, `Table_Podyanov`.`Adress` AS `Adress`, `Departments`.`name` AS `Department_name`  FROM `Table_Podyanov` INNER JOIN `Departments` ON `Table_Podyanov`.`department_id`=`Departments`.`id`";
    if ($result = $link->query($sql)) {
        $rowsCount = $result->num_rows; // количество полученных строк
        echo "<p>Получено объектов: $rowsCount</p>";
        echo "<table><tr><th>ID</th><th>Surname</th><th>Name</th><th>MidName</th><th>Phone</th><th>Salary</th><th>Experience</th><th>Adress</th><th>Department_Name</th></tr>";
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row["ID"] . "</td>";
            echo "<td>" . $row["Surname"] . "</td>";
            echo "<td>" . $row["Name"] . "</td>";
            echo "<td>" . $row["MidName"] . "</td>";
            echo "<td>" . $row["Phone"] . "</td>";
            echo "<td>" . $row["Salary"] . "</td>";
            echo "<td>" . $row["Experience"] . "</td>";
            echo "<td>" . $row["Adress"] . "</td>";
            echo "<td>" . $row["Department_name"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        $result->free();
    } else {
        echo "Ошибка: " . $link->error;
    }
}
//TRIGGERS
if(isset($_POST['create_triggers'])) {
    $sql = "CREATE TABLE `log` (
        `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `msg` VARCHAR( 255 ) NOT NULL,
        `time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `row_id` INT( 11 ) NOT NULL
    ) ENGINE = InnoDB DEFAULT CHARSET=utf8mb3;";
    if ($link->query($sql)) {
        echo "Таблица log успешно создана<br>";
    } else {
        echo "Ошибка: " . $link->error . "<br>";
    }
    $sql = "CREATE TRIGGER `insert_test` AFTER INSERT ON `Table_Podyanov` FOR EACH ROW
    BEGIN
        INSERT INTO log Set msg = 'insert', row_id = NEW.id;
    END;";
    if ($link->query($sql)) {
        echo "Триггер insert в таблице Table_Podyanov успешно создан<br>";
    } else {
        echo "Ошибка: " . $link->error . "<br>";
    }
    $sql = "CREATE TRIGGER `update_test` AFTER UPDATE ON `Table_Podyanov` FOR EACH ROW
    BEGIN
        INSERT INTO log Set msg = 'update', row_id = OLD.id;
    END;";
    if ($link->query($sql)) {
        echo "Триггер update в таблице Table_Podyanov успешно создан<br>";
    } else {
        echo "Ошибка: " . $link->error . "<br>";
    }
    $sql = "CREATE TRIGGER `delete_test` AFTER DELETE ON `Table_Podyanov` FOR EACH ROW
    BEGIN
        INSERT INTO log Set msg = 'delete', row_id = OLD.id;
    END;";
    if ($link->query($sql)) {
        echo "Триггер delete в таблице Table_Podyanov успешно создан<br>";
    } else {
        echo "Ошибка: " . $link->error . "<br>";
    }
}
//VIEW Podyanov
if(isset($_POST['create_view_procedure'])) {
    $sql = "CREATE PROCEDURE create_view_procedure()
    BEGIN
        CREATE OR REPLACE VIEW SNMPS AS SELECT Surname, Name, MidName, Phone, Salary FROM Table_Podyanov;
        CREATE OR REPLACE VIEW SNMAbyAasc AS SELECT Surname, Name, MidName, Adress FROM Table_Podyanov ORDER BY Adress ASC;
        CREATE OR REPLACE VIEW SNME AS SELECT `Name`, `Surname`, `MidName`, TIMESTAMPDIFF(Year, Experience, NOW()) AS Experience FROM `Table_Podyanov` WHERE TIMESTAMPDIFF(Year, Experience, NOW()) > 4;
    END";
    if ($link->query($sql)) {
        echo "Процедура для создания или замены представлений была успешно создана<br>";
    } else {
        echo "Ошибка: " . $link->error . "<br>";
    }
    $sql = "CALL create_view_procedure()";
    if ($link->query($sql)) {
        echo "Процедура для создания или замены представлений была успешно вызвана<br>";
    } else {
        echo "Ошибка: " . $link->error . "<br>";
    }
}
if(isset($_POST['view1_podyanov'])) {
    $sql = "SELECT * FROM SNMPS";
    if ($result = $link->query($sql)) {
        $rowsCount = $result->num_rows; // количество полученных строк
        echo "<p>Получено объектов: $rowsCount</p>";
        echo "<table><tr><th>Surname</th><th>Name</th><th>MidName</th><th>Phone</th><th>Salary</th></tr>";
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row["Surname"] . "</td>";
            echo "<td>" . $row["Name"] . "</td>";
            echo "<td>" . $row["MidName"] . "</td>";
            echo "<td>" . $row["Phone"] . "</td>";
            echo "<td>" . $row["Salary"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        $result->free();
    } else {
        echo "Ошибка: " . $link->error;
    }
}
if(isset($_POST['view2_podyanov'])) {
    $sql = "SELECT * FROM SNMAbyAasc";
    if ($result = $link->query($sql)) {
        $rowsCount = $result->num_rows; // количество полученных строк
        echo "<p>Получено объектов: $rowsCount</p>";
        echo "<table><tr><th>Surname</th><th>Name</th><th>MidName</th><th>Address</th></tr>";
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row["Surname"] . "</td>";
            echo "<td>" . $row["Name"] . "</td>";
            echo "<td>" . $row["MidName"] . "</td>";
            echo "<td>" . $row["Adress"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        $result->free();
    } else {
        echo "Ошибка: " . $link->error;
    }
}
if(isset($_POST['view3_podyanov'])) {
    $sql = "SELECT * FROM SNME";
    if ($result = $link->query($sql)) {
        $rowsCount = $result->num_rows; // количество полученных строк
        echo "<p>Получено объектов: $rowsCount</p>";
        echo "<table><tr><th>Surname</th><th>Name</th><th>MidName</th><th>Experience</th></tr>";
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row["Surname"] . "</td>";
            echo "<td>" . $row["Name"] . "</td>";
            echo "<td>" . $row["MidName"] . "</td>";
            echo "<td>" . $row["Experience"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        $result->free();
    } else {
        echo "Ошибка: " . $link->error;
    }
}
?>

</body>
</html>