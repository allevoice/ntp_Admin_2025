<?php

$url = "../";

include $url . 'include/header.php';
?>




<input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required="">
<input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required="">
<input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required="">
<textarea class="form-control" name="message" rows="5" placeholder="Message" required=""></textarea>











    <div class="pagetitle">
        <h1>Dashboard</h1>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-8">
                <div class="row">

                    <!-- Recent Sales -->
                    <div class="col-12">
                        <div class="card recent-sales overflow-auto">


                            <div class="card-body">

                                <?php include $url."mail_admin/content.php"?>

                            </div>

                        </div>
                    </div><!-- End Recent Sales -->

                </div>
            </div><!-- End Left side columns -->


            <?php include $url."include/sidebare_right.php"?>

        </div>
    </section>


<?php include $url.'include/footer.php'; ?>