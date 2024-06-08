
	<?php
		// ******** update your personal settings ******** 
		$servername = "140.122.184.129:3310";
        $username = "team12";
        $password = "SM(tFcLC*Ma0(N(E";
        $dbname = "team12";
		// Connect MySQL server
		$conn = new mysqli($servername, $username, $password, $dbname);
		
        if (!$conn->set_charset("utf8")) {
            printf("Error loading character set utf8: %s\n", $conn->error);
            exit();
        }
        
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        $delete_sql = "SELECT * FROM Company";
        if ($conn->query($delete_sql)=== TRUE) {
            // 重定向用戶到下一頁
            echo "破處"
        } else {
            echo "刪除失敗!";
        }
        
		// // set up char set
		// if (!$conn->set_charset("utf8")) {
		// 	printf("Error loading character set utf8: %s\n", $conn->error);
		// 	exit();
		// }
		
		// // Check connection
		// if ($conn->connect_error) {
		// 	die("Connection failed: " . $conn->connect_error);
		// } 
		
		// // ******** update your personal settings ******** 
		// $sql = "SELECT * FROM book";	// Set up your SQL query
		// $result = $conn->query($sql);	// Send SQL Query
		// if ($result->num_rows > 0) {
		// 	// Output data of each row
		// 	while($row = $result->fetch_assoc()) {
		// 		echo "<tr>";
		// 		echo "<td>" . $row["ISBN"] . "</td>";
		// 		echo "<td>" . $row["BookTitle"] . "</td>";
		// 		echo "<td>" . $row["Author"] . "</td>";
		// 		echo "<td>" . $row["Publisher"] . "</td>";
		// 		echo "<td><a href='update.php?ISBN=".$row["ISBN"]."'>編輯</a></td>";
		// 		echo "<td><a href=\"delete.php?ISBN=".$row["ISBN"]."\">刪除</a></td>";
		// 		echo "</tr>";
		// 	}
		// } else {
		// 	echo "<tr><td colspan='6'>0 結果</td></tr>";
		// }
	?>