<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
 <?php 
 function clean($data)
    {
       $data = trim($data);
       $data = htmlspecialchars($data);
       $data = stripslashes($data);
       return $data; 
    }
     
 

 if (isset($_POST['save']) && $_SERVER['REQUEST_METHOD'] == "POST"){
    $name = clean($_POST['name']);
    $email = clean($_POST['email']);
    $gender = clean($_POST['gender'] ?? null);
    $skills = $_POST['skill'] ?? null;
    $country = $_POST['county'] ?? null;
    // file upload start
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];

    // validation
    $allowed = ['jpg', 'jpeg', 'png', 'gif' ];
    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    if(empty($fileName)){
        $fileNameErr = "<span style='color:red'>Please select a file to upload</span>";
    } elseif(!in_array($fileActualExt, $allowed)){
        $fileNameErr = "<span style='color:red'>Please select a valid file format</span>";
    } else {
        // check dir uploads
        if(!is_dir('uploads')){
            mkdir('uploads');
        }

        // create new file name
        $fileNewName = str_shuffle(date('HisAFdYDyl')). uniqid('', true) . '.' . $fileActualExt;

        // upload file
        $fileUpload = move_uploaded_file($fileTmpName, 'uploads/' . $fileNewName);
        if ($fileUpload){
            $fileUploadSucc = "<span style='color:green;'>File uploaded successfully</span>";
        } else {
            $fileUploadSucc = "<span style='color:red'>Something went wrong</span>";
        }
    }

    // file upload end

    if(empty($name)){ 
        $nameErr = "Name is requied";
    } elseif (!preg_match("/^[A-Za-z. ]*$/", $name)){

        $nameErr = "Only letters and white space allowed";
    } else {
        $crname = $name;
    }
    $email = $_POST['email'];
    if(empty($email)){ 
        $emailErr = "Valid email is requied";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){

        $emailErr = "Invalid email format";
    } else { 
        $cremail = $email;
    }
    if(empty($gender)){
        $genderErr = "Please select your gender";
    } 
    if(empty($skills)){
        $skillErr = "Plese select your skill";

    } else {
        $crskills = $skills;
    }
    if(empty($country)){
        $countryErr = "Plese select your country";

    } else {
        $crcountry = $country;
    }
    
    
 } 
 ?>   
<div class="container">
    <div class="row min-vh-100 d-flex">
        <div class="col-md-6 m-auto border rounded shadow p-4">
            <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                <div class="mb-3 form-floating">
                    <input type="text" name="name" placeholder="Your name" class="form-control <?= isset($nameErr) ? 'is-invalid':null ?><?= isset($crname) ? 'is-valid':null; ?>" value="<?= $name ?? null; ?>" >
                    <label for="">Your name</label>
                    <div class="invalid-feedback"><?= $nameErr ?? null ?></div>
                    <div class="valid-feedback"><?= $crname ?? null ?></div>                   
                </div>  
                <div class="mb-3 form-floating">
                    <input type="text" name="email" placeholder="Your email" class="form-control <?= isset($emailErr) ? 'is-invalid':null ?><?= isset($cremail) ? 'is-valid':null; ?>" value="<?= $email ?? null; ?>" >
                    <label for="">Email</label>
                    <div class="invalid-feedback"><?= $emailErr ?? null ?></div>
                    <div class="valid-feedback"><?= $cremail ?? null ?></div>                   
                </div>
                <div class="py-3 border rounded shadow-sm <?= isset($genderErr) ? 'border-danger' : null ?><?= isset($gender) ? 'border-success' : null ?>">
                    <div for="" class="form-check form-check-inline">
                        <label class="form-check-label">Gender : </label>
                    </div>
                    <div for="" class="form-check form-check-inline">
                        <input type="radio" value="Male" id="male" name="gender" class="form-check-input" <?= isset($gender) && $gender == "male" ? 'checked':null ?> >
                        <label for="male" class="form-check-label">Male</label>
                    </div>
                    <div for="" class="form-check form-check-inline">
                        <input type="radio" value="Female" id="female" name="gender" class="form-check-input" <?= isset($gender) && $gender == "female" ? 'checked':null ?>>
                        <label for="female" class="form-check-label">Female</label>
                    </div>                    
                    
                </div>
                <div class="mb-3 <?= isset($genderErr) ? 'text-danger' : (isset($gender) ? 'text-success' : null) ?>"><?= $genderErr ?? $gender ?? null?></div>
                
                <div class="border py-3 rounded shadow-sm <?= isset($skillErr) ? 'border-danger' : (isset($crskills) ? 'border-success' : null) ?>">
                    <div for="" class="form-check form-check-inline">
                        <label class="form-check-label">Skills : </label>
                    </div>
                    <div for="" class="form-check form-check-inline">
                        <input type="checkbox" value="HTML" id="html" name="skill[]" class="form-check-input" <?= isset($crskills) && in_array('HTML', $crskills) ? 'checked': null ?> >
                        <label for="html" class="form-check-label">HTML</label>
                    </div>
                    <div for="" class="form-check form-check-inline">
                        <input type="checkbox" value="CSS" id="css" name="skill[]" class="form-check-input" <?= isset($crskills) && in_array('CSS', $crskills) ? 'checked': null ?> >
                        <label for="css" class="form-check-label">CSS</label>
                    </div>
                     <div for="" class="form-check form-check-inline">
                        <input type="checkbox" value="MYSQL" id="mysql" name="skill[]" class="form-check-input" <?= isset($crskills) && in_array('MYSQL', $crskills) ? 'checked': null ?> >
                        <label for="mysql" class="form-check-label">MySQL</label>
                    </div>
                    <div for="" class="form-check form-check-inline">
                        <input type="checkbox" value="PHP" id="php" name="skill[]" class="form-check-input" <?= isset($crskills) && in_array('PHP', $crskills) ? 'checked': null ?> >
                        <label for="php" class="form-check-label">PHP</label>
                    </div>                 
                </div>
                <div class="mb-3 <?= isset($skillErr) ? 'text-danger' : (isset($skills) ? 'text-success' : null )  ?>">
                        <?= $skillErr ?? null ?>   

                            <?php
                            if (isset($skills)) {
                                $countSkills = count($skills);

                                foreach ($skills as $key => $skill) {
                                    echo $skill;

                                    if ($countSkills > 1 && $key < $countSkills - 1) {
                                        echo ", ";
                                    }
                                }
                            }
                            ?>


                    </div>
                    <div class="border py-3 rounded shadow-sm <?= isset($countryErr) ? 'border-danger' : (isset($crcountry) ? 'border-success' : null) ?>">
                        <div for="" class="form-check form-check-inline">
                            <label class="form-label">Country : </label>
                        </div>
                        <div for="" class="from-check form-check-inline">
                            <input list="datalistOptions" class="form-control" id="country" name="country" placeholder="Select your country">
                            <datalist id="datalistOptions">
                                <option value="Bangladesh" <?= isset($crcountry) && in_array('Bangladesh', $crcountry) ? $crcountry : null ?>>
                                <option value="India">
                                <option value="Nepal">
                                <option value="Bhutan">
                                <option value="Thailand">
                            </datalist>
                        </div>

                    </div>
                    <div class="mb-3 <?= isset($countryErr) ? 'text-danger' : (isset($crcountry) ? 'text-success' : null) ?>">
                     <?= $countryErr ?? null ?>
                    </div>
                  <div class="border py-3 rounded shadow-sm <?= isset($fileNameErr) ? 'border-danger' : (isset($fileName) ? 'border-success' : null) ?>">
                        <div for="" class="form-check form-check-inline">
                            <label for="" class="form-label">Upoload your photo :</label>
                            <input type="file" name="file">
                        </div>
                  </div>   
                    <div class="mb-3 <?= isset($fileNameErr) ? 'text-danger' : (isset($fileName) ? 'text-success' : null ) ?>">
                            <?= $fileNameErr ?? null ?><?= $fileUploadSucc ?? null ?>
                    </div>     
                <input type="submit" value="Submit" name="save" class="btn btn-primary medium">
            </form>
        </div>
    </div>
</div>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>