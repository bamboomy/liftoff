<script src="../js/nav.js"></script>

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span> 
      </button>
      <a class="navbar-brand" href="#">Android Liftoff</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#services">App list</a></li>
        <li><a href="#about">The System</a></li>
        <li><a href="#contact">Contact</a></li>
<?
	if(isset($_SESSION['login_user'])){
		//whenever changing this code change the code in m.js as well...
?>
		<li class="dropdown" id='login'>
			<? echo "<a data-toggle='dropdown' class='dropdown-toggle' href='#'>".$_SESSION['login_user']; ?>
			<b class="caret"></b>
			</a>
			<ul class="dropdown-menu">
				<li><a href="toBeReviewedList.php">Review an app</a></li>
				<li><a href="#">Submit an app</a></li>
				<li><a href="crib.php">Crib</a></li>
				<li class="divider"></li>
				<li><a href="#" onclick="logout();">Log out</a></li>
			</ul>
		</li>
<?
	}else{
		echo "<li id='login'><a href='#loginModal' data-toggle='modal'>Log in/register</a></li>";
	}
?>
      </ul>
    </div>
  </div>
</nav>

<!-- Modal -->
<div id="welcomeModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Welcome :)</h4>
      </div>
      <div class="modal-body">
		<p id="welcome"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- Modal -->
<div id="logoutModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Goodbye!!!</h4>
      </div>
      <div class="modal-body">
		<p>You are logged out.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- Modal -->
<div id="loginModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Login/register</h4>
      </div>
      <div class="modal-body">
		<div class="row">
			<div class="col-sm-1"></div>
			<div class="col-sm-4">username/e-mail:</div>
			<div class="col-sm-5">
				<input type="text" class="pull-right" id="username" />
			</div>
			<div class="col-sm-2"></div>
		</div>
		<div class="row">
			<div class="col-sm-1"></div>
			<div class="col-sm-4">password:</div>
			<div class="col-sm-5">
				<input type="password" class="pull-right" id="password"/>
			</div>
			<div class="col-sm-2"></div>
		</div>
		<div class="row">
			<div class="col-sm-5"></div>
			<div class="col-sm-5">
				<span class="red pull-right" id="error"></span>
			</div>
			<div class="col-sm-2"></div>
		</div>
		<div class="row">
			<div class="col-sm-5"></div>
			<div class="col-sm-5">
				<button class="btn btn-default pull-right" onclick="login();">Login</button>
			</div>
			<div class="col-sm-2"></div>
		</div>
		<br/>
		<div class="row">
			<form class="form-inline" id="subscribeAppForm" action="register_app.php" method="post">
				<div class="col-sm-2"></div>
				<div class="col-sm-8">
					<input type="app" class="form-control subscribe" size="50" 
						placeholder="https://play.google.com/store/apps/details?id=" 
						id="appurl" name="appurl" />
				</div>
				<div class="col-sm-2"></div>
			</form>
		</div>
		<div class="row">
			<div class="col-sm-8"></div>
			<div class="col-sm-2"><button type="submit" class="btn btn-primary" id="register_app" disabled="disabled">Register app</button><br/></div>
			<div class="col-sm-2"></div>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>