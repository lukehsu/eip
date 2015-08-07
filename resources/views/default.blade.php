<!DOCTYPE HTML>
<html>
    <head>
        <!-- incudle -->
        @include('head')
    </head>
    <body>
        <header>
          
        </header>
        <div class="content">
            <!-- yield 會產生 content 這個 section 的內容 -->
            @yield('content')
        </div>
        <footer>
          
        </footer>
    </body>
</html>