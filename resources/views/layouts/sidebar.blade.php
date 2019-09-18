<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">
            <!--            <li class="header">MAIN NAVIGATION</li>-->
            <li class=""><a href="{{'home'}}"><i class="fas fa-tachometer-alt mr-5"></i><span>Dashboard</span></a></li>
            <li><a href="{{'user/user'}}"><i class="fa fa-user mr-3"></i><span>User</span></a></li>
            <li><a href="{{'content/content'}}"><i class="fa fa-file-text mr-3"></i><span>Content</span></a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
<script>
    (function ($) {
        // custom css expression for a case-insensitive contains()
        jQuery.expr[':'].Contains = function (a, i, m) {
            return (a.textContent || a.innerText || "").toUpperCase().indexOf(m[3].toUpperCase()) >= 0;
        };
        function FilterMenu(list) {
            var input = $(".filtertxt");

            $(input).change(function () {
                var filter = $(this).val();
                //console.log(filter);
                //If search text box contains some text then apply filter list
                if (filter) {
                    //Add open class to parent li item
                    $(list).parent().addClass('open');
                    //Add class in and expand the ul item which is nested li of main ul
                    $(list).addClass('in').prop('aria-expanded', 'true').slideDown();

                    //Check if child list items contain the query text. Them make them active
                    $(list).find('li:Contains(' + filter + ')').addClass('active');
                    //Check if any child list items doesn't contain query text. Remove the active class
                    //So that they are not more highlighted
                    $(list).find('li:not(:Contains(' + filter + '))').removeClass('active');

                    //Show any ul inside main ul which contains the text.
                    $(list).find('li:Contains(' + filter + ')').show();
                    //Hide any ul inside main ul which doesn't contains the text.
                    $(list).find('li:not(:Contains(' + filter + '))').hide();

                    //Filter top level list items to show and hide them.
                    $('.sidebar-menu').find('li:Contains(' + filter + ')').show();
                    $('.sidebar-menu').find('li:not(:Contains(' + filter + '))').hide();

                } else {

                    $(list).parent().removeClass('open');
                    $(list).removeClass('in').prop('aria-expanded', 'false').slideUp();
                    $(list).find('li').removeClass('active');
                    $('.sidebar-menu').find('li').show();
                }
            })
                .keyup(function () {
                    $(this).change();
                });
        }

        //ondomready
        $(function () {
            FilterMenu($(".sidebar-menu ul"));
        });
    }(jQuery));

    $(".sidebar-menu a").each(function () {
        //console.log($(this).attr('href'));
        if ((window.location.pathname.indexOf($(this).attr('href'))) > -1) {
            $(this).parent().addClass('active');
        }
    });
</script>