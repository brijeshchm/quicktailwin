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
       
<h1>Technical<span class="color_h1"> Interview Question & Answer</span></h1>
<div class="clear nextprev">
<a class="left btn" href="{{url('interviews/mysql-interview-question-answer')}}">&#10094; Previous</a>
<a class="right btn" href="{{url('interviews/laravel-interview-question-answer')}}">Next &#10095;</a>
</div>
<hr>
  <div class="light">
  
 <section id="services-section" class="py-12 bg-gray-100">
  <div class="container mx-auto px-4">
  
 
 <div class="mb-12">
 <div class="question"> 
 <h2 class="text-3xl font-bold text-primary mt-5 mb-4">Find two value add value return value are equil?</h2>
 </div>
  <div class="example">
 <div class="code">
 <code>
  <xmp>
$array = array(2,7,11,15,18); 
for($i=0; $i <count($array);$i++){ 
  for($j= $i+1; $j<count($array);$j++){ 
   $sum = $array[$i] + $array[$j]; 
   if($sum == 9){ 

   echo "Index of $array[$i] 
    $array[$j] is $sum\n"; 

   } 
  } 
} 

// output 2 7
</xmp>
 </code>
</div>
</div>
</div>
 
 <div class="mb-12">
 <div class="question"> 
 <h2 class="text-3xl font-bold text-primary mt-5 mb-4">Write program factorial in php?</h2>
 </div>
  
 <div class="example">
 <div class="code">
 <code>
  <xmp>
 function factorial($n){

if($n<=1){
 return 1;
}
return $n * factorial ($n-1);
 }
 echo factorial(5);
</xmp>
 </code>
</div>
</div>
</div>
 
 
 <div class="mb-12">
 <div class="question"> 
 <h2 class="text-3xl font-bold text-primary mt-5 mb-4">Find Odd and Even without loop?</h2>
 </div>
  
 <div class="example">
 <div class="code">
 <code>
  <xmp>
 "First Program"; 
 $a[0] = "Even";
 $a[1] = "Odd";
 echo $a[5%2]; // Output Odd


 "Second Program"; 
 $array  = array('Even','Odd');
 $number = 5;
 echo $array[$number%2];


"Third Program"; 
 $n = 6;
 if($n&1){
echo "Odd";
 }else{
 echo "Even"; // Output Even

 }

</xmp>
 </code>
</div>
</div>
</div> 



  
 
 
 <div class="mb-12">
 <div class="question"> 
 <h2 class="text-3xl font-bold text-primary mt-5 mb-4">Second Max value in array?</h2>
 </div>
  
 <div class="example">
 <div class="code">
 <code>
  <xmp>
 function findSecondMax($arr) {
    $max = 0;
    $secondMax = 0;

    foreach ($arr as $num) {
        if ($num > $max) {
            $secondMax = $max;
            $max = $num;
        } elseif ($num < $max && $num > $secondMax) {
            $secondMax = $num;
        }
    }

    return $secondMax ?$secondMax: "No second maximum exists";
}

// Example usage:
echo findSecondMax([5, 3, 8, 1, 9, 2]); // Output: 8
echo findSecondMax([1, 1, 1]); // Output: No second maximum exists
echo findSecondMax([7, 7, 7]); // Output: No second maximum exists
echo findSecondMax([10, 5, 8, 12, 3]); // Output: 10
 

</xmp>
 </code>
</div>
</div>
</div> 
  
 
 
 
 <div class="mb-12">
 <div class="question"> 
 <h2 class="text-3xl font-bold text-primary mt-5 mb-4">Write a program sort array in php?</h2>
 </div>
  
 <div class="example">
 <div class="code">
 <code>
  <xmp>
  $arr = [64, 34, 25, 12, 22, 11, 90];
 $n = count($arr);
    
    // Outer loop for passes
    for ($i = 0; $i < $n; $i++) {
        // Inner loop for comparisons
        for ($j = $i+1; $j < $n; $j++) {
            // Compare adjacent elements
            if ($arr[$i] > $arr[$j]) {
                // Swap if they are in wrong order
                $temp = $arr[$i];
                $arr[$i] = $arr[$j];
                $arr[$j] = $temp;
            }
        }
    }
    
    echo "<pre>";print_r($arr);
//Output
[0] => 11
[1] => 12
[2] => 22
[3] => 25
[4] => 34
[5] => 64
[6] => 90
</xmp>
 </code>
</div>
</div>
</div> 
  
 
 
 <div class="mb-12">
 <div class="question"> 
 <h2 class="text-3xl font-bold text-primary mt-5 mb-4">Write a program prime number in php?</h2>
 </div>
  
 <div class="example">
 <div class="code">
 <code>
  <xmp>
  function isPrime($num) {
    if ($num <= 1) {
        return false;
    }
    for ($i = 2; $i < $num; $i++) {
        if ($num % $i == 0) {
            return false; 
        }
    }

    return true; 
}
$number = 7;
if (isPrime($number)) {
    echo "$number is a prime number.";
} else {
    echo "$number is not a prime number.";
}
</xmp>
 </code>
</div>
</div>
</div> 
 



 <div class="mb-12">
 <div class="question"> 
 <h2 class="text-3xl font-bold text-primary mt-5 mb-4">Write a program palindrome number in php?</h2>
 </div>
  
 <div class="example">
 <div class="code">
 <code>
  <xmp>
  Step First string

  function Palindrome($string){  
    if (strrev($string) == $string){  
        return 1;  
    }
    else{
        return 0;
    }
}  

// Driver Code
$original = "DADDAD"; 
if(Palindrome($original)){  
    echo "Palindrome";  
} 
else {  
echo "Not a Palindrome";  
}

//Second Program  string without pre-difine function

 //without pre-define function
function isPalindrome($str) {    
    $i = 0;
    $j = strlen($str) - 1;  
    while ($i < $j) {        
        if ($str[$i] !== $str[$j]) {
            return false;  
        }
        $i++;   
        $j--;  
	}    
    return true;  
}
$string = "aabbaa";
if (isPalindrome($string)) {
    echo "$string is a palindrome!";
} else {
    echo "$string is not a palindrome!";
}

//Third program

$number = 12121;
$temp = $number;
$reverse = 0;

// Reverse the number
while ($temp > 0) {
    $digit = $temp % 10;
    $reverse = ($reverse * 10) + $digit;
    $temp = (int)($temp / 10);
}

// Check if original and reversed are the same
if ($number == $reverse) {
    echo "$number is a palindrome number.";
} else {
    echo "$number is not a palindrome number.";
}

</xmp>
 </code>
</div>
</div>
</div> 
  




 <div class="mb-12">
 <div class="question"> 
 <h2 class="text-3xl font-bold text-primary mt-5 mb-4">write a program array duplicate count number  in php?</h2>
 </div>
  
 <div class="example">
 <div class="code">
 <code>
  <xmp>
 $arr = array(1, 2, 3, 2, 4, 1, 5, 3);  
$length = 0;
$counts = [];
$duplicateCount = 0;
while (isset($arr[$length])) {
    $length++;
}

// Count occurrences of each element
for ($i = 0; $i < $length; $i++) {
    $count = 1;  
    for ($j = $i + 1; $j < $length; $j++) {
        if ($arr[$i] == $arr[$j]) {
            $count++;
        }
    }
    
    $isProcessed = false;
    for ($k = 0; $k < $i; $k++) {
        if ($arr[$k] == $arr[$i]) {
            $isProcessed = true;
            break;
        }
    }
    if (!$isProcessed) {
        $counts[$arr[$i]] = $count;
        if ($count > 1) {
            $duplicateCount++;
        }
    }
}


echo "Duplicate count: $duplicateCount\n";
echo "Element counts:\n";
foreach ($counts as $element => $count) {
    echo "$element appears $count time(s)\n";
}

// Output results

 Array: [1, 2, 3, 2, 4, 1, 5, 3]
Duplicate count: 3
Element counts:
1 appears 2 time(s)
2 appears 2 time(s)
3 appears 2 time(s)
4 appears 1 time(s)
5 appears 1 time(s)

</xmp>
 </code>
</div>
</div>
</div> 
  





 <div class="mb-12">
 <div class="question"> 
 <h2 class="text-3xl font-bold text-primary mt-5 mb-4">write a program array duplicate count string  in php?</h2>
 </div>
  
 <div class="example">
 <div class="code">
 <code>
  <xmp>
    $arr = "abdbabdbaab"; // Example array
$length = 0;
$counts = [];
$duplicateCount = 0;

// Calculate array length manually
while (isset($arr[$length])) {
    $length++;
}

// Count occurrences of each string
for ($i = 0; $i < $length; $i++) {
    $count = 1; // Count current string itself
    for ($j = $i + 1; $j < $length; $j++) {
        if ($arr[$i] === $arr[$j]) {
            $count++;
        }
    }
    // Store count only if not already processed
    $isProcessed = false;
    for ($k = 0; $k < $i; $k++) {
        if ($arr[$k] === $arr[$i]) {
            $isProcessed = true;
            break;
        }
    }
    if (!$isProcessed) {
        $counts[$arr[$i]] = $count;
        if ($count > 1) {
            $duplicateCount++;
        }
    }
}

// Output results
 
 
echo "String counts:\n";
foreach ($counts as $string => $count) {
    echo "$string appears $count time(s)\n";
}

</xmp>
 </code>
</div>
</div>
</div> 
  


 <div class="mb-12">
 <div class="question"> 
 <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What is the output of the following code?</h2>
 </div>
  
 <div class="example">
 <div class="code">
 <code>
  <xmp>
    $array = array(1 => "a", "1" => "b", 1.5 => "c", true => "d");

echo $array[1];


output d

</xmp>
 </code>
</div>
</div>
</div> 
  




 <div class="mb-12">
 <div class="question"> 
 <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What does the following PHP code output, and why?</h2>
 </div>
  
 <div class="example">
 <div class="code">
 <code>
  <xmp>
 
$number = 3;
echo $number;
echo $number++ + $number++;
echo $number;
echo $number-- - $number--;
echo $number;
 

Output
3
7
5
1
3

</xmp>
 </code>
</div>
</div>
</div> 



 <div class="mb-12">
 <div class="question"> 
 <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What does the following PHP code output, and why?</h2>
 </div>
  
 <div class="example">
 <div class="code">
 <code>
  <xmp>
 
$array = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry'];
unset($array['b']);
$result = array_keys($array);

echo implode(", ", $result);
 

Output
a
c
 

</xmp>
 </code>
</div>
</div>
</div> 
  

 <div class="mb-12">
 <div class="question"> 
 <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What will be the output of the code below and why?</h2>
 </div>
  
 <div class="example">
 <div class="code">
 <code>
  <xmp>
  $x = 5;
echo $x;
echo "<br />";
echo $x+++$x++;
echo "<br />";
echo $x;
echo "<br />";
echo $x---$x--;
echo "<br />";
echo $x;

Output
5
11
7
1
5
 

</xmp>
 </code>
</div>
</div>
</div> 
  



 <div class="mb-12">
 <div class="question"> 
 <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What will be the values of $a and $b after the code below is executed?</h2>
 </div>
  
 <div class="example">
 <div class="code">
 <code>
  <xmp>
$a = '1';
$b = &$a;
$b = "2$b";

Output
21
 

</xmp>
 </code>
</div>
</div>
</div> 
  

 <div class="mb-12">
 <div class="question"> 
 <h2 class="text-3xl font-bold text-primary mt-5 mb-4">After the code below is executed, what will be the value of $text and what will strlen($text) return?</h2>
 </div>
  
 <div class="example">
 <div class="code">
 <code>
  <xmp>
$text = 'John ';
$text[10] = 'Doe';

Output
“John      D”
 

</xmp>
 </code>
</div>
</div>
</div> 
  

 <div class="mb-12">
 <div class="question"> 
 <h2 class="text-3xl font-bold text-primary mt-5 mb-4">PHP_INT_MAX is a PHP?</h2>
 </div>
  
 <div class="example">
 <div class="code">
 <code>
  <xmp>
var_dump(PHP_INT_MAX)

Output
 int(9223372036854775807)
 

</xmp>
 </code>
</div>
</div>
</div> 
  


 <div class="mb-12">
 <div class="question"> 
 <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What does the follow code echo?</h2>
 </div>
  
 <div class="example">
 <div class="code">
 <code>
  <xmp>
$a = "PHP";
$a = $a + 1;
echo $a;

Output
Fatal error: Uncaught TypeError string
 

</xmp>
 </code>
</div>
</div>
</div> 
  

 <div class="mb-12">
 <div class="question"> 
 <h2 class="text-3xl font-bold text-primary mt-5 mb-4">HTML Boilerplate Shortcut (Emmet)?</h2>
 </div>
  
 <div class="example">
 <div class="code">
 <code>
  <xmp>
Type: !

Then Press: Tab


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
</head>
<body>
</body>
</html>
 

</xmp>
 </code>
</div>
</div>
</div> 
  





 

</div>


</section>
  



 

  


 
 


 </div>
 
 
<br>
<div class="clear nextprev">
<a class="left btn" href="{{url('interviews/mysql-interview-question-answer')}}">&#10094; Previous</a>
<a class="right btn" href="{{url('interviews/laravel-interview-question-answer')}}">Next &#10095;</a>
</div>
</div>
 
</div>
   
  @endsection