# Pagination-PHP
An easy to implement pagination class in PHP which also supports ajax call function as a target for paginations links  

Steps to integrate :

1) Include pagination.php file in your code

2) Create a object of pagination class

3) Pass the required parameters to the class as shown in test.php file

4) Thats It ! Render your pagination links.

Features : 

	1) This pagination class also supports a call to JavaScript function as a target of pagination links; in case your using ajax call for fetching the data.
	
	2) If you want to set js function as an action to pagination links, just pass your function name to JSCallFunction function and set render mode as 'JS'.
		E.g. 
			setRenderMode('JS')
			$pagination->setJSCallFunction('loadData');

		Note : Don't mention brackets for function. they will be added automatically.
	3) If you want to use direct callback link, then just pass 'PHP' to JSCallFunction function, or dont call it at all. class will automatically pick PHP as a method.

	4) In PHP callback link case, you can also pass optional actual web link to the function render() while rendering the pagination links. if you dont pass the link, class will pick PHP_SELF as a link and will create result link by appending '?page=<page_no>' to it.

	5) For styling the pagination links Bootstrap classes have been used. you can customize style by editing that css sheets or replacing them.		
		
Sample Code :

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
		
Enjoy!
