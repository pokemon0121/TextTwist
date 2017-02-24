<?php
    if (!session_id()) {
        session_start();
    }
    if (!isset($_SESSION['answer'])) {
        $answer = [];
        $record = [];
    }
?>