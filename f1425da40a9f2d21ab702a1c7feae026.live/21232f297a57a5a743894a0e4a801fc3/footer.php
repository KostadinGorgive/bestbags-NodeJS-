			</div>
			<div id="copyright">
				Major 2021<br/>
				<?php
				$mtime = explode(' ', microtime());
				$totaltime = $mtime[0] + $mtime[1] - $starttime;
				printf('Page loaded in %.3f seconds.', $totaltime);
				?>
			</div>
		</div>
	</body>
</html>
<?php
	$db->close();
?>