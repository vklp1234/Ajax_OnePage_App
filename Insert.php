<?php
include "db_connect.php";
extract($_POST);
if(isset($_POST['tempshowdata'])){
    $status = '1';
    $Query="SELECT * FROM `ajaxrecord` where `status` ='$status' ";
    $run =mysqli_query($con,$Query);
    $data ='<table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">S.No</th>
                <th scope="col">Name</th>
                <th scope="col">UserName</th>
                <th scope="col">Email</th>
                <th scope="col">Edit Mode</th>
                <th scope="col">Delete Mode</th>
            </tr>
            </thead>
            <tbody>';
    if(mysqli_num_rows($run)>0)
    {
        $num=0;
        while($fetch = mysqli_fetch_array($run))
        {
            $num++;
            $data .='<tr>
                    <th scope="row">'.$num.'</th>
                    <td>'.$fetch['name'].'</td>
                    <td>'.$fetch['username'].'</td>
                    <td>'.$fetch['email'].'</td>
                    <td><button onclick="edituser('.$fetch['id'].')" class="btn btn-warning">Edit</button>
                    <td><button onclick="Deleteuser('.$fetch['id'].')" class="btn btn-danger">Delete</button>
                    </tr>';

        }
    }
    $data .='</tbody>
        </table>';
        echo $data;

}
if(isset($_POST['deleteid']))
{
    $Query = "UPDATE `ajaxrecord` SET `status`='2' WHERE `id`='$deleteid'";
    if(!$run = mysqli_query($con,$Query))
    {
        echo '<script>alert("Something Went Wrong");</script>';
    }
}


if(isset($_POST['name']) && isset($_POST['username']) && isset($_POST['email']) && isset($_POST['pwd']))
{
    $query = "INSERT INTO `ajaxrecord`(`name`, `username`, `email`, `password`) VALUES ('$name','$username','$email','$pwd')";
    if(!$run = mysqli_query($con,$query))
    {
        echo '<script>alert("Not Inserted");</script>';
    }

}
if(isset($_POST['updateid']) && isset($_POST['updateid'])!='')
{
    $query="SELECT * FROM `ajaxrecord` where `id`='$updateid'";
    if(!$run = mysqli_query($con,$query))
    {
            exit(mysqli_error());
    }
    $response = array();
    if(mysqli_num_rows($run)>0){
        while($row = mysqli_fetch_assoc($run))
        {
            $response = $row;
        }

    }else{
        $response['status']=200;
        $response['message']="data not found";
    }
    echo json_encode($response);
}else{
    $response['status']=200;
    $response['message']="Invelide request";
}



if(isset($_POST['upadate_hidden']) && isset($_POST['upadate_hidden'])!='' )
{
    $U_id = $_POST['upadate_hidden'];
    $u_name=$_POST['upadate_name'];
    $u_username = $_POST['upadate_username'];
    $u_email = $_POST['upadate_email'];
    $u_pwd = $_POST['upadate_pwd'];
    $query="UPDATE `ajaxrecord` SET `name`=' $u_name',`username`='$u_username',`email`='$u_email',`password`='$u_pwd' WHERE `id`='$U_id'";
    echo $query;
    if(!$run = mysqli_query($con,$query))
    {
        exit(mysqli_error());
    }
    else{
        echo '<script>alert("Successfully");</script>';
    }
}


?>
