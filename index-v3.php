<!DOCTYPE html>
<html>
<head>
    <title>CV Search</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .selected-options {
            padding: 10px;
        }
        .selected-option {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 0.5rem;
            padding: 0.5rem 1rem;
            border: 1px solid #ccc;
            font-size: large;
        }
        .remove-option {
            cursor: pointer;
        }
    </style>
</head>
<body style="background-color: #faf8f8;">
    <div class="container" >
        <div>
            <h1>Recherche sur CV</h1>
            <form method="post" action="">
                <div class="row">

                    <?php
                    $skills_options = array(
                        "django" => "Django",
                        "laravel" => "Laravel",
                        "ruby" => "Ruby on Rails",
                        "express" => "Express.js",
                        "flask" => "Flask",
                        ".net" => "ASP.NET",
                        "spring" => "Spring Boot",
                        "angular" => "Angular",
                        "react" => "React",
                        "vue.js" => "Vue.js",
                        "android" => "Android",
                        "php" => "PHP",
                        "java" => "Java",
                        "firebase" => "Firebase",
                        "python" => "Python",
                        "javascript" => "JavaScript",
                        "sql" => "SQL",
                        "c++" => "C++",
                        "swift" => "Swift",
                        "nodejs" => "Node.js",
                        "docker" => "Docker",
                        "kubernetes" => "Kubernetes",
                        "aws" => "AWS (Amazon Web Services)",
                        "azure" => "Azure",
                        "devops" => "DevOps",
                        "git" => "Git",
                        "jenkins" => "Jenkins",
                        "api" => "API",
                        "json" => "JSON",
                        "mongodb" => "MongoDB",
                        "blockchain" => "Blockchain",
                        "cybersecurity" => "Cybersecurity",
                        "tensorflow" => "TensorFlow",
                        "cloud" => "Cloud Computing",
                        "virtualization" => "Virtualization",
                        "iot" => "Internet of Things (IoT)",
                        "ai" => "Artificial Intelligence (AI)",
                        "nlp" => "Natural Language Processing (NLP)",
                        "ui" => "User Interface (UI)",
                        "ux" => "User Experience (UX)",
                        "mobile" => "Mobile App Development",
                        "web" => "Web Development",
                        "testing" => "Software Testing",
                        "agile" => "Agile Development",
                        "scrum" => "Scrum",
                        "kanban" => "Kanban",
                        "bi" => "Business Intelligence (BI)",
                    );
                    $family_options = array(
                        "célibataire" => "Célibataire",
                        "marié mariée" => "Marié(e)",
                        "divorcé divorcée" => "Divorcé(e)",
                    );
                    $education_options = array(
                        "ingenieur engineer" => "Ingenieur",
                        "mastère master mastere" => "Mastère",
                        "licence bachelor" => "Licence",
                        "bac" => "Bac",
                    );
                    ?>
                    <div class="col-md-3">
                        <label for="skills">Competences techniques</label>
                        <select id="skills" class="form-control" name="options[]" multiple>
                            <?php
                                foreach ($skills_options as $value => $text){
                                    $selected = ($_SERVER["REQUEST_METHOD"] == "POST" && in_array($value, $_POST["options"])) ? "selected" : "";
                                    echo "<option value='$value' $selected>$text</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="family">Situation familiale</label>
                        <select id="family" class="form-control" name="options[]" multiple>
                            <?php
                            foreach ($family_options as $value => $text){
                                $selected = ($_SERVER["REQUEST_METHOD"] == "POST" && in_array($value, $_POST["options"])) ? "selected" : "";
                                echo "<option value='$value' $selected>$text</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="education">Niveau d'étude</label>
                        <select id="education" class="form-control" name="options[]" multiple>
                            <?php
                            foreach ($education_options as $value => $text){
                                $selected = ($_SERVER["REQUEST_METHOD"] == "POST" && in_array($value, $_POST["options"])) ? "selected" : "";
                                echo "<option value='$value' $selected>$text</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <input class="form-control" type="text" name="keywords" placeholder="Entrez autres mots-clés" value="<?php echo $_POST["keywords"] ?? '' ?>">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <input class="btn btn-primary" type="submit" value="Rechercher">
                    </div>
                </div>
                <div class="row">
                    <div id="selected-options1" class="selected-options col-md-3">
                        <!-- Selected options will be displayed here -->
                    </div>
                    <div id="selected-options2" class="selected-options col-md-2">
                        <!-- Selected options will be displayed here -->
                    </div>
                    <div id="selected-options3" class="selected-options col-md-2">
                        <!-- Selected options will be displayed here -->
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
                exec("python pdf_to_txt.py");


                // Directory containing your TXT files
                $txtDirectory = './CVs/txt/';

                // Get a list of TXT files in the directory
                $txtFiles = glob($txtDirectory . '*.txt');

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $keywords = $_POST["keywords"];
                    $keywords = explode(" ", $keywords);
                    $options = $_POST["options"];
                    $results = array();

                    // Loop through TXT files
                    foreach ($txtFiles as $filename) {
                        $output = file_get_contents($filename);
                        $count = 0;
                        $words_found = '';
                        foreach ($options as $option) {
                            if ($key_options = explode(" ", $option)){
                                foreach ($key_options as $key_option) {
                                    if (stripos($output, $key_option) !== false) {
                                        $count++;
                                        $words_found .= $key_option.' ';
                                    }
                                }
                            }elseif (stripos($output, $option) !== false) {
                                $count++;
                                $words_found .= $option.' ';
                            }
                        }
                        foreach ($keywords as $keyword) {
                            if ($keyword !== "" && stripos($output, $keyword) !== false) {
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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script>
        // Select elements
        const selects = [
            document.getElementById('skills'),
            document.getElementById('family'),
            document.getElementById('education')
        ];
        // Display areas for selected options
        const selectedOptionsDivs = [
            document.getElementById('selected-options1'),
            document.getElementById('selected-options2'),
            document.getElementById('selected-options3')
        ];

        function updateSelectedOptions(index) {
            const selectedOptionsDiv = selectedOptionsDivs[index];
            selectedOptionsDiv.innerHTML = '';
            const selectedOptions = Array.from(selects[index].selectedOptions);
            selectedOptions.forEach(option => {
                const selectedOptionDiv = document.createElement('div');
                selectedOptionDiv.classList.add('selected-option');
                selectedOptionDiv.innerHTML = `
            <span>${option.text}</span>
            <span class="remove-option" data-value="${option.value}">X</span>
        `;
                selectedOptionsDiv.appendChild(selectedOptionDiv);
            });

            const removeOptionButtons = selectedOptionsDiv.querySelectorAll('.remove-option');
            removeOptionButtons.forEach(button => {
                button.addEventListener('click', () => removeOption(index, button));
            });
        }

        function removeOption(index, button) {
            const optionValue = button.getAttribute('data-value');
            const optionToRemove = Array.from(selects[index].selectedOptions).find(option => option.value === optionValue);
            if (optionToRemove) {
                optionToRemove.selected = false;
                updateSelectedOptions(index);
            }
        }
    </script>
    <script>
        $('option').mousedown(function(e) {
            e.preventDefault();
            $(this).prop('selected', !$(this).prop('selected'));
            var selectElement = $(this).parent('select');
            switch (selectElement.attr('id')) {
                case 'skills': updateSelectedOptions(0);break;
                case 'family': updateSelectedOptions(1);break;
                case 'education': updateSelectedOptions(2);break;
            }
            return false;
        });
    </script>
</body>
</html>
