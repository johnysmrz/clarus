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
        <a class="users" href="/admin/tree">{_ Users}<span>{_ users agenda, rights, acces privilegies and groups}</span></a>
        <ul>
            <li><a href="/admin/tree/overview">Přehled<span>prehled stromu stranek</span></a></li>
            <li><a href="/admin/tree/new">Nový<span>přidat nový lístek</span></a></li>
        </ul>
    </li>
    <li>
        <a class="settings" href="/admin/tree">{_ Setting}<span>{_ global application setting}</span></a>
        <ul>
            <li><a href="/admin/tree/overview">Přehled<span>prehled stromu stranek</span></a></li>
            <li><a href="/admin/tree/new">Nový<span>přidat nový lístek</span></a></li>
        </ul>
    </li>
</ul>
<script type="text/javascript">
    $(document).ready(function(){
        $("#mainMenu > li > a").mouseenter(function(){
            $("#mainMenu > li > ul > li:visible").not($(this).parent().find("ul > li")).slideUp(100);
            $(this).parent().find('ul > li').slideDown(100);
        })
    })
</script>