<!DOCTYPE html>
<html>
<head>
    <title>CV Search</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #faf8f8;">
    <div class="container" >
        <div>
            <h1>Recherche sur CV</h1>
            <form method="post" action="">
                <div class="row">
                    <div class="col-md-3">
                        <input class="form-control" type="text" name="keywords" placeholder="Entrez des mots-clés" value="<?php echo $_POST["keywords"] ?? '' ?>" required>
                    </div>
                    <div class="col-md-2">
                        <input class="btn btn-primary" type="submit" value="Rechercher">
                    </div>

                </div>
            </form>
        </div>
        <div class="mt-2 border">
            <table class="table table-responsive table-hover mb-0">
                <tr>
                    <th>#</th>
                    <th>Curriculum Vitae</th>
                    <th>Occurrences</th>
                    <th>Score</th>
                </tr>
                <?php
                //convert pdf files to txt
                $out = shell_exec("python pdf_to_txt.py 2>&1");
                var_dump($out);


                // Directory containing your TXT files
                $txtDirectory = './CVs/txt/';

                // Get a list of TXT files in the directory
                $txtFiles = glob($txtDirectory . '*.txt');

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $keywords = $_POST["keywords"];
                    $keywords = explode(" ", $keywords);
                    $results = array();

                    // Loop through TXT files
                    foreach ($txtFiles as $filename) {
                        $output = file_get_contents($filename);
                        $count = 0;
                        $words_found = '';
                        foreach ($keywords as $keyword) {
                            if (stripos($output, $keyword) !== false) {
                                $count++;
                                $words_found .= $keyword.' ';
                            }
                        }

                        if ($count > 0) {
                            $results[$filename] = $count;
                            $words[$filename] = $words_found;
                        }
                    }

                    // Sort results by the number of occurrences
                    arsort($results);

                    // Display results
                    $rank=0;
                    $old_score= 0;
                    foreach ($results as $filename => $count) {
                        $pdf_file_path= "./CVs/".pathinfo($filename,PATHINFO_FILENAME).".pdf";
                        if ($old_score != $count) {
                            $rank +=1 ;
                        }
                        ?>
                        <tr>
                            <td><?php echo $rank ?></td>
                            <td><a target="_blank" href="<?php echo $pdf_file_path ?>"><?php echo pathinfo($filename,PATHINFO_FILENAME) ?></a></td>
                            <td><?php echo $words[$filename] ?></td>
                            <td><?php echo $count ?></td>
                        </tr>
                        <?php
                        $old_score= $count;
                    }
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>
