 @extends('interview.layouts.app')
@section('title')
Quick Dials- Business Services
@endsection 
@section('keyword')
Quick Dials-  Business Services list 
@endsection
@section('description'),  
Quick Dials- Business Services POPULAR CATEGORIES, B2B & BUSINESS SERVICES
@endsection


@section('content')	 
 

<div class='main light-grey' id='belowtopnav' style='margin-left:220px;'>
  <div class='row white'>
    <div class='col l11 m12' id='main'>
       
<h1>PHP<span class="color_h1"> Interview Question & Answer</span></h1>
<div class="clear nextprev">
<a class="left btn" href="{{url('interviews/php-interview-question-answer')}}">&#10094; Previous</a>
<a class="right btn" href="{{url('interviews/mysql-interview-question-answer')}}">Next &#10095;</a>
</div>
<hr>
 <div class="light">
  
 <section id="services-section" class="py-12 bg-gray-100"><div class="container mx-auto px-4">
  
 <div class="mb-12">
  <div class="question">
 <h2>What is PHP?</h2> 
 </div>
 <p class="text-lg text-gray-700">PHP stands for <strong>"Hypertext Preprocessor"</strong> a widely-used, open-source, server-side scripting language ideal for building dynamic websites, web applications, and mobile APIs.</p><p class="text-lg text-gray-700">It supports a wide range of databases, including:<strong>MySQL, PostgreSQL, Oracle, Sybase, Solid, Generic ODBC</strong></p><p><strong>PHP</strong> Originally developed by Rasmus Lerdorf in 1994, PHP has grown into a powerful tool for building interactive and data-driven websites.</p></div><div class="mb-12">
  <div class="question">
 <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What is a session in PHP?</h2>
 </div>
 
 <p class="text-lg text-gray-700">A <strong>session</strong> is a way to store information (variables) across multiple pages. </p><p>Session data is stored on the server and stored on the user's browser.</p><p>Session is a temporary storage Data while close the browser then the session times out.</p><p>Session unique ID assigns to unique ID (PHPSESSID) of each session.</p><p class="text-lg text-gray-700"><strong>The Start a session</strong> session_start();</p><p class="text-lg text-gray-700"><strong>Set session variables:</strong> <span class="shadow-lg p-2">$_SESSION['username'] = 'john_doe';</span></p><p class="text-lg text-gray-700"><strong>Access session variables</strong> <span class="shadow-lg p-2">echo $_SESSION['username']; </span></p><p class="text-lg text-gray-700"><strong>Unset or destroy a session</strong> <span class="shadow-lg p-2">unset($_SESSION['username']); session_destroy(); </span></p></div><div class="mb-12">
  
 <div class="question">
 <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What are cookies?</h2>
 
 </div>
 
 
 
 <p class="text-lg text-gray-700">A <strong>Cookies</strong> is store information client computer your web browser. </p><p>They store data about a user on the browser.</p><p>Session is a temporary storage Data while close the browser then the session times out.</p><p class="text-lg text-gray-700"><strong>Session Cookies:</strong> <span class="shadow-lg p-2">Temporary; deleted when you close your browser.</span></p><p class="text-lg text-gray-700"><strong>Persistent Cookies</strong> <span class="shadow-lg p-2">Stored on your device for a set time. </span></p><p class="text-lg text-gray-700"><strong>Setcookie</strong> <span class="shadow-lg p-2">setcookie(name, value, expire, path, domain, secure, httponly);</span></p></div>
 
 
 <div class="mb-12">
 <div class="question"> 
 <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What is the difference between the include() and require() functions?</h2>
 </div>
 <p>Both are used to include a file within another PHP script</p><p class="text-lg text-gray-700"><strong>include() function</strong> <span class="shadow-lg p-2">If the file is not found or fails to load, include() generates a warning (E_WARNING), but the script continues to execute.</span></p><p class="text-lg text-gray-700"><strong>require():</strong> <span class="shadow-lg p-2">When the file is require cannot be found, it will produce a fatal error (E_COMPILE_ERROR) and stops the execution of the script. </span></p></div>
 
 
 <div class="mb-12">
 <div class="question"> 
 <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What is the difference between the $_GET[] and $_POST[]?</h2>
 </div>
 <table><thead><tr><th style="width:350px;"><span>$_GET[]</span></th><th style="width:350px;"><span>$_POST[]</span></th></tr></thead>
 
 
 <tbody><tr><td ><span>Appended to the URL (query string)</span></td><td ><span>Sent in the HTTP request body.</span></td></tr><tr><td ><span>	Visible in the URL (e.g., ?id=123)</span></td><td ><span>Hidden from the URL.</span></td></tr><tr><td ><span>Maximum Length Limited 2000 characters</span></td><td ><span>No significant limit.</span></td></tr><tr><td ><span>Use Case	For retrieving data (search, filters, links)</span></td><td ><span>For submitting sensitive or large data (login, form submission).</span></td></tr><tr><td ><span>Not Security visible in browser history and server logs</span></td><td ><span>More secure for confidential data.</span></td></tr><tr><td ><span>Can be cached</span></td><td ><span>Not cached</span></td></tr><tr><td ><span>echo $_GET['name'];</span></td><td ><span>echo $_POST['email'];</span></td></tr></tbody></table></div>
 
 
 
 <div class="mb-12">
 <div class="question"> 
 <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What is the difference between the echo  and print?</h2>
 </div>
 
 <table><thead><tr><th style="width:350px;"><span>Echo</span></th><th style="width:350px;"><span>Print</span></th></tr></thead><tbody><tr><td ><span>echo can output one or more strings.</span></td><td ><span>print can only output one string and it always returns 1.</span></td></tr><tr><td ><span>	echo is faster than print because it does not return any value.</span></td><td ><span>print is slower compared to echo.</span></td></tr><tr><td ><span>If you want to pass more than one parameter to echo, a parenthesis should be used.</span></td><td ><span>Use of parenthesis is not required with the argument list.</span></td></tr><tr><td ><span>Supports multiple arguments: echo "A", "B";</span></td><td ><span>Only one argument: print("A");.</span></td></tr></tbody></table></div>
 
 <div class="mb-12">
 <div class="question">  
 <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What does PEAR stands for?</h2>
 </div>
 <p class="text-lg text-gray-700"><strong>PEAR</strong> stands for <strong>“PHP Extension and Application Repository”.</strong> PEAR is a framework and repository for all of the reusable PHP components.</p><p class="text-lg text-gray-700">A structured library of open-source code for PHP developers.</p><p class="text-lg text-gray-700">A command-line tool to install packages.</p><p class="text-lg text-gray-700">A standardized way to write and share PHP code.</p></div>
 
 
 <div class="mb-12">
  <div class="question"> 
 <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What is Variables in PHP?</h2>
 </div>
 <p class="text-lg text-gray-700"><strong>Variables</strong>are "containers" for storing information.</p><p class="text-lg text-gray-700"> <strong>$ sign</strong> A variable starts with the $ sign, followed by the name of the variable.</p><p class="text-lg text-gray-700"><strong>Underscore variable </strong>A variable name must start with a letter or the underscore character.</p><p class="text-lg text-gray-700"><strong>Number variable</strong>A variable name cannot start with a number.</p><p class="text-lg text-gray-700"><strong>Alpha numeric</strong>A variable name can only contain alpha-numeric characters and underscores (A-z, 0-9, and _ )</p><p class="text-lg text-gray-700"><strong>Case sensitive</strong>Variable names are case-sensitive ($age and $AGE are two different variables)</p>
 <div class="example">
 <div class="code">
 <code>$a = '1';<br>
   echo $b = &amp;<br>
   $a; <br>
   echo $c= "2$b"; <br>
   First Output: 1; <br>
   Second Output: 21;<br>
  
 $i = 5; <br>
 echo $i++; // 5<br>
  echo $i++; // 6<br>
   echo ++$i; // 8 <br>
   echo $i //8
  </code></div>
 </div>
 </div>
 
 <div class="mb-12">
 <div class="question">  
 <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What is the difference between ASP.NET and PHP?</h2>
 </div>
 <table><thead><tr><th style="width:350px;"><span>ASP.NET</span></th><th style="width:350px;"><span>PHP</span></th></tr></thead><tbody><tr><td ><span>A web application framework.</span></td><td ><span>A server-side scripting language.</span></td></tr><tr><td ><span>It is designed for use on Windows</span></td><td ><span>It is Platform independent.</span></td></tr><tr><td ><span>Code is compiled and executed.</span></td><td ><span>Interpreted mode of execution.</span></td></tr><tr><td ><span>It has a license cost associated with it.</span></td><td ><span>PHP is open-source and freely available.</span></td></tr></tbody></table></div>
 
 
 <div class="mb-12">
 <div class="question">  
 <h2 class="text-3xl font-bold text-primary mt-5 mb-4">Explain the main types of errors.</h2>
 </div>
 <p class="text-lg text-gray-700"><strong>Notices</strong> Notices are non-critical errors that can occur during the execution of the script. These are not visible to users.</p><p class="text-lg text-gray-700"><strong>Warnings:</strong> error are more critical than notices. Warnings don’t interrupt the script execution. By default, these are visible to the user. Example: include() a file that doesn’t exist..</p><p class="text-lg text-gray-700"><strong>Fatal:</strong> This is the most critical error type and Happens when PHP cannot continue execution. example:  require() a non-existent file</p><p class="text-lg text-gray-700"><strong>ini_set('display_errors', 1):</strong>Purpose of display errors on the browser screen. </p><p class="text-lg text-gray-700"><strong>ini_set('display_startup_errors', 1):</strong> Purpose of PHP to display errors that occur during PHPs startup sequence.</p><p class="text-lg text-gray-700"><strong>error_reporting(E_ALL):</strong>Purpose of which types of errors should be reported,  Report all types of errors display. </p><p class="text-lg text-gray-700"><strong>ini_set('display_errors', 0):</strong>Purpose of Disables error display , Do not show errors to users. </p><p class="text-lg text-gray-700"><strong>ini_set('log_errors', 1):</strong>When set to 1, Log errors to a file. </p></div>
 
 
 
 <div class="mb-12">
 <div class="question">  
 <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What is the difference between the in_array() and is_array() and array_search functions?</h2>
 </div>
 <p class="text-lg text-gray-700"><strong>is_array()</strong> <span class="shadow-lg p-2">Checks if a variable is an array.</span></p>
 
  <xmp> if (is_array($data)) </xmp></pre><p class="text-lg text-gray-700"><strong>in_array():</strong>Checks if a value exists in an array.</p> 
  
 <xmp> if (in_array('green', $colors)) </xmp></pre><p class="text-lg text-gray-700"><strong>array_search():</strong>Searches an array for a value and returns the key/index if found.</p>
 
  <xmp> $key = array_search('green', $colors); </xmp></div>
 
 
 <div class="mb-12">
 <div class="question">  
 <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What is Composer?</h2>
 </div>
 <p>Composer is a dependency management tool for PHP.</p><p>It allows you to <strong> install, manage, and update </strong>external libraries (packages) that your project depends on.</p><p class="text-lg text-gray-700"><strong>Composer Update: </strong> update all dependencies to the newest version allosed by your composer.json</p><p>Download and install the latest allowed packages versions</p><p>Update the composer.lock file when you want to upgrade package to newer versions</p><p>When you want to refresh the package list after modifying composer.json and set the path</p><p class="text-lg text-gray-700"><strong>Composer install:</strong>Install dependencies listed in your composer.lock.</p><p> you clone a project pr deploy it to a server </p><p> Read composer.lock and install exact versions of package</p><p> if no composer.lock exist it all back to composer.json and create a composer.lock</p><p class="text-lg text-gray-700"><strong>Composer- dump-autoload:</strong>regenerate the autoload files.</p><p>You are added new classes, removed classes or changed</p><p>Namespaced - but didnot change composer.json</p><p>No package installation or update Happens, just refresh vendor- autoload.php</p></div>
 
 
 <div class="mb-12">
 <div class="question">  
 <h2 class="text-3xl font-bold text-primary mt-5 mb-4">How to wesite optimization?</h2>
 </div>
 <ul><li><p>Implemeting caching machanisms.</p></li><li><p>Efficient algorithems and data structures.</p></li><li><p>Optimizing database query.</p></li><li><p>Removed unnessary join.</p></li><li><p>Remove Un-nessary function.</p></li><li><p>Minimizing database need of</p></li><li><p>Some data store in localization store local</p></li><li><p>Use a CDN (Content Delivery Network): Like Cloudflare or AWS CloudFront</p></li><li><p>Use browser caching to store static files locally.</p></li><li><p>Compress images: Use tools like TinyPNG or WebP format.</p></li><li><p>Lazy load images and videos to reduce initial load time.</p></li><li><p>Use responsive design (CSS media queries or frameworks like Bootstrap).</p></li><li><p>Use indexing for faster queries and Use pagination or limit results for large data sets.</p></li><li><p>Code Remove unused scripts and styles.</p></li><li> <p>Use HTTPS (SSL certificate) , Keep software, plugins, and libraries up-to-date, Sanitize and validate all user input.</p></li>

 <li> <p>Website speed optimization: Reducing file sizes, optimizing images, enabling browser caching</p></li>
 <li> <p>for Website optimization is check of using gtmetrix,PageSpeed Insights or https://pagespeed.web.dev/</p></li>

</ul></div>
 
 
 <div class="mb-12">
 <div class="question">  
 <h2 class="text-3xl font-bold text-primary mt-5 mb-4">Explain the __construct() and __destruct () method in PHP.</h2>
 
 </div>
 <p class="text-lg text-gray-700"><strong>__construct():</strong> If you create a __construct() function, php will automatically call this function when you create an object from a class.</p><ul class="mt-2 bg-gray-200 p-4 shadow-lg"><li class="bg-white p-3 border-l-4 border-green-500 text-sm"><div class="example">
 <div class="code">
  
 <code>
class Mobile {<br>
  &nbsp public $name;<br>
  &nbsp public $color;<br>

  function __construct($name) {<br>
    &nbsp $this-&gt;name = $name;<br>
  }<br>

  function get_name() {<br>
    &nbsp return $this-&gt;name;<br>
  }<br>
}<br>

$iphone = new Mobile("iphone");<br>
echo $iphone-&gt;get_name();<br>
  </code>

</div>
</div>
</li></ul><p class="text-lg text-gray-700"><strong>__destruct():</strong> If you create a __destruct() function, PHP will automatically call this function at the end of the script.</p><ul class="mt-2 bg-gray-200 p-4 shadow-lg"><li class="bg-white p-3 border-l-4 border-green-500 text-sm">
  <div class="example">
 <div class="code">
  
<code>
class Mobile {<br>
  &nbsp public $name;<br>
  &nbsp public $color;<br>

  function __construct($name) {<br>
    &nbsp $this-&gt;name = $name;<br>
  }<br>
 function __destruct() {<br>
    &nbsp echo "The Mobile is {$this-&gt;name}.";<br>
  }<br>
  function get_name() {<br>
    &nbsp return $this-&gt;name;<br>
  }<br>

}<br>

$iphone = new Mobile("iphone");<br>
echo $iphone-&gt;get_name();<br>
  </code></div></div>



</li></ul></div>
  
  
  <div class="mb-12">
  <div class="question">   
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">Explain the significance of the header() function in PHP.</h2>
  </div>
  <p class="text-lg text-gray-700"><strong>The header()</strong>  function in PHP is used to send raw HTTP headers to the browser before any output is sent..</p><p class="text-lg text-gray-700"><strong> Syntax:</strong> header(string $header, bool $replace = true, int $response_code = 0);.</p><p class="text-lg text-gray-700"><strong> Redirecting a Page:</strong> header("Location: https://example.com"); exit;.</p><p class="text-lg text-gray-700"><strong>Setting Content-Type:</strong> header("Content-Type: application/json");</p><p class="text-lg text-gray-700"><strong>Force File Download:</strong><ul><li>header("Content-Disposition: attachment; filename=\"file.pdf\"");</li><li>header("Content-Type: application/pdf");</li><li>readfile("file.pdf");</li></ul></p><p class="text-lg text-gray-700"><strong>Custom Status Codes:</strong> header("HTTP/1.1 404 Not Found");</p><p class="text-lg text-gray-700"><strong>Cache Control:</strong><ul><li>header("Cache-Control: no-cache, must-revalidate");</li><li>header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");</li></ul></p><p class="text-lg text-gray-700"><strong>File access Control:</strong><ul><li>header("Access-Control-Allow-Origin: *"); // allow frontend</li><li>header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); // Allow methods</li><li>header("Access-Control-Allow-Headers: Content-Type"); //  Allow headers (like Content-Type)</li><li>header("Access-Control-Allow-Headers: Content-Type, Authorization");</li><li>header("Access-Control-Allow-Credentials: true");</li></ul></p></div>
    
    
    <div class="mb-12">
    <div class="question">   
    <h2 class="text-3xl font-bold text-primary mt-5 mb-4">Explain dependency injection in PHP.</h2>
    </div>
    <p class="text-lg text-gray-700">Dependency Injection (DI) is a design pattern used in PHP to pass dependencies (like objects or services) into a class or Constructor, rather than letting the class create them itself.</p><p class="text-lg text-gray-700"><strong> Simple Definition:</strong> Dependency Injection is a technique where an object receives other objects it depends on, instead of creating them internally.</p><p class="text-lg text-gray-700"><strong> Constructor Injection:</strong> Most common; dependencies passed via the constructor.</p><p class="text-lg text-gray-700"><strong>Setter Injection:</strong> Dependencies passed via public setter methods.</p><p class="text-lg text-gray-700"><strong>Interface Injection:</strong>Dependency passed via an interface method.</p><ul class="mt-2 bg-gray-200 p-4 shadow-lg"><li class="bg-white p-3 border-l-4 border-green-500 text-sm"><div class="example">
 <div class="code">
    <code>class Database {<br>
    public function connect() {<br>
        &nbsp return "Connected to DB";<br>
    }<br>
}<br>

class UserService {<br>
    private $db;<br>

    // Dependency Injection via constructor
    public function __construct(Database $db) {<br>
        &nbsp $this-&gt;db = $db;<br>
    }<br>

    public function getUser() {<br>
        &nbsp return $this-&gt;db-&gt;connect();<br>
    }<br>
}<br>

// Inject dependency from outside<br>
$db = new Database();<br>
$userService = new UserService($db);<br>
echo $userService-&gt;getUser()<br>

</code></div></div></li></ul></div>


<div class="mb-12">
<div class="question">   
<h2 class="text-3xl font-bold text-primary mt-5 mb-4">What's the significance of PSR standards in PHP?</h2>
</div>
<p class="text-lg text-gray-700"><strong>PSR</strong> PHP Standard recommendation.</p><p>ites a set of coding standards and guidelines for php designed to promote consistency</p><p class="text-lg text-gray-700"><strong>PSP-1:</strong> basic coding standard defines basic rules like using 

 php tags, properClass naming convestions getClassName() <br>

</p><p class="text-lg text-gray-700"><strong>PSR-2:</strong>Coding style guid, code formating rules like indentation, line lenght,spacing.</p><p class="text-lg text-gray-700"><strong>PSR-12:</strong> extended coding style guide -code formatting including whitespace, visibility and method declaration.</p><p class="text-lg text-gray-700"><strong>PSR-4:</strong>Autoloading standard - autoloading classes using namespaces , its widly used.</p><p class="text-lg text-gray-700"><strong>PSR-7:</strong>HTTP message interface- http request and responses.</p><p class="text-lg text-gray-700"><strong>PSR-11:</strong>container interface.</p><p class="text-lg text-gray-700"><strong>PSR-14:</strong>Event dispatches.</p><p class="text-lg text-gray-700"><strong>PSR-15:</strong>HTTP server request handles.</p></div>


<div class="mb-12">
<div class="question">  
<h2 class="text-3xl font-bold text-primary mt-5 mb-4">What's the OOPs PHP?</h2>
</div>
<p class="text-lg text-gray-700"><strong>Class: </strong>Classes define the blueprint for creating objects.</p><p class="text-lg text-gray-700"><strong>Object:</strong> Objects are instance of classes an instance of a class containing real data and behavior.</p><p class="text-lg text-gray-700"><strong>Encapsulation:</strong>Encapsulation involves restricting access to certain class members to prevent direct modification from outside the class with the help of getters and setters.</p><p class="text-lg text-gray-700"><strong>Access Modifies:</strong><ul><li><strong>Public:</strong> Accessible from any where - inside or outside the class.</li><li><strong>Protected:</strong> Accessible within the class and by inheriting class or derived class.</li><li><strong>Private:</strong>Accessible only within the class itself. </li><li><strong>Getters:</strong>Allow you to retrieving the value of private properties. </li><li><strong>Setters:</strong>Allow you to modify the values of private properties sately.</li></ul><ul class="mt-2 bg-gray-200 p-4 shadow-lg"><li class="bg-white p-3 border-l-4 border-green-500 text-sm">
  <div class="example">
 <div class="code">
  

<code>
     
class user {
  &nbsp public $name;
 
 
 
 public function setName($newName) {
    &nbsp return $this-&gt;name = $newName;
  }
 
 public function getName() {
   &nbsp return $this-&gt;name;
  }
}

$user = new user();
echo $user-&gt;setName('codekredit');
echo $user-&gt;getName();
echo $user-&gt;name(); // error connot access private properties
  
  </code></div></div></li></ul></p>
  
  <p class="text-lg text-gray-700"><strong>Inheritance:</strong> a class can inherit properties and methods from another class. </p>
  <p class="text-lg text-gray-700"><strong>Polymorphism:</strong> a methods can behave differently based on the object calling them . </p>
  
  <p class="text-lg text-gray-700"><strong>Overloading and Overriding :</strong> </p>
    <p>
   <strong>Overloading :</strong> Function overloading contains same function name but different argument passing.</p>
   
   <p>PHP overloading not supports</p>
   
   <p>Overloading in PHP refers to dynamically creating properties or methods at runtime using magic methods like:_get() __set(), __call() (for methods) ,__isset() / __unset()</p> 
  
  <div class="example">
 <div class="code">
    
  
  
  <code>
   
class OverloadExample {<br>
    &nbsp public function __call($name, $arguments) {<br>
        &nbsp echo "Method $name called with arguments: " . implode(', ', $arguments);<br>
    }<br>
}<br>

$obj = new OverloadExample();<br>
$obj-&gt;hello('Aryan'); // Triggers __call()<br>
 
  </code>

</div></div>

<p><strong>Overriding :</strong> same properies overriding both parent and child classes should have same funciton and argument.</p>

    <div class="example">
 
<div class="code"> 
  
class ParentClass {<br>
   &nbsp public function greet() {<br>
      &nbsp  echo "Hello from Parent";<br>
    }<br>
}<br>

class ChildClass extends ParentClass {<br>
    &nbsp public function greet() {<br>
       &nbsp echo "Hello from Child";<br>
    }<br>
}<br>

$obj = new ChildClass();<br>
$obj-&gt;greet(); // Output: Hello from Child<br>
 
</div> </div>

 
  
  <p class="text-lg text-gray-700"><strong>Abstract Class and Interface class :</strong> </p>
  
  
  
  </div>
  
  <div class="mb-12">
      
      
  <table><thead><tr><th style="width:350px;"><span>Abstract</span></th><th style="width:350px;"><span>Interface</span></th></tr></thead><tbody><tr><td ><span>Abstract class can have both defined method and property.</span></td><td ><span>Interface only can have method signature</span></td></tr><tr><td ><span>Abstract class cannot be create object only extends</span></td><td ><span>Interface cannot create object instantiated only Implements.</span></td></tr><tr><td ><span>Abstract Class can have modify access public, protected, private methods.</span></td><td ><span>Interface class methods are access public.</span></td></tr><tr><td ><span>Abstract class can have constructor.</span></td><td ><span>Cannot have a constructor</span></td></tr><tr><td ><span>Child classes must extend the abstract class and implement its abstract methods.</span></td><td ><span>A class that implements an interface must implement all its methods.</span></td></tr><tr><td ><span>Abstract class single inheritance(one class).</span></td><td ><span>Interface class multiple inheritance </span></td></tr>
  
  <tr><td ><div class="example">
 <div class="code">
    
  
  <code>
   
abstract class Animal {<br>
    &nbsp abstract public function makeSound();<br>

    public function sleep() {<br>
        &nbsp echo "Sleeping";<br>
    }<br>
}<br>

class Dog extends Animal {<br>
   &nbsp public function makeSound() {<br>
       &nbsp echo "Woof";<br>
    }<br>
}<br>

$dog = new Dog();<br>
$dog-&gt;makeSound(); // Output: Woof!<br>
$dog-&gt;sleep();     // Output: Sleeping...<br>


$test = New Animal(); // wrong not direct object create<br>
  </code>

</div></div></td><td >
    
  
  <div class="example">
 <div class="code"><code>
 
interface Shape {<br>
    &nbsp public function area();<br>
    &nbsp public function perimeter();<br>
}<br>
 
class Circle implements Shape {<br>
    &nbsp private $radius;<br>

    &nbsp public function __construct($r) {<br>
        &nbsp &nbsp $this-&gt;radius = $r;<br>
    }<br>

    public function area() {<br>
       &nbsp return pi() * $this-&gt;radius ** 2;<br>
    }<br>

    public function perimeter() {<br>
      &nbsp  return 2 * pi() * $this-&gt;radius;<br>
    }<br>
}<br>

$circle = new Circle(5);<br>
echo $circle-&gt;area(); // Output: 78.539...<br>
   </code></div></div></td></tr></tbody></table>
  </div>

<div class="mb-12">
  <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What is Static Class?</h2>
  </div>
  <p class="text-lg text-gray-700">A<strong> static</strong> class is a class that cannot be instantiated and  can’t create objects.</p>
  <p>Only contains static methods and variables.</p>
  <p>PHP does not have a "static class" keyword, but you can make all methods static:</p>
<div class="example">
 <div class="code">
 
<code>  class MathHelper {<br>
    public static function add($a, $b) {<br>
       &nbsp return $a + $b;<br>
    }<br>
}<br>

$result = MathHelper::add(4, 6); // call :: <br>
  
</code>
</div>
</div>



</div>
  
  
  

<div class="mb-12">
  <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What is Final Class?</h2>
  </div>
  <p class="text-lg text-gray-700">A<strong> Final Class </strong> cannot be extended any other class.</p>
   <p class="text-lg text-gray-700">A<strong> Final method </strong> cannot be overridden by subclasses.</p>
   
   <div class="example">
 
<div class="code">
 
<code> final class Car {<br>
    public function drive() {<br>
      &nbsp  echo "Drivering the car";<br>
    }<br>
}<br>

$car = New Car();<br>
$car->drive();<br>
 
</code>
</div>
</div>



</div>
  
  


<div class="mb-12">
  <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What are SOLID principles?</h2>
  </div>
  <ul><li>
 <strong>S – Single Responsibility Principle (SRP)</strong> 
<p>A class should have one responsibility and only one reason to change.</p>
<p>Each class should do only one job.</p>
<div class="example">
 
<div class="code">
 
<code> // ❌ Bad: One class handles both user data and email<br>
class User {<br>
&nbsp public function save() { /* Save user */ }<br>
   &nbsp public function sendEmail() { /* Send email */ }<br>
}<br>

// ✅ Good: Split responsibilities<br>
class User {<br>
    &nbsp public function save() { /* Save user */ }<br>
}<br>

class EmailService {<br>
    &nbsp public function sendEmail(User $user) { /* Send email */ }<br>
}<br>
 
</code>
</div>
</div>
</li><li>

<strong>O – Open/Closed Principle (OCP)</strong>
<p>A class should be open for extension, but closed for modification</p> 
<p>You should be able to extend a class's behavior without modifying it..</p>
<div class="example">
 
<div class="code notranslate htmlHigh">
 
<code> // ❌ Bad: Need to change this class every time we add a new payment method<br>
class Payment {<br>
    public function pay($type) {<br>
        if ($type == 'paypal') { /* PayPal logic */ }<br>
        if ($type == 'card') { /* Card logic */ }<br>
    }<br>
}<br>

// ✅ Good: Use inheritance to extend behavior<br>
interface PaymentMethod {<br>
    public function pay();<br>
}

class PayPal implements PaymentMethod {<br>
    public function pay() { echo "Pay with PayPal"; }<br>
}

class CreditCard implements PaymentMethod {<br>
    public function pay() { echo "Pay with Card"; }<br>
}<br>

function makePayment(PaymentMethod $payment) {<br>
    $payment->pay();<br>
}<br>
 
</code>
</div>
</div>

</li>

<li>

<strong>L – Liskov Substitution Principle (LSP)</strong>
<p>Objects of a subclass should be substitutable for objects of the superclass without altering correctness.</p>
<p>Subtypes must be substitutable for their base types.</p>
<p>Any child class should be usable in place of the parent class without breaking the app.</p>
<div class="example">
 
<div class="code">
 
<code> class Bird {<br>
    public function fly() { echo "Flying"; }<br>
}<br>

class Ostrich extends Bird {<br>
    public function fly() { throw new Exception("I can't fly"); } // ❌ Violates LSP<br>
}<br>

//Fix by restructuring the hierarchy:<br>

 
abstract class Bird { }<br>

class FlyingBird extends Bird {<br>
    public function fly() { echo "Flying"; } //right<br>
}<br>

class Ostrich extends Bird { }<br>
 
</code>
</div>
</div>
</li><li> 
<strong>I – Interface Segregation Principle (ISP)</strong>
<p>A client should not be forced to implement interfaces it does not use.</p>
<p>Split large interfaces into smaller, more specific ones.</p>
<div class="example">
 
<div class="code">
 
<code> // ❌ Bad: Animal interface forces all to implement fly()<br>
interface Animal {<br>
    public function eat();<br>
    public function fly();<br>
}<br>

class Dog implements Animal {<br>
    public function eat() { <br>
      echo "Dog eating"; <br>
    }<br>
    public function fly() {<br>

     } <br>
     // ❌ Dog can't fly<br>
}<br>

// ✅ Good: Separate interfaces<br>
interface Animal {<br>
    public function eat();<br>
}<br>

interface Flyable {<br>
    public function fly();<br>
}<br>

class Dog implements Animal {<br>
    public function eat() { 
      echo "Dog eating";<br>
     }<br>
}<br>

class Bird implements Animal, Flyable {<br>
    public function eat() { <br>
      
      echo "Bird eating"; <br>
    }<br>
    public function fly() { <br>
      
      echo "Bird flying";<br>
    
    }<br>
}<br>

 
</code>
</div>
</div>

</li>

<li> 
<strong>D – Dependency Inversion Principle (DIP)</strong>
<p>Depend on abstractions, not on concretions.</p>
<p>High-level modules should not depend on low-level modules. , but both should depend on abstractions Or interfaces.</p>
 <div class="example">
 
<div class="code">
 
<code> // ❌ Bad: Tightly coupled<br>
class MySQL {<br>
    public function connect() { <br>
      
      /* MySQL connection */<br>
    
    }<br>
}<br>

class App {<br>
    private $db;<br>
    public function __construct() {<br>
        $this->db = new MySQL(); // tightly coupled<br>
    }<br>
}<br>

// ✅ Good: Use an interface<br>
interface Database {<br>
    public function connect();<br>
}<br>

class MySQL implements Database {<br>
    public function connect() { <br>
      
      /* MySQL connection */<br>
    
    }<br>
}<br>

class MongoDB implements Database {<br>
    public function connect() { <br>
      
      /* MongoDB connection */ <br>
    
    }<br>
}<br>

class App {<br>
    private $db;<br>
    public function __construct(Database $db) {<br>
        $this->db = $db;<br>
    }<br>
}<br>

 
</code>
</div>
</div>
</li>

</ul>


</div>
  













  
  <div class="mb-12">
  <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What is MVVM?</h2>
  </div>
  <p class="text-lg text-gray-700"><strong>MVVM</strong> stands for Model-View-ViewModel.</p><p class="text-lg text-gray-700"><strong>Model:</strong> The Model represents the data and business logic of the application.</p><p class="text-lg text-gray-700"><strong>View:</strong> The View is the user interface of the application. It is responsible for displaying the data that the Model provides.</p><p class="text-lg text-gray-700"><strong>Controller:</strong> The Controller acts as an intermediary between the Model and the View.</p><p class="text-lg text-gray-700"><strong>ViewModel:</strong> The ViewModel serves as the middle-man between the Model and the View.</p></div>
  
  
  
  <div>
  <div class="question">   
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What design pattern?</h2>
  </div>
  <ul class="space-y-4"><li><strong>1. Factory Pattern:</strong> a method that creates and returns objects without exposing the instantiation logic<ul class="mt-2 bg-gray-200 p-4 shadow-lg"><li class="bg-white p-3 border-l-4 border-green-500 text-sm">
     <div class="example">
 
<div class="code"> 
  
  class Automobile {<br>
  private $bikeMake;<br>
  public function __construct($make, $model) {<br>
    $this-&gt;bikeMake = $make;<br>
  }<br>
  public function getMakeAndModel() {<br>
    return $this-&gt;bikeMake;<br>
  }<br>
}<br>
class AutomobileFactory {<br>
  public static function create($make, $model) {<br>
    return new Automobile($make, $model);<br>
  }<br>
}<br>
$pulsar = AutomobileFactory::create('ktm', 'Pulsar');<br>
print_r($pulsar-&gt;getMakeAndModel());<br>

 

</div></div>
</li></ul></li><li><strong>2. Singleton:</strong> make sure that a class has one instance of a class that is produced like database connection and mailer class<ul class="mt-2 bg-gray-200 p-4 shadow-lg"><li class="bg-white p-3 border-l-4 border-green-500 text-sm">
  
<div class="example"> 
<div class="code"> 
 class Singleton {<br>
  private static $instance;<br>
  private function __construct() {<br>
  }  <br>
  
  private function __clone() {<br>

  }<br>
} <br>

public static function getInstance() {<br>
    if (self::$instance === null) {<br>
      self::$instance = new Singleton();<br>
    }<br>
    return self::$instance;<br>
  }<br>
 
$singleton = Singleton::getInstance(); 

</div></div>
</li></ul></li><li><strong>3. Repository Pattern:</strong> It is a collection of domain objects, acting like an in-memory collection. The repository is responsible for providing access to data.</li><li><strong>4. Observer Pattern:</strong> Allows a subject to notify a list of observers when its state changes.<ul class="mt-2 bg-gray-200 p-4 shadow-lg"><li class="bg-white p-3 border-l-4 border-green-500 text-sm">
  
     <div class="example">
 
<div class="code"> 
 class Subject {<br>
  private $observers = [];<br>
  public function addObserver(Observer $observer) {<br>
    $this-&gt;observers[] = $observer;<br>
  }<br>
  public function notifyObservers($state) {<br>
    foreach ($this-&gt;observers as $observer) {<br>
      $observer-&gt;update($state);<br>
    }<br>
  }<br>
}<br>
$subject = new Subject();<br>
$observer1 = new ConcreteObserver();<br>
$observer2 = new ConcreteObserver();<br>
$subject-&gt;addObserver($observer1);<br>
$subject-&gt;addObserver($observer2);<br>
$subject-&gt;notifyObservers("New state");<br>

 

</div></div>
</li></ul></li></ul></div>

</div>


</section>
  



 

  


 
 


 </div>
 
<br>
<div class="clear nextprev">
<a class="left btn" href="{{url('interviews/php-interview-question-answer')}}">&#10094; Previous</a>
<a class="right btn" href="{{url('interviews/mysql-interview-question-answer')}}">Next &#10095;</a>
</div>
</div>
 
</div>
 
  
  @endsection