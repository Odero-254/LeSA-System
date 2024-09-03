<!-- sidebar.php -->
<div class="sidebar">
    <div class='sidebar-links'>
        <a href='#' onclick='loadContent("change_password.php")'>Change Password</a>
        

        <?php if ($user_role === 'Principal' || $user_role === 'Deputy Principal') { ?>
            <a href='#' onclick='loadContent("add_user_step1.php")'>Add User</a>
            <a href='#' onclick='loadContent("add_course.php")'>Add Course</a>
            <a href='#' onclick='loadContent("add_subject.php")'>Add Subject</a>
            <a href='#' onclick='loadContent("allocate_lecturer.php")'>Allocate Lecturer</a>
            <a href='#' onclick='loadContent("allocate_lesson.php")'>Allocate Lesson</a>
            <a href='#' onclick='loadContent("monitor_class_attendance.php")'>Monitor Lesson Attendance</a>
            <a href='#' onclick='loadContent("manage_user.php")'>Manage User</a>
            <a href='#' onclick='loadContent("send_message.php")'>Send Message</a>
            <a href='#' onclick='loadContent("generate_timetable.php")'>Generate Timetable</a>
            
        <?php } elseif ($user_role === 'HOD') { ?>
            <a href='#' onclick='loadContent("allocate_lesson.php")'>Allocate Lesson</a>
            <a href='#' onclick='loadContent("monitor_class_attendance.php")'>Monitor Lesson Attendance</a>
            <a href='#' onclick='loadContent("generate_timetable.php")'>Generate Timetable</a>
            <a href='#' onclick='loadContent("view_staff.php")'>View Staff</a>
            <a href='#' onclick='loadContent("send_message.php")'>Send Message</a>
            <a href='#' onclick='loadContent("add_ClassRep.php")'>Add New Class Representative</a>

        <?php } elseif ($user_role === 'Lecturer') { ?>
            <a href='#' onclick='loadContent("view_lessons.php")'>View Lessons</a>
            <a href='#' onclick='loadContent("generate_lesson_plans.php")'>Generate Lesson Plans</a>
            <a href='#' onclick='loadContent("send_message.php")'>Send Message</a>

        <?php } elseif ($user_role === 'Class Representative') { ?>
            <a href='#' onclick='loadContent("generate_timetable.php")'>Generate Timetable</a>
            <a href='#' onclick='loadContent("mark_lesson_attendance.php")'>Mark Lesson Attendance</a>
        <?php } ?>
    </div>
</div>
