<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ajax Pagination with Search and Filter using PHP by CddexWorld</title>

    <!-- Stylesheet file -->
    <link rel="stylesheet" href="css/style.css">
    <link href="css/green-pagination.css" rel="stylesheet"  id="green-pagination" title="Green pagination">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>


        // change pagination style
        function toggleCSS() {
            let green = document.getElementById('green-pagination');
            green.disabled = green.disabled ? false : true;
        }

       $(document).ready (function(){
            $('#postContent').on("click", "#show-numbers" , function(){
                toggleCSS();
            });
            searchFilter();
        });

        // Show loading overlay when ajax request starts
        $(document).ajaxStart(function () {
            $('.loading-overlay').show();
        });

        // Hide loading overlay when ajax request completes
        $(document).ajaxStop(function () {
            $('.loading-overlay').hide();
            // document.ready will not fire again once a ajax request is completed
          /*  $('#show-numbers').click( function(){
                toggleCSS();
            });*/
        });

        function searchFilter(page_num) {
            page_num = page_num ? page_num : 0;
            var keywords = $('#keywords').val();
            var sortBy = $('#sortBy').val();
            $.ajax({
                type: 'POST',
                url: 'getData.php',
                data: 'page=' + page_num + '&keywords=' + keywords + '&sortBy=' + sortBy,
                beforeSend: function () {
                    $('.loading-overlay').show();
                },
                success: function (html) {
                    $('#postContent').html(html);
                    $('.loading-overlay').fadeOut("slow");
                }
            });
        }
    </script>
</head>
<body>
<div class="container">
    <h1 class="title">
        <a href="https://www.codexworld.com/ajax-pagination-with-search-filter-php/">
            Ajax Pagination with Search and Filter in PHP
        </a>
    </h1>
    <!-- Search form -->
    <div class="post-search-panel">
        <input type="text" id="keywords" placeholder="Type keywords..." onkeyup="searchFilter();"/>
        <select id="sortBy" onchange="searchFilter();">
            <option value="">Sort by Title</option>
            <option value="asc">Ascending</option>
            <option value="desc">Descending</option>
        </select>
    </div>

    <div class="post-wrapper">
        <!-- Loading overlay -->
        <div class="loading-overlay">
            <div class="overlay-content">Loading...</div>
        </div>



       <!-- Post list container -->
        <div id="postContent"></div>
</div>
 
</body>
</html>