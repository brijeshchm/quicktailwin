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
       
<h1>Javascript<span class="color_h1"> Interview Question & Answer</span></h1>
<div class="clear nextprev">
<a class="left btn" href="{{url('interviews/laravel-interview-question-answer')}}">&#10094; Previous</a>
<a class="right btn" href="{{url('interviews/reactjs-interview-question-answer')}}">Next &#10095;</a>
</div>
<hr>
 <div class="light">
 <p>HTML, which stands for HyperText Markup Language, is the standard language used to create and structure content on the web. It consists of a set of elements, each represented by tags, which are used to define the structure and appearance of a web page. Here's a basic overview of HTML:</p>
 
 <ul><li>
 
 <p><strong>HTML Document Structure:</strong>
An HTML document starts with a declaration and consists of the following main parts:</p>
 

<div class="example">
<h3>Example</h3>
 
<div class="code notranslate htmlHigh">
&lt;!DOCTYPE html&gt;&lt;!-- Declaration --&gt;<br>&lt;html&gt;<br>&lt;head&gt;<br>&lt;title&gt;Page Title&lt;/title&gt;<br>&lt;/head&gt;<br>&lt;body&gt;<br> &lt;!-- Content goes here --&gt;<br><br>&lt;/body&gt;<br>&lt;/html&gt;

</div>
</div>
 
 
 

  </li>


<li><p><strong>Head Section:</strong>
The <code>&lt;head&gt;</code> section contains meta-information about the document and links to external resources. The <code>&lt;title&gt;</code> tag sets the title displayed in the browser's title bar or tab.</p></li><li><p><strong>Body Section:</strong>
The <code>&lt;body&gt;</code> section contains the visible content of the web page.</p></li>


<li><p><strong>Text and Headings:</strong>
Use headings from <code>&lt;h1&gt;</code> to <code>&lt;h6&gt;</code> for various levels of headings and the <code>&lt;p&gt;</code> tag for paragraphs.</p>

 <div class="example">
<h3>Example</h3>
<div class="code notranslate htmlHigh">
 &lt;h1&gt; Main Heading&lt;/h1&gt;<br>&lt;p&gt;  This is a paragraph of text.&gt; &lt;/p&gt;  
 </div>
 </div>
 
  


</li>

<li><p><strong>Links:</strong>
The <code>&lt;a&gt;</code> tag is used to create hyperlinks.</p> 
<div class="example">
<h3>Example</h3>
<div class="code notranslate htmlHigh">
 &lt;a&gt; https://www.example.com  &lt;/a&gt;
 </div> 
 </div> 
 
 
</li>
<li><p><strong>Images:</strong>
The <code>&lt;img&gt;</code> tag is used to display images.</p>
<div class="example">
<h3>Example</h3>
<div class="code notranslate htmlHigh">
 &lt;src src="image.jpg" alt="image of alt"&gt;
 </div>
 </div>
 
 
  </li>
  <li><p><strong>Lists:</strong>
Use <code>&lt;ul&gt;</code> for an unordered list and <code>&lt;ol&gt;</code> for an ordered list. List items are created with <code>&lt;li&gt;</code>.</p>

<div class="example">
<h3>Example</h3>
<div class="code notranslate htmlHigh">
&lt;ul&gt;<br>
	&lt;li&gt; Item 1 &lt;/li&gt;<br>
	&lt;li&gt; Item 2 &lt;/li&gt;<br>
&lt;/ul&gt;
</div>
</div>
 
 
<pre></pre></li>

<li><p><strong>Forms:</strong>
Forms are created using the <code>&lt;form&gt;</code> tag and contain input elements like text fields, radio buttons, checkboxes, etc.</p>
<div class="example">
<h3>Example</h3>
<div class="code notranslate htmlHigh">
&lt;form action="submit.php" method="post"&gt;<br>
	&lt;input type="text" name="username" placeholder="Username"&gt;  <br>
	&lt;input type="password" name="password" placeholder="Password"&gt; <br>
	&lt;input type="submit" value="Submit"&gt; <br>
&lt;/form&gt;
</div>
</div>


</li><li><p><strong>Comments:</strong>
Comments can be added to the code using 

<code>&lt;!-- comment text --&gt;</code>.</p></li><li><p><strong>Basic Formatting:</strong>
For basic text formatting, you can use the <code>&lt;strong&gt;</code> tag for bold and <code>&lt;em&gt;</code> tag for italic.</p>
<div class="example">
<h3>Example</h3>
<div class="code notranslate htmlHigh">
&lt;p&gt; This is&lt;strong&gt;bold&lt;/strong&gt; and this is &lt;em&gt; italic&lt;/em&gt;text.&lt;/p&gt;<br>
 
</div>
</div>
</li></ul>
 </div>
 
<br>
<div class="clear nextprev">
<a class="left btn" href="{{url('interviews/laravel-interview-question-answer')}}">&#10094; Previous</a>
<a class="right btn" href="{{url('interviews/reactjs-interview-question-answer')}}">Next &#10095;</a>
</div>
</div>
 
</div>
 
   @endsection