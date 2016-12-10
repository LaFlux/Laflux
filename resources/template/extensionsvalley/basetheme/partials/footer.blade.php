 <footer id="fh5co-footer">

        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="fh5co-footer-widget">
                        <h2 class="fh5co-footer-logo">{{ \WebConf::get('site_name')}}</h2>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
                    </div>
                    <div class="fh5co-footer-widget">
                        <ul class="fh5co-social">
                            <li><a href="#"><i class="icon-facebook"></i></a></li>
                            <li><a href="#"><i class="icon-twitter"></i></a></li>
                            <li><a href="#"><i class="icon-instagram"></i></a></li>
                            <li><a href="#"><i class="icon-linkedin"></i></a></li>
                            <li><a href="#"><i class="icon-youtube"></i></a></li>
                        </ul>
                    </div>
                </div>
                @includeIf('Basetheme::position.loadview',['position'=> 'footer-menu'])
            </div>

            <div class="row fh5co-row-padded fh5co-copyright">
                <div class="col-md-5">
                    <p><small>{{ \WebConf::get('copy_right')}} <br>Designed by: <a href="http://extensionsvalley.com/" target="_blank">Extensions Valley</a></small></p>
                </div>
            </div>
        </div>

    </footer>
