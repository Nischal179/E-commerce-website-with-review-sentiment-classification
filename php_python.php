<?php
    $review = "Very bad taste, absolutely hated it";
    $command = "python api.py \"$review\" 2>&1";
    putenv("PYTHONIOENCODING=utf-8");
    $response = shell_exec($command);
    
    // Extract the response without the URL
    $pattern = '/Loaded as API: (.+)/';
    $replacement = '';
    $cleanResponse = preg_replace($pattern, $replacement, $response);
    
    echo $cleanResponse;
    
?>