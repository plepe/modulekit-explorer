window.onload = ExplorerAction_diff;
window.onresize = ExplorerAction_diff;

function ExplorerAction_diff() {
  var parent_div = document.getElementById('ExplorerAction_diff');

  var original = document.getElementById('original').firstChild;
  var compare = document.getElementById('compare').firstChild;

  while(original && compare) {
    if(original.getAttribute("row")) {
      var height = original.offsetHeight;
      var compare_height = compare.offsetHeight;

      if(compare_height > height)
	height = compare_height;

      original.style.height = height + "px";
      compare.style.height = height + "px";
    }

    original = original.nextSibling;
    compare = compare.nextSibling;
  }
}
