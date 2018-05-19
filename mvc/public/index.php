<?php
	require '../vendor/autoload.php';
	session_start();
	Toro::serve(array(
	    "/" => "\Controller\IndexController",
	    "/home" => "\Controller\HomeController",
	    "/top" => "\Controller\TopController",
	    "/login" => "\Controller\LoginController",
	    "/logout" => "\Controller\LogoutController",
	    "/discuss/:number" => "\Controller\ThreadController",
	    "/comment/:number" => "\Controller\CommentsController",
	    "/new" => "\Controller\NewController",
	    "/likelink/:number" => "\Controller\LinkLikeController",
	    "/unlikelink/:number" => "\Controller\LinkUnlikeController",
	    "/likecomment/:number/:number" => "\Controller\CommentLikeController",
	    "/unlikecomment/:number/:number" => "\Controller\CommentUnlikeController",
	    "/user/:alpha" => "\Controller\UserController",
	    "/follow/:alpha" => "\Controller\FollowController",
	    "/unfollow/:alpha" => "\Controller\UnfollowController",
	    "/tag/:alpha" => "\Controller\TagController",
	));
