<?php
require'config.php';
include 'headerr.php';

if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] !== 'admin') {
    header("Location: view-event.php");
    exit();
}
?>

<style>
    .container {
        margin-bottom: 30px;
    }
    .card {
        height: 500px;
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.3s ease;
        margin-bottom: 30px;
        position: relative;
    }
    .card:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }
    .admin-buttons {
        position: absolute;
        bottom: 10px;
        right: 10px;
    }
    .btn-edit, .btn-delete, .btn-readmore {
        margin-right: 5px;
    }
    .btn-readmore {
        background-color: #1C1D3C;
        color: white;
    }
</style>

<div class="container">
    <?php
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM events";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo '<div class="row">';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="col-lg-4 col-md-6 mt-5">';
            echo '<div class="card h-100">';
            echo '<img src="uploads/' . htmlspecialchars($row['image']) . '" class="card-img-top" style="object-fit: cover; height: 150px;" alt="' . htmlspecialchars($row['name']) . '">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . htmlspecialchars($row['name']) . '</h5>';
            echo '<p class="card-text">' . htmlspecialchars(substr($row['description'], 0, 100)) . '...</p>';
            echo '<div class="admin-buttons">';
            echo '<a href="event_details.php?id=' . htmlspecialchars($row['id']) . '" class="btn btn-sm btn-info btn-readmore">Read More</a>';
            echo '<a href="edit_event.php?id=' . htmlspecialchars($row['id']) . '" class="btn btn-sm btn-info btn-edit">Edit</a>';
            echo '<a href="delete_event.php?id=' . htmlspecialchars($row['id']) . '" class="btn btn-sm btn-danger btn-delete">Delete</a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
    } else {
        echo "No events found";
    }

    mysqli_close($conn);
    ?>
</div>

<?php
include 'footer.php';
?>
