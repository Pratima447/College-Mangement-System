<?php
    $cname   = $_POST['course'];
    $sem     = $_POST['sem'];
    $subject = $_POST['subject'];
   

    $file_name = $_FILES['mat_file']['name'];

    $target_dir  = "../../../public/study_materials/".$cname."/".$sem."/".$subject."/";

    if (file_exists($target_dir.$file_name)) {
        echo 'This file already exists';
        return;
    }

    $course_folder = "../../../public/study_materials/".$cname;
    $sem_folder = "../../../public/study_materials/".$cname."/".$sem;
    $sub_folder = "../../../public/study_materials/".$cname."/".$sem."/".$subject;

    if (is_dir($course_folder)) {
        $target_dir  = "../../../public/study_materials/".$cname;
    } else {
        mkdir("../../../public/study_materials/".$cname, 0755, true);
    }

    if (is_dir($sem_folder)) {
        $target_dir  = "../../../public/study_materials/".$cname."/".$sem;
    } else {
        mkdir("../../../public/study_materials/".$cname."/".$sem, 0755, true);
    }

    if (is_dir($sub_folder)) {
        $target_dir = "../../../public/study_materials/".$cname."/".$sem."/".$subject."/";
    } else {
        mkdir("../../../public/study_materials/".$cname."/".$sem."/".$subject, 0755, true);
    }
    
    $target_dir  = $target_dir .$_FILES['mat_file']['name'];   
    $targetfile  = $target_dir.$_FILES['mat_file']['name'];

    if (move_uploaded_file($_FILES['mat_file']['tmp_name'], $target_dir))
    {
        echo "The file ". basename( $_FILES["mat_file"]["name"]). " has been uploaded.";
    } else { 
        echo "Sorry, there was an error uploading your file.";
    }

?>