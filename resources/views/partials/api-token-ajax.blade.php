<script>
  (function($) {
    $.ajaxPrefilter(function(options, originalOptions, xhr) {
      if (! options.crossDomain) {
        var token = $('meta[name=api-token]').attr('content');
        if (token) {
          xhr.setRequestHeader('X-API-KEY', $('meta[name=api-key]').attr('content'));
          xhr.setRequestHeader('X-API-TIME', $('meta[name=api-time]').attr('content'));
          xhr.setRequestHeader('X-API-TOKEN', token);
        }
      }
    })
  })(jQuery)
</script>
