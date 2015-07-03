register_hook("init", function() {
  var codes = document.getElementsByTagName("pre");
  for(var i = 0; i < codes.length; i++)
    hljs.highlightBlock(codes[i]);
});
