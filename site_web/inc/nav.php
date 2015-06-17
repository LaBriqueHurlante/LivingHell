
<!--<nav id="nav1" class="nav" style="display:block;">
	<ul class="menu">
    	<li><a class="rouge" href="cours.php">Cours</a></li>
        <li><a class="orange" href="quiz.php">Quiz</a></li>
        <li><a class="bleu" href="wikiotheque.php">Wikiothèque</a></li>
        <li class="logo"></li>
        <li><a class="vert" href="ateliers.php">Ateliers de création</a></li>
        <li><a class="rose" href="gazette.php">La Gazette</a></li>
        <li><a class="violet" href="">Inscription</a></li>
    </ul>
</nav>-->

<div id="menu2" class="nav">
<nav>
	<ul class="menu">
    	<li class="logo"></li>
        <li><a class="violet" href="">Inscription</a></li>
    	<li><a class="rouge" href="cours.php">Cours</a></li>
        <li><a class="orange" href="quiz.php">Quiz</a></li>
        <li><a class="bleu" href="wikiotheque.php">Wikiothèque</a></li>
        <li><a class="vert" href="ateliers.php">Les Ateliers</a></li>
        <li><a class="rose" href="gazette.php">La Gazette</a></li>      
    </ul>
</nav>
</div>
<script>
	$(document).ready(function(e) {
        $('.nav a').hover(function() {
    $( this ).addClass( "animated bounceIn" );
  }, function() {
    $( this ).removeClass( "animated bounceIn" );
  })
    });
</script>