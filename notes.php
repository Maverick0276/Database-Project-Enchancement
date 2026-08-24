<?php
session_start();

if (isset($_SESSION['role']) && isset($_SESSION['id'])) {

    include "DB_connection.php";

    $user_id = $_SESSION['id'];

    // Save note
    if (isset($_POST['note'])) {

        $note = trim($_POST['note']);

        if (!empty($note)) {

            $sql = "INSERT INTO notes (user_id, note)
                    VALUES (?, ?)";

            $stmt = $conn->prepare($sql);
            $stmt->execute([$user_id, $note]);
        }
    }

    // Get all notes with the name of the user who wrote them
    $sql = "SELECT notes.*, users.full_name
            FROM notes
            JOIN users ON notes.user_id = users.id
            ORDER BY notes.created_at DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $notes = $stmt->fetchAll();

?>



<!DOCTYPE html>
<html>
<head>

    <title>Notes</title>

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

        <h4 class="title">Notes</h4>

        <!-- Write Note -->
        <form method="POST">

            <textarea
                name="note"
                rows="10"
                cols="60"
                placeholder="Write your note here..."
                required></textarea>

            <br><br>

            <button type="submit">
                Save Note
            </button>

        </form>

        <br>

        <h4>Saved Notes</h4>

        <!-- Display Notes -->
        <?php foreach ($notes as $note) { ?>

            <div>

                <strong>
                    <?=$note['full_name']?>
                </strong>

                <p>
                    <?=htmlspecialchars($note['note'])?>
                </p>

                <small>
                    <?=$note['created_at']?>
                </small>

            </div>

            <hr>

        <?php } ?>

    </section>

</div>

</body>
</html>

<?php

} else {

    $em = "First login";
    header("Location: login.php?error=$em");
    exit();

}

?>
