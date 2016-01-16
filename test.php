<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>

<body>
<div class="container">
	<div class="row">
		<div class="col-md-12">
		<?php

			//include database config file (as your database configuration or query method doesnt make any differance to this pagination class,
			// hence i have not inlcuded my database configuration file in this repository)
			include('config.php');

			//include pagination class
			include('pagination/pagination.php');

			//create an object of a pagination class
			$pagination = new pagination();

			//set number of records per page
			$pagination->setRecordsPerPage(10);

			//set links call method (PHP for simple full callback or JS for javascript function call (in case your fetching data using ajax))
			$pagination->setRenderMode('PHP');
			// $pagination->setRenderMode('JS');

			//set javascript function name (function which you call for fetching data using ajax (if you dont have used any function, 
			//it is mendatory to use one for using this class))
			// $pagination->setJSCallFunction('loadData');

			//get page number if its been ser in URL 
			if(isset($_GET['page']))
				$page = $_GET['page'];
			else
				$page = 1;

			//set page number
			$pagination->setPage($page);

			//provide pagination class a total number of records(use count(*) query)
			$stmt = $db->prepare('select count(*) from songs');
			$res = $stmt->execute();
			$total_rows = $stmt->fetch(PDO::FETCH_ASSOC);

			//set number of total records
			$pagination->setTotalRecords($total_rows['count(*)']);

			//calculate offset (copy and paste this to your code)
			$offset = ($page - 1) * $pagination->getRecordsPerPage();

			//get actual data (use any type of SQL query you want and just append offset parameter to it as shown below)
			$stmt = $db->prepare('SELECT * FROM songs LIMIT '.$offset.','.$pagination->getRecordsPerPage());

			$res = $stmt->execute();

			$arrSongs = $stmt->fetchAll(PDO::FETCH_ASSOC);

			echo '<h1>Songs</h1>';
			echo '<table class="table table-hover">';

			foreach ($arrSongs as $key => $value) {
				echo '<tr><td>'.$value['song'].'</td></tr>';
			}

			echo '</table>';

		?>
		<!-- You can send optional call back link as a parameter to below render function -->
		<!-- this link will be assigned to the pagination buttons as 'href' with '?page=<page_no>' appended -->
		<!-- If you do not send any link to it, class will take PHP_SELF as a link. -->
		<!-- Example: $pagination->render('mywebsite.com/mypage/list') 
				this will generate link like - mywebsite.com/mypage/list?page=<page_no> and
				assing it to pagination buttons -->
				 
		<?php echo $pagination->render(); ?>
		</div>
	</div>
</div>
</body>
</html>			