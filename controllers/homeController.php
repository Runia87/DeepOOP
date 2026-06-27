<?php
namespace App\controllers;
use App\QueryBuilder;
use League\Plates\Engine;
use Exception;
use function Tamtamchik\SimpleFlash\flash;
use App\exceptions\NotEnoughMoneyException;
use App\exceptions\AccountIsBlockedException;
use PDO;
//$db=new QueryBuilder();
//$posts=$db->getAll('posts');
//$db->insert(['title'=>'New post from queryFactory'],'posts');
//$db->delete('posts',11);
//$post=$db->getOne('posts',10);
//$db->update(['title'=>'New post from queryFactory2'],4,'posts');
//var_dump($posts);
//var_dump($post);

class homeController{

    private $templates;
    private $auth;
    private $db;

    function __construct(QueryBuilder $db){
        $this->db=$db;
        $this->templates = new Engine('../code/app/views');
        $db = new PDO('mysql:host=MySQL-8.0;dbname=OOP2',"root","");  
        $this->auth=new \Delight\Auth\Auth($db); 
    }

public function index(){
    d($this->db);die;
    //$this->auth->login('runia87@mail.ru','123'); die;
    d($this->auth->getRoles()); die;
    try{
        $this->auth->admin()->addRoleForUserById(1, \Delight\Auth\Role::ADMIN);
    }
   catch(\Delight\Auth\UnknownIdException $e) {
        die('Unknown ID');
    }
    
//die;
   
    // d($vars); exit;
    // $db=new QueryBuilder();
    // $db->update(['title'=>'new post'],2,'posts');

    // Create new Plates instance
//$templates = new Engine('../code/app/views');

// Render a template

$db = new QueryBuilder();
$posts=$db->getAll('posts');
echo $this->templates->render('homepage', ['posts' => $posts]);
}

public function about(){
    
    
    try {
        $userId = $this->auth->register('runia87@mail.ru', '123', 'Ainur', function ($selector, $token) {
            echo 'Send ' . $selector . ' and ' . $token . ' to the user (e.g. via email)';
            echo '  For emails, consider using the mail(...) function, Symfony Mailer, Swiftmailer, PHPMailer, etc.';
            echo '  For SMS, consider using a third-party service and a compatible SDK';
        });
    
        echo 'We have signed up a new user with the ID ' . $userId;
    }
    catch (\Delight\Auth\InvalidEmailException $e) {
        die('Invalid email address');
    }
    catch (\Delight\Auth\InvalidPasswordException $e) {
        die('Invalid password');
    }
    catch (\Delight\Auth\UserAlreadyExistsException $e) {
        die('User already exists');
    }
    catch (\Delight\Auth\TooManyRequestsException $e) {
        die('Too many requests');
    }
    // try{
    //     $this->withdraw($vars['amount']);
    // }
    // catch(NotEnoughMoneyException $exception){
    //     flash()->error($exception->getMessage());
    // }
    // catch(AccountIsBlockedException $exception){
    //     flash()->error($exception->getMessage());
    // }
    
   // echo $this->templates->render('about', ['name' => 'Jonathan about']);
    // d($vars); exit;
    // $db=new QueryBuilder();
    // $db->update(['title'=>'new post'],2,'posts');

    // Create new Plates instance
//$templates = new Engine('../code/app/views');

// Render a template


}

public function email_verification(){
    try {
        $this->auth->confirmEmail('KnVpLKISofgS7ch5', '1Dusv0K4WV3s8EzB');
    
        echo 'Email address has been verified';
    }
    catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
        die('Invalid token');
    }
    catch (\Delight\Auth\TokenExpiredException $e) {
        die('Token expired');
    }
    catch (\Delight\Auth\UserAlreadyExistsException $e) {
        die('Email address already exists');
    }
    catch (\Delight\Auth\TooManyRequestsException $e) {
        die('Too many requests');
    }
}

public function login(){
    try {
        $this->auth->login('runia87@mail.ru','123');
    
        echo 'User is logged in';
    }
    catch (\Delight\Auth\InvalidEmailException $e) {
        die('Wrong email address');
    }
    catch (\Delight\Auth\InvalidPasswordException $e) {
        die('Wrong password');
    }
    catch (\Delight\Auth\EmailNotVerifiedException $e) {
        die('Email not verified');
    }
    catch (\Delight\Auth\TooManyRequestsException $e) {
        die('Too many requests');
    }

}

public function withdraw($amount=1){
$total=10;

throw new AccountIsBlockedException('Счет заблокирован!');

if($amount>$total){
    throw new NotEnoughMoneyException('Не достаточно средств на счету!');
}}
}

?>
