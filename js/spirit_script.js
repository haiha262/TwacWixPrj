$(document).ready(function() {

var rad = document.getElementsByName("c_000000da");
    var prev = null;
    for(var i = 0; i < rad.length; i++) {
        rad[i].onclick = function() {
            (prev)? console.log(prev.value):null;
            if(this !== prev) {
                prev = this;
            }
            console.log(this.value)
        };
    }
$( "<h1>HELLO</h1>" ).appendTo( $( "body" ) );

$('input[type=radio][name=c_000000da]').change(function() {
        if (this.value == 'allot') {
            alert("Allot Thai Gayo Bhai");
        }
        else if (this.value == 'transfer') {
            alert("Transfer Thai Gayo");
        }
    });
});