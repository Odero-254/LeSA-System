<?php
include('includes/config.php');

if(isset($_POST['subject_id'])){
    $subject_id = $_POST['subject_id'];

    $classQuery = $conn->prepare("SELECT classes.id, classes.class_name FROM classes
                                  JOIN subjects ON classes.course_id = subjects.course_id AND classes.level_id = subjects.level_id
                                  WHERE subjects.id = ?");
    $classQuery->bind_param("i", $subject_id);
    $classQuery->execute();
    $classResult = $classQuery->get_result();

    if($classResult->num_rows > 0){
        echo '<option value="">Select Class</option>';
        while($row = $classResult->fetch_assoc()){
            echo '<option value="'.$row['id'].'">'.$row['class_name'].'</option>';
        }
    }else{
        echo '<option value="">No classes available</option>';
    }
}
?>
