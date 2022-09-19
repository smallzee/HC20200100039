<?php
 	require_once 'core/config.php'; 

 	$error = array();

 	if (isset($_GET['id'])) { // todo delete student record
 		$id = $_GET['id'];
 		$db->query("DELETE FROM students WHERE id='$id'");
 		set_flash("Student information has been deleted","info");
 	}

 	if (isset($_POST['create'])) { // todo update student record

 		$data = $_POST;

 		$matric = strtolower(trim($data['matric']));
 		$firstName = trim($data['first_name']);
 		$lastName = trim($data['last_name']);
 		$email = trim($data['email']);
 		$phone = trim($data['phone']);
 		$gender = trim($data['gender']);
 		$department = trim($data['department']);
 		$level = trim($data['level']);

 		$sql_matric = $db->query("SELECT * FROM students WHERE matric_number='$matric'");

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

 		if ($sql_matric->rowCount() >= 1) {
 			$error[] = "Matric number is already used, please check and try again";
 		}

 		$sql_email = $db->query("SELECT * FROM students WHERE email ='$email'");
 		if ($sql_email->rowCount()  >= 1) {
 			$error[] = "Email address has already been used, please check and try again";
 		}

 		$sql_phone = $db->query("SELECT * FROM students WHERE phone='$phone'");
 		if ($sql_phone->rowCount() >= 1) {
 			$error[] = "Phone number has already been used, please check and try again";
 		}


 		$error_count = count($error);
 		if ($error_count == 0) {

 			$name = $firstName." ".$lastName;
 		 	
 		 	$db->query("INSERT INTO students (matric_number,first_name,last_name,email,phone,gender,level,department)VALUES('$matric','$firstName','$lastName','$email','$phone','$gender','$level','$department')");

 		 	set_flash("Student information has been successful created","info");

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
							<h5 class="card-title">Create Student Information</h5>
						</div>
						<div class="card-body">
							
							<?php flash(); ?>
							<form method="post">
								<div class="row">
								

									<div class="col-sm-6">
										<div class="form-group">
											<label>First Name</label>
											<input type="text" class="form-control" required name="first_name" placeholder="First Name">
										</div>
									</div>

									<div class="col-sm-6">
										<div class="form-group">
											<label>Last Name</label>
											<input type="text" class="form-control" required placeholder="Last Name" name="last_name">
										</div>
									</div>

									<div class="col-sm-12">
										<div class="form-group">
											<label>Matric Number</label>
											<input type="text" class="form-control" required placeholder="Matric Number" name="matric">
										</div>
									</div>

									<div class="col-sm-6">
										<div class="form-group">
											<label>Email Address</label>
											<input type="email" class="form-control" required placeholder="Email" name="email">
										</div>
									</div>

									<div class="col-sm-6">
										<div class="form-group">
											<label>Phone Number</label>
											<input type="text" class="form-control" required placeholder="Phone Number" name="phone">
										</div>
									</div>

									<div class="col-sm-12">
										<div class="form-group">
											<label>Gender</label>
											<select class="form-control" required name="gender">
												<option>Male</option>
												<option>Female</option>
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
														<option><?= $value ?></option>
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
									<input type="submit" class="btn btn-primary" value="Create Student Information" name="create">
								</div>
							</form>
						</div>
					</div>
				</div>

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 " style="margin-top: 20px;">

					<div class="card card-default ">
						<div class="card-header">
							<div class="card-title">All Student Information</div>
						</div>
						<div class="card-body">
							
							<div class="table-responsive">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>S/N</th>
											<th>Matric Number</th>
											<th>Full Name</th>
											<th>Email Address</th>
											<th>Phone Number</th>
											<th>Gender</th>
											<th>Level</th>
											<th>Department</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$sn =1;
											$sql = $db->query("SELECT s.*, d.name as department FROM students s INNER JOIN department d ON s.department = d.id ORDER BY matric_number");
											while ($rs = $sql->fetch(PDO::FETCH_ASSOC)) {
												?>
												<tr>
													<td><?= $sn++ ?></td>
													<td><?= strtoupper($rs['matric_number']) ?></td>
													<td><?= ucwords($rs['first_name']." ".$rs['last_name']) ?></td>
													<td><?= $rs['email'] ?></td>
													<td><?= $rs['phone'] ?></td>
													<td><?= $rs['gender'] ?></td>
													<td><?= $rs['level'] ?></td>
													<td><?= ucwords($rs['department']) ?></td>
													<td>
														<div class="btn-group">
															<a href="edit.php?id=<?= $rs['id'] ?>" class="btn btn-primary">Edit</a>
															<a href="?id=<?= $rs['id'] ?>" onclick="return confirm('Are you sure, you want to delete this record')" class="btn btn-danger">Delete</a>
														</div>
													</td>
												</tr>
												<?php
											}
										?>
									</tbody>
								</table>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<?php require_once 'footer.php'; ?>


</body>
</html>