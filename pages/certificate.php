<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>ออก Certificate</title>
  <style>
    body { font-family: sans-serif; padding: 30px; }
    label, select, input { display: block; margin: 15px 0; }
  </style>
</head>
<body>
  <h2>ระบบออก Certificate</h2>
  <form action="../config/course-certificate.php" method="post">
    <label>เลือกเท็มเพลต:</label>
    <select name="template">
      <option value="cert01.png">Template 1</option>
    </select>

    <label>ชื่อผู้รับ:</label>
    <select name="name">
      <option value="คุณสมชาย ใจดี">คุณสมชาย ใจดี</option>
      <option value="คุณสมหญิง สุขใจ">คุณสมหญิง สุขใจ</option>
      <option value="นายณัฐพล เก่งมาก">นายณัฐพล เก่งมาก</option>
    </select>

    <input type="submit" value="สร้าง Certificate">
  </form>
</body>
</html>
