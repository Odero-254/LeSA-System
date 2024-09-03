<!-- templates/weekly_schedule_form.php -->
<form method="POST" action="../public/set_weekly_schedule.php">
    <label for="day_of_week">Day of the Week:</label>
    <select id="day_of_week" name="day_of_week">
        <option value="Monday">Monday</option>
        <option value="Tuesday">Tuesday</option>
        <option value="Wednesday">Wednesday</option>
        <option value="Thursday">Thursday</option>
        <option value="Friday">Friday</option>
    </select>
    <label for="lesson_start">Lesson Start Time:</label>
    <input type="time" id="lesson_start" name="lesson_start" required>
    <label for="lesson_end">Lesson End Time:</label>
    <input type="time" id="lesson_end" name="lesson_end" required>
    <label for="break_start">Break Start Time:</label>
    <input type="time" id="break_start" name="break_start" required>
    <label for="break_end">Break End Time:</label>
    <input type="time" id="break_end" name="break_end" required>
    <input type="submit" value="Set Weekly Schedule">
</form>
