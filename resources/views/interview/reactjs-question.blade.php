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
       
<h1>HTML<span class="color_h1"> Basic Examples</span></h1>
<div class="clear nextprev">
<a class="left btn" href="{{url('interviews/laravel-interview-question-answer')}}">&#10094; Previous</a>
<a class="right btn" href="{{url('interviews/restapi-interview-question-answer')}}">Next &#10095;</a>
</div>
<hr>
  
 <div class="light">
 
 
 <section id="services-section" class="py-12 bg-gray-100">
  <div class="container mx-auto px-4">
  
  <div class="mb-12">
    <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What is Reactjs??</h2>
  </div>
  <p class="text-lg text-gray-700">React is a JavaScript library that makes building user interfaces easy. It was developed by Facebook.</p> 
  </div>
 
  <div class="mb-12">
    <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">Does React use HTML?</h2>
  </div>
  <p class="text-lg text-gray-700">No, It uses JSX, which is similar to HTML.</p>
   
  </div>
 
  <div class="mb-12">
    <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">When was React first released?</h2>
  </div>
  <p class="text-lg text-gray-700">React was first released on March 2013.</p> 
  </div>
 
  <div class="mb-12">
    <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">Give me two most significant drawbacks of React?</h2>
  </div>
  <p class="text-lg text-gray-700">Integrating React with the MVC framework like Rails requires complex configuration.</p><p class="text-lg text-gray-700">React require the users to have knowledge about the integration of user interface into MVC framework.</p>
  </div>
 
  


<div class="mb-12">
  <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">State the difference between Real DOM and Virtual DOM?</h2>
  </div>
  <table border="2px">
    <thead><tr><th><strong>Real DOM</strong></th><th><strong>Virtual DOM</strong></th></tr></thead>
    <tbody>
      <tr><td>It is updated slowly</td><td>It updates faster</td></tr>
      <tr><td>It allows a direct update from HTML</td><td>It cannot be used to update HTML directly.</td></tr>
      <tr><td>It wastes too much memory</td><td>Memory consumption is less</td></tr>   
  
  </tbody></table>
     
</div>


 <div class="mb-12">
    <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What is Flux Concept In React?</h2>
  </div>
  <p class="text-lg text-gray-700">Facebook widely uses flux architecture concept for developing client-side web applications. It is not a framework or a library. It is simply a new kind of architecture that complements React and the concept of Unidirectional Data Flow.</p>
  </div>
 

 <div class="mb-12">
    <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">Define the term Redux in React?</h2>
  </div>
  <p class="text-lg text-gray-700">Redux is a library used for front end development. It is a state container for JavaScript applications which should be used for the applications state management. You can test and run an application developed with Redux in different environments</p>
  </div>
 

 <div class="mb-12">
    <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What is the 'Store' feature in Redux?</h2>
  </div>
  <p class="text-lg text-gray-700">Redux has a feature called 'Store' which allows you to save the application's entire State at one place. Therefore all it's component's State are stored in the Store so that you will get regular updates directly from the Store. The single state tree helps you to keep track of changes over time and debug or inspect the application.</p>
  </div>
 

 <div class="mb-12">
    <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What is an action in Redux?</h2>
  </div>
  <p class="text-lg text-gray-700">It is a function which returns an action object. The action-type and the action data are always stored in the action object. Actions can send data between the Store and the software application. All information retrieved by the Store is produced by the actions.</p>
  </div>
 

 <div class="mb-12">
    <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">Name the important features of React?</h2>
  </div>
  <p class="text-lg text-gray-700">Here, are important features of React:</p>
  <p>Allows you to use 3rd party libraries</p>
  <p>Time-Saving</p>
  <p>Faster Development</p>
  <p>Simplicity and Composable</p>
  <p>Fully supported by</p>
  <p>Facebook.</p>
  <p>Code Stability with One-directional data binding React Components</p>


  </div>

 <div class="mb-12">
    <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What is meant by callback function? What is its purpose?</h2>
  </div>
  <p class="text-lg text-gray-700">A callback function should be called when setState has finished, and the component is retendered. As the setState is asynchronous, which is why it takes in a second callback function.</p>
  
  </div>
 




 <div class="mb-12">
    <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">Explain the term high order component?</h2>
  </div>
  <p class="text-lg text-gray-700">A higher-order component also shortly known as HOC is an advanced technique for reusing component logic. It is not a part of the React API, but they are a pattern which emerges from React’s compositional nature.</p>
  
  </div>
 


 <div class="mb-12">
    <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What are Props in react js?</h2>
  </div>
  <p class="text-lg text-gray-700">Props mean properties, which is a way of passing data from parent to child. We can say that props are just a communication channel between components. It is always moving from parent to child component.</p>
  
  </div>
 




  

<div class="mb-12">
  <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">Name two types of React component?</h2>
  </div>
  <table border="2px">
    <thead><tr><th><strong>Function component</strong></th><th><strong>Class component</strong></th></tr></thead>
    <tbody>
      <tr><td></td><td></td></tr>
      <tr><td></td><td></td></tr>
      <tr><td></td> <td></td> </tr>   
  
  </tbody></table>
     
</div>





 <div class="mb-12">
    <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">Explain synthetic event in React js?</h2>
  </div>
  <p class="text-lg text-gray-700">Synthetic event is a kind of object which acts as a cross-browser wrapper around the browser’s native event. It also helps us to combine the behaviors of various browser into signal API.</p>
  
  </div>

 <div class="mb-12">
    <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What is React State?</h2>
  </div>
  <p class="text-lg text-gray-700">It is an object which decides how a specific component renders and how it behaves. The state stores the information which can be changed over the lifetime of a React component.</p>
  
  </div>
 
 <div class="mb-12">
    <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">Explain the use of the arrow function in React?</h2>
  </div>
  <p class="text-lg text-gray-700">The arrow function helps you to predict the behavior of bugs when passed as a callback. Therefore, it prevents bug caused by this all together.</p>
  
  </div>
 



<div class="mb-12">
  <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">State the main difference between Pros and State?</h2>
  </div>
  <table border="2px">
    <thead><tr><th><strong>State</strong></th><th><strong>Pros</strong></th></tr></thead>
    <tbody>
      <tr><td>State is mutable</td><td>Pros are immutable</td></tr>
      <tr><td>State information that will change, we need to utilize State</td><td>Props are set by the parent and which are settled all through the lifetime of a part.
        <p>You can’t update props in react js because props are read-only.</p>
      </td></tr>
      <tr><td></td> <td></td> </tr>   
  
  </tbody></table>
     
</div>



 <div class="mb-12">
    <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">Explain pure components in React js?</h2>
  </div>
  <p class="text-lg text-gray-700">Pure components are the fastest components which can replace any component with only a render(). It helps you to enhance the simplicity of the code and performance of the application.</p>
  
  </div>
 

 <div class="mb-12">
    <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">Explain strict mode?</h2>
  </div>
  <p class="text-lg text-gray-700">StrictMode allows you to run checks and warnings for react components. It runs only on development build. It helps you to highlight the issues without rendering any visible UI.</p>
  
  </div>
 

 <div class="mb-12">
    <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What is the use of Webpack?</h2>
  </div>
  <p class="text-lg text-gray-700">Webpack in basically is a module builder. It is mainly runs during the development process.</p>
  
  </div>
 

 <div class="mb-12">
    <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What is Babel in React js?</h2>
  </div>
  <p class="text-lg text-gray-700">Babel, is a JavaScript compiler that converts latest JavaScript like ES6, ES7 into plain old ES5 JavaScript that most browsers understand.</p>
  
  </div>

 <div class="mb-12">
    <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">How can a browser read JSX file?</h2>
  </div>
  <p class="text-lg text-gray-700">If you want the browser to read JSX, then that JSX file should be replaced using a JSX transformer like Babel and then send back to the browser.</p>
  
  </div>
 


 <div class="mb-12">
    <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">What are the major issues of using MVC architecture in React?</h2>
  </div>
  <p class="text-lg text-gray-700">DOM handling is quite expensive</p>
  <p class="text-lg text-gray-700">Most of the time applications were slow and inefficient</p>
  <p class="text-lg text-gray-700">Because of circular functions, a complex model has been created around models and ideas</p>
  
  </div>


 <div class="mb-12">
    <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">Explain the term synthetic events?</h2>
  </div>
  <p class="text-lg text-gray-700">It is actually a cross-browser wrapper around the browser’s native event. These events have interface stopPropagation() and preventDefault().</p>
  
  </div>
 


 <div class="mb-12">
    <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">Explain the term reconciliation?</h2>
  </div>
  <p class="text-lg text-gray-700">When a component's state or props change then rest will compare the rendered element with previously rendered DOM and will update the actual DOM if it is needed. This process is known as reconciliation.</p>
  
  </div>
 

 <div class="mb-12">
    <div class="question">  
  <h2 class="text-3xl font-bold text-primary mt-5 mb-4">Explain Hooks?</h2>
  </div>
  <p class="text-lg text-gray-700"><strong>useState: </strong>.
This React hook allows components to manage local
state without class components.</p>
 <p>
Store simple values like numbers, strings, objects, or
arrays.
</p>
<div class="example"> 
<div class="code"> 
      <code>
import React, { useState } from 'react';<br>

function Counter() {<br>
  const [count, setCount] = useState(0); // Initialize state<br>
 <xmp> 
  return (
    <div>
      <p>Count: {count}</p>
      <button onClick={() => setCount(count + 1)}>Increment</button>
    </div>
  );
}

export default Counter; <xmp> 
      
      </code>
    </div>
  </div>
  <p>Avoid directly mutating the state. Instead,
always update it using ‘setState'</p>

<p class="text-lg text-gray-700"><strong>useEffect: </strong>.
useEffect is used for tasks like data fetching, setting up
subscriptions, and performing initial actions. It
behaves similarly to componentDidMount in class
components
</p>
<p>Runs after rendering. You can control when it executes
by passing dependencies. It functions similarly to
shouldComponentUpdate or componentDidUpdate</p>
<div class="example"> 
<div class="code"> 
      <code>
import React, { useState, useEffect } from 'react';<br>

function ExampleComponent() {<br>
  const [count, setCount] = useState(0);<br>

  // Run side effect after render<br>
  useEffect(() => {<br>
    document.title = `Count: ${count}`; // Update document title<br>

    // Cleanup (optional)<br>
    return () => {<br>
      document.title = 'React App';<br>
    };<br>
  }, [count]); // Dependency array: run when count changes<br>
 <xmp> 
  return (
    <div>
      <p>Count: {count}</p>
      <button onClick={() => setCount(count + 1)}>Increment</button>
    </div>
  );
}

export default ExampleComponent; </xmp> 
      
      </code>
    </div>
  </div>
  

<p class="text-lg text-gray-700"><strong>useRef: </strong>.
It is used to create mutable references to DOM
elements and any values that you want to persist
across renders without causing re-renders.
</p>
<p>Autofocus an input field.</p>
<p>Useful for handling animations, measuring
elements, and persisting values without re-renders.</p>
<div class="example"> 
<div class="code"> 
      <code>
import React, { useRef } from 'react';<br>

function TextInput() {<br>
  const inputRef = useRef(null);<br>

  const focusInput = () => {<br>
    inputRef.current.focus(); // Access DOM element<br>
  };
 <xmp> 
  return (
    <div>
      <input ref={inputRef} type="text" placeholder="Type here" />
      <button onClick={focusInput}>Focus Input</button>
    </div>
  );
}

export default TextInput; <xmp> 
      </code>
    </div>
  </div>

<p class="text-lg text-gray-700"><strong>useMemo: </strong>.
Returns a cached value and prevents expensive
calculations from running on every render.
</p>
<p>Use it only when necessary—overusing can
degrade performance.</p>
 
<div class="example"> 
<div class="code"> 
      <code>
import React, { useState, useMemo } from 'react';<br>

function ExpensiveComponent() {<br>
  const [count, setCount] = useState(0);<br>

  // Memoize expensive computation<br>
  const expensiveValue = useMemo(() => {<br>
    return Array(1000000).fill().reduce((sum, _, i) => sum + i, count);<br>
  }, [count]); // Recompute only if count changes<br>
 <xmp> 
  return (
    <div>
      <p>Count: {count}</p>
      <p>Expensive Value: {expensiveValue}</p>
      <button onClick={() => setCount(count + 1)}>Increment</button>
    </div>
  );
} </xmp> 

export default ExpensiveComponent;<br>
      
      
      </code>
    </div>
  </div>


<p class="text-lg text-gray-700"><strong>useCallback: </strong>.
Memoizes a function, ensuring that the function
reference remains stable across re-renders unless its
dependencies change. This is especially useful when
passing functions down to child components, as it
prevents unnecessary re-renders.
</p>
<p>Use it when passing functions to child
components to prevent unnecessary renders.</p>
 
<div class="example"> 
<div class="code"> 
      <code>
import React, { useState, useCallback } from 'react';<br>

function Counter() {<br>
  const [count, setCount] = useState(0);<br>

  // Memoize the increment function<br>
  const increment = useCallback(() => {<br>
    setCount(prevCount => prevCount + 1);<br>
  }, []); // Empty dependency array: function is memoized and won't change<br>
 <xmp> 
  return (
    <div>
      <p>Count: {count}</p>
      <button onClick={increment}>Increment</button>
    </div>
  );
}

export default Counter; </code>xmp> 
      
      </code>
    </div>
  </div>


<p class="text-lg text-gray-700"><strong>useReducer: </strong>.
Useful when state management is more complex
than a simple state change (like useState).
</p>
<p>Like useState, useReducer is local to the
component, but it gives you more flexibility and
control over how the state is updated.</p>
<p>Works great for managing form states and
complex UI state logic.</p>
 
<div class="example"> 
<div class="code"> 
      <code>
import React, { useReducer } from 'react';<br>

const initialState = { count: 0 };<br>
const reducer = (state, action) => {<br>
  switch (action.type) {<br>
    case 'increment': return { count: state.count + 1 };<br>
    case 'decrement': return { count: state.count - 1 };<br>
    default: return state;<br>
  }<br>
};<br>

function Counter() {<br>
  const [state, dispatch] = useReducer(reducer, initialState);<br>
 <xmp> 
  return (
    <div>
      <p>{state.count}</p>
      <button onClick={() => dispatch({ type: 'increment' })}>+</button>
      <button onClick={() => dispatch({ type: 'decrement' })}>-</button>
    </div>
  );
}
</xmp> 

export default Counter;
      
      </code>
    </div>
  </div>

<p class="text-lg text-gray-700"><strong>useLayoutEffect: </strong>.
Like useEffect, but fires synchronously after the
DOM has been updated but before the browser
has painted the changes.
</p>
<p>useful for animations and layout measurements.</p>
<p>Avoid blocking the UI—use it only for UI
calculations and measurements.</p>
 
<div class="example"> 
<div class="code"> 
      <code>
import React, { useLayoutEffect, useRef } from 'react';<br>

function ExampleComponent() {<br>
  const divRef = useRef(null);<br>

  useLayoutEffect(() => {<br>
    // Adjust the div's width immediately after DOM update<br>
    divRef.current.style.width = '200px';<br>
  }, []);<br>
<xmp> 
  return <div ref={divRef} style="">Resize me</div>;</code>xmp> 
}<br>

export default ExampleComponent;<br>
      
      </code>
    </div>
  </div>

<p class="text-lg text-gray-700"><strong>useId: </strong>.
useId is a Hook that generates unique, stable IDs that
are consistent across re-renders.
</p>
<p>Useful in scenarios involving form elements,
dynamic content, or any situation requiring
guaranteed unique identifiers across re-renders.</p>
 
 
<div class="example"> 
<div class="code"> 
      <code>

      import React, { useId } from 'react';<br>

function ExampleComponent() {<br>
  const id = useId();<br>
<xmp> 
  return (
    <div>
      <label htmlFor={id}>Username</label>
      <input id={id} type="text" placeholder="Enter username" />
    </div>
  );</xmp> 
}<br>

export default ExampleComponent;<br>
      </code>
    </div>
  </div>

<p class="text-lg text-gray-700"><strong>useDeferredValue: </strong>.
Defers updates to prevent UI lag during heavy
computations.
</p>
<p>It’s similar to a debounce function but without a timeout.
It defers the update until React is done processing other
tasks.</p>
 <p>Use it for search bars, filtering, or UI-heavy
components.</p>
 
<div class="example"> 
<div class="code"> 
      <code>
import React, { useState, useDeferredValue } from 'react';

function ExampleComponent() {
  const [input, setInput] = useState('');
  const deferredInput = useDeferredValue(input);

  const handleChange = (e) => {
    setInput(e.target.value);
  };
<xmp> 
  return (
    <div>
      <input
        type="text"
        value={input}
        onChange={handleChange}
        placeholder="Type something..."
      />
      <p>Deferred value: {deferredInput}</p>
    </div>
  );</xmp>
}

export default ExampleComponent; 
      
      </code>
    </div>
  </div>


<p class="text-lg text-gray-700"><strong>useTransition: </strong>.
Allows non-blocking UI updates for better user
experience. It’s pertcularly useful when you need to
update multiple states without rendering immidietly
</p>
 
 
<div class="example"> 
<div class="code"> 
      <code>

      import React, { useState, useTransition } from 'react';<br>

function ExampleComponent() {<br>
  const [input, setInput] = useState('');<br>
  const [items, setItems] = useState([]);<br>
  const [isPending, startTransition] = useTransition();<br>

  const handleChange = (e) => {<br>
    setInput(e.target.value);<br>

    // Mark this state update as a transition (non-urgent)<br>
    startTransition(() => {<br>
      // Simulate a heavy computation or filtering<br>
      const filteredItems = Array(10000)<br>
        .fill()<br>
        .map((_, i) => `Item ${i + 1}`)<br>
        .filter(item => item.toLowerCase().includes(e.target.value.toLowerCase()));<br>
      
      setItems(filteredItems);<br>
    });<br>
  };<br>
<xmp>
  return (
    <div>
      <input
        type="text"
        value={input}
        onChange={handleChange}
        placeholder="Type to filter..."
      />
      {isPending ? (
        <p>Loading...</p>
      ) : (
        <ul>
          {items.map((item, index) => (
            <li key={index}>{item}</li>
          ))}
        </ul>
      )}
    </div>
  ); </xmp>
}

export default ExampleComponent;
      </code>
    </div>
  </div>








  </div>
 







</div>
</section>


  </div>
   
  


 
     



<br>
<div class="clear nextprev">
<a class="left btn" href="{{url('interviews/laravel-interview-question-answer')}}">&#10094; Previous</a>
<a class="right btn" href="{{url('interviews/restapi-interview-question-answer')}}">Next &#10095;</a>
</div>
</div>
 
</div>
   
  @endsection