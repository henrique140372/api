<div class="sidebar user-sidebar">
    <div class="sidebar-menu px-15">

        <div class="dropdown dropright with-arrow w-full">
            <button class="btn w-full" data-toggle="dropdown" type="button" id="..." aria-haspopup="true" aria-expanded="false">
                Dashboard <i class="fa fa-angle-right ml-5" aria-hidden="true"></i> <!-- ml-5 = margin-left: 0.5rem (5px) -->
            </button>
            <div class="dropdown-menu" >
                <h6 class="dropdown-header">Header</h6>
                <a href="#" class="dropdown-item">Link 1</a>
                <a href="#" class="dropdown-item">Link 2</a>
                <div class="dropdown-divider"></div>
                <div class="dropdown-content">
                    <button class="btn btn-block" type="button">Button</button>
                </div>
            </div>
        </div>



    </div>
</div>
<br>
<script>
</div>
<!--bloqueio inspecionar-->
<script src="https://cdn.jsdelivr.net/gh/brunoalbim/devtools-detect/index.js"></script>
<script>
if (window.devtools.isOpen === true) {
      window.location = "https://aoseugosto.eu.org/";
    }
  	window.addEventListener('devtoolschange', event => {
      if (event.detail.isOpen === true) {
        window.location = "https://t.me/aoseugostobr";
      }
  	});
</script>
<!-- fim inspecionar-->
<!--bloquear control+u do teclado-->
<script>
var message="";
function clickIE() {if (document.all) {(message);return false;}}
function clickNS(e) {if
(document.layers||(document.getElementById&&!document.all)) {
if (e.which==2||e.which==3) {(message);return false;}}}
if (document.layers)
{document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;}
else{document.onmouseup=clickNS;document.oncontextmenu=clickIE;}

document.oncontextmenu=new Function("return false")


//  F12
//==========

  document.onkeypress = function (event) {
    if (e.ctrlKey &&
        (e.keyCode === 123)) {
            // alert('not allowed');
            return false;
          }
  };


//    CTRL + u
//==============

  document.onkeydown = function(e) {
    if (e.ctrlKey &&
      (e.keyCode === 85)) {
          // alert('not allowed');
          return false;
        }
      };  
</script>
<!-- fim bloqueio control+u do teclado-->
        