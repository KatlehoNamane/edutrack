<!-- <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Ultimate School Report Generator</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #eef2f7;
      margin: 0;
      padding: 40px;
    }
    h1 {
      text-align: center;
      color: #333;
    }
    .container {
      background: white;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 6px 18px rgba(0,0,0,0.1);
      max-width: 600px;
      margin: 20px auto;
    }
    .input-group {
      margin-bottom: 15px;
      width:100%

    }
    label {
      font-weight: bold;
      display: block;
      margin-bottom: 5px;
    }
    input[type="text"], select {
      width: 90%;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
    .subjects {
      margin-top: 10px;
    }
    .subject-row {
      display: flex;
      gap: 10px;
      margin-bottom: 10px;
    }
    .subject-row input {
      flex: 1;
    }
    button {
    background-color:rgba(250, 118, 23, .9);
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      margin-right: 10px;
      margin-top: 10px;
    }
    button:hover {
      background: #0056b3;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    table, th, td {
      border: 1px solid #ddd;
    }
    th, td {
      padding: 8px;
      text-align: center;
    }
    th {
      background-color: #007bff;
      color: white;
    }
  </style>
</head>
<body>

<h1>Ultimate School Report Generator</h1>

<div class="container">
  <div class="input-group">
    <label>Student Name</label>
    <input type="text" id="studentName">
  </div>

  <div class="input-group">
    <label>Gender</label>
    <select id="studentGender">
      <option value="">Select Gender</option>
      <option value="Male">Male</option>
      <option value="Female">Female</option>
    </select>
  </div>

  <div class="input-group">
    <label>Class Name</label>
    <input type="text" id="className" placeholder="e.g., Grade 6">
  </div>

  <div id="subjectsContainer">
    <label>Subjects & Marks</label>
    <div class="subject-row">
      <input type="text" placeholder="Subject Name" class="subject">
      <input type="text" placeholder="Mark" class="mark">
    </div>
  </div>

  <button onclick="addSubject()">+ Add Subject</button>
  <button onclick="saveStudent()">Save Student</button>
  <button onclick="generateReports()">Generate Reports</button>

  <div id="reportSection" style="display:none;">
    <h2>Report Preview</h2>
    <div id="reports"></div>
  </div>
</div>

<script>
  let students = [];

  function addSubject() {
    const container = document.getElementById('subjectsContainer');
    const div = document.createElement('div');
    div.className = 'subject-row';
    div.innerHTML = `
      <input type="text" placeholder="Subject Name" class="subject">
      <input type="text" placeholder="Mark" class="mark">
    `;
    container.appendChild(div);
  }

  function gradeFromMark(mark) {
    if (mark >= 90) return 'A*';
    if (mark >= 80) return 'A';
    if (mark >= 70) return 'B';
    if (mark >= 60) return 'C';
    if (mark >= 50) return 'D';
    if (mark >= 40) return 'E';
    if (mark >= 30) return 'F';
    if (mark >= 20) return 'G';
    return 'U';
  }

  function remarkFromAverage(avg) {
    if (avg >= 90) return 'Outstanding Performance';
    if (avg >= 80) return 'Very Good';
    if (avg >= 70) return 'Good Effort';
    if (avg >= 60) return 'Satisfactory';
    if (avg >= 50) return 'Needs Improvement';
    return 'Serious Attention Needed';
  }

  function saveStudent() {
    const name = document.getElementById('studentName').value.trim();
    const gender = document.getElementById('studentGender').value;
    const className = document.getElementById('className').value.trim();
    const subjectInputs = document.querySelectorAll('.subject');
    const markInputs = document.querySelectorAll('.mark');

    if (!name || !gender || !className) {
      alert('Please fill in all required fields.');
      return;
    }

    const subjects = [];
    let totalMarks = 0;
    for (let i = 0; i < subjectInputs.length; i++) {
      const subject = subjectInputs[i].value.trim();
      const mark = parseFloat(markInputs[i].value.trim());
      if (subject && !isNaN(mark)) {
        subjects.push({
          subject,
          mark,
          grade: gradeFromMark(mark)
        });
        totalMarks += mark;
      }
    }

    if (subjects.length === 0) {
      alert('Please enter at least one subject and mark.');
      return;
    }

    const average = totalMarks / subjects.length;
    const remark = remarkFromAverage(average);

    students.push({ name, gender, className, subjects, totalMarks, average, remark });

    // Reset form
    document.getElementById('studentName').value = '';
    document.getElementById('studentGender').value = '';
    document.getElementById('className').value = '';
    document.getElementById('subjectsContainer').innerHTML = `
      <label>Subjects & Marks</label>
      <div class="subject-row">
        <input type="text" placeholder="Subject Name" class="subject">
        <input type="text" placeholder="Mark" class="mark">
      </div>
    `;

    alert('Student saved successfully! ✅');
  }

  function generateReports() {
    students.sort((a, b) => b.average - a.average); // Sort by average descending

    // Assign positions
    students.forEach((student, index) => {
      student.position = index + 1;
    });

    const container = document.getElementById('reports');
    container.innerHTML = '';

    students.forEach(student => {
      let report = `<h3>${student.name} (${student.gender}) - ${student.className}</h3>`;
      report += `<p><strong>Average:</strong> ${student.average.toFixed(2)}% | <strong>Position:</strong> ${student.position} | <strong>Remark:</strong> ${student.remark}</p>`;
      report += `<table><tr><th>Subject</th><th>Mark</th><th>Grade</th></tr>`;

      student.subjects.forEach(sub => {
        report += `<tr><td>${sub.subject}</td><td>${sub.mark}</td><td>${sub.grade}</td></tr>`;
      });

      report += `</table><hr>`;
      container.innerHTML += report;
    });

    document.getElementById('reportSection').style.display = 'block';
  }
</script>

</body>
</html> -->

<?php
// Receive student info (GET method from previous page)
$student_id = $_GET['student_id'] ?? '';
$first_name = $_GET['first_name'] ?? '';
$last_name = $_GET['last_name'] ?? '';
$student_number = $_GET['student_number'] ?? '';
$school_name = $_GET['school_name'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create Student Report</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6">

  <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-2xl">
    <h1 class="text-2xl font-bold mb-6">Create Report for <?= htmlspecialchars($first_name . ' ' . $last_name) ?></h1>

    <form action="save_report.php" method="POST" class="space-y-4">

      <!-- Hidden fields to carry student identity -->
      <input type="hidden" name="student_id" value="<?= htmlspecialchars($student_id) ?>">
      <input type="hidden" name="first_name" value="<?= htmlspecialchars($first_name) ?>">
      <input type="hidden" name="last_name" value="<?= htmlspecialchars($last_name) ?>">

      <div>
        <label class="block font-semibold mb-1">Student Number</label>
        <input type="text" name="student_number" value="<?= htmlspecialchars($student_number) ?>"
               class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" readonly>
      </div>

      <div>
        <label class="block font-semibold mb-1">School Name</label>
        <input type="text" name="school_name" value="<?= htmlspecialchars($school_name) ?>"
               class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" readonly>
      </div>

      <div>
        <label class="block font-semibold mb-1">Report Title</label>
        <input type="text" name="report_title" required
               class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
      </div>

      <div>
        <label class="block font-semibold mb-1">Report Details</label>
        <textarea name="report_details" rows="6" required
                  class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200"></textarea>
      </div>

      <div class="flex justify-end">
        <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md font-semibold">
          Save Report
        </button>
      </div>

    </form>
  </div>

</body>
</html>

