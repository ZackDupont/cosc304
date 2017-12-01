<?

if(isset($_POST['cure_name']) && isset($_POST['injection_site']) && isset($_POST['injection_timing']) && isset($_POST['num_injections'])
&& isset($_POST['special_reqs']) && isset($_POST['cure_desc']) && isset($_POST['cure_availability']) && isset($_POST['cat_id']) && isset($_POST['price'])) {

  $imagedata = file_get_contents($_FILES['image']['tmp_name']);

        $cure_name = $_POST['cure_name'];
        $injection_site = $_POST['injection_site'];
        $injection_timing = $_POST['injection_timing'];
        $num_injections = $_POST['num_injections'];
        $special_reqs = $_POST['special_reqs'];
        $cure_desc = $_POST['cure_desc'];
        $cure_availability = $_POST['cure_availability'];
        $cat_id = $_POST['cat_id'];
        $price = $_POST['price'];

        $null = NULL;
        // include database connection
        include 'dbConnection.php';

        $stmt = $connection->prepare("INSERT INTO Cure (cure_name, injection_site, injection_timing, num_injections, special_reqs, cure_desc, cure_availability, cat_id, price, cure_image) VALUES (?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param( "sssissiidb", $cure_name,$injection_site,$injection_timing,$num_injections,$special_reqs,$cure_desc, $cure_availability,$cat_id, $price, $null);
        mysqli_stmt_send_long_data($stmt, 9, $imagedata);
        $stmt->execute();
        $stmt->store_result();
        $rows = $stmt->num_rows;



        header("Location: account.php");

}

?>
