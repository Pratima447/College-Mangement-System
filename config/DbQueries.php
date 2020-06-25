<?php
require('Database.php');

class DbQueries
{   
    //credential check
    function login($loginid, $password)
    {
        $db     = Database::getInstance();
        $mysqli = $db->getConnection();
        
        if(ctype_alpha($loginid) && ctype_alpha($password))
        {
            // admin login
            $query  = "SELECT loginid, password FROM credentials where loginid=? and password=? ";
            $stmt   = $mysqli->prepare($query);

            if(false===$stmt)
            {    
                trigger_error("Error in query: " . mysqli_connect_error(),E_USER_ERROR);
            }
            else
            {  
                $stmt->bind_param('ss',$loginid,$password);
                $stmt->execute();
                $stmt->bind_result($loginid,$password);
                $result = $stmt->fetch();

                if(!$result)
                {
                    echo "<script>alert('Invalid Details')</script>";
                }
                else
                {
                    setcookie('user', $loginid, time() + (86400 * 30), "/"); // 86400 = 1 day

                    header('location:/pages/admin_modules/courses/view_courses.php');
                }
            }
        }
        else if(ctype_digit($loginid))
        {
            // Lecturer login
            $query  = "SELECT lid,name FROM lecturers where mobile=? and password=? ";
            $stmt   = $mysqli->prepare($query);

            $stmt->bind_param('ss',$loginid,$password);
            $stmt->execute();
            $stmt->bind_result($lid, $name);
            $is_valid = $stmt->fetch();

            if (!$is_valid)
            {
                echo "<script>alert('Invalid Details')</script>";
            }
            else
            {
                setcookie('user', $name, time() + (86400 * 30), "/"); // 86400 = 1 day
                setcookie('id', $lid, time() + (86400 * 30), "/"); // 86400 = 1 day

                header('location:/pages/lecturer_modules/profile/view.php');
            }
        }
        else if(ctype_digit($password))
        {
            // Student login
            $query  = "SELECT sid, concat(fname,' ',mname) as name FROM students where reg_no=? and password=? ";
            $stmt   = $mysqli->prepare($query);

            $stmt->bind_param('si',$loginid,$password);
            $stmt->execute();
            $stmt->bind_result($sid, $name);
            $is_valid = $stmt->fetch();

            if (!$is_valid)
            {
                echo "<script>alert('Invalid Details')</script>";
            }
            else
            {
                setcookie('user', $name, time() + (86400 * 30), "/"); // 86400 = 1 day
                setcookie('stud_id', $sid, time() + (86400 * 30), "/"); // 86400 = 1 day

                header('location:/pages/student_modules/profile/view.php');
            }
        }
        else
        {
            echo "<script>alert('Invalid Details')</script>";
        }
    }

    // Create a new course
    function create_course($cshort,$cfull,$cdate)
    {
        $db     = Database::getInstance();
        $mysqli = $db->getConnection();
        $query  = "INSERT into courses(cshort,cfull,cdate) values (?,?,?)";
        $stmt   = $mysqli->prepare($query);

		if($stmt = $mysqli->prepare($query))
        {
            $stmt->bind_param('sss',$cshort,$cfull,$cdate);
            $stmt->execute();
            echo "<script>alert('Course Added Successfully')</script>";
        }
        else
        {
            $error = $mysqli->errno . ' ' . $mysqli->error;
    		echo $error;
        }  
    }

    //Show all courses
    function showCourses() 
    {
        $db     = Database::getInstance();
        $mysqli = $db->getConnection();
        $query  = "SELECT * FROM courses";
        $stmt   = $mysqli->query($query);
        
        return $stmt;
    }

    //Delete particular course
    function del_course($c_id)
    {
        $db     = Database::getInstance();
        $mysqli = $db->getConnection();

        $query = "DELETE from courses where cid=?";
        $stmt  = $mysqli->prepare($query);

        if($stmt = $mysqli->prepare($query))
        {
            $stmt->bind_param('s',$c_id);
            $stmt->execute();
            echo "<script>alert('Course has been deleted')</script>";
            echo "<script>window.location.href='view_courses.php'</script>";
        }
        else
        {
            $error = $mysqli->errno . ' ' . $mysqli->error;
    		echo $error;
        }  
    }

    //Get particluar course details
    function getCourse($cid)
    {
        $db     = Database::getInstance();
        $mysqli = $db->getConnection();

        $query  = "SELECT * FROM courses  where cid='".$cid."'";
        $stmt   = $mysqli->query($query);

        return $stmt;
        
    }

    // Update particluar course 
    function edit_course($cshort,$cfull,$udate,$id) 
    {
        $db     = Database::getInstance();
        $mysqli = $db->getConnection();

        $query = "UPDATE courses set cshort=?,cfull=? ,update_date=? where cid=?";
        $stmt  = $mysqli->prepare($query);

        if($stmt = $mysqli->prepare($query))
        {
            $stmt->bind_param('sssi',$cshort,$cfull,$udate,$id);
            $stmt->execute();
            echo '<script>alert("Course Updated Successfully")</script>';
        }
        else
        {
            $error = $mysqli->errno . ' ' . $mysqli->error;
    		echo $error;
        }  
    
    }

    // Create Subject
    function create_subject($cid, $sem, $no_sub, $subjects)
    {
        $db     = Database::getInstance();
        $mysqli = $db->getConnection();

        for ($i = 1; $i <= $no_sub; $i++)
        {
            $sem_name = "semester_" . $sem;
            $subject_name = $subjects[$i];

            $query_c = "SELECT cshort FROM courses where cid='".$cid."'";
            $result  = $mysqli->query($query_c);
            $row     = $result->fetch_row();
            $cshort  = $row[0];
            
            $query   = "INSERT into subjects(cid,semester,cshort,subject_name) values (?,?,?,?)";

            if($stmt = $mysqli->prepare($query))
            {
                $stmt->bind_param('isss',$cid,$sem_name,$cshort,$subject_name);
                $stmt->execute();
            }
            else
            {
                $error = $mysqli->errno . ' ' . $mysqli->error;
                echo $error;
            } 
        }
        
        echo "<script>alert('Subject Added Successfully')</script>";

    }

    // Show all Subjects
    function showSubjects()
    {
        $db     = Database::getInstance();
        $mysqli = $db->getConnection();
        $query  = "SELECT courses.cid, courses.cshort, subjects.semester,subjects.sub_id, subjects.subject_name FROM `subjects` JOIN courses on courses.cid = subjects.cid";

        $stmt   = $mysqli->query($query);

        return $stmt;
        
    }

    // Delete particular Subject
    function del_subject($sub_id)
    {
        $db     = Database::getInstance();
        $mysqli = $db->getConnection();

        $query = "DELETE from subjects where sub_id=?";
        $stmt  = $mysqli->prepare($query);

        $stmt->bind_param('i',$sub_id);
        $stmt->execute();

        echo "<script>alert('Subject has been deleted')</script>";
        echo "<script>window.location.href='view_subjects.php'</script>";

    }

    // Get particular Subject
    function getSubject($sub_id)
    {
        $db     = Database::getInstance();
        $mysqli = $db->getConnection();
        $query  = "SELECT * FROM subjects where sub_id='$sub_id' ";
        $stmt   = $mysqli->query($query);

        return $stmt;
    }

    // Update particular subject
    function edit_subject($cid, $sem, $subject_name, $udate, $sub_id)
    {
        $sem_name = "semester_" . $sem;

        $db     = Database::getInstance();
        $mysqli = $db->getConnection();

        $query_c = "SELECT cshort FROM courses where cid='".$cid."'";
        $result  = $mysqli->query($query_c);
        $row     = $result->fetch_row();
        $cshort  = $row[0];

        $query = "UPDATE subjects set cid=?, semester=?, cshort=?, subject_name=?, updated_at=? where sub_id=?";

        if($stmt = $mysqli->prepare($query))
        {
            $stmt->bind_param('issssi',$cid,$sem_name,$cshort,$subject_name, $udate, $sub_id);
            $stmt->execute();
        }
        else
        {
            $error = $mysqli->errno . ' ' . $mysqli->error;
            echo $error;
        } 

        echo "<script>alert('Subject Updated Successfully')</script>";
        echo "<script>window.location.href='view_subjects.php'</script>";

    }

    // Add Student
    function add_student($cid, $subjects,$sub_ids, $fname,$mname,$lname,
                    $guard_name,$occupation,$gender,$income,$category,$phy_challenged,
                    $nationality, $mobile, $email_id, $perm_address,
                    $board_1, $roll_no_1, $percent_1, $pass_year_1,
                    $board_2, $roll_no_2, $percent_2, $pass_year_2,$dob_stud) {

                      
        $db     = Database::getInstance();
        $mysqli = $db->getConnection();

        $query = "INSERT into students(cid,subjects,sub_ids,fname,mname,lname,gender,guard_name,occupation,income,category,
                    phy_challenged,nationality,mobile,email_id,perm_address,board_1,roll_no_1,percent_1,pass_year_1,
                    board_2,roll_no_2,percent_2,pass_year_2,reg_date,reg_no,dob,password) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        
        $stmt   = $mysqli->prepare($query);
         
        $permitted_chars = '0123456789E';
        $reg_no = substr(str_shuffle($permitted_chars), 0, 10);

        $password_chars = '0123456789';
        $password = substr(str_shuffle($password_chars), 0, 4);
        
        if($stmt = $mysqli->prepare($query))
        {
            $stmt->bind_param('issssssssssssssssssssssssssi',$cid, $subjects, $sub_ids,$fname,$mname,$lname,
                                $gender, $guard_name,$occupation,$income,$category,$phy_challenged,
                                $nationality, $mobile, $email_id, $perm_address,
                                $board_1, $roll_no_1,$percent_1,$pass_year_1,
                                $board_2, $roll_no_2,$percent_2,$pass_year_2,
                                $reg_date, $reg_no,$dob_stud,$password);

            $stmt->execute();
             //Send sems
            //request parameters array
            $requestParams = array(
                'user' => 'student-managment',
                'apiKey' => 'dssf645fddfgh565',
                'senderID' => 'C
                ODEXW',
                'message' => "Hello".$mname.".Your temporary password for login is ". $password,
            );
            // $apiUrl = "http://api.example.com/http/sendsms?";

            //API call
            // $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, $apiUrl);
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            // curl_exec($ch);
            // curl_close($ch);
            echo "<script>alert('Student Added Successfully')</script>";
            echo "<script>window.location.href='view_students.php'</script>";
        }
        else
        {
            $error = $mysqli->errno . ' ' . $mysqli->error;
    		echo $error;
        } 
    }

    // Show all students
    function showStudents()
    {
        $db     = Database::getInstance();
        $mysqli = $db->getConnection();
        $query  = "SELECT * FROM students";
        $stmt   = $mysqli->query($query);

        return $stmt;
        
    }

    // Delete particular student 
    function del_student($id)
    {
        $db     = Database::getInstance();
        $mysqli = $db->getConnection();

        $query = "DELETE from students where sid=?";
        $stmt  = $mysqli->prepare($query);

        $stmt->bind_param('i',$id);
        $stmt->execute();

        echo "<script>alert('One record has been deleted')</script>";
        echo "<script>window.location.href='view_students.php'</script>";
     
    }

    // get particluar student 
    function getStudentData($sid)
    {
        $db     = Database::getInstance();
        $mysqli = $db->getConnection();

        $query = "SELECT * FROM students  where sid='".$sid."'";
        $stmt  = $mysqli->query($query);

        return $stmt;
    }

    // update student data
    function edit_student($cid, $subjects,$fname,$mname,$lname,
                            $guard_name,$occupation,$gender,$income,$category,$phy_challenged,
                            $nationality, $mobile, $email_id, $perm_address,
                            $board_1, $roll_no_1, $percent_1, $pass_year_1,
                            $board_2, $roll_no_2, $percent_2, $pass_year_2, $dob_stud, $sid)
    {
        $db     = Database::getInstance();
        $mysqli = $db->getConnection();

        $query = "UPDATE students set cid=?,subjects=?,fname=?,mname=?,lname=?,gender=?,guard_name=?,occupation=?
                ,income=?,category=?,phy_challenged=?,nationality=?,mobile=?,email_id=?,perm_address=?
                ,board_1=?,roll_no_1=?,percent_1=?,pass_year_1=?
                ,board_2=?,roll_no_2=?,percent_2=?,pass_year_2=?,dob=? where sid=?";

        // $stmt= $mysqli->prepare($query);

        if($stmt = $mysqli->prepare($query))
        {
            $stmt->bind_param('isssssssssssssssssssssssi',$cid, $subjects,$fname,$mname,$lname,
                                $gender, $guard_name,$occupation,$income,$category,$phy_challenged,
                                $nationality, $mobile, $email_id, $perm_address,
                                $board_1, $roll_no_1,$percent_1,$pass_year_1,
                                $board_2, $roll_no_2,$percent_2,$pass_year_2, $dob_stud,$sid
                                );

            $stmt->execute();
            echo "<script>alert('Student Data Updated Successfully')</script>";
            echo "<script>window.location.href='view_students.php'</script>";

        }
        else
        {
            $error = $mysqli->errno . ' ' . $mysqli->error;
            echo $error;
        } 
    }

    // Add lecture
    function add_lecture($lname,$mobile,$email,$qual,$gender,$join_date,$perm_address)
    {
        $db     = Database::getInstance();
        $mysqli = $db->getConnection();

        $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $password = substr(str_shuffle($permitted_chars), 0, 10);

        $query = "INSERT into lecturers(name,mobile,email,qualification,gender,join_date,perm_address,password) values (?,?,?,?,?,?,?,?)";
        $stmt   = $mysqli->prepare($query);

        if($stmt = $mysqli->prepare($query))
        {
            $stmt->bind_param('ssssssss',$lname,$mobile,$email,$qual,$gender,$join_date,$perm_address,$password);
            $stmt->execute();

            //Send sems
            //request parameters array
            $requestParams = array(
                'user' => 'student-managment',
                'apiKey' => 'dssf645fddfgh565',
                'senderID' => 'CODEXW',
                'message' => "Hello".$lname.".Your temporary password for login is ". $password,
            );
            // $apiUrl = "http://api.example.com/http/sendsms?";

            //API call
            // $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, $apiUrl);
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            // curl_exec($ch);
            // curl_close($ch);

            echo "<script>alert('Lecturer Details Added Successfully')</script>";

        }
        else
        {
            $error = $mysqli->errno . ' ' . $mysqli->error;
            echo $error;
        } 
    }

    //Show all courses
    function showLectures() 
    {
        $db     = Database::getInstance();
        $mysqli = $db->getConnection();
        $query  = "SELECT * FROM lecturers";
        $stmt   = $mysqli->query($query);
        
        return $stmt;
    }

    //Delete particular Lecture details
    function del_lecture($lid)
    {
        $db     = Database::getInstance();
        $mysqli = $db->getConnection();

        $query = "DELETE from lecturers where lid=?";
        $stmt  = $mysqli->prepare($query);

        if($stmt = $mysqli->prepare($query))
        {
            $stmt->bind_param('i',$lid);
            $stmt->execute();
            echo "<script>alert('Lecture data has been deleted')</script>";
            echo "<script>window.location.href='view_lectures.php'</script>";
        }
        else
        {
            $error = $mysqli->errno . ' ' . $mysqli->error;
            echo $error;
        }  
    }
    
    // get particluar lecture 
    function getLectureData($lid)
    {
        $db     = Database::getInstance();
        $mysqli = $db->getConnection();

        $query = "SELECT * FROM lecturers where lid='".$lid."'";
        $stmt  = $mysqli->query($query);

        return $stmt;
    }

    // Update Particluar lecture details
    function update_lecture($lid,$lname,$mobile,$qual,$gender,$join_date,$perm_address)
    {
        $db     = Database::getInstance();
        $mysqli = $db->getConnection();

        $query = "UPDATE lecturers set name=?, mobile=?,qualification=?, gender=?, join_date=?,perm_address=? where lid=?";
        
        if ($stmt = $mysqli->prepare($query))
        {
            $stmt->bind_param('ssssssi',$lname,$mobile,$qual,$gender,$join_date,$perm_address,$lid);
            $stmt->execute();
            echo "<script>alert('Lecture Data Updated Successfully')</script>";
            echo "<script>window.location.href='view_lectures.php'</script>";

        }
        else
        {
            $error = $mysqli->errno . ' ' . $mysqli->error;
            echo $error;
        } 
    }

    // Create a department
    function create_department($dshort, $dfull, $cdate)
    {
        $db     = Database::getInstance();
        $mysqli = $db->getConnection();
        $query  = "INSERT into departments(dshort,dfull,cdate) values (?,?,?)";
        $stmt   = $mysqli->prepare($query);

        if($stmt = $mysqli->prepare($query))
        {
            $stmt->bind_param('sss',$dshort,$dfull,$cdate);
            $stmt->execute();
            echo "<script>alert('Department Added Successfully')</script>";
        }
        else
        {
            $error = $mysqli->errno . ' ' . $mysqli->error;
    		echo $error;
        }  
    }
    
    //Show all Departments
    function showDepartments() 
    {
        $db     = Database::getInstance();
        $mysqli = $db->getConnection();
        $query  = "SELECT * FROM departments";
        $stmt   = $mysqli->query($query);
        
        return $stmt;
    }

    //Delete particular Department
    function del_department($d_id)
    {
        $db     = Database::getInstance();
        $mysqli = $db->getConnection();

        $query = "DELETE from departments where did=?";
        $stmt  = $mysqli->prepare($query);

        if($stmt = $mysqli->prepare($query))
        {
            $stmt->bind_param('i',$d_id);
            $stmt->execute();
            echo "<script>alert('Department has been deleted')</script>";
            echo "<script>window.location.href='view_departments.php'</script>";
        }
        else
        {
            $error = $mysqli->errno . ' ' . $mysqli->error;
            echo $error;
        }  
    }

    //Get particluar Department details
    function getDept($did)
    {
        $db     = Database::getInstance();
        $mysqli = $db->getConnection();
        $query  = "SELECT * FROM departments  where did='".$did."'";
        $stmt   = $mysqli->query($query);

        return $stmt;
        
    }

    // Update particluar Department 
    function edit_dept($dshort,$dfull,$udate,$id) 
    {
        $db     = Database::getInstance();
        $mysqli = $db->getConnection();

        $query = "UPDATE departments set dshort=?,dfull=? ,update_date=? where did=?";
        $stmt  = $mysqli->prepare($query);

        if($stmt = $mysqli->prepare($query))
        {
            $stmt->bind_param('sssi',$dshort,$dfull,$udate,$id);
            $stmt->execute();
            echo '<script>alert("Departments Updated Successfully")</script>';
            echo "<script>window.location.href='view_departments.php'</script>";
        }
        else
        {
            $error = $mysqli->errno . ' ' . $mysqli->error;
            echo $error;
        }  
    
    }

    function get_all_lect()
    {
        $db     = Database::getInstance();
        $mysqli = $db->getConnection();
        $query  = "SELECT * FROM lecturers";
        $stmt   = $mysqli->query($query);
        
        return $stmt;
    }

    // update lect password
    function update_lect_pass($new_pass, $confirm_new_pass)
    {
        if ($new_pass != $confirm_new_pass)
        {
            echo '<script>alert("Password and confirm password doesnt match!!")</script>';
        }
        else
        {
            $db     = Database::getInstance();
            $mysqli = $db->getConnection();

            if( isset($_COOKIE['id']))
            {
                $id = $_COOKIE['id'];
            }

            $query = "UPDATE lecturers set password=? where lid=?";
            $stmt  = $mysqli->prepare($query);
    
            if($stmt = $mysqli->prepare($query))
            {
                $stmt->bind_param('si',$new_pass,$id);
                $stmt->execute();
                echo '<script>alert("Password Updated Successfully")</script>';
                echo "<script>window.location.href='view.php'</script>";
            }
            else
            {
                $error = $mysqli->errno . ' ' . $mysqli->error;
                echo $error;
            }  
        }
    }

    // get study materials
    function get_study_materials($cname, $sem, $subject)
    {
        $dir = "../../../public/study_materials/".$cname."/".$sem."/".$subject."/";    
        $results_array = array();
        
        if (is_dir($dir))
        {
            if ($handle = opendir($dir))
            {
                    //Notice the parentheses I added:
                while(($file = readdir($handle)) !== FALSE)
                {
                        $results_array[] = $file;
                }
                closedir($handle);
            }
        }
        
        //Output findings
        foreach($results_array as $value)
        {
            echo $value . '<br />';
        }

    }

    // enter course and sem in time table 
    function enter_tt_course_sem($cid,$cshort,$sem,$day,$slots)
    {
        $db     = Database::getInstance();
        $mysqli = $db->getConnection();
        $query  = "INSERT into tt_course_sem(cid,cshort,semester,day,course_sem_day	) values (?,?,?,?,?)";
        $stmt   = $mysqli->prepare($query);

        $course_sem_day	 = $cshort.'_'.$sem.'_'.$day;

        if($stmt = $mysqli->prepare($query))
        {
            $stmt->bind_param('issss',$cid,$cshort,$sem,$day,$course_sem_day);
            $stmt->execute();
            return 1;
            // echo "<script>alert('Inserted course ans sem in tt Successfully')</script>";
        }
        else
        {
            $error = $mysqli->errno . ' ' . $mysqli->error;
    		echo $error;
        }  
    }

    function time_table_daily($course_sem_day, $day, $start_time, $end_time,$sub_id,$sub_name, $lect_id, $lect_name )
    {
        // echo $course_sem_day."<br>".$day."<br>".$start_time."<br>".$end_time."<br>".$sub_id."<br>".$lect_id;

        $db     = Database::getInstance();
        $mysqli = $db->getConnection();

        $query  = "INSERT into time_table_daily(course_sem_day,day,start_time,end_time,sub_id,subject,lect_id,lecturer) values (?,?,?,?,?,?,?,?)";
        $stmt   = $mysqli->prepare($query);

        if($stmt = $mysqli->prepare($query))
        {
            $stmt->bind_param('ssiiisis',$course_sem_day,$day,$start_time,$end_time,$sub_id,$sub_name,$lect_id,$lect_name);
            $stmt->execute();
            
            return 1;
        }
        else
        {
            $error = $mysqli->errno . ' ' . $mysqli->error;
    		echo $error;
        } 
    }

    function add_internal_marks($cid, $sem, $sub_id,$session,$stud_id,$marks,$sub_name,$stud_name,$reg_no)
    {
       
        $lect_id    = $_COOKIE['id'];
        $lect_name  = $_COOKIE['user'];

        $db     = Database::getInstance();
        $mysqli = $db->getConnection();
        
        $query = 'INSERT INTO internal_marks(c_id,stud_id,sub_id,lect_id,semester,reg_no,student_name,subject_name,lect_name,session,marks) values(?,?,?,?,?,?,?,?,?,?,?)';
        $stmt  = $mysqli->prepare($query);

      
        if($stmt = $mysqli->prepare($query))
        {
            $stmt->bind_param('iiiisssssii',$cid,$stud_id,$sub_id,$lect_id,$sem,$reg_no,$stud_name,$sub_name,$lect_name,$session,$marks);
            $stmt->execute();
            return 1;
        }
        else
        {
            $error = $mysqli->errno . ' ' . $mysqli->error;
    		echo $error;
        } 
    }

    function check_if_exists($cid, $sem, $sub_id,$stud_id,$session)
    {
        $db     = Database::getInstance();
        $mysqli = $db->getConnection();

        $query = 'SELECT marks from internal_marks where c_id=? and semester=? and sub_id=? and stud_id=? and session=? ';
        $stmt   = $mysqli->prepare($query);

        if(false===$stmt)
        {    
            trigger_error("Error in query: " . mysqli_connect_error(),E_USER_ERROR);
        }
        else
        {  
            $stmt->bind_param('isiii',$cid,$sem,$sub_id,$stud_id,$session);
            $stmt->execute();
            $stmt->bind_result($marks);

            $result = $stmt->fetch();

            if ($result) {
                return 1;
            }
            return 0;
        }

    }

    // update student password
    function update_stud_pass($new_pass, $confirm_new_pass)
    {
        if ($new_pass != $confirm_new_pass)
        {
            echo '<script>alert("Password and confirm password doesnt match!!")</script>';
        }
        else
        {
            $db     = Database::getInstance();
            $mysqli = $db->getConnection();

            if( isset($_COOKIE['stud_id']))
            {
                $id = $_COOKIE['stud_id'];
            }

            $query = "UPDATE students set password=? where sid=?";
            $stmt  = $mysqli->prepare($query);
    
            if($stmt = $mysqli->prepare($query))
            {
                $stmt->bind_param('ii',$new_pass,$id);
                $stmt->execute();
                echo '<script>alert("Password Updated Successfully")</script>';
                echo "<script>window.location.href='view.php'</script>";
            }
            else
            {
                $error = $mysqli->errno . ' ' . $mysqli->error;
                echo $error;
            }  
        }
    }
  
    // Insert query by student
    function post_stud_query($sub_id, $question)
    {
        $stud_id   = $_COOKIE['stud_id'];
        $stud_name = $_COOKIE['user'];
        
        $db     = Database::getInstance();
        $mysqli = $db->getConnection();

        // get subject name
        $query_sub  = "SELECT subject_name FROM subjects where sub_id=".$sub_id;
        $result     = $mysqli->query($query_sub);
        $row        = $result->fetch_row();
        $sub_name   = $row[0];

        // Insert query now
        $query = 'INSERT INTO queries(stud_id,sub_id,student_name,subject_name,question) 
                    values(?,?,?,?,?)';

        date_default_timezone_set('Asia/Kolkata');
        $now = date("Y-m-d h:i:s");

        if($stmt = $mysqli->prepare($query))
        {
            $stmt->bind_param('iisss',$stud_id,$sub_id,$stud_name,$sub_name,$question);
            $stmt->execute();

            echo "<script>alert('Question posted Successfully')</script>";
            header('location:/pages/student_modules/queries/answers.php');

        }
        else
        {
            $error = $mysqli->errno . ' ' . $mysqli->error;
            echo $error;
        } 
    }


    function getLectureSubjects($lect_id)
    {
        $db     = Database::getInstance();
        $mysqli = $db->getConnection();

        $query = 'SELECT sub_id, subject
                    from time_table_daily where lect_id='.$lect_id;

        $result  = $mysqli->query($query);
    
        return $result;
    }

    function get_question_details($qid)
    {
        $db     = Database::getInstance();
        $mysqli = $db->getConnection();

        $query = 'SELECT subject_name, question, answer,request_time,solution_time
                    from queries where qid='.$qid;

        $result  = $mysqli->query($query);
    
        return $result;
    }

    function post_answer($qid, $answer, $update)
    {
        $lect_id   = $_COOKIE['id'];
        $lect_name = $_COOKIE['user'];
         
        $db     = Database::getInstance();
        $mysqli = $db->getConnection();

        $query  = 'UPDATE queries set lect_id=?, lect_name=?, answer=?, solution_time=?,  solved=? where qid=?';
        $solved = 1;

        if($stmt = $mysqli->prepare($query))
        {
            $stmt->bind_param('isssii',$lect_id,$lect_name,$answer,$update,$solved,$qid);
            $stmt->execute();

            echo "<script>alert('Answer submitted Successfully')</script>";
            header('location:/pages/lecturer_modules/queries/answers.php');

        }
        else
        {
            $error = $mysqli->errno . ' ' . $mysqli->error;
            echo $error;
        } 
    }
}

?>



