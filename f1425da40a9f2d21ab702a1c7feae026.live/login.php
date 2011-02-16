<?php
require("./header.php");
if ($checkLogin) {
?>
			<script type="text/javascript">setTimeout("window.location = './21232f297a57a5a743894a0e4a801fc3'", 1000);</script>
			<div id="login_success">
				
				
			</div>
<?php
}
else {
	require("./minilogin.php");
}
require("./footer.php");
?>