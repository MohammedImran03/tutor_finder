

<?php 

include 'sidebar.php'; 

include '../../vendor/autoload.php';
// MongoDB connection
$mongoClient = new MongoDB\Client('mongodb+srv://praveen:Byf0rEebirBOILam@cluster0.9mzctp3.mongodb.net/');
$courses = $mongoClient->tunetutor->course_enrollment->find();

?>
<div class="main-panel">
    <div class="content-wrapper" style="background-color:white;">
        
        <div class="row">
            
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Courses List</h4>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                      
                                        <th>User ID</th>
                                        <th>Payment ID</th>
                                        <th>Amount</th>
                                        <th>Product ID</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($courses as $course): ?>
                                    <tr>
                                       
                                        <td><?php echo $course['user_id']; ?></td>
                                        <td><?php echo $course['payment_id']; ?></td>
                                        <td><?php echo $course['amount']; ?></td>
                                        <td><?php echo $course['product_id']; ?></td>
                                       
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>