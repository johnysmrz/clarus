<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" dir="ltr">
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <link rel="StyleSheet" href="/css/admin.css" type="text/css" media="screen"></link>
        <script type="text/javascript" src="/js/jquery-1.4.4.min.js"></script>
        <title>admin - login</title>
    </head>
    <body>
        <div id="loginBox">
            <object id="loginClarusLogo" data="/img/admin/clarus.svg" codetype="image/svg+xml" style="width: 150px;"></object>
            <?php echo $this->getTplVar('form')->display() ?>
        </div>
    </body>
</html>