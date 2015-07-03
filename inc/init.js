window.onload = function() {
  call_hooks("init");
}

window.onresize = function() {
  call_hooks("resize");
}
