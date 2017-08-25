<script>
function getTextNode(){
    var x = document.getElementById("frame1").contentWindow.document
    x.body.scrollTop= x.body.offsetHeight;
}

setInterval(getTextNode,50);
</script>

<iframe id="frame1" width="400px" height="600px" src="allplay.php"></iframe>