<!-- Request For Appointment-->
<?php

session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION["logged_in"] != true) {
    header("Location:donor_login.php");
    exit();
}
//Query Execution

try {
    include 'db_connection.php';

    if (isset($_POST['a_edit'])) {
        // Prepare and execute query
        $appointment_date = $_POST['appointment_date'];
        $appointment_time = $_POST['appointment_time'];
        $appointment_id = $_GET['id'];
        $status = 'Pending';
        $query = "UPDATE `appointments` SET `appointment_date`='$appointment_date',`appointment_time`='$appointment_time',`status`='$status' WHERE `appointment_id`='$appointment_id'";

        if ($conn->query($query)) {
            echo "<script>alert('Updated Succesfull');</script>";
        } else {
            echo "<script>alert('Updation Failed !!!')</script>";
        }
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Appointment</title>
    <!-- <link rel="stylesheet" type="text/css" href="css/header.css"> -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" tyep="text/css" href="css/forms.css">
    <link rel="stylesheet" tyep="text/css" href="css/donor.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
</head>

<body>
    <?php
    if (isset($_GET["id"])) {
    $appointment_id = $_GET['id'];
        $q = "SELECT * FROM `appointments` WHERE `appointment_id`='$appointment_id'";
        $statement = $conn->prepare($q);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
    }?>
    <header>
        <h1>
            <img src="assets/images/back.jpeg" alt="Back Button" id="backbtn" class="logos" onclick="history.back()">
            <a class="links" id="main_heading_link" href="donor_dashboard.php">Sarthi Blood Bank </a>
        </h1>
        <nav id="donor_nav">
            <a id="donor_appointment" class="nav_li_links links nav_element" href="donor_book_appointments.php"> Book Appointments</a>
            <a style="color:var(--color);" class="links nav_element" href="logout.php">Logout</a>
        </nav>
    </header>
    <main>
        <?php
        // print_r($_SESSION);
        ?>
        <h1> Edit Appointment</h1>

        <form id="appointment_form" method="post" action="" onsubmit="return validate_form()">
        
            <label for="appointment_date">Enter the Date :</label>
            <input type="date" id="appointment_date" name="appointment_date" value="<?= $result['appointment_date']; ?>" required><span id="appointment_date_error_logo"><img src="assets/images/cross.png"></span>
            <div id="date_err_msg" class="error"></div>

            <label for="appointment_date">Enter the Time :</label>
            <input type="time" id="appointment_time" name="appointment_time" value="<?= $result['appointment_time']; ?>" required><span id="appointment_time_error_logo"><img src="assets/images/cross.png"></span>
            <div id="time_err_msg" class="error"></div>
            <br>
            <input name="a_edit" value="Edit" class="buttons" type="submit">
            <input name="a_reset" value="Cancel" class="buttons" type="reset">

        </form>
    </main>
    <footer>
        <div>Copyright &copy; 2024. All rights reserved.</div>
        <div> &reg;Designed And Developed By <strong>
                <emp>Prasanna Sonawane</emp>
            </strong> And Tushar Chavan.</div>
    </footer>
    <script>
        function validate_form() {
            returnvalue = true;
            var a_date = new Date(document.getElementById("appointment_date").value);
            var today = new Date();
            if (a_date < today) {
                document.getElementById("date_err_msg").innerHTML =
                    "* Date should be in the future!!";
                document.getElementById("appointment_date").style.color = "red";
                document.getElementById("appointment_date").style.fontWeight = "bold";
                document.getElementById("appointment_date_error_logo").style.display = "inline";
                returnvalue = false;
            } else {
                document.getElementById("date_err_msg").innerHTML = "";
                document.getElementById("appointment_date").style.fontWeight = "normal";
                document.getElementById("appointment_date").style.color = "black";
                document.getElementById("appointment_date_error_logo").style.display = "none";
            }
            // var a_time = document.getElementById("appointment_time").value;
            // var minn=new Date(2024,10,21,10,0);
            // var maxx=new Date(2024,10,21,19,0);
            // var min=minn.getTime;
            // var max=maxx.getTime;

            // if (a_time < min) {
            //     document.getElementById("time_err_msg").innerHTML =
            //         "*Blood Bank Opens at 10AM and Closes at 7PM!!";
            //     document.getElementById("appointment_time").style.color = "red";
            //     document.getElementById("appointment_time").style.fontWeight = "bold";
            //     document.getElementById("appointment_time_error_logo").style.display = "inline";
            //     returnvalue = false;
            // } else {
            //     document.getElementById("time_err_msg").innerHTML = "";
            //     document.getElementById("appointment_time").style.fontWeight = "normal";
            //     document.getElementById("appointment_time").style.color = "black";
            //     document.getElementById("appointment_time_error_logo").style.display = "none";
            // }
            return returnvalue;
        }
        document.querySelectorAll('.nav_li_links').forEach(link => {
            if (link.href == window.location.href) {
                link.classList.add('active');
            }
        });
    </script>
</body>

</html>