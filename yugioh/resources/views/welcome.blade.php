@extends('layout.app')
@section('content')

<section class="banner_part">
    <div class="background_overlay"></div>
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <!-- Phần text -->
            <div class="col-lg-6 col-md-8">
                <div class="banner_text">
                    <div class="banner_text_iner">
                        <h1>YUGIOH:Dual Link</h1>
                        <p>Yu-Gi-Oh! xoay quanh câu chuyện về Yugi Muto, 
                            cậu thanh niên tóc dựng đứng đã giải thành công 
                            câu đố của người Ai Cập cổ đại và giải phóng một 
                            bản ngã bí ẩn của bản thân. Trong thế giới Yu-Gi-Oh!,
                             các nhân vật sẽ tranh đấu với nhau bằng các trận đấu bài
                            ma thuật.</p>
                        <a href="https://www.youtube.com/watch?v=zpTrhc4CwJE" class="btn_1">Watch Tutorial</a>
                    </div>
                </div>
            </div>
            <!-- Phần video -->
            <div class="col-lg-6 col-md-4">
                <div class="video_wrapper">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/oJMG-6gfAVo?si=A3oU-w-tmnZK2K2l" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>            </div>
            </div>
        </div>
    </div>
</section>


        <!-- about_us part start-->
        <section class="about_us section_padding">
            <div class="container">
                <div class="row align-items-center justify-content-between">
                    <div class="col-md-5 col-lg-6 col-xl-6">
                        <div class="learning_img">
                            <img src="{{ asset('img/blue_eyes.png') }}" alt="">
                        </div>
                    </div>
                    <div class="col-md-7 col-lg-6 col-xl-5">
                        <div class="about_us_text">
                            <h2>Bước vào thế giới đấu bài ma thuật</h2>
                            <p>
                                Đừng lo lắng nếu bạn là người chơi mới hoặc nếu bạn đã lâu chưa Đấu, 
                                các hướng dẫn trong trò chơi sẽ dạy bạn những điều cơ bản về cách chơi 
                                Yu-Gi-Oh!. Bạn sẽ nhận được một Bộ bài khi bạn hoàn thành để giúp bạn 
                                bắt đầu cuộc hành trình của mình! Thu thập các thẻ mới khi bạn tiến bộ 
                                qua trò chơi để tăng sức mạnh cho Bộ bài của bạn!
                            </p>
                            <a href="https://store.steampowered.com/app/601510/YuGiOh_Duel_Links/?l=vietnamese&cc=ru" class="btn_1">Install Now</a>
                            <a href="https://www.youtube.com/watch?v=zpTrhc4CwJE" class="btn_1">Watch Tutorial</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- about_us part end-->

        <!--::about_us part start::-->
        <section class="live_stareams padding_bottom">
            <div class="container-fluid">
                <div class="row align-items-center justify-content-between">
                    <div class="col-md-2 offset-lg-2 offset-sm-1">
                        <div class="live_stareams_text">
                            <h2>live <br> stream</h2>
                        </div>
                    </div>
                    <div class="col-md-7 offset-sm-1">
                        <div class="live_stareams_slide owl-carousel">
                            <div class="live_stareams_slide_img">
                                <img src="img/duel.jpg" alt="">
                                <div class="extends_video">
                                    <a id="play-video_1" class="video-play-button popup-youtube"
                                        href="https://www.youtube.com/watch?v=7c9h5p8tonA">
                                        <span class="fas fa-play"></span>
                                    </a>
                                </div>
                            </div>
                            <div class="live_stareams_slide_img">
                                <img src="img/cps2.png" alt="">
                                <div class="extends_video">
                                    <a id="play-video_1" class="video-play-button popup-youtube"
                                        href="https://www.youtube.com/watch?app=desktop&v=qAa3e3WlGDM">
                                        <span class="fas fa-play"></span>
                                    </a>
                                </div>
                            </div>
                            <div class="live_stareams_slide_img">
                                <img src="img/cpsjp.jpg" alt="">
                                <div class="extends_video">
                                    <a id="play-video_1" class="video-play-button popup-youtube"
                                        href="https://www.youtube.com/watch?v=80qaUbGAzB4">
                                        <span class="fas fa-play"></span>
                                    </a>
                                </div>
                            </div>
                            <div class="live_stareams_slide_img">
                                <img src="img/cps2020.jpg" alt="">
                                <div class="extends_video">
                                    <a id="play-video_1" class="video-play-button popup-youtube"
                                        href="https://www.youtube.com/watch?v=rYPLdTfiNKc">
                                        <span class="fas fa-play"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--::about_us part end::-->

        <!-- use sasu part end-->
        <section class="Latest_War">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="section_tittle text-center">
                            <h2>Latest War Fight</h2>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-12">
                        <div class="Latest_War_text">
                            <div class="row justify-content-center align-items-center h-100">
                                <div class="col-lg-6">
                                    <div class="single_war_text text-center">
                                        <h4>Open War chalange</h4>
                                        <p>6 August , 2023</p>
                                        <a href="#">view fight</a>
                                        <div class="war_text_item d-flex justify-content-around align-items-center">
                                            <img src="img/taka.jpg" alt="" style="width: 100px;">
                                            <h2>190<span>vs</span>189</h2>
                                            <img src="img/yukoo.jpg" alt="" style="width: 100px;">
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <a href="https://www.youtube.com/watch?v=XunOFynG2Oo&t=3799s" class="btn_2">Watch Duel</a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="latest_war_list">
                            <div class="single_war_text">
                                <div class="war_text_item d-flex justify-content-around align-items-center">
                                    <img src="img/war_logo_1.png" alt="">
                                    <h2>190<span>vs</span>189</h2>
                                    <img src="img/war_logo_2.png" alt="">
                                    <div class="war_date">
                                        <a href="#">27 june 2020</a>
                                        <p>Open War chalange</p>
                                    </div>
                                </div>
                            </div>
                            <div class="single_war_text">
                                <div class="war_text_item d-flex justify-content-around align-items-center">
                                    <img src="img/war_logo_1.png" alt="">
                                    <h2>190<span>vs</span>189</h2>
                                    <img src="img/war_logo_2.png" alt="">
                                    <div class="war_date">
                                        <a href="#">27 june 2020</a>
                                        <p>Open War chalange</p>
                                    </div>
                                </div>
                            </div>
                            <div class="single_war_text">
                                <div class="war_text_item d-flex justify-content-around align-items-center">
                                    <img src="img/war_logo_1.png" alt="">
                                    <h2>190<span>vs</span>189</h2>
                                    <img src="img/war_logo_2.png" alt="">
                                    <div class="war_date">
                                        <a href="#">27 june 2020</a>
                                        <p>Open War chalange</p>
                                    </div>
                                </div>
                            </div>
                            <div class="single_war_text">
                                <div class="war_text_item d-flex justify-content-around align-items-center">
                                    <img src="img/war_logo_1.png" alt="">
                                    <h2>190<span>vs</span>189</h2>
                                    <img src="img/war_logo_2.png" alt="">
                                    <div class="war_date">
                                        <a href="#">27 june 2020</a>
                                        <p>Open War chalange</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="Latest_War_text Latest_War_bg_1">
                            <div class="row justify-content-center align-items-center h-100">
                                <div class="col-lg-6">
                                    <div class="single_war_text text-center">
                                        <img src="img/favicon.png" alt="">
                                        <h4>Open War chalange</h4>
                                        <p>27 june , 2020</p>
                                        <a href="#">view fight</a>
                                        <div class="war_text_item d-flex justify-content-around align-items-center">
                                            <img src="img/war_logo_1.png" alt="">
                                            <h2>190<span>vs</span>189</h2>
                                            <img src="img/war_logo_2.png" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="#" class="btn_2">Watch Tutorial</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- use sasu part end-->

        <!-- use sasu part end-->
        <section class="upcomming_war">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="section_tittle text-center">
                            <h2>Trận đấu tiếp theo</h2>
                        </div>
                    </div>
                </div>
                <div class="upcomming_war_iner">
                    <div class="row justify-content-center align-items-center h-100">
                        <div class="col-10 col-sm-5 col-lg-3">
                            <div class="upcomming_war_counter text-center">
                                <h2>Dark Dragon</h2>
                                <div id="timer" class="d-flex justify-content-between">
                                    <div id="days"></div>
                                    <div id="hours"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- use sasu part end-->

        <!-- pricing part start-->
        <section class="pricing_part padding_top">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="section_tittle text-center">
                            <h2>Gói thẻ phổ biến</h2>
                        </div>
                    </div>
                </div>
                @foreach ($topPacks as $pack)
                <div class="row justify-content-center">
                    <div class="col-lg-3 col-sm-6">
                        <div class="single_pricing_part">
                            <p>{{ $pack->PackName }}</p>
                            <h3>{{ $pack->Price }}</h3>
                            <img src="{{ asset('img/pack_image/' . $pack->Image_pack) }}" class="card-img-top pack-image" alt="{{ $pack->PackName }}" style="height: 100%;">
                            <a href="{{ route('user.packs') }}" class="btn_2">Mua ngay</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
@endsection