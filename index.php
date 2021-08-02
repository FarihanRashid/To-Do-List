<?php
require_once("./header.php");
require_once("./db_details.php");
$select_query = "SELECT * FROM $table_name";
$result_from_db = mysqli_query($db_connect, $select_query);

$unread_count_query = "SELECT count(*) AS unread_result FROM $table_name WHERE status='undone'";
$read_count_query = "SELECT count(*) AS read_result FROM $table_name WHERE status='done'";

$unread_count_result = mysqli_fetch_assoc(mysqli_query($db_connect, $unread_count_query))['unread_result'];
$read_count_result = mysqli_fetch_assoc(mysqli_query($db_connect, $read_count_query))['read_result'];

?>
<!-- navbar -->
<div class="main-nav">
    <div class="container">
        <h1>To-do List</h1>
        <p>Now, you can remember without remembering</p>
    </div>
</div>

<!-- Add New Task Form -->
<div class="modal fade form-input-sec" id="newTaskForm" tabindex="-1" aria-labelledby="newTaskForm" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newTaskForm">New Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-floating mb-3">
                        <textarea type="text" class="form-control" id="task_name" placeholder="Enter The Task Details" name="task_name"></textarea>
                        <label for="task_name" class="form-label">Task Details</label>
                    </div>
                    <div class="mb-3">
                        <label for="due_date" class="form-label">Due Date</label>
                        <input type="date" class="form-control" id="due_date" placeholder="Enter The Task Details" name="due_date">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add New Task</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php
if (isset($_POST['due_date']) && isset($_POST['task_name'])) {
    if ($_POST['due_date'] != "" && $_POST['task_name'] != "") {
        $date = $_POST['due_date'];
        $task_name = $_POST['task_name'];
        $date_short = strtotime($_POST['due_date']);
        $year = date("Y", $date_short);
        $month = date("F", $date_short);
        $day = date("d", $date_short);

        $insert_query = "INSERT INTO $table_name(task_name, date, year, month, day) VALUES('$task_name', '$date', $year, '$month', $day) ";
        mysqli_query($db_connect, $insert_query);

        header("location: index.php");
    } else {

?>
        <div class="overlay d-flex justify-content-center align-items-center alert alert-dismissible alert-danger fade show" role="alert">
            <div class="error-message alert-danger container">
                <h2><strong>Error!</strong> Please Insert the Data Properly</h2>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
<?php
    }
}
?>

<!-- Todo List $table_name -->
<div id="task-sec">
    <div class="container mt-5">
        <div class="card">
            <div class="card-header text-center p-3 text-white" style="background-color: #042575;">
                <h2>Tasks <br>Total: <?= mysqli_num_rows($result_from_db) ?>, Done: <?= $read_count_result ?>, Undone: <?= $unread_count_result ?></h2>
            </div>
            <div class="card-body table-responsive">
                <form action="./update_status.php" method="post" id="update_Form">
                    <table class="table table-bordered table-striped" id="myTable">
                        <thead>
                            <tr>
                                <th style="width:15% !important;">Serial Number</th>
                                <th>Task Name</th>
                                <th>Due-Date</th>
                                <th style="width:20% !important;">Status And Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $serial_num = 0;
                            foreach ($result_from_db as $task_detail) :
                            ?>
                                <tr>
                                    <td><?= ++$serial_num ?></td>
                                    <td><?= $task_detail['task_name'] ?></td>
                                    <td><?= $task_detail['month'] . " " . $task_detail['day'] . ", " . $task_detail['year'] ?></td>
                                    <td class="text-center">
                                        <input type="checkbox" name="<?= "status" . $serial_num ?>" id="<?= "status" . $serial_num ?>" value="<?= $task_detail['status'] ?>" <?= ($task_detail['status']) == "done" ? "checked" : "" ?>>
                                        <span onclick="dropDown(<?= $serial_num ?>)" class="border-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square ms-2" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                            </svg>
                                        </span>
                                        <a href="./delete_task.php?id=<?= $task_detail['id'] ?>" class="text-dark">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash ms-2" viewBox="0 0 16 16">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                                <tr id="drop_down_<?= $serial_num ?>" class="hide drop_down_item">
                                    <td style="opacity: 0;"><?= $serial_num ?></td>
                                    <td>
                                        <div class="mb-3">
                                            <label for="<?= $task_detail['id'] ?>" class="form-label">Task Details</label>
                                            <textarea type="text" class="form-control" id="task_name_update<?= $task_detail['id'] ?>" placeholder="Enter The Task Details" name="task_name_update<?= $task_detail['id'] ?>"><?= $task_detail['task_name'] ?></textarea>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="mb-3">
                                            <label for="due_date_update<?= $task_detail['id'] ?>" class="form-label">Due Date</label>
                                            <input type="date" class="form-control" id="due_date_update<?= $task_detail['id'] ?>" placeholder="Enter The Task Details" name="due_date_update<?= $task_detail['id'] ?>" value="<?= $task_detail['date'] ?>">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <button onclick="formDetailsUpdate(<?= $task_detail['id'] ?>)" class="btn btn-success">
                                            Update
                                        </button>
                                    </td>
                                </tr>
                            <?php
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Button -->
<div class="btn-wrapper d-flex justify-content-center">
    <button type="button" class="form-input-btn btn btn-primary" data-bs-toggle="modal" data-bs-target="#newTaskForm">
        Add New Task
    </button>
    <a href="./mark_all_done.php" class="btn btn-success">
        Mark All as Done
    </a>
    <a href="./mark_all_undone.php" class="btn btn-secondary">
        Mark All as Undone
    </a>
    <a href="./delete_all_task.php" class="btn btn-danger">
        Delete All
    </a>
    <button type=" submit" form="update_Form" class="btn btn-primary" value="update_form_btn" name="update_form_btn">
        Update Done/Undone
    </button>
</div>

<?php

require_once("./footer.php");
?>