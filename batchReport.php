<?php
$title="ProSys";
$subtitle="Group Report";
include("include/head.php");
include("db/db_connect.php");
include ("include/functions.php");
session_start();

//Check if coordinator is logged in
if(!isset($_SESSION['user_id'])){
  header('location: login.php');
}

//Check if form is submitted by GET
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $batchId = filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);

    $sql = "SELECT * FROM batch WHERE batchId = '$batchId' LIMIT 1";
    $result = mysqli_query($link,$sql);

    if (mysqli_num_rows($result)> 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $batchName = $row['batchName'];
            $startDate = $row['startingDate'];
        }
    } else {
        $batchName = "--";
        $startDate = "--";
    }

    $sql = "SELECT studentId FROM student WHERE student.batchId = '$batchId' ";
    $result = mysqli_query($link,$sql);
    if (mysqli_num_rows($result)> 0) {
        $numOfStudents = mysqli_num_rows($result);
    }
    else{
        $numOfStudents = "--";
    }


}


?>
<style>
    body {
        background: rgb(204,204,204);
    }
    page {
        background: white;
        display: block;
        margin: 0 auto;
        margin-bottom: 0.5cm;
        card-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
    }
    page[size="A4"] {
        width: 21cm;
        /*height: 29.7cm;*/
    }
    page[size="A4"][layout="portrait"] {
        width: 29.7cm;
        height: 21cm;
    }
    page[size="A3"] {
        width: 29.7cm;
        height: 42cm;
    }
    page[size="A3"][layout="portrait"] {
        width: 42cm;
        height: 29.7cm;
    }
    page[size="A5"] {
        width: 14.8cm;
        height: 21cm;
    }
    page[size="A5"][layout="portrait"] {
        width: 21cm;
        height: 14.8cm;
    }
    @media print {
        body, page {
            margin: 0;
            card-shadow: 0;
        }
    }
</style>
<!--KendoUI-->
<link href="plugins/kendo-ui/styles/kendo.common.min.css" rel="stylesheet">
<link href="plugins/kendo-ui/styles/kendo.rtl.min.css" rel="stylesheet">
<link href="plugins/kendo-ui/styles/kendo.default.min.css" rel="stylesheet">
<link href="plugins/kendo-ui/styles/kendo.dataviz.min.css" rel="stylesheet">
<link href="plugins/kendo-ui/styles/kendo.dataviz.default.min.css" rel="stylesheet">
<script src="plugins/kendo-ui/js/jquery.min.js"></script>
<script src="plugins/kendo-ui/js/jszip.min.js"></script>
<script src="plugins/kendo-ui/js/kendo.all.min.js"></script>

</head>
<body>
    <!-- general form elements -->
    <div class="card no-padding">
        <div class="card-body ">
            <div class="col-md-12">
                <div class="">
                    <center>
                        <button class='export-pdf btn btn-primary btn-flat btn-lg'><i class="fa fa-file-pdf" aria-hidden="true"></i> Export as PDF</button>
                        <button class='export-img btn btn-primary btn-flat btn-lg'><i class="fa fa-file-image" aria-hidden="true"></i> Export as Image</button>
                    </center>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card -->

    <page size="A4" class="groupReport">
        <section class="invoice">
            <!-- title row -->
            <div class="row">
                <div class="col-sm-8">
                    <h2 class="page-header">
                        <img src="dist/img/IUlogo.png" alt="fyp_logo" length="52" width="250">
                    </h2>
                </div>
                <div class="col-sm-4 float-right text-center">
                    <h2 class="float-left">Date: <?php echo date("d/m/Y");?>
                    </h2>
                </div>
            </div>

            <!-- info row -->
            <div class="row ">
                <div class="col-sm-12 col-md-offset-3 ">
                    <h4 class="text-center"><?php echo $batchName;?> : Report
                    </h4>
                    <br>
                </div>
            </div>

            <!-- info row -->
            <div class="row" >
                <div class="col-md-6">
                    <p class="float-left" >Student Registered : <?php echo $numOfStudents; ?></p>
                    <br>
                </div>
                <!-- /.col -->

                <div class="col-md-6 ">
                    <p class="float-right" >Start Date : <?php echo $startDate; ?></p>
                    <br>
                </div>
            </div>
            <!-- /.row -->


            <!-- Table row -->
            <h5>List of students</h5>
            <div class="row">
                <div class="col-sm-12 table-responsive">
                    <table class="table table-head-fixed text-nowrap table-striped">
                        <thead>
                            <tr>
                                <th style="width:40px;">RID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Contact</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM student WHERE student.batchId = '$batchId' ";
                            $result = mysqli_query($link,$sql);
                            if (mysqli_num_rows($result) > 0) {
                                // output data of each row
                                while($row = mysqli_fetch_assoc($result)) { ?>
                                    <tr>
                                        <td><?php echo $row['studentRid'];?></td>
                                        <td><?php echo $row['studentName'];?></td>
                                        <td><?php echo $row['studentEmail'];?></td>
                                        <td><?php echo $row['studentPhoneNo'];?></td>
                                    </tr>

                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
    </page>
</div>
<script>
    // Import DejaVu Sans font for embedding

    // NOTE: Only required if the Kendo UI stylesheets are loaded
    // from a different origin, e.g. cdn.kendostatic.com
    kendo.pdf.defineFont({
        "DejaVu Sans"             : "//kendo.cdn.telerik.com/2014.3.1314/styles/fonts/DejaVu/DejaVuSans.ttf",
        "DejaVu Sans|Bold"        : "//kendo.cdn.telerik.com/2014.3.1314/styles/fonts/DejaVu/DejaVuSans-Bold.ttf",
        "DejaVu Sans|Bold|Italic" : "//kendo.cdn.telerik.com/2014.3.1314/styles/fonts/DejaVu/DejaVuSans-Oblique.ttf",
        "DejaVu Sans|Italic"      : "//kendo.cdn.telerik.com/2014.3.1314/styles/fonts/DejaVu/DejaVuSans-Oblique.ttf"
    });
</script>

<!-- Load Pako ZLIB library to enable PDF compression -->
<script src="plugins/kendo-ui/js/pako_deflate.min.js"></script>

<script>
$(document).ready(function() {

    $(".export-pdf").click(function() {
        // Convert the DOM element to a drawing using kendo.drawing.drawDOM
        kendo.drawing.drawDOM($(".groupReport"))
            .then(function(group) {
                // Render the result as a PDF file
                return kendo.drawing.exportPDF(group, {
                    paperSize: "auto",
                    margin: { left: "1cm", top: "1cm", right: "1cm", bottom: "1cm" }
                });
            })
            .done(function(data) {
                // Save the PDF file
                kendo.saveAs({
                    dataURI: data,
                    fileName: "batch-report.pdf",
                    proxyURL: "//demos.telerik.com/kendo-ui/service/export"
                });
            });
    });

    $(".export-img").click(function() {
        // Convert the DOM element to a drawing using kendo.drawing.drawDOM
        kendo.drawing.drawDOM($(".groupReport"))
            .then(function(group) {
                // Render the result as a PNG image
                return kendo.drawing.exportImage(group);
            })
            .done(function(data) {
                // Save the image file
                kendo.saveAs({
                    dataURI: data,
                    fileName: "batch-report.png",
                    proxyURL: "//demos.telerik.com/kendo-ui/service/export"
                });
            });
    });
});
</script>

</body>

