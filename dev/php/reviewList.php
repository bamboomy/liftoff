<?
	if($result->num_rows > 0){
		
		$appCounter = 0;
		
		$reviewCounter = 0;
		
		$oldAppId = -1;
		
		while($row = $result->fetch_assoc()){
			
			$app[$reviewCounter]['id'] 		= $row['id'];
			$app[$reviewCounter]['appid'] 	= $row['appid'];
			
			$reviewCounter++;
			
			if($oldAppId !== $row['appid']){

				$reviewCounter = 0;
				
				$oldAppId = $row['appid'];
				
				$appz[$appCounter++] = $app;
			}
		}

		foreach($appz as $app){
			
		
			$sql2 = "SELECT `id`, `appUrl`, `sentence`, `title`, `src`, `genre`, ownerName FROM `reviewCandidate` WHERE id = (";
			$sql2 .= "SELECT `reviewCandidateId` FROM `app` WHERE `id`=".$app[0]['id'].")";
			
			$result2 = $conn->query($sql2);
			
			if($result2->num_rows == 0){
				//2DO: ERROR HANDLING
				echo "no reviewCandidates";
				die;
			}
			
			$row2 = $result2->fetch_assoc()
?>
									<br/>
									<div class="row">
										<div class="col-sm-1"></div>
										<div class="col-sm-11">
											<div class="row">
												<div class="col-sm-2"><? echo "<img src='".$row2['src']."' width='100' height='100' />";?></div>
												<div class="col-sm-8">
													<div class="row">
														<div class="col-sm-12">
															<h4><?php echo $row2['title']." by ".$row2['ownerName']; ?></h4>
														</div>
													</div>
													<div class="row">
														<div class="col-sm-12">
															<p><? echo $row2['genre']; ?></p>
														</div>
													</div>
													<div class="row">
														<div class="col-sm-12">
															<p><? echo $row2['sentence']; ?></p>
														</div>
													</div>
												</div>
												<div class="col-sm-2"></div>
											</div>
										</div>
									</div>
<?			

			$sql3 = "SELECT `id`, `appid`, `text`, `pro0`, `con0`, `pro1`, `con1`, `pro2`, `con2`";
			$sql3 .= " FROM `review` WHERE appid=".$app[0]['id']." and `ownerId`=".$_SESSION['id'];
			
			$result3 = $conn->query($sql3);
		
			if($result3->num_rows == 0){
				//2DO: ERROR HANDLING
				echo "no reviews";
				die;
			}

			$reviewCounter = 0;
			
			while($row3 = $result3->fetch_assoc()){
?>			
									<br/>
									<div class="row">
										<div class="col-sm-1"></div>
										<div class="col-sm-11">
											<div class="row">
												<div class="col-sm-2">
													<? echo "<a class='btn btn-primary' data-toggle='collapse' href='#review_need_admin_".$app[0]['id']."_".$reviewCounter."'>Review by ".$_SESSION['login_user']."</a>"; ?>
												</div>
												<div class="col-sm-10"></div>
											</div>
										</div>
									</div>
									<br/>
									<div class="row">
										<div class="col-sm-1"></div>
										<div class="col-sm-11">
										<? echo "<div class='collapse well' id='review_need_admin_".$app[0]['id']."_".$reviewCounter."'>"; ?>
											<div class="row">
												<div class="col-sm-2">
													Review by <?echo $_SESSION['login_user']; ?><br/>
													<br/>
												</div>
												<div class="col-sm-8">
													<p><? echo nl2br($row3['text']); ?></p>
												</div>
												<div class="col-sm-2"></div>
											</div>
											<div class="row">
												<div class="col-sm-2"></div>
												<div class="col-sm-4">Pro</div>
												<div class="col-sm-4">Con</div>
												<div class="col-sm-2"></div>
											</div>
											<br/>
											<div class="row">
												<div class="col-sm-2"></div>
												<div class="col-sm-4"><p><? echo $row3['pro0']; ?></p></div>
												<div class="col-sm-4"><p><? echo $row3['con0']; ?></p></div>
												<div class="col-sm-2"></div>
											</div>
											<br/>
											<?
												if($row3['pro1'] !== "" || $row3['con1'] !== ""){
											?>
											<div class="row">
												<div class="col-sm-2"></div>
												<?
													if($row3['pro1'] !== ""){
												?>
												<div class="col-sm-4"><p><? echo $row3['pro1']; ?></p></div>
												<?
													}else{
												?>
												<div class="col-sm-4"></div>
												<?
													}
													if($row3['con1'] !== ""){
												?>
												<div class="col-sm-4"><p><? echo $row3['con1']; ?></p></div>
												<?
													}else{
												?>
												<div class="col-sm-4"></div>
												<?
													}
												?>
												<div class="col-sm-2"></div>
											</div>
											<br/>
											<?
												}
											?>
											<?
												if($row3['pro2'] !== "" || $row3['con2'] !== ""){
											?>
											<div class="row">
												<div class="col-sm-2"></div>
												<?
													if($row3['pro2'] !== ""){
												?>
												<div class="col-sm-4"><p><? echo $row3['pro2']; ?></p></div>
												<?
													}else{
												?>
												<div class="col-sm-4"></div>
												<?
													}
													if($row3['con2'] !== ""){
												?>
												<div class="col-sm-4"><p><? echo $row3['con2']; ?></p></div>
												<?
													}else{
												?>
												<div class="col-sm-4"></div>
												<?
													}
												?>
												<div class="col-sm-2"></div>
											</div>
											<br/>
											<?
												}
											?>
											<div class="row">
												<div class="col-sm-2"></div>
												<div class="col-sm-8">
												</div>
												<div class="col-sm-2">
													<button type="submit" class="btn btn-primary" id="submitReview" disabled="disabled">Edit</button>
												</div>
											</div>	
										</div>	
									</div>	
								</div>	
<?		
				$reviewCounter++;
			}
		}
	}
?>