@if ($id = config('support.google_analytics.id'))
<script>
  setTimeout(function() {
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
    ga('create', "{{ $id }}", "{{ config('support.google_analytics.cookie_domain', 'auto') }}", {'allowLinker': true});
    ga('require', 'linker');
    ga('send', 'pageview');
    if (typeof setupGA === "function") setupGA(ga);
  }, 0)
</script>
@endif
