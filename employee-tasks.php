<?php
session_start();

if (isset($_SESSION['role']) && isset($_SESSION['id'])) {

    include "DB_connection.php";
    include "app/Model/User.php";
    include "app/Model/Task.php";

    if (isset($_GET['id'])) {
        $employee_id = $_GET['id'];

        $employee = get_user_by_id($conn, $employee_id);
        $tasks = get_all_tasks_by_id($conn, $employee_id);
        $task_count = count_my_tasks($conn, $employee_id);
    } else {
        header("Location: employees.php");
        exit();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee Tasks</title>

    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<input type="checkbox" id="checkbox">

<?php include "inc/header.php" ?>

<div class="body">

    <?php include "inc/nav.php" ?>

    <section class="section-1">

        <?php if ($employee != 0) { ?>

            <h4 class="title">
                <?=$employee['full_name']?>'s Tasks
            </h4>

            <p>Total Tasks: <?=$task_count?></p>

            <?php if ($tasks != 0) { ?>

                <div class="main-table">

                    <table>

                        <tr>
                            <th>Task Name</th>
                            <th>Deadline</th>
                            <th>Description</th>
                        </tr>

                        <?php foreach ($tasks as $task) { ?>

                        <tr>

                            <td>
                                <?=$task['title']?>
                            </td>

                            <td>
                                <?=$task['due_date']?>
                            </td>

                            <td>
                                <?=$task['description']?>
                            </td>

                        </tr>

                        <?php } ?>

                    </table>

                </div>

            <?php } else { ?>

                <p>This employee has no tasks.</p>

            <?php } ?>

        <?php } else { ?>

            <p>Employee not found.</p>

        <?php } ?>

    </section>

</div>

</body>
</html>

<?php
}else{
    $em = "First login";
    header("Location: login.php?error=$em");
    exit();
}
?>
