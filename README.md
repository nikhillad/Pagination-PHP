# Pagination-PHP
A pagination class in PHP which supports ajax call support as well

Steps to integrate :
1) Include pagination.php file in your code

2) Create a object of pagination class

3) Pass the required parameters to the class as shown in test.php file

4) Thats It ! Render your pagination links.

Features : 

	1) This pagination class also supports a call to JavaScript function as target of pagination links; in case your using ajax call for 
	fetching the data.
	
	2) In that case just set render mode as 'JS' and set the JavaScript function name to be called. 
		E.g. setRenderMode('JS')
		Note : Don't mention brackets for function. they will be added automatically.
	
	3) For styling the pagination links Twitter Bootstrap classes have been used. you can customise style by editing that css sheets.		
		
