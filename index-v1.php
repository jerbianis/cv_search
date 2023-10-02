<!DOCTYPE html>
<html>
<head>
    <title>CV Search</title>
</head>
<body>
    <h1>CV Search</h1>
    <form method="post" action="">
        <input type="text" name="keywords" placeholder="Enter keywords" required>
        <input type="submit" value="Search">
    </form>
    <div>
        <?php
        // Directory containing your PDF files
        $pdfDirectory = './CVs/';

        // Get a list of PDF files in the directory
        $pdfFiles = glob($pdfDirectory . '*.pdf');
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $keywords = $_POST["keywords"];
            $keywords = explode(" ", $keywords);
            $results = array();
        
            // Loop through your PDF files and call the Python script
            foreach ($pdfFiles as $filename) {
                // Replace 'python' with 'python3' if needed
                $command = "python pdf_extractor_v1.py ".$filename;
                $output = shell_exec($command);
                $count = 0;
                foreach ($keywords as $keyword) {
                    if (stripos($output, $keyword) !== false) {
                        $count++;
                    }
                }
                
                if ($count > 0) {
                    $results[$filename] = $count;
                }
            }
        
            // Sort results by the number of occurrences
            arsort($results);
        
            // Display results
            echo "<h2>Search Results:</h2>";
            echo "<ol>";
            foreach ($results as $filename => $count) {
                echo "<li><a href='$pdfDirectory.$filename'>$filename</a> (Occurrences: $count)</li>";
            }
            echo "</ol>";
        }
        ?>
    </div>
</body>
</html>
