<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>PHED APPRAISALS</title>

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .title {
                font-size: 25px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }
  
            td, th, .text-center{
                border: 1px solid #fcfcfc;
                text-align: center;
                padding-top: 12px;
                padding-bottom: 12px;
                color: #222;
            }
            th > strong{
                color: #636b6f;
            }
            body > div > .table > tbody > .row{
                padding: 10px;
                color:green;
            }
          
            table {
                border-collapse: collapse;
                margin-left: 10px;
                margin-right: 10px;
            }
         
            table tr:nth-child(even){background-color: #f2f2f2;}

            table th {
                padding-top: 12px;
                padding-bottom: 12px;
                text-align: center;
                color: white;
                border-bottom: 1px solid #d2d2d2;
            }
           
        </style>
    </head>
    <body>
            
            <div style="margin-top:25px" class="text-center">
                <h3>PHED APPRAISAL</h3>
                <p>2019 performance Appraisal Report: 2nd Half Year Performance Report</p>
                      
            </div>

            <div class="table-responsive">
       
                <table class="table table-bordered" width="100%">
                    <thead>
                      
                        <tr id="row1">                           
                            <th><strong>S/N</strong></th>
                            <th><strong>EMPLOYEE</strong></th>
                            <th><strong>STAFF ID</strong></th>
                            <th><strong>DESIGNATION</strong></th>
                            <th><strong>EMAIL</strong></th>
                            <th><strong>APPRAISER RATING</strong></th>  
                            <th><strong>REVIEWER RATING</strong></th>  
                            <th><strong>HHCM</strong></th>  
                            <th><strong>CPO</strong></th>                                         
                        </tr>
                    </thead>
                    <tbody>
                        <?php $x = 0; ?>
                        @foreach($employees as $e)
                            <?php $x++; ?>
                            <tr class="item">
                                <td>{{$x}}</td>
                                <td>{{$e->name}}</td>
                                <td>{{$e->staff_id}}</td>
                                <td>{{$e->designation}}</td>
                                <td>{{$e->email}}</td>
                                <td>{{$e->appraiser_rating}}</td>
                                <td>{{$e->reviewer_rating}}</td>
                                <td>{{$e->hhcm_rating}}</td>
                                <td>{{$e->cpo_rating}}</td>                                                               
                            </tr>
                        @endforeach
                    </tbody>
                   
                </table>
            </div>

    </body>
</html>
