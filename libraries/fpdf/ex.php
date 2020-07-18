<?php

# Copyright (c) Bouncing Ltd 2003-2015
# Author Philip Clarke nod@bouncing.org
# Released under the CC Attribution 4.0 licence https://creativecommons.org/licenses/by/4.0/
# You may do with it as you please just keep the credits. If you change something note it down for your own good
# This Version released 29/01/2015 (keep in as helps with bug fixes)


# mysql_report is now mysqli_report PHP 5+ compatible
# General Principle for setting up.
# Get the mysql_report and fpdf libraries loaded
# Set the page side (although pdf's tend to scale well)
# add database connection details
# add report title
# Add SQL statement (it is sanitized in mysql_report but take precautions with any user input)
# Output PDF (lots of people forget this and then wonder why the page is blank).

// you may need to change mysql_report.php to find the fpdf libraries
define('FPDF_FONTPATH','./font/');
require('./mysql_report.php');

// the PDF is defined as normal, in this case a Landscape, measurements in points, A3 page.
$pdf = new PDF('P','mm','A4');
$pdf->SetFont('Arial','',10);


// change the below to establish the database connection.
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'fyp_management_system';

// should not need changing, change above instead.
$pdf->connect($host, $username, $password, $database);


// attributes for the page titles
$attr = array('titleFontSize'=>16, 'titleText'=>'Student Details');

$sql_statement = " SELECT studentCMS AS CMS,studentName AS Name,studentEmail AS Email,studentPhoneNo AS Contact FROM student WHERE batchId = 12 ";

// Generate report
$pdf->mysql_report($sql_statement, false, $attr );


$pdf->Output();


/* ADVICE do not use a PHP closing tag like  ?> */
