<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>test vignette Ajax</title>
<link href="../css/style.css" rel="stylesheet" type="text/css">

<style>
	body {background:#655C89;}
	.div_questionnaire {
/*	width: 80%;
  height: 400px;
  background-color: #fff;
  margin: 5% auto;
  padding: 2rem;
  box-sizing: border-box;
  font-family: lato;
  color: #777777;
  display:none;
  position:fixed;*/
  
  background-color: #fff;
  margin: 5% auto;
  padding: 2rem;
  box-sizing: border-box;
  font-family: lato;
  color: #777777;
  display: none;
  position: fixed;
  left: 200px;
  top: 10px;
  bottom: 100px;
  right: 200px;
  z-index: 10; /* keep on top of other elements on the page */
  outline: 9999px solid rgba(0,0,0,0.5);
		}

.but-quest{
background-color: #fff;
  border: 1px solid #777777;
  padding: 1rem;
  display: block;
  width: 100%;
  font-family: lato;
  transition:all linear .1s;

}
.but-quest:hover {
	background-color:rgb(245, 53, 37);
	transition:all linear .1s;
	color:#fff;
	border:1px solid #fff;;

	}
.but-quest-suiv{
display: block;
  margin-right: 0px;
  margin-left: auto;
  background-color: #EA2929;
  border: none;
  padding: 1rem;
  color: #fff;
  font-family: lato;
}
.but-quest-suiv:hover {
	background-color:#777777;
	transition:all linear .1s;
	}
	
h1 {
	color:#fff;
	font-family:lato;
}
#but-art2 {margin-left: 55px;}
.quest {
color: #000;
  font-family: lato;
  font-size: 40px;
}
</style>
<script src="../../js/jquery.min.js"></script>
<script src="../../js/jquery-ui.min.js"></script>

<script type="text/javascript">
		function init(){
			//récupère les questions
			$.get('../../r.php',
        			{fct:"question"},
        			function(js){
        				console.log(js);
        				afficheQuestions(js);
        			},'json');
		}
		function afficheQuestions(rs){
			rs.forEach(function(r){
				$("#result").html($("#result").html()+"<div class='quest'>"+r.contenu+"</div>");
			});
		}
	</script>
</head>

<body onload="init()">

<h1>TEST 2</h1>
<article id="art2">
<p>Êtes-vous prêt à passer l'examen??</p>
<button id="but-art2" class="but-quest-suiv" onClick="ouvrir_fermer('question_0','question_0');">Démarrer</button>
</article>

<article>
  <div id="question_0" class="div_questionnaire" >
	<cite>http://openclassrooms.com/forum/sujet/qcm-en-javascript-59648</cite>
    <p>quel est votre sexe :</p>
    <p><INPUT class="but-quest" type=button name="sexe" value="Homme"></p>
	<p><INPUT class="but-quest" type=button name="sexe" value="Femme"></p>
    <p><INPUT class="but-quest" type=button name="sexe" value="Androgyne"></p>
    <!--<button onClick="ouvrir_fermer('response_0','question_0');">Valider</button>-->
    <button class="but-quest-suiv" onClick="ouvrir_fermer('question_1','question_0');">question suivante</button>
  </div>
  
  <div id="response_0" class="div_questionnaire">
    <p>la réponse est : UN MEC</p>
	<button onClick="ouvrir_fermer('question_1','response_0');">question suivante</button>
  </div>
  
  <div id="question_1" class="div_questionnaire">
    question n°2
	<div id="result"></div>
  </div>
 
  <div id="response_1" class="div_questionnaire">
  </div>
  
</article>

<script>
$('#question_0').hide();
function ouvrir_fermer(ouvrir,fermer)
{
$(document).ready(function()
{
$('#'+fermer).hide('fast');
$('#'+ouvrir).show('fast');

});
}
</script>

<div class="overlay"></div>

</body>
</html>