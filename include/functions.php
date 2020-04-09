<?php
/**
 * Get excerpt from string
 *
 * @param String $str String to get an excerpt from
 * @param Integer $startPos Position int string to start excerpt from
 * @param Integer $maxLength Maximum length the excerpt may be
 * @return String excerpt
 */
function getExcerpt($str, $startPos = 0, $maxLength = 100)
{
    if (strlen($str) > $maxLength) {
        $excerpt = substr($str, $startPos, $maxLength - 3);
        $lastSpace = strrpos($excerpt, ' ');
        $excerpt = substr($excerpt, 0, $lastSpace);
        $excerpt .= '...';
    } else {
        $excerpt = $str;
    }

    return $excerpt;
}


/**
 * Function to convert timestamp to relative time
 *
 * @param String $timestamp
 * @return bool|string
 */
function time2str($ts) {
    if (!ctype_digit($ts))
        $ts = strtotime($ts);

    $diff = time() - $ts;
    if ($diff == 0){
        return 'now';
    }elseif ($diff > 0) {
        $day_diff = floor($diff / 86400);
        if ($day_diff == 0) {
            if ($diff < 60)
                return 'just now';
            if ($diff < 120)
                return '1 minute ago';
            if ($diff < 3600)
                return floor($diff / 60) . ' minutes ago';
            if ($diff < 7200)
                return '1 hour ago';
            if ($diff < 86400)
                return floor($diff / 3600) . ' hours ago';
        }
        if ($day_diff == 1)
            return 'Yesterday';
        if ($day_diff < 7)
            return $day_diff . ' days ago';
        if ($day_diff < 31)
            return ceil($day_diff / 7) . ' weeks ago';
        if ($day_diff < 60)
            return 'last month';
        return date('F Y', $ts);
    }
    else {
        $diff = abs($diff);
        $day_diff = floor($diff / 86400);
        if ($day_diff == 0) {
            if ($diff < 120)
                return 'in a minute';
            if ($diff < 3600)
                return 'in ' . floor($diff / 60) . ' minutes';
            if ($diff < 7200)
                return 'in an hour';
            if ($diff < 86400)
                return 'in ' . floor($diff / 3600) . ' hours';
        }
        if ($day_diff == 1)
            return 'Tomorrow';
        if ($day_diff < 4)
            return date('l', $ts);
        if ($day_diff < 7 + (7 - date('w')))
            return 'next week';
        if (ceil($day_diff / 7) < 4)
            return 'in ' . ceil($day_diff / 7) . ' weeks';
        if (date('n', $ts) == date('n') + 1)
            return 'next month';
        return date('F Y', $ts);
    }
}


function getStudentData($id) {
    global $link;

    // build the query
    $sql = "SELECT * from student WHERE student.studentId = '$id' LIMIT 1";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $studentData = array(
                "rid"=>$row['studentRid'],
                "name"=>$row['studentName'],
                "email"=>$row['studentEmail'],
                "gender"=>$row['studentGender'],
                "studentimage"=>$row['studentImage'],
            );

            return $studentData;

        }
    } else {
       return false;
    }

}


//Function to generate random password
function random_password( $length = 8 ) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*";
    $password = substr( str_shuffle( $chars ), 0, $length );
    return $password;
}

function get_icon($filename){
    //Work out file extension
    $file_ext   =   explode('.',$filename);
    $file_ext   = strtolower(end($file_ext));

    switch($file_ext){
        //Documents
        case 'docx':{echo 'text-primary fa fa-file-word' ; break;}
        case 'doc':{echo 'text-primary fa fa-file-word' ; break;}
        case 'txt':{echo 'text-secondary fa fa-file-text' ; break;}
        case 'pdf':{echo 'text-danger fa fa-file-pdf'; break;}

        //Compressed Files
        case 'rar':{echo 'fa fa-file-archive' ; break;}
        case 'zip':{echo 'fa fa-file-archive' ; break;}
        case '7zip':{echo 'fa fa-file-archive' ; break;}
        case 'iso':{echo 'fa fa-file-archive' ; break;}

        //Image
        case 'jpg':{echo 'fa fa-file-image'; break;}
        case 'jpeg':{echo 'fa fa-file-image'; break;}
        case 'png':{echo 'fa fa-file-image'; break;}
        case 'gif':{echo 'fa fa-file-image'; break;}

        //Powerpoint
        case 'ppt':{echo 'text-warning fa fa-file-powerpoint'; break;}
        case 'pptx':{echo 'text-warning fa fa-file-powerpoint'; break;}

        //Excel
        case 'xlsx':{echo 'text-success fa fa-file-excel'; break;}

        //Default
        default:{echo 'fa fa-file'; break;}
    }




}

function check_group_uploads ($groupId,$taskId,$batchId){
    global $link;

    $sql = "SELECT * FROM batch_tasks JOIN group_uploads ON batch_tasks.taskId = group_uploads.taskId WHERE groupId = '$groupId' AND batchId = '$batchId' AND batch_tasks.taskId = '$taskId' LIMIT 1 ";
    $result = $link->query($sql);

    if ($result->num_rows > 0) {
        return true;
    } else {
        return false;
    }

}

function fuzzydate($value)
{
    list($date, $time) = explode(' ', $value);
    list($year, $month, $day) = explode('-', $date);
    list($hour, $minutes, $seconds) = explode(':', $time);

    $unit_timestamp = mktime($hour, $minutes, $seconds, $month, $day, $year);

    return $unit_timestamp;

}

function convertToAgoFormat($timestamp)
{
    $diff = time() - $timestamp;
    if ($diff < 0){
        return 'now';
    }elseif ($diff > 0) {
        $day_diff = floor($diff / 86400);
        if ($day_diff == 0) {
            if ($diff < 60)
                return 'just now';
            if ($diff < 120)
                return '1 minute ago';
            if ($diff < 3600)
                return floor($diff / 60) . ' minutes ago';
            if ($diff < 7200)
                return '1 hour ago';
            if ($diff < 86400)
                return floor($diff / 3600) . ' hours ago';
        }
        if ($day_diff == 1)
            return 'Yesterday';
        if ($day_diff < 7)
            return $day_diff . ' days ago';
        if ($day_diff < 31)
            return ceil($day_diff / 7) . ' weeks ago';
        if ($day_diff < 60)
            return 'last month';
        return date('F Y', $ts);
    }
    else {
        $diff = abs($diff);
        $day_diff = floor($diff / 86400);
        if ($day_diff == 0) {
            if ($diff < 120)
                return 'in a minute';
            if ($diff < 3600)
                return 'in ' . floor($diff / 60) . ' minutes';
            if ($diff < 7200)
                return 'in an hour';
            if ($diff < 86400)
                return 'in ' . floor($diff / 3600) . ' hours';
        }
        if ($day_diff == 1)
            return 'Tomorrow';
        if ($day_diff < 4)
            return date('l', $ts);
        if ($day_diff < 7 + (7 - date('w')))
            return 'next week';
        if (ceil($day_diff / 7) < 4)
            return 'in ' . ceil($day_diff / 7) . ' weeks';
        if (date('n', $ts) == date('n') + 1)
            return 'next month';
        return date('F Y', $ts);
    }
    
}

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
	