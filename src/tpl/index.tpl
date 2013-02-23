<!DOCTYPE html>
<head>
	<meta charset="UTF-8">
	
	<meta name="viewport" content="width=device-width">
	
	<link rel="stylesheet" href="../css/foundation.min.css">
	
	<link rel="stylesheet" href="../css/icons.css">
	
	<link rel="stylesheet" href="../css/app.css">
	
	<title>Elternsprechtag - Login</title>
	
	<script src="../js/modernizr.foundation.js"></script>
</head>
<body>
	<div class="wrapper">
		<div class="row contain-to-grid">
			<div class="five mobile-four columns offset-by-one">
				<h1 class="header">Elternsprechtag</h1>
			</div>
		</div>

		<div class="push"></div>
		<div class="row">
			<div class="twelve columns ">
				<div class="panel">
					<h4> Liebe Eltern,</h4>
					<p> Willkommen auf der elektronischen Elternsprechtagsplattform der Brühlwiesenschule Hofheim.<br>
						Melden Sie sich an oder registrieren Sie sich um ihre Termine einzusehen oder neue Termine zu vereinbaren.
					</p>
				</div>
			</div>
		</div>
		<div id="Login_Form" class="row">
			<div class="six columns centered">
				<form action="./main_new.html" method="get" accept-charset="UTF-8">
					<fieldset>
						<legend>Login</legend>
						<input type="text" placeholder="E-Mail" />
						<input type="password" placeholder="Passwort" />
						<input type="submit" class="button" value="Login" />
						<a class="medium right" href="" data-reveal-id="myModal"><br>Probleme beim Login?</a>
					</fieldset>
				</form>
			</div>
		</div>
		<div class="row">
			<div class="four columns centered">
					<p class="text-center" style="font-weight:bold;"><a id="Zugang_Anchor" href="">Ben&ouml;tigen Sie einen neuen Zugang?<br>Klicken Sie hier.</a></p>
			</div>
		</div>
		<div id="Zugang_Form" class="row hide">
			<div class="six columns centered">
				<form action="./new_entry_success.html" method="get" accept-charset="UTF-8">
					<fieldset>
						<legend>Registrierung</legend>
						<p>Geben Sie ihre E-Mail-Adresse und ein Passwort ein um sich im System zu registrieren.<br> 
							Sie sollten innerhalb weniger Minuten eine E-Mail empfangen, die einen Link enthält mit dem Sie ihre Registrierung abschlie&szlig;en k&ouml;nnen.
						</p>
						<input type="text" placeholder="E-Mail" />
						<input type="password" placeholder="Passwort" />
						<input type="password" placeholder="Passwort bestätigen" />
						<input type="submit" class="button" value="Registrieren" />
					</fieldset>
				</form>
			</div>
		</div>
		<div class="row">
			<div class="four columns centered">
				<p class="text-center" style="font-weight:bold;"><a id="Login_Anchor" href="" class="hide">Sie kennen ihre Logindaten bereits?<br>Klicken Sie hier.</a></p>
			</div>
		</div>
		<div class="push"></div>
	</div> <!-- /WRAPPER -->
	<div class="footer"> 
		<div class="row">
			<div class="twelve columns"><hr />
				<div class="row">
					<div class="six columns">
						<p>&copy; Copyright no one at all. Go to town.</p>
					</div>
					<div class="six columns">
						<ul class="link-list right">
							<li><a href="#">Link 1</a></li>
							<li><a href="#">Link 2</a></li>
							<li><a href="#">Link 3</a></li>
							<li><a href="#">Link 4</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div> 	
	
		<!-- MODALS -->
		<div id="myModal" class="reveal-modal [expand, xlarge, large, medium, small]">
			<h3>M&ouml;chten Sie ihr Passwort zur&uuml;cksetzen ?</h3>
			<p>Geben Sie einfach ihre E-Mail-Adresse ein. Ihnen wird ein tempor&auml;res Passwort zugesandt mit dem Sie sich einloggen können.</p>
			<form>
			<div class="row collapse">
				<div class="nine columns">
					<input type="text" placeholder="E-Mail" />
				</div>
				<div class="three columns">
					<a class="button expand postfix" href="./password_reset.html">Absenden</a>
				</div>
			</div>
			</form>
			<div class="panel">
				<p class="medium">Das Zur&uuml;cksetzen eines Passwortes funktioniert nur, wenn Sie bereits im System registriert sind. Sollten Sie noch keinen Zugang besitzen registrieren Sie sich bitte zuerst im System.</p>
			</div>
			<a class="close-reveal-modal" data-icon="&#xe014;"></a>
		</div>
		
		<!-- SKRIPTE -->
		<!-- Einbinden der JS Files (Minified) -->
		<script src="../js/foundation.min.js"></script>

		<!-- Initialisieren der JS Plugins -->
		<script src="../js/app.js"></script>
		<script> 
;(function (window, document, $) {

	
	$( '#Zugang_Anchor' ).on('click', function(e) {
		e.preventDefault();
		$( '#Zugang_Form' ).toggleClass( 'hide' );
		$( '#Login_Form' ).toggleClass( 'hide' );
		$( '#Zugang_Anchor' ).toggleClass( 'hide' );
		$( '#Login_Anchor' ).toggleClass( 'hide' );
	});
	
	$( '#Login_Anchor' ).on('click', function(e) {
		e.preventDefault();
		$( '#Zugang_Form' ).toggleClass( 'hide' );
		$( '#Login_Form' ).toggleClass( 'hide' );
		$( '#Zugang_Anchor' ).toggleClass( 'hide' );
		$( '#Login_Anchor' ).toggleClass( 'hide' );
	});
		

}(this, document, jQuery));
		</script>
</body>
</html>
