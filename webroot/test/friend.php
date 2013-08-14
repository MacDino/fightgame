<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>测试好友</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<p center>添加好友</p>
<form method="GET" action="http://kaedezyf.dev.bs.com/friend/createFriend.php" name="createFriend">
<input align="left" id="user_id" name="user_id" value="">用户ID
<input align="left" id="friend_id" name="friend_id" value="">好友ID
<input type="submit" value="提交">
</form>

<p center>删除好友</p>
<form method="GET" action="http://kaedezyf.dev.bs.com/friend/deteleFriend.php" name="deteleFriend">
<input align="left" id="user_id" name="user_id" value="">用户ID
<input align="left" id="friend_id" name="friend_id" value="">好友ID
<input type="submit" value="提交">
</form>

<p center>显示好友列表</p>
<form method="GET" action="http://kaedezyf.dev.bs.com/friend/listFriend.php" name="listFriend">
<input align="left" id="user_id" name="user_id" value="">用户ID
<input type="submit" value="提交">
</form>