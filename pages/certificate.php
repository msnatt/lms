<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>ออก Certificate</title>
  <style>
    body {
      font-family: sans-serif;
      font-weight: 500;
    }
  </style>
</head>

<body>
  <?php include "../include/header.php"; ?>
  <div class="main-inner">
    <h2>ระบบออก Certificate</h2>
    <form action="../config/course-certificate.php" method="post">
      <label>เลือกเท็มเพลต:</label>
      <select name="template">
        <option value="cert01.png">Template 1</option>
      </select>

      <div class="px-4 d-flex justify-content-center">
        <div id="select-list" class="d-flex flex-wrap m-4 gap-2" style="width: 600px; min-height: 30px;"></div>
      </div>
      <div id="student_list" class="mt-3 d-flex flex-column align-items-center" style="min-height: 60vh;">
        <table id="table_list_student" style="max-width: 800px;">
          <thead>
            <tr>
              <th style="width: 40px !important;"></th>
              <th>code</th>
              <th>name</th>
              <th></th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div>

      <input type="submit" value="สร้าง Certificate">
    </form>
  </div>
</body>

</html>