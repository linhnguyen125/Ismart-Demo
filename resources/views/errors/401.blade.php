<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>404 (NOT FOUND)</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/errors/404.css') }}">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Lato">
</head>

<body>
    <div class="page-wrap">
        <h1>401</h1>
        <h2>not found</h2>
        <p>Hiện tại bạn chưa được cấp quyền truy cập vào trang này. liên hệ với <a id="admin"
                href="https://www.facebook.com/profile.php?id=100015452952494" target="blank">Admin </a>để được hỗ trợ
        </p>
        <p><a id="home" href="{{ url('/admin') }}">home</a></p>
    </div>


</body>

</html>
