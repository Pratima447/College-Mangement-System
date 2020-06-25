<?php

    $cname   = $_POST['cname'];
    $sem     = $_POST['sem'];
    $subject = $_POST['subject'];

    $dir = "../../../public/study_materials/".$cname."/".$sem."/".$subject."/";  
    
    $results_array = array();

    if (is_dir($dir))
    {
        if ($handle = opendir($dir))
        {
            while(($file = readdir($handle)) !== FALSE)
            {
                    $results_array[] = $file;
            }
            closedir($handle);
        }
    }

    if ( count($results_array) == 0 ) 
    {
        echo "<strong>No files found for selected fields.</strong>";
        return;
    }
    //Output findings
    echo "<strong style='color: blueviolet;'>Study materials available for ".$subject." of ".$sem." in ".$cname."</strong>";

    foreach($results_array as $value)
    {
        echo "<p>";
        echo '<a href="'.$dir.$value.'" target="_blank">'.$value .'</a>';
        // echo "<a href="">click</a>
        echo "</p>";
    }
?>