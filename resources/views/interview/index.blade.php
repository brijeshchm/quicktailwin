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
     <div class="container-xxl py-5">
      <div class="container">
       
	   
	 <style>
        

        .program-cont {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 25px;
            max-width: 1200px;
        }

        .crs-cont-box {
            background: linear-gradient(145deg, #ffffff, #e6e6e6);
            border-radius: 20px;
            width: 300px;
            height: 200px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            position: relative;
            overflow: hidden;
            opacity: 0;
            animation: fadeIn 0.8s ease forwards;
            animation-delay: calc(var(--delay) * 0.1s);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .crs-cont-box:hover {
            
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.25);
            transform: scale(1.05);
        }

        .crs-cont-box img {
            width: 100px;
            height: 100px;
            object-fit: contain;
            animation: bounce 2s ease-in-out infinite;
        }

        .crs-cont-box:hover img {
            animation: bounce 1s ease-in-out infinite;
        }

        .crs-cont-box a {
            margin-top: 12px;
            font-size: 0.9em;
            color: #2d3748;
            text-align: center;
            text-decoration: none;
            position: relative;
            transition: color 0.3s ease;
        }

        .crs-cont-box:hover a {
            color: #000;
        }

        /* Sliding underline effect for links */
        .crs-cont-box a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            background: #ff6f61;
            bottom: -4px;
            left: 0;
            transition: width 0.3s ease;
        }

        .crs-cont-box:hover a::after {
            width: 100%;
            background: #ffffff;
        }

        /* Glowing effect on hover */
        .crs-cont-box::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.4), transparent);
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .crs-cont-box:hover::before {
            opacity: 1;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .crs-cont-box {
                width: 110px;
                height: 130px;
            }

            .crs-cont-box img {
                width: 50px;
                height: 50px;
            }

            .crs-cont-box a {
                font-size: 0.8em;
            }
        }

        @media (max-width: 480px) {
            .crs-cont-box {
                width: 90px;
                height: 110px;
            }

            .crs-cont-box img {
                width: 40px;
                height: 40px;
            }

            .crs-cont-box a {
                font-size: 0.7em;
            }
        }
    </style>
<div class="program-cont">
        <div class="crs-cont-box" style="--delay: 1;">
            <a href="{{url('interviews/php-interview-question-answer')}}"> <img loading="lazy" src="{{asset('interview/tech/php.png')}}" alt="PHP Interview Question Answer"> </a>
            <a href="{{url('interviews/php-interview-question-answer')}}"> PHP Interview Question Answer </a>
        </div>
        <div class="crs-cont-box" style="--delay: 2;">
            <img loading="lazy" src="{{asset('interview/tech/mysql.png')}}" alt="PHP Interview Question Answer">
            <a href="{{url('interviews/mysql-interview-question-answer')}}">PHP Interview Question Answer</a>
        </div>
		
        <div class="crs-cont-box" style="--delay: 3;">
            <img loading="lazy" src="{{asset('interview/tech/appache-mysql-php.png')}}" alt="Technical Logic">
            <a href="{{url('interviews/technical-logic-question-answer')}}">Technical Logic</a>
        </div>
		
		   <div class="crs-cont-box" style="--delay: 4;">
            <img loading="lazy" src="{{asset('interview/tech/laravel.png')}}" alt="Technical Logic">
            <a href="{{url('interviews/laravel-interview-question-answer')}}">Laravel Interview Question Answer</a>
        </div>
		
		
		   <div class="crs-cont-box" style="--delay: 5;">
            <img loading="lazy" src="{{asset('interview/tech/javascript.jpg')}}" alt="Javascript Interview Question Answer">
            <a href="{{url('interviews/javascript-interview-question-answer')}}">Javascript Interview Question Answer</a>
        </div>
		
		
		   <div class="crs-cont-box" style="--delay: 6;">
            <img loading="lazy" src="{{asset('interview/tech/react.png')}}" alt="Interview Question Answer">
            <a href="{{url('interviews/reactjs-interview-question-answer')}}">Reactjs Interview Question Answer</a>
        </div>
		
		
		   <div class="crs-cont-box" style="--delay: 7;">
            <img loading="lazy" src="{{asset('interview/tech/restapi.png')}}" alt="Restapi Interview Question Answer">
            <a href="{{url('interviews/restapi-interview-question-answer')}}">Restapi Interview Question Answer</a>
        </div>
		
		
		  
         
    </div>



    </div>

	</div>
	 
	</div>
	</div>
  
  
  @endsection