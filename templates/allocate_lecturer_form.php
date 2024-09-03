<!-- templates/allocate_lecturer_form.php -->
<form method="POST" action="../public/allocate_lecturer.php" id="allocation_form">
    <label for="subject_id">Subject:</label>
    <select id="subject_id" name="subject_id" onchange="fetchLecturers()">
        <!-- Populate with subjects from the database -->
        <?php
        // Include database configuration
        require_once('../includes/config.php');
        
        // Start session to get department_id of logged-in user
        session_start();
        $department_id = $_SESSION['department_id'];
        
        // Query subjects for the logged-in user's department
        $sql = "SELECT id, name FROM subjects WHERE department_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $department_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Output options for subjects
        while ($subject = $result->fetch_assoc()) {
            echo "<option value='" . htmlspecialchars($subject['id']) . "'>" . htmlspecialchars($subject['name']) . "</option>";
        }
        ?>
    </select>
    
    <!-- Fetch and display courses from the database -->
    <label for="course">Course:</label>
    <select id="course" name="course" required>
        <?php
        $courses = $conn->query("SELECT id, name FROM courses");
        while ($course = $courses->fetch_assoc()) {
            echo "<option value='" . htmlspecialchars($course['id']) . "'>" . htmlspecialchars($course['name']) . "</option>";
        }
        ?>
    </select>
    
    <!-- Fetch and display levels from the database -->
    <label for="level">Level:</label>
    <select id="level" name="level" required>
        <?php
        $levels = $conn->query("SELECT id, name FROM levels");
        while ($level = $levels->fetch_assoc()) {
            echo "<option value='" . htmlspecialchars($level['id']) . "'>" . htmlspecialchars($level['name']) . "</option>";
        }
        ?>
    </select>
    
    <!-- Display initial option for lecturers -->
    <label for="lecturer_id">Lecturer:</label>
    <select id="lecturer_id" name="lecturer_id" required>
        <option value="">Select a subject first</option>
    </select>
    
    <label for="start_time">Start Time:</label>
    <input type="time" id="start_time" name="start_time" onchange="calculateDuration()" required>
    
    <label for="end_time">End Time:</label>
    <input type="time" id="end_time" name="end_time" onchange="calculateDuration()" required>
    
    <label for="duration">Duration:</label>
    <input type="text" id="duration" name="duration" readonly>
    
    <input type="submit" value="Allocate Lecturer">
</form>

<script>
function fetchLecturers() {
    var subject_id = document.getElementById('subject_id').value;
    
    if (subject_id === '') {
        // If no subject is selected, show default message
        document.getElementById('lecturer_id').innerHTML = "<option value=''>Select a subject first</option>";
    } else {
        // If subject is selected, fetch qualified lecturers
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    document.getElementById('lecturer_id').innerHTML = xhr.responseText;
                } else {
                    console.error('Error fetching lecturers: ' + xhr.status);
                }
            }
        };
        xhr.open('POST', '../public/fetch_lecturers.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('subject_id=' + subject_id);
    }
}

function calculateDuration() {
    var startTime = document.getElementById('start_time').value;
    var endTime = document.getElementById('end_time').value;
    
    if (startTime && endTime) {
        var start = new Date("1970-01-01 " + startTime);
        var end = new Date("1970-01-01 " + endTime);
        
        var diff = end.getTime() - start.getTime();
        var hours = Math.floor(diff / (1000 * 60 * 60));
        var minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        
        document.getElementById('duration').value = hours + ' hours ' + minutes + ' minutes';
    } else {
        document.getElementById('duration').value = '';
    }
}
</script>
