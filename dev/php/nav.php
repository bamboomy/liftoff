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