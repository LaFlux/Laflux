 <!-- Start .header -->
    <header id="fh5co-header" role="banner">
        <nav class="navbar navbar-default" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                <!-- Mobile Toggle Menu Button -->
                <a href="#" class="js-fh5co-nav-toggle fh5co-nav-toggle" data-toggle="collapse" data-target="#fh5co-navbar" aria-expanded="false" aria-controls="navbar"><i></i></a>
                <a class="navbar-brand" href="{{url('/')}}">{{ \WebConf::get('site_name')}}</a>
                </div>
               @includeIf('Basetheme::position.loadview',['position'=> 'header-menu'])
            </div>
        </nav>
    </header>
    <!-- END .header -->
