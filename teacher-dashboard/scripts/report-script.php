<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Exceptional School Report Generator</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      margin: 40px;
      background: #f0f2f5;
    }
    h1 {
      text-align: center;
      color: #333;
    }
    .form-container, .report-container {
      background: white;
      padding: 20px;
      margin-top: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .input-group {
      margin-bottom: 15px;
    }
    label {
      font-weight: bold;
      display: block;
      margin-bottom: 5px;
    }
    input[type="text"] {
      width: 100%;
      padding: 8px;
      margin-bottom: 5px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    .subjects {
      margin-bottom: 15px;
    }
    button {
      background: #007bff;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
      margin-right: 10px;
      margin-top: 10px;
    }
    button:hover {
      background: #0056b3;
    }
    .student-entry {
      border-bottom: 1px solid #eee;
      margin-bottom: 20px;
      padding-bottom: 20px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }
    table th, table td {
      border: 1px solid #ddd;
      padding: 8px;
    }
    table th {
      background-color: #007bff;
      color: white;
    }
  </style>
</head>
<body>

  <h1>Exceptional School Report Generator</h1>

  <div class="form-container">
    <div class="input-group">
      <label for="studentName">Student Name</label>
      <input type="text" id="studentName" placeholder="Enter student name">
    </div>

    <div id="subjectsContainer" class="subjects">
      <label>Subjects & Grades</label>
      <div class="subject-row">
        <input type="text" placeholder="Subject" class="subject">
        <input type="text" placeholder="Grade" class="grade">
      </div>
    </div>

    <button onclick="addSubject()">+ Add Subject</button>
    <button onclick="saveStudent()">Save Student</button>
    <button onclick="generateAllReports()">Generate All Reports</button>
  </div>

  <div class="report-container" id="reportContainer" style="display:none;">
    <h2>Reports Preview</h2>
    <div id="allReports"></div>
    <button onclick="downloadAllPDF()">Download All Reports as PDF</button>
  </div>

<script>
  let students = [];

  function addSubject() {
    const container = document.getElementById('subjectsContainer');
    const div = document.createElement('div');
    div.className = 'subject-row';
    div.innerHTML = `
      <input type="text" placeholder="Subject" class="subject">
      <input type="text" placeholder="Grade" class="grade">
    `;
    container.appendChild(div);
  }

  function saveStudent() {
    const name = document.getElementById('studentName').value.trim();
    const subjects = Array.from(document.querySelectorAll('.subject'));
    const grades = Array.from(document.querySelectorAll('.grade'));

    if (!name) {
      alert('Please enter the student\'s name.');
      return;
    }

    const studentSubjects = [];
    for (let i = 0; i < subjects.length; i++) {
      const subject = subjects[i].value.trim();
      const grade = grades[i].value.trim();
      if (subject && grade) {
        studentSubjects.push({ subject, grade });
      }
    }

    if (studentSubjects.length === 0) {
      alert('Please enter at least one subject and grade.');
      return;
    }

    students.push({ name, subjects: studentSubjects });

    // Reset form
    document.getElementById('studentName').value = '';
    document.getElementById('subjectsContainer').innerHTML = `
      <label>Subjects & Grades</label>
      <div class="subject-row">
        <input type="text" placeholder="Subject" class="subject">
        <input type="text" placeholder="Grade" class="grade">
      </div>
    `;

    alert('Student saved! You can add another one.');
  }

  function generateAllReports() {
    const container = document.getElementById('allReports');
    container.innerHTML = '';

    if (students.length === 0) {
      alert('No students added yet!');
      return;
    }

    students.forEach(student => {
      let reportHTML = `<div class="student-entry"><h3>${student.name}</h3><table>`;
      reportHTML += `<tr><th>Subject</th><th>Grade</th></tr>`;

      student.subjects.forEach(entry => {
        reportHTML += `<tr><td>${entry.subject}</td><td>${entry.grade}</td></tr>`;
      });

      reportHTML += `</table></div>`;

      container.innerHTML += reportHTML;
    });

    document.getElementById('reportContainer').style.display = 'block';
  }

  function downloadAllPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    if (students.length === 0) {
      alert('No students to download.');
      return;
    }

    students.forEach((student, index) => {
      if (index !== 0) {
        doc.addPage();
      }

      doc.setFontSize(16);
      doc.text(`School Report for ${student.name}`, 14, 20);

      const rows = student.subjects.map(entry => [entry.subject, entry.grade]);

      doc.autoTable({
        startY: 30,
        head: [['Subject', 'Grade']],
        body: rows,
        styles: { halign: 'center' },
        headStyles: { fillColor: [0, 123, 255] }
      });
    });

    doc.save('all_school_reports.pdf');
  }
</script>

</body>
</html>
