<style>
        .contact-container {
            display: flex;
            width: 80%;
            max-width: 600px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            
        }

        .contact-image {
            flex: 1;
            overflow: hidden;
        }

        .contact-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .contact-form {
            flex: 1;
            padding: 20px;
        }

        .contact-form label {
            display: block;
            margin-bottom: 10px;
        }

        .contact-form input,
        .contact-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .contact-form button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .text{
            padding-top: 200px;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-nNEziqxv9Vs3m5eDdIeJViZSLV1RBUlHc9RZb9OI7U6c7gRUIlNlQ/E4XZnqndVzpm57d+3AAZU5xM/7Pr4WyA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

@extends('layout.app')
@section('content')
<body>
    <div class="text">   
        <div class="container mt-4">
            <div class="row">
                <div class="custombox authorbox clearfix">
                    <h4 class="small-title">About us</h4>
                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <img src="img/comment/long.png" alt="" class="img-fluid rounded-circle"> 
                        </div><!-- end col -->

                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                            <h4><a href="#">Long</a></h4>
                            <p>Chúng tôi – đội ngũ quản trị blog vốn đam mê bộ môn bài ma thuật này. Chúng tôi luôn tìm kiếm những người đồng chí hướng để cùng nhau đồng hành không chỉ về trò chơi thẻ bài đầy logic này mà còn trong cuộc sống mỗi chúng ta.</p>

                            <div class="topsocial">
                                <a href="https://www.facebook.com/profile.php?id=100055364994284" data-toggle="tooltip" data-placement="bottom" title="Facebook"><i class="fab fa-facebook"></i></a>
                                <a href="https://www.youtube.com/channel/UCUw6xxZ4WY1I1Xk7nIbbGiw" data-toggle="tooltip" data-placement="bottom" title="Youtube"><i class="fab fa-youtube"></i></a>
                                <a href="#" data-toggle="tooltip" data-placement="bottom" title="Twitter"><i class="fab fa-twitter"></i></a>
                                <a href="#" data-toggle="tooltip" data-placement="bottom" title="Instagram"><i class="fab fa-instagram"></i></a>
                                <a href="#" data-toggle="tooltip" data-placement="bottom" title="Website"><i class="fas fa-link"></i></a>
                            </div><!-- end social -->

                        </div><!-- end col -->
                    </div><!-- end row -->
                </div><!-- end author-box -->
            </div>
        </div>
    </div>
</body>
@endsection