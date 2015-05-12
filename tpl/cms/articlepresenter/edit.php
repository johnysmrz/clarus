{_ edit}
<?php

?>
<style type="text/css">
    div.cbTabSet > div.cbTab {
        border: 1px solid #B3B3B4;
        padding: 10px;
        background-color: #d9d8da;
    }

    div.cbTabSet > ul.cbTabHead {
        margin: 0px;
        padding: 0px;
        height: 25px;
    }

    div.cbTabSet > ul.cbTabHead > li {
        list-style: none;
        display: block;
        float: left;
        height: 25px;
    }

    div.cbTabSet > ul.cbTabHead > li > a {
        color: black;
        text-decoration: none;
        display: block;
        background-color: #f5f5f4;
        border-top: 1px solid #B3B3B4;
        border-left: 1px solid #B3B3B4;
        border-right: 1px solid #B3B3B4;
        height: 19px;
        padding: 3px 25px;
        -webkit-border-top-left-radius: 7px;
        -webkit-border-top-right-radius: 7px;
        -moz-border-radius-topleft: 7px;
        -moz-border-radius-topright: 7px;
        border-top-left-radius: 7px;
        border-top-right-radius: 7px;
        margin-right: 3px;
    }

    div.cbTabSet > ul.cbTabHead > li > a.active {
        background: -moz-linear-gradient(100% 100% 90deg, #d9d8da, #f5f5f4);
    }
</style>
<div class="cbTabSet">
    <ul class="cbTabHead">
        <li><a href="#prvni-tab">prvni tab</a></li>
        <li><a href="#druhy-tab">druhy tab</a></li>
        <li><a href="#treti-tab">treti tab</a></li>
    </ul>
    <div class="cbTab" title="#prvni-tab">
        Prvni. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris et lectus augue, non sodales diam. Donec consectetur suscipit interdum. Cras quis cursus odio. Suspendisse vitae mauris eros, quis malesuada erat. Etiam vitae quam diam, non imperdiet dui. In accumsan varius interdum. Praesent lorem lorem, aliquet vel porttitor sit amet, cursus ac dui. Fusce id dolor neque. Vestibulum vitae lacus nulla. Integer vitae enim ligula, in tristique tellus. Quisque lorem eros, aliquet vel commodo in, malesuada eget tellus. Maecenas eget mauris diam. Praesent fringilla leo ac nulla commodo sit amet rhoncus nulla bibendum. Vivamus cursus leo in lorem molestie sed consequat eros fringilla. Praesent vitae orci nec ante placerat auctor vitae quis ipsum.
    </div>
    <div class="cbTab" title="#druhy-tab">
        Druhy. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris et lectus augue, non sodales diam. Donec consectetur suscipit interdum. Cras quis cursus odio. Suspendisse vitae mauris eros, quis malesuada erat. Etiam vitae quam diam, non imperdiet dui. In accumsan varius interdum. Praesent lorem lorem, aliquet vel porttitor sit amet, cursus ac dui. Fusce id dolor neque. Vestibulum vitae lacus nulla. Integer vitae enim ligula, in tristique tellus. Quisque lorem eros, aliquet vel commodo in, malesuada eget tellus. Maecenas eget mauris diam. Praesent fringilla leo ac nulla commodo sit amet rhoncus nulla bibendum. Vivamus cursus leo in lorem molestie sed consequat eros fringilla. Praesent vitae orci nec ante placerat auctor vitae quis ipsum.
    </div>
    <div class="cbTab" title="#treti-tab">
        Treti. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris et lectus augue, non sodales diam. Donec consectetur suscipit interdum. Cras quis cursus odio. Suspendisse vitae mauris eros, quis malesuada erat. Etiam vitae quam diam, non imperdiet dui. In accumsan varius interdum. Praesent lorem lorem, aliquet vel porttitor sit amet, cursus ac dui. Fusce id dolor neque. Vestibulum vitae lacus nulla. Integer vitae enim ligula, in tristique tellus. Quisque lorem eros, aliquet vel commodo in, malesuada eget tellus. Maecenas eget mauris diam. Praesent fringilla leo ac nulla commodo sit amet rhoncus nulla bibendum. Vivamus cursus leo in lorem molestie sed consequat eros fringilla. Praesent vitae orci nec ante placerat auctor vitae quis ipsum.
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('div.cbTabSet > div.cbTab:nth-of-type(1n+2)').hide(0);
        $('ul.cbTabHead > li:first-child > a').addClass('active');
        $('ul.cbTabHead > li > a').click(function(){
            $(this).addClass('active');
            var href = $(this).attr('href');
            $('div.cbTabSet > div.cbTab').each(function(){
                if($(this).attr('title') == href) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
            $(this).parents('ul.cbTabHead').find('li').not($(this).parent()).each(function(){
                $(this).find('a').removeClass('active');
            });
        })
    });
</script>