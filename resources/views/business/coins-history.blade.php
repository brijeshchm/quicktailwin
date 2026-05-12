@extends('business.layouts.app')
@section('title')
Quick India | Coin History
@endsection 
@section('keyword')
Find Best It Training Centre near You, Find Best It Training Institute near You, Find Top 10 IT Training Institute near You, Find Best Entrance Exam Preparation Centre Near you, Top 10 Entrance Exam Centre Near you, Find Best Distance Education Centre Near You, Find Top 10 Distance Education Centre Near You, Find Best School And Colleges Near You, Find Top 10 school And College Near You, Get Education Loan, GET Free career Counselling, Find Best overseas education consultants Near you, Find Top 10 overseas education consultants Near you

@endsection
@section('description')
Find Only Certified Training Institutes, Coaching Centers near you on Estivaledge and Get Free counseling, Free Demo Classes, and Get Placement Assistence.
@endsection
@section('content')	
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Coin History</h1>
    
    </div>
 <style>
        

        .table-container {
            max-width: 1000px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
            max-height: 400px;
            overflow-y: auto;
            position: relative;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #e6e6e6;
            font-weight: normal;
            color: #333;
            position: sticky;
            top: 0;
            z-index: 1;
        }

        td {
            font-weight: bold;
            color: #333;
        }

        /* Mouse-over Animation */
        tr {
            transition: background-color 0.3s ease;
        }

        tr:hover {
            background-color: #f0f8ff;
        }

        /* Expanded Row Details */
        .expanded-details {
            display: none;
            background-color: #f9f9f9;
            padding: 10px;
            text-align: left;
            font-weight: normal;
            font-size: 14px;
            border-top: 1px solid #ddd;
        }

        tr.expanded .expanded-details {
            display: block;
        }

        /* No More Data Message */
        .no-data-row {
            background-color: #f0f0f0;
            font-style: italic;
            color: #666;
        }

        .no-data-row td {
            font-weight: normal;
            padding: 15px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .table-container {
                max-height: 300px;
            }

            th, td {
                padding: 8px 10px;
                font-size: 14px;
            }

            .expanded-details {
                font-size: 12px;
            }
        }

        @media (max-width: 480px) {
            .table-container {
                max-height: 250px;
            }

            table, thead, tbody, th, td, tr {
                display: block;
            }

            thead tr {
                display: none;
            }

            tr {
                margin-bottom: 10px;
                border-bottom: 2px solid #ddd;
            }

            td {
                text-align: right;
                padding-left: 50%;
                position: relative;
                font-size: 14px;
            }

            td::before {
                content: attr(data-label);
                position: absolute;
                left: 10px;
                width: 45%;
                text-align: left;
                font-weight: normal;
                color: #666;
            }

            .expanded-details {
                text-align: right;
                padding: 5px 0;
            }

            .no-data-row td {
                text-align: center;
                padding-left: 0;
            }

            .no-data-row td::before {
                content: none;
            }
        }
    </style>
         <div class="container">
        <div class="header-enquiry">
            <div class="enquiry-tabs">
        <div class="tab">
            <span>My Lead</span>
            <span class="count"><?php if(!empty($coinsLeads)){ echo count($coinsLeads); } ?></span>
        </div>
        
    </div> 
            
            <div class="status">
                <span><a href="{{ url('business/myLead')}}">Total Lead</a> | </span>
                <span><a href="{{ url('business/package')}}">Platinum</a></span>
                <span>0h</span>
            </div>
        </div>

 <div class="table-container" id="tableContainer">
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Mobile</th>                   
                    <th>Service</th>
                    <th>Coins</th>
                </tr>
            </thead>
            <tbody id="tableBody">              
            </tbody>
        </table>
    </div>
    <?php 
 
 
    if(!empty($coinsLeads)){
            $coinsList = [];
            foreach($coinsLeads as $coinsLead){
            $coins= "";
            if(!empty($coinsLead->scrapLead)) { 
            $coins =    "<span style='color:green'>" . $coinsLead->coins . "</span>"; 
            }else if($coinsLead->coins){ 
            $coins =  "<span style='color:red;'> -" . $coinsLead->coins . " </span>"; 
            } 
            $coinsList[] = [
            'name' => $coinsLead->name,
            'mobile' => $coinsLead->mobile,
            'service' => $coinsLead->kw_text,
            'coins' =>$coins,  
            'date' => date('d M Y',strtotime($coinsLead->created))
            ];
            }

            } 

    
    ?>
 <script>


        const tableContainer = document.getElementById('tableContainer');
        const tableBody = document.getElementById('tableBody');


        const remainingData = <?php  echo json_encode($coinsList); ?>;
       

        // Function to append new rows
        function appendRows(dataArray) {
            dataArray.forEach(data => {
                // console.log(data.name);
                const dataRow = document.createElement('tr');
                dataRow.classList.add('data-row');
                dataRow.innerHTML = `
                    <td data-label="Date">${data.date}</td>
                    <td data-label="Name">${data.name}</td>
                    <td data-label="Mobile">${data.mobile}</td>                     
                    <td data-label="Service">${data.service}</td>
                    <td data-label="Coins">${data.coins}</td>
                `;

                const detailRow = document.createElement('tr');
                detailRow.classList.add('expanded-details');
              

                tableBody.appendChild(dataRow);
                tableBody.appendChild(detailRow);
            });
        }

        // Function to append "Data is finished" message
        function appendNoDataMessage() {
            const noDataRow = document.createElement('tr');
            noDataRow.classList.add('no-data-row');
            noDataRow.innerHTML = `
                <td colspan="4">Data is finished</td>
            `;
            tableBody.appendChild(noDataRow);
        }

        // Infinite scroll to load more rows
        let isLoading = false;
        let hasShownNoDataMessage = false;
        tableContainer.addEventListener('scroll', () => {
            if (isLoading) return;

            const { scrollTop, scrollHeight, clientHeight } = tableContainer;
            if (scrollTop + clientHeight >= scrollHeight - 5) {
                if (remainingData.length > 0) {
                    isLoading = true;
                    setTimeout(() => {
                        appendRows(remainingData.splice(0, 5)); // Load 2 rows at a time
                        isLoading = false;
                    }, 500);
                } else if (!hasShownNoDataMessage) {
                    appendNoDataMessage();
                    hasShownNoDataMessage = true;
                }
            }

            // Expand rows in viewport
            const rows = document.querySelectorAll('tr.data-row');
            rows.forEach((row) => {
                const rect = row.getBoundingClientRect();
                const containerRect = tableContainer.getBoundingClientRect();

                const isInView = rect.top >= containerRect.top && rect.bottom <= containerRect.bottom;
                if (isInView) {
                    row.classList.add('expanded');
                    const detailRow = row.nextElementSibling;
                    if (detailRow && detailRow.classList.contains('expanded-details')) {
                        detailRow.style.display = 'block';
                    }
                } else {
                    row.classList.remove('expanded');
                    const detailRow = row.nextElementSibling;
                    if (detailRow && detailRow.classList.contains('expanded-details')) {
                        detailRow.style.display = 'none';
                    }
                }
            });
        });

        // Initial check to expand rows in view on page load
        const initialScrollEvent = new Event('scroll');
        tableContainer.dispatchEvent(initialScrollEvent);
    </script>
    </div>
 

  </main>

 @endsection