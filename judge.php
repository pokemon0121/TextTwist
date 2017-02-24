<?php
    include 'utils.php';
    if (!session_id()) {
        session_start();
    }
    if (!isset($_POST['guess'])) {
        echo 'error, got no guess data';
        exit(1);
    }
    if ($_POST['guess'] == '') {
        echo json_encode(array('correct' => 3));
        exit(0);
    }
    if (strlen($_POST['guess']) > 8) {
        echo json_encode(array('correct' => 4));
        exit(0);
    }
    if (in_array(strtoupper($_POST['guess']), $_SESSION['answer'])) {
        $index = array_search(strtoupper($_POST['guess']), $_SESSION['answer']);
        if ($_SESSION['record'][$index] == 1) {
            echo json_encode(array('correct' => -1));
        }
        else {
            $w = $_SESSION['answer'][$index];
            $_SESSION['record'][$index] = 1;
            $finished = false;
            if (finished($_SESSION['record'])) {
                echo json_encode(array('correct' => 2, 'index' => $index, 'word_len' => strlen($w), 'word' => $w));
            }
            else {
                echo json_encode(array('correct' => 1, 'index' => $index, 'word_len' => strlen($w), 'word' => $w, 'remained' => remained($_SESSION['record'])));
            }
        }
    }
    else {
        echo json_encode(array('correct' => 0));
    }
?>