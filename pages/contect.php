<?php
include '../components/session.php';
checkLogin();
?>


<!DOCTYPE html>
<html lang="en">

<?php include "../include/ref.html"; ?>
<?php include "../include/style.html"; ?>

<body class="bg-custom ">
    <?php include "../include/header.php"; ?>
    <div class="d-flex" style="min-height: 70vh;">
        <?php include "../components/sidemenu.php"; ?>
        <div class="container box-shadow bg-light">
            <br>
            <div class="d-flex justify-content-center">
                <img src="../assets/images/1000x500.png" height="75%" width="75%">
            </div>

            <br>
            <br>
            <div class="d-flex justify-content-center">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                        <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6" />
                    </svg>
                </span>
                <h3> Contact US</h3>
            </div>
            <div class="container py-5">
                <div class="row">
                    <!-- Left Section -->
                    <div class="col-12 col-lg-6 mb-4">
                        <h3>Fieldtech Automation Company Limited.</h3>
                        <p>
                            <i class="bi bi-geo-alt-fill text-danger"></i>
                            <strong>Address</strong><br>
                            54/164 M. 13 Khlong Kum, Bueng Kum Bangkok Thailand 10240<br>
                            54/164 ม.13 แขวงคลองกุ่ม เขตบึงกุ่ม กรุงเทพมหานคร 10240
                        </p>
                        <p>
                            <i class="bi bi-telephone-fill text-primary"></i>
                            <strong>Telephone</strong><br>
                            02-936-8827-8, 081-255-7172, 063-952-4102
                        </p>
                        <p>
                            <i class="bi bi-printer-fill text-warning"></i>
                            <strong>Fax</strong><br>
                            02-936-8829
                        </p>
                        <p>
                            <i class="bi bi-envelope-fill text-success"></i>
                            <strong>E-mail</strong><br>
                            MD@ft-atm.com, napatchoong@ft-atm.com, sales1@ft-atm.com<br>
                            sales2@ft-atm.com, ftatm.edu1@gmail.com
                        </p>
                        <hr>
                        <!-- Google Map -->
                        <div>
                            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d683.1840037737155!2d100.66030889399215!3d13.810407595256011!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x311d63b49f0cc469%3A0x32cf30804f62df31!2z4Lia4Lij4Li04Lip4Lix4LiXIOC4n-C4tOC4peC4lOC5jOC5gOC4l-C4hCDguK3guK3guYLguJXguYDguKHguIrguLHguYjguJkg4LiI4Liz4LiB4Lix4LiU!5e1!3m2!1sen!2sth!4v1732522168307!5m2!1sen!2sth" width="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>

                    <!-- Right Section -->
                    <div class="col-12 col-lg-6">
                        <form>
                            <div class="mb-3">
                                <label for="subject" class="form-label">หัวเรื่อง</label>
                                <input type="text" class="form-control" name="subject" id="subject" placeholder="หัวเรื่อง">
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">ชื่อ-นามสกุล</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="ชื่อ-นามสกุล">
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">เบอร์โทร</label>
                                <input type="text" class="form-control" name="phone" id="phone" placeholder="เบอร์โทร">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">อีเมล์</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="อีเมล์">
                            </div>
                            <div class="mb-3">
                                <label for="details" class="form-label">รายละเอียด</label>
                                <textarea class="form-control" name="details" id="details" rows="5" placeholder="รายละเอียด"></textarea>
                            </div>
                            <!-- reCAPTCHA -->
                            <div class="mb-3">
                                <div class="g-recaptcha" data-sitekey="your-site-key"></div>
                            </div>
                            <!-- Buttons -->
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary">ยืนยัน</button>
                                <button type="reset" class="btn btn-warning">ล้างข้อมูล</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
</body>

</html>