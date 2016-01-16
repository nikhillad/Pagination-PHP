<?php
	//Pagination class

	//Author : Nikhil Lad
	//Email : mail@nikhillad.com
	//Date : 25th January 2015	
	//version : 1.1

	class pagination
	{
		public $records_per_page;
		public $query;
		public $total_records;
		public $db_connection;
		public $page;
		public $render_mode;
		public $js_call_function;
			

		//render pagination links
		public function render(callback_link = '')
		{	
			//get total records
			$total_records = $this->getTotalRecords();

			//get records per page
			$records_per_page = $this->getRecordsPerPage();

			//show pagination only if total number of records is greater than records per page
			if($total_records > $records_per_page)
			{
				?>
				<link href="css/bootstrap.min.css" rel="stylesheet">

				<style type="text/css">
					#pagination-js-nav a:hover {
						cursor: pointer;
					}
				</style>
				<?php	

				//total links per view
				$totalLinks = 10;

				//get page
				$page = $this->getPage();

				//calculate total pages
				$total_pages = ceil($total_records / $records_per_page);

				//first page
				$first_page = 1;
				$last_page = $total_pages;

				//get render mode
				$render_mode = $this->getRenderMode();

				if($render_mode == 'PHP')
				{
					if($callback_link != '')
						$_PHP_SELF = $callback_link;
					else
						$_PHP_SELF = $_SERVER['PHP_SELF'];

					//if number of pages is less than the nunber of max links per view
					if($total_pages < $totalLinks)
					{
						if($page == 1)
						{
							echo '<nav>
								  <ul class="pagination">
								    <li class="disabled">
								      <a href="#" aria-label="Previous">
								        <span aria-hidden="true">&laquo;</span>
								      </a>
								    </li>';
						}
						else 
						{
							echo '<nav>
								  <ul class="pagination">
								    <li>
								      <a href="'.$_PHP_SELF.'?page='.($page - 1).'" aria-label="Previous">
								        <span aria-hidden="true">&laquo;</span>
								      </a>
								    </li>';
						}	

						for($i=1;$i<=$total_pages;$i++)
						{
							if($page == $i)
								echo '<li class="active"><a href="'.$_PHP_SELF.'?page='.$i.'">'.$i.'</a></li>';
							else	
								echo '<li><a href="'.$_PHP_SELF.'?page='.$i.'">'.$i.'</a></li>';	
						}

						if($page == $last_page)
						{
							echo '<li class="disabled">
								      <a href="#" aria-label="Next">
								        <span aria-hidden="true">&raquo;</span>
								      </a>
								    </li>
								  </ul>
								</nav>';
						}
						else
						{
							echo '<li>
								      <a href="'.$_PHP_SELF.'?page='.($page + 1).'" aria-label="Next">
								        <span aria-hidden="true">&raquo;</span>
								      </a>
								    </li>
								  </ul>
								</nav>';
						}	
					}
					else
					{	
						//check the page number to decide whether to load next page links to view or not
						if($page < 7)
						{
							if($page == 1)
							{
								echo '<nav>
									  <ul class="pagination">
									    <li class="disabled">
									      <a href="#" aria-label="Previous">
									        <span aria-hidden="true">&laquo;</span>
									      </a>
									    </li>';
							}
							else 
							{
								echo '<nav>
									  <ul class="pagination">
									    <li>
									      <a href="'.$_PHP_SELF.'?page='.($page - 1).'" aria-label="Previous">
									        <span aria-hidden="true">&laquo;</span>
									      </a>
									    </li>';
							}	

							//render links
							for($i=1;$i<=$totalLinks;$i++)
							{
								if($page == $i)
									echo '<li class="active"><a href="'.$_PHP_SELF.'?page='.$i.'">'.$i.'</a></li>';
								else	
									echo '<li><a href="'.$_PHP_SELF.'?page='.$i.'">'.$i.'</a></li>';	
							}

							echo '<li><a>...</a></li>';

							echo '<li><a href="'.$_PHP_SELF.'?page='.$last_page.'">'.$last_page.'</a></li>';

							if($page == $last_page)
							{
								echo '<li class="disabled">
									      <a href="#" aria-label="Next">
									        <span aria-hidden="true">&raquo;</span>
									      </a>
									    </li>
									  </ul>
									</nav>';
							}
							else
							{
								echo '<li>
									      <a href="'.$_PHP_SELF.'?page='.($page + 1).'" aria-label="Next">
									        <span aria-hidden="true">&raquo;</span>
									      </a>
									    </li>
									  </ul>
									</nav>';
							}	
						}
						else
						{
							if($page == 1)
							{
								echo '<nav>
									  <ul class="pagination">
									    <li class="disabled">
									      <a href="#" aria-label="Previous">
									        <span aria-hidden="true">&laquo;</span>
									      </a>
									    </li>';
							}
							else 
							{
								echo '<nav>
									  <ul class="pagination">
									    <li>
									      <a href="'.$_PHP_SELF.'?page='.($page - 1).'" aria-label="Previous">
									        <span aria-hidden="true">&laquo;</span>
									      </a>
									    </li>';
							}	

							echo '<li><a href="'.$_PHP_SELF.'?page=1">1</a></li>';
							echo '<li><a>...</a></li>';

							//set max 3 visible links towards left of current page link
							for($i=$page-3;$i<=$page;$i++)
							{
								if($page == $i)
									echo '<li class="active"><a href="'.$_PHP_SELF.'?page='.$i.'">'.$i.'</a></li>';
								else	
									echo '<li><a href="'.$_PHP_SELF.'?page='.$i.'">'.$i.'</a></li>';	
							}

							//show all the remaining links
							if($page >= $total_pages - 5)
							{
								for($i=$page+1;$i<=$total_pages;$i++)
								{
									if($page == $i)
										echo '<li class="active"><a href="'.$_PHP_SELF.'?page='.$i.'">'.$i.'</a></li>';
									else	
										echo '<li><a href="'.$_PHP_SELF.'?page='.$i.'">'.$i.'</a></li>';	
								}
							}
							//set max 3 visible links towards right of the current page link
							else
							{
								for($i=$page+1;$i<=$page+3;$i++)
								{
									if($page == $i)
										echo '<li class="active"><a href="'.$_PHP_SELF.'?page='.$i.'">'.$i.'</a></li>';
									else	
										echo '<li><a href="'.$_PHP_SELF.'?page='.$i.'">'.$i.'</a></li>';	
								}

								echo '<li><a>...</a></li>';
								echo '<li><a href="'.$_PHP_SELF.'?page='.$last_page.'">'.$last_page.'</a></li>';
							}

							if($page == $last_page)
							{
								echo '<li class="disabled">
									      <a href="#" aria-label="Next">
									        <span aria-hidden="true">&raquo;</span>
									      </a>
									    </li>
									  </ul>
									</nav>';
							}
							else
							{
								echo '<li>
									      <a href="'.$_PHP_SELF.'?page='.($page + 1).'" aria-label="Next">
									        <span aria-hidden="true">&raquo;</span>
									      </a>
									    </li>
									  </ul>
									</nav>';
							}	
						}
					}
				}
				else if($render_mode == 'JS')
				{
					$js_call_function = $this->getJSCallFunction();

					//if number of pages is less than the nunber of max links per view
					if($total_pages < $totalLinks)
					{
						if($page == 1)
						{
							echo '<nav id="pagination-js-nav">
								  <ul class="pagination">
								    <li class="disabled">
								      <a href="#" aria-label="Previous">
								        <span aria-hidden="true">&laquo;</span>
								      </a>
								    </li>';
						}
						else 
						{
							echo '<nav id="pagination-js-nav">
								  <ul class="pagination">
								    <li>
								      <a onclick="'.$js_call_function.'('.($page - 1).')" aria-label="Previous">
								        <span aria-hidden="true">&laquo;</span>
								      </a>
								    </li>';
						}	

						for($i=1;$i<=$total_pages;$i++)
						{
							if($page == $i)
								echo '<li class="active"><a onclick="'.$js_call_function.'('.$i.')">'.$i.'</a></li>';
							else	
								echo '<li><a onclick="'.$js_call_function.'('.$i.')">'.$i.'</a></li>';	
						}

						if($page == $last_page)
						{
							echo '<li class="disabled">
								      <a href="#" aria-label="Next">
								        <span aria-hidden="true">&raquo;</span>
								      </a>
								    </li>
								  </ul>
								</nav>';
						}
						else
						{
							echo '<li>
								      <a onclick="'.$js_call_function.'('.($page + 1).')" aria-label="Next">
								        <span aria-hidden="true">&raquo;</span>
								      </a>
								    </li>
								  </ul>
								</nav>';
						}	
					}
					else
					{	
						//check the page number to decide whether to load next page links to view or not
						if($page < 7)
						{
							if($page == 1)
							{
								echo '<nav id="pagination-js-nav">
									  <ul class="pagination">
									    <li class="disabled">
									      <a href="#" aria-label="Previous">
									        <span aria-hidden="true">&laquo;</span>
									      </a>
									    </li>';
							}
							else 
							{
								echo '<nav id="pagination-js-nav">
									  <ul class="pagination">
									    <li>
									      <a onclick="'.$js_call_function.'('.($page - 1).')" aria-label="Previous">
									        <span aria-hidden="true">&laquo;</span>
									      </a>
									    </li>';
							}	

							//render links
							for($i=1;$i<=$totalLinks;$i++)
							{
								if($page == $i)
									echo '<li class="active"><a onclick="'.$js_call_function.'('.$i.')">'.$i.'</a></li>';
								else	
									echo '<li><a onclick="'.$js_call_function.'('.$i.')">'.$i.'</a></li>';	
							}

							echo '<li><a>...</a></li>';

							echo '<li><a onclick="'.$js_call_function.'('.$last_page.')">'.$last_page.'</a></li>';

							if($page == $last_page)
							{
								echo '<li class="disabled">
									      <a href="#" aria-label="Next">
									        <span aria-hidden="true">&raquo;</span>
									      </a>
									    </li>
									  </ul>
									</nav>';
							}
							else
							{
								echo '<li>
									      <a onclick="'.$js_call_function.'('.($page + 1).')" aria-label="Next">
									        <span aria-hidden="true">&raquo;</span>
									      </a>
									    </li>
									  </ul>
									</nav>';
							}	
						}
						else
						{
							if($page == 1)
							{
								echo '<nav id="pagination-js-nav">
									  <ul class="pagination">
									    <li class="disabled">
									      <a href="#" aria-label="Previous">
									        <span aria-hidden="true">&laquo;</span>
									      </a>
									    </li>';
							}
							else 
							{
								echo '<nav id="pagination-js-nav">
									  <ul class="pagination">
									    <li>
									      <a onclick="'.$js_call_function.'('.($page - 1).')" aria-label="Previous">
									        <span aria-hidden="true">&laquo;</span>
									      </a>
									    </li>';
							}	

							echo '<li><a onclick="'.$js_call_function.'(1)">1</a></li>';
							echo '<li><a>...</a></li>';

							//set max 3 visible links towards left of current page link
							for($i=$page-3;$i<=$page;$i++)
							{
								if($page == $i)
									echo '<li class="active"><a onclick="'.$js_call_function.'('.$i.')">'.$i.'</a></li>';
								else	
									echo '<li><a onclick="'.$js_call_function.'('.$i.')">'.$i.'</a></li>';	
							}

							//show all the remaining links
							if($page >= $total_pages - 5)
							{
								for($i=$page+1;$i<=$total_pages;$i++)
								{
									if($page == $i)
										echo '<li class="active"><a onclick="'.$js_call_function.'('.$i.')">'.$i.'</a></li>';
									else	
										echo '<li><a onclick="'.$js_call_function.'('.$i.')">'.$i.'</a></li>';	
								}
							}
							//set max 3 visible links towards right of the current page link
							else
							{
								for($i=$page+1;$i<=$page+3;$i++)
								{
									if($page == $i)
										echo '<li class="active"><a onclick="'.$js_call_function.'('.$i.')">'.$i.'</a></li>';
									else	
										echo '<li><a onclick="'.$js_call_function.'('.$i.')">'.$i.'</a></li>';	
								}

								echo '<li><a>...</a></li>';
								echo '<li><a onclick="'.$js_call_function.'('.$last_page.')">'.$last_page.'</a></li>';
							}

							if($page == $last_page)
							{
								echo '<li class="disabled">
									      <a href="#" aria-label="Next">
									        <span aria-hidden="true">&raquo;</span>
									      </a>
									    </li>
									  </ul>
									</nav>';
							}
							else
							{
								echo '<li>
									      <a onclick="'.$js_call_function.'('.($page + 1).')" aria-label="Next">
									        <span aria-hidden="true">&raquo;</span>
									      </a>
									    </li>
									  </ul>
									</nav>';
							}	
						}
					}
				}
			}
		}


		//records_per_page setter
		public function setRecordsPerPage($value)
		{
			$this->records_per_page = $value;
		}

		//records_per_page getter
		public function getRecordsPerPage()
		{
			return $this->records_per_page;
		}

		//query setter
		public function setQuery($value)
		{
			$this->query = $value;
		}

		//query getter
		public function getQuery()
		{
			return $this->query;
		}

		//total_records setter
		public function setTotalRecords($value)
		{
			$this->total_records = $value;
		}

		//total_records getter
		public function getTotalRecords()
		{
			return $this->total_records;
		}

		//set db connection PDO
		public function setDBConnection($value)
		{
			$this->db_connection = $value;	
		}

		//get db connection PDO
		public function getDBConnection()
		{
			return $this->db_connection;
		}

		//set page number
		public function setPage($value)
		{
			$this->page = $value;
		}

		//get page number
		public function getPage()
		{
			return $this->page;
		}

		//set render_mode
		public function setRenderMode($value)
		{
			$this->render_mode = $value;
		}

		//get render_mode
		public function getRenderMode()
		{
			return $this->render_mode;
		}

		//set js_call_function
		public function setJSCallFunction($value)
		{
			$this->js_call_function = $value;
		}

		//get js_call_function
		public function getJSCallFunction()
		{
			return $this->js_call_function;
		}
	}
	
?>
