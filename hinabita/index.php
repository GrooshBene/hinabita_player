<?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    $conn = mysql_connect('localhost', 'hinabita', 'prec') or die("asdf");
    $db = mysql_select_db('hinabita', $conn);
    $musicId = $_GET['id'];

?>

<html>
    <head>
        <meta charset="utf-8"/>
        <meta property="og:url" content="http://lntcs.iptime.org/hinabita/">
    <meta property="og:title" content="ANi! Music">  
    <meta property="og:type" content="website">
    <meta property="og:image" content="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTGLSAjdz0DmTAsB5MlsbZNOVRo4W3kXYeRvmPXjMFmZPAn6U81">
    <meta property="og:description" content="ANi! 뮤직 플레이어">
    <meta name="description" content="ANi! 뮤직 플레이어">   
        <title>ANi! MusicStreamer</title>
        <link rel="stylesheet" href="css/board.css"/>
        <link rel="stylesheet" href="css/normalize.css"/>
        <link rel="stylesheet" href="css/index.css"/>        
        <link rel="stylesheet" href="css/player.css"/>   
</head>
    <body>
    <script>
                   function looper(){
                var player = document.getElementById('music');
                var loopchk = document.getElementById('isLooped');
                if(player.loop == true){
                    player.loop = false;
                    loopchk.innerHTML = "자동반복 해제";
                }
                else if(player.loop == false){
                    player.loop = true;
                    loopchk.innerHTML = "자동반복 설정";
                }
                   }
            var music = document.getElementById('music');
            var duration;
            var pButton = document.getElementById('songPlay');
            var playhead = document.getElementById('playhead');
            var timeline = document.getElementById('timeline');
            //var timelineWidth = timeline.offsetWidth - playhead.offsetWidth;
            music.addEventListener("timeupdate", timeUpdate, false);
            timeline.addEventListener("click", function (event){
                moveplayhead(event);
                music.currentTime = duration *clickPercent(event);
            },false);
            function clickPercent(e){
                return (e.pageX -timeline.offsetLeft) / timelineWidth;
            }

            playhead.addEventListener('mousedown', mouseDown, false);
            window.addEventListener('mouseup', mouseUp, false);

            var onplayhead = false;

            function mouseDown(){
                onplayhead = true;
                window.addEventListener('mousemove' ,moveplayhead, true);
                music.removeEventListener('timeupdate', timeUpdate, false);
            }

            function mouseUp(e){
                if(onplayhead == true){
                    moveplayhead(e);
                    window.removeEventListener('mousemove', moveplayhead, true);
                    music.currentTime = duration * clickPercent(e);
                    music.addEventListener('timeupdate', timeUpdate, false);
                }
                onplayhead = false;
            }

            function moveplayhead(e){
                var newMargLeft = e.pageX - timeline.offsetLeft;
                if(newMargLeft >= 0 && newMargLeft <= timelineWidth){
                    playhead.style.marginLeft = newMargLeft + "px";
                }
                if(newMargLeft < 0){
                    playhead.style.marginLeft = "0px";
                }
                if(newMargLeft > timelineWidth){
                    playhead.style.marginLeft = timelineWidth + "px";
                }
            }

            function timeUpdate(){
                varplayPercent = timelineWidth * (music.currentTime / duration);
                playhead.style.marginLeft = playPercent + "px";
                if(music.currentTime == duration){
                    pButton.className = "";
                    pButton.className = "play";
                }
            }

            function play(){
                if(music.paused){
                    music.play();
                    pButton.className = "";
                    pButton.className = "pause";
                } else{
                    music.pause();
                    pButton.className = "";
                    pButton.className = "play";
                }
            }

            music.addEventListener("canplaythrough", function(){
                duration = music.duration;
            }, false);

    </script>
 
        <table>
            <thead>
                <tr>
                    <th scope="col" class="no">듣기</th>
                    <th scope="col" class="title">제목</th>
                    <th scope="col" class="download">다운로드</th>
                </tr>
            </thead>
            <tbody>
                 <?php
                     $query = "SELECT * FROM MUSICLIST";
                     $result = mysql_query($query, $conn);
                     while($data = mysql_fetch_array($result)){
                 ?>
                <tr>
                    <td class="no"><input type="button" value="듣기" onclick="location.href='./index.php?id=<?php echo $data['musicid']?>'"></input></td>
                    <td class="title"><?php echo $data['musictitle'];?></td>
                    <td class="download"><input type="button" value="다운로드" onclick="location.href='./php/download.php?id=<?php echo $data['musicid']?>'"></input></td>
                </tr>
                 <?php
                     }
                 ?>
            </tbody>
        </table>
        <footer class="container">
        <button id="songPlay" onclick="play()"></button>
        <button id="songStop" onclick="stopSong('player')"></button>
        <div id="timeline">
            <div id="playhead"></div>
        </div>
        <audio id="music" preload="true" autoplay>

                <?php
                     $playerquery = "SELECT * FROM MUSICLIST WHERE musicid='".$musicId."'";
                     $playresult = mysql_query($playerquery, $conn);
                     while($playdata = mysql_fetch_array($playresult)){
                ?>
            <source src='<?php echo $playdata['musicurl'];?>' type='audio/mp3'>Your Browser Does not support this player.</source></audio>
            <p><?php echo $playdata['musictitle'];?></p>
            <p id="isLooped">자동반복 해제</p>
            <input type="button" value="자동반복 설정" onclick="looper()"></input>
                <?php
                     }
                ?>
        </footer>
    </body>
</html>

