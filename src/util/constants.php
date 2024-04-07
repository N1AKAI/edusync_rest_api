<?php

use Dotenv\Dotenv;

$dotenv = Dotenv::createUnsafeImmutable(__DIR__ . '/../../');
$dotenv->safeLoad();

// Database
define('DB_HOST', getenv('DB_HOST'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASS', getenv('DB_PASS'));
define('DB_NAME', getenv('DB_NAME'));

// Mail
define('MAIL_HOST', getenv('MAIL_HOST'));
define('MAIL_USER', getenv('MAIL_USER'));
define('MAIL_PASS', getenv('MAIL_PASS'));
define("MAIL_NAME", getenv('MAIL_NAME'));

// JWT Secret Key
define('SECRET_KEY', getenv('SECRET_KEY'));

// Teacher
define('TEACHER_CREATED', 101);
define('TEACHER_EXIST', 102);
define('TEACHER_FAILUARE', 103);
define('TEACHER_AUTHENTICATED', 201);
define('TEACHER_NOT_FOUND', 202);
define('TEACHER_PASSWORD_DO_NOT_MATCH', 203);
define('PASSWORD_CHANGED', 301);
define('PASSWORD_DO_NOT_MATCH', 302);
define('PASSWORD_NOT_CHANGED', 303);

// Student
define('STUDENT_CREATED', 404);
define('STUDENT_EXIST', 402);
define('STUDENT_FAILUARE', 403);
define('STUDENT_AUTHENTICATED', 501);
define('STUDENT_NOT_FOUND', 502);
define('STUDENT_PASSWORD_DO_NOT_MATCH', 503);

// Course
define('COURSE_CREATED', 601);
define('COURSE_FAILUARE', 602);

// Test
define('TEST_CREATED', 701);
define('TEST_EXIST', 702);
define('TEST_FAILURE', 703);

// Answer
define('ANSWER_CREATED', 801);
define('ANSWER_FAILURE', 802);

// Attendance
define('ATTENDANCE_CREATED', 901);
define('ATTENDANCE_FAILURE', 902);

// Class
define('CLASS_CREATED', 101);
define('CLASS_FAILURE', 102);

// Class_Cours
define('CLASS_COURSE_CREATED', 201);
define('CLASS_COURSE_FAILURE', 202);

// Class_Student
define('CLASS_STUDENT_CREATED', 301);
define('CLASS_STUDENT_FAILURE', 302);

// Fee
define('FEE_CREATED', 401);
define('FEE_FAILURE', 402);

// Holiday
define('HOLIDAY_CREATED', 501);
define('HOLIDAY_FAILURE', 502);

// Report Card
define('REPORT_CARD_CREATED', 501);
define('REPORT_CARD_FAILURE', 502);
