<?php
 	require_once 'core/config.php'; 

 	$error = array();

 	if (isset($_GET['id'])) {
 		$id = $_GET['id'];
 		$sql = $db->query("SELECT * FROM students WHERE id='$id'");
 		$student_info = $sql->fetch(PDO::FETCH_ASSOC);
 	}



 	if (isset($_POST['update'])) {

 		$data = $_POST;

 		$matric = strtolower(trim($data['matric']));
 		$firstName = trim($data['first_name']);
 		$lastName = trim($data['last_name']);
 		$email = trim($data['email']);
 		$phone = trim($data['phone']);
 		$gender = trim($data['gender']);
 		$department = trim($data['department']);
 		$level = trim($data['level']);

 		if (empty($matric)) {
 			$error[] = "Matric number is required";
 		}

 		if (empty($firstName)) {
 			$error[] ="Your first name is required";
 		}

 		if (empty($lastName)) {
 			$error[] ="Your last name is required";
 		}

 		if (empty($email)) {
 			$error[] = "Email is required";
 		}

 		if (empty($phone)) {
 			$error[] = "Phone number is required";
 		}

 		if (empty($gender)) {
 			$error[] = "Gender is required";
 		}

 		if (empty($department)) {
 			$error[] = "Department is required";
 		}

 		if (empty($level)) {
 			$error[] = "Level is required";
 		}


 		$error_count = count($error);
 		if ($error_count == 0) {

 		
 			$db->query("UPDATE students SET matric_number='$matric',first_name='$firstName', last_name='$lastName',email='$email',phone='$phone', gender='$gender', level='$level', department='$department' WHERE id ='$id'");

 		 	set_flash("Student information has been successful updated","info");

 		 	// header("location:edit.php?id=$id");

 		 }else{
 		 	$msg = $error_count > 1 ? 'Some errors are occurred while creating an account' : 'An error is occurred while creating an account';
	        foreach ($error as $value){
	            $msg.='<p>'.$value.'</p>';
	        }
	        set_flash($msg,"danger");
 		 } 
 		
 	}
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Student Information </title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/css.css">
</head>
<body>

	<section id="main">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card card-default">
						<div class="card-header">
							<h5 class="card-title">Update Student Information</h5>
						</div>
						<div class="card-body">
							
							<?php flash(); ?>
							<form method="post">
								<div class="row">
								

									<div class="col-sm-6">
										<div class="form-group">
											<label>First Name</label>
											<input type="text" value="<?= $student_info['first_name'] ?>" class="form-control" required name="first_name" placeholder="First Name">
										</div>
									</div>

									<div class="col-sm-6">
										<div class="form-group">
											<label>Last Name</label>
											<input type="text" class="form-control" value="<?= $student_info['last_name'] ?>" required placeholder="Last Name" name="last_name">
										</div>
									</div>

									<div class="col-sm-12">
										<div class="form-group">
											<label>Matric Number</label>
											<input type="text" class="form-control" value="<?= $student_info['matric_number'] ?>" required placeholder="Matric Number" name="matric">
										</div>
									</div>

									<div class="col-sm-6">
										<div class="form-group">
											<label>Email Address</label>
											<input type="email" class="form-control" value="<?= $student_info['email'] ?>" required placeholder="Email" name="email">
										</div>
									</div>

									<div class="col-sm-6">
										<div class="form-group">
											<label>Phone Number</label>
											<input type="text" class="form-control" value="<?= $student_info['phone'] ?>" required placeholder="Phone Number" name="phone">
										</div>
									</div>

									<div class="col-sm-12">
										<div class="form-group">
											<label>Gender</label>
											<select class="form-control" required name="gender">
												<?php 
													foreach(array('male','female') as $value){
														?>
														<option value="<?= $value ?>" <?= ($student_info['gender'] == $value) ? "selected" : ""?> ><?= ucwords($value) ?></option>
														<?php
													}
												 ?>
											</select>
										</div>
									</div>

									<div class="col-sm-6">
										<div class="form-group">
											<label>Level</label>
											<select class="form-control" name="level" required>
												<?php 
													foreach (array('ND I FT','ND II FT','ND I DPT','ND II DPT','ND RPTY1','ND RPTY2','ND RPTY3','HND I FT','HND II FT','HND I DPT','HND II DPT') as $value) {
														?>
														<option value="<?= $value ?>" <?= ($student_info['level'] == $value) ? "selected" : ""?>><?= $value ?></option>
														<?php
													}
												?>
											</select>
										</div>
									</div>

									<div class="col-sm-6">
										<div class="form-group">
											<label>Department</label>
											<select class="form-control" name="department" required >
												<?php 
													$sql = $db->query("SELECT * FROM department ORDER BY name");
													while ($rs = $sql->fetch(PDO::FETCH_ASSOC)) {
														?>
														<option value="<?= $rs['id'] ?>"><?= ucwords($rs['name']) ?></option>
														<?php
													}
												 ?>
											</select>
										</div>
									</div>
								</div>

								<div class="form-group">
									<input type="submit" class="btn btn-primary" value="Update Student Information" name="update">
								</div>
							</form>
						</div>
					</div>
				</div>

			</div>
		</div>
	</section>

	<?php require_once 'footer.php'; ?>

</body>
</html>