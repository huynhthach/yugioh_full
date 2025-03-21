<style>
    .button-container {
        text-align: center; /* căn chỉnh nút vào giữa */
        padding-top: 150px; /* Khoảng cách từ container đến nút */
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@extends('layout.app')

@section('content')
<!-- Container chứa các button -->
<div class="button-container">
    <!-- Button kích hoạt Pack -->
    <button id="toggleContentPack">Gói thẻ</button>
    <!-- Button kích hoạt Card -->
    <button id="toggleContentfvCard">Thẻ yêu thích</button>

    <button id="toggleContentCard">Thẻ của tôi</button>
</div>

<!-- Container chứa nội dung Pack -->
<div id="contentPackContainer" style="display: none;padding-top: 20px;">
    @include('user.owned_packs', ['ownedPacks' => $ownedPacks])
</div>

<div id="contentfvCardContainer" style="display: none;">
    @include('yugioh.catalog', ['catalogItems' => $catalogItems])
</div>

<div id="contentCardContainer" style="display: none;">
    @include('user.owned_cards', ['ownedCards' => $ownedCards])
</div>

@endsection

<script>
    $(document).ready(function() {
        $('#toggleContentPack').on('click', function() {
            $('#contentPackContainer').toggle(); // Hiển thị hoặc giấu nội dung khi click vào nút
        });

        $('#toggleContentfvCard').on('click', function() {
            $('#contentfvCardContainer').toggle(); // Hiển thị hoặc giấu nội dung khi click vào nút
        });

        $('#toggleContentCard').on('click', function() {
            $('#contentCardContainer').toggle(); // Hiển thị hoặc giấu nội dung khi click vào nút
        });
    });
</script>
