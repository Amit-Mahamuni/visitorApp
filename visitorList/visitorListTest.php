<?php
    include "config.php";    
?>


<nav class="navbar navbar-light bg-light">
    <button type="button" class="btn btn-primary btn-sm">
        Total Visitor : <span class="badge badge-light">
            <?php
                $sql = "SELECT * FROM `visitor_info` WHERE `Visibility` = 'visible' ORDER BY `V_Id` DESC";
                $result = $con -> query($sql);

                // $totalVisitor = "SELECT COUNT(Id) FROM `visitor_info`";
                // $result_count = $con -> query($totalVisitor);

                $rowcount = mysqli_num_rows($result);
                if($rowcount > 0){
                    echo $rowcount;
                }else{
                    echo "No Record Found";
                }
            ?>
        </span>
    </button>
    <form class="form-inline">
        <input class="form-control mr-sm-2" id="visitor_search" type="text" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
</nav>


<table class="table table-bordered table-hover">
    <thead>
        <tr>
        <th width="5%">Id</th>
        <th width="15%">profile</th>
        <th width="25%">Name</th>
        <th width="15%">Contact</th>
        <th width="15%">Address</th>
        <th width="15%">Refernce</th>
        <th width="10%">Action</th>
        </tr>
    </thead>
    <tbody id="visitor_table_body">
    <?php
            // $sql = "SELECT * FROM `visitor_info`";
            // $result = $con -> query($sql);

            if($result->num_rows>0)
            {
                $i = 1;  

                while($row=$result->fetch_assoc())
                {
                    // <img src="{$row['Visitor_Profile']}" id="visitor_profile" name="visitor_profile" width="30%" height="auto">
                    
                    echo "<tr>";
                    echo "<th scope='row'>$i</th>";
                    echo "<td><img src='../image/Visitor_Profile/{$row['Visitor_Profile']}' class='img-thumbnail rounded mx-auto d-block'></td>";
                    // echo "<td><img src='../image/Visitor_Profile/{$row['Visitor_Profile']}' id='visitor_profile' name='visitor_profile' width='100px' height='auto'></td>";
                    echo "<td>{$row['Name']}</td>";
                    echo "<td>+91 {$row['Phone']}<br>{$row['Email']}</td>";
                    echo "<td>{$row['Address']}, {$row['City']}, {$row['Pincode']}</td>";
                    echo "<td>{$row['R_Name']} <br> +91 {$row['R_Phone']}</td>";       
                    echo "<td><button type='button' class='btn btn-primary btn-sm edit' data-id='{$row['V_Id']}'><i class='fa fa-pencil' aria-hidden='true'></i></button>";
                    echo "<button type='button' class='btn btn-danger btn-sm ml-2 remove' data-id='{$row['V_Id']}'><i class='fa fa-trash' aria-hidden='true'></button>";
                    echo "</td>";
                    echo "</tr>";

                    $i++;

                }

            }

            else{
                echo "No Data Found";
            }
        
    ?>

    </tbody>
    </table>
                  

    
