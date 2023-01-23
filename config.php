<?php

$QUERYS = [
    1 => "SELECT last_name as 'Фамилия', first_name as 'Имя', middle_name as 'Отчество', user_position.created_at as 'Дата найма', TIMESTAMPDIFF(MONTH, DATE(user_position.created_at), CURDATE() ) as 'Отработано месяцев'
            FROM user, user_position
            WHERE user.id=user_position.user_id
            AND TIMESTAMPDIFF(MONTH, DATE(user_position.created_at), CURDATE() ) < 3
            ORDER BY last_name",

    2 => "  SELECT last_name as 'Фамилия', first_name as 'Имя', middle_name as 'Отчество', description as 'Причина увольнения'
            FROM user, user_dismission, dismission_reason
            WHERE user.id = user_dismission.user_id AND user_dismission.reason_id=dismission_reason.id",

    3 => "  SELECT last_users.name as 'Отделение', last_users.leader as 'Начальник',last_name as 'Фамилия', first_name as 'Имя', last_users.date as 'Дата найма'
            FROM
                (SELECT department.name as name, user.last_name as leader, MAX(user_position.user_id) as user_id, MAX(user_position.created_at) as date
                FROM user_position
                JOIN department
                    ON department.id=user_position.department_id
                JOIN user
                    ON user.id=department.leader_id
                GROUP BY department.id) as last_users
            JOIN user
            ON user.id = last_users.user_id ",

    4 => "SELECT * FROM user",
];

$LIMIT = 4;
$PAGE = 1;
$LINKS = 5;
$QUERY = 1;

$HOST = 'localhost';
$USER = 'root';
$PASS = '';
$DB = 'test';
$PORT = 3306;
