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
        <h2>회원별 누적 이용금액</h2>
        <p>서울시 공공자전거를 이용하는 회원들의 누적 이용금액에 대한 정보입니다.<br>나이대별, 성별, 국적별로 확인하실 수 있습니다.</p>
        <form method="post">
            <label for="category">구분:</label>
            <select name="category" id="category">
                <option value="all">전체</option>
                <option value="gender">성별</option>
                <option value="age_group">나이대별</option>
                <option value="nationality">국적별</option>
            </select>

            <input type="submit" value="조회">
        </form>

        <?php
            $host="localhost";
            $user="root";
            $pw="team17";
            $dbName="test";

            // MySQL 연결
            $conn = new mysqli($host, $user, $pw, $dbName);

            // 연결 확인
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // 사용자의 입력 받기
            $category = isset($_POST['category']) ? $_POST['category'] : 'all';
            
            $query = "SELECT AVG(cumulative_usage_amount) FROM user";

            // 쿼리 작성
            if ($category == 'gender'){
                $query = "SELECT gender, AVG(cumulative_usage_amount) AS average_usage FROM user GROUP BY gender;";
            }
            if ($category == 'age_group'){
                $query = "SELECT age_group, AVG(cumulative_usage_amount) AS average_usage FROM user GROUP BY age_group;";
            }
            if ($category == 'nationality'){
                $query = "SELECT nationality, AVG(cumulative_usage_amount) AS average_usage FROM user GROUP BY nationality;";
            }

            // 쿼리 실행
            $result = $conn->query($query);


            // 결과 출력
            echo "<h2>회원 구분별 누적 이용금액 평균</h2>";
            echo "<table border='1'>";
            while ($row = $result->fetch_assoc()) {
                
                echo "<tr>";
        
                // 각 행의 열을 동적으로 처리
                foreach ($row as $column) {
                    echo "<td>$column</td>";
                }
        
                echo "</tr>";
            }
            echo "</table>";
        
            // 연결 종료
            $conn->close();
        ?>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        

    </script>
</body>
</html>

