<?php
require("./header.php");
if ($checkLogin) {
	$sql = "SELECT count(*) FROM `".TABLE_ADS."`";
	$totalRecordsAds = $db->query_first($sql);
	$totalRecordsAds = $totalRecordsAds["count(*)"];
	$perPageAds = 10;
	$totalPageAds = ceil($totalRecordsAds/$perPageAds);
	if (isset($_GET["pageAds"])) {
		$pageAds = $db->escape($_GET["pageAds"]);
		if ($pageAds < 1)
		{
			$pageAds = 1;
		}
		else if ($pageAds > $totalPageAds)
		{
			$pageAds = 1;
		}
	}
	else
	{
		$pageAds = 1;
	}
	$sql = "SELECT * FROM `".TABLE_ADS."` ORDER BY ad_time DESC,ad_id DESC LIMIT ".(($pageAds-1)*$perPageAds).",".$perPageAds;
	$recordsAds = $db->fetch_all_array($sql);

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
	$sql = "SELECT ".TABLE_NEWS.".*, ".TABLE_USERS.".user_id, ".TABLE_USERS.".user_name FROM `".TABLE_NEWS."` LEFT JOIN `".TABLE_USERS."` ON ".TABLE_NEWS.".news_author = ".TABLE_USERS.".user_id ORDER BY ".TABLE_NEWS.".news_time  DESC,".TABLE_NEWS.".news_id DESC LIMIT ".(($page-1)*$perPage).",".$perPage;
	$records = $db->fetch_all_array($sql);
?>
				<div id="news">
					<div class="page-title">NEWS</div>
					    </br>
					<p style="text-align:center;color:red;">WEB: <a>MAJORCC.SHOP MAJORCC.STORE MAJORCC.RU</a></p>
					<p style="text-align:center;color:red;">TOR: <a>xktoxobz3jv6epntuj5ws7nc6zuihfroxziprd5np5xkbby4nzmmmiyd.onion</a></p>
					<div class="section_page_bar">
<?php
	if ($totalRecords > 0) {
		echo "Page:";
		if ($page>1) {
			echo "<a href=\"?page=".($page-1)."&pageAds=".$pageAds."\">&lt;</a>";
			echo "<a href=\"?page=1&pageAds=".$pageAds."\">1</a>";
		}
		if ($page>3) {
			echo "...";
		}
		if (($page-1) > 1) {
			echo "<a href=\"?page=".($page-1)."&pageAds=".$pageAds."\">".($page-1)."</a>";
		}
		echo "<input type=\"TEXT\" class=\"page_go\" value=\"".$page."\" onchange=\"window.location.href='?page='+this.value+'&pageAds=".$pageAds."'\"/>";
		if (($page+1) < $totalPage) {
			echo "<a href=\"?page=".($page+1)."&pageAds=".$pageAds."\">".($page+1)."</a>";
		}
		if ($page < $totalPage-2) {
			echo "...";
		}
		if ($page<$totalPage) {
			echo "<a href=\"?page=".$totalPage."&pageAds=".$pageAds."\">".$totalPage."</a>";
			echo "<a href=\"?page=".($page+1)."&pageAds=".$pageAds."\">&gt;</a>";
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

						<div class="new-box">
							<div class="title"><?=$value['news_title']?></div>
							<p><?=$value['news_content']?></p>
							<div class="news-info"><?=date("d/M/Y", $value['news_time'])?> by <span class="bold"><?=$value['user_name']?></div>

						</div>

<?php
		}
	}else {
?>

				<div class="news_title">
					<span class="red">No record found.</span>
				</div>

<?php
	}
?>
					</div>
				</div>
<?php
}else {
	require("./minilogin.php");
}
require("./footer.php");
?>