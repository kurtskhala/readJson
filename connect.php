<?php
    ini_set("allow_url_fopen", 1);
    $url = 'https://api.jikan.moe/v3/search/anime?q=naruto';
    $JSON = file_get_contents($url);
    $obj = json_decode($JSON, TRUE);
?>

<?php
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $conn= new mysqli('localhost', 'root', '','php warriors',8111) 
                            or die( "Connection Failed:" .mysqli_error());
            $count = 0;
            $max = 10;
            foreach($obj['results'] as $results) {
                $count++;
                $mal_id=$results['mal_id'];
                $url = $results['url'];
                $image_url = $results['image_url'];
                $title = $results['title'];
                $synopsis = $results['synopsis'];
                $rated = $results['rated'];
                $sql = "INSERT INTO `narutomovies` (`mal_id`,`url`,`image_url`,`title`,`synopsis`,`rated`) 
                VALUES ('$mal_id','$url','$image_url', '$title','$synopsis','$rated')";
                
                $query = mysqli_query($conn,$sql);
                            
                            if($query){
                            } else {
                                echo "Error Occurred";
                            }
                if($count>=$max){
                    break;
                }
            }
        }
        header("Location: http://localhost/readjson/index.php", TRUE, 301);
    ?>