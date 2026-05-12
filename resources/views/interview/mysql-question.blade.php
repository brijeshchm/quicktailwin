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
       
<h1>MySql<span class="color_h1"> Interview Question & Answer</span></h1>
<div class="clear nextprev">
<a class="left btn" href="{{url('interviews/php-interview-question-answer')}}">&#10094; Previous</a>
<a class="right btn" href="{{url('interviews/technical-logic-question-answer')}}">Next &#10095;</a>
</div>
<hr>
<div class="light">
 
 
 <section id="services-section" class="py-12 bg-gray-100"><div class="container mx-auto px-4">
  
  <div class="mb-12">
    <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What is Mysql?</h2>
  </div>
  <p class="text-lg text-gray-700">MySQL is a widely used relational database management system (RDBMS).</p><p class="text-lg text-gray-700">MySQL is free and open-source.</p><p>SQL-based: Uses Structured Query Language (SQL) to manage and manipulate data.</p><p>MySQL was first released in 1995</p><p>MySQL was founded by Michael "Monty" Widenius, along with David Axmark and Allan Larsson</p></div>
  
  <div class="mb-12">
    <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">Type of SQl Commands?</h2>
  </div
  >
  <p class="text-lg text-gray-700">A <strong>Data Definition Language(DDL)</strong> Commands like create, alter and drop to define database structure. </p><p class="text-lg text-gray-700"><strong>Data Manipulation Language(DML)</strong>Commands like select, insert,update and delete for data operatioins</p><p class="text-lg text-gray-700"><strong>Data Control Language(DCL)</strong> <span class="shadow-lg p-2">Commands like grant and revoke to manage permissions</span></p><p class="text-lg text-gray-700"><strong>Transaction control language(TCL)</strong> Commands like commit , rollback and savepoint to maange transaction.</p>

  </div>
  
  <div class="mb-12">
  <div class="question">    
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">How is DATE different from DATETIME in MySQL? </h2>
  </div>
  <p class="text-lg text-gray-700">The DATE function in MySQL stores the date in year, month, and day format: YYYY-MM-DD </p><p>However, the DATETIME function stores the date with the time, and it looks like this: YYYY-MM-DD HH:MM:SS</p></div>
  
  <div class="mb-12">
  <div class="question">    
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What are the differences between INNER JOIN, LEFT JOIN, RIGHT JOIN, and FULL JOIN?</h2>
  </div>
  <p class="text-lg text-gray-700"><strong>INNER JOIN:</strong> Returns rows where there is a match in both tables.</p><p class="text-lg text-gray-700"><strong>LEFT JOIN:</strong> Returns all rows from the left table and matching rows from the right table. If there’s no match, NULL is returned for the right table's columns.</p><p class="text-lg text-gray-700"><strong>RIGHT JOIN:</strong> Similar to LEFT JOIN, it returns all rows from the right table and matching rows from the left.</p><p class="text-lg text-gray-700"><strong>FULL JOIN:</strong> Combines the LEFT JOIN and RIGHT JOIN results, including unmatched rows from both tables.</p><p class="text-lg text-gray-700"><strong>Self JOIN:</strong>Self join is a join in which a table is joined with itself.</p><code>Select a.column1,b.column2 from table_name a join table_name b on a.column= b.column </code></div>
  
  <div class="mb-12">
  <div class="question">    
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What is the difference between DELETE, TRUNCATE, and DROP in MySQL?</h2>
  </div>
  <p class="text-lg text-gray-700"><strong>DELETE:</strong> Removes rows from a table based on a condition. It can be rolled back if inside a transaction.</p><p class="text-lg text-gray-700"><strong>TRUNCATE:</strong> Deletes all rows from a table, but the table structure remains intact. It is faster than DELETE and cannot be rolled back.</p><p class="text-lg text-gray-700"><strong>DROP:</strong> Completely removes the table structure and data, along with any dependencies like indexes.</p></div>
  
  <div class="mb-12">
      <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What is a subquery in MySQL?</h2>
  </div>
  <p class="text-lg text-gray-700">A subquery (also known as a nested query) is nested inside another query.</p><p class="text-lg text-gray-700">SELECT first_name, last_name, salary</p>
  
  <code> FROM employees WHERE salary &gt; ( SELECT AVG(salary) FROM employees );</code></div>
  
  <div class="mb-12">
  <div class="question">    
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What is a view in MySQL? </h2>
  </div>
  <p class="text-lg text-gray-700">A view is a saved query that works like a virtual table.</p><p class="text-lg text-gray-700">you can treat a view like regular table in select, inset, update and delete.</p><p class="text-lg text-gray-700">Create view view_name as select column1, column2, from table_name where condition and drop view view_name</p><code> CREATE VIEW employee_details AS SELECT e.id, e.name, d.department_name,  
  FROM employees e JOIN departments d ON e.department_id = d.department_id;</code> </div>
  
  <div class="mb-12">
  <div class="question">    
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What is a trigger in MySQL? </h2>
  </div>
  <p class="text-lg text-gray-700">a trigger is a set of actions that run when a database event occurs. Triggers can be configured to execute before or after events like INSERT, UPDATE, or DELETE.</p><code> CREATE TRIGGER after_order_insert <br>
  {BEFORE|AFTER(INSERT|UPDATE|DELETE)} INSERT ON orders FOR EACH  ROW <br>
  BEGIN 
  <br>
  INSERT INTO order_history (order_id, action, timestamp) VALUES (NEW.order_id, 'inserted', NOW()); <br>END;</code></div>
  


  
  <div class="mb-12">
  <div class="question">    
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What are transactions in MySQL?</h2>
  </div>
  <p class="text-lg text-gray-700">A transaction is a sequence of operations performed as a single unit. It follows the ACID properties.</p> 

<code>
  START TRANSACTION;<br>
UPDATE accounts SET balance = balance - 500 WHERE id = 1;<br>
UPDATE accounts SET balance = balance + 500 WHERE id = 2;<br>
COMMIT;<br>
</code>
</div>
  
  
  <div class="mb-12">
  <div class="question">    
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">How do you optimize a slow query in MySQL??</h2>
  </div>
  <p class="text-lg text-gray-700">Use EXPLAIN to analyze the query.</p> 
  <p class="text-lg text-gray-700">Use Add appropriate indexes.</p> 
  <p class="text-lg text-gray-700">Avoid SELECT *, Remove unnecessary join, remove unnecessary database connection need of, use limit when possible.</p> 
  <p>Avoid subqueries when possible, Normalize the database</p>
  <p>some data store in locatization store local</p>
  <p>Fetch data need of</p>

 
</div>
  



  <div class="mb-12">
  <div class="question">    
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What is store engine in database? </h2>
  </div>
  <p class="text-lg text-gray-700">A<strong> storage engine </strong> (also called a table type) is the <strong>software component of a database</strong> that handles how data is<strong>stored, managed, and retrieved</strong>  at the physical level..</p><p class="text-lg text-gray-700"><strong> Common Storage Engines in MySQL:</strong></p><p class="text-lg text-gray-700"><strong>InnoDB:</strong>Default engine, supports transactions, row-level locking, foreign keys, and crash recovery.</p><p>it supports foreign key constraints for relational integrity</p><p><strong>ACID Compliance</strong> Ensure Atomicity, consistency, Isolation, and Durability </p><p class="text-lg text-gray-700"><strong>MyiSAM:</strong> it is doesnot support transaction meaning it does not have rollback capability.</p><p class="text-lg text-gray-700"><strong>MEMORY:</strong> Stores data in RAM for fast access. Volatile (data lost after restart).</p><p class="text-lg text-gray-700"><strong>CSV:</strong> Stores data in comma-separated text files. Simple but not efficient for large data..</p><p class="text-lg text-gray-700"><strong>ARCHIVE:</strong> Good for storing large historical data with high compression. No indexes.</p><p class="text-lg text-gray-700"><strong>BLACKHOLE:</strong> Accepts data but does not store it (used for replication or testing).</p></div>
  
  <div class="mb-12">
  <div class="question">    
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4"> What are the ACID properties in MySQL? </h2>
  </div>
  <p class="text-lg text-gray-700"><strong>Atomicity </strong> The transfer is an all-or-nothing operation. If $100 is deducted from Account A, the same $100 will be added to Account B, or nothing happens (if a failure occurs).</p>
  <p class="text-lg text-gray-700"><strong>Consistency </strong> After the transaction, both accounts must reflect the correct balance according to the rules of the system. The balances must not go negative (if not allowed), and all business rules must be respected.</p>
  <p class="text-lg text-gray-700"><strong>Isolation </strong> If another transaction tries to read or modify the same accounts while the first one is in progress, the second transaction must either wait or operate on a snapshot of the data to avoid inconsistencies. The changes from the first transaction are invisible to the second until it is completed.</p>
  <p class="text-lg text-gray-700"><strong>Durability </strong> After the transfer is committed, even if the database crashes, the changes to the account balances will be recovered and will not be lost.</p>   
    <div class="example">
 
<div class="code"> 

</div></div>

  </div>

    
  
  <div class="mb-12">
  <div class="question">    
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What is Store Procedure in database? </h2>
  </div>
  <p class="text-lg text-gray-700">A<strong> Stored Procedure </strong> is a predefined set of SQL statements that are stored in the database and can be executed (called) repeatedly. It is like a function in programming and To improve performance</p>
  
  <p class="text-lg text-gray-700">
      <div class="example">
 
<div class="code"> 
  <strong> Syntax (MySQL Example):</strong></p><code>
    DELIMITER // <br>
    CREATE PROCEDURE getUsers() <br>
    BEGIN <br>
    SELECT * FROM users; <br>
    END <br>
    // DELIMITER ;<br>    
    CALL getUsers();</code>
  </div>
  </div>
  </div>


  
  <div class="mb-12">
    <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What is an Index in a Database? </h2>
  </div>
  
  <p class="text-lg text-gray-700"><strong>Index</strong> Indexes are used to retrive data from the database very fast. the use cannot see the indexes , they are just used to speed up searches query.</p><p class="text-lg text-gray-700">An index in a database is a data structure that improves the speed of data retrieval operations on a table.</p><p>To increase query performance, especially with large tables.</p><p>To speed up searches, sorting, filtering, and JOIN operations.</p><p>To enforce constraints like UNIQUE.</p><p class="text-lg text-gray-700"><strong>Types of Indexes:</strong>.</p><ul><li><p class="text-lg text-gray-700"><strong>Primary Index:</strong> Automatically created on the primary key column, and Ensures uniqueness.</p>
<div class="example"> 
<div class="code"> 
  <code>CREATE TABLE users ( id INT PRIMARY KEY, name VARCHAR(100) );</code>

</div></div>
</li><li><p class="text-lg text-gray-700"><strong>Unique Index:</strong> nsures all values in the column are unique (no duplicates).</p>
<div class="example"> 
<div class="code"> 
<code>CREATE UNIQUE INDEX idx_email ON users(email);</code>
</div></div>
</li><li><p class="text-lg text-gray-700"><strong> Composite (Multi-column) Index:</strong> An index on two or more columns.</p>
<div class="example"> 
<div class="code"> 
<code>CREATE INDEX idx_name_email ON users(name, email);</code>
</div></div>
</li><li><p class="text-lg text-gray-700"><strong>Full-Text Index:</strong>Used for searching text, like articles, blogs, etc.</p>
<div class="example"> 
<div class="code"> 
<code> CREATE FULLTEXT INDEX idx_content ON posts(content);</code>
</div></div>
</li><li><p class="text-lg text-gray-700"><strong>Spatial Index:</strong> Used for geographic data (e.g., maps, coordinates).</p><p>Available in spatial databases like MySQL with GIS support.</p>
<div class="example"> 
<div class="code"> 
<code>
  
CREATE FULLTEXT INDEX idx_content ON posts(content);</code>
</div></div>
</li></ul></div>
  
  <div class="mb-12">
    <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What is SQL Injection? </h2>
  </div>
  <p class="text-lg text-gray-700"><strong>SQL Injection</strong>  is a security vulnerability that allows an attacker to interfere with the SQL queries your application sends to the database.</p><p class="text-lg text-gray-700">  <strong> Use Prepared Statements / Parameterized Queries</strong></p>
  
  <div class="example"> 
<div class="code"> 
  <code>$stmt = $conn-&gt;prepare("SELECT * FROM users WHERE username = ? AND password = ?"); <br>
    
  $stmt-&gt;bind_param("ss", $username, $password); <br>
  $stmt-&gt;execute();</code>
  
  </div></div>
  <p class="text-lg text-gray-700"> <strong>Unauthorized access</strong> to sensitive data (like passwords, credit card numbers) </p><p>Bypassing login authentication</p><p>Modifying or deleting data</p><p>Taking full control of the database server</p><p class="text-lg text-gray-700">SQL injection is a code injection technique that might destroy your database.</p><p class="text-lg text-gray-700">SQL Injection is one of the most common web hacking technique get request string ('userid').</p><p class="text-lg text-gray-700">THe sql above is valid and will return all rows from the user table since or 1=1 is always true.</p></div>
  
 
  
  
  <div class="mb-12">
    <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What is an alter table in a Database? </h2>
  </div>
  <p class="text-lg text-gray-700"><strong>Alter Table</strong> statment is used to add, delete or modify columns in an existing table.</p><p class="text-lg text-gray-700">Alter table table_name <strong>add</strong> colomn varchar(255).</p><p class="text-lg text-gray-700">Alter table table_name <strong>Drop</strong> colomn varchar(255).</p><p class="text-lg text-gray-700">Alter table table_name <strong>rename</strong> colomn varchar(255).</p></div>
  
  <div class="mb-12">
    <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">Common separate value find in sql? </h2>
  </div>
  <p class="text-lg text-gray-700"><strong> Group_concat</strong>group_concat(product_name order by product_name form orders group by order_id).</p></div>
  
  <div class="mb-12">
    <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What is Unique, Primary key, not null, foreign key? </h2>
  </div>
  <p class="text-lg text-gray-700"><strong> Not null</strong> column cannot have a null value , no value.</p><p class="text-lg text-gray-700"><strong>Uniqu</strong> All value in a column are defferent.</p><p class="text-lg text-gray-700"><strong>Primary key</strong> Uniquely identifies each row in table and combination of not null and unique.</p><p class="text-lg text-gray-700"><strong>Foreign Key:</strong> When the foreign key creat other table is primary key.</p></div>
  
  <div class="mb-12">
    <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What is DeadLock? </h2>
  </div>
  <p class="text-lg text-gray-700"><strong>Dead Lock</strong> in a database happens when two or more transaction are waiting on each other to release lock , evething get stuck consistant locking order.</p>

<ul>
  Let's say we have Process A and Process B, and they both want to access Resource X and Resource Y.
<li>
Person A picks up Pen X and waits for Pen Y.</li>
<li> 
Person B picks up Pen Y and waits for Pen X.</li>
<li> 
Now, A wants Y, and B wants X.</li>
<li> 
Both are waiting on each other — forever.</li>
<li> 
Result: Deadlock.</li>
</ul>
</div>




<div class="mb-12">
  <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">Update field name female to F and male to M and other mail = "" and namuber=0 </h2>
  </div>
  
   <div class="example"> 
<div class="code">
 
<code> 
UPDATE your_table_name<br>
SET<br>
    gender = CASE<br>
        WHEN gender = 'female' THEN 'F'<br>
        WHEN gender = 'male' THEN 'M'<br>
        ELSE gender<br>
    END,<br>
    mail = ""<br>
    namuber = 1; <br>
</pre>
</code>
</div>
</div>
</div>


<div class="mb-12">
  <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What is Normalization in DBMS?</h2>
  </div>
  <p>Normalization is the process of organizing data in a database to:</p>
  <p>Reduce data redundancy (repeating data)</p>
  <p>Improve data integrity</p>
  <p>Ensure efficient storage and retrieval</p>

      <p class="text-lg text-gray-700"><strong>1NF</strong> Remove duplicate comuns and use atomic (indivisible) values.</p>
      <p class="text-lg text-gray-700"><strong>2NF</strong> Remove partial dependencies (non-key fields must depend on whole key).</p>
      <p class="text-lg text-gray-700"><strong>3NF</strong> Remove transitive dependencies (non-key fields should not depend on other non-key fields).</p>
       <p class="text-lg text-gray-700"><strong>BCNF</strong> Strengthens 3NF by ensuring that all non-trivial dependencies are on superkeys.</p>
</div>




<div class="mb-12">
  <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What is sql thread?</h2>
  </div>
  <p>SQL thread same as database systems, a SQL thread usually refers to a server-side execution thread that is handling an SQL query or task. Most commonly, the term is used in replication or multi-threaded operations.</p>
  <p>In Mysql : SHOW PROCESSLIST</p>
  <p>In Postgre SQL : select * from pg_stat_activity</p>
 

 
</div>

<div class="mb-12">
  <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">Write Max Salary and second max salary in mysql?</h2>
  </div>
  <p><strong>Max Salary</strong> 
  <div class="example"> 
<div class="code"> 
  <code> Select Max(salary) from table_name order by salary desc limit 1</code>

</div></div>
</p>
   <p><strong>Socond Salary</strong> 
   <div class="example"> 
<div class="code"> 
   <code> Select salary from table_name order by salary desc limit 1 OFFSET 1</code>
  </div></div>
  </p>
 
   <p><strong>Third Salary</strong> 
   <div class="example"> 
<div class="code"> 
   <code> Select salary from table_name order by salary desc limit 1 OFFSET 2</code>
  </div></div>
  </p>
OR
    <p><strong>Third Salary</strong> 
    <div class="example"> 
<div class="code"> 
    <code> Select max(salary) as third_highest_salary from table_name <br>
    where salary < ( select max(salary) from table_name <br>
    where salary < (select max(salary) from table_name))</code>
</div></div>
  </p>
</div>


 


<div class="mb-12">
  <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">Write query who user amount greater than 5000rs?</h2>
  </div>
  <p> 
    <div class="example"> 
<div class="code"> 
      <code> Select user.name from user join order on users.id= order.user_id where order.amount > 5000</code>
    
    </div></div>
    </p>
</div>

<div class="mb-12">
  <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">Write query if get user name,total order amount greated than 5000 and find amount last six months?</h2>
  </div>
  <p> 
    <div class="example"> 
<div class="code"> 
      <code> Select user.name sum(order.amount) as total_order from users join order on users.id= orders.user_id group by users.name  having total_order>5000 and order.created > date_sub(now(), interval 6 months)</code>
    </div></div>
    </p>
</div>



<div class="mb-12">
  <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What is the difference between WHERE and HAVING?</h2>
  </div>
  <p> <strong>WHERE</strong> filters rows before aggregation..</p>
    <p> <strong>HAVING</strong> filters groups after aggregation.</p>
    <div class="example"> 
<div class="code"> 
    <code>
      SELECT department, COUNT(*) <br>
FROM employees <br>
GROUP BY department <br>
HAVING COUNT(*) > 5;</code>
     
</div>
</div>
</div>



<div class="mb-12">
  <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What is the difference between CHAR and VARCHAR</h2>
  </div>
  <p> <strong>CHAR</strong> datatype is used to store character strings of fixed length</p>
  <p>CHAR stands for "Character"</p>
  <p>CHAR takes 1 byte for each character</p>
  <p>Uses a fixed memory space (for example, CHAR(10) if I store 3 bytes. That means 7 bytes of memory is wasted. </p>
  <p>Can waste space if data is shorter than the specified length.</p>
    <p> <strong>VARCHAR</strong> Variable length. Reserves only required space.</p>
    <p>Uses only the amount of storage needed for the actual string.</p>
    <p>ARCHAR(10) stores up to 10 characters but uses only as much space as required..</p>
   
     
</div>

<div class="mb-12">
  <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What is the difference between primary key and unique constraints?</h2>
  </div>
  <table border="2px">
    <thead><tr><th><strong>Aspect</strong></th><th><strong>Primary Key</strong></th><th><strong>Unique Key</strong></th></tr></thead>
    <tbody>
      <tr><td><strong>Uniqueness</strong></td><td>Ensures uniqueness for the column(s).</td><td>Ensures uniqueness for the column(s).</td></tr>
      <tr><td><strong>Nullability</strong></td><td>Cannot accept <code>NULL</code> values.</td><td>Can accept <code>NULL</code> values.</td></tr>
      <tr><td><strong>Number per Table</strong></td><td>A table can only have <strong>one</strong> primary key.</td><td>A table can have <strong>multiple</strong> unique keys.</td></tr>
      <tr><td><strong>Example</strong></td><td><code>EmployeeID INT PRIMARY KEY</code></td><td><code>Email VARCHAR(100) UNIQUE</code></td></tr>
  
  </tbody></table>
     
</div>



<div class="mb-12">
  <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What is the difference between TRUNCATE and DROP statements?</h2>
  </div>
  <table border="2px"><thead><tr><th style="text-align: center;">DROP</th><th style="text-align: center;">TRUNCATE</th></tr></thead><tbody><tr><td>The DROP command is used to remove the table definition and its contents.</td><td>Whereas the TRUNCATE command is used to delete all the rows from the table.</td></tr><tr><td>In the DROP command, table space is freed from memory.</td><td>While the TRUNCATE command does not free the table space from memory.</td></tr><tr><td>DROP is a DDL(Data Definition Language) command.</td><td>Whereas the TRUNCATE is also a DDL(Data Definition Language) command.</td></tr><tr><td>In the DROP command, a view of the table does not exist.</td><td>While in this command, a view of the table exists.</td></tr><tr><td>In the DROP command, integrity constraints will be removed.</td><td>While in this command, integrity constraints will not be removed.</td></tr><tr><td>In the DROP command, undo space is not used.</td><td>While in this command, undo space is used but less than DELETE.</td></tr><tr><td>The DROP command is quick to perform but gives rise to complications.</td><td>While this command is faster than DROP.</td></tr></tbody></table>
     
</div>






<div class="mb-12">
  <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">Write a Queue in MySQL?</h2>
  </div>
  <p> <strong>Queue</strong> Queue is not a build in feature but can be implement using standard database operations like inserting, updating and selecting data.</p>
    <p> <strong>Queue</strong> are processed in a First in first out (FIFO) feature.</p>
    <p> <strong>Queue</strong> feture  are use sending email, prossing updated.</p>
  <p> 
    <div class="example"> 
<div class="code"> 
      <code>

      create table job_queue (<br>
        id int auto_increment primary ky,<br>
        task_name varchar (255) not null,<br>
        status enum('pending','processing','completed','faild'),<br>
        created_at timestamp default current_timestamp,<br>
        updated_at timestamp default current_timestamp,<br>
      
      )
      </code>
    </div></div>
    </p>
</div>

<div class="mb-12">
  <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">write query second table not exist record MySQL?</h2>
  </div>
  <p>
    <div class="example"> 
<div class="code"> 
      <code>
      Select table1.* from table1 where table1.id not in (select table2.id form table2)
      </code>
      </div></div>
    </p>
</div>


<div class="mb-12">
  <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">How to one increase sttaus not in table2?</h2>
  </div>
  <p>
     <strong>
      table1<br>
     id name status<br>
     1   a     2 <br>
     2   b     0 <br>
     3   c     1 <br>
     4   d     4 <br>
     5   e     6 <br>
     6   f     9 <br>
     table2<br>
     id user_id<br>
     1     4<br>
     2     3<br>
      </strong>
      <div class="example"> 
<div class="code"> 
      <code>
      Update table1 set status = status +1 where id not in (select id from table2)
      </code>
      </div></div>
    </p>
</div>


<div class="mb-12">
  <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">Difference between Commit and Rollback commands?</h2>
  </div>
  <table border="2px"><thead><tr><th style="text-align: center;">COMMIT</th><th style="text-align: center;">ROLLBACK</th></tr></thead><tbody><tr><td>COMMIT permanently saves the changes made by the current transaction.</td><td>ROLLBACK undo the changes made by the current transaction.</td></tr><tr><td>The transaction can not undo changes after COMMIT execution.</td><td>Transaction reaches its previous state after ROLLBACK.</td></tr><tr><td>When the transaction is successful, COMMIT is applied.</td><td>When the transaction is aborted, ROLLBACK occurs.</td></tr></tbody></table>
     
</div>


<div class="mb-12">
  <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">How to select query not in table2 ?</h2>
  </div>
  <p>
     <strong>
      user<br>
     id name status<br>
     1   a     2 <br>
     2   b     0 <br>
     3   c     1 <br>
     4   d     4 <br>
     5   e     6 <br>
     6   f     9 <br>
     table2<br>
     id user_id<br>
     1    4,5<br>
     2     3,2<br>
     3     6<br>
      </strong>
      <div class="example"> 
<div class="code"> 
      <code>
      Select a.id, a.name, from user not find_in_set(a.id, (select id from table where id=1))
      </code>
      </div></div>
    </p>
</div>


<div class="mb-12">
  <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">How to create table dynamics in sql?</h2>
  </div>
  <p>
      <div class="example"> 
<div class="code"> 
      <code>
      schema::create('table_name', function(Blueprint $table){<br>

        $table->increments('id');<br>
        $table->varchar('name',255)->nullable();<br>
        $table->varchar('email',255)->nullable();<br>
        $table->string('mobile');<br>
        $table->tinyInterger('demo_attended');<br>
        $table->text('remarks');<br>
        $table->timestamp('deleted_at')->nullable();<br>
      });<br>
      </code>
      </div></div>
    </p>
</div>


















</div></section>


 </div>
 
<br>
<div class="clear nextprev">
<a class="left btn" href="{{url('interviews/php-interview-question-answer')}}">&#10094; Previous</a>
<a class="right btn" href="{{url('interviews/technical-logic-question-answer')}}">Next &#10095;</a>
</div>
</div>
 
</div>
   
  @endsection