<?php
    include 'utils.php';
    if (!session_id()) {
        session_start();
    }
    
    
    $dbhandle = new PDO("sqlite:scrabble.sqlite") or die("Failed to open DB");
    if (!$dbhandle) die ($error);

    $answers = array();
    while (count($answers) == 0) {
        $len = rand(4, 8);
        $root_rack = generate_rack($len);
        $subracks = generate_subracks($root_rack);
        foreach ($subracks as $r) {
            $query = "select words from racks where rack = '".$r."'";
            $statement = $dbhandle->prepare($query);
            $statement->execute();
            $results = $statement->fetchAll(PDO::FETCH_ASSOC);
            $rows = count($results);
            if ($rows != 0) {
                $answers = array_merge($answers, explode("@@", $results[0]['words']));
            }
        }
        usort($answers, function($a, $b) {
            return strlen($a) - strlen($b);
        });
        $answers_lengths = array();
        foreach ($answers as $ans) {
            array_push($answers_lengths, strlen($ans));
        }
    }
    header('HTTP/1.1 200 OK');
    header('Content-Type: application/json');
    $_SESSION['answer'] = $answers;
    $_SESSION['record'] = array_pad(array(), count($answers), 0);
    echo json_encode(
        array(
            'len' => $len, 
            'root_rack' => $root_rack, 
            'answers_count' => count($answers), 
            'answers_lengths' => $answers_lengths,
            'answers' => $answers
        )
    );
?>
