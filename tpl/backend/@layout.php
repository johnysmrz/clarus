<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" dir="ltr">
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <link rel="StyleSheet" href="/css/admin.css" type="text/css" media="screen"></link>
        <script type="text/javascript" src="/js/jquery-1.4.4.min.js"></script>
        <title>{_ administration} - {$pageTitle}</title>
    </head>
    <body>
        <div id="topBox">
            <div class="inner">
                <div id="searchBox">
                    <input type="text" id="searchText" />
                </div>
                <div id="userInfoBox">
                    {_ Logged as}: <?php echo \clarus\security\autentification\User::get('secuirty_autentification_IBackendUser')->getUsername(); ?>
                    (<a id="userLogout" href="/admin/auth/logout">{_ Logout}</a>)
                </div>
            </div>
        </div>
        <div id="mainBox">
            <div id="midBox">
                <div id="menuBox">
                    <div class="inner">
                        <?php include_once(\clarus\templater\Templater::get(PATH_TPL.'/backend/menu.php')) ?>
                    </div>
                </div>
                <div id="contentBox">
                    <div class="inner">
                        {content}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>