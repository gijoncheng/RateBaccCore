
<?php
    require_once 'config.php';
    
    $mysqli = connect();
    
    $postdata = file_get_contents("php://input");

    date_default_timezone_set('America/Los_Angeles');
    $cur_time = date("Y-m-d");


    if(isset($postdata) && !empty($postdata)){
        $request = json_decode($postdata);
        $action = $request->action;

        if ($action === 'post'){
	        $sql = "INSERT INTO QUESTION (question, qTime, courseID, userID) VALUES (?,?,?,?)";
	        if($stmt = $mysqli->prepare($sql)){

	            $stmt->bind_param("ssss", $question, $qTime, $courseID, $userID);

	            $question = $request->qText;
	            $qTime = $cur_time;
	            $courseID = $request->courseId;
	            $userID = $request->userId;
	            
	            if($stmt->execute()){
	                echo 1;
	            }else{
	                echo 0;
	            }
	            $stmt->close();

	        }else{
	            die("Failed to insert");
	        }
	        
	    } else if ($action === 'delete') {
	    	$questionId = $request->question_id;

	        if($request->action == 'delete'){

	            $sql = "DELETE FROM QUESTION WHERE qID = '$questionId'";
	            if ($mysqli->query($sql) === TRUE) {
	                echo 1;
	            } else {
	                echo "Error deleting record: " . $conn->error;
	            }
	        } 
	    }
    }
    mysqli_close($mysqli);
    
?>
