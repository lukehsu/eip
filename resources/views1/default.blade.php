<!DOCTYPE HTML>
<html>
    <head>
        <!-- incudle -->
  @include('head.bootstrapcss')
    </head>
    <body>
        <header>
          
        </header>
        <div class="content">
            @include('includes.navbar')
            <!-- yield 會產生 content 這個 section 的內容 -->
            @yield('content')
        </div>
        <footer>
          
        </footer>
    </body>
</html>