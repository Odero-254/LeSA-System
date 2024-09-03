-- Create users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone_number VARCHAR(20),
    role ENUM('Principal', 'Deputy Principal', 'HOD', 'Lecturer', 'Class Representative') NOT NULL,
    password VARCHAR(255) NOT NULL, -- Storing plain text password
    first_login BOOLEAN DEFAULT TRUE,
    last_login DATETIME
);

INSERT INTO users (username, email, phone_number, role, password, first_login) VALUES
('ben.odero', 'ben.odero@gmail.com', '+254-728-005-323', 'Principal', 'plainpass123', TRUE); 

-- Create lecturers table
CREATE TABLE lecturers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    qualifications TEXT NOT NULL
);

-- Create subjects table
CREATE TABLE subjects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    required_qualification TEXT NOT NULL
);

-- Create department table
CREATE TABLE department (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

-- Insert predefined department names
INSERT INTO department (name) VALUES 
('Administration'),
('ICT'), 
('Electrical and Electronic'), 
('Automotive'), 
('Mechanical'), 
('Building Technology'), 
('Aviation');

-- Create courses table
CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    department_id INT NOT NULL,
    FOREIGN KEY (department_id) REFERENCES department(id)
);

-- Insert predefined courses linked to their departments
INSERT INTO courses (name, department_id) VALUES
('ICT', (SELECT id FROM department WHERE name='ICT')),
('CS', (SELECT id FROM department WHERE name='ICT')),
('Power Option', (SELECT id FROM department WHERE name='Electrical and Electronic')),
('Instrumentation Option', (SELECT id FROM department WHERE name='Electrical and Electronic')),
('Telecommunication Option', (SELECT id FROM department WHERE name='Electrical and Electronic')),
('Automotive', (SELECT id FROM department WHERE name='Automotive')),
('Construction Plant', (SELECT id FROM department WHERE name='Mechanical')),
('Industrial Plant', (SELECT id FROM department WHERE name='Mechanical')),
('Welding and Fabrication', (SELECT id FROM department WHERE name='Mechanical')),
('B.Tech', (SELECT id FROM department WHERE name='Building Technology')),
('Civil Engineering', (SELECT id FROM department WHERE name='Building Technology')),
('Avionics', (SELECT id FROM department WHERE name='Aviation'));

-- Create levels table
CREATE TABLE levels (
    id INT AUTO_INCREMENT PRIMARY KEY,
    level_number INT NOT NULL
);

-- Insert predefined levels
INSERT INTO levels (level_number) VALUES 
(1), (2), (3);

-- Create classes table
CREATE TABLE classes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT NOT NULL,
    level_id INT NOT NULL,
    FOREIGN KEY (course_id) REFERENCES courses(id),
    FOREIGN KEY (level_id) REFERENCES levels(id)
);

-- Insert predefined classes
INSERT INTO classes (course_id, level_id) VALUES
-- ICT and CS classes
((SELECT id FROM courses WHERE name='ICT'), 1),
((SELECT id FROM courses WHERE name='ICT'), 2),
((SELECT id FROM courses WHERE name='ICT'), 3),
((SELECT id FROM courses WHERE name='CS'), 1),
((SELECT id FROM courses WHERE name='CS'), 2),
((SELECT id FROM courses WHERE name='CS'), 3),
-- Electrical and Electronic classes
((SELECT id FROM courses WHERE name='Power Option'), 1),
((SELECT id FROM courses WHERE name='Power Option'), 2),
((SELECT id FROM courses WHERE name='Power Option'), 3),
((SELECT id FROM courses WHERE name='Instrumentation Option'), 1),
((SELECT id FROM courses WHERE name='Instrumentation Option'), 2),
((SELECT id FROM courses WHERE name='Instrumentation Option'), 3),
((SELECT id FROM courses WHERE name='Telecommunication Option'), 1),
((SELECT id FROM courses WHERE name='Telecommunication Option'), 2),
((SELECT id FROM courses WHERE name='Telecommunication Option'), 3),
-- Automotive classes
((SELECT id FROM courses WHERE name='Automotive'), 1),
((SELECT id FROM courses WHERE name='Automotive'), 2),
((SELECT id FROM courses WHERE name='Automotive'), 3),
-- Mechanical classes
((SELECT id FROM courses WHERE name='Construction Plant'), 1),
((SELECT id FROM courses WHERE name='Construction Plant'), 2),
((SELECT id FROM courses WHERE name='Construction Plant'), 3),
((SELECT id FROM courses WHERE name='Industrial Plant'), 1),
((SELECT id FROM courses WHERE name='Industrial Plant'), 2),
((SELECT id FROM courses WHERE name='Industrial Plant'), 3),
((SELECT id FROM courses WHERE name='Welding and Fabrication'), 1),
((SELECT id FROM courses WHERE name='Welding and Fabrication'), 2),
((SELECT id FROM courses WHERE name='Welding and Fabrication'), 3),
-- Building Technology classes
((SELECT id FROM courses WHERE name='B.Tech'), 1),
((SELECT id FROM courses WHERE name='B.Tech'), 2),
((SELECT id FROM courses WHERE name='B.Tech'), 3),
((SELECT id FROM courses WHERE name='Civil Engineering'), 1),
((SELECT id FROM courses WHERE name='Civil Engineering'), 2),
((SELECT id FROM courses WHERE name='Civil Engineering'), 3),
-- Aviation classes
((SELECT id FROM courses WHERE name='Avionics'), 1),
((SELECT id FROM courses WHERE name='Avionics'), 2),
((SELECT id FROM courses WHERE name='Avionics'), 3);

-- Create allocations table
CREATE TABLE allocations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lecturer_id INT,
    subject_id INT,
    class_id INT,
    day VARCHAR(10) NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    FOREIGN KEY (lecturer_id) REFERENCES lecturers(id),
    FOREIGN KEY (subject_id) REFERENCES subjects(id),
    FOREIGN KEY (class_id) REFERENCES classes(id),
    UNIQUE (lecturer_id, day, start_time)
);
