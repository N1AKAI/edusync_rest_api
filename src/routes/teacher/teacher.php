<?php

use App\Common\JsonResponse;
use App\Lib\JWTAuth;
use App\Repository\AbsentStudentsRepository;
use App\Repository\AttendanceRepository;
use App\Repository\ClassRepository;
use App\Repository\ClassTeacherRepository;
use App\Repository\CourseRepository;
use App\Repository\HomeworkRepository;
use App\Repository\StudentRepository;
use App\Repository\TeacherRepository;
use App\Repository\TestRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->get("/teacher/show", function (Request $request, Response $response) {

  $token = str_replace("Bearer ", "", $request->getHeaderLine('Authorization'));
  $data = JWTAuth::getData($token);

  $repo = new TeacherRepository;
  $student = $repo->getTeacherAndTheirClassesByEmail($data->email);

  return JsonResponse::send($response, $student);
});

$app->get("/teacher/classes", function (Request $request, Response $response) {

  $token = str_replace("Bearer ", "", $request->getHeaderLine('Authorization'));
  $data = JWTAuth::getData($token);

  $repo = new ClassRepository;
  $classes = $repo->getTeachersClasses($data->id);

  return JsonResponse::send($response, $classes);
});

$app->get("/teacher/homeworks", function (Request $request, Response $response) {

  $token = str_replace("Bearer ", "", $request->getHeaderLine('Authorization'));
  $data = JWTAuth::getData($token);

  $repo = new HomeworkRepository;
  $homeworks = $repo->getTeachersHomeworks($data->id);

  return JsonResponse::send($response, $homeworks);
});

$app->get("/teacher/class/{classId}/homeworks/{homeworkId}", function (Request $request, Response $response, array $args) {

  $classId = $args['classId'];
  $homeworkId = $args['homeworkId'];

  $token = str_replace("Bearer ", "", $request->getHeaderLine('Authorization'));
  $data = JWTAuth::getData($token);

  $repo = new StudentRepository;
  $students = $repo->getAllClassStudentsHomework($classId, $homeworkId, $data->id);

  return JsonResponse::send($response, $students);
});

$app->post("/teacher/homeworks", function (Request $request, Response $response, array $args) {

  $token = str_replace("Bearer ", "", $request->getHeaderLine('Authorization'));
  $tokenData = JWTAuth::getData($token);

  $data = $request->getParsedBody();
  $data['teacher_id'] = $tokenData->id;

  $msg['error'] = true;
  $msg['message'] = "Something went wrong!";
  $status = 200;
  $repo = new HomeworkRepository;
  if ($repo->create($data)) {
    $msg['error'] = false;
    $msg['message'] = "Created successfully!";
    $status = 201;
  }

  return JsonResponse::send($response, $msg, $status);
});

$app->get("/teacher/class/{classId}/course", function (Request $request, Response $response, array $args) {

  $token = str_replace("Bearer ", "", $request->getHeaderLine('Authorization'));
  $data = JWTAuth::getData($token);

  $classId = $args['classId'];

  $repo = new ClassTeacherRepository;
  $courses = $repo->getCourseByClassId($classId, $data->id);

  return JsonResponse::send($response, $courses);
});

$app->get("/teacher/class/{classId}/students", function (Request $request, Response $response, array $args) {

  $classId = $args['classId'];

  $repo = new StudentRepository;
  $student = $repo->getClassStudents($classId);

  return JsonResponse::send($response, $student);
});

$app->post("/teacher/absent", function (Request $request, Response $response, array $args) {

  $token = str_replace("Bearer ", "", $request->getHeaderLine('Authorization'));
  $tokenData = JWTAuth::getData($token);

  $allData = $request->getParsedBody();

  $repo = new AbsentStudentsRepository;

  $msg = [];
  $status = 200;

  foreach ($allData as $data) {
    $data['teacher_id'] = $tokenData->id;
    $msg['error'] = true;
    $msg['message'] = "Failed!";
    $status = 422;

    if ($repo->registerAttendance($data)) {
      $msg['error'] = false;
      $msg['message'] = "Absents registered successfully!";
      $status = 201;
    }
  }

  return JsonResponse::send($response, $msg, $status);
});

$app->get("/teacher/courses", function (Request $request, Response $response, array $args) {

  $token = str_replace("Bearer ", "", $request->getHeaderLine('Authorization'));
  $data = JWTAuth::getData($token);

  $repo = new CourseRepository;
  $courses = $repo->getTeacherCourses($data->id);

  return JsonResponse::send($response, $courses);
});

$app->post("/teacher/tests", function (Request $request, Response $response, array $args) {

  $body = $request->getParsedBody();

  $repo = new TestRepository;

  $msg['error'] = true;
  $msg['message'] = "Something went wrong!";
  $status = 422;

  foreach ($body as $test) {
    if ($repo->create($test)) {
      $msg['error'] = false;
      $msg['message'] = "Test marks added successfully";
      $status = 201;
    }
  }

  return JsonResponse::send($response, $msg, $status);
});

$app->post("/teacher/tests/update", function (Request $request, Response $response, array $args) {
  $body = $request->getParsedBody();

  $repo = new TestRepository;

  $msg['error'] = true;
  $msg['message'] = "Something went wrong!";
  $status = 422;

  print_r($body);

  foreach ($body as $id => $test) {
    if ($repo->update($id, $test)) {
      $msg['error'] = false;
      $msg['message'] = "Test marks updated successfully";
      $status = 201;
    }
  }
  return JsonResponse::send($response, $msg, $status);
});

$app->put("/teacher/testnum/{classId}/{courseId}", function (Request $request, Response $response, array $args) {

  $msg['error'] = true;
  $msg['message'] = 'Something went wrong!';
  $status = 422;

  $token = str_replace("Bearer ", "", $request->getHeaderLine('Authorization'));
  $data = JWTAuth::getData($token);

  $classId = $args['classId'];
  $courseId = $args['courseId'];

  $body = $request->getParsedBody();

  $repo = new ClassTeacherRepository;
  $bol = $repo->addTestNumber($classId, $courseId, $data->id, $body['num_test']);
  if ($bol) {
    $msg['error'] = false;
    $msg['message'] = 'Updated successfully!';
    $status = 200;
  }
  return JsonResponse::send($response, $msg, $status);
});

$app->get("/teacher/tests/course/{courseId}/class/{classId}", function (Request $request, Response $response, array $args) {

  $courseId = $args['courseId'];
  $classId = $args['classId'];

  $repo = new TestRepository;
  $marks = $repo->getClassMarks([$courseId, $classId]);

  return JsonResponse::send($response, $marks);
});
