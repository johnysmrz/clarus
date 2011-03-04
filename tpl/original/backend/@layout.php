<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" dir="ltr">
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <link rel="StyleSheet" href="/css/admin.css" type="text/css" media="screen"></link>
        <script type="text/javascript" src="/js/jquery-1.4.4.min.js"></script>
        <title>admin - {$pageTitle}</title>
    </head>
    <body>
        <div id="topBox">
            <div class="inner">
                <div id="searchBox">
                    <input type="text" id="searchText" />
                </div>
                <a href="/admin/logout" id="logout"></a>
            </div>
        </div>
        <div id="mainBox">
            <div id="midBox">
                <div id="menuBox">
                    <div class="inner">
                        <ul id="mainMenu">
                            <li>
                                <a class="tree" href="/admin/tree">Strom stránek<span>prehled stromu stranek</span></a>
                                <ul>
                                    <li><a href="/admin/tree/overview">Přehled<span>prehled stromu stranek</span></a></li>
                                    <li><a href="/admin/tree/new">Nový<span>přidat nový lístek</span></a></li>
                                </ul>
                            </li>
                            <li>
                                <a class="book" href="/admin/tree">Články<span>přehled článků, správa, zvežejňování a verzování</span></a>
                                <ul>
                                    <li><a href="/admin/tree/overview">Přehled<span>prehled stromu stranek</span></a></li>
                                    <li><a href="/admin/tree/new">Nový<span>přidat nový lístek</span></a></li>
                                </ul>
                            </li>
                            <li>
                                <a class="users" href="/admin/tree">Uživatelé<span>správa uživatelů, jejich skupin, oprávnění a přístupů</span></a>
                                <ul>
                                    <li><a href="/admin/tree/overview">Přehled<span>prehled stromu stranek</span></a></li>
                                    <li><a href="/admin/tree/new">Nový<span>přidat nový lístek</span></a></li>
                                </ul>
                            </li>
                            <li>
                                <a class="settings" href="/admin/tree">Nastavení<span>správa uživatelů frontendu i backendu</span></a>
                                <ul>
                                    <li><a href="/admin/tree/overview">Přehled<span>prehled stromu stranek</span></a></li>
                                    <li><a href="/admin/tree/new">Nový<span>přidat nový lístek</span></a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                <div id="contentBox">
                    <div class="inner">
                        {content}
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#mainMenu > li > a").mouseenter(function(){
                        $("#mainMenu > li > ul > li:visible").not($(this).parent().find("ul > li")).slideUp(100);
                        $(this).parent().find('ul > li').slideDown(100);
                })
            })
        </script>
    </body>
</html>