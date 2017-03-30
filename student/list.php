<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    
    <link rel="stylesheet" href="../css/style.css">
    
    <!-- Latest compiled and minified JavaScript -->
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">collegeAnalytics</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="../index.php">Home</a></li>
            <li><a href="../student/list.php">Student</a></li>
            <li><a href="../teacher/list.php">Teacher</a></li>
            <li><a href="../test/list.php">Test</a></li>
            <li><a href="../questions/list.php">Questions</a></li>
            <li><a href="../classroom/list.php">Classroom</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <div class="container theme"> 
        <h1>Students > loading...</h1>
        <a href="import_student.php">Import</a>
        <table class="table table-striped">
            <thead>
                <th>##</th>
                <th>Code</th>
                <th>Start Date</th>
                <th>Name</th>
                <th>Sex</th>
                <th>E-mail</th>
            </thead>
            <tbody>
            <?php
                    $connection = mysql_connect("176.32.230.51", "cl60-aflf", "mydb");
                    if(!$connection) die ("Fail");
                    mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $connection);
                    $db = mysql_select_db("cl60-aflf");
                    
                    $cont_fem = 0;
                    $cont_mas = 0;
                    $cont_no = 0;

                    $sql = "SELECT *, DATE_FORMAT(A.data_cadastro, '%d/%m/%Y')as inputDate FROM tb_aluno A";
                    $result = mysql_query($sql);
                    while($line = mysql_fetch_assoc($result))
                     {
                       echo '<tr>';
                        echo '<td>' . $line['id'] . '</td>';
                        echo '<td>' . $line['codigo'] . '</td>';
                        echo '<td>' . $line['inputDate'] . '</td>';
                        echo '<td>' . $line['nome'] . '</td>';
                        
                        $sexo = ($line['sexo'] == 'F') ? 'Feminine' : 'Masculine';
                        echo '<td>' . $sexo . '</td>';
                        echo '<td>' . $line['email'] . '</td>';
                       echo '</tr>';
                       
                       if($line['sexo'] == 'F') 
                               $cont_fem++;
                           else if ( $line['sexo'] == 'M') 
                               $cont_mas++;
                           else 
                               $cont_no++;
                     }    
                     
                   mysql_close($connection);
               ?>
            </tbody>
        </table>
        <div id="piechart_3d" style="width: 900px; height: 500px;"></div>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Sexo', 'Value'],
          ['Fem',     <?php echo $cont_fem; ?>],
          ['Mas',      <?php echo $cont_mas; ?>],
          ['No Info',  <?php echo $cont_no; ?>],
        ]);

        var options = {
          title: 'Chart by sex',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script>
  </body>
</html>