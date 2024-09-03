<!-- templates/exam_schedule_form.php -->
<form method="POST" action="../public/set_exam_schedule.php">
    <label for="exam_date">Examination Date:</label>
    <input type="date" id="exam_date" name="exam_date" required>
    <label for="exam_start">Exam Start Time:</label>
    <input type="time" id="exam_start" name="exam_start" required>
    <label for="exam_end">Exam End Time:</label>
    <input type="time" id="exam_end" name="exam_end" required>
    <input type="submit" value="Set Exam Schedule">
</form>
