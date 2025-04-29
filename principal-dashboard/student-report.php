<?php
session_start();

// Only students and principals may access
if (!isset($_SESSION['user_id'], $_SESSION['role'])
    || !in_array($_SESSION['role'], ['STUDENT','PRINCIPAL'])) {
    http_response_code(403);
    exit('Access denied.');
}

$servername = "localhost";
$username   = "root";
$password   = "";
$database   = "edutrack_lesotho";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . htmlspecialchars($conn->connect_error));
}

// Determine which student to show
if ($_SESSION['role'] === 'STUDENT') {
    $student_id = $conn->real_escape_string($_SESSION['user_id']);
} else {
    // PRINCIPAL must supply student_id
    if (empty($_GET['student_id'])) {
        exit('Please provide a student_id in the query string.');
    }
    $student_id = $conn->real_escape_string($_GET['student_id']);
}

// Term and year filter (optional GET parameters)
$term = 'All Terms';
$year = isset($_GET['year'])
    ? (int)$_GET['year']
    : (int)date('Y');

// Helper to get grade symbol
function getGradeSymbol(int $score): string {
    if ($score >= 90) return 'A+';
    if ($score >= 80) return 'A';
    if ($score >= 70) return 'B';
    if ($score >= 60) return 'C';
    if ($score >= 40) return 'D';
    if ($score >= 30) return 'E';
    if ($score >= 20) return 'F';
    return 'F';
}

// Fetch student info
$sql = "SELECT first_name, last_name, school_name FROM users WHERE id = '$student_id' AND role = 'STUDENT'";
$res = $conn->query($sql);
if (!$res || $res->num_rows === 0) {
    exit('Student not found.');
}
$student = $res->fetch_assoc();
$school_name = $conn->real_escape_string($student['school_name']);

// Fetch all subjects for that school
$sql = "SELECT subject FROM school_subjects WHERE school_name = '$school_name'";
$subsRes = $conn->query($sql);

$marks        = [];
$totalMarks   = 0;
$subjectCount = 0;

if ($subsRes && $subsRes->num_rows > 0) {
    while ($row = $subsRes->fetch_assoc()) {
        $subject = $conn->real_escape_string($row['subject']);
        
        // Get the latest mark for this student+subject per term/year
        $filterTerm = $term !== 'All Terms'
            ? "AND term = '$term'"
            : '';
        $filterYear = "AND year = '$year'";
        $q2 = "SELECT mark, term
               FROM subject_marks
               WHERE student_id = '$student_id'
                 AND subject_name = '$subject'
                 $filterYear
               ORDER BY created_at DESC
               LIMIT 1";
        $mRes = $conn->query($q2);
        if ($mRes && $mRes->num_rows === 1) {
          // echo print_r($mRes->fetch_assoc());
          $result = $mRes->fetch_assoc();
            $mark = (int)$result['mark'];
            $term = $result['term'];
        } else {
            $mark = 0;
        }
        $symbol = getGradeSymbol($mark);

        $marks[] = [
            'subject' => $subject,
            'mark'    => $mark,
            'symbol'  => $symbol
        ];
        $totalMarks   += $mark;
        $subjectCount++;
    }
} else {
    exit('No subjects defined for your school yet.');
}

// Compute average
$avg = $subjectCount ? $totalMarks / $subjectCount : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Report: <?= htmlspecialchars("{$student['first_name']} {$student['last_name']}") ?></title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6">
  <div class="w-full max-w-4xl bg-white shadow-lg rounded-2xl overflow-hidden">
    <!-- Header -->
    <div class="bg-green-500 text-white p-6">
      <h1 class="text-3xl font-semibold">Student Report</h1>
      <p class="mt-1">Name: <?= htmlspecialchars("{$student['first_name']} {$student['last_name']}") ?> | School: <?= htmlspecialchars($school_name) ?></p>
      <p class="mt-1">Term: <span class="font-medium"><?= htmlspecialchars($term) ?></span> | Year: <span class="font-medium"><?= $year ?></span></p>
      <p class="mt-1">Total Subjects: <span class="font-semibold"><?= $subjectCount ?></span></p>
    </div>

    <!-- Table -->
    <div class="p-6">
      <table class="w-full table-auto border-collapse">
        <thead>
          <tr class="bg-gray-200">
            <th class="px-4 py-2 text-left uppercase text-sm">Subject</th>
            <th class="px-4 py-2 text-center uppercase text-sm">Mark (%)</th>
            <th class="px-4 py-2 text-center uppercase text-sm">Grade</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($marks as $row): ?>
          <tr class="odd:bg-white even:bg-gray-50 hover:bg-blue-50">
            <td class="border-t px-4 py-3"><?= htmlspecialchars($row['subject']) ?></td>
            <td class="border-t px-4 py-3 text-center"><?= $row['mark'] ?>%</td>
            <td class="border-t px-4 py-3 text-center">
              <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                <?= $row['symbol'] ?>
              </span>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <!-- Summary -->
      <div class="mt-6 flex justify-end items-center">
        <div class="text-right">
          <p class="text-lg font-medium">Average Mark: <span class="text-blue-600"><?= number_format($avg,2) ?>%</span></p>
          <?php $overallGrade = getGradeSymbol((int)round($avg)); ?>
          <p class="mt-1">Overall Grade: 
            <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">
              <?= $overallGrade ?>
            </span>
          </p>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
