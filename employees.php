<?php
session_start();

if (isset($_SESSION['role']) && isset($_SESSION['id'])) {

    include "DB_connection.php";
    include "app/Model/User.php";
    include "app/Model/Task.php";

    $employees = get_all_users($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employees</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<input type="checkbox" id="checkbox">

<?php include "inc/header.php" ?>

<div class="body">

    <?php include "inc/nav.php" ?>

    <section class="section-1">

        <h4 class="title">Employees</h4>

        <?php if ($employees != 0) { ?>

            <div class="main-table">
                <table>
                    <tr>
                        <th>Employee</th>
                        <th>Username</th>
                        <th>Tasks</th>
                    </tr>

                    <?php foreach ($employees as $employee) { ?>

                    <tr>
                        <td>
                            <a href="employee-tasks.php?id=<?=$employee['id']?>">
                                <?=$employee['full_name']?>
                            </a>
                        </td>

                        <td>
                            <?=$employee['username']?>
                        </td>

                        <td>
                            <?=count_my_tasks($conn, $employee['id'])?>
                        </td>
                    </tr>

                    <?php } ?>

                </table>
            </div>

        <?php } else { ?>

            <p>No employees found.</p>

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
