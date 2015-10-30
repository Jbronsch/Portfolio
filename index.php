<?php 
require 'vendor/autoload.php';
date_default_timezone_set('America/Vancouver');

$app = new \Slim\Slim( array(
	'view' => new \Slim\Views\Twig()
	));

$app->add(new \Slim\Middleware\SessionCookie());

$view = $app->view();
$view->parserOptions = array(
    'debug' => true,
);

$view->parserExtensions = array(
    new \Slim\Views\TwigExtension(),
);

$app->get('/', function() use($app){
	$app->render('main.twig');
})->name("home");

$app->post('/', function() use($app){
	$name = $app->request->post("name");
	$email = $app->request->post("email");
	$subject= $app->request->post("subject");
	$message = $app->request->post("message");


	if(!empty($name) && !empty($email) && !empty($message) && !empty($subject)) {
		$cleanName = filter_var($name, FILTER_SANITIZE_STRING);
		$cleanEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
		$cleanSubject = filter_var($subject, FILTER_SANITIZE_STRING);
		$cleanMessage = filter_var($message, FILTER_SANITIZE_STRING);
	} else {
		//message user problem
		$app->flash("error", "There was an error with your form data. Please recheck all fields.");
		$app->redirect('/');
	}

// Swift_SmtpTransport::newInstance('smtp.gmail.com' , 465, 'ssl')
// 		->setUsername("jbronsch@gmail.com")
// 		->setPassword('DeadButDreaming99');

	$transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');
	$mailer = \Swift_Mailer::newInstance($transport);
	$swMessage = \Swift_Message::newInstance();
	$swMessage->setFrom(array($cleanEmail => $cleanName));
	$swMessage->setTo(array('jbronsch@gmail.com'));
	$swMessage->setSubject($cleanSubject);
	$swMessage->setContentType("text/html");
	$swMessage->setBody(
		"<b>Name:</b> ".
		$cleanName.
		"<br><br>".
		"<b>Email:</b> ".
		$cleanEmail.
		"<br><br>".
		"<b>Message:</b> ".
		$cleanMessage
		);

	$result = $mailer->send($swMessage);

	if($result > 0){
		//send thank you
		$app->flash("success", "Your message was successfully sent. Thank you!");
		$app->redirect('/');
	} else {
		//send user message failed
		//log error
		$app->flash("error", "There was a problem sending your message. Please try again.");
		$app->redirect('/');
	}

});
$app->run();
?>