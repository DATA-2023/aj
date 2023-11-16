<!DOCTYPE html>
<html>
<head>
    <title>서울시 공공자전거 이용정보 보고서</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }
        header {
            background-color: #0078d4;
            color: #fff;
            text-align: center;
            padding: 20px;
        }
        h1 {
            font-size: 24px;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        h2 {
            font-size: 20px;
            margin-top: 20px;
        }
        p {
            font-size: 16px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #0078d4;
            color: #fff;
        }
        /* 네비게이션바 스타일 */
        nav {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px;
        }
        nav a {
            color: #fff;
            text-decoration: none;
            margin: 10px;
        }
    </style>
</head>
<body>
    <?php
        $host="localhost";
        $user="root";
        $pw="team17";
        $dbName="test";

        $mysqli = mysqli_connect($host, $user, $pw, $dbName);

        if(mysqli_connect_error()){
            echo "MySQL 접속 실패!!","<br>";
            echo "오류 원인: ", mysqli_error();
            exit();
        }
        else{
            $sql = "SELECT S.gu, COUNT(*) AS 이용건수 FROM rent_history AS R JOIN station AS S ON R.rent_station_id = S.station_id GROUP BY S.gu;";
            $res = mysqli_query($mysqli, $sql);
            
            if ($res) {
                // 데이터 배열 생성
                $dataArray = array();
                while ($row = $res->fetch_assoc()) {
                    $dataArray['labels'][] = $row['gu'];
                    $dataArray['data'][] = $row['이용건수'];
                }
            } else {
                echo "0 results";
            }
        }
        mysqli_close($mysqli);
    ?>
    <header>
        <h1>서울시 공공자전거 이용정보 보고서</h1>
    </header>
    <nav>
        <!-- 자기 파트 웹페이지 만들어서 제목 추하 html파일 연결하기-->
        <a href="#summary">이용 현황 요약</a>
        <a href="#monthlyChart">월별 이용 건수 그래프</a>
        <a href="#detailData">상세 데이터</a>
    </nav>
    <div class="container">
        <h2>서울 소재 구별 대여 현황</h2>
        <p>2023년 6월 서울시 공공자전거 구별 이용 현황에 대한 정보입니다.</p>
        
        <h2>그래프: 월별 이용 건수</h2>
        <canvas id="monthlyChart"></canvas>

        <h2>상세 데이터</h2>
        <p>각 구역 및 기간별 자세한 데이터는 다음과 같습니다:</p>
        <div id="tableDiv"></div>

    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var labels = <?php echo json_encode($dataArray['labels']); ?>;
        var data = <?php echo json_encode($dataArray['data']); ?>;

        var ctx = document.getElementById("monthlyChart").getContext("2d");
        var chart = new Chart(ctx, {
            type: "bar",
            data:{
                labels: labels,
                datasets: [{
                    label: '이용건수',
                    data: data,
                    backgroundColor: "rgba(0, 120, 212, 0.8)",
                    borderColor: "rgba(0, 120, 212, 1)",
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        });

        var tableHTML = '<table border="1"><tr><th>구</th><th>이용건수</th></tr>';
        for (var i = 0; i < labels.length; i++) {
            tableHTML += '<tr><td>' + labels[i] + '</td><td>' + data[i] + '</td></tr>';
        }
        tableHTML += '</table>';

        // 표를 표시할 div에 추가
        document.getElementById('tableDiv').innerHTML = tableHTML;
    </script>
</body>
</html>

