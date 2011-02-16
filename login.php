<?php
require("./header.php");
if ($checkLogin) {
?>
			<script type="text/javascript">setTimeout("window.location = './'", 1000);</script>
			<div id="login_success">
				
				
			</div>
<?php
}
else {
	require("./minilogin.php");
}
require("./footer.php");
?>