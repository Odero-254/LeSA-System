<!-- templates/term_form.php -->
<form method="POST" action="../public/set_term_dates.php">
    <label for="start_date">Term Start Date:</label>
    <input type="date" id="start_date" name="start_date" required>
    <label for="end_date">Term End Date:</label>
    <input type="date" id="end_date" name="end_date" required>
    <input type="submit" value="Set Term Dates">
</form>
