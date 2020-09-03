<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SB Admin 2 - Dashboard</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">

</head>

<body id="page-top">

  <div id="wrapper">

   
   
   <?php
include 'sidebar.php';
?>

 
    <div id="content-wrapper" class="d-flex flex-column">


      <div id="content">

    
      <?php include 'header.php'; ?>
        
      <div class="container-fluid">
      <h5 class="text-center">List Page </h5> 
     
          <div class="row company-creation-form shadow">
            <div class="company-data-list d-flex justify-content-between w-100">
                <h6>Date</h6>
                <p>01-01-2021</p>
            </div>
            <div class="company-data-list d-flex justify-content-between w-100">
                <h6>Vehicle RegNo:</h6>
                <p>Enter Vehicle Number</p>
            </div>
            <div class="company-data-list d-flex justify-content-between w-100">
                <h6>Vehicle Manufacturing Year:</h6>
                <p>2020</p>
            </div>
            <div class="company-data-list d-flex justify-content-between w-100">
                <h6>Classis No:</h6>
                <p>Enter Vehicle Number</p>
            </div>
            <div class="company-data-list d-flex justify-content-between w-100">
                <h6>Engine No:</h6>
                <p>Enter Vehicle Number</p>
            </div>
            <div class="company-data-list d-flex justify-content-between w-100">
                <h6>Vechicle Make:  </h6>
                <p>Enter Vehicle Number</p>
            </div>
            <div class="company-data-list d-flex justify-content-between w-100">
                <h6>Vechicle Model:</h6>
                <p>Enter Vehicle Number</p>
            </div>
            <div class="company-data-list d-flex justify-content-between w-100">
                <h6>Owner Name</h6>
                <p>Enter Name</p>
            </div>
            <div class="company-data-list d-flex justify-content-between w-100">
                <h6>Phone</h6>
                <p>Enter Mobile Number</p>
            </div>
            <div class="company-data-list d-flex justify-content-between w-100">
                <h6>Address</h6>
                <p>Enter Address</p>
            </div>
            <div class="company-data-list d-flex justify-content-between w-100">
                <h6>RTO</h6>
                <p>RTO Number</p>
            </div>

            <div class="border-bottom mb-3 w-100">
               <h6 class="text-center"> Reflective Tape details </h6>
            </div>

            <div class="company-data-list d-flex justify-content-between w-100">
                <h6>Red 20mm:</h6>
                <p> Number</p>
            </div>  
            <div class="company-data-list d-flex justify-content-between w-100">
                <h6>white 20mm:</h6>
                <p> Number</p>
            </div>  
            <div class="company-data-list d-flex justify-content-between w-100">
                <h6>Red 50mm:</h6>
                <p> Number</p>
            </div>  
            <div class="company-data-list d-flex justify-content-between w-100">
                <h6>white 50mm:</h6>
                <p> Number</p>
            </div>  
            <div class="company-data-list d-flex justify-content-between w-100">
                <h6>Yellow 50mm:</h6>
                <p> Number</p>
            </div>  
            <div class="company-data-list d-flex justify-content-between w-100">
                <h6>80mm red circular reflector:</h6>
                <p> Number</p>
            </div> 
            <div class="company-data-list d-flex justify-content-between w-100">
                <h6>80mm white circular reflector:</h6>
                <p> Number</p>
            </div> 
            <div class="company-data-list d-flex justify-content-between w-100">
                <h6>80mm yellow circular reflector:</h6>
                <p> Number</p>
            </div> 
            <div class="company-data-list d-flex justify-content-between w-100">
                <h6>Class 3:</h6>
                <p> Number</p>
            </div> 
            <div class="company-data-list d-flex justify-content-between w-100">
                <h6>Class 4:</h6>
                <p> Number</p>
            </div> 
            <div class="border-bottom mb-5 w-100">
               <h6 class="text-center"> Images </h6>
            </div>

            <div class="row">
            <div class="col-lg-4  mb-3"> 
            <p class="text-center">Front Image</p>
                <img src="img/image-human-brain_99433-298.jpg" class="w-100" alt="images"/>
            </div>
            <div class="col-lg-4  mb-3"> 
            <p class="text-center">Left Image</p>
                <img src="img/image-human-brain_99433-298.jpg" class="w-100" alt="images"/>
            </div>
            <div class="col-lg-4  mb-3"> 
            <p class="text-center">Right Image</p>
                <img src="img/image-human-brain_99433-298.jpg" class="w-100" alt="images"/>
            </div>
            <div class="col-lg-4  mb-3"> 
            <p class="text-center">Back Image</p>
                <img src="img/image-human-brain_99433-298.jpg" class="w-100" alt="images"/>
            </div>

            

            </div>
            <div class=" d-flex justify-content-center w-100">
                    <button type="button" class="btn btn-success mr-2"> Accept </button>
                    <button type="button" class="btn btn-danger"> Reject </button>

            </div>

            
          </div>
      </div>
        <!-- /.container-fluid -->

      </div>
      
  <?php include 'footer.php' ?>
     

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
 

  <!-- Logout Modal-->
  <!-- <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.html">Logout</a>
        </div>
      </div>
    </div>
  </div> -->



</body>

</html>
