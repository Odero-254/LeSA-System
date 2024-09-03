<?php
// Fetch the user role from the database
$user_role = '';
$dashboard_url = 'home.php'; 
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query = mysqli_query($conn, "SELECT user_role FROM users WHERE id='$user_id'");
    if ($row = mysqli_fetch_array($query)) {
        $user_role = $row['user_role'];
        switch ($user_role) {
            case 'Principal':
            case 'Deputy Principal':
                $dashboard_url = 'dashboard_admin.php';
                break;
            case 'Class Representative':
                $dashboard_url = 'dashboard_cRep.php';
                break;
            case 'Lecturer':
                $dashboard_url = 'dashboard_lecturer.php';
                break;
            case 'HOD':
                $dashboard_url = 'dashboard_hod.php';
                break;
            
        }
    }
}
?>
<nav class="hk-nav hk-nav-light">
    <a href="javascript:void(0);" id="hk_nav_close" class="hk-nav-close"><span class="feather-icon"><i data-feather="x"></i></span></a>
    <div class="nicescroll-bar">
        <div class="navbar-nav-wrap">
            <ul class="navbar-nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $dashboard_url; ?>">
                        <i class="ion ion-ios-keypad"></i>
                        <span class="nav-link-text">Dashboard</span>
                    </a>
                </li>

                <?php if ($user_role === 'Principal' || $user_role === 'Deputy Principal') { ?>

                    <li class="nav-item">
                         <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#user_drp">
                            <i class="zmdi zmdi-account"></i>
                            <span class="nav-link-text">User</span>
                        </a>
                        <ul id="user_drp" class="nav flex-column collapse collapse-level-1">
                            <li class="nav-item">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="add_user.php">Add User</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="manage-users.php">Manage User</a>
                                    </li>
                            
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="view_students_admin.php">
                            <i class="ion ion-ios-people"></i>
                            <span class="nav-link-text">Students</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#class_drp">
                            <i class="ion ion-ios-home"></i>
                            <span class="nav-link-text">Class</span>
                        </a>
                        <ul id="class_drp" class="nav flex-column collapse collapse-level-1">
                            <li class="nav-item">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="add_class.php">Add</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="manage_classes.php">Manage</a>
                                     </li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#course_drp">
                            <i class="ion ion-ios-copy"></i>
                            <span class="nav-link-text">Course</span>
                        </a>
                        <ul id="course_drp" class="nav flex-column collapse collapse-level-1">
                            <li class="nav-item">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="add_course.php">Add</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="manage_courses.php">Manage</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#subj_drp">
                            <i class="ion ion-ios-book"></i>
                            <span class="nav-link-text">Subject</span>
                        </a>
                        <ul id="subj_drp" class="nav flex-column collapse collapse-level-1">
                            <li class="nav-item">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="add_subject.php">Add</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="manage_subject.php">Manage</a>
                                    </li>
                                </li>
                            </ul>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#msg_drp">
                            <i class="ion ion-ios-text"></i>
                            <span class="nav-link-text">Messages</span>
                        </a>
                        <ul id="msg_drp" class="nav flex-column collapse collapse-level-1">
                            <li class="nav-item">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="send_message.php">Send message</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="unread_message.php">unread messages</a>
                                    </li>
                                </ul>
                            </li>  
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#timetbl_drp">
                            <i class="ion ion-ios-list-box"></i>
                            <span class="nav-link-text">Timetable</span>
                        </a>
                        <ul id="timetbl_drp" class="nav flex-column collapse collapse-level-1">
                            <li class="nav-item">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="department_timetable.php">Department timetable</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="class_timetable.php">class timetable</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                         <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#report_drp">
                            <i class="ion ion-ios-print"></i>
                            <span class="nav-link-text">Reports</span>
                        </a>
                        <ul id="report_drp" class="nav flex-column collapse collapse-level-1">
                            <li class="nav-item">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="missed_lessons.php">Missed Lessons</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="student_absence.php">Absent Students</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="rescheduled_lessons.php">rescheduled lessons</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" href="set_term_dates.php">
                            <i class="ion ion-ios-calendar"></i>
                            <span class="nav-link-text">Academic Calendar</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="account-request.php">
                            <i class="ion ion-ios-alert"></i>
                            <span class="nav-link-text">Requests</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="search.php">
                            <i class="glyphicon glyphicon-search"></i>
                            <span class="nav-link-text">Search</span>
                        </a>
                     </li>

                    <!-- More items for Principal or Deputy Principal -->

                <?php } elseif ($user_role === 'HOD') { ?>

                    <li class="nav-item">
                         <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#classRep_drp">
                            <i class="zmdi zmdi-account"></i>
                            <span class="nav-link-text">Class Representative</span>
                        </a>
                        <ul id="classRep_drp" class="nav flex-column collapse collapse-level-1">
                            <li class="nav-item">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="add_classRep.php">Add Class Rep</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="manage_classRep.php">Manage Class Reps</a>
                                    </li>
                            
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                         <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#allocation_drp">
                            <i class="ion ion-ios-at"></i>
                            <span class="nav-link-text">Lesson Allocation</span>
                        </a>
                        <ul id="allocation_drp" class="nav flex-column collapse collapse-level-1">
                            <li class="nav-item">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="allocation.html">Allocate Lessons</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="manage_allocations.php">Manage Allocations</a>
                                    </li>
                            
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                         <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#students_drp">
                            <i class="ion ion-ios-people"></i>
                            <span class="nav-link-text">Students</span>
                        </a>
                        <ul id="students_drp" class="nav flex-column collapse collapse-level-1">
                            <li class="nav-item">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="add_student.php">Add Student</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="manage_students.php">Manage Student</a>
                                    </li>
                            
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                         <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#msg_drp">
                            <i class="ion ion-ios-text"></i>
                            <span class="nav-link-text">Message</span>
                        </a>
                        <ul id="msg_drp" class="nav flex-column collapse collapse-level-1">
                            <li class="nav-item">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="send_message.php">send message</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="unread_message.php">unread message</a>
                                    </li>
                            
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                         <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#timetbl_drp">
                            <i class="ion ion-ios-list-box"></i>
                            <span class="nav-link-text">Timetable</span>
                        </a>
                        <ul id="timetbl_drp" class="nav flex-column collapse collapse-level-1">
                            <li class="nav-item">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="department_timetbl.php">Department timetable</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="class_timetbl.php">Class timetable</a>
                                    </li>
                            
                                </ul>
                            </li>
                        </ul>
                    </li>


                    <li class="nav-item">
                         <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#report_drp">
                            <i class="ion ion-ios-print"></i>
                            <span class="nav-link-text">Reports</span>
                        </a>
                        <ul id="report_drp" class="nav flex-column collapse collapse-level-1">
                            <li class="nav-item">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="missed_lessons.php">Missed Lessons</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="absent_students.php">Absent Students</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="taught_lessons.php">Taught Lessons</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="rescheduled_lessons.php">rescheduled lessons</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="reports/report_classRep.php">Class Representatives</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="view_lecturers.php">
                            <i class="ion ion-ios-people"></i>
                            <span class="nav-link-text">Lecturers</span>
                        </a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" href="request.php">
                            <i class="ion ion-ios-alert"></i>
                            <span class="nav-link-text">Requests</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="search.php">
                            <i class="glyphicon glyphicon-search"></i>
                            <span class="nav-link-text">Search</span>
                        </a>
                     </li>


                    <!-- More items for HOD -->

                <?php } elseif ($user_role === 'Lecturer') { ?>

                    <li class="nav-item">
                        <a class="nav-link" href="my_students.php">
                            <i class="ion ion-ios-people"></i>
                            <span class="nav-link-text">Students</span>
                        </a>
                    </li>

                    
                    <li class="nav-item">
                         <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#assign_drp">
                            <i class="ion ion-ios-copy"></i>
                            <span class="nav-link-text">Assignment</span>
                        </a>
                        <ul id="assign_drp" class="nav flex-column collapse collapse-level-1">
                            <li class="nav-item">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="create_assignment.php">Create</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="view_assignments.php">View</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="grade_assignment.php">Grade</a>
                                    </li>
                            
                                </ul>
                            </li>
                        </ul>
                    </li>
                    

                    <li class="nav-item">
                         <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#sub_drp">
                            <i class="ion ion-ios-book"></i>
                            <span class="nav-link-text">Subject</span>
                        </a>
                        <ul id="sub_drp" class="nav flex-column collapse collapse-level-1">
                            <li class="nav-item">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="qualified_subject.php">Qualified</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="view_lessons.php">Allocated</a>
                                    </li>
                            
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                         <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#msg_drp">
                            <i class="ion ion-ios-text"></i>
                            <span class="nav-link-text">Message</span>
                        </a>
                        <ul id="msg_drp" class="nav flex-column collapse collapse-level-1">
                            <li class="nav-item">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="send_message.php">send message</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="unread_message.php">unread message</a>
                                    </li>
                            
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                         <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#report_drp">
                            <i class="ion ion-ios-print"></i>
                            <span class="nav-link-text">Reports</span>
                        </a>
                        <ul id="report_drp" class="nav flex-column collapse collapse-level-1">
                            <li class="nav-item">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="missed_lessons.php">Missed Lessons</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="absent_students.php">Absent Students</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="taught_lessons.php">Attendend Lessons</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="rescheduled_lessons.php">rescheduled lessons</a>
                                    </li> 
                                    <li class="nav-item">
                                        <a class="nav-link" href="students_performance.php">student performance</a>
                                    </li> 
                                    
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="search.php">
                            <i class="glyphicon glyphicon-search"></i>
                            <span class="nav-link-text">Search</span>
                        </a>
                     </li>
                     <!-- Lecturers items ends here -->

                <?php } elseif ($user_role === 'Class Representative') { ?>

                    <li class="nav-item">
                        <a class="nav-link" href="track_attendance.php">
                            <i class="ion ion-ios-checkbox"></i>
                            <span class="nav-link-text">Lesson Attendance</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="review_reschedule.php">
                            <i class="ion ion-ios-copy"></i>
                            <span class="nav-link-text">Rechedule Requests</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="class_timetable.php">
                            <i class="ion ion-ios-list-box"></i>
                            <span class="nav-link-text">Class Timetable</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="view_students.php">
                            <i class="ion ion-ios-people"></i>
                            <span class="nav-link-text">Students</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#msg_drp">
                            <i class="ion ion-ios-text"></i>
                            <span class="nav-link-text">Message</span>
                        </a>
                        <ul id="msg_drp" class="nav flex-column collapse collapse-level-1">
                            <li class="nav-item">
                                <a class="nav-link" href="unread_message.php">Unread Messages</a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                         <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#report_drp">
                            <i class="ion ion-ios-print"></i>
                            <span class="nav-link-text">Reports</span>
                        </a>
                        <ul id="report_drp" class="nav flex-column collapse collapse-level-1">
                            <li class="nav-item">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="view_missed_lessons.php">Missed Lessons</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="view_absent_students.php">Absent Students</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="view_rescheduled_lessons.php">rescheduled lessons</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="view_lecturer_cRep.php">
                            <i class="ion ion-ios-people"></i>
                            <span class="nav-link-text">Allocated Lecturers</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="search.php">
                            <i class="glyphicon glyphicon-search"></i>
                            <span class="nav-link-text">Search</span>
                        </a>
                     </li>

                    <!-- Class Representative utems ends here-->

                <?php } ?>
            </ul>
            <hr class="nav-separator">
        </div>
    </div>
</nav>
